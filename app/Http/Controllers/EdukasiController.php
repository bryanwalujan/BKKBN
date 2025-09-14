<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasis = Edukasi::orderBy('created_at', 'desc')->get();
        return view('master.edukasi.index', compact('edukasis'));
    }

    public function create()
    {
        return view('master.edukasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'penyebaran_informasi_media' => ['nullable', 'string'],
            'konseling_perubahan_perilaku' => ['nullable', 'string'],
            'konseling_pengasuhan' => ['nullable', 'string'],
            'paud' => ['nullable', 'string'],
            'konseling_kesehatan_reproduksi' => ['nullable', 'string'],
            'ppa' => ['nullable', 'string'],
            'modul_buku_saku' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status_aktif' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('edukasi', 'public');
        }

        Edukasi::create($validated);

        return redirect()->route('edukasi.index')->with('success', 'Data edukasi berhasil ditambahkan.');
    }

    public function edit(Edukasi $edukasi)
    {
        return view('master.edukasi.edit', compact('edukasi'));
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'penyebaran_informasi_media' => ['nullable', 'string'],
            'konseling_perubahan_perilaku' => ['nullable', 'string'],
            'konseling_pengasuhan' => ['nullable', 'string'],
            'paud' => ['nullable', 'string'],
            'konseling_kesehatan_reproduksi' => ['nullable', 'string'],
            'ppa' => ['nullable', 'string'],
            'modul_buku_saku' => ['nullable', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status_aktif' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($edukasi->gambar) {
                Storage::disk('public')->delete($edukasi->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('edukasi', 'public');
        } else {
            $validated['gambar'] = $edukasi->gambar;
        }

        $edukasi->update($validated);

        return redirect()->route('edukasi.index')->with('success', 'Data edukasi berhasil diperbarui.');
    }

    public function destroy(Edukasi $edukasi)
    {
        if ($edukasi->gambar) {
            Storage::disk('public')->delete($edukasi->gambar);
        }
        $edukasi->delete();

        return redirect()->route('edukasi.index')->with('success', 'Data edukasi berhasil dihapus.');
    }

    public function refresh(Request $request)
    {
        Edukasi::truncate();
        Storage::disk('public')->deleteDirectory('edukasi');
        return redirect()->route('edukasi.index')->with('success', 'Data edukasi telah di-refresh.');
    }
}