<?php

namespace App\Http\Controllers;

use App\Models\PendingIbu;
use App\Models\PendingIbuHamil;
use App\Models\PendingIbuNifas;
use App\Models\PendingIbuMenyusui;
use App\Models\Ibu;
use App\Models\IbuHamil;
use App\Models\IbuNifas;
use App\Models\IbuMenyusui;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanIbuController extends Controller
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
        $status = $request->query('status');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingIbu
        $pendingQuery = PendingIbu::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status_verifikasi', 'pending');

        if ($search) {
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($status) {
            $pendingQuery->where('status', $status);
        }

        $pendingIbus = $pendingQuery->get()->map(function ($ibu) {
            $ibu->source = 'pending';
            return $ibu;
        });

        // Query untuk Ibu (terverifikasi)
        $verifiedQuery = Ibu::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kecamatan_id', $kecamatan_id);

        if ($search) {
            $verifiedQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($status) {
            $verifiedQuery->where('status', $status);
        }

        $verifiedIbus = $verifiedQuery->get()->map(function ($ibu) {
            $ibu->source = 'verified';
            $ibu->createdBy = $ibu->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $ibu;
        });

        // Gabungkan data untuk tab yang dipilih
        $ibus = $tab === 'verified' ? $verifiedIbus : $pendingIbus;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $ibus->count();
        $paginatedIbus = $ibus->slice($offset, $perPage);
        $ibus = new LengthAwarePaginator($paginatedIbus, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kecamatan.ibu.index', compact('ibus', 'search', 'status', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingIbu = PendingIbu::where('kecamatan_id', $user->kecamatan_id)
                ->where('status_verifikasi', 'pending')
                ->findOrFail($id);

            $data = [
                'nik' => $pendingIbu->nik,
                'nama' => $pendingIbu->nama,
                'kecamatan_id' => $pendingIbu->kecamatan_id,
                'kelurahan_id' => $pendingIbu->kelurahan_id,
                'kartu_keluarga_id' => $pendingIbu->kartu_keluarga_id,
                'alamat' => $pendingIbu->alamat,
                'status' => $pendingIbu->status,
                'foto' => $pendingIbu->foto,
                'created_by' => $pendingIbu->created_by,
            ];

            if ($pendingIbu->original_ibu_id) {
                // Update data di ibus jika original_ibu_id ada
                $existingIbu = Ibu::findOrFail($pendingIbu->original_ibu_id);
                $existingIbu->update($data);
                Log::info('Memperbarui data ibu di ibus', ['id' => $existingIbu->id, 'data' => $data]);
                $ibuId = $existingIbu->id;
            } else {
                // Buat baru jika tidak ada original_ibu_id
                $existingIbu = Ibu::where('nik', $pendingIbu->nik)->first();
                if ($existingIbu) {
                    $existingIbu->update($data);
                    Log::info('Memperbarui data ibu di ibus', ['id' => $existingIbu->id, 'data' => $data]);
                    $ibuId = $existingIbu->id;
                } else {
                    $ibu = Ibu::create($data);
                    Log::info('Menyimpan data ibu baru ke ibus', ['data' => $data]);
                    $ibuId = $ibu->id;
                }
            }

            // Pindahkan data terkait berdasarkan status
            if ($pendingIbu->status === 'Hamil') {
                if ($pendingIbu->pendingIbuHamil) {
                    IbuHamil::updateOrCreate(
                        ['ibu_id' => $ibuId],
                        [
                            'trimester' => $pendingIbu->pendingIbuHamil->trimester,
                            'intervensi' => $pendingIbu->pendingIbuHamil->intervensi,
                            'status_gizi' => $pendingIbu->pendingIbuHamil->status_gizi,
                            'warna_status_gizi' => $pendingIbu->pendingIbuHamil->warna_status_gizi,
                            'usia_kehamilan' => $pendingIbu->pendingIbuHamil->usia_kehamilan,
                            'berat' => $pendingIbu->pendingIbuHamil->berat,
                            'tinggi' => $pendingIbu->pendingIbuHamil->tinggi,
                            'created_by' => $pendingIbu->pendingIbuHamil->created_by,
                        ]
                    );
                    $pendingIbu->pendingIbuHamil->delete();
                }
            } elseif ($pendingIbu->status === 'Nifas') {
                if ($pendingIbu->pendingIbuNifas) {
                    IbuNifas::updateOrCreate(
                        ['ibu_id' => $ibuId],
                        [
                            'hari_nifas' => $pendingIbu->pendingIbuNifas->hari_nifas,
                            'kondisi_kesehatan' => $pendingIbu->pendingIbuNifas->kondisi_kesehatan,
                            'berat' => $pendingIbu->pendingIbuNifas->berat,
                            'tinggi' => $pendingIbu->pendingIbuNifas->tinggi,
                            'created_by' => $pendingIbu->pendingIbuNifas->created_by,
                        ]
                    );
                    $pendingIbu->pendingIbuNifas->delete();
                }
            } elseif ($pendingIbu->status === 'Menyusui') {
                if ($pendingIbu->pendingIbuMenyusui) {
                    IbuMenyusui::updateOrCreate(
                        ['ibu_id' => $ibuId],
                        [
                            'status_menyusui' => $pendingIbu->pendingIbuMenyusui->status_menyusui,
                            'frekuensi_menyusui' => $pendingIbu->pendingIbuMenyusui->frekuensi_menyusui,
                            'kondisi_ibu' => $pendingIbu->pendingIbuMenyusui->kondisi_ibu,
                            'warna_kondisi' => $pendingIbu->pendingIbuMenyusui->warna_kondisi,
                            'berat' => $pendingIbu->pendingIbuMenyusui->berat,
                            'tinggi' => $pendingIbu->pendingIbuMenyusui->tinggi,
                            'created_by' => $pendingIbu->pendingIbuMenyusui->created_by,
                        ]
                    );
                    $pendingIbu->pendingIbuMenyusui->delete();
                }
            }

            // Tandai sebagai approved dan hapus dari pending
            $pendingIbu->update(['status_verifikasi' => 'approved']);
            $pendingIbu->delete();

            return redirect()->route('kecamatan.ibu.index')->with('success', 'Data ibu berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data ibu: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu.index')->with('error', 'Gagal menyetujui data ibu: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.ibu.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingIbu = PendingIbu::where('kecamatan_id', $user->kecamatan_id)
                ->where('status_verifikasi', 'pending')
                ->findOrFail($id);

            if ($pendingIbu->foto && Storage::disk('public')->exists($pendingIbu->foto)) {
                Storage::disk('public')->delete($pendingIbu->foto);
            }

            // Hapus data terkait
            if ($pendingIbu->pendingIbuHamil) {
                $pendingIbu->pendingIbuHamil->delete();
            }
            if ($pendingIbu->pendingIbuNifas) {
                $pendingIbu->pendingIbuNifas->delete();
            }
            if ($pendingIbu->pendingIbuMenyusui) {
                $pendingIbu->pendingIbuMenyusui->delete();
            }

            $pendingIbu->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingIbu->delete();

            Log::info('Data ibu ditolak', ['id' => $id, 'catatan' => $request->catatan]);

            return redirect()->route('kecamatan.ibu.index')->with('success', 'Data ibu ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data ibu: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.ibu.index')->with('error', 'Gagal menolak data ibu: ' . $e->getMessage());
        }
    }
}