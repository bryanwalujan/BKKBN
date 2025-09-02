<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('peta_geospasials', function (Blueprint $table) {
            $table->string('jenis', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peta_geospasials', function (Blueprint $table) {
            $table->string('jenis', 50)->nullable(false)->change();
        });
    }
};