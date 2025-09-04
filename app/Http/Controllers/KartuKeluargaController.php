<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        $kartuKeluargas = KartuKeluarga::withCount('balitas')->paginate(10);
        return view('master.kartu_keluarga.index', compact('kartuKeluargas'));
    }

    public function create()
    {
        return view('master.kartu_keluarga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => ['required', 'string', 'max:16', 'unique:kartu_keluargas,no_kk'],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        KartuKeluarga::create($request->all());

        return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kartuKeluarga = KartuKeluarga::findOrFail($id);
        return view('master.kartu_keluarga.edit', compact('kartuKeluarga'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kk' => ['required', 'string', 'max:16', 'unique:kartu_keluargas,no_kk,' . $id],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        $kartuKeluarga = KartuKeluarga::findOrFail($id);
        $kartuKeluarga->update($request->all());

        return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kartuKeluarga = KartuKeluarga::findOrFail($id);
        if ($kartuKeluarga->balitas()->count() > 0) {
            return redirect()->route('kartu_keluarga.index')->with('error', 'Kartu Keluarga tidak dapat dihapus karena masih memiliki data balita terkait.');
        }
        $kartuKeluarga->delete();

        return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil dihapus.');
    }
}