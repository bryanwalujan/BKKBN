<?php
namespace App\Http\Controllers;

use App\Models\Genting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GentingController extends Controller
{
    public function index()
    {
        $gentings = Genting::all();
        return view('master.genting.index', compact('gentings'));
    }

    public function create()
    {
        return view('master.genting.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'sasaran' => ['required', 'string', 'max:255'],
            'jenis_intervensi' => ['required', 'string', 'max:255'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $data = $request->all();

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('genting_dokumentasi', 'public');
        }

        Genting::create($data);

        return redirect()->route('genting.index')->with('success', 'Data kegiatan Genting berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $genting = Genting::findOrFail($id);
        return view('master.genting.edit', compact('genting'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'sasaran' => ['required', 'string', 'max:255'],
            'jenis_intervensi' => ['required', 'string', 'max:255'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        $genting = Genting::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('dokumentasi')) {
            if ($genting->dokumentasi) {
                Storage::disk('public')->delete($genting->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('genting_dokumentasi', 'public');
        }

        $genting->update($data);

        return redirect()->route('genting.index')->with('success', 'Data kegiatan Genting berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $genting = Genting::findOrFail($id);
        if ($genting->dokumentasi) {
            Storage::disk('public')->delete($genting->dokumentasi);
        }
        $genting->delete();

        return redirect()->route('genting.index')->with('success', 'Data kegiatan Genting berhasil dihapus.');
    }
}