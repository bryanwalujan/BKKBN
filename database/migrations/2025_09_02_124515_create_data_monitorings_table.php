<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('kelurahan', 100);
            $table->enum('kategori', ['Pencegahan Stunting', 'Gizi Balita', 'Kesehatan Ibu', 'Posyandu']);
            $table->string('balita', 255);
            $table->enum('status', ['Normal', 'Kurang Gizi', 'Stunting', 'Lainnya'])->default('Normal');
            $table->enum('warna_badge', ['Hijau', 'Kuning', 'Merah', 'Biru'])->default('Hijau');
            $table->date('tanggal_monitoring');
            $table->integer('urutan');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
            $table->unique(['nama', 'tanggal_monitoring']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_monitorings');
    }
};