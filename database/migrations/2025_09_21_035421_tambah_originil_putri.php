<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk menambahkan kolom original_remaja_putri_id.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pending_remaja_putris', function (Blueprint $table) {
            $table->unsignedBigInteger('original_remaja_putri_id')->nullable()->after('created_by');
            $table->foreign('original_remaja_putri_id')
                  ->references('id')
                  ->on('remaja_putris')
                  ->onDelete('set null');
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus kolom original_remaja_putri_id.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pending_remaja_putris', function (Blueprint $table) {
            $table->dropForeign(['original_remaja_putri_id']);
            $table->dropColumn('original_remaja_putri_id');
        });
    }
};