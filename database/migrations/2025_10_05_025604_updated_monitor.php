<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->boolean('terpapar_rokok')->nullable();
            $table->boolean('suplemen_ttd')->nullable();
            $table->boolean('rujukan')->nullable();
            $table->boolean('bantuan_sosial')->nullable();
            $table->boolean('posyandu_bkb')->nullable();
            $table->boolean('kie')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'terpapar_rokok',
                'suplemen_ttd',
                'rujukan',
                'bantuan_sosial',
                'posyandu_bkb',
                'kie',
                'created_by'
            ]);
        });
    }
};