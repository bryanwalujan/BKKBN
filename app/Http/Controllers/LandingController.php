<?php
namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\LayananKami;
use App\Models\Publikasi;
use App\Models\DataRiset;
use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\IbuNifas;
use App\Models\IbuMenyusui;
use App\Models\RemajaPutri;
use App\Models\Stunting;
use App\Models\PendampingKeluarga;
use App\Models\DataPenduduk;
use App\Models\DataMonitoring;
use App\Models\Referensi;
use App\Models\GaleriProgram;
use App\Models\PetaGeospasial;
use App\Models\Template;
use App\Models\TentangKami;
use App\Models\Genting;
use App\Models\AksiKonvergensi;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function data()
    {
        $carousels = Carousel::orderBy('id', 'asc')->get();
        $services = LayananKami::where('status_aktif', true)->orderBy('urutan')->get();
        $publications = Publikasi::where('status_aktif', true)->orderBy('urutan')->get();
        $stats = DataRiset::orderBy('updated_at', 'desc')->get();

        // Aggregate only the requested public metrics
        $entityCounts = [
            ['judul' => 'Balita', 'angka' => Balita::count()],
            ['judul' => 'Ibu Hamil', 'angka' => IbuHamil::count()],
            ['judul' => 'Ibu Nifas', 'angka' => IbuNifas::count()],
            ['judul' => 'Ibu Menyusui', 'angka' => IbuMenyusui::count()],
            ['judul' => 'Remaja Putri', 'angka' => RemajaPutri::count()],
            ['judul' => 'Kasus Stunting', 'angka' => Stunting::count()],
            ['judul' => 'Aksi Konvergensi', 'angka' => AksiKonvergensi::count()],
            ['judul' => 'Genting', 'angka' => Genting::count()],
        ];

        return response()->json([
            'carousels' => $carousels,
            'services' => $services,
            'publications' => $publications,
            'stats' => $stats,
            'entity_counts' => $entityCounts,
        ]);
    }
}
