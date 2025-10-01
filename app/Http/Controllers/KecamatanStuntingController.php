<?php

namespace App\Http\Controllers;

use App\Models\PendingStunting;
use App\Models\Stunting;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanStuntingController extends Controller
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
        $kategoriUmur = $request->query('kategori_umur');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingStunting
        $pendingQuery = PendingStunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status', 'pending');

        if ($search) {
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $pendingStuntings = $pendingQuery->get()->map(function ($stunting) {
            $stunting->source = 'pending';
            return $stunting;
        });

        // Query untuk Stunting (terverifikasi)
        $verifiedQuery = Stunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kecamatan_id', $kecamatan_id);

        if ($search) {
            $verifiedQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $verifiedStuntings = $verifiedQuery->get()->map(function ($stunting) {
            $stunting->source = 'verified';
            $stunting->createdBy = $stunting->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $stunting;
        });

        // Filter berdasarkan kategori umur
        if ($kategoriUmur && in_array($kategoriUmur, ['Baduata', 'Balita'])) {
            $pendingStuntings = $pendingStuntings->filter(function ($stunting) use ($kategoriUmur) {
                return $stunting->kategori_umur === $kategoriUmur;
            });
            $verifiedStuntings = $verifiedStuntings->filter(function ($stunting) use ($kategoriUmur) {
                return $stunting->kategori_umur === $kategoriUmur;
            });
        }

        // Gabungkan data untuk tab yang dipilih
        $stuntings = $tab === 'verified' ? $verifiedStuntings : $pendingStuntings;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $stuntings->count();
        $paginatedStuntings = $stuntings->slice($offset, $perPage);
        $stuntings = new LengthAwarePaginator($paginatedStuntings, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.stunting.index', compact('stuntings', 'kategoriUmur', 'search', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.stunting.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingStunting = PendingStunting::where('kecamatan_id', $user->kecamatan_id)
                ->where('status', 'pending')
                ->findOrFail($id);

            // Pindahkan foto ke direktori terverifikasi jika ada
            $fotoPath = $pendingStunting->foto;
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                $newFotoPath = str_replace('pending_stunting_fotos', 'stunting_fotos', $fotoPath);
                Storage::disk('public')->move($fotoPath, $newFotoPath);
                $fotoPath = $newFotoPath;
            }

            // Simpan atau perbarui data ke Stunting
            Stunting::updateOrCreate(
                ['id' => $pendingStunting->original_stunting_id],
                [
                    'kartu_keluarga_id' => $pendingStunting->kartu_keluarga_id,
                    'nik' => $pendingStunting->nik,
                    'nama' => $pendingStunting->nama,
                    'tanggal_lahir' => $pendingStunting->tanggal_lahir,
                    'kategori_umur' => $pendingStunting->kategori_umur,
                    'jenis_kelamin' => $pendingStunting->jenis_kelamin,
                    'berat_tinggi' => $pendingStunting->berat_tinggi,
                    'status_gizi' => $pendingStunting->status_gizi,
                    'warna_gizi' => $pendingStunting->warna_gizi,
                    'tindak_lanjut' => $pendingStunting->tindak_lanjut,
                    'warna_tindak_lanjut' => $pendingStunting->warna_tindak_lanjut,
                    'foto' => $fotoPath,
                    'kecamatan_id' => $pendingStunting->kecamatan_id,
                    'kelurahan_id' => $pendingStunting->kelurahan_id,
                    'created_by' => $pendingStunting->created_by,
                ]
            );

            // Tandai sebagai approved dan hapus dari pending
            $pendingStunting->update(['status' => 'approved']);
            $pendingStunting->delete();

            Log::info('Data stunting disetujui', ['id' => $id]);
            return redirect()->route('kecamatan.stunting.index')->with('success', 'Data stunting berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data stunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.stunting.index')->with('error', 'Gagal menyetujui data stunting: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.stunting.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingStunting = PendingStunting::where('kecamatan_id', $user->kecamatan_id)
                ->where('status', 'pending')
                ->findOrFail($id);

            // Hapus foto jika ada
            if ($pendingStunting->foto && Storage::disk('public')->exists($pendingStunting->foto)) {
                Storage::disk('public')->delete($pendingStunting->foto);
            }

            // Tandai sebagai rejected dan simpan catatan
            $pendingStunting->update([
                'status' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingStunting->delete();

            Log::info('Data stunting ditolak', ['id' => $id, 'catatan' => $request->catatan]);
            return redirect()->route('kecamatan.stunting.index')->with('success', 'Data stunting ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data stunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.stunting.index')->with('error', 'Gagal menolak data stunting: ' . $e->getMessage());
        }
    }
}