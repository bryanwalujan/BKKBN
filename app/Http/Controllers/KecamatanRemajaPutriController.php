<?php

namespace App\Http\Controllers;

use App\Models\PendingRemajaPutri;
use App\Models\RemajaPutri;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanRemajaPutriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kecamatan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $kecamatan_id = $user->kecamatan_id;

        if (!$kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $search = $request->query('search');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingRemajaPutri
        $pendingQuery = PendingRemajaPutri::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status', 'pending');

        if ($search) {
            $pendingQuery->where('nama', 'like', '%' . $search . '%');
        }

        $pendingRemajaPutris = $pendingQuery->get()->map(function ($remaja) {
            $remaja->source = 'pending';
            return $remaja;
        });

        // Query untuk RemajaPutri (terverifikasi)
        $verifiedQuery = RemajaPutri::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kecamatan_id', $kecamatan_id);

        if ($search) {
            $verifiedQuery->where('nama', 'like', '%' . $search . '%');
        }

        $verifiedRemajaPutris = $verifiedQuery->get()->map(function ($remaja) {
            $remaja->source = 'verified';
            $remaja->createdBy = $remaja->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $remaja;
        });

        // Gabungkan data untuk tab yang dipilih
        $remajaPutris = $tab === 'verified' ? $verifiedRemajaPutris : $pendingRemajaPutris;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $remajaPutris->count();
        $paginatedRemajaPutris = $remajaPutris->slice($offset, $perPage);
        $remajaPutris = new LengthAwarePaginator($paginatedRemajaPutris, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.remaja_putri.index', compact('remajaPutris', 'search', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.remaja_putri.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingRemajaPutri = PendingRemajaPutri::where('kecamatan_id', $user->kecamatan_id)
                ->where('status', 'pending')
                ->findOrFail($id);

            // Pindahkan foto ke direktori terverifikasi jika ada
            $fotoPath = $pendingRemajaPutri->foto;
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                $newFotoPath = str_replace('pending_remaja_putri_fotos', 'remaja_putri_fotos', $fotoPath);
                Storage::disk('public')->move($fotoPath, $newFotoPath);
                $fotoPath = $newFotoPath;
            }

            // Simpan atau perbarui data ke RemajaPutri
            RemajaPutri::updateOrCreate(
                ['id' => $pendingRemajaPutri->original_remaja_putri_id],
                [
                    'nama' => $pendingRemajaPutri->nama,
                    'kartu_keluarga_id' => $pendingRemajaPutri->kartu_keluarga_id,
                    'kecamatan_id' => $pendingRemajaPutri->kecamatan_id,
                    'kelurahan_id' => $pendingRemajaPutri->kelurahan_id,
                    'sekolah' => $pendingRemajaPutri->sekolah,
                    'kelas' => $pendingRemajaPutri->kelas,
                    'umur' => $pendingRemajaPutri->umur,
                    'status_anemia' => $pendingRemajaPutri->status_anemia,
                    'konsumsi_ttd' => $pendingRemajaPutri->konsumsi_ttd,
                    'foto' => $fotoPath,
                    'created_by' => $pendingRemajaPutri->created_by,
                ]
            );

            // Tandai sebagai approved dan hapus dari pending
            $pendingRemajaPutri->update(['status' => 'approved']);
            $pendingRemajaPutri->delete();

            Log::info('Data remaja putri disetujui', ['id' => $id]);
            return redirect()->route('kecamatan.remaja_putri.index')->with('success', 'Data remaja putri berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data remaja putri: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.remaja_putri.index')->with('error', 'Gagal menyetujui data remaja putri: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.remaja_putri.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingRemajaPutri = PendingRemajaPutri::where('kecamatan_id', $user->kecamatan_id)
                ->where('status', 'pending')
                ->findOrFail($id);

            // Hapus foto jika ada
            if ($pendingRemajaPutri->foto && Storage::disk('public')->exists($pendingRemajaPutri->foto)) {
                Storage::disk('public')->delete($pendingRemajaPutri->foto);
            }

            // Tandai sebagai rejected dan simpan catatan
            $pendingRemajaPutri->update([
                'status' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingRemajaPutri->delete();

            Log::info('Data remaja putri ditolak', ['id' => $id, 'catatan' => $request->catatan]);
            return redirect()->route('kecamatan.remaja_putri.index')->with('success', 'Data remaja putri ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data remaja putri: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.remaja_putri.index')->with('error', 'Gagal menolak data remaja putri: ' . $e->getMessage());
        }
    }
}