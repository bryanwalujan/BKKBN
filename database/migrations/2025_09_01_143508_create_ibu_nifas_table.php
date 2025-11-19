<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ibu_nifas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('kelurahan', 255);
            $table->string('kecamatan', 255);
            $table->integer('hari_nifas');
            $table->string('kondisi_kesehatan', 255);
            $table->enum('warna_kondisi', ['Hijau (success)', 'Kuning (warning)', 'Merah (danger)']);
            $table->decimal('berat', 5, 1);
            $table->decimal('tinggi', 5, 1);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ibu_nifas');
    }
};