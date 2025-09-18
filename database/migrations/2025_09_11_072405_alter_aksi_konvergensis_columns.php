<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAksiKonvergensisColumns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aksi_konvergensis', function (Blueprint $table) {
            // Mengubah kolom air_bersih_sanitasi menjadi varchar
            $table->string('air_bersih_sanitasi')->nullable()->change();
            
            // Mengubah kolom-kolom yang menerima 'ada', 'tidak' menjadi varchar
            $table->string('akses_layanan_kesehatan_kb')->nullable()->change();
            $table->string('pendidikan_pengasuhan_ortu')->nullable()->change();
            $table->string('edukasi_kesehatan_remaja')->nullable()->change();
            $table->string('kesadaran_pengasuhan_gizi')->nullable()->change();
            $table->string('akses_pangan_bergizi')->nullable()->change();
            $table->string('makanan_ibu_hamil')->nullable()->change();
            $table->string('tablet_tambah_darah')->nullable()->change();
            $table->string('inisiasi_menyusui_dini')->nullable()->change();
            $table->string('asi_eksklusif')->nullable()->change();
            $table->string('asi_mpasi')->nullable()->change();
            $table->string('imunisasi_lengkap')->nullable()->change();
            $table->string('pencegahan_infeksi')->nullable()->change();
            $table->string('penyakit_menular')->nullable()->change();
            
            // Mengubah kolom-kolom yang menerima 'baik', 'buruk' menjadi varchar
            $table->string('status_gizi_ibu')->nullable()->change();
            $table->string('kesehatan_lingkungan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aksi_konvergensis', function (Blueprint $table) {
            // Mengembalikan ke tipe integer jika diperlukan (sesuai aslinya)
            $table->integer('air_bersih_sanitasi')->nullable()->change();
            $table->integer('akses_layanan_kesehatan_kb')->nullable()->change();
            $table->integer('pendidikan_pengasuhan_ortu')->nullable()->change();
            $table->integer('edukasi_kesehatan_remaja')->nullable()->change();
            $table->integer('kesadaran_pengasuhan_gizi')->nullable()->change();
            $table->integer('akses_pangan_bergizi')->nullable()->change();
            $table->integer('makanan_ibu_hamil')->nullable()->change();
            $table->integer('tablet_tambah_darah')->nullable()->change();
            $table->integer('inisiasi_menyusui_dini')->nullable()->change();
            $table->integer('asi_eksklusif')->nullable()->change();
            $table->integer('asi_mpasi')->nullable()->change();
            $table->integer('imunisasi_lengkap')->nullable()->change();
            $table->integer('pencegahan_infeksi')->nullable()->change();
            $table->integer('penyakit_menular')->nullable()->change();
            $table->integer('status_gizi_ibu')->nullable()->change();
            $table->integer('kesehatan_lingkungan')->nullable()->change();
        });
    }
}