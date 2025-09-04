<?php
namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Imports\BalitaImport;
use App\Exports\BalitaTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BalitaController extends Controller
{
    public function index()
    {
        $balitas = Balita::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])->paginate(10);
        return view('master.balita.index', compact('balitas'));
    }

    public function create()
    {
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        $kecamatans = Kecamatan::all();
        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum menambah data balita.');
        }
        if ($kecamatans->isEmpty()) {
            return redirect()->route('balita.index')->with('error', 'Tambahkan Kecamatan terlebih dahulu sebelum menambah data balita.');
        }
        return view('master.balita.create', compact('kartuKeluargas', 'kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'unique:balitas,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $data = $request->all();
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
            }

            Log::info('Menyimpan data balita', $data);
            Balita::create($data);

            return redirect()->route('balita.index')->with('success', 'Data balita berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data balita: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data balita: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $balita = Balita::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])->findOrFail($id);
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        $kecamatans = Kecamatan::all();
        $kelurahans = $balita->kecamatan_id ? Kelurahan::where('kecamatan_id', $balita->kecamatan_id)->get() : collect([]);
        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum mengedit data balita.');
        }
        if ($kecamatans->isEmpty()) {
            return redirect()->route('balita.index')->with('error', 'Tambahkan Kecamatan terlebih dahulu sebelum mengedit data balita.');
        }
        return view('master.balita.edit', compact('balita', 'kartuKeluargas', 'kecamatans', 'kelurahans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'unique:balitas,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $balita = Balita::findOrFail($id);
            $data = $request->all();
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;

            if ($request->hasFile('foto')) {
                if ($balita->foto) {
                    Storage::disk('public')->delete($balita->foto);
                }
                $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
            }

            Log::info('Memperbarui data balita', ['id' => $id, 'data' => $data]);
            $balita->update($data);

            return redirect()->route('balita.index')->with('success', 'Data balita berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data balita: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data balita: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $balita = Balita::findOrFail($id);
            if ($balita->foto) {
                Storage::disk('public')->delete($balita->foto);
            }
            $balita->delete();

            return redirect()->route('balita.index')->with('success', 'Data balita berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('balita.index')->with('error', 'Gagal menghapus data balita: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:70000'],
        ]);

        try {
            Log::info('Memulai proses impor Excel');
            $import = new BalitaImport;
            Excel::import($import, $request->file('file'));
            Log::info('Proses impor Excel selesai');
            $message = "Impor selesai: {$import->getSuccessCount()} data berhasil diimpor.";
            if ($errors = $import->getErrors()) {
                $message .= " Terdapat kesalahan pada " . count($errors) . " baris: " . implode(', ', array_slice($errors, 0, 5));
            }
            return redirect()->route('balita.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error saat mengimpor Excel: ' . $e->getMessage());
            return redirect()->route('balita.index')->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new BalitaTemplateExport, 'template_balita.xlsx');
    }
}