<?php

namespace App\Http\Controllers;

use App\Models\PendingKartuKeluarga;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanKartuKeluargaController extends Controller
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

        // Query untuk PendingKartuKeluarga
        $pendingQuery = PendingKartuKeluarga::with(['kecamatan', 'kelurahan', 'createdBy'])
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status_verifikasi', 'pending');

        if ($search) {
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $pendingKartuKeluargas = $pendingQuery->get()->map(function ($kk) {
            $kk->source = 'pending';
            return $kk;
        });

        // Query untuk KartuKeluarga (terverifikasi)
        $verifiedQuery = KartuKeluarga::with(['kecamatan', 'kelurahan'])
            ->where('kecamatan_id', $kecamatan_id);

        if ($search) {
            $verifiedQuery->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $verifiedKartuKeluargas = $verifiedQuery->get()->map(function ($kk) {
            $kk->source = 'verified';
            $kk->createdBy = $kk->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $kk;
        });

        // Gabungkan data untuk tab yang dipilih
        $kartuKeluargas = $tab === 'verified' ? $verifiedKartuKeluargas : $pendingKartuKeluargas;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $kartuKeluargas->count();
        $paginatedKartuKeluargas = $kartuKeluargas->slice($offset, $perPage);
        $kartuKeluargas = new LengthAwarePaginator($paginatedKartuKeluargas, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.kartu_keluarga.index', compact('kartuKeluargas', 'search', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.kartu_keluarga.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingKartuKeluarga = PendingKartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
                ->where('status_verifikasi', 'pending')
                ->findOrFail($id);

            $data = [
                'no_kk' => $pendingKartuKeluarga->no_kk,
                'kepala_keluarga' => $pendingKartuKeluarga->kepala_keluarga,
                'alamat' => $pendingKartuKeluarga->alamat,
                'latitude' => $pendingKartuKeluarga->latitude,
                'longitude' => $pendingKartuKeluarga->longitude,
                'kecamatan_id' => $pendingKartuKeluarga->kecamatan_id,
                'kelurahan_id' => $pendingKartuKeluarga->kelurahan_id,
                'status' => $pendingKartuKeluarga->status,
                'created_by' => $pendingKartuKeluarga->created_by,
            ];

            if ($pendingKartuKeluarga->original_kartu_keluarga_id) {
                // Update data di kartu_keluargas jika original_kartu_keluarga_id ada
                $existingKartuKeluarga = KartuKeluarga::findOrFail($pendingKartuKeluarga->original_kartu_keluarga_id);
                $existingKartuKeluarga->update($data);
                Log::info('Memperbarui data kartu keluarga di kartu_keluargas', ['id' => $existingKartuKeluarga->id, 'data' => $data]);
            } else {
                // Buat baru jika tidak ada original_kartu_keluarga_id
                $existingKartuKeluarga = KartuKeluarga::where('no_kk', $pendingKartuKeluarga->no_kk)->first();
                if ($existingKartuKeluarga) {
                    $existingKartuKeluarga->update($data);
                    Log::info('Memperbarui data kartu keluarga di kartu_keluargas', ['id' => $existingKartuKeluarga->id, 'data' => $data]);
                } else {
                    KartuKeluarga::create($data);
                    Log::info('Menyimpan data kartu keluarga baru ke kartu_keluargas', ['data' => $data]);
                }
            }

            // Tandai sebagai approved dan hapus dari pending
            $pendingKartuKeluarga->update(['status_verifikasi' => 'approved']);
            $pendingKartuKeluarga->delete();

            return redirect()->route('kecamatan.kartu_keluarga.index')->with('success', 'Data kartu keluarga berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data kartu keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.kartu_keluarga.index')->with('error', 'Gagal menyetujui data kartu keluarga: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.kartu_keluarga.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingKartuKeluarga = PendingKartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
                ->where('status_verifikasi', 'pending')
                ->findOrFail($id);

            $pendingKartuKeluarga->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingKartuKeluarga->delete();

            Log::info('Data kartu keluarga ditolak', ['id' => $id, 'catatan' => $request->catatan]);

            return redirect()->route('kecamatan.kartu_keluarga.index')->with('success', 'Data kartu keluarga ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data kartu keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.kartu_keluarga.index')->with('error', 'Gagal menolak data kartu keluarga: ' . $e->getMessage());
        }
    }
}