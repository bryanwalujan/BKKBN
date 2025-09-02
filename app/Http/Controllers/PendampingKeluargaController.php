<?php
namespace App\Http\Controllers;

use App\Models\PendampingKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendampingKeluargaController extends Controller
{
    public function index()
    {
        $pendampingKeluargas = PendampingKeluarga::all();
        return view('master.pendamping_keluarga.index', compact('pendampingKeluargas'));
    }

    public function create()
    {
        return view('master.pendamping_keluarga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peran' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'tahun_bergabung' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pendamping_fotos', 'public');
        }

        PendampingKeluarga::create($data);

        return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pendampingKeluarga = PendampingKeluarga::findOrFail($id);
        return view('master.pendamping_keluarga.edit', compact('pendampingKeluarga'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peran' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'tahun_bergabung' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $pendampingKeluarga = PendampingKeluarga::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($pendampingKeluarga->foto) {
                Storage::disk('public')->delete($pendampingKeluarga->foto);
            }
            $data['foto'] = $request->file('foto')->store('pendamping_fotos', 'public');
        }

        $pendampingKeluarga->update($data);

        return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendampingKeluarga = PendampingKeluarga::findOrFail($id);
        if ($pendampingKeluarga->foto) {
            Storage::disk('public')->delete($pendampingKeluarga->foto);
        }
        $pendampingKeluarga->delete();

        return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil dihapus.');
    }
}