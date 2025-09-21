<?php

namespace App\Http\Controllers;

use App\Models\PendingIbu;
use App\Models\PendingIbuHamil;
use App\Models\PendingIbuNifas;
use App\Models\PendingIbuMenyusui;
use App\Models\Ibu;
use App\Models\KartuKeluarga;
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
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $search = $request->query('search');
        $status = $request->query('status');
        $tab = $request->query('tab', 'pending');

        $pendingQuery = PendingIbu::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $user->kelurahan_id);

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

        $verifiedQuery = Ibu::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $user->kelurahan_id);

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

        $ibus = $tab === 'verified' ? $verifiedIbus : $pendingIbus;

        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $ibus->count();
        $paginatedIbus = $ibus->slice($offset, $perPage);
        $ibus = new LengthAwarePaginator($paginatedIbus, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kelurahan.ibu.index', compact('ibus', 'search', 'status', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kecamatan = $user->kecamatan;
        $kelurahan = $user->kelurahan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan) {
            Log::warning('Tidak ada data Kartu Keluarga atau data kecamatan/kelurahan tidak ditemukan untuk kelurahan_id: ' . $user->kelurahan_id);
            return view('kelurahan.ibu.create', compact('kartuKeluargas', 'kecamatan', 'kelurahan'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau data kecamatan/kelurahan tidak ditemukan. Silakan tambahkan data terlebih dahulu.');
        }

        return view('kelurahan.ibu.create', compact('kartuKeluargas', 'kecamatan', 'kelurahan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'nik' => ['nullable', 'string', 'max:16', 'unique:ibus,nik', 'unique:pending_ibus,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
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
                    'trimester' => 'Trimester 1',
                    'intervensi' => 'Tidak Ada',
                    'status_gizi' => 'Normal',
                    'warna_status_gizi' => 'Sehat',
                    'usia_kehamilan' => 0,
                    'berat' => 0,
                    'tinggi' => 0,
                    'created_by' => $user->id,
                ]);
            } elseif ($data['status'] === 'Nifas') {
                PendingIbuNifas::create([
                    'pending_ibu_id' => $pendingIbu->id,
                    'hari_nifas' => 0,
                    'kondisi_kesehatan' => 'Normal',
                    'berat' => 0,
                    'tinggi' => 0,
                    'created_by' => $user->id,
                ]);
            } elseif ($data['status'] === 'Menyusui') {
                PendingIbuMenyusui::create([
                    'pending_ibu_id' => $pendingIbu->id,
                    'status_menyusui' => 'Eksklusif',
                    'frekuensi_menyusui' => 0,
                    'kondisi_ibu' => 'Normal',
                    'warna_kondisi' => 'Hijau (success)',
                    'berat' => 0,
                    'tinggi' => 0,
                    'created_by' => $user->id,
                ]);
            }

            Log::info('Menyimpan data ibu ke pending_ibus', ['data' => $data]);
            return redirect()->route('kelurahan.ibu.index', ['tab' => 'pending'])->with('success', 'Data ibu berhasil ditambahkan, menunggu verifikasi admin kecamatan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        if ($source === 'verified') {
            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        } else {
            $ibu = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kecamatan = $user->kecamatan;
        $kelurahan = $user->kelurahan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan) {
            Log::warning('Tidak ada data Kartu Keluarga atau data kecamatan/kelurahan tidak ditemukan untuk kelurahan_id: ' . $user->kelurahan_id);
            return view('kelurahan.ibu.edit', compact('ibu', 'kartuKeluargas', 'kecamatan', 'kelurahan', 'source'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau data kecamatan/kelurahan tidak ditemukan. Silakan tambahkan data terlebih dahulu.');
        }

        return view('kelurahan.ibu.edit', compact('ibu', 'kartuKeluargas', 'kecamatan', 'kelurahan', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'nik' => ['nullable', 'string', 'max:16', 'unique:ibus,nik,' . ($source === 'verified' ? $id : null), 'unique:pending_ibus,nik,' . ($source === 'pending' ? $id : null)],
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            if ($source === 'verified') {
                $verifiedIbu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = [
                    'nik' => $request->nik,
                    'nama' => $request->nama,
                    'kecamatan_id' => $user->kecamatan_id,
                    'kelurahan_id' => $user->kelurahan_id,
                    'kartu_keluarga_id' => $request->kartu_keluarga_id,
                    'alamat' => $request->alamat,
                    'status' => $request->status,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                    'original_ibu_id' => $verifiedIbu->id,
                ];

                if ($request->hasFile('foto')) {
                    if ($verifiedIbu->foto && Storage::disk('public')->exists($verifiedIbu->foto)) {
                        Storage::disk('public')->delete($verifiedIbu->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('ibu_fotos', 'public');
                } else {
                    $data['foto'] = $verifiedIbu->foto;
                }

                $pendingIbu = PendingIbu::create($data);

                if ($verifiedIbu->status !== $data['status']) {
                    if ($pendingIbu->pendingIbuHamil) {
                        $pendingIbu->pendingIbuHamil->delete();
                    }
                    if ($pendingIbu->pendingIbuNifas) {
                        $pendingIbu->pendingIbuNifas->delete();
                    }
                    if ($pendingIbu->pendingIbuMenyusui) {
                        $pendingIbu->pendingIbuMenyusui->delete();
                    }

                    if ($data['status'] === 'Hamil') {
                        PendingIbuHamil::create([
                            'pending_ibu_id' => $pendingIbu->id,
                            'trimester' => 'Trimester 1',
                            'intervensi' => 'Tidak Ada',
                            'status_gizi' => 'Normal',
                            'warna_status_gizi' => 'Sehat',
                            'usia_kehamilan' => 0,
                            'berat' => 0,
                            'tinggi' => 0,
                            'created_by' => $user->id,
                        ]);
                    } elseif ($data['status'] === 'Nifas') {
                        PendingIbuNifas::create([
                            'pending_ibu_id' => $pendingIbu->id,
                            'hari_nifas' => 0,
                            'kondisi_kesehatan' => 'Normal',
                            'berat' => 0,
                            'tinggi' => 0,
                            'created_by' => $user->id,
                        ]);
                    } elseif ($data['status'] === 'Menyusui') {
                        PendingIbuMenyusui::create([
                            'pending_ibu_id' => $pendingIbu->id,
                            'status_menyusui' => 'Eksklusif',
                            'frekuensi_menyusui' => 0,
                            'kondisi_ibu' => 'Normal',
                            'warna_kondisi' => 'Hijau (success)',
                            'berat' => 0,
                            'tinggi' => 0,
                            'created_by' => $user->id,
                        ]);
                    }
                }

                Log::info('Menyimpan data ibu terverifikasi ke pending_ibus untuk edit', ['data' => $data]);
                return redirect()->route('kelurahan.ibu.index', ['tab' => 'pending'])->with('success', 'Data ibu terverifikasi berhasil diedit, menunggu verifikasi admin kecamatan.');
            } else {
                $pendingIbu = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = $request->all();
                $data['kecamatan_id'] = $user->kecamatan_id;
                $data['kelurahan_id'] = $user->kelurahan_id;
                $data['created_by'] = $user->id;
                $data['status_verifikasi'] = 'pending';

                if ($request->hasFile('foto')) {
                    if ($pendingIbu->foto && Storage::disk('public')->exists($pendingIbu->foto)) {
                        Storage::disk('public')->delete($pendingIbu->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('ibu_fotos', 'public');
                }

                if ($pendingIbu->status !== $data['status']) {
                    if ($pendingIbu->pendingIbuHamil) {
                        $pendingIbu->pendingIbuHamil->delete();
                    }
                    if ($pendingIbu->pendingIbuNifas) {
                        $pendingIbu->pendingIbuNifas->delete();
                    }
                    if ($pendingIbu->pendingIbuMenyusui) {
                        $pendingIbu->pendingIbuMenyusui->delete();
                    }

                    if ($data['status'] === 'Hamil') {
                        PendingIbuHamil::create([
                            'pending_ibu_id' => $pendingIbu->id,
                            'trimester' => 'Trimester 1',
                            'intervensi' => 'Tidak Ada',
                            'status_gizi' => 'Normal',
                            'warna_status_gizi' => 'Sehat',
                            'usia_kehamilan' => 0,
                            'berat' => 0,
                            'tinggi' => 0,
                            'created_by' => $user->id,
                        ]);
                    } elseif ($data['status'] === 'Nifas') {
                        PendingIbuNifas::create([
                            'pending_ibu_id' => $pendingIbu->id,
                            'hari_nifas' => 0,
                            'kondisi_kesehatan' => 'Normal',
                            'berat' => 0,
                            'tinggi' => 0,
                            'created_by' => $user->id,
                        ]);
                    } elseif ($data['status'] === 'Menyusui') {
                        PendingIbuMenyusui::create([
                            'pending_ibu_id' => $pendingIbu->id,
                            'status_menyusui' => 'Eksklusif',
                            'frekuensi_menyusui' => 0,
                            'kondisi_ibu' => 'Normal',
                            'warna_kondisi' => 'Hijau (success)',
                            'berat' => 0,
                            'tinggi' => 0,
                            'created_by' => $user->id,
                        ]);
                    }
                }

                $pendingIbu->update($data);
                Log::info('Memperbarui data ibu di pending_ibus', ['id' => $id, 'data' => $data]);
                return redirect()->route('kelurahan.ibu.index', ['tab' => 'pending'])->with('success', 'Data ibu berhasil diperbarui, menunggu verifikasi admin kecamatan.');
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
            if ($ibu->pendingIbuNifas) {
                $ibu->pendingIbuNifas->delete();
            }
            if ($ibu->pendingIbuMenyusui) {
                $ibu->pendingIbuMenyusui->delete();
            }
            $ibu->delete();

            return redirect()->route('kelurahan.ibu.index', ['tab' => 'pending'])->with('success', 'Data ibu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu.index', ['tab' => 'pending'])->with('error', 'Gagal menghapus data ibu: ' . $e->getMessage());
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
                ];
            });

        return response()->json($kartuKeluargas);
    }
}