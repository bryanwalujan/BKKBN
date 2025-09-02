<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pendamping_keluargas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('peran', 255);
            $table->string('kelurahan', 255);
            $table->string('kecamatan', 255);
            $table->string('status', 50);
            $table->integer('tahun_bergabung');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendamping_keluargas');
    }
};