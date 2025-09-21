<?php

namespace App\Http\Controllers;

use App\Models\PendingIbuHamil;
use App\Models\IbuHamil;
use App\Models\PendingIbu;
use App\Models\Ibu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanIbuHamilController extends Controller
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
        $category = $request->query('category');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingIbuHamil
        $pendingQuery = PendingIbuHamil::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan'])
            ->whereHas('pendingIbu', function ($q) use ($kecamatan_id) {
                $q->where('kecamatan_id', $kecamatan_id);
            })
            ->where('status_verifikasi', 'pending');

        if ($search) {
            $pendingQuery->whereHas('pendingIbu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($category) {
            $pendingQuery->where('trimester', $category);
        }

        $pendingIbuHamils = $pendingQuery->get()->map(function ($ibuHamil) {
            $ibuHamil->source = 'pending';
            return $ibuHamil;
        });

        // Query untuk IbuHamil (terverifikasi)
        $verifiedQuery = IbuHamil::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
            ->whereHas('ibu', function ($q) use ($kecamatan_id) {
                $q->where('kecamatan_id', $kecamatan_id);
            });

        if ($search) {
            $verifiedQuery->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($category) {
            $verifiedQuery->where('trimester', $category);
        }

        $verifiedIbuHamils = $verifiedQuery->get()->map(function ($ibuHamil) {
            $ibuHamil->source = 'verified';
            $ibuHamil->pendingIbu = $ibuHamil->ibu; // Untuk keseragaman view
            return $ibuHamil;
        });

        // Gabungkan data untuk tab yang dipilih
        $ibuHamils = $tab === 'verified' ? $verifiedIbuHamils : $pendingIbuHamils;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $ibuHamils->count();
        $paginatedIbuHamils = $ibuHamils->slice($offset, $perPage);
        $ibuHamils = new LengthAwarePaginator($paginatedIbuHamils, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.ibu_hamil.index', compact('ibuHamils', 'search', 'category', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu_hamil.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingIbuHamil = PendingIbuHamil::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            })->where('status_verifikasi', 'pending')->findOrFail($id);

            $pendingIbu = $pendingIbuHamil->pendingIbu;
            if (!$pendingIbu) {
                return redirect()->route('kecamatan.ibu_hamil.index')->with('error', 'Data ibu terkait tidak ditemukan.');
            }

            $ibu = Ibu::where('id', $pendingIbu->original_ibu_id)->first() ?? Ibu::where('nik', $pendingIbu->nik)->first();
            if (!$ibu) {
                $ibu = Ibu::create([
                    'nik' => $pendingIbu->nik,
                    'nama' => $pendingIbu->nama,
                    'kecamatan_id' => $pendingIbu->kecamatan_id,
                    'kelurahan_id' => $pendingIbu->kelurahan_id,
                    'kartu_keluarga_id' => $pendingIbu->kartu_keluarga_id,
                    'alamat' => $pendingIbu->alamat,
                    'status' => 'Hamil',
                    'foto' => $pendingIbu->foto,
                    'created_by' => $pendingIbu->created_by,
                ]);
                Log::info('Menyimpan data ibu baru ke ibus', ['ibu_id' => $ibu->id]);
            } else {
                $ibu->update([
                    'nik' => $pendingIbu->nik,
                    'nama' => $pendingIbu->nama,
                    'kecamatan_id' => $pendingIbu->kecamatan_id,
                    'kelurahan_id' => $pendingIbu->kelurahan_id,
                    'kartu_keluarga_id' => $pendingIbu->kartu_keluarga_id,
                    'alamat' => $pendingIbu->alamat,
                    'status' => 'Hamil',
                    'foto' => $pendingIbu->foto,
                    'created_by' => $pendingIbu->created_by,
                ]);
                Log::info('Memperbarui data ibu di ibus', ['ibu_id' => $ibu->id]);
            }

            IbuHamil::updateOrCreate(
                ['ibu_id' => $ibu->id],
                [
                    'trimester' => $pendingIbuHamil->trimester,
                    'intervensi' => $pendingIbuHamil->intervensi,
                    'status_gizi' => $pendingIbuHamil->status_gizi,
                    'warna_status_gizi' => $pendingIbuHamil->warna_status_gizi,
                    'usia_kehamilan' => $pendingIbuHamil->usia_kehamilan,
                    'berat' => $pendingIbuHamil->berat,
                    'tinggi' => $pendingIbuHamil->tinggi,
                    'created_by' => $pendingIbuHamil->created_by,
                ]
            );

            $pendingIbuHamil->update(['status_verifikasi' => 'approved']);
            $pendingIbuHamil->delete();
            $pendingIbu->delete();

            return redirect()->route('kecamatan.ibu_hamil.index')->with('success', 'Data ibu hamil berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data ibu hamil: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu_hamil.index')->with('error', 'Gagal menyetujui data ibu hamil: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu_hamil.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingIbuHamil = PendingIbuHamil::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            })->where('status_verifikasi', 'pending')->findOrFail($id);

            $pendingIbuHamil->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingIbuHamil->delete();

            Log::info('Data ibu hamil ditolak', ['id' => $id, 'catatan' => $request->catatan]);

            return redirect()->route('kecamatan.ibu_hamil.index')->with('success', 'Data ibu hamil ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data ibu hamil: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu_hamil.index')->with('error', 'Gagal menolak data ibu hamil: ' . $e->getMessage());
        }
    }
}