<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aksi_konvergensis', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan', 255);
            $table->string('kelurahan', 255);
            $table->string('nama_aksi', 255);
            $table->boolean('selesai')->default(false);
            $table->integer('tahun');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aksi_konvergensis');
    }
};