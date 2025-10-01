<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kartu_keluargas', function (Blueprint $table) {
            $table->string('marker_color', 7)->nullable()->after('longitude');
            $table->index('marker_color');
        });

        // Update existing records dengan warna berdasarkan status
        $this->updateExistingMarkerColors();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kartu_keluarga', function (Blueprint $table) {
            $table->dropIndex(['marker_color']);
            $table->dropColumn('marker_color');
        });
    }

    /**
     * Update marker colors untuk data yang sudah ada
     */
    private function updateExistingMarkerColors()
    {
        $kartuKeluargas = \App\Models\KartuKeluarga::with(['balitas', 'remajaPutris'])->get();
        
        foreach ($kartuKeluargas as $kk) {
            $worstStatus = $this->getWorstStatus($kk);
            $kk->marker_color = $this->getMarkerColor($worstStatus);
            $kk->save();
        }
    }

    private function getMarkerColor($status)
    {
        if (!$status) {
            return '#3b82f6'; // Biru untuk Tidak Diketahui
        }

        $status = strtolower(trim($status));
        
        switch ($status) {
            case 'bahaya':
            case 'anemia berat':
                return '#dc2626'; // Merah
            case 'waspada':
            case 'anemia sedang':
                return '#f59e0b'; // Oranye
            case 'anemia ringan':
                return '#eab308'; // Kuning
            case 'sehat':
            case 'tidak anemia':
                return '#22c55e'; // Hijau
            default:
                return '#3b82f6'; // Biru
        }
    }

    private function getWorstStatus($kk)
    {
        $statuses = [];
        
        foreach ($kk->balitas as $balita) {
            if ($balita->status_gizi) {
                $statuses[] = strtolower(trim($balita->status_gizi));
            }
        }
        
        foreach ($kk->remajaPutris as $remaja) {
            if ($remaja->status_anemia) {
                $statuses[] = strtolower(trim($remaja->status_anemia));
            }
        }

        if (empty($statuses)) {
            return 'tidak diketahui';
        }

        if (in_array('bahaya', $statuses) || in_array('anemia berat', $statuses)) {
            return 'bahaya';
        }
        if (in_array('waspada', $statuses) || in_array('anemia sedang', $statuses)) {
            return 'waspada';
        }
        if (in_array('anemia ringan', $statuses)) {
            return 'anemia ringan';
        }
        if (in_array('sehat', $statuses) || in_array('tidak anemia', $statuses)) {
            return 'sehat';
        }

        return 'tidak diketahui';
    }
};