<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class monitorBaru extends Migration
{
    public function up()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->foreignId('kartu_keluarga_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            $table->text('perkembangan_anak')->nullable()->after('balita');
            $table->integer('kunjungan_rumah')->nullable()->after('perkembangan_anak');
            $table->string('frekuensi_kunjungan')->nullable()->after('kunjungan_rumah');
            $table->integer('pemberian_pmt')->nullable()->after('frekuensi_kunjungan');
            $table->string('frekuensi_pmt')->nullable()->after('pemberian_pmt');
            $table->text('hasil_audit_stunting')->nullable()->after('frekuensi_pmt');
        });
    }

    public function down()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->dropForeign(['kartu_keluarga_id']);
            $table->dropColumn([
                'kartu_keluarga_id',
                'perkembangan_anak',
                'kunjungan_rumah',
                'frekuensi_kunjungan',
                'pemberian_pmt',
                'frekuensi_pmt',
                'hasil_audit_stunting',
            ]);
        });
    }
}