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
use Illuminate\Pagination\LengthAwarePaginator;

class StuntingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter pencarian dan kategori umur
        $search = $request->query('search');
        $kategoriUmur = $request->query('kategori_umur');

        // Ambil data dengan relasi
        $query = Stunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan']);

        // Terapkan filter pencarian berdasarkan nama atau NIK
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama',

 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        // Ambil data
        $stuntings = $query->get();

        // Filter berdasarkan kategori umur
        if ($kategoriUmur && in_array($kategoriUmur, ['Baduata', 'Balita'])) {
            $stuntings = $stuntings->filter(function ($stunting) use ($kategoriUmur) {
                return $stunting->kategori_umur === $kategoriUmur;
            });
        }

        // Implementasi pagination manual untuk koleksi
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $stuntings->count();
        $paginatedStuntings = $stuntings->slice($offset, $perPage);
        $stuntings = new LengthAwarePaginator($paginatedStuntings, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

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
            'nik' => ['nullable', 'string', 'max:255', 'unique:stuntings,nik'],
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

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('stunting_fotos', 'public');
            }

            $stunting = Stunting::create($data);

            // Perbarui status_gizi dan warna_label di tabel balitas jika NIK ada
            if ($data['nik']) {
                $balita = Balita::where('nik', $data['nik'])->first();
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
            'nik' => ['nullable', 'string', 'max:255', 'unique:stuntings,nik,' . $id],
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

            if ($request->hasFile('foto')) {
                if ($stunting->foto) {
                    Storage::disk('public')->delete($stunting->foto);
                }
                $data['foto'] = $request->file('foto')->store('stunting_fotos', 'public');
            }

            $stunting->update($data);

            // Perbarui status_gizi dan warna_label di tabel balitas jika NIK ada
            if ($data['nik']) {
                $balita = Balita::where('nik', $data['nik'])->first();
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