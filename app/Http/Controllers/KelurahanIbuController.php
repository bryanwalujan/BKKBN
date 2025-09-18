<?php
namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\IbuHamil;
use App\Models\IbuNifas;
use App\Models\IbuMenyusui;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        $query = Ibu::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
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

        $kecamatan = Kecamatan::where('id', $user->kecamatan_id)->first();
        $kelurahan = Kelurahan::where('id', $user->kelurahan_id)->first();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get();

        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kelurahan.kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum menambah data ibu.');
        }
        if (!$kecamatan || !$kelurahan) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Data kecamatan atau kelurahan tidak ditemukan.');
        }

        return view('kelurahan.ibu.create', compact('kecamatan', 'kelurahan', 'kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id . ',kelurahan_id,' . $user->kelurahan_id],
            'nik' => ['nullable', 'string', 'max:16', 'unique:ibus,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'trimester' => ['required_if:status,Hamil', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required_if:status,Hamil', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required_if:status,Hamil', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required_if:status,Hamil', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required_if:status,Hamil', 'integer', 'min:0', 'max:40'],
            'berat_hamil' => ['required_if:status,Hamil', 'numeric', 'min:0'],
            'tinggi_hamil' => ['required_if:status,Hamil', 'numeric', 'min:0'],
            'hari_nifas' => ['required_if:status,Nifas', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required_if:status,Nifas', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi_nifas' => ['required_if:status,Nifas', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat_nifas' => ['required_if:status,Nifas', 'numeric', 'min:0'],
            'tinggi_nifas' => ['required_if:status,Nifas', 'numeric', 'min:0'],
            'status_menyusui' => ['required_if:status,Menyusui', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required_if:status,Menyusui', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required_if:status,Menyusui', 'string', 'max:255'],
            'warna_kondisi_menyusui' => ['required_if:status,Menyusui', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat_menyusui' => ['required_if:status,Menyusui', 'numeric', 'min:0'],
            'tinggi_menyusui' => ['required_if:status,Menyusui', 'numeric', 'min:0'],
        ]);

        try {
            $data = $request->only(['nik', 'nama', 'alamat', 'status']);
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;
            $data['kartu_keluarga_id'] = $request->kartu_keluarga_id;

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('ibu_photos', 'public');
            }

            $ibu = Ibu::create($data);

            if ($request->status == 'Hamil') {
                IbuHamil::create([
                    'ibu_id' => $ibu->id,
                    'trimester' => $request->trimester,
                    'intervensi' => $request->intervensi,
                    'status_gizi' => $request->status_gizi,
                    'warna_status_gizi' => $request->warna_status_gizi,
                    'usia_kehamilan' => $request->usia_kehamilan,
                    'berat' => $request->berat_hamil,
                    'tinggi' => $request->tinggi_hamil,
                ]);
            } elseif ($request->status == 'Nifas') {
                IbuNifas::create([
                    'ibu_id' => $ibu->id,
                    'hari_nifas' => $request->hari_nifas,
                    'kondisi_kesehatan' => $request->kondisi_kesehatan,
                    'warna_kondisi' => $request->warna_kondisi_nifas,
                    'berat' => $request->berat_nifas,
                    'tinggi' => $request->tinggi_nifas,
                ]);
            } elseif ($request->status == 'Menyusui') {
                IbuMenyusui::create([
                    'ibu_id' => $ibu->id,
                    'status_menyusui' => $request->status_menyusui,
                    'frekuensi_menyusui' => $request->frekuensi_menyusui,
                    'kondisi_ibu' => $request->kondisi_ibu,
                    'warna_kondisi' => $request->warna_kondisi_menyusui,
                    'berat' => $request->berat_menyusui,
                    'tinggi' => $request->tinggi_menyusui,
                ]);
            }

            Log::info('Data ibu disimpan ke ibus', ['id' => $ibu->id, 'data' => $data]);
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

        $ibu = Ibu::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'ibuHamil', 'ibuNifas', 'ibuMenyusui'])
            ->where('kelurahan_id', $user->kelurahan_id)
            ->findOrFail($id);

        $kecamatan = Kecamatan::where('id', $user->kecamatan_id)->first();
        $kelurahan = Kelurahan::where('id', $user->kelurahan_id)->first();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get();

        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kelurahan.kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum mengedit data ibu.');
        }
        if (!$kecamatan || !$kelurahan) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Data kecamatan atau kelurahan tidak ditemukan.');
        }

        return view('kelurahan.ibu.edit', compact('ibu', 'kecamatan', 'kelurahan', 'kartuKeluargas'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id . ',kelurahan_id,' . $user->kelurahan_id],
            'nik' => ['nullable', 'string', 'max:16', 'unique:ibus,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'trimester' => ['required_if:status,Hamil', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required_if:status,Hamil', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required_if:status,Hamil', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required_if:status,Hamil', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required_if:status,Hamil', 'integer', 'min:0', 'max:40'],
            'berat_hamil' => ['required_if:status,Hamil', 'numeric', 'min:0'],
            'tinggi_hamil' => ['required_if:status,Hamil', 'numeric', 'min:0'],
            'hari_nifas' => ['required_if:status,Nifas', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required_if:status,Nifas', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi_nifas' => ['required_if:status,Nifas', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat_nifas' => ['required_if:status,Nifas', 'numeric', 'min:0'],
            'tinggi_nifas' => ['required_if:status,Nifas', 'numeric', 'min:0'],
            'status_menyusui' => ['required_if:status,Menyusui', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required_if:status,Menyusui', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required_if:status,Menyusui', 'string', 'max:255'],
            'warna_kondisi_menyusui' => ['required_if:status,Menyusui', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat_menyusui' => ['required_if:status,Menyusui', 'numeric', 'min:0'],
            'tinggi_menyusui' => ['required_if:status,Menyusui', 'numeric', 'min:0'],
        ]);

        try {
            $data = $request->only(['nik', 'nama', 'alamat', 'status']);
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;
            $data['kartu_keluarga_id'] = $request->kartu_keluarga_id;

            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);

            if ($request->hasFile('foto')) {
                if ($ibu->foto) {
                    Storage::disk('public')->delete($ibu->foto);
                }
                $data['foto'] = $request->file('foto')->store('ibu_photos', 'public');
            }

            $ibu->update($data);

            if ($request->status == 'Hamil') {
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->update([
                        'trimester' => $request->trimester,
                        'intervensi' => $request->intervensi,
                        'status_gizi' => $request->status_gizi,
                        'warna_status_gizi' => $request->warna_status_gizi,
                        'usia_kehamilan' => $request->usia_kehamilan,
                        'berat' => $request->berat_hamil,
                        'tinggi' => $request->tinggi_hamil,
                    ]);
                } else {
                    IbuHamil::create([
                        'ibu_id' => $ibu->id,
                        'trimester' => $request->trimester,
                        'intervensi' => $request->intervensi,
                        'status_gizi' => $request->status_gizi,
                        'warna_status_gizi' => $request->warna_status_gizi,
                        'usia_kehamilan' => $request->usia_kehamilan,
                        'berat' => $request->berat_hamil,
                        'tinggi' => $request->tinggi_hamil,
                    ]);
                }
                if ($ibu->ibuNifas) {
                    $ibu->ibuNifas->delete();
                }
                if ($ibu->ibuMenyusui) {
                    $ibu->ibuMenyusui->delete();
                }
            } elseif ($request->status == 'Nifas') {
                if ($ibu->ibuNifas) {
                    $ibu->ibuNifas->update([
                        'hari_nifas' => $request->hari_nifas,
                        'kondisi_kesehatan' => $request->kondisi_kesehatan,
                        'warna_kondisi' => $request->warna_kondisi_nifas,
                        'berat' => $request->berat_nifas,
                        'tinggi' => $request->tinggi_nifas,
                    ]);
                } else {
                    IbuNifas::create([
                        'ibu_id' => $ibu->id,
                        'hari_nifas' => $request->hari_nifas,
                        'kondisi_kesehatan' => $request->kondisi_kesehatan,
                        'warna_kondisi' => $request->warna_kondisi_nifas,
                        'berat' => $request->berat_nifas,
                        'tinggi' => $request->tinggi_nifas,
                    ]);
                }
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuMenyusui) {
                    $ibu->ibuMenyusui->delete();
                }
            } elseif ($request->status == 'Menyusui') {
                if ($ibu->ibuMenyusui) {
                    $ibu->ibuMenyusui->update([
                        'status_menyusui' => $request->status_menyusui,
                        'frekuensi_menyusui' => $request->frekuensi_menyusui,
                        'kondisi_ibu' => $request->kondisi_ibu,
                        'warna_kondisi' => $request->warna_kondisi_menyusui,
                        'berat' => $request->berat_menyusui,
                        'tinggi' => $request->tinggi_menyusui,
                    ]);
                } else {
                    IbuMenyusui::create([
                        'ibu_id' => $ibu->id,
                        'status_menyusui' => $request->status_menyusui,
                        'frekuensi_menyusui' => $request->frekuensi_menyusui,
                        'kondisi_ibu' => $request->kondisi_ibu,
                        'warna_kondisi' => $request->warna_kondisi_menyusui,
                        'berat' => $request->berat_menyusui,
                        'tinggi' => $request->tinggi_menyusui,
                    ]);
                }
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuNifas) {
                    $ibu->ibuNifas->delete();
                }
            } else {
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuNifas) {
                    $ibu->ibuNifas->delete();
                }
                if ($ibu->ibuMenyusui) {
                    $ibu->ibuMenyusui->delete();
                }
            }

            Log::info('Data ibu diperbarui di ibus', ['id' => $ibu->id, 'data' => $data]);
            return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        try {
            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($ibu->foto) {
                Storage::disk('public')->delete($ibu->foto);
            }
            $ibu->delete();
            return redirect()->route('kelurahan.ibu.index')->with('success', 'Data ibu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu.index')->with('error', 'Gagal menghapus data ibu: ' . $e->getMessage());
        }
    }
}