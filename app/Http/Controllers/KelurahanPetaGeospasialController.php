<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelurahanPetaGeospasialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kelurahan');
    }

    /**
     * Menampilkan halaman peta geospasial untuk admin kelurahan.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            Log::warning('Admin kelurahan tidak terkait dengan kelurahan.', ['user_id' => $user->id]);
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        // Ambil data Kartu Keluarga berdasarkan kelurahan_id admin
        $kartuKeluargas = KartuKeluarga::with([
            'balitas' => function ($query) {
                $query->select('id', 'kartu_keluarga_id', 'nama', 'usia', 'tanggal_lahir', 'status_gizi');
            },
            'remajaPutris' => function ($query) {
                $query->select('id', 'kartu_keluarga_id', 'nama', 'umur', 'status_anemia');
            },
            'ibu' => function ($query) {
                $query->select('id', 'kartu_keluarga_id', 'nama', 'ibu_hamil', 'ibu_nifas', 'ibu_menyusui');
            },
            'kecamatan' => function ($query) {
                $query->select('id', 'nama_kecamatan');
            },
            'kelurahan' => function ($query) {
                $query->select('id', 'nama_kelurahan');
            }
        ])
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'no_kk', 'kepala_keluarga', 'alamat', 'kecamatan_id', 'kelurahan_id', 'latitude', 'longitude']);

        if ($kartuKeluargas->isEmpty()) {
            Log::info('Tidak ada data Kartu Keluarga yang valid untuk ditampilkan di peta.', ['kelurahan_id' => $user->kelurahan_id]);
            $errorMessage = 'Tidak ada data Kartu Keluarga dengan koordinat yang valid di kelurahan Anda. Silakan tambahkan data Kartu Keluarga dengan koordinat terlebih dahulu.';
            return view('kelurahan.peta_geospasial.index', compact('kartuKeluargas', 'errorMessage'));
        }

        return view('kelurahan.peta_geospasial.index', compact('kartuKeluargas'));
    }
}