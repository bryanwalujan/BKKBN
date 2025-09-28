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
use App\Models\Edukasi;
use App\Models\PetaGeospasial;
use App\Models\Template;
use App\Models\TentangKami;
use App\Models\Genting;
use App\Models\AksiKonvergensi;

class LandingController extends Controller
{
    public function index()
    {
        return view('public.landing');
    }

    public function data()
    {
        $carousels = Carousel::orderBy('id', 'asc')->get();
        $services = LayananKami::where('status_aktif', true)->orderBy('urutan')->get();
        $publications = Publikasi::where('status_aktif', true)->orderBy('urutan')->get();
        $stats = DataRiset::orderBy('updated_at', 'desc')->get();
        $about = TentangKami::first();
        $gallery = GaleriProgram::where('status_aktif', true)->orderBy('urutan')->get();
        $education = Edukasi::where('status_aktif', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'judul' => $item->judul,
                'kategori' => $item->kategori,
                'kategori_label' => Edukasi::KATEGORI[$item->kategori] ?? null,
                'deskripsi' => $item->deskripsi,
                'tautan' => $item->tautan,
                'file' => $item->file,
                'gambar' => $item->gambar,
                'created_at' => optional($item->created_at)->toIso8601String(),
            ])->values();

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
            // keep original key for backwards-compat if used elsewhere
            'stats' => $stats,
            // explicit keys for redesigned public landing sections
            'data_riset' => $stats,
            'tentang_kami' => $about,
            'galeri_program' => $gallery,
            'edukasi' => $education,
            'entity_counts' => $entityCounts,
        ]);
    }
}