<?php
namespace App\Http\Controllers;

use App\Models\Stunting;
use App\Models\Balita;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class StuntingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kategoriUmur = $request->query('kategori_umur');

        $query = Stunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhereRaw('nik = ?', [Crypt::encryptString($search)]);
            });
        }

        if ($kategoriUmur && in_array($kategoriUmur, ['Baduata', 'Balita'])) {
            $query->where('kategori_umur', $kategoriUmur);
        }

        $stuntings = $query->paginate(10)->appends($request->query());

        return view('master.stunting.index', compact('stuntings', 'kategoriUmur', 'search'));
    }

    public function create()
    {
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        $kecamatans = Kecamatan::all();
        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum menambah data stunting.');
        }
        if ($kecamatans->isEmpty()) {
            return redirect()->route('stunting.index')->with('error', 'Tambahkan Kecamatan terlebih dahulu sebelum menambah data stunting.');
        }
        return view('master.stunting.create', compact('kartuKeluargas', 'kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'regex:/^[0-9]+$/', 'unique:stuntings,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $data = $request->all();
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['created_by'] = auth()->id();

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('stunting_fotos', 'public');
            }

            $stunting = Stunting::create($data);

            if ($data['nik']) {
                $balita = Balita::where('nik', Crypt::encryptString($data['nik']))->first();
                if ($balita) {
                    $balita->update([
                        'status_gizi' => $data['status_gizi'],
                        'warna_label' => $data['warna_gizi'],
                    ]);
                    Log::info('Status gizi dan warna label balita diperbarui', [
                        'nik' => $data['nik'],
                        'balita_id' => $balita->id,
                        'status_gizi' => $data['status_gizi'],
                        'warna_label' => $data['warna_gizi']
                    ]);
                }
            }

            return redirect()->route('stunting.index')->with('success', 'Data stunting berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data stunting: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data stunting: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $stunting = Stunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])->findOrFail($id);
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        $kecamatans = Kecamatan::all();
        $kelurahans = $stunting->kecamatan_id ? Kelurahan::where('kecamatan_id', $stunting->kecamatan_id)->get() : collect([]);
        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum mengedit data stunting.');
        }
        if ($kecamatans->isEmpty()) {
            return redirect()->route('stunting.index')->with('error', 'Tambahkan Kecamatan terlebih dahulu sebelum mengedit data stunting.');
        }
        return view('master.stunting.edit', compact('stunting', 'kartuKeluargas', 'kecamatans', 'kelurahans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'regex:/^[0-9]+$/', 'unique:stuntings,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $stunting = Stunting::findOrFail($id);
            $data = $request->all();
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['created_by'] = auth()->id();

            if ($request->hasFile('foto')) {
                if ($stunting->foto) {
                    Storage::disk('public')->delete($stunting->foto);
                }
                $data['foto'] = $request->file('foto')->store('stunting_fotos', 'public');
            }

            $stunting->update($data);

            if ($data['nik']) {
                $balita = Balita::where('nik', Crypt::encryptString($data['nik']))->first();
                if ($balita) {
                    $balita->update([
                        'status_gizi' => $data['status_gizi'],
                        'warna_label' => $data['warna_gizi'],
                    ]);
                    Log::info('Status gizi dan warna label balita diperbarui', [
                        'nik' => $data['nik'],
                        'balita_id' => $balita->id,
                        'status_gizi' => $data['status_gizi'],
                        'warna_label' => $data['warna_gizi']
                    ]);
                }
            }

            return redirect()->route('stunting.index')->with('success', 'Data stunting berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data stunting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data stunting: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $stunting = Stunting::findOrFail($id);
            if ($stunting->foto) {
                Storage::disk('public')->delete($stunting->foto);
            }
            $stunting->delete();

            return redirect()->route('stunting.index')->with('success', 'Data stunting berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data stunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('stunting.index')->with('error', 'Gagal menghapus data stunting: ' . $e->getMessage());
        }
    }
}