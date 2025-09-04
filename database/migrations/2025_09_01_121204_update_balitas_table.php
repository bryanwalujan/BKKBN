<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->dropColumn('usia');
            $table->date('tanggal_lahir')->after('nama');
            $table->dropColumn('pemantauan');
            $table->string('status_pemantauan')->nullable()->after('status_gizi');
            $table->enum('warna_label', ['primary', 'warning', 'danger'])->after('status_gizi');
            $table->dropForeign(['kelurahan_id']);
            $table->dropColumn('kelurahan_id');
            $table->string('kelurahan')->after('berat_tinggi');
        });
    }

    public function down(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->integer('usia')->comment('Usia dalam bulan');
            $table->dropColumn('tanggal_lahir');
            $table->text('pemantauan')->nullable();
            $table->dropColumn('status_pemantauan');
            $table->dropColumn('warna_label');
            $table->foreignId('kelurahan_id')->constrained()->onDelete('cascade')->after('berat_tinggi');
            $table->dropColumn('kelurahan');
        });
    }
};