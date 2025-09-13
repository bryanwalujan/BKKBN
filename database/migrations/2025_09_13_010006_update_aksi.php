<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aksi_konvergensis', function (Blueprint $table) {
            // Intervensi Sensitif
            $table->enum('air_bersih_sanitasi', ['ada-baik', 'ada-buruk', 'tidak'])->nullable()->change();
            $table->enum('akses_layanan_kesehatan_kb', ['ada', 'tidak'])->nullable()->change();
            $table->enum('pendidikan_pengasuhan_ortu', ['ada', 'tidak'])->nullable()->change();
            $table->enum('edukasi_kesehatan_remaja', ['ada', 'tidak'])->nullable()->change();
            $table->enum('kesadaran_pengasuhan_gizi', ['ada', 'tidak'])->nullable()->change();
            $table->enum('akses_pangan_bergizi', ['ada', 'tidak'])->nullable()->change();

            // Intervensi Spesifik
            $table->enum('makanan_ibu_hamil', ['ada', 'tidak'])->nullable()->change();
            $table->enum('tablet_tambah_darah', ['ada', 'tidak'])->nullable()->change();
            $table->enum('inisiasi_menyusui_dini', ['ada', 'tidak'])->nullable()->change();
            $table->enum('asi_eksklusif', ['ada', 'tidak'])->nullable()->change();
            $table->enum('asi_mpasi', ['ada', 'tidak'])->nullable()->change();
            $table->enum('imunisasi_lengkap', ['ada', 'tidak'])->nullable()->change();
            $table->enum('pencegahan_infeksi', ['ada', 'tidak'])->nullable()->change();
            $table->enum('status_gizi_ibu', ['baik', 'buruk'])->nullable()->change();
            $table->enum('penyakit_menular', ['ada', 'tidak'])->nullable()->change();
            $table->string('jenis_penyakit', 255)->nullable()->change(); // Sudah VARCHAR, hanya konfirmasi
            $table->enum('kesehatan_lingkungan', ['baik', 'buruk'])->nullable()->change();
        });

        // Konversi data lama dari BOOLEAN ke ENUM
        DB::statement("UPDATE aksi_konvergensis SET akses_layanan_kesehatan_kb = CASE 
            WHEN akses_layanan_kesehatan_kb = '1' THEN 'ada' 
            WHEN akses_layanan_kesehatan_kb = '0' THEN 'tidak' 
            ELSE akses_layanan_kesehatan_kb END");

        DB::statement("UPDATE aksi_konvergensis SET pendidikan_pengasuhan_ortu = CASE 
            WHEN pendidikan_pengasuhan_ortu = '1' THEN 'ada' 
            WHEN pendidikan_pengasuhan_ortu = '0' THEN 'tidak' 
            ELSE pendidikan_pengasuhan_ortu END");

        DB::statement("UPDATE aksi_konvergensis SET edukasi_kesehatan_remaja = CASE 
            WHEN edukasi_kesehatan_remaja = '1' THEN 'ada' 
            WHEN edukasi_kesehatan_remaja = '0' THEN 'tidak' 
            ELSE edukasi_kesehatan_remaja END");

        DB::statement("UPDATE aksi_konvergensis SET kesadaran_pengasuhan_gizi = CASE 
            WHEN kesadaran_pengasuhan_gizi = '1' THEN 'ada' 
            WHEN kesadaran_pengasuhan_gizi = '0' THEN 'tidak' 
            ELSE kesadaran_pengasuhan_gizi END");

        DB::statement("UPDATE aksi_konvergensis SET akses_pangan_bergizi = CASE 
            WHEN akses_pangan_bergizi = '1' THEN 'ada' 
            WHEN akses_pangan_bergizi = '0' THEN 'tidak' 
            ELSE akses_pangan_bergizi END");

        DB::statement("UPDATE aksi_konvergensis SET makanan_ibu_hamil = CASE 
            WHEN makanan_ibu_hamil = '1' THEN 'ada' 
            WHEN makanan_ibu_hamil = '0' THEN 'tidak' 
            ELSE makanan_ibu_hamil END");

        DB::statement("UPDATE aksi_konvergensis SET tablet_tambah_darah = CASE 
            WHEN tablet_tambah_darah = '1' THEN 'ada' 
            WHEN tablet_tambah_darah = '0' THEN 'tidak' 
            ELSE tablet_tambah_darah END");

        DB::statement("UPDATE aksi_konvergensis SET inisiasi_menyusui_dini = CASE 
            WHEN inisiasi_menyusui_dini = '1' THEN 'ada' 
            WHEN inisiasi_menyusui_dini = '0' THEN 'tidak' 
            ELSE inisiasi_menyusui_dini END");

        DB::statement("UPDATE aksi_konvergensis SET asi_eksklusif = CASE 
            WHEN asi_eksklusif = '1' THEN 'ada' 
            WHEN asi_eksklusif = '0' THEN 'tidak' 
            ELSE asi_eksklusif END");

        DB::statement("UPDATE aksi_konvergensis SET asi_mpasi = CASE 
            WHEN asi_mpasi = '1' THEN 'ada' 
            WHEN asi_mpasi = '0' THEN 'tidak' 
            ELSE asi_mpasi END");

        DB::statement("UPDATE aksi_konvergensis SET imunisasi_lengkap = CASE 
            WHEN imunisasi_lengkap = '1' THEN 'ada' 
            WHEN imunisasi_lengkap = '0' THEN 'tidak' 
            ELSE imunisasi_lengkap END");

        DB::statement("UPDATE aksi_konvergensis SET pencegahan_infeksi = CASE 
            WHEN pencegahan_infeksi = '1' THEN 'ada' 
            WHEN pencegahan_infeksi = '0' THEN 'tidak' 
            ELSE pencegahan_infeksi END");

        DB::statement("UPDATE aksi_konvergensis SET penyakit_menular = CASE 
            WHEN penyakit_menular = '1' THEN 'ada' 
            WHEN penyakit_menular = '0' THEN 'tidak' 
            ELSE penyakit_menular END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aksi_konvergensis', function (Blueprint $table) {
            // Kembalikan ke tipe BOOLEAN untuk kolom yang sebelumnya BOOLEAN
            $table->boolean('akses_layanan_kesehatan_kb')->nullable()->change();
            $table->boolean('pendidikan_pengasuhan_ortu')->nullable()->change();
            $table->boolean('edukasi_kesehatan_remaja')->nullable()->change();
            $table->boolean('kesadaran_pengasuhan_gizi')->nullable()->change();
            $table->boolean('akses_pangan_bergizi')->nullable()->change();
            $table->boolean('makanan_ibu_hamil')->nullable()->change();
            $table->boolean('tablet_tambah_darah')->nullable()->change();
            $table->boolean('inisiasi_menyusui_dini')->nullable()->change();
            $table->boolean('asi_eksklusif')->nullable()->change();
            $table->boolean('asi_mpasi')->nullable()->change();
            $table->boolean('imunisasi_lengkap')->nullable()->change();
            $table->boolean('pencegahan_infeksi')->nullable()->change();
            $table->boolean('penyakit_menular')->nullable()->change();

            // Kembalikan ke VARCHAR untuk kolom dengan opsi lain
            $table->string('air_bersih_sanitasi', 255)->nullable()->change();
            $table->string('status_gizi_ibu', 255)->nullable()->change();
            $table->string('kesehatan_lingkungan', 255)->nullable()->change();
            $table->string('jenis_penyakit', 255)->nullable()->change();
        });

        // Kembalikan data ke BOOLEAN (1/0)
        DB::statement("UPDATE aksi_konvergensis SET akses_layanan_kesehatan_kb = CASE 
            WHEN akses_layanan_kesehatan_kb = 'ada' THEN 1 
            WHEN akses_layanan_kesehatan_kb = 'tidak' THEN 0 
            ELSE akses_layanan_kesehatan_kb END");

        DB::statement("UPDATE aksi_konvergensis SET pendidikan_pengasuhan_ortu = CASE 
            WHEN pendidikan_pengasuhan_ortu = 'ada' THEN 1 
            WHEN pendidikan_pengasuhan_ortu = 'tidak' THEN 0 
            ELSE pendidikan_pengasuhan_ortu END");

        DB::statement("UPDATE aksi_konvergensis SET edukasi_kesehatan_remaja = CASE 
            WHEN edukasi_kesehatan_remaja = 'ada' THEN 1 
            WHEN edukasi_kesehatan_remaja = 'tidak' THEN 0 
            ELSE edukasi_kesehatan_remaja END");

        DB::statement("UPDATE aksi_konvergensis SET kesadaran_pengasuhan_gizi = CASE 
            WHEN kesadaran_pengasuhan_gizi = 'ada' THEN 1 
            WHEN kesadaran_pengasuhan_gizi = 'tidak' THEN 0 
            ELSE kesadaran_pengasuhan_gizi END");

        DB::statement("UPDATE aksi_konvergensis SET akses_pangan_bergizi = CASE 
            WHEN akses_pangan_bergizi = 'ada' THEN 1 
            WHEN akses_pangan_bergizi = 'tidak' THEN 0 
            ELSE akses_pangan_bergizi END");

        DB::statement("UPDATE aksi_konvergensis SET makanan_ibu_hamil = CASE 
            WHEN makanan_ibu_hamil = 'ada' THEN 1 
            WHEN makanan_ibu_hamil = 'tidak' THEN 0 
            ELSE makanan_ibu_hamil END");

        DB::statement("UPDATE aksi_konvergensis SET tablet_tambah_darah = CASE 
            WHEN tablet_tambah_darah = 'ada' THEN 1 
            WHEN tablet_tambah_darah = 'tidak' THEN 0 
            ELSE tablet_tambah_darah END");

        DB::statement("UPDATE aksi_konvergensis SET inisiasi_menyusui_dini = CASE 
            WHEN inisiasi_menyusui_dini = 'ada' THEN 1 
            WHEN inisiasi_menyusui_dini = 'tidak' THEN 0 
            ELSE inisiasi_menyusui_dini END");

        DB::statement("UPDATE aksi_konvergensis SET asi_eksklusif = CASE 
            WHEN asi_eksklusif = 'ada' THEN 1 
            WHEN asi_eksklusif = 'tidak' THEN 0 
            ELSE asi_eksklusif END");

        DB::statement("UPDATE aksi_konvergensis SET asi_mpasi = CASE 
            WHEN asi_mpasi = 'ada' THEN 1 
            WHEN asi_mpasi = 'tidak' THEN 0 
            ELSE asi_mpasi END");

        DB::statement("UPDATE aksi_konvergensis SET imunisasi_lengkap = CASE 
            WHEN imunisasi_lengkap = 'ada' THEN 1 
            WHEN imunisasi_lengkap = 'tidak' THEN 0 
            ELSE imunisasi_lengkap END");

        DB::statement("UPDATE aksi_konvergensis SET pencegahan_infeksi = CASE 
            WHEN pencegahan_infeksi = 'ada' THEN 1 
            WHEN pencegahan_infeksi = 'tidak' THEN 0 
            ELSE pencegahan_infeksi END");

        DB::statement("UPDATE aksi_konvergensis SET penyakit_menular = CASE 
            WHEN penyakit_menular = 'ada' THEN 1 
            WHEN penyakit_menular = 'tidak' THEN 0 
            ELSE penyakit_menular END");
    }
};