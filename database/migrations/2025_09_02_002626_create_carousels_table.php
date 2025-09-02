<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('sub_heading', 255);
            $table->string('heading', 255);
            $table->text('deskripsi');
            $table->string('button_1_text', 100)->nullable();
            $table->string('button_1_link', 255)->nullable();
            $table->string('button_2_text', 100)->nullable();
            $table->string('button_2_link', 255)->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carousels');
    }
};