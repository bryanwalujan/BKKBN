<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gentings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan', 255);
            $table->date('tanggal');
            $table->string('lokasi', 255);
            $table->string('sasaran', 255);
            $table->string('jenis_intervensi', 255);
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gentings');
    }
};