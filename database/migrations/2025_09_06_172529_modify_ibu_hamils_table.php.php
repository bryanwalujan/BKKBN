<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyIbuHamilsTable extends Migration
{
    public function up()
    {
        // Step 1: Backup data existing jika diperlukan
        // Atau hapus data yang tidak valid
        
        // Option 1: Hapus semua data di ibu_hamils (jika data tidak penting)
        DB::table('ibu_hamils')->truncate();
        
        // Option 2: Atau hapus data yang ibu_id nya tidak ada di tabel ibus
        // DB::statement('DELETE FROM ibu_hamils WHERE ibu_id NOT IN (SELECT id FROM ibus)');
        
        Schema::table('ibu_hamils', function (Blueprint $table) {
            // Pastikan kolom ibu_id sudah ada atau tambahkan dulu
            if (!Schema::hasColumn('ibu_hamils', 'ibu_id')) {
                $table->unsignedBigInteger('ibu_id')->after('id');
            }
            
            // Buat foreign key constraint
            $table->foreign('ibu_id')->references('id')->on('ibus')->onDelete('cascade');
            
            // Drop kolom yang tidak diperlukan jika ada
            $columnsToCheck = ['nama', 'kecamatan', 'kelurahan', 'foto'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('ibu_hamils', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down()
    {
        Schema::table('ibu_hamils', function (Blueprint $table) {
            // Tambahkan kembali kolom yang dihapus
            $table->string('nama')->after('id');
            $table->string('kecamatan')->after('nama');
            $table->string('kelurahan')->after('kecamatan');
            $table->string('foto')->nullable()->after('tinggi');
            
            // Drop foreign key dan kolom ibu_id
            $table->dropForeign(['ibu_id']);
            $table->dropColumn('ibu_id');
        });
    }
}