<?php
namespace App\Http\Controllers;

use App\Models\RemajaPutri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RemajaPutriController extends Controller
{
    public function index()
    {
        $remajaPutris = RemajaPutri::all();
        return view('master.remaja_putri.index', compact('remajaPutris'));
    }

    public function create()
    {
        return view('master.remaja_putri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('remaja_putri_fotos', 'public');
        }

        RemajaPutri::create($data);

        return redirect()->route('remaja_putri.index')->with('success', 'Data remaja putri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $remajaPutri = RemajaPutri::findOrFail($id);
        return view('master.remaja_putri.edit', compact('remajaPutri'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        $remajaPutri = RemajaPutri::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($remajaPutri->foto) {
                Storage::disk('public')->delete($remajaPutri->foto);
            }
            $data['foto'] = $request->file('foto')->store('remaja_putri_fotos', 'public');
        }

        $remajaPutri->update($data);

        return redirect()->route('remaja_putri.index')->with('success', 'Data remaja putri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $remajaPutri = RemajaPutri::findOrFail($id);
        if ($remajaPutri->foto) {
            Storage::disk('public')->delete($remajaPutri->foto);
        }
        $remajaPutri->delete();

        return redirect()->route('remaja_putri.index')->with('success', 'Data remaja putri berhasil dihapus.');
    }
}