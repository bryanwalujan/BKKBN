<?php
namespace App\Http\Controllers;

use App\Models\AksiKonvergensi;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AksiKonvergensiController extends Controller
{
    public function index()
    {
        $aksiKonvergensis = AksiKonvergensi::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])->get();
        return view('master.aksi_konvergensi.index', compact('aksiKonvergensis'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
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
            'tahun' => ['required', 'integer', 'min:2020', 'max:2030'],
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

        $data = $request->all();
        $data['selesai'] = $request->has('selesai');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
        }

        AksiKonvergensi::create($data);

        return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::where('kecamatan_id', $aksiKonvergensi->kecamatan_id)->get();
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $aksiKonvergensi->kelurahan_id)->get();
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
            'tahun' => ['required', 'integer', 'min:2020', 'max:2030'],
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

        $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
        $data = $request->all();
        $data['selesai'] = $request->has('selesai');

        if ($request->hasFile('foto')) {
            if ($aksiKonvergensi->foto) {
                Storage::disk('public')->delete($aksiKonvergensi->foto);
            }
            $data['foto'] = $request->file('foto')->store('aksi_konvergensi_fotos', 'public');
        }

        $aksiKonvergensi->update($data);

        return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $aksiKonvergensi = AksiKonvergensi::findOrFail($id);
        if ($aksiKonvergensi->foto) {
            Storage::disk('public')->delete($aksiKonvergensi->foto);
        }
        $aksiKonvergensi->delete();

        return redirect()->route('aksi_konvergensi.index')->with('success', 'Data Aksi Konvergensi berhasil dihapus.');
    }

    public function showByKK($kartu_keluarga_id)
    {
        $kartuKeluarga = KartuKeluarga::with('aksiKonvergensis')->findOrFail($kartu_keluarga_id);
        return view('master.kartu_keluarga.aksi_konvergensi', compact('kartuKeluarga'));
    }

    public function getKelurahansByKecamatan($kecamatanId)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatanId)->get();
        return response()->json($kelurahans);
    }

    public function getKartuKeluargaByKelurahan($kelurahanId)
    {
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $kelurahanId)->get();
        return response()->json($kartuKeluargas);
    }
}