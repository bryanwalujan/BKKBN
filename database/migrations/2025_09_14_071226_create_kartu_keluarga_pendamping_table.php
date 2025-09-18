<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kartu_keluarga_pendamping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendamping_keluarga_id')->constrained('pendamping_keluargas')->onDelete('cascade');
            $table->foreignId('kartu_keluarga_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kartu_keluarga_pendamping');
    }
};