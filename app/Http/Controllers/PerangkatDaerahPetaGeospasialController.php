<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PerangkatDaerahPetaGeospasialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:perangkat_daerah']);
    }

    public function index(Request $request)
    {
        try {
            // Ambil kecamatan_id dari pengguna
            $kecamatan_id = Auth::user()->kecamatan_id;
            if (!$kecamatan_id) {
                Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', [
                    'user_id' => Auth::user()->id
                ]);
                return view('perangkat_daerah.peta_geospasial.index', [
                    'kartuKeluargas' => collect([]),
                    'kelurahans' => collect([]),
                    'kecamatan_id' => '',
                    'kelurahan_id' => '',
                    'marker_color' => '',
                    'markerColors' => [],
                    'errorMessage' => 'Perangkat daerah tidak terkait dengan kecamatan.'
                ]);
            }

            // Ambil parameter filter
            $kelurahan_id = $request->query('kelurahan_id', '');
            $marker_color = $request->query('marker_color', '');

            // Validasi warna marker
            $validColors = ['#dc2626', '#f59e0b', '#eab308', '#22c55e', '#3b82f6'];
            if ($marker_color && !in_array($marker_color, $validColors)) {
                Log::warning('Warna marker tidak valid', ['marker_color' => $marker_color]);
                $marker_color = '';
            }

            // Cache kelurahan berdasarkan kecamatan_id
            $kelurahans = Cache::remember("kelurahans_kecamatan_{$kecamatan_id}", 60 * 60 * 24, function () use ($kecamatan_id) {
                try {
                    return Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
                } catch (\Exception $e) {
                    Log::warning('Gagal mengambil kelurahan untuk kecamatan_id ' . $kecamatan_id . ': ' . $e->getMessage());
                    return collect([]);
                }
            });

            // Query KartuKeluarga dengan relasi kecamatan dan kelurahan
            $query = KartuKeluarga::with(['kecamatan', 'kelurahan'])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('status', 'Aktif')
                ->where('kecamatan_id', $kecamatan_id);

            // Terapkan filter
            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }
            if ($marker_color && \Schema::hasColumn('kartu_keluarga', 'marker_color')) {
                $query->where('marker_color', $marker_color);
            }

            // Ambil data
            $kartuKeluargas = $query->get();

            // Process dan tentukan warna untuk setiap KK
            $processedData = collect();
            foreach ($kartuKeluargas as $kk) {
                // Tentukan warna marker
                $markerColorForKK = null;
                if (isset($kk->marker_color) && $kk->marker_color) {
                    $markerColorForKK = $kk->marker_color;
                } else {
                    $worstStatus = $this->getWorstStatus($kk);
                    $markerColorForKK = $this->getMarkerColor($worstStatus);
                }

                // Buat data untuk ditampilkan
                $processedKK = [
                    'id' => $kk->id,
                    'no_kk' => $kk->no_kk,
                    'kepala_keluarga' => $kk->kepala_keluarga,
                    'alamat' => $kk->alamat,
                    'latitude' => $kk->latitude,
                    'longitude' => $kk->longitude,
                    'kecamatan' => $kk->kecamatan ? ['nama_kecamatan' => $kk->kecamatan->nama_kecamatan] : null,
                    'kelurahan' => $kk->kelurahan ? ['nama_kelurahan' => $kk->kelurahan->nama_kelurahan] : null,
                    'marker_color' => $markerColorForKK,
                ];

                // Filter berdasarkan warna jika diperlukan
                if (!$marker_color || $markerColorForKK === $marker_color) {
                    $processedData->push($processedKK);
                }
            }

            // Log hasil filter
            if ($marker_color) {
                Log::info('Filter warna diterapkan', [
                    'filter_color' => $marker_color,
                    'total_before_filter' => $kartuKeluargas->count(),
                    'total_after_filter' => $processedData->count(),
                    'sample_data' => $processedData->take(3)->map(function($item) {
                        return [
                            'id' => $item['id'],
                            'no_kk' => $item['no_kk'],
                            'marker_color' => $item['marker_color']
                        ];
                    })
                ]);
            }

            // Definisikan opsi warna marker
            $markerColors = [
                ['value' => '#dc2626', 'label' => 'Merah (Bahaya/Anemia Berat)'],
                ['value' => '#f59e0b', 'label' => 'Oranye (Waspada/Anemia Sedang)'],
                ['value' => '#eab308', 'label' => 'Kuning (Anemia Ringan)'],
                ['value' => '#22c55e', 'label' => 'Hijau (Sehat/Tidak Anemia)'],
                ['value' => '#3b82f6', 'label' => 'Biru (Tidak Diketahui)'],
            ];

            // Jika tidak ada data, set pesan error
            $errorMessage = null;
            if ($processedData->isEmpty()) {
                if ($marker_color) {
                    $colorLabel = collect($markerColors)->firstWhere('value', $marker_color)['label'] ?? $marker_color;
                    $errorMessage = "Tidak ada kartu keluarga dengan warna marker {$colorLabel}.";
                } else {
                    $errorMessage = 'Tidak ada data kartu keluarga dengan koordinat yang valid untuk ditampilkan.';
                }
            }

            // Log final data
            Log::info('Data final untuk peta', [
                'total' => $processedData->count(),
                'marker_color_filter' => $marker_color ?: 'none',
                'kecamatan_id' => $kecamatan_id
            ]);

            return view('perangkat_daerah.peta_geospasial.index', [
                'kartuKeluargas' => $processedData,
                'kelurahans' => $kelurahans,
                'kecamatan_id' => $kecamatan_id,
                'kelurahan_id' => $kelurahan_id,
                'marker_color' => $marker_color,
                'markerColors' => $markerColors,
                'errorMessage' => $errorMessage
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal memuat peta geospasial: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('perangkat_daerah.peta_geospasial.index', [
                'kartuKeluargas' => collect([]),
                'kelurahans' => collect([]),
                'kecamatan_id' => '',
                'kelurahan_id' => '',
                'marker_color' => '',
                'markerColors' => [
                    ['value' => '#dc2626', 'label' => 'Merah (Bahaya/Anemia Berat)'],
                    ['value' => '#f59e0b', 'label' => 'Oranye (Waspada/Anemia Sedang)'],
                    ['value' => '#eab308', 'label' => 'Kuning (Anemia Ringan)'],
                    ['value' => '#22c55e', 'label' => 'Hijau (Sehat/Tidak Anemia)'],
                    ['value' => '#3b82f6', 'label' => 'Biru (Tidak Diketahui)'],
                ],
                'errorMessage' => 'Gagal memuat peta geospasial: ' . $e->getMessage()
            ]);
        }
    }

    private function getMarkerColor($status)
    {
        if (!$status) {
            return '#3b82f6'; // Biru untuk Tidak Diketahui
        }

        $status = strtolower(trim($status));
        
        switch ($status) {
            case 'bahaya':
            case 'anemia berat':
                return '#dc2626'; // Merah
            case 'waspada':
            case 'anemia sedang':
                return '#f59e0b'; // Oranye
            case 'anemia ringan':
                return '#eab308'; // Kuning
            case 'sehat':
            case 'tidak anemia':
                return '#22c55e'; // Hijau
            default:
                return '#3b82f6'; // Biru untuk tidak diketahui
        }
    }

    private function getWorstStatus($kk)
    {
        $statuses = [];
        
        // Kumpulkan status dari balita
        foreach ($kk->balitas()->get() as $balita) {
            if ($balita->status_gizi) {
                $statuses[] = strtolower(trim($balita->status_gizi));
            }
        }
        
        // Kumpulkan status dari remaja putri
        foreach ($kk->remajaPutris()->get() as $remaja) {
            if ($remaja->status_anemia) {
                $statuses[] = strtolower(trim($remaja->status_anemia));
            }
        }

        // Jika tidak ada status sama sekali
        if (empty($statuses)) {
            return 'tidak diketahui';
        }

        // Prioritas status (dari terburuk ke terbaik)
        if (in_array('bahaya', $statuses) || in_array('anemia berat', $statuses)) {
            return 'bahaya';
        }
        if (in_array('waspada', $statuses) || in_array('anemia sedang', $statuses)) {
            return 'waspada';
        }
        if (in_array('anemia ringan', $statuses)) {
            return 'anemia ringan';
        }
        if (in_array('sehat', $statuses) || in_array('tidak anemia', $statuses)) {
            return 'sehat';
        }

        return 'tidak diketahui';
    }
}