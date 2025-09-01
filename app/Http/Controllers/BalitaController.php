<?php
namespace App\Http\Controllers;

use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BalitaController extends Controller
{
    public function index()
    {
        $balitas = Balita::all();
        return view('master.balita.index', compact('balitas'));
    }

    public function create()
    {
        return view('master.balita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'status_gizi' => ['required', 'string', 'max:255'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
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
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'status_gizi' => ['required', 'string', 'max:255'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
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
}