<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pending_users', function (Blueprint $table) {
            $table->string('kelurahan_nama')->nullable()->after('kelurahan_id');
        });
    }

    public function down(): void
    {
        Schema::table('pending_users', function (Blueprint $table) {
            $table->dropColumn('kelurahan_nama');
        });
    }
};