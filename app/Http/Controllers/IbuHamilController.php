<?php
namespace App\Http\Controllers;

use App\Models\IbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IbuHamilController extends Controller
{
    public function index()
    {
        $ibuHamils = IbuHamil::all();
        return view('master.ibu_hamil.index', compact('ibuHamils'));
    }

    public function create()
    {
        return view('master.ibu_hamil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ibu_hamil_fotos', 'public');
        }

        IbuHamil::create($data);

        return redirect()->route('ibu_hamil.index')->with('success', 'Data ibu hamil berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ibuHamil = IbuHamil::findOrFail($id);
        return view('master.ibu_hamil.edit', compact('ibuHamil'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $ibuHamil = IbuHamil::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($ibuHamil->foto) {
                Storage::disk('public')->delete($ibuHamil->foto);
            }
            $data['foto'] = $request->file('foto')->store('ibu_hamil_fotos', 'public');
        }

        $ibuHamil->update($data);

        return redirect()->route('ibu_hamil.index')->with('success', 'Data ibu hamil berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ibuHamil = IbuHamil::findOrFail($id);
        if ($ibuHamil->foto) {
            Storage::disk('public')->delete($ibuHamil->foto);
        }
        $ibuHamil->delete();

        return redirect()->route('ibu_hamil.index')->with('success', 'Data ibu hamil berhasil dihapus.');
    }
}