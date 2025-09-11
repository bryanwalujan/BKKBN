<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KartuKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id');
        $kelurahan_id = $request->query('kelurahan_id');
        $search = $request->query('search');

        $query = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas'])->withCount('balitas');

        if ($kecamatan_id) {
            $query->where('kecamatan_id', $kecamatan_id);
        }

        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $kartuKeluargas = $query->paginate(10)->appends($request->query());
        $kecamatans = Kecamatan::all();

        return view('master.kartu_keluarga.index', compact('kartuKeluargas', 'kecamatans', 'kecamatan_id', 'kelurahan_id', 'search'));
    }

    public function show($id)
    {
        $kartuKeluarga = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas', 'ibu', 'remajaPutris'])->findOrFail($id);
        return view('master.kartu_keluarga.show', compact('kartuKeluarga'));
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
        $kelurahans = Kelurahan::where('kecamatan_id', $kartuKeluarga->kecamatan_id)->get();
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
            if ($kartuKeluarga->remajaPutris()->count() > 0) {
                return redirect()->route('kartu_keluarga.index')->with('error', 'Kartu Keluarga tidak dapat dihapus karena masih memiliki data remaja putri terkait.');
            }
            $kartuKeluarga->delete();
            return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data Kartu Keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kartu_keluarga.index')->with('error', 'Gagal menghapus data Kartu Keluarga: ' . $e->getMessage());
        }
    }

    public function getByKecamatanKelurahan(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id');
        $kelurahan_id = $request->query('kelurahan_id');

        $query = KartuKeluarga::where('status', 'Aktif');

        if ($kecamatan_id) {
            $query->where('kecamatan_id', $kecamatan_id);
        }

        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }

        $kartuKeluargas = $query->get(['id', 'no_kk', 'kepala_keluarga']);

        return response()->json($kartuKeluargas);
    }
}