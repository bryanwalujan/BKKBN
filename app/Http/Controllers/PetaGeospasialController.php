<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PetaGeospasialController extends Controller
{
    public function publicView(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id', '');
        $kelurahan_id = $request->query('kelurahan_id', '');
        $status_kesehatan = $request->query('status_kesehatan', '');

        $query = KartuKeluarga::with(['balitas', 'remajaPutris', 'kecamatan', 'kelurahan'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        if ($kecamatan_id) {
            $query->where('kecamatan_id', $kecamatan_id);
        }
        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }
        if ($status_kesehatan) {
            $query->where(function ($q) use ($status_kesehatan) {
                $q->whereHas('balitas', function ($qq) use ($status_kesehatan) {
                    $qq->where('status_gizi', $status_kesehatan);
                })->orWhereHas('remajaPutris', function ($qq) use ($status_kesehatan) {
                    $qq->where('status_anemia', $status_kesehatan);
                });
            });
        }

        $points = $query->get()->map(function ($kk) {
            return [
                'id' => $kk->id,
                'no_kk' => $kk->no_kk,
                'kepala_keluarga' => $kk->kepala_keluarga,
                'alamat' => $kk->alamat,
                'latitude' => (float) $kk->latitude,
                'longitude' => (float) $kk->longitude,
                'kecamatan' => optional($kk->kecamatan)->nama_kecamatan,
                'kelurahan' => optional($kk->kelurahan)->nama_kelurahan,
                'balita_count' => $kk->balitas->count(),
                'remaja_putri_count' => $kk->remajaPutris->count(),
                'status' => $kk->status,
            ];
        })->values();

        $kecamatans = Kecamatan::all();
        $kelurahans = $kecamatan_id ? Kelurahan::where('kecamatan_id', $kecamatan_id)->get() : collect([]);

        return view('public.peta_geospasial', compact(
            'points', 'kecamatans', 'kelurahans', 'kecamatan_id', 'kelurahan_id', 'status_kesehatan'
        ));
    }
    public function index(Request $request)
    {
        try {
            $kecamatan_id = $request->query('kecamatan_id', '');
            $kelurahan_id = $request->query('kelurahan_id', '');
            $status_kesehatan = $request->query('status_kesehatan', '');

            $query = KartuKeluarga::with(['balitas', 'remajaPutris', 'kecamatan', 'kelurahan'])
                ->whereNotNull('latitude')
                ->whereNotNull('longitude');

            if ($kecamatan_id) {
                $query->where('kecamatan_id', $kecamatan_id);
            }
            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }
            if ($status_kesehatan) {
                $query->whereHas('balitas', function ($q) use ($status_kesehatan) {
                    $q->where('status_gizi', $status_kesehatan);
                })->orWhereHas('remajaPutris', function ($q) use ($status_kesehatan) {
                    $q->where('status_anemia', $status_kesehatan);
                });
            }

            $kartuKeluargas = $query->get();
            $kecamatans = Kecamatan::all();
            $kelurahans = $kelurahan_id ? Kelurahan::where('kecamatan_id', $kecamatan_id)->get() : collect([]);
            $statusKesehatans = [
                'Sehat', 'Waspada', 'Bahaya',
                'Tidak Anemia', 'Anemia Ringan', 'Anemia Sedang', 'Anemia Berat'
            ];

            return view('master.peta_geospasial.index', compact(
                'kartuKeluargas',
                'kecamatans',
                'kelurahans',
                'kecamatan_id',
                'kelurahan_id',
                'status_kesehatan',
                'statusKesehatans'
            ));
        } catch (\Exception $e) {
            Log::error('Error loading geospatial map: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->route('peta_geospasial.index')->with('error', 'Gagal memuat peta geospasial: ' . $e->getMessage());
        }
    }
}
