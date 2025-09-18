<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing role column
            $table->dropColumn('role');
            // Add new role column with updated enum values
            $table->enum('role', ['master', 'admin_kecamatan', 'admin_kelurahan', 'perangkat_daerah'])
                  ->default('perangkat_daerah')
                  ->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the new role column
            $table->dropColumn('role');
            // Restore the old role column
            $table->enum('role', ['master', 'admin_kelurahan', 'perangkat_desa'])
                  ->default('perangkat_desa')
                  ->after('updated_at');
        });
    }
};