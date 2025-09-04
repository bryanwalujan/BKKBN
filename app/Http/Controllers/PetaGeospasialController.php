<?php
namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use Illuminate\Http\Request;

class PetaGeospasialController extends Controller
{
    public function index(Request $request)
    {
        $kecamatan = $request->query('kecamatan', '');
        $status_gizi = $request->query('status_gizi', '');

        $query = KartuKeluarga::with(['balitas' => function ($query) use ($status_gizi) {
            if ($status_gizi) {
                $query->where('status_gizi', $status_gizi);
            }
        }])->whereNotNull('latitude')->whereNotNull('longitude');

        if ($kecamatan) {
            $query->where('kecamatan', $kecamatan);
        }

        $kartuKeluargas = $query->get();

        $kecamatans = KartuKeluarga::distinct()->pluck('kecamatan');
        $statusGizis = ['Sehat', 'Waspada', 'Bahaya'];

        return view('master.peta_geospasial.index', compact('kartuKeluargas', 'kecamatans', 'statusGizis', 'kecamatan', 'status_gizi'));
    }
}