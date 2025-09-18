<?php

namespace App\Http\Controllers;

use App\Models\PendingIbu;
use App\Models\PendingIbuHamil;
use App\Models\Ibu;
use App\Models\IbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanIbuHamilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kelurahan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $kelurahan_id = $user->kelurahan_id;

        if (!$kelurahan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $search = $request->query('search');
        $category = $request->query('category');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingIbuHamil
        $pendingQuery = PendingIbuHamil::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan'])
            ->whereHas('pendingIbu', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
            });

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
            ->whereHas('ibu', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
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

        return view('kelurahan.ibu_hamil.index', compact('ibuHamils', 'search', 'category', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $ibus = PendingIbu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Hamil')
            ->where('status_verifikasi', 'pending')
            ->get(['id', 'nama', 'nik'])
            ->map(function ($ibu) {
                $ibu->source = 'pending';
                return $ibu;
            });

        $verifiedIbus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Hamil')
            ->get(['id', 'nama', 'nik'])
            ->map(function ($ibu) {
                $ibu->source = 'verified';
                return $ibu;
            });

        $ibus = $ibus->merge($verifiedIbus);

        if ($ibus->isEmpty()) {
            return view('kelurahan.ibu_hamil.create', compact('ibus'))
                ->with('warning', 'Tidak ada data ibu dengan status Hamil. Silakan tambahkan data ibu terlebih dahulu.');
        }

        return view('kelurahan.ibu_hamil.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'ibu_id' => ['required'],
            'ibu_source' => ['required', 'in:pending,verified'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibu_id = $request->ibu_id;
            $ibu_source = $request->ibu_source;

            if ($ibu_source === 'verified') {
                $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($ibu_id);
                $pendingIbu = PendingIbu::create([
                    'nik' => $ibu->nik,
                    'nama' => $ibu->nama,
                    'kecamatan_id' => $ibu->kecamatan_id,
                    'kelurahan_id' => $ibu->kelurahan_id,
                    'kartu_keluarga_id' => $ibu->kartu_keluarga_id,
                    'alamat' => $ibu->alamat,
                    'status' => 'Hamil',
                    'foto' => $ibu->foto,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                    'original_ibu_id' => $ibu->id,
                ]);

                PendingIbuHamil::create([
                    'pending_ibu_id' => $pendingIbu->id,
                    'trimester' => $request->trimester,
                    'intervensi' => $request->intervensi,
                    'status_gizi' => $request->status_gizi,
                    'warna_status_gizi' => $request->warna_status_gizi,
                    'usia_kehamilan' => $request->usia_kehamilan,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                    'original_ibu_hamil_id' => $ibu->ibuHamil ? $ibu->ibuHamil->id : null,
                ]);
            } else {
                $ibu = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($ibu_id);
                if ($ibu->pendingIbuHamil) {
                    $ibu->pendingIbuHamil->delete();
                }
                PendingIbuHamil::create([
                    'pending_ibu_id' => $ibu->id,
                    'trimester' => $request->trimester,
                    'intervensi' => $request->intervensi,
                    'status_gizi' => $request->status_gizi,
                    'warna_status_gizi' => $request->warna_status_gizi,
                    'usia_kehamilan' => $request->usia_kehamilan,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                ]);
            }

            return redirect()->route('kelurahan.ibu_hamil.index')->with('success', 'Data ibu hamil berhasil ditambahkan, menunggu verifikasi admin kecamatan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu hamil: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu hamil: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        if ($source === 'verified') {
            $ibuHamil = IbuHamil::whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);
            $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)
                ->where('status', 'Hamil')
                ->get(['id', 'nama', 'nik'])
                ->map(function ($ibu) {
                    $ibu->source = 'verified';
                    return $ibu;
                });
        } else {
            $ibuHamil = PendingIbuHamil::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);
            $ibus = PendingIbu::where('kelurahan_id', $user->kelurahan_id)
                ->where('status', 'Hamil')
                ->where('status_verifikasi', 'pending')
                ->get(['id', 'nama', 'nik'])
                ->map(function ($ibu) {
                    $ibu->source = 'pending';
                    return $ibu;
                });
        }

        $verifiedIbus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Hamil')
            ->get(['id', 'nama', 'nik'])
            ->map(function ($ibu) {
                $ibu->source = 'verified';
                return $ibu;
            });

        $ibus = $ibus->merge($verifiedIbus);

        return view('kelurahan.ibu_hamil.edit', compact('ibuHamil', 'ibus', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'ibu_id' => ['required'],
            'ibu_source' => ['required', 'in:pending,verified'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibu_id = $request->ibu_id;
            $ibu_source = $request->ibu_source;

            if ($ibu_source === 'verified') {
                $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($ibu_id);
                $pendingIbu = PendingIbu::create([
                    'nik' => $ibu->nik,
                    'nama' => $ibu->nama,
                    'kecamatan_id' => $ibu->kecamatan_id,
                    'kelurahan_id' => $ibu->kelurahan_id,
                    'kartu_keluarga_id' => $ibu->kartu_keluarga_id,
                    'alamat' => $ibu->alamat,
                    'status' => 'Hamil',
                    'foto' => $ibu->foto,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                    'original_ibu_id' => $ibu->id,
                ]);

                PendingIbuHamil::create([
                    'pending_ibu_id' => $pendingIbu->id,
                    'trimester' => $request->trimester,
                    'intervensi' => $request->intervensi,
                    'status_gizi' => $request->status_gizi,
                    'warna_status_gizi' => $request->warna_status_gizi,
                    'usia_kehamilan' => $request->usia_kehamilan,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                    'original_ibu_hamil_id' => $source === 'verified' ? $id : null,
                ]);
            } else {
                $ibuHamil = PendingIbuHamil::whereHas('pendingIbu', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                })->findOrFail($id);
                $ibuHamil->update([
                    'pending_ibu_id' => $ibu_id,
                    'trimester' => $request->trimester,
                    'intervensi' => $request->intervensi,
                    'status_gizi' => $request->status_gizi,
                    'warna_status_gizi' => $request->warna_status_gizi,
                    'usia_kehamilan' => $request->usia_kehamilan,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                ]);
            }

            return redirect()->route('kelurahan.ibu_hamil.index')->with('success', 'Data ibu hamil berhasil diperbarui, menunggu verifikasi admin kecamatan.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu hamil: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu hamil: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $ibuHamil = PendingIbuHamil::whereHas('pendingIbu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);
            $ibuHamil->delete();

            return redirect()->route('kelurahan.ibu_hamil.index')->with('success', 'Data ibu hamil berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu hamil: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Gagal menghapus data ibu hamil: ' . $e->getMessage());
        }
    }
}