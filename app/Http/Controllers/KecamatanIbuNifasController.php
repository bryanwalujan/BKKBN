<?php

namespace App\Http\Controllers;

use App\Models\PendingIbuNifas;
use App\Models\IbuNifas;
use App\Models\PendingIbu;
use App\Models\Ibu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanIbuNifasController extends Controller
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

        // Query untuk PendingIbuNifas
        $pendingQuery = PendingIbuNifas::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan'])
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
            $pendingQuery->where('kondisi_kesehatan', $category);
        }

        $pendingIbuNifas = $pendingQuery->get()->map(function ($ibuNifas) {
            $ibuNifas->source = 'pending';
            return $ibuNifas;
        });

        // Query untuk IbuNifas (terverifikasi)
        $verifiedQuery = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
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
            $verifiedQuery->where('kondisi_kesehatan', $category);
        }

        $verifiedIbuNifas = $verifiedQuery->get()->map(function ($ibuNifas) {
            $ibuNifas->source = 'verified';
            $ibuNifas->pendingIbu = $ibuNifas->ibu; // Untuk keseragaman view
            return $ibuNifas;
        });

        // Gabungkan data untuk tab yang dipilih
        $ibuNifas = $tab === 'verified' ? $verifiedIbuNifas : $pendingIbuNifas;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $ibuNifas->count();
        $paginatedIbuNifas = $ibuNifas->slice($offset, $perPage);
        $ibuNifas = new LengthAwarePaginator($paginatedIbuNifas, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.ibu_nifas.index', compact('ibuNifas', 'search', 'category', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu_nifas.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingIbuNifas = PendingIbuNifas::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            })->where('status_verifikasi', 'pending')->findOrFail($id);

            $pendingIbu = $pendingIbuNifas->pendingIbu;
            if (!$pendingIbu) {
                return redirect()->route('kecamatan.ibu_nifas.index')->with('error', 'Data ibu terkait tidak ditemukan.');
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
                    'status' => 'Nifas',
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
                    'status' => 'Nifas',
                    'foto' => $pendingIbu->foto,
                    'created_by' => $pendingIbu->created_by,
                ]);
                Log::info('Memperbarui data ibu di ibus', ['ibu_id' => $ibu->id]);
            }

            IbuNifas::updateOrCreate(
                ['ibu_id' => $ibu->id],
                [
                    'hari_nifas' => $pendingIbuNifas->hari_nifas,
                    'kondisi_kesehatan' => $pendingIbuNifas->kondisi_kesehatan,
                    'warna_kondisi' => $pendingIbuNifas->warna_kondisi,
                    'berat' => $pendingIbuNifas->berat,
                    'tinggi' => $pendingIbuNifas->tinggi,
                    'created_by' => $pendingIbuNifas->created_by,
                ]
            );

            $pendingIbuNifas->update(['status_verifikasi' => 'approved']);
            $pendingIbuNifas->delete();
            $pendingIbu->delete();

            return redirect()->route('kecamatan.ibu_nifas.index')->with('success', 'Data ibu nifas berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data ibu nifas: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu_nifas.index')->with('error', 'Gagal menyetujui data ibu nifas: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu_nifas.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingIbuNifas = PendingIbuNifas::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            })->where('status_verifikasi', 'pending')->findOrFail($id);

            $pendingIbuNifas->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingIbuNifas->delete();

            Log::info('Data ibu nifas ditolak', ['id' => $id, 'catatan' => $request->catatan]);

            return redirect()->route('kecamatan.ibu_nifas.index')->with('success', 'Data ibu nifas ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data ibu nifas: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu_nifas.index')->with('error', 'Gagal menolak data ibu nifas: ' . $e->getMessage());
        }
    }
}