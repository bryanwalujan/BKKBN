<?php

namespace App\Http\Controllers;

use App\Models\PendingIbu;
use App\Models\PendingIbuHamil;
use App\Models\Ibu;
use App\Models\KartuKeluarga;
use App\Models\PendingKartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanIbuController extends Controller
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
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingIbu
        $pendingQuery = PendingIbu::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $pendingIbus = $pendingQuery->get()->map(function ($ibu) {
            $ibu->source = 'pending';
            return $ibu;
        });

        // Query untuk Ibu (terverifikasi)
        $verifiedQuery = Ibu::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $verifiedQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
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

        return view('kelurahan.ibu.index', compact('ibus', 'search', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga'])
            ->map(function ($kk) {
                $kk->source = 'verified';
                return $kk;
            });

        $pendingKartuKeluargas = PendingKartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->where('status_verifikasi', 'pending')
            ->get(['id', 'no_kk', 'kepala_keluarga'])
            ->map(function ($kk) {
                $kk->source = 'pending';
                return $kk;
            });

        $kartuKeluargas = $kartuKeluargas->merge($pendingKartuKeluargas);

        if ($kartuKeluargas->isEmpty()) {
            Log::warning('Tidak ada data Kartu Keluarga ditemukan untuk kelurahan_id: ' . $user->kelurahan_id);
            return view('kelurahan.ibu.create', compact('kartuKeluargas'))
                ->with('warning', 'Tidak ada data Kartu Keluarga. Silakan tambahkan Kartu Keluarga terlebih dahulu.');
        }

        return view('kelurahan.ibu.create', compact('kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'nik' => ['nullable', 'string', 'max:16', 'unique:pending_ibus,nik', 'unique:ibus,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
            'trimester' => ['required_if:status,Hamil', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required_if:status,Hamil', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required_if:status,Hamil', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required_if:status,Hamil', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required_if:status,Hamil', 'integer', 'min:0', 'max:40'],
            'berat' => ['required_if:status,Hamil', 'numeric', 'min:0'],
            'tinggi' => ['required_if:status,Hamil', 'numeric', 'min:0'],
        ]);

        try {
            $data = $request->all();
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;
            $data['status_verifikasi'] = 'pending';

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('ibu_fotos', 'public');
            }

            $pendingIbu = PendingIbu::create($data);

            if ($data['status'] === 'Hamil') {
                PendingIbuHamil::create([
                    'pending_ibu_id' => $pendingIbu->id,
                    'trimester' => $data['trimester'],
                    'intervensi' => $data['intervensi'],
                    'status_gizi' => $data['status_gizi'],
                    'warna_status_gizi' => $data['warna_status_gizi'],
                    'usia_kehamilan' => $data['usia_kehamilan'],
                    'berat' => $data['berat'],
                    'tinggi' => $data['tinggi'],
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                ]);
            }

            return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu berhasil ditambahkan, menunggu verifikasi admin kecamatan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        if ($source === 'verified') {
            $ibu = Ibu::with('ibuHamil')->where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        } else {
            $ibu = PendingIbu::with('pendingIbuHamil')->where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga'])
            ->map(function ($kk) {
                $kk->source = 'verified';
                return $kk;
            });

        $pendingKartuKeluargas = PendingKartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->where('status_verifikasi', 'pending')
            ->get(['id', 'no_kk', 'kepala_keluarga'])
            ->map(function ($kk) {
                $kk->source = 'pending';
                return $kk;
            });

        $kartuKeluargas = $kartuKeluargas->merge($pendingKartuKeluargas);

        if ($kartuKeluargas->isEmpty()) {
            Log::warning('Tidak ada data Kartu Keluarga ditemukan untuk kelurahan_id: ' . $user->kelurahan_id);
            return view('kelurahan.ibu.edit', compact('ibu', 'kartuKeluargas', 'source'))
                ->with('warning', 'Tidak ada data Kartu Keluarga. Silakan tambahkan Kartu Keluarga terlebih dahulu.');
        }

        return view('kelurahan.ibu.edit', compact('ibu', 'kartuKeluargas', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'nik' => ['nullable', 'string', 'max:16', 'unique:pending_ibus,nik,' . ($source === 'pending' ? $id : null), 'unique:ibus,nik,' . ($source === 'verified' ? $id : null)],
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
            'trimester' => ['required_if:status,Hamil', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required_if:status,Hamil', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required_if:status,Hamil', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required_if:status,Hamil', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required_if:status,Hamil', 'integer', 'min:0', 'max:40'],
            'berat' => ['required_if:status,Hamil', 'numeric', 'min:0'],
            'tinggi' => ['required_if:status,Hamil', 'numeric', 'min:0'],
        ]);

        try {
            if ($source === 'verified') {
                $verifiedIbu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = $request->all();
                $data['kecamatan_id'] = $user->kecamatan_id;
                $data['kelurahan_id'] = $user->kelurahan_id;
                $data['created_by'] = $user->id;
                $data['status_verifikasi'] = 'pending';
                $data['original_ibu_id'] = $verifiedIbu->id;

                if ($request->hasFile('foto')) {
                    if ($verifiedIbu->foto && Storage::disk('public')->exists($verifiedIbu->foto)) {
                        Storage::disk('public')->delete($verifiedIbu->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('ibu_fotos', 'public');
                } else {
                    $data['foto'] = $verifiedIbu->foto;
                }

                $pendingIbu = PendingIbu::create($data);

                if ($data['status'] === 'Hamil') {
                    PendingIbuHamil::create([
                        'pending_ibu_id' => $pendingIbu->id,
                        'trimester' => $data['trimester'],
                        'intervensi' => $data['intervensi'],
                        'status_gizi' => $data['status_gizi'],
                        'warna_status_gizi' => $data['warna_status_gizi'],
                        'usia_kehamilan' => $data['usia_kehamilan'],
                        'berat' => $data['berat'],
                        'tinggi' => $data['tinggi'],
                        'created_by' => $user->id,
                        'status_verifikasi' => 'pending',
                        'original_ibu_hamil_id' => $verifiedIbu->ibuHamil ? $verifiedIbu->ibuHamil->id : null,
                    ]);
                }

                return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu terverifikasi berhasil diedit, menunggu verifikasi admin kecamatan.');
            } else {
                $ibu = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = $request->all();
                $data['kecamatan_id'] = $user->kecamatan_id;
                $data['kelurahan_id'] = $user->kelurahan_id;
                $data['created_by'] = $user->id;
                $data['status_verifikasi'] = 'pending';

                if ($request->hasFile('foto')) {
                    if ($ibu->foto && Storage::disk('public')->exists($ibu->foto)) {
                        Storage::disk('public')->delete($ibu->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('ibu_fotos', 'public');
                }

                $ibu->update($data);

                if ($ibu->pendingIbuHamil && $data['status'] !== 'Hamil') {
                    $ibu->pendingIbuHamil->delete();
                } elseif ($data['status'] === 'Hamil') {
                    if ($ibu->pendingIbuHamil) {
                        $ibu->pendingIbuHamil->update([
                            'trimester' => $data['trimester'],
                            'intervensi' => $data['intervensi'],
                            'status_gizi' => $data['status_gizi'],
                            'warna_status_gizi' => $data['warna_status_gizi'],
                            'usia_kehamilan' => $data['usia_kehamilan'],
                            'berat' => $data['berat'],
                            'tinggi' => $data['tinggi'],
                            'created_by' => $user->id,
                            'status_verifikasi' => 'pending',
                        ]);
                    } else {
                        PendingIbuHamil::create([
                            'pending_ibu_id' => $ibu->id,
                            'trimester' => $data['trimester'],
                            'intervensi' => $data['intervensi'],
                            'status_gizi' => $data['status_gizi'],
                            'warna_status_gizi' => $data['warna_status_gizi'],
                            'usia_kehamilan' => $data['usia_kehamilan'],
                            'berat' => $data['berat'],
                            'tinggi' => $data['tinggi'],
                            'created_by' => $user->id,
                            'status_verifikasi' => 'pending',
                        ]);
                    }
                }

                return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu berhasil diperbarui, menunggu verifikasi admin kecamatan.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $ibu = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($ibu->foto && Storage::disk('public')->exists($ibu->foto)) {
                Storage::disk('public')->delete($ibu->foto);
            }
            if ($ibu->pendingIbuHamil) {
                $ibu->pendingIbuHamil->delete();
            }
            $ibu->delete();

            return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Gagal menghapus data ibu: ' . $e->getMessage());
        }
    }

    public function getKartuKeluarga(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return response()->json(['error' => 'Admin kelurahan tidak terkait dengan kelurahan.'], 403);
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga'])
            ->map(function ($kk) {
                return [
                    'id' => $kk->id,
                    'no_kk' => $kk->no_kk,
                    'kepala_keluarga' => $kk->kepala_keluarga,
                    'source' => 'verified',
                ];
            });

        $pendingKartuKeluargas = PendingKartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->where('status_verifikasi', 'pending')
            ->get(['id', 'no_kk', 'kepala_keluarga'])
            ->map(function ($kk) {
                return [
                    'id' => $kk->id,
                    'no_kk' => $kk->no_kk,
                    'kepala_keluarga' => $kk->kepala_keluarga,
                    'source' => 'pending',
                ];
            });

        $kartuKeluargas = $kartuKeluargas->merge($pendingKartuKeluargas);

        return response()->json($kartuKeluargas);
    }
}