<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('referensis', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255)->unique();
            $table->text('deskripsi');
            $table->string('icon')->nullable();
            $table->string('pdf')->nullable();
            $table->enum('warna_icon', ['Biru', 'Merah', 'Hijau', 'Kuning'])->default('Biru');
            $table->string('link_file', 255)->nullable();
            $table->string('teks_tombol', 50);
            $table->integer('urutan');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referensis');
    }
};