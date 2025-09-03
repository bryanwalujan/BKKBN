<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom kelurahan_id jika ada
            if (Schema::hasColumn('users', 'kelurahan_id')) {
                $table->dropForeign(['kelurahan_id']);
                $table->dropColumn('kelurahan_id');
            }
            // Tambahkan kolom kecamatan_id
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan perubahan
            $table->dropForeign(['kecamatan_id']);
            $table->dropColumn('kecamatan_id');
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('set null');
        });
    }
};