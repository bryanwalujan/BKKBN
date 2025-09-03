<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('id');
            $table->string('alamat')->nullable()->after('kelurahan');
            $table->string('berat')->nullable()->change();
            $table->string('tinggi')->nullable()->change();
            $table->string('berat_tinggi')->nullable()->change();
            $table->string('status_gizi')->nullable()->change();
            $table->string('warna_label')->nullable()->change();
            $table->string('status_pemantauan')->nullable()->change();
            $table->string('foto')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->dropColumn(['nik', 'alamat']);
            $table->string('berat')->change();
            $table->string('tinggi')->change();
            $table->string('berat_tinggi')->change();
            $table->string('status_gizi')->change();
            $table->string('warna_label')->change();
            $table->string('status_pemantauan')->change();
            $table->string('foto')->change();
        });
    }
};