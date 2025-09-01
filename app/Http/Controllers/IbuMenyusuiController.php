<?php
namespace App\Http\Controllers;

use App\Models\IbuMenyusui;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IbuMenyusuiController extends Controller
{
    public function index()
    {
        $ibuMenyusuis = IbuMenyusui::all();
        return view('master.ibu_menyusui.index', compact('ibuMenyusuis'));
    }

    public function create()
    {
        return view('master.ibu_menyusui.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'status_menyusui' => ['required', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ibu_menyusui_fotos', 'public');
        }

        IbuMenyusui::create($data);

        return redirect()->route('ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ibuMenyusui = IbuMenyusui::findOrFail($id);
        return view('master.ibu_menyusui.edit', compact('ibuMenyusui'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'status_menyusui' => ['required', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $ibuMenyusui = IbuMenyusui::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($ibuMenyusui->foto) {
                Storage::disk('public')->delete($ibuMenyusui->foto);
            }
            $data['foto'] = $request->file('foto')->store('ibu_menyusui_fotos', 'public');
        }

        $ibuMenyusui->update($data);

        return redirect()->route('ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ibuMenyusui = IbuMenyusui::findOrFail($id);
        if ($ibuMenyusui->foto) {
            Storage::disk('public')->delete($ibuMenyusui->foto);
        }
        $ibuMenyusui->delete();

        return redirect()->route('ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil dihapus.');
    }
}