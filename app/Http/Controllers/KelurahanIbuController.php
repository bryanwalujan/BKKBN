<?php

namespace App\Http\Controllers;

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

        $query = Ibu::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $user->kelurahan_id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $ibus = $query->paginate(10)->appends(['search' => $search, 'status' => $status]);

        return view('kelurahan.ibu.index', compact('ibus', 'search', 'status'));
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
            'nik' => ['nullable', 'string', 'max:16', 'regex:/^[0-9]+$/', 'unique:ibus,nik'],
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

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('ibu_fotos', 'public');
            }

            $ibu = Ibu::create($data);

            if ($data['status'] === 'Hamil') {
                IbuHamil::create([
                    'ibu_id' => $ibu->id,
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
                IbuNifas::create([
                    'ibu_id' => $ibu->id,
                    'hari_nifas' => 0,
                    'kondisi_kesehatan' => 'Normal',
                    'warna_kondisi' => 'Hijau (success)',
                    'berat' => 0,
                    'tinggi' => 0,
                    'created_by' => $user->id,
                ]);
            } elseif ($data['status'] === 'Menyusui') {
                IbuMenyusui::create([
                    'ibu_id' => $ibu->id,
                    'status_menyusui' => 'Eksklusif',
                    'frekuensi_menyusui' => 0,
                    'kondisi_ibu' => 'Normal',
                    'warna_kondisi' => 'Hijau (success)',
                    'berat' => 0,
                    'tinggi' => 0,
                    'created_by' => $user->id,
                ]);
            }

            Log::info('Menyimpan data ibu ke ibus', ['data' => $data]);
            return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kecamatan = $user->kecamatan;
        $kelurahan = $user->kelurahan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan) {
            Log::warning('Tidak ada data Kartu Keluarga atau data kecamatan/kelurahan tidak ditemukan untuk kelurahan_id: ' . $user->kelurahan_id);
            return view('kelurahan.ibu.edit', compact('ibu', 'kartuKeluargas', 'kecamatan', 'kelurahan'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau data kecamatan/kelurahan tidak ditemukan. Silakan tambahkan data terlebih dahulu.');
        }

        return view('kelurahan.ibu.edit', compact('ibu', 'kartuKeluargas', 'kecamatan', 'kelurahan'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'nik' => ['nullable', 'string', 'max:16', 'regex:/^[0-9]+$/', 'unique:ibus,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            $data = $request->all();
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;

            if ($request->hasFile('foto')) {
                if ($ibu->foto && Storage::disk('public')->exists($ibu->foto)) {
                    Storage::disk('public')->delete($ibu->foto);
                }
                $data['foto'] = $request->file('foto')->store('ibu_fotos', 'public');
            }

            if ($ibu->status !== $data['status']) {
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuNifas) {
                    $ibu->ibuNifas->delete();
                }
                if ($ibu->ibuMenyusui) {
                    $ibu->ibuMenyusui->delete();
                }

                if ($data['status'] === 'Hamil') {
                    IbuHamil::create([
                        'ibu_id' => $ibu->id,
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
                    IbuNifas::create([
                        'ibu_id' => $ibu->id,
                        'hari_nifas' => 0,
                        'kondisi_kesehatan' => 'Normal',
                        'warna_kondisi' => 'Hijau (success)',
                        'berat' => 0,
                        'tinggi' => 0,
                        'created_by' => $user->id,
                    ]);
                } elseif ($data['status'] === 'Menyusui') {
                    IbuMenyusui::create([
                        'ibu_id' => $ibu->id,
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

            $ibu->update($data);
            Log::info('Memperbarui data ibu di ibus', ['id' => $id, 'data' => $data]);
            return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu berhasil diperbarui.');
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
            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($ibu->foto && Storage::disk('public')->exists($ibu->foto)) {
                Storage::disk('public')->delete($ibu->foto);
            }
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuNifas) {
                $ibu->ibuNifas->delete();
            }
            if ($ibu->ibuMenyusui) {
                $ibu->ibuMenyusui->delete();
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
                ];
            });

        return response()->json($kartuKeluargas);
    }
}