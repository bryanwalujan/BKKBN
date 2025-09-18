<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGentingAttributesToGentingsTable extends Migration
{
    public function up()
    {
        Schema::table('gentings', function (Blueprint $table) {
            $table->foreignId('kartu_keluarga_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('dunia_usaha')->nullable();
            $table->string('dunia_usaha_frekuensi')->nullable();
            $table->string('pemerintah')->nullable();
            $table->string('pemerintah_frekuensi')->nullable();
            $table->string('bumn_bumd')->nullable();
            $table->string('bumn_bumd_frekuensi')->nullable();
            $table->string('individu_perseorangan')->nullable();
            $table->string('individu_perseorangan_frekuensi')->nullable();
            $table->string('lsm_komunitas')->nullable();
            $table->string('lsm_komunitas_frekuensi')->nullable();
            $table->string('swasta')->nullable();
            $table->string('swasta_frekuensi')->nullable();
            $table->string('perguruan_tinggi_akademisi')->nullable();
            $table->string('perguruan_tinggi_akademisi_frekuensi')->nullable();
            $table->string('media')->nullable();
            $table->string('media_frekuensi')->nullable();
            $table->string('tim_pendamping_keluarga')->nullable();
            $table->string('tim_pendamping_keluarga_frekuensi')->nullable();
            $table->string('tokoh_masyarakat')->nullable();
            $table->string('tokoh_masyarakat_frekuensi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('gentings', function (Blueprint $table) {
            $table->dropForeign(['kartu_keluarga_id']);
            $table->dropColumn([
                'kartu_keluarga_id',
                'dunia_usaha',
                'dunia_usaha_frekuensi',
                'pemerintah',
                'pemerintah_frekuensi',
                'bumn_bumd',
                'bumn_bumd_frekuensi',
                'individu_perseorangan',
                'individu_perseorangan_frekuensi',
                'lsm_komunitas',
                'lsm_komunitas_frekuensi',
                'swasta',
                'swasta_frekuensi',
                'perguruan_tinggi_akademisi',
                'perguruan_tinggi_akademisi_frekuensi',
                'media',
                'media_frekuensi',
                'tim_pendamping_keluarga',
                'tim_pendamping_keluarga_frekuensi',
                'tokoh_masyarakat',
                'tokoh_masyarakat_frekuensi',
            ]);
        });
    }
}