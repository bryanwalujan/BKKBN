<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEdukasi extends Migration
{
    public function up()
    {
        Schema::table('edukasi', function (Blueprint $table) {
            // Drop kolom lama
            $table->dropColumn([
                'penyebaran_informasi_media',
                'konseling_perubahan_perilaku',
                'konseling_pengasuhan',
                'paud',
                'konseling_kesehatan_reproduksi',
                'ppa',
                'modul_buku_saku'
            ]);

            // Tambahkan kolom baru
            $table->string('kategori')->after('judul')->nullable();
            $table->text('deskripsi')->nullable()->after('kategori');
            $table->string('tautan')->nullable()->after('deskripsi');
            $table->string('file')->nullable()->after('tautan');
        });
    }

    public function down()
    {
        Schema::table('edukasi', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->text('penyebaran_informasi_media')->nullable();
            $table->text('konseling_perubahan_perilaku')->nullable();
            $table->text('konseling_pengasuhan')->nullable();
            $table->text('paud')->nullable();
            $table->text('konseling_kesehatan_reproduksi')->nullable();
            $table->text('ppa')->nullable();
            $table->text('modul_buku_saku')->nullable();

            // Hapus kolom baru
            $table->dropColumn(['kategori', 'deskripsi', 'tautan', 'file']);
        });
    }
}