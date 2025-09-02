<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('publikasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->enum('kategori', ['Berita', 'Artikel', 'Pengumuman', 'Lainnya']);
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->string('link_aksi', 255)->nullable();
            $table->string('teks_tombol', 50);
            $table->integer('urutan');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
            $table->unique(['judul', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publikasis');
    }
};