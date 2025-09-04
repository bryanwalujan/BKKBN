<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanan_kamis', function (Blueprint $table) {
            $table->id();
            $table->string('judul_layanan', 255);
            $table->text('deskripsi_singkat', 500);
            $table->text('deskripsi_lengkap')->nullable();
            $table->string('ikon');
            $table->integer('urutan');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
            $table->unique('judul_layanan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_kamis');
    }
};