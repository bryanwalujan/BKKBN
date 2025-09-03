<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->string('nik')->nullable()->unique()->after('id');
            $table->string('alamat')->nullable()->after('kelurahan');
        });
    }

    public function down(): void
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->dropColumn(['nik', 'alamat']);
        });
    }
};