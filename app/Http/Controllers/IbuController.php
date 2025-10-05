<?php
namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\IbuHamil;
use App\Models\IbuNifas;
use App\Models\IbuMenyusui;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class IbuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $query = Ibu::with(['kecamatan', 'kelurahan', 'kartuKeluarga', 'createdBy']);
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhereRaw('nik = ?', [Crypt::encryptString($search)])
                  ->orWhere('tempat_lahir', 'like', '%' . $search . '%')
                  ->orWhereRaw('nomor_telepon = ?', [Crypt::encryptString($search)]);
            });
        }

        if ($category) {
            $query->where('status', $category);
        }

        $ibus = $query->paginate(10)->appends(['search' => $search, 'category' => $category]);
        return view('master.ibu.index', compact('ibus', 'search', 'category'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        $kartuKeluargas = KartuKeluarga::all();
        
        if ($kartuKeluargas->isEmpty()) {
            Log::warning('Tidak ada data Kartu Keluarga ditemukan saat mengakses IbuController::create');
            return view('master.ibu.create', compact('kecamatans', 'kelurahans', 'kartuKeluargas'))
                ->with('warning', 'Tidak ada data Kartu Keluarga. Silakan tambahkan Kartu Keluarga terlebih dahulu.');
        }

        return view('master.ibu.create', compact('kecamatans', 'kelurahans', 'kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => ['nullable', 'string', 'max:16', 'regex:/^[0-9]+$/', 'unique:ibus,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'nomor_telepon' => ['nullable', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'jumlah_anak' => ['nullable', 'integer', 'min:0'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = auth()->id();
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
                ]);
            } elseif ($data['status'] === 'Nifas') {
                IbuNifas::create([
                    'ibu_id' => $ibu->id,
                    'hari_nifas' => 0,
                    'kondisi_kesehatan' => 'Normal',
                    'warna_kondisi' => 'Hijau (success)',
                    'berat' => 0,
                    'tinggi' => 0,
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
                ]);
            }

            return redirect()->route('ibu.index')->with('success', 'Data ibu berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ibu = Ibu::with(['kecamatan', 'kelurahan', 'kartuKeluarga'])->findOrFail($id);
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        $kartuKeluargas = KartuKeluarga::all();
        return view('master.ibu.edit', compact('ibu', 'kecamatans', 'kelurahans', 'kartuKeluargas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => ['nullable', 'string', 'max:16', 'regex:/^[0-9]+$/', 'unique:ibus,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'nomor_telepon' => ['nullable', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'jumlah_anak' => ['nullable', 'integer', 'min:0'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'alamat' => ['nullable', 'string'],
            'status' => ['required', 'in:Hamil,Nifas,Menyusui,Tidak Aktif'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $ibu = Ibu::findOrFail($id);
            $data = $request->all();
            $data['created_by'] = auth()->id();
            if ($request->hasFile('foto')) {
                if ($ibu->foto) {
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
                    ]);
                } elseif ($data['status'] === 'Nifas') {
                    IbuNifas::create([
                        'ibu_id' => $ibu->id,
                        'hari_nifas' => 0,
                        'kondisi_kesehatan' => 'Normal',
                        'warna_kondisi' => 'Hijau (success)',
                        'berat' => 0,
                        'tinggi' => 0,
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
                    ]);
                }
            }

            $ibu->update($data);
            return redirect()->route('ibu.index')->with('success', 'Data ibu berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ibu = Ibu::findOrFail($id);
            if ($ibu->foto) {
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
            return redirect()->route('ibu.index')->with('success', 'Data ibu berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('ibu.index')->with('error', 'Gagal menghapus data ibu: ' . $e->getMessage());
        }
    }
}