<?php

namespace App\Http\Controllers;

use App\Models\PendingAksiKonvergensi;
use App\Models\AksiKonvergensi;
use App\Models\KartuKeluarga;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

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
            return redirect()->route('dashboard')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $search = $request->query('search');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingAksiKonvergensi
        $pendingQuery = PendingAksiKonvergensi::with(['kartuKeluarga', 'kelurahan', 'createdBy'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })
            ->where('status', 'pending');

        if ($search) {
            $pendingQuery->where('nama_aksi', 'like', '%' . $search . '%');
        }

        $pendingAksiKonvergensis = $pendingQuery->get()->map(function ($aksi) {
            $aksi->source = 'pending';
            return $aksi;
        });

        // Query untuk AksiKonvergensi (terverifikasi)
        $verifiedQuery = AksiKonvergensi::with(['kartuKeluarga', 'kelurahan'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            });

        if ($search) {
            $verifiedQuery->where('nama_aksi', 'like', '%' . $search . '%');
        }

        $verifiedAksiKonvergensis = $verifiedQuery->get()->map(function ($aksi) {
            $aksi->source = 'verified';
            return $aksi;
        });

        // Gabungkan data untuk tab yang dipilih
        $aksiKonvergensis = $tab === 'verified' ? $verifiedAksiKonvergensis : $pendingAksiKonvergensis;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $aksiKonvergensis->count();
        $paginatedAksiKonvergensis = $aksiKonvergensis->slice($offset, $perPage);
        $aksiKonvergensis = new LengthAwarePaginator($paginatedAksiKonvergensis, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('perangkat_daerah.aksi_konvergensi.index', compact('aksiKonvergensis', 'search', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        $kecamatan = $user->kecamatan;

        if ($kartuKeluargas->isEmpty() || $kelurahans->isEmpty() || !$kecamatan) {
            Log::warning('Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan tidak ditemukan untuk kecamatan_id: ' . $user->kecamatan_id);
            return view('perangkat_daerah.aksi_konvergensi.create', compact('kartuKeluargas', 'kelurahans', 'kecamatan'))
                ->with('error', 'Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan yang terverifikasi.');
        }

        return view('perangkat_daerah.aksi_konvergensi.create', compact('kartuKeluargas', 'kelurahans', 'kecamatan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id],
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
            $data['status'] = 'pending';
            $data['selesai'] = $request->has('selesai');

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pending_aksi_konvergensi_fotos', 'public');
            }

            PendingAksiKonvergensi::create($data);
            Log::info('Menyimpan data aksi konvergensi ke pending_aksi_konvergensis', ['data' => $data]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'pending'])->with('success', 'Data Aksi Konvergensi berhasil diajukan untuk verifikasi.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data aksi konvergensi: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan data aksi konvergensi: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        if ($source === 'verified') {
            $aksiKonvergensi = AksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->findOrFail($id);
        } else {
            $aksiKonvergensi = PendingAksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('created_by', $user->id)->findOrFail($id);
        }

        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        $kecamatan = $user->kecamatan;

        if ($kartuKeluargas->isEmpty() || $kelurahans->isEmpty() || !$kecamatan) {
            Log::warning('Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan tidak ditemukan untuk kecamatan_id: ' . $user->kecamatan_id);
            return view('perangkat_daerah.aksi_konvergensi.edit', compact('aksiKonvergensi', 'kartuKeluargas', 'kelurahans', 'kecamatan', 'source'))
                ->with('error', 'Tidak ada data Kartu Keluarga, kelurahan, atau kecamatan yang terverifikasi.');
        }

        return view('perangkat_daerah.aksi_konvergensi.edit', compact('aksiKonvergensi', 'kartuKeluargas', 'kelurahans', 'kecamatan', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id],
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
            $data['status'] = 'pending';
            $data['selesai'] = $request->has('selesai');

            if ($source === 'verified') {
                $aksiKonvergensi = AksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                    $query->where('kecamatan_id', $user->kecamatan_id);
                })->findOrFail($id);
                if ($request->hasFile('foto')) {
                    $data['foto'] = $request->file('foto')->store('pending_aksi_konvergensi_fotos', 'public');
                } else {
                    $data['foto'] = $aksiKonvergensi->foto;
                }
                $data['original_aksi_konvergensi_id'] = $aksiKonvergensi->id;
                PendingAksiKonvergensi::create($data);
                $message = 'Perubahan data Aksi Konvergensi berhasil diajukan untuk verifikasi.';
            } else {
                $aksiKonvergensi = PendingAksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                    $query->where('kecamatan_id', $user->kecamatan_id);
                })->where('created_by', $user->id)->findOrFail($id);
                if ($request->hasFile('foto')) {
                    if ($aksiKonvergensi->foto && Storage::disk('public')->exists($aksiKonvergensi->foto)) {
                        Storage::disk('public')->delete($aksiKonvergensi->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('pending_aksi_konvergensi_fotos', 'public');
                }
                $aksiKonvergensi->update($data);
                $message = 'Data Aksi Konvergensi berhasil diperbarui dan diajukan untuk verifikasi.';
            }

            Log::info('Memperbarui data aksi konvergensi', ['id' => $id, 'source' => $source, 'data' => $data]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'pending'])->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data aksi konvergensi: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data aksi konvergensi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        try {
            $aksiKonvergensi = PendingAksiKonvergensi::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('created_by', $user->id)->findOrFail($id);
            if ($aksiKonvergensi->foto && Storage::disk('public')->exists($aksiKonvergensi->foto)) {
                Storage::disk('public')->delete($aksiKonvergensi->foto);
            }
            $aksiKonvergensi->delete();
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'pending'])->with('success', 'Data Aksi Konvergensi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data aksi konvergensi: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'pending'])->with('error', 'Gagal menghapus data aksi konvergensi: ' . $e->getMessage());
        }
    }

    public function getKelurahansByKecamatan($kecamatanId)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatanId)->get();
        return response()->json($kelurahans);
    }

    public function getKartuKeluargaByKelurahan($kelurahanId)
    {
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $kelurahanId)->where('status', 'Aktif')->get();
        return response()->json($kartuKeluargas);
    }
}