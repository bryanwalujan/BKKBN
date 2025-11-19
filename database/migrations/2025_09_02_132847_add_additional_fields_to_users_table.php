<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('penanggung_jawab')->nullable()->after('kelurahan_id');
            $table->string('no_telepon')->nullable()->after('penanggung_jawab');
            $table->string('pas_foto')->nullable()->after('no_telepon');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['penanggung_jawab', 'no_telepon', 'pas_foto']);
        });
    }
};