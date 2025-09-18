<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class hapusAuditDariMonitor extends Migration
{
    public function up()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->dropColumn('hasil_audit_stunting');
        });
    }

    public function down()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->text('hasil_audit_stunting')->nullable();
        });
    }
}