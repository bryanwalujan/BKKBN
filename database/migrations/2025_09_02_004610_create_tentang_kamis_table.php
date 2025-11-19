<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tentang_kamis', function (Blueprint $table) {
            $table->id();
            $table->string('sub_judul', 255);
            $table->string('judul_utama', 255);
            $table->text('paragraf_1');
            $table->text('paragraf_2')->nullable();
            $table->string('teks_tombol', 100)->nullable();
            $table->string('link_tombol', 255)->nullable();
            $table->string('gambar_utama');
            $table->string('gambar_overlay')->nullable();
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tentang_kamis');
    }
};