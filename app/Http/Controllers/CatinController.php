<?php

namespace App\Http\Controllers;

use App\Models\Catin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CatinController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Catin::with('user'); // Load relasi user

        if ($search) {
            $query->where('catin_wanita_nama', 'like', '%' . $search . '%')
                  ->orWhere('catin_pria_nama', 'like', '%' . $search . '%');
        }

        $catins = $query->paginate(10)->appends(['search' => $search]);
        return view('master.catin.index', compact('catins', 'search'));
    }

    public function create()
    {
        return view('master.catin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari_tanggal' => ['nullable', 'date'],
            'catin_wanita_nama' => ['nullable', 'string', 'max:255'],
            'catin_wanita_nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'catin_wanita_tempat_lahir' => ['nullable', 'string', 'max:255'],
            'catin_wanita_tgl_lahir' => ['nullable', 'date'],
            'catin_wanita_no_hp' => ['nullable', 'string', 'max:15', 'regex:/^\+?[0-9]{10,15}$/'],
            'catin_wanita_alamat' => ['nullable', 'string'],
            'catin_pria_nama' => ['nullable', 'string', 'max:255'],
            'catin_pria_nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'catin_pria_tempat_lahir' => ['nullable', 'string', 'max:255'],
            'catin_pria_tgl_lahir' => ['nullable', 'date'],
            'catin_pria_no_hp' => ['nullable', 'string', 'max:15', 'regex:/^\+?[0-9]{10,15}$/'],
            'catin_pria_alamat' => ['nullable', 'string'],
            'tanggal_pernikahan' => ['nullable', 'date'],
            'berat_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:0'],
            'imt' => ['nullable', 'numeric', 'min:0'],
            'kadar_hb' => ['nullable', 'numeric', 'min:0'],
            'merokok' => ['nullable', 'in:Ya,Tidak'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = auth()->id();
            if ($data['berat_badan'] && $data['tinggi_badan']) {
                $tinggiMeter = $data['tinggi_badan'] / 100;
                $data['imt'] = round($data['berat_badan'] / ($tinggiMeter * $tinggiMeter), 1);
            }
            Catin::create($data);
            return redirect()->route('catin.index')->with('success', 'Data calon pengantin berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data calon pengantin: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data calon pengantin: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $catin = Catin::findOrFail($id);
        return view('master.catin.edit', compact('catin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari_tanggal' => ['nullable', 'date'],
            'catin_wanita_nama' => ['nullable', 'string', 'max:255'],
            'catin_wanita_nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'catin_wanita_tempat_lahir' => ['nullable', 'string', 'max:255'],
            'catin_wanita_tgl_lahir' => ['nullable', 'date'],
            'catin_wanita_no_hp' => ['nullable', 'string', 'max:15', 'regex:/^\+?[0-9]{10,15}$/'],
            'catin_wanita_alamat' => ['nullable', 'string'],
            'catin_pria_nama' => ['nullable', 'string', 'max:255'],
            'catin_pria_nik' => ['nullable', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'catin_pria_tempat_lahir' => ['nullable', 'string', 'max:255'],
            'catin_pria_tgl_lahir' => ['nullable', 'date'],
            'catin_pria_no_hp' => ['nullable', 'string', 'max:15', 'regex:/^\+?[0-9]{10,15}$/'],
            'catin_pria_alamat' => ['nullable', 'string'],
            'tanggal_pernikahan' => ['nullable', 'date'],
            'berat_badan' => ['nullable', 'numeric', 'min:0'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:0'],
            'imt' => ['nullable', 'numeric', 'min:0'],
            'kadar_hb' => ['nullable', 'numeric', 'min:0'],
            'merokok' => ['nullable', 'in:Ya,Tidak'],
        ]);

        try {
            $catin = Catin::findOrFail($id);
            $data = $request->all();
            $data['created_by'] = auth()->id();
            if ($data['berat_badan'] && $data['tinggi_badan']) {
                $tinggiMeter = $data['tinggi_badan'] / 100;
                $data['imt'] = round($data['berat_badan'] / ($tinggiMeter * $tinggiMeter), 1);
            }
            $catin->update($data);
            return redirect()->route('catin.index')->with('success', 'Data calon pengantin berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data calon pengantin: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data calon pengantin: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $catin = Catin::findOrFail($id);
            $catin->delete();
            return redirect()->route('catin.index')->with('success', 'Data calon pengantin berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data calon pengantin: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('catin.index')->with('error', 'Gagal menghapus data calon pengantin: ' . $e->getMessage());
        }
    }
}