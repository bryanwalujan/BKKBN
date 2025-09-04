<?php
namespace App\Http\Controllers;

use App\Models\IbuNifas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IbuNifasController extends Controller
{
    public function index()
    {
        $ibuNifas = IbuNifas::all();
        return view('master.ibu_nifas.index', compact('ibuNifas'));
    }

    public function create()
    {
        return view('master.ibu_nifas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ibu_nifas_fotos', 'public');
        }

        IbuNifas::create($data);

        return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ibuNifas = IbuNifas::findOrFail($id);
        return view('master.ibu_nifas.edit', compact('ibuNifas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $ibuNifas = IbuNifas::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($ibuNifas->foto) {
                Storage::disk('public')->delete($ibuNifas->foto);
            }
            $data['foto'] = $request->file('foto')->store('ibu_nifas_fotos', 'public');
        }

        $ibuNifas->update($data);

        return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ibuNifas = IbuNifas::findOrFail($id);
        if ($ibuNifas->foto) {
            Storage::disk('public')->delete($ibuNifas->foto);
        }
        $ibuNifas->delete();

        return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil dihapus.');
    }
}