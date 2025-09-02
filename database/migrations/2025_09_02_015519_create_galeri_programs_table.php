<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('galeri_programs', function (Blueprint $table) {
            $table->id();
            $table->string('gambar');
            $table->string('judul', 255);
            $table->text('deskripsi');
            $table->enum('kategori', ['Penyuluhan', 'Posyandu', 'Pendampingan', 'Lainnya']);
            $table->string('link', 255)->nullable();
            $table->integer('urutan');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
            $table->unique(['judul', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_programs');
    }
};