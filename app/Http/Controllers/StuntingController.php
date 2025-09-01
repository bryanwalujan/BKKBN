<?php
namespace App\Http\Controllers;

use App\Models\Stunting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StuntingController extends Controller
{
    public function index()
    {
        $stuntings = Stunting::all();
        return view('master.stunting.index', compact('stuntings'));
    }

    public function create()
    {
        return view('master.stunting.create');
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
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $data = $request->all();
        $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('stunting_fotos', 'public');
        }

        Stunting::create($data);

        return redirect()->route('stunting.index')->with('success', 'Data stunting berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stunting = Stunting::findOrFail($id);
        return view('master.stunting.edit', compact('stunting'));
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
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

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

        return redirect()->route('stunting.index')->with('success', 'Data stunting berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $stunting = Stunting::findOrFail($id);
        if ($stunting->foto) {
            Storage::disk('public')->delete($stunting->foto);
        }
        $stunting->delete();

        return redirect()->route('stunting.index')->with('success', 'Data stunting berhasil dihapus.');
    }
}