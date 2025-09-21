<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PetaGeospasialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $view = 'master.peta_geospasial.index')
    {
        try {
            // Ambil parameter filter
            $kecamatan_id = $request->query('kecamatan_id', '');
            $kelurahan_id = $request->query('kelurahan_id', '');
            $status_kesehatan = $request->query('status_kesehatan', '');

            // Jika pengguna adalah admin kelurahan, batasi ke kelurahan_id mereka
            if (Auth::user()->role === 'admin_kelurahan' && !$kelurahan_id) {
                $kelurahan_id = Auth::user()->kelurahan_id;
                if (!$kelurahan_id) {
                    Log::warning('Admin kelurahan tidak terkait dengan kelurahan.', [
                        'user_id' => Auth::user()->id
                    ]);
                    return view($view, [
                        'kartuKeluargas' => collect([]),
                        'kecamatans' => collect([]),
                        'kelurahans' => collect([]),
                        'kecamatan_id' => '',
                        'kelurahan_id' => '',
                        'status_kesehatan' => '',
                        'statusKesehatans' => [],
                        'errorMessage' => 'Admin kelurahan tidak terkait dengan kelurahan.'
                    ]);
                }
            }

            // Cache kecamatan (hanya untuk master)
            $kecamatans = $view === 'master.peta_geospasial.index' ? Cache::remember('kecamatans_all', 60 * 60 * 24, function () {
                try {
                    return Kecamatan::all();
                } catch (\Exception $e) {
                    Log::warning('Gagal mengambil kecamatan dari database: ' . $e->getMessage());
                    return collect([]);
                }
            }) : collect([]);

            // Cache kelurahan berdasarkan kecamatan_id (hanya untuk master)
            $kelurahans = $kecamatan_id && $view === 'master.peta_geospasial.index' ? Cache::remember("kelurahans_kecamatan_{$kecamatan_id}", 60 * 60 * 24, function () use ($kecamatan_id) {
                try {
                    return Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
                } catch (\Exception $e) {
                    Log::warning('Gagal mengambil kelurahan untuk kecamatan_id ' . $kecamatan_id . ': ' . $e->getMessage());
                    return collect([]);
                }
            }) : collect([]);

            // Query KartuKeluarga dengan relasi
            $query = KartuKeluarga::with([
                'balitas',
                'remajaPutris',
                'ibu.ibuHamil',
                'ibu.ibuNifas',
                'ibu.ibuMenyusui',
                'kecamatan',
                'kelurahan'
            ])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('status', 'Aktif');

            // Terapkan filter
            if ($kecamatan_id && $view === 'master.peta_geospasial.index') {
                $query->where('kecamatan_id', $kecamatan_id);
            }
            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }
            if ($status_kesehatan && $view === 'master.peta_geospasial.index') {
                $query->where(function ($q) use ($status_kesehatan) {
                    $q->whereHas('balitas', function ($q) use ($status_kesehatan) {
                        $q->where('status_gizi', $status_kesehatan);
                    })->orWhereHas('remajaPutris', function ($q) use ($status_kesehatan) {
                        $q->where('status_anemia', $status_kesehatan);
                    });
                });
            }

            // Ambil data
            $kartuKeluargas = $query->get()->map(function ($kk) {
                $kk->balitas = $kk->balitas->map(function ($balita) {
                    // Pastikan usia dihitung jika tanggal_lahir ada
                    if ($balita->tanggal_lahir) {
                        $balita->usia = round(Carbon::parse($balita->tanggal_lahir)->diffInMonths(Carbon::now()));
                    } else {
                        Log::warning('Balita tidak memiliki tanggal_lahir', [
                            'balita_id' => $balita->id,
                            'nama' => $balita->nama,
                            'kartu_keluarga_id' => $balita->kartu_keluarga_id
                        ]);
                        $balita->usia = null;
                    }
                    return [
                        'nama' => $balita->nama,
                        'usia' => $balita->usia,
                        'tanggal_lahir' => $balita->tanggal_lahir,
                        'status_gizi' => $balita->status_gizi,
                    ];
                });
                $kk->remaja_putris = $kk->remajaPutris->map(function ($remaja) {
                    return [
                        'nama' => $remaja->nama,
                        'umur' => $remaja->umur,
                        'status_anemia' => $remaja->status_anemia,
                    ];
                });
                $kk->ibu = $kk->ibu->map(function ($ibu) {
                    return [
                        'nama' => $ibu->nama,
                        'ibu_hamil' => $ibu->ibuHamil ? true : false,
                        'ibu_nifas' => $ibu->ibuNifas ? true : false,
                        'ibu_menyusui' => $ibu->ibuMenyusui ? true : false,
                    ];
                });
                return [
                    'id' => $kk->id,
                    'no_kk' => $kk->no_kk,
                    'kepala_keluarga' => $kk->kepala_keluarga,
                    'alamat' => $kk->alamat,
                    'latitude' => $kk->latitude,
                    'longitude' => $kk->longitude,
                    'kecamatan' => $kk->kecamatan ? ['nama_kecamatan' => $kk->kecamatan->nama_kecamatan] : null,
                    'kelurahan' => $kk->kelurahan ? ['nama_kelurahan' => $kk->kelurahan->nama_kelurahan] : null,
                    'balitas' => $kk->balitas->toArray(),
                    'remaja_putris' => $kk->remaja_putris->toArray(),
                    'ibu' => $kk->ibu->toArray(),
                ];
            });

            // Definisikan status kesehatan (hanya untuk master)
            $statusKesehatans = $view === 'master.peta_geospasial.index' ? [
                'Sehat', 'Waspada', 'Bahaya',
                'Tidak Anemia', 'Anemia Ringan', 'Anemia Sedang', 'Anemia Berat'
            ] : [];

            // Jika tidak ada data, set pesan error
            $errorMessage = $kartuKeluargas->isEmpty() ? 'Tidak ada data kartu keluarga dengan koordinat yang valid untuk ditampilkan.' : null;

            return view($view, compact(
                'kartuKeluargas',
                'kecamatans',
                'kelurahans',
                'kecamatan_id',
                'kelurahan_id',
                'status_kesehatan',
                'statusKesehatans',
                'errorMessage'
            ));
        } catch (\Exception $e) {
            Log::error('Gagal memuat peta geospasial: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return view($view, [
                'kartuKeluargas' => collect([]),
                'kecamatans' => collect([]),
                'kelurahans' => collect([]),
                'kecamatan_id' => '',
                'kelurahan_id' => '',
                'status_kesehatan' => '',
                'statusKesehatans' => $view === 'master.peta_geospasial.index' ? [
                    'Sehat', 'Waspada', 'Bahaya',
                    'Tidak Anemia', 'Anemia Ringan', 'Anemia Sedang', 'Anemia Berat'
                ] : [],
                'errorMessage' => 'Gagal memuat peta geospasial: ' . $e->getMessage()
            ]);
        }
    }
}