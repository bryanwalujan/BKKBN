<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class EdukasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Edukasi::query();

        // Filter berdasarkan pencarian
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan status
        if ($request->status && $request->status !== 'all') {
            $query->where('status_aktif', $request->status === 'active' ? 1 : 0);
        }

        $edukasis = $query->orderBy('created_at', 'desc')->get();

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
    try {

        // Log untuk debugging
        Log::info('Attempting to delete edukasi with ID: ' . $edukasi->id);
        
        // Simpan informasi file untuk dihapus
        $gambarPath = $edukasi->gambar;
        $filePath = $edukasi->file;
        $edukasiId = $edukasi->id;
        
        // Hapus data dari database
        $edukasi->delete();
        
        // Hapus file gambar jika ada
        if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
            Storage::disk('public')->delete($gambarPath);
            Log::info('Deleted image file: ' . $gambarPath);
        }
        
        // Hapus file dokumen jika ada
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            Log::info('Deleted document file: ' . $filePath);
        }
        
        Log::info('Successfully deleted edukasi with ID: ' . $edukasiId);
        
        return redirect()->route('edukasi.index')
                       ->with('success', 'Data edukasi berhasil dihapus.');
                       
    } catch (\Illuminate\Database\QueryException $e) {
        // Tangani error terkait database (misalnya, foreign key constraints)
        Log::error('Database error deleting edukasi: ' . $e->getMessage(), [
            'edukasi_id' => $edukasi->id,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('edukasi.index')
                       ->with('error', 'Gagal menghapus data edukasi karena ada ketergantungan data: ' . $e->getMessage());
    } catch (\Exception $e) {
        // Tangani error umum
        Log::error('Error deleting edukasi: ' . $e->getMessage(), [
            'edukasi_id' => $edukasi->id,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('edukasi.index')
                       ->with('error', 'Gagal menghapus data edukasi: ' . $e->getMessage());
    }
}

    public function refresh(Request $request)
    {
        try {
            Edukasi::truncate();
            Storage::disk('public')->deleteDirectory('edukasi');
            Storage::disk('public')->deleteDirectory('edukasi_files');
            
            return redirect()->route('edukasi.index')
                           ->with('success', 'Data edukasi telah di-refresh.');
                           
        } catch (Exception $e) {
            Log::error('Error refreshing edukasi data: ' . $e->getMessage());
            
            return redirect()->route('edukasi.index')
                           ->with('error', 'Gagal me-refresh data edukasi: ' . $e->getMessage());
        }
    }
}