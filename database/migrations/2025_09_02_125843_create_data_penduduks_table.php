<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_penduduks', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('jumlah_penduduk');
            $table->integer('urutan');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
            $table->unique('tahun');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_penduduks');
    }
};