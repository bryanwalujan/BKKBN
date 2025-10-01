<?php

namespace App\Http\Controllers;

use App\Models\PendingAksiKonvergensi;
use App\Models\AksiKonvergensi;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanAksiKonvergensiController extends Controller
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

        // Query untuk PendingAksiKonvergensi
        $pendingQuery = PendingAksiKonvergensi::with(['kartuKeluarga', 'kelurahan', 'createdBy'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })
            ->where('status', 'pending');

        if ($search) {
            $pendingQuery->where('nama_aksi', 'like', '%' . $search . '%');
        }

        $pendingAksiKonvergensis = $pendingQuery->get()->map(function ($aksi) {
            $aksi->source = 'pending';
            return $aksi;
        });

        // Query untuk AksiKonvergensi (terverifikasi)
        $verifiedQuery = AksiKonvergensi::with(['kartuKeluarga', 'kelurahan'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            });

        if ($search) {
            $verifiedQuery->where('nama_aksi', 'like', '%' . $search . '%');
        }

        $verifiedAksiKonvergensis = $verifiedQuery->get()->map(function ($aksi) {
            $aksi->source = 'verified';
            return $aksi;
        });

        // Gabungkan data untuk tab yang dipilih
        $aksiKonvergensis = $tab === 'verified' ? $verifiedAksiKonvergensis : $pendingAksiKonvergensis;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $aksiKonvergensis->count();
        $paginatedAksiKonvergensis = $aksiKonvergensis->slice($offset, $perPage);
        $aksiKonvergensis = new LengthAwarePaginator($paginatedAksiKonvergensis, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.aksi_konvergensi.index', compact('aksiKonvergensis', 'search', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.aksi_konvergensi.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingAksiKonvergensi = PendingAksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('status', 'pending')->findOrFail($id);

            // Pindahkan foto ke direktori terverifikasi jika ada
            $fotoPath = $pendingAksiKonvergensi->foto;
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                $newFotoPath = str_replace('pending_aksi_konvergensi_fotos', 'aksi_konvergensi_fotos', $fotoPath);
                Storage::disk('public')->move($fotoPath, $newFotoPath);
                $fotoPath = $newFotoPath;
            }

            // Simpan atau perbarui data ke AksiKonvergensi
            AksiKonvergensi::updateOrCreate(
                ['id' => $pendingAksiKonvergensi->original_aksi_konvergensi_id],
                [
                    'kartu_keluarga_id' => $pendingAksiKonvergensi->kartu_keluarga_id,
                    'kelurahan_id' => $pendingAksiKonvergensi->kelurahan_id,
                    'kecamatan_id' => $user->kecamatan_id,
                    'nama_aksi' => $pendingAksiKonvergensi->nama_aksi,
                    'selesai' => $pendingAksiKonvergensi->selesai,
                    'tahun' => $pendingAksiKonvergensi->tahun,
                    'foto' => $fotoPath,
                    'air_bersih_sanitasi' => $pendingAksiKonvergensi->air_bersih_sanitasi,
                    'akses_layanan_kesehatan_kb' => $pendingAksiKonvergensi->akses_layanan_kesehatan_kb,
                    'pendidikan_pengasuhan_ortu' => $pendingAksiKonvergensi->pendidikan_pengasuhan_ortu,
                    'edukasi_kesehatan_remaja' => $pendingAksiKonvergensi->edukasi_kesehatan_remaja,
                    'kesadaran_pengasuhan_gizi' => $pendingAksiKonvergensi->kesadaran_pengasuhan_gizi,
                    'akses_pangan_bergizi' => $pendingAksiKonvergensi->akses_pangan_bergizi,
                    'makanan_ibu_hamil' => $pendingAksiKonvergensi->makanan_ibu_hamil,
                    'tablet_tambah_darah' => $pendingAksiKonvergensi->tablet_tambah_darah,
                    'inisiasi_menyusui_dini' => $pendingAksiKonvergensi->inisiasi_menyusui_dini,
                    'asi_eksklusif' => $pendingAksiKonvergensi->asi_eksklusif,
                    'asi_mpasi' => $pendingAksiKonvergensi->asi_mpasi,
                    'imunisasi_lengkap' => $pendingAksiKonvergensi->imunisasi_lengkap,
                    'pencegahan_infeksi' => $pendingAksiKonvergensi->pencegahan_infeksi,
                    'status_gizi_ibu' => $pendingAksiKonvergensi->status_gizi_ibu,
                    'penyakit_menular' => $pendingAksiKonvergensi->penyakit_menular,
                    'jenis_penyakit' => $pendingAksiKonvergensi->jenis_penyakit,
                    'kesehatan_lingkungan' => $pendingAksiKonvergensi->kesehatan_lingkungan,
                    'narasi' => $pendingAksiKonvergensi->narasi,
                    'pelaku_aksi' => $pendingAksiKonvergensi->pelaku_aksi,
                    'waktu_pelaksanaan' => $pendingAksiKonvergensi->waktu_pelaksanaan,
                ]
            );

            // Tandai sebagai approved dan hapus dari pending
            $pendingAksiKonvergensi->update(['status' => 'approved']);
            $pendingAksiKonvergensi->delete();

            Log::info('Data aksi konvergensi disetujui', ['id' => $id]);
            return redirect()->route('kecamatan.aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data aksi konvergensi: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.aksi_konvergensi.index')->with('error', 'Gagal menyetujui data aksi konvergensi: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.aksi_konvergensi.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingAksiKonvergensi = PendingAksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('status', 'pending')->findOrFail($id);

            // Hapus foto jika ada
            if ($pendingAksiKonvergensi->foto && Storage::disk('public')->exists($pendingAksiKonvergensi->foto)) {
                Storage::disk('public')->delete($pendingAksiKonvergensi->foto);
            }

            // Tandai sebagai rejected dan simpan catatan
            $pendingAksiKonvergensi->update([
                'status' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingAksiKonvergensi->delete();

            Log::info('Data aksi konvergensi ditolak', ['id' => $id, 'catatan' => $request->catatan]);
            return redirect()->route('kecamatan.aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data aksi konvergensi: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.aksi_konvergensi.index')->with('error', 'Gagal menolak data aksi konvergensi: ' . $e->getMessage());
        }
    }
}