<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('remaja_putris', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('sekolah', 255);
            $table->string('kelas', 50);
            $table->integer('umur');
            $table->enum('status_anemia', ['Tidak Anemia', 'Anemia Ringan', 'Anemia Sedang', 'Anemia Berat']);
            $table->enum('konsumsi_ttd', ['Rutin', 'Tidak Rutin', 'Tidak Konsumsi']);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remaja_putris');
    }
};