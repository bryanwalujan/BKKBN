<?php

namespace App\Http\Controllers;

use App\Models\Stunting;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KelurahanStuntingController extends Controller
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

        $query = Stunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $stuntings = $query->paginate(10)->appends(['search' => $search]);
        $totalData = $stuntings->total();

        return view('kelurahan.stunting.index', compact('stuntings', 'search', 'totalData'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kecamatan = Kecamatan::where('id', $user->kecamatan_id)->first();
        $kelurahan = Kelurahan::where('id', $user->kelurahan_id)->first();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get();

        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kelurahan.kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum menambah data stunting.');
        }
        if (!$kecamatan || !$kelurahan) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Data kecamatan atau kelurahan tidak ditemukan.');
        }

        return view('kelurahan.stunting.create', compact('kartuKeluargas', 'kecamatan', 'kelurahan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id . ',kelurahan_id,' . $user->kelurahan_id],
            'nik' => ['nullable', 'string', 'max:255', 'unique:stuntings,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $data = $request->except(['kecamatan_id', 'kelurahan_id']);
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['created_by'] = Auth::id();

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('stunting_fotos', 'public');
            }

            Log::info('Menyimpan data stunting ke stuntings', ['data' => $data]);
            Stunting::create($data);

            return redirect()->route('kelurahan.stunting.index')->with('success', 'Data stunting berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data stunting: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data stunting: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $stunting = Stunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $user->kelurahan_id)
            ->findOrFail($id);

        $kecamatan = Kecamatan::where('id', $user->kecamatan_id)->first();
        $kelurahan = Kelurahan::where('id', $user->kelurahan_id)->first();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get();

        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kelurahan.kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum mengedit data stunting.');
        }
        if (!$kecamatan || !$kelurahan) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Data kecamatan atau kelurahan tidak ditemukan.');
        }

        $beratTinggi = explode('/', $stunting->berat_tinggi ?? '0/0');
        $tanggalLahir = $stunting->tanggal_lahir ? \Carbon\Carbon::parse($stunting->tanggal_lahir)->format('Y-m-d') : null;

        Log::info('Edit Stunting', [
            'id' => $id,
            'tanggal_lahir_raw' => $stunting->tanggal_lahir,
            'tanggal_lahir_formatted' => $tanggalLahir,
        ]);

        return view('kelurahan.stunting.edit', compact('stunting', 'kartuKeluargas', 'kecamatan', 'kelurahan', 'beratTinggi', 'tanggalLahir'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id . ',kelurahan_id,' . $user->kelurahan_id],
            'nik' => ['nullable', 'string', 'max:255', 'unique:stuntings,nik,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $stunting = Stunting::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            $data = $request->except(['kecamatan_id', 'kelurahan_id']);
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['created_by'] = Auth::id();

            if ($request->hasFile('foto')) {
                if ($stunting->foto) {
                    Storage::disk('public')->delete($stunting->foto);
                }
                $data['foto'] = $request->file('foto')->store('stunting_fotos', 'public');
            }

            Log::info('Memperbarui data stunting di stuntings', ['id' => $id, 'data' => $data]);
            $stunting->update($data);

            return redirect()->route('kelurahan.stunting.index')->with('success', 'Data stunting berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data stunting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data stunting: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $stunting = Stunting::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($stunting->foto) {
                Storage::disk('public')->delete($stunting->foto);
            }
            $stunting->delete();

            return redirect()->route('kelurahan.stunting.index')->with('success', 'Data stunting berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data stunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Gagal menghapus data stunting: ' . $e->getMessage());
        }
    }
}