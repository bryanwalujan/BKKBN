<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbusTable extends Migration
{
    public function up()
    {
        Schema::create('ibus', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable()->unique();
            $table->string('nama');
            $table->foreignId('kecamatan_id')->constrained('kecamatans')->onDelete('restrict');
            $table->foreignId('kelurahan_id')->constrained('kelurahans')->onDelete('restrict');
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluargas')->onDelete('restrict');
            $table->text('alamat')->nullable();
            $table->enum('status', ['Hamil', 'Nifas', 'Menyusui', 'Tidak Aktif'])->default('Tidak Aktif');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ibus');
    }
}