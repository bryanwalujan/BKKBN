<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pending_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin_kelurahan', 'perangkat_desa']);
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->string('penanggung_jawab');
            $table->string('no_telepon');
            $table->string('pas_foto')->nullable();
            $table->string('surat_pengajuan')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_users');
    }
};