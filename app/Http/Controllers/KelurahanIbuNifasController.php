<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\IbuNifas;
use App\Models\BayiBaruLahir;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelurahanIbuNifasController extends Controller
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

        $query = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan', 'bayiBaruLahir'])
            ->whereHas('ibu', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
            });

        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            })->orWhere('tempat_persalinan', 'like', '%' . $search . '%');
        }

        $ibuNifas = $query->paginate(10)->appends(['search' => $search]);
        $totalData = $ibuNifas->total();

        return view('kelurahan.ibu_nifas.index', compact('ibuNifas', 'search', 'totalData'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Nifas')
            ->get(['id', 'nama', 'nik']);

        if ($ibus->isEmpty()) {
            return view('kelurahan.ibu_nifas.create', compact('ibus'))
                ->with('warning', 'Tidak ada data ibu dengan status Nifas. Silakan tambahkan data ibu terlebih dahulu.');
        }

        return view('kelurahan.ibu_nifas.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'tanggal_melahirkan' => ['nullable', 'date'],
            'tempat_persalinan' => ['nullable', 'string', 'max:255'],
            'penolong_persalinan' => ['nullable', 'string', 'max:255'],
            'cara_persalinan' => ['nullable', 'string', 'max:255'],
            'komplikasi' => ['nullable', 'string', 'max:255'],
            'keadaan_bayi' => ['nullable', 'string', 'max:255'],
            'kb_pasca_salin' => ['nullable', 'string', 'max:255'],
            'bayi.umur_dalam_kandungan' => ['nullable', 'string', 'max:255'],
            'bayi.berat_badan_lahir' => ['nullable', 'string', 'max:255'],
            'bayi.panjang_badan_lahir' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);

            // Update status ibu ke Nifas dan hapus data terkait lainnya
            $ibu->update(['status' => 'Nifas']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuMenyusui) {
                $ibu->ibuMenyusui->delete();
            }

            // Cek apakah ibu sudah memiliki entri IbuNifas, hapus jika ada
            $existingIbuNifas = IbuNifas::where('ibu_id', $ibu->id)->first();
            if ($existingIbuNifas) {
                $existingIbuNifas->delete();
            }

            // Simpan data ibu nifas
            $ibuNifas = IbuNifas::create([
                'ibu_id' => $ibu->id,
                'hari_nifas' => $request->hari_nifas,
                'kondisi_kesehatan' => $request->kondisi_kesehatan,
                'warna_kondisi' => $request->warna_kondisi,
                'berat' => $request->berat,
                'tinggi' => $request->tinggi,
                'tanggal_melahirkan' => $request->tanggal_melahirkan,
                'tempat_persalinan' => $request->tempat_persalinan,
                'penolong_persalinan' => $request->penolong_persalinan,
                'cara_persalinan' => $request->cara_persalinan,
                'komplikasi' => $request->komplikasi,
                'keadaan_bayi' => $request->keadaan_bayi,
                'kb_pasca_salin' => $request->kb_pasca_salin,
                'created_by' => $user->id,
            ]);

            // Simpan data bayi baru lahir jika ada
            if ($request->has('bayi') && ($request->bayi['umur_dalam_kandungan'] || $request->bayi['berat_badan_lahir'] || $request->bayi['panjang_badan_lahir'])) {
                BayiBaruLahir::create([
                    'ibu_nifas_id' => $ibuNifas->id,
                    'umur_dalam_kandungan' => $request->bayi['umur_dalam_kandungan'],
                    'berat_badan_lahir' => $request->bayi['berat_badan_lahir'],
                    'panjang_badan_lahir' => $request->bayi['panjang_badan_lahir'],
                    'created_by' => $user->id,
                ]);
            }

            return redirect()->route('kelurahan.ibu_nifas.index')->with('success', 'Data ibu nifas berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu nifas: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu nifas: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $ibuNifas = IbuNifas::with('bayiBaruLahir')->whereHas('ibu', function ($q) use ($user) {
            $q->where('kelurahan_id', $user->kelurahan_id);
        })->findOrFail($id);

        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Nifas')
            ->get(['id', 'nama', 'nik']);

        return view('kelurahan.ibu_nifas.edit', compact('ibuNifas', 'ibus'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'tanggal_melahirkan' => ['nullable', 'date'],
            'tempat_persalinan' => ['nullable', 'string', 'max:255'],
            'penolong_persalinan' => ['nullable', 'string', 'max:255'],
            'cara_persalinan' => ['nullable', 'string', 'max:255'],
            'komplikasi' => ['nullable', 'string', 'max:255'],
            'keadaan_bayi' => ['nullable', 'string', 'max:255'],
            'kb_pasca_salin' => ['nullable', 'string', 'max:255'],
            'bayi.umur_dalam_kandungan' => ['nullable', 'string', 'max:255'],
            'bayi.berat_badan_lahir' => ['nullable', 'string', 'max:255'],
            'bayi.panjang_badan_lahir' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $ibuNifas = IbuNifas::whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);

            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Nifas']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuMenyusui) {
                $ibu->ibuMenyusui->delete();
            }

            $ibuNifas->update([
                'ibu_id' => $request->ibu_id,
                'hari_nifas' => $request->hari_nifas,
                'kondisi_kesehatan' => $request->kondisi_kesehatan,
                'warna_kondisi' => $request->warna_kondisi,
                'berat' => $request->berat,
                'tinggi' => $request->tinggi,
                'tanggal_melahirkan' => $request->tanggal_melahirkan,
                'tempat_persalinan' => $request->tempat_persalinan,
                'penolong_persalinan' => $request->penolong_persalinan,
                'cara_persalinan' => $request->cara_persalinan,
                'komplikasi' => $request->komplikasi,
                'keadaan_bayi' => $request->keadaan_bayi,
                'kb_pasca_salin' => $request->kb_pasca_salin,
                'created_by' => $user->id,
            ]);

            // Update atau buat data bayi baru lahir
            if ($request->has('bayi')) {
                $bayiData = $request->bayi;
                if ($ibuNifas->bayiBaruLahir) {
                    $ibuNifas->bayiBaruLahir->update([
                        'umur_dalam_kandungan' => $bayiData['umur_dalam_kandungan'],
                        'berat_badan_lahir' => $bayiData['berat_badan_lahir'],
                        'panjang_badan_lahir' => $bayiData['panjang_badan_lahir'],
                    ]);
                } elseif ($bayiData['umur_dalam_kandungan'] || $bayiData['berat_badan_lahir'] || $bayiData['panjang_badan_lahir']) {
                    BayiBaruLahir::create([
                        'ibu_nifas_id' => $ibuNifas->id,
                        'umur_dalam_kandungan' => $bayiData['umur_dalam_kandungan'],
                        'berat_badan_lahir' => $bayiData['berat_badan_lahir'],
                        'panjang_badan_lahir' => $bayiData['panjang_badan_lahir'],
                        'created_by' => $user->id,
                    ]);
                }
            }

            return redirect()->route('kelurahan.ibu_nifas.index')->with('success', 'Data ibu nifas berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu nifas: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu nifas: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $ibuNifas = IbuNifas::whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);

            // Hapus data bayi baru lahir terkait
            if ($ibuNifas->bayiBaruLahir) {
                $ibuNifas->bayiBaruLahir->delete();
            }

            $ibu = $ibuNifas->ibu;
            $ibuNifas->delete();
            $ibu->update(['status' => 'Tidak Aktif']);

            return redirect()->route('kelurahan.ibu_nifas.index')->with('success', 'Data ibu nifas berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu nifas: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Gagal menghapus data ibu nifas: ' . $e->getMessage());
        }
    }

    public function moveToBalita($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $ibuNifas = IbuNifas::with('ibu', 'bayiBaruLahir')
                ->whereHas('ibu', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                })->findOrFail($id);

            $bayiBaruLahir = $ibuNifas->bayiBaruLahir;

            if (!$bayiBaruLahir) {
                return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Data bayi baru lahir tidak ditemukan untuk ibu nifas ini.');
            }

            // Buat data balita
            Balita::create([
                'created_by' => $user->id,
                'nik' => null,
                'nama' => 'Bayi ' . ($ibuNifas->ibu->nama ?? 'Tanpa Nama'),
                'tanggal_lahir' => $ibuNifas->tanggal_melahirkan,
                'berat_tinggi' => ($bayiBaruLahir->berat_badan_lahir ? $bayiBaruLahir->berat_badan_lahir . ' kg' : '') .
                                 ($bayiBaruLahir->panjang_badan_lahir ? ' / ' . $bayiBaruLahir->panjang_badan_lahir . ' cm' : ''),
                'kelurahan_id' => $ibuNifas->ibu->kelurahan_id,
                'kecamatan_id' => $ibuNifas->ibu->kecamatan_id,
                'kartu_keluarga_id' => $ibuNifas->ibu->kartu_keluarga_id,
                'jenis_kelamin' => null,
                'lingkar_kepala' => null,
                'lingkar_lengan' => null,
                'alamat' => $ibuNifas->ibu->alamat ?? null,
                'status_gizi' => null,
                'warna_label' => null,
                'status_pemantauan' => null,
                'foto' => null,
            ]);

            // Hapus data bayi baru lahir
            $bayiBaruLahir->delete();

            return redirect()->route('kelurahan.ibu_nifas.index')->with('success', 'Data bayi berhasil dipindahkan ke tabel balita.');
        } catch (\Exception $e) {
            Log::error('Gagal memindahkan data bayi ke balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Gagal memindahkan data bayi ke balita: ' . $e->getMessage());
        }
    }
}