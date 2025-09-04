<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->dropColumn('warna_label');
            $table->enum('warna_label', ['Sehat', 'Waspada', 'Bahaya'])->after('status_gizi');
        });
    }

    public function down(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->dropColumn('warna_label');
            $table->enum('warna_label', ['primary', 'warning', 'danger'])->after('status_gizi');
        });
    }
};