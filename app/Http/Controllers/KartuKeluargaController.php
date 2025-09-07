<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        $kartuKeluargas = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas'])->withCount('balitas')->paginate(10);
        return view('master.kartu_keluarga.index', compact('kartuKeluargas'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        return view('master.kartu_keluarga.create', compact('kecamatans', 'kelurahans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => ['required', 'string', 'max:16', 'unique:kartu_keluargas,no_kk'],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        try {
            KartuKeluarga::create($request->all());
            return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data Kartu Keluarga: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Kartu Keluarga: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kartuKeluarga = KartuKeluarga::findOrFail($id);
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        return view('master.kartu_keluarga.edit', compact('kartuKeluarga', 'kecamatans', 'kelurahans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kk' => ['required', 'string', 'max:16', 'unique:kartu_keluargas,no_kk,' . $id],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        try {
            $kartuKeluarga = KartuKeluarga::findOrFail($id);
            $kartuKeluarga->update($request->all());
            return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data Kartu Keluarga: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data Kartu Keluarga: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kartuKeluarga = KartuKeluarga::findOrFail($id);
            if ($kartuKeluarga->balitas()->count() > 0) {
                return redirect()->route('kartu_keluarga.index')->with('error', 'Kartu Keluarga tidak dapat dihapus karena masih memiliki data balita terkait.');
            }
            if ($kartuKeluarga->ibu()->count() > 0) {
                return redirect()->route('kartu_keluarga.index')->with('error', 'Kartu Keluarga tidak dapat dihapus karena masih memiliki data ibu terkait.');
            }
            $kartuKeluarga->delete();
            return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data Kartu Keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kartu_keluarga.index')->with('error', 'Gagal menghapus data Kartu Keluarga: ' . $e->getMessage());
        }
    }
}