<?php
namespace App\Http\Controllers;

use App\Models\Balita;
use App\Imports\BalitaImport;
use App\Exports\BalitaTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BalitaController extends Controller
{
    public function index()
    {
        $balitas = Balita::paginate(10); // Tambahkan pagination
        return view('master.balita.index', compact('balitas'));
    }

    public function create()
    {
        return view('master.balita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => ['nullable', 'string', 'max:255', 'unique:balitas,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'string', 'max:255'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $data = $request->all();
        $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
        }

        Balita::create($data);

        return redirect()->route('balita.index')->with('success', 'Data balita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $balita = Balita::findOrFail($id);
        return view('master.balita.edit', compact('balita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => ['nullable', 'string', 'max:255', 'unique:balitas,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'string', 'max:255'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $balita = Balita::findOrFail($id);
        $data = $request->all();
        $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;

        if ($request->hasFile('foto')) {
            if ($balita->foto) {
                Storage::disk('public')->delete($balita->foto);
            }
            $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
        }

        $balita->update($data);

        return redirect()->route('balita.index')->with('success', 'Data balita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $balita = Balita::findOrFail($id);
        if ($balita->foto) {
            Storage::disk('public')->delete($balita->foto);
        }
        $balita->delete();

        return redirect()->route('balita.index')->with('success', 'Data balita berhasil dihapus.');
    }

     public function import(Request $request)
{
    $request->validate([
        'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
    ]);

    try {
        \Log::info('Memulai proses impor Excel');
        $import = new BalitaImport;
        \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file'));
        \Log::info('Proses impor Excel selesai');
        $message = "Impor selesai: {$import->getSuccessCount()} data berhasil diimpor.";
        if ($errors = $import->getErrors()) {
            $message .= " Terdapat kesalahan pada " . count($errors) . " baris: " . implode(', ', array_slice($errors, 0, 5));
        }
        return redirect()->route('balita.index')->with('success', $message);
    } catch (\Exception $e) {
        \Log::error('Error saat mengimpor Excel: ' . $e->getMessage());
        return redirect()->route('balita.index')->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
    }
}

    public function downloadTemplate()
    {
        return Excel::download(new BalitaTemplateExport, 'template_balita.xlsx');
    }
}