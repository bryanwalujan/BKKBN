<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pending_users', function (Blueprint $table) {
            $table->string('penanggung_jawab', 255)->change();
            $table->string('no_telepon', 15)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pending_users', function (Blueprint $table) {
            $table->text('penanggung_jawab')->change();
            $table->text('no_telepon')->change();
        });
    }
};