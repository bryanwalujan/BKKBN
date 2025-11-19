<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerangkatDaerahKartuKeluargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:perangkat_daerah');
    }

    public function index(Request $request)
    {
        $kecamatan_id = Auth::user()->kecamatan_id;
        $kelurahan_id = $request->query('kelurahan_id');
        $search = $request->query('search');

        $query = KartuKeluarga::with(['kecamatan', 'kelurahan', 'balitas'])
            ->withCount('balitas')
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status', 'Aktif');

        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $kartuKeluargas = $query->paginate(10)->appends($request->query());
        $kecamatan = Kecamatan::find($kecamatan_id);
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();

        return view('perangkat_daerah.kartu_keluarga.index', compact('kartuKeluargas', 'kecamatan', 'kelurahans', 'kelurahan_id', 'search'));
    }

    public function show($id)
    {
        $kecamatan_id = Auth::user()->kecamatan_id;
        $kartuKeluarga = KartuKeluarga::with([
            'kecamatan',
            'kelurahan',
            'balitas',
            'ibu',
            'pendampingKeluargas',
            'aksiKonvergensis',
            'gentings',
            'dataMonitorings'
        ])
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status', 'Aktif')
            ->findOrFail($id);

        return view('perangkat_daerah.kartu_keluarga.show', compact('kartuKeluarga'));
    }
}