<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanKartuKeluargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kelurahan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $kelurahan_id = $user->kelurahan_id;
        $kecamatan_id = $user->kecamatan_id;

        if (!$kelurahan_id || !$kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $search = $request->query('search');

        // Query untuk KartuKeluarga
        $query = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas', 'createdBy'])
            ->withCount('balitas')
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $kartuKeluargas = $query->paginate(10)->appends($request->query());
        $kecamatan = Kecamatan::find($kecamatan_id);
        $kelurahan = Kelurahan::find($kelurahan_id);

        return view('kelurahan.kartu_keluarga.index', compact('kartuKeluargas', 'kecamatan', 'kelurahan', 'search'));
    }

     public function show($id)
    {
        $kartuKeluarga = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas', 'ibu', 'createdBy'])->findOrFail($id);
        return view('kelurahan.kartu_keluarga.show', compact('kartuKeluarga'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kecamatan = Kecamatan::find($user->kecamatan_id);
        $kelurahan = Kelurahan::find($user->kelurahan_id);
        return view('kelurahan.kartu_keluarga.create', compact('kecamatan', 'kelurahan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

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
            KartuKeluarga::create(array_merge($request->all(), ['created_by' => $user->id]));
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('success', 'Data kartu keluarga berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data kartu keluarga: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data kartu keluarga: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kartuKeluarga = KartuKeluarga::with('createdBy')
            ->where('kelurahan_id', $user->kelurahan_id)
            ->findOrFail($id);
        $kecamatan = Kecamatan::find($user->kecamatan_id);
        $kelurahan = Kelurahan::find($user->kelurahan_id);

        return view('kelurahan.kartu_keluarga.edit', compact('kartuKeluarga', 'kecamatan', 'kelurahan'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

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
            $kartuKeluarga = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            $kartuKeluarga->update(array_merge($request->all(), ['created_by' => $user->id]));
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('success', 'Data kartu keluarga berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data kartu keluarga: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data kartu keluarga: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $kartuKeluarga = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($kartuKeluarga->balitas()->count() > 0) {
                return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Kartu keluarga tidak dapat dihapus karena masih memiliki data balita terkait.');
            }
            if ($kartuKeluarga->ibu()->count() > 0) {
                return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Kartu keluarga tidak dapat dihapus karena masih memiliki data ibu terkait.');
            }
            $kartuKeluarga->delete();
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('success', 'Data kartu keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data kartu keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Gagal menghapus data kartu keluarga: ' . $e->getMessage());
        }
    }

    public function getByKecamatanKelurahan(Request $request)
    {
        $user = Auth::user();
        $kelurahan_id = $user->kelurahan_id;

        if (!$kelurahan_id) {
            return response()->json(['error' => 'Admin kelurahan tidak terkait dengan kelurahan.'], 403);
        }

        $query = KartuKeluarga::where('status', 'Aktif')
            ->where('kelurahan_id', $kelurahan_id);

        $kartuKeluargas = $query->get(['id', 'no_kk', 'kepala_keluarga']);

        return response()->json($kartuKeluargas);
    }

    public function getIbuAndBalita($kartu_keluarga_id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return response()->json(['error' => 'Admin kelurahan tidak terkait dengan kelurahan.'], 403);
        }

        try {
            $kartuKeluarga = KartuKeluarga::with(['ibu', 'balitas'])
                ->where('kelurahan_id', $user->kelurahan_id)
                ->find($kartu_keluarga_id);
            if (!$kartuKeluarga) {
                return response()->json(['error' => 'Kartu keluarga tidak ditemukan'], 404);
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
            Log::error('Gagal memuat data ibu dan balita untuk kartu_keluarga_id: ' . $kartu_keluarga_id . ' - ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data ibu dan balita'], 500);
        }
    }
}