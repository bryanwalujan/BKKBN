<?php
namespace App\Http\Controllers;

use App\Models\PetaGeospasial;
use Illuminate\Http\Request;

class PetaGeospasialController extends Controller
{
    public function index()
    {
        $petaGeospasials = PetaGeospasial::all();
        return view('master.peta_geospasial.index', compact('petaGeospasials'));
    }

    public function create()
    {
        return view('master.peta_geospasial.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'jenis' => ['nullable', 'string', 'max:50'],
            'warna_marker' => ['required', 'in:Merah,Biru,Hijau'],
        ]);

        PetaGeospasial::create($request->all());

        return redirect()->route('peta_geospasial.index')->with('success', 'Data Peta Geospasial berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $petaGeospasial = PetaGeospasial::findOrFail($id);
        return view('master.peta_geospasial.edit', compact('petaGeospasial'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'jenis' => ['nullable', 'string', 'max:50'],
            'warna_marker' => ['required', 'in:Merah,Biru,Hijau'],
        ]);

        $petaGeospasial = PetaGeospasial::findOrFail($id);
        $petaGeospasial->update($request->all());

        return redirect()->route('peta_geospasial.index')->with('success', 'Data Peta Geospasial berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petaGeospasial = PetaGeospasial::findOrFail($id);
        $petaGeospasial->delete();

        return redirect()->route('peta_geospasial.index')->with('success', 'Data Peta Geospasial berhasil dihapus.');
    }
}