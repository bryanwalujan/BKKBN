<?php
namespace App\Http\Controllers;

use App\Models\AksiKonvergensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AksiKonvergensiController extends Controller
{
    public function index()
    {
        $aksiKonvergensis = AksiKonvergensi::all();
        return view('master.aksi_konvergensi.index', compact('aksiKonvergensis'));
    }

    public function create()
    {
        return view('master.aksi_konvergensi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'nama_aksi' => ['required', 'string', 'max:255'],
            'selesai' => ['nullable', 'boolean'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2030'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $data = $request->all();
        $data['selesai'] = $request->has('selesai');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
        }

        AksiKonvergensi::create($data);

        return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
        return view('master.aksi_konvergensi.edit', compact('aksiKonvergensi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'nama_aksi' => ['required', 'string', 'max:255'],
            'selesai' => ['nullable', 'boolean'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2030'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
        $data = $request->all();
        $data['selesai'] = $request->has('selesai');

        if ($request->hasFile('foto')) {
            if ($aksiKonvergensi->foto) {
                Storage::disk('public')->delete($aksiKonvergensi->foto);
            }
            $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
        }

        $aksiKonvergensi->update($data);

        return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
        if ($aksiKonvergensi->foto) {
            Storage::disk('public')->delete($aksiKonvergensi->foto);
        }
        $aksiKonvergensi->delete();

        return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil dihapus.');
    }
}