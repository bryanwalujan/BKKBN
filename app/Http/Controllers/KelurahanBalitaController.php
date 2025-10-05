<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanBalitaController extends Controller
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

        if (!$kelurahan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $search = $request->query('search');
        $kategoriUmur = $request->query('kategori_umur');

        // Query untuk Balita
        $query = Balita::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($kategoriUmur && in_array($kategoriUmur, ['Baduata', 'Balita'])) {
            $query->where('kategori_umur', $kategoriUmur);
        }

        $balitas = $query->paginate(10)->appends($request->query());

        return view('kelurahan.balita.index', compact('balitas', 'kategoriUmur', 'search'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        return view('kelurahan.balita.create', compact('kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'unique:balitas,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'lingkar_lengan' => ['nullable', 'numeric', 'min:0'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $data = $request->all();
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
            }

            Log::info('Menyimpan data balita ke balitas', ['data' => $data]);
            Balita::create($data);

            return redirect()->route('kelurahan.balita.index')->with('success', 'Data balita berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data balita: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data balita: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $balita = Balita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $beratTinggi = explode('/', $balita->berat_tinggi ?? '0/0');
        $tanggalLahir = $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('Y-m-d') : null;

        Log::info('Edit Balita', [
            'id' => $id,
            'tanggal_lahir_raw' => $balita->tanggal_lahir,
            'tanggal_lahir_formatted' => $tanggalLahir,
        ]);

        return view('kelurahan.balita.edit', compact('balita', 'kartuKeluargas', 'beratTinggi', 'tanggalLahir'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'unique:balitas,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'lingkar_lengan' => ['nullable', 'numeric', 'min:0'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $balita = Balita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            $data = $request->all();
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;

            if ($request->hasFile('foto')) {
                if ($balita->foto && Storage::disk('public')->exists($balita->foto)) {
                    Storage::disk('public')->delete($balita->foto);
                }
                $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
            }

            Log::info('Memperbarui data balita di balitas', ['id' => $id, 'data' => $data]);
            $balita->update($data);

            return redirect()->route('kelurahan.balita.index')->with('success', 'Data balita berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data balita: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data balita: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $balita = Balita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($balita->foto && Storage::disk('public')->exists($balita->foto)) {
                Storage::disk('public')->delete($balita->foto);
            }
            $balita->delete();

            return redirect()->route('kelurahan.balita.index')->with('success', 'Data balita berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.balita.index')->with('error', 'Gagal menghapus data balita: ' . $e->getMessage());
        }
    }

    public function getKartuKeluarga(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return response()->json(['error' => 'Admin kelurahan tidak terkait dengan kelurahan.'], 403);
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        return response()->json($kartuKeluargas);
    }
}