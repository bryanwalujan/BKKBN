<?php

namespace App\Http\Controllers;

use App\Models\PendingGenting;
use App\Models\Genting;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanGentingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kecamatan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $search = $request->query('search');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingGenting
        $pendingQuery = PendingGenting::with(['kartuKeluarga', 'createdBy'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })
            ->where('status', 'pending');

        if ($search) {
            $pendingQuery->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $pendingGentings = $pendingQuery->get()->map(function ($genting) {
            $genting->source = 'pending';
            return $genting;
        });

        // Query untuk Genting (terverifikasi)
        $verifiedQuery = Genting::with('kartuKeluarga')
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            });

        if ($search) {
            $verifiedQuery->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $verifiedGentings = $verifiedQuery->get()->map(function ($genting) {
            $genting->source = 'verified';
            return $genting;
        });

        // Gabungkan data untuk tab yang dipilih
        $gentings = $tab === 'verified' ? $verifiedGentings : $pendingGentings;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $gentings->count();
        $paginatedGentings = $gentings->slice($offset, $perPage);
        $gentings = new LengthAwarePaginator($paginatedGentings, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.genting.index', compact('gentings', 'search', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.genting.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingGenting = PendingGenting::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('status', 'pending')->findOrFail($id);

            // Pindahkan dokumentasi ke direktori terverifikasi jika ada
            $dokumentasiPath = $pendingGenting->dokumentasi;
            if ($dokumentasiPath && Storage::disk('public')->exists($dokumentasiPath)) {
                $newDokumentasiPath = str_replace('pending_genting_dokumentasi', 'genting_dokumentasi', $dokumentasiPath);
                Storage::disk('public')->move($dokumentasiPath, $newDokumentasiPath);
                $dokumentasiPath = $newDokumentasiPath;
            }

            // Simpan atau perbarui data ke Genting
            Genting::updateOrCreate(
                ['id' => $pendingGenting->original_genting_id],
                [
                    'kartu_keluarga_id' => $pendingGenting->kartu_keluarga_id,
                    'nama_kegiatan' => $pendingGenting->nama_kegiatan,
                    'tanggal' => $pendingGenting->tanggal,
                    'lokasi' => $pendingGenting->lokasi,
                    'sasaran' => $pendingGenting->sasaran,
                    'jenis_intervensi' => $pendingGenting->jenis_intervensi,
                    'narasi' => $pendingGenting->narasi,
                    'dokumentasi' => $dokumentasiPath,
                    'dunia_usaha' => $pendingGenting->dunia_usaha,
                    'dunia_usaha_frekuensi' => $pendingGenting->dunia_usaha_frekuensi,
                    'pemerintah' => $pendingGenting->pemerintah,
                    'pemerintah_frekuensi' => $pendingGenting->pemerintah_frekuensi,
                    'bumn_bumd' => $pendingGenting->bumn_bumd,
                    'bumn_bumd_frekuensi' => $pendingGenting->bumn_bumd_frekuensi,
                    'individu_perseorangan' => $pendingGenting->individu_perseorangan,
                    'individu_perseorangan_frekuensi' => $pendingGenting->individu_perseorangan_frekuensi,
                    'lsm_komunitas' => $pendingGenting->lsm_komunitas,
                    'lsm_komunitas_frekuensi' => $pendingGenting->lsm_komunitas_frekuensi,
                    'swasta' => $pendingGenting->swasta,
                    'swasta_frekuensi' => $pendingGenting->swasta_frekuensi,
                    'perguruan_tinggi_akademisi' => $pendingGenting->perguruan_tinggi_akademisi,
                    'perguruan_tinggi_akademisi_frekuensi' => $pendingGenting->perguruan_tinggi_akademisi_frekuensi,
                    'media' => $pendingGenting->media,
                    'media_frekuensi' => $pendingGenting->media_frekuensi,
                    'tim_pendamping_keluarga' => $pendingGenting->tim_pendamping_keluarga,
                    'tim_pendamping_keluarga_frekuensi' => $pendingGenting->tim_pendamping_keluarga_frekuensi,
                    'tokoh_masyarakat' => $pendingGenting->tokoh_masyarakat,
                    'tokoh_masyarakat_frekuensi' => $pendingGenting->tokoh_masyarakat_frekuensi,
                ]
            );

            // Tandai sebagai approved dan hapus dari pending
            $pendingGenting->update(['status' => 'approved']);
            $pendingGenting->delete();

            Log::info('Data genting disetujui', ['id' => $id]);
            return redirect()->route('kecamatan.genting.index')->with('success', 'Data kegiatan genting berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data genting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.genting.index')->with('error', 'Gagal menyetujui data genting: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.genting.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingGenting = PendingGenting::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('status', 'pending')->findOrFail($id);

            // Hapus dokumentasi jika ada
            if ($pendingGenting->dokumentasi && Storage::disk('public')->exists($pendingGenting->dokumentasi)) {
                Storage::disk('public')->delete($pendingGenting->dokumentasi);
            }

            // Tandai sebagai rejected dan simpan catatan
            $pendingGenting->update([
                'status' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingGenting->delete();

            Log::info('Data genting ditolak', ['id' => $id, 'catatan' => $request->catatan]);
            return redirect()->route('kecamatan.genting.index')->with('success', 'Data kegiatan genting ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data genting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.genting.index')->with('error', 'Gagal menolak data genting: ' . $e->getMessage());
        }
    }
}