<?php
namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        Kelurahan::create(['nama_kelurahan' => 'Kelurahan Tomohon Utara']);
        Kelurahan::create(['nama_kelurahan' => 'Kelurahan Tomohon Selatan']);
        // Tambahkan kelurahan lain sesuai kebutuhan
    }
}