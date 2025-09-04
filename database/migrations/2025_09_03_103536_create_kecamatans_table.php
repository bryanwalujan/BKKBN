<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kecamatan')->unique();
            $table->timestamps();
        });

        // Isi data kecamatan
        DB::table('kecamatans')->insert([
            ['nama_kecamatan' => 'Tomohon Barat'],
            ['nama_kecamatan' => 'Tomohon Selatan'],
            ['nama_kecamatan' => 'Tomohon Tengah'],
            ['nama_kecamatan' => 'Tomohon Timur'],
            ['nama_kecamatan' => 'Tomohon Utara'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};