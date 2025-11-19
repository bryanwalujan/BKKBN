<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catins', function (Blueprint $table) {
            $table->string('catin_wanita_nik', 500)->nullable()->change();
            $table->string('catin_wanita_no_hp', 500)->nullable()->change();
            $table->string('catin_pria_nik', 500)->nullable()->change();
            $table->string('catin_pria_no_hp', 500)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('catins', function (Blueprint $table) {
            $table->string('catin_wanita_nik', 255)->nullable()->change();
            $table->string('catin_wanita_no_hp', 255)->nullable()->change();
            $table->string('catin_pria_nik', 255)->nullable()->change();
            $table->string('catin_pria_no_hp', 255)->nullable()->change();
        });
    }
};
