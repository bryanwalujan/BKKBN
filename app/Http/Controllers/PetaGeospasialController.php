<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PetaGeospasialController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Ambil parameter filter
            $kecamatan_id = $request->query('kecamatan_id', '');
            $kelurahan_id = $request->query('kelurahan_id', '');
            $status_kesehatan = $request->query('status_kesehatan', '');

            // Cache kecamatan dengan fallback
            $kecamatans = Cache::remember('kecamatans_all', 60 * 60 * 24, function () {
                try {
                    return Kecamatan::all();
                } catch (\Exception $e) {
                    Log::warning('Failed to fetch kecamatans from database: ' . $e->getMessage());
                    return collect([]);
                }
            });

            // Cache kelurahan berdasarkan kecamatan_id dengan fallback
            $kelurahans = $kecamatan_id ? Cache::remember("kelurahans_kecamatan_{$kecamatan_id}", 60 * 60 * 24, function () use ($kecamatan_id) {
                try {
                    return Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
                } catch (\Exception $e) {
                    Log::warning('Failed to fetch kelurahans for kecamatan_id ' . $kecamatan_id . ': ' . $e->getMessage());
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
                ->whereNotNull('longitude');

            // Terapkan filter
            if ($kecamatan_id) {
                $query->where('kecamatan_id', $kecamatan_id);
            }
            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }
            if ($status_kesehatan) {
                $query->where(function ($q) use ($status_kesehatan) {
                    $q->whereHas('balitas', function ($q) use ($status_kesehatan) {
                        $q->where('status_gizi', $status_kesehatan);
                    })->orWhereHas('remajaPutris', function ($q) use ($status_kesehatan) {
                        $q->where('status_anemia', $status_kesehatan);
                    });
                });
            }

            // Ambil data
            $kartuKeluargas = $query->get();

            // Transformasi data balitas untuk memastikan atribut usia tersedia
            $kartuKeluargas = $kartuKeluargas->map(function ($kk) {
                $kk->balitas = $kk->balitas->map(function ($balita) {
                    // Pastikan usia dihitung jika tanggal_lahir ada
                    if ($balita->tanggal_lahir) {
                        $balita->usia = round(Carbon::parse($balita->tanggal_lahir)->diffInMonths(Carbon::now()));
                    } else {
                        Log::warning('Balita missing tanggal_lahir', [
                            'balita_id' => $balita->id,
                            'nama' => $balita->nama,
                            'kartu_keluarga_id' => $balita->kartu_keluarga_id
                        ]);
                        $balita->usia = null;
                    }
                    return $balita;
                });
                return $kk;
            });

            // Definisikan status kesehatan
            $statusKesehatans = [
                'Sehat', 'Waspada', 'Bahaya',
                'Tidak Anemia', 'Anemia Ringan', 'Anemia Sedang', 'Anemia Berat'
            ];

            // Jika tidak ada data, set pesan error
            $errorMessage = $kartuKeluargas->isEmpty() ? 'Tidak ada data kartu keluarga yang sesuai dengan filter.' : null;

            return view('master.peta_geospasial.index', compact(
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
            Log::error('Error loading geospatial map: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            // Tampilkan view dengan pesan error alih-alih redirect
            return view('master.peta_geospasial.index', [
                'kartuKeluargas' => collect([]),
                'kecamatans' => collect([]),
                'kelurahans' => collect([]),
                'kecamatan_id' => '',
                'kelurahan_id' => '',
                'status_kesehatan' => '',
                'statusKesehatans' => [
                    'Sehat', 'Waspada', 'Bahaya',
                    'Tidak Anemia', 'Anemia Ringan', 'Anemia Sedang', 'Anemia Berat'
                ],
                'errorMessage' => 'Gagal memuat peta geospasial: ' . $e->getMessage()
            ]);
        }
    }
}