<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carousel;

class CarouselPlaceholderSeeder extends Seeder
{
    public function run(): void
    {
        // Avoid duplicate placeholders
        if (Carousel::count() >= 3) {
            return;
        }

        $items = [
            [
                'sub_heading' => 'Program Prioritas Nasional',
                'heading' => 'Cegah Stunting, Investasi Masa Depan Bangsa',
                'deskripsi' => 'Kami hadir untuk memberikan informasi, edukasi, dan data penting dalam upaya pencegahan stunting.',
                'button_1_text' => 'Pelajari Lebih Lanjut',
                'button_1_link' => '#services',
                'button_2_text' => 'Hubungi Kami',
                'button_2_link' => '#contact',
                'gambar' => 'carousel_gambar/placeholder-1.png',
            ],
            [
                'sub_heading' => 'Kolaborasi Lintas Sektor',
                'heading' => 'Bersama Wujudkan Generasi Sehat dan Cerdas',
                'deskripsi' => 'Kolaborasi pemerintah daerah, fasilitas kesehatan, dan masyarakat untuk intervensi tepat sasaran.',
                'button_1_text' => 'Lihat Program',
                'button_1_link' => '#publications',
                'button_2_text' => 'Monitoring',
                'button_2_link' => '#stats',
                'gambar' => 'carousel_gambar/placeholder-2.png',
            ],
            [
                'sub_heading' => 'Data Terintegrasi',
                'heading' => 'Akurat, Realtime, dan Mudah Diakses',
                'deskripsi' => 'Dashboard data mendukung pengambilan keputusan berbasis bukti di berbagai tingkatan.',
                'button_1_text' => 'Jelajahi Data',
                'button_1_link' => '#',
                'button_2_text' => 'Bantuan',
                'button_2_link' => '#',
                'gambar' => 'carousel_gambar/placeholder-3.png',
            ],
        ];

        foreach ($items as $it) {
            Carousel::create($it);
        }
    }
}

