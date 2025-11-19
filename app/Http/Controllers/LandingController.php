<?php
namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\LayananKami;
use App\Models\Edukasi;


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

    

        return response()->json([
            'carousels' => $carousels,
            'services' => $services,
            'edukasi' => $education,
        ]);
    }
}