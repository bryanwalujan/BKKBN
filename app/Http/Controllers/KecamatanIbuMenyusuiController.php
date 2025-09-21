<?php

namespace App\Http\Controllers;

use App\Models\PendingIbuMenyusui;
use App\Models\IbuMenyusui;
use App\Models\PendingIbu;
use App\Models\Ibu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanIbuMenyusuiController extends Controller
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

        // Query untuk PendingIbuMenyusui
        $pendingQuery = PendingIbuMenyusui::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan'])
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
            $pendingQuery->where('status_menyusui', $category);
        }

        $pendingIbuMenyusuis = $pendingQuery->get()->map(function ($ibuMenyusui) {
            $ibuMenyusui->source = 'pending';
            return $ibuMenyusui;
        });

        // Query untuk IbuMenyusui (terverifikasi)
        $verifiedQuery = IbuMenyusui::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
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
            $verifiedQuery->where('status_menyusui', $category);
        }

        $verifiedIbuMenyusuis = $verifiedQuery->get()->map(function ($ibuMenyusui) {
            $ibuMenyusui->source = 'verified';
            $ibuMenyusui->pendingIbu = $ibuMenyusui->ibu; // Untuk keseragaman view
            return $ibuMenyusui;
        });

        // Gabungkan data untuk tab yang dipilih
        $ibuMenyusuis = $tab === 'verified' ? $verifiedIbuMenyusuis : $pendingIbuMenyusuis;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $ibuMenyusuis->count();
        $paginatedIbuMenyusuis = $ibuMenyusuis->slice($offset, $perPage);
        $ibuMenyusuis = new LengthAwarePaginator($paginatedIbuMenyusuis, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.ibu_menyusui.index', compact('ibuMenyusuis', 'search', 'category', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu_menyusui.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingIbuMenyusui = PendingIbuMenyusui::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            })->where('status_verifikasi', 'pending')->findOrFail($id);

            $pendingIbu = $pendingIbuMenyusui->pendingIbu;
            if (!$pendingIbu) {
                return redirect()->route('kecamatan.ibu_menyusui.index')->with('error', 'Data ibu terkait tidak ditemukan.');
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
                    'status' => 'Menyusui',
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
                    'status' => 'Menyusui',
                    'foto' => $pendingIbu->foto,
                    'created_by' => $pendingIbu->created_by,
                ]);
                Log::info('Memperbarui data ibu di ibus', ['ibu_id' => $ibu->id]);
            }

            IbuMenyusui::updateOrCreate(
                ['ibu_id' => $ibu->id],
                [
                    'status_menyusui' => $pendingIbuMenyusui->status_menyusui,
                    'frekuensi_menyusui' => $pendingIbuMenyusui->frekuensi_menyusui,
                    'kondisi_ibu' => $pendingIbuMenyusui->kondisi_ibu,
                    'warna_kondisi' => $pendingIbuMenyusui->warna_kondisi,
                    'berat' => $pendingIbuMenyusui->berat,
                    'tinggi' => $pendingIbuMenyusui->tinggi,
                    'created_by' => $pendingIbuMenyusui->created_by,
                ]
            );

            $pendingIbuMenyusui->update(['status_verifikasi' => 'approved']);
            $pendingIbuMenyusui->delete();
            $pendingIbu->delete();

            return redirect()->route('kecamatan.ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data ibu menyusui: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu_menyusui.index')->with('error', 'Gagal menyetujui data ibu menyusui: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu_menyusui.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingIbuMenyusui = PendingIbuMenyusui::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kecamatan_id', $user->kecamatan_id);
            })->where('status_verifikasi', 'pending')->findOrFail($id);

            $pendingIbuMenyusui->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingIbuMenyusui->delete();

            Log::info('Data ibu menyusui ditolak', ['id' => $id, 'catatan' => $request->catatan]);

            return redirect()->route('kecamatan.ibu_menyusui.index')->with('success', 'Data ibu menyusui ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data ibu menyusui: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu_menyusui.index')->with('error', 'Gagal menolak data ibu menyusui: ' . $e->getMessage());
        }
    }
}