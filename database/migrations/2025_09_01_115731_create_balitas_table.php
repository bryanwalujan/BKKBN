<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('balitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('usia')->comment('Usia dalam bulan');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('berat_tinggi')->comment('Format: Berat (kg) / Tinggi (cm), e.g., 10/70');
            $table->foreignId('kelurahan_id')->constrained()->onDelete('cascade');
            $table->string('kecamatan');
            $table->enum('status_gizi', ['Sehat', 'Stunting', 'Kurang Gizi', 'Obesitas']);
            $table->text('pemantauan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('balitas');
    }
};