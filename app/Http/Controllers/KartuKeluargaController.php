<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class KartuKeluargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id');
        $kelurahan_id = $request->query('kelurahan_id');
        $search = $request->query('search');

        $query = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas', 'createdBy'])->withCount('balitas');

        if ($kecamatan_id) {
            $query->where('kecamatan_id', $kecamatan_id);
        }

        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('CAST(AES_DECRYPT(no_kk, ?) AS CHAR) LIKE ?', [config('app.key'), '%' . $search . '%'])
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $kartuKeluargas = $query->paginate(10)->appends($request->query());
        $kecamatans = Kecamatan::all();

        return view('master.kartu_keluarga.index', compact('kartuKeluargas', 'kecamatans', 'kecamatan_id', 'kelurahan_id', 'search'));
    }

    public function show($id)
    {
        $kartuKeluarga = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas', 'ibu', 'createdBy'])->findOrFail($id);
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
            'no_kk' => ['required', 'numeric', 'digits_between:1,16', 'unique:kartu_keluargas,no_kk'],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        try {
            KartuKeluarga::create(array_merge($request->all(), ['created_by' => Auth::id()]));
            return redirect()->route('kartu_keluarga.index')->with('success', 'Data Kartu Keluarga berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data Kartu Keluarga: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Kartu Keluarga: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kartuKeluarga = KartuKeluarga::with('createdBy')->findOrFail($id);
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::where('kecamatan_id', $kartuKeluarga->kecamatan_id)->get();
        return view('master.kartu_keluarga.edit', compact('kartuKeluarga', 'kecamatans', 'kelurahans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kk' => ['required', 'numeric', 'digits_between:1,16', 'unique:kartu_keluargas,no_kk,' . $id],
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
            $kartuKeluarga->update(array_merge($request->all(), ['created_by' => Auth::id()]));
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

    public function getIbuAndBalita($kartu_keluarga_id)
    {
        try {
            $kartuKeluarga = KartuKeluarga::with(['ibu', 'balitas'])->find($kartu_keluarga_id);
            if (!$kartuKeluarga) {
                return response()->json(['error' => 'Kartu Keluarga tidak ditemukan'], 404);
            }
            return response()->json([
                'ibus' => $kartuKeluarga->ibu->map(function ($ibu) {
                    return ['id' => $ibu->id, 'nama' => $ibu->nama];
                })->toArray(),
                'balitas' => $kartuKeluarga->balitas->map(function ($balita) {
                    return ['id' => $balita->id, 'nama' => $balita->nama];
                })->toArray(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching ibu and balita for kartu_keluarga_id: ' . $kartu_keluarga_id . ' - ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data ibu dan balita'], 500);
        }
    }
}