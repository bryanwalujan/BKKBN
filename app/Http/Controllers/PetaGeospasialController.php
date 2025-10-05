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
            $marker_color = $request->query('marker_color', '');

            // Validasi warna marker
            $validColors = ['#dc2626', '#f59e0b', '#eab308', '#22c55e', '#3b82f6'];
            if ($marker_color && !in_array($marker_color, $validColors)) {
                Log::warning('Warna marker tidak valid', ['marker_color' => $marker_color]);
                $marker_color = '';
            }

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
                        'marker_color' => '',
                        'markerColors' => [],
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
                'ibu.ibuHamil',
                'ibu.ibuNifas',
                'ibu.ibuMenyusui',
                'kecamatan',
                'kelurahan'
            ])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->where('status', 'Aktif');

            // Terapkan filter kecamatan dan kelurahan
            if ($kecamatan_id && $view === 'master.peta_geospasial.index') {
                $query->where('kecamatan_id', $kecamatan_id);
            }
            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }

            // Jika ada marker_color dalam database, filter berdasarkan itu
            if ($marker_color && \Schema::hasColumn('kartu_keluarga', 'marker_color')) {
                $query->where('marker_color', $marker_color);
            }

            // Ambil data
            $kartuKeluargas = $query->get();
            
            // Process dan tentukan warna untuk setiap KK
            $processedData = collect();
            
            foreach ($kartuKeluargas as $kk) {
                // Process balitas
                $balitas = $kk->balitas->map(function ($balita) {
                    if ($balita->tanggal_lahir) {
                        $balita->usia = round(Carbon::parse($balita->tanggal_lahir)->diffInMonths(Carbon::now()));
                    } else {
                        $balita->usia = null;
                    }
                    return [
                        'nama' => $balita->nama,
                        'usia' => $balita->usia,
                        'tanggal_lahir' => $balita->tanggal_lahir,
                        'status_gizi' => $balita->status_gizi ? trim($balita->status_gizi) : null,
                    ];
                });

                // Process ibu
                $ibu = $kk->ibu->map(function ($ibu) {
                    return [
                        'nama' => $ibu->nama,
                        'ibu_hamil' => $ibu->ibuHamil ? true : false,
                        'ibu_nifas' => $ibu->ibuNifas ? true : false,
                        'ibu_menyusui' => $ibu->ibuMenyusui ? true : false,
                    ];
                });

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
                    'balitas' => $balitas->toArray(),
                    'ibu' => $ibu->toArray(),
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
                ['value' => '#dc2626', 'label' => 'Merah (Bahaya)'],
                ['value' => '#f59e0b', 'label' => 'Oranye (Waspada)'],
                ['value' => '#eab308', 'label' => 'Kuning (Kurang Gizi)'],
                ['value' => '#22c55e', 'label' => 'Hijau (Sehat)'],
                ['value' => '#3b82f6', 'label' => 'Biru (Tidak Diketahui)'],
            ];

            // Set pesan error jika tidak ada data
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
                'view' => $view
            ]);

            return view($view, [
                'kartuKeluargas' => $processedData,
                'kecamatans' => $kecamatans,
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

            return view($view, [
                'kartuKeluargas' => collect([]),
                'kecamatans' => collect([]),
                'kelurahans' => collect([]),
                'kecamatan_id' => '',
                'kelurahan_id' => '',
                'marker_color' => '',
                'markerColors' => [
                    ['value' => '#dc2626', 'label' => 'Merah (Bahaya)'],
                    ['value' => '#f59e0b', 'label' => 'Oranye (Waspada)'],
                    ['value' => '#eab308', 'label' => 'Kuning (Kurang Gizi)'],
                    ['value' => '#22c55e', 'label' => 'Hijau (Sehat)'],
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
            case 'stunting':
                return '#dc2626'; // Merah
            case 'waspada':
            case 'kurang gizi':
                return '#f59e0b'; // Oranye
            case 'obesitas':
                return '#eab308'; // Kuning
            case 'sehat':
                return '#22c55e'; // Hijau
            default:
                return '#3b82f6'; // Biru untuk tidak diketahui
        }
    }

    private function getWorstStatus($kk)
    {
        $statuses = [];
        
        // Kumpulkan status dari balita
        foreach ($kk->balitas as $balita) {
            if ($balita->status_gizi) {
                $statuses[] = strtolower(trim($balita->status_gizi));
            }
        }

        // Jika tidak ada status sama sekali
        if (empty($statuses)) {
            return 'tidak diketahui';
        }

        // Prioritas status (dari terburuk ke terbaik)
        if (in_array('bahaya', $statuses) || in_array('stunting', $statuses)) {
            return 'bahaya';
        }
        if (in_array('waspada', $statuses) || in_array('kurang gizi', $statuses)) {
            return 'waspada';
        }
        if (in_array('obesitas', $statuses)) {
            return 'obesitas';
        }
        if (in_array('sehat', $statuses)) {
            return 'sehat';
        }

        return 'tidak diketahui';
    }
}