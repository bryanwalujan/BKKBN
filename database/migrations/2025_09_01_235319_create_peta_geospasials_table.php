<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peta_geospasials', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi', 255);
            $table->string('kecamatan', 255);
            $table->string('kelurahan', 255);
            $table->string('status', 50);
            $table->double('latitude');
            $table->double('longitude');
            $table->string('jenis', 50);
            $table->string('warna_marker', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peta_geospasials');
    }
};