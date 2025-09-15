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
            'kategori' => ['required', 'in:' . implode(',', array_keys(\App\Models\Edukasi::KATEGORI))],
            'deskripsi' => ['nullable', 'string'],
            'tautan' => ['nullable', 'url'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // Maks 5MB
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status_aktif' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('edukasi', 'public');
        }

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('edukasi_files', 'public');
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
            'kategori' => ['required', 'in:' . implode(',', array_keys(\App\Models\Edukasi::KATEGORI))],
            'deskripsi' => ['nullable', 'string'],
            'tautan' => ['nullable', 'url'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
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

        if ($request->hasFile('file')) {
            if ($edukasi->file) {
                Storage::disk('public')->delete($edukasi->file);
            }
            $validated['file'] = $request->file('file')->store('edukasi_files', 'public');
        } else {
            $validated['file'] = $edukasi->file;
        }

        $edukasi->update($validated);

        return redirect()->route('edukasi.index')->with('success', 'Data edukasi berhasil diperbarui.');
    }

    public function destroy(Edukasi $edukasi)
    {
        if ($edukasi->gambar) {
            Storage::disk('public')->delete($edukasi->gambar);
        }
        if ($edukasi->file) {
            Storage::disk('public')->delete($edukasi->file);
        }
        $edukasi->delete();

        return redirect()->route('edukasi.index')->with('success', 'Data edukasi berhasil dihapus.');
    }

    public function refresh(Request $request)
    {
        Edukasi::truncate();
        Storage::disk('public')->deleteDirectory('edukasi');
        Storage::disk('public')->deleteDirectory('edukasi_files');
        return redirect()->route('edukasi.index')->with('success', 'Data edukasi telah di-refresh.');
    }
}