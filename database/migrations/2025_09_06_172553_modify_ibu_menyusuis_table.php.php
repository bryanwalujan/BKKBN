<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyIbuMenyusuisTable extends Migration
{
    public function up()
    {
        // Tambahkan kolom ibu_id sebagai nullable terlebih dahulu
        Schema::table('ibu_menyusuis', function (Blueprint $table) {
            $table->unsignedBigInteger('ibu_id')->nullable()->after('id');
        });

        // Migrasi data ke tabel ibus
        $ibuMenyusuis = DB::table('ibu_menyusuis')->whereNull('ibu_id')->get();
        foreach ($ibuMenyusuis as $ibu) {
            $kecamatan = DB::table('kecamatans')->where('nama_kecamatan', $ibu->kecamatan)->first();
            $kelurahan = DB::table('kelurahans')->where('nama_kelurahan', $ibu->kelurahan)->first();
            $ibuId = DB::table('ibus')->insertGetId([
                'nik' => null, // Ganti dengan $ibu->nik jika tersedia
                'nama' => $ibu->nama,
                'kecamatan_id' => $kecamatan ? $kecamatan->id : 1,
                'kelurahan_id' => $kelurahan ? $kelurahan->id : 1,
                'kartu_keluarga_id' => 1, // Ganti dengan ID kartu keluarga yang sesuai
                'alamat' => null,
                'status' => 'Menyusui',
                'foto' => $ibu->foto,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('ibu_menyusuis')->where('id', $ibu->id)->update(['ibu_id' => $ibuId]);
        }

        // Tambahkan foreign key constraint dan hapus kolom lama
        Schema::table('ibu_menyusuis', function (Blueprint $table) {
            $table->foreign('ibu_id')->references('id')->on('ibus')->onDelete('cascade');
            $table->dropColumn(['nama', 'kecamatan', 'kelurahan', 'foto']);
        });
    }

    public function down()
    {
        Schema::table('ibu_menyusuis', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->string('kecamatan')->after('nama');
            $table->string('kelurahan')->after('kecamatan');
            $table->string('foto')->nullable()->after('tinggi');
            $table->dropForeign(['ibu_id']);
            $table->dropColumn('ibu_id');
        });
    }
}