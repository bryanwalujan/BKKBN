<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_risets', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->integer('angka');
            $table->boolean('is_realtime')->default(false);
            $table->timestamp('tanggal_update')->useCurrent();
            $table->timestamps();
            $table->unique('judul');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_risets');
    }
};