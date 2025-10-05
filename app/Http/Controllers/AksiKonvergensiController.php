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

class AksiKonvergensiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = AksiKonvergensi::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy']);

        if ($search) {
            $query->where('nama_aksi', 'like', '%' . $search . '%');
        }

        $aksiKonvergensis = $query->paginate(10)->appends(['search' => $search]);
        return view('master.aksi_konvergensi.index', compact('aksiKonvergensis', 'search'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::all(['id', 'nama_kecamatan']);
        return view('master.aksi_konvergensi.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
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
            $data['selesai'] = $request->has('selesai');
            $data['created_by'] = Auth::id();

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
            }

            AksiKonvergensi::create($data);
            Log::info('Menyimpan data aksi konvergensi', ['data' => $data]);
            return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data aksi konvergensi: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data aksi konvergensi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $aksiKonvergensi = AksiKonvergensi::with('createdBy')->findOrFail($id);
        $kecamatans = Kecamatan::all(['id', 'nama_kecamatan']);
        $kelurahans = Kelurahan::where('kecamatan_id', $aksiKonvergensi->kecamatan_id)->get(['id', 'nama_kelurahan']);
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $aksiKonvergensi->kelurahan_id)->get(['id', 'no_kk', 'kepala_keluarga']);
        return view('master.aksi_konvergensi.edit', compact('aksiKonvergensi', 'kecamatans', 'kelurahans', 'kartuKeluargas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
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
            $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
            $data = $request->all();
            $data['selesai'] = $request->has('selesai');
            $data['created_by'] = Auth::id();

            if ($request->hasFile('foto')) {
                if ($aksiKonvergensi->foto && Storage::disk('public')->exists($aksiKonvergensi->foto)) {
                    Storage::disk('public')->delete($aksiKonvergensi->foto);
                }
                $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
            }

            $aksiKonvergensi->update($data);
            Log::info('Memperbarui data aksi konvergensi', ['id' => $id, 'data' => $data]);
            return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data aksi konvergensi: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data aksi konvergensi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
            if ($aksiKonvergensi->foto && Storage::disk('public')->exists($aksiKonvergensi->foto)) {
                Storage::disk('public')->delete($aksiKonvergensi->foto);
            }
            $aksiKonvergensi->delete();
            Log::info('Menghapus data aksi konvergensi', ['id' => $id]);
            return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data aksi konvergensi: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('aksi_konvergensi.index')->with('error', 'Gagal menghapus data aksi konvergensi: ' . $e->getMessage());
        }
    }

    public function getKelurahansByKecamatan($kecamatanId)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatanId)->get(['id', 'nama_kelurahan']);
        return response()->json($kelurahans);
    }

    public function getKartuKeluargaByKelurahan($kelurahanId)
    {
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $kelurahanId)->get(['id', 'no_kk', 'kepala_keluarga']);
        return response()->json($kartuKeluargas);
    }
}