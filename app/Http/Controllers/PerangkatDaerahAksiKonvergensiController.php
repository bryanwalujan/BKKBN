<?php

namespace App\Http\Controllers;

use App\Models\AksiKonvergensi;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PerangkatDaerahAksiKonvergensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:perangkat_daerah');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('dashboard')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $search = $request->query('search');
        $query = AksiKonvergensi::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            });

        if ($search) {
            $query->where('nama_aksi', 'like', '%' . $search . '%');
        }

        $aksiKonvergensis = $query->orderBy('created_at', 'desc')->paginate(10)->appends(['search' => $search]);
        return view('perangkat_daerah.aksi_konvergensi.index', compact('aksiKonvergensis', 'search'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $kecamatans = Kecamatan::where('id', $user->kecamatan_id)->get(['id', 'nama_kecamatan']);
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get(['id', 'nama_kelurahan']);
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        if ($kartuKeluargas->isEmpty() || $kelurahans->isEmpty() || $kecamatans->isEmpty()) {
            Log::warning('Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan untuk kecamatan_id: ' . $user->kecamatan_id, ['user_id' => $user->id]);
            return view('perangkat_daerah.aksi_konvergensi.create', compact('kecamatans', 'kelurahans', 'kartuKeluargas'))
                ->with('error', 'Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan yang tersedia.');
        }

        return view('perangkat_daerah.aksi_konvergensi.create', compact('kecamatans', 'kelurahans', 'kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id,kecamatan_id,' . $user->kecamatan_id],
            'nama_aksi' => ['required', 'string', 'max:255'],
            'selesai' => ['nullable', 'boolean'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:2050'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
            'air_bersih_sanitasi' => ['nullable', 'in:ada-baik,ada-buruk,tidak'],
            'akses_layanan_kesehatan_kb' => ['nullable', 'in:ada,tidak'],
            'pendidikan_pengasuhan_ortu' => ['nullable', 'in:ada,tidak'],
            'edukasi_kesehatan_remaja' => ['nullable', 'in:ada,tidak'],
            'kesadaran_pengasuhan_gizi' => ['nullable', 'in:ada,tidak'],
            'akses_pangan_bergizi' => ['nullable', 'in:ada,tidak'],
            'makanan_ibu_hamil' => ['nullable', 'in:ada,tidak'],
            'tablet_tambah_darah' => ['nullable', 'in:ada,tidak'],
            'inisiasi_menyusui_dini' => ['nullable', 'in:ada,tidak'],
            'asi_eksklusif' => ['nullable', 'in:ada,tidak'],
            'asi_mpasi' => ['nullable', 'in:ada,tidak'],
            'imunisasi_lengkap' => ['nullable', 'in:ada,tidak'],
            'pencegahan_infeksi' => ['nullable', 'in:ada,tidak'],
            'status_gizi_ibu' => ['nullable', 'in:baik,buruk'],
            'penyakit_menular' => ['nullable', 'in:tidak,ada'],
            'jenis_penyakit' => ['required_if:penyakit_menular,ada', 'string', 'max:255', 'nullable'],
            'kesehatan_lingkungan' => ['nullable', 'in:baik,buruk'],
            'narasi' => ['nullable', 'string'],
            'pelaku_aksi' => ['nullable', 'string', 'max:255'],
            'waktu_pelaksanaan' => ['nullable', 'date'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = $user->id;
            $data['selesai'] = $request->has('selesai');

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
            }

            $aksiKonvergensi = AksiKonvergensi::create($data);
            Log::info('Data Aksi Konvergensi berhasil ditambahkan.', ['id' => $aksiKonvergensi->id, 'user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data Aksi Konvergensi: ' . $e->getMessage(), ['data' => $request->all(), 'user_id' => $user->id]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Aksi Konvergensi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $aksiKonvergensi = AksiKonvergensi::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->findOrFail($id);

        return view('perangkat_daerah.aksi_konvergensi.show', compact('aksiKonvergensi'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $aksiKonvergensi = AksiKonvergensi::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->findOrFail($id);

        $kecamatans = Kecamatan::where('id', $user->kecamatan_id)->get(['id', 'nama_kecamatan']);
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get(['id', 'nama_kelurahan']);
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        if ($kartuKeluargas->isEmpty() || $kelurahans->isEmpty() || $kecamatans->isEmpty()) {
            Log::warning('Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan untuk kecamatan_id: ' . $user->kecamatan_id, ['user_id' => $user->id]);
            return view('perangkat_daerah.aksi_konvergensi.edit', compact('aksiKonvergensi', 'kecamatans', 'kelurahans', 'kartuKeluargas'))
                ->with('error', 'Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan yang tersedia.');
        }

        return view('perangkat_daerah.aksi_konvergensi.edit', compact('aksiKonvergensi', 'kecamatans', 'kelurahans', 'kartuKeluargas'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id,kecamatan_id,' . $user->kecamatan_id],
            'nama_aksi' => ['required', 'string', 'max:255'],
            'selesai' => ['nullable', 'boolean'],
            'tahun' => ['required', 'integer', 'min:2000', 'max:2050'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
            'air_bersih_sanitasi' => ['nullable', 'in:ada-baik,ada-buruk,tidak'],
            'akses_layanan_kesehatan_kb' => ['nullable', 'in:ada,tidak'],
            'pendidikan_pengasuhan_ortu' => ['nullable', 'in:ada,tidak'],
            'edukasi_kesehatan_remaja' => ['nullable', 'in:ada,tidak'],
            'kesadaran_pengasuhan_gizi' => ['nullable', 'in:ada,tidak'],
            'akses_pangan_bergizi' => ['nullable', 'in:ada,tidak'],
            'makanan_ibu_hamil' => ['nullable', 'in:ada,tidak'],
            'tablet_tambah_darah' => ['nullable', 'in:ada,tidak'],
            'inisiasi_menyusui_dini' => ['nullable', 'in:ada,tidak'],
            'asi_eksklusif' => ['nullable', 'in:ada,tidak'],
            'asi_mpasi' => ['nullable', 'in:ada,tidak'],
            'imunisasi_lengkap' => ['nullable', 'in:ada,tidak'],
            'pencegahan_infeksi' => ['nullable', 'in:ada,tidak'],
            'status_gizi_ibu' => ['nullable', 'in:baik,buruk'],
            'penyakit_menular' => ['nullable', 'in:tidak,ada'],
            'jenis_penyakit' => ['required_if:penyakit_menular,ada', 'string', 'max:255', 'nullable'],
            'kesehatan_lingkungan' => ['nullable', 'in:baik,buruk'],
            'narasi' => ['nullable', 'string'],
            'pelaku_aksi' => ['nullable', 'string', 'max:255'],
            'waktu_pelaksanaan' => ['nullable', 'date'],
        ]);

        try {
            $aksiKonvergensi = AksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->findOrFail($id);

            $data = $request->all();
            $data['selesai'] = $request->has('selesai');
            $data['created_by'] = $user->id;

            if ($request->hasFile('foto')) {
                if ($aksiKonvergensi->foto && Storage::disk('public')->exists($aksiKonvergensi->foto)) {
                    Storage::disk('public')->delete($aksiKonvergensi->foto);
                }
                $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
            } else {
                $data['foto'] = $aksiKonvergensi->foto;
            }

            $aksiKonvergensi->update($data);
            Log::info('Data Aksi Konvergensi berhasil diperbarui.', ['id' => $id, 'user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data Aksi Konvergensi: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all(), 'user_id' => $user->id]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data Aksi Konvergensi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        try {
            $aksiKonvergensi = AksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->findOrFail($id);

            if ($aksiKonvergensi->foto && Storage::disk('public')->exists($aksiKonvergensi->foto)) {
                Storage::disk('public')->delete($aksiKonvergensi->foto);
            }
            $aksiKonvergensi->delete();
            Log::info('Data Aksi Konvergensi berhasil dihapus.', ['id' => $id, 'user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data Aksi Konvergensi: ' . $e->getMessage(), ['id' => $id, 'user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Gagal menghapus data Aksi Konvergensi: ' . $e->getMessage());
        }
    }

    public function getKelurahansByKecamatan($kecamatanId)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatanId)->get(['id', 'nama_kelurahan']);
        return response()->json($kelurahans);
    }

    public function getKartuKeluargaByKelurahan($kelurahanId)
    {
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $kelurahanId)->where('status', 'Aktif')->get(['id', 'no_kk', 'kepala_keluarga']);
        return response()->json($kartuKeluargas);
    }
}