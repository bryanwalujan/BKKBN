<?php
namespace App\Http\Controllers;

use App\Models\DataRiset;
use App\Models\Kecamatan;
use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:master']);
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $dataRisets = DataRiset::where('is_realtime', true)->get();
            $kecamatanCount = Kecamatan::count();
            $backupCount = Backup::count(); // Asumsi model Backup ada untuk riwayat backup

            // Log pengambilan data
            Log::info('Data dashboard diambil', [
                'user_id' => $user->id,
                'data_risets_count' => $dataRisets->count(),
                'kecamatan_count' => $kecamatanCount,
                'backup_count' => $backupCount,
                'sample_risets' => $dataRisets->take(3)->map(function($item) {
                    return [
                        'id' => $item->id,
                        'judul' => $item->judul,
                        'angka' => $item->angka,
                        'tanggal_update' => $item->tanggal_update
                    ];
                })->toArray()
            ]);

            return view('master.dashboard', compact(
                'dataRisets',
                'kecamatanCount',
                'backupCount'
            ));
        } catch (\Exception $e) {
            Log::error('Gagal memuat data dashboard: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return view('master.dashboard', [
                'dataRisets' => collect([]),
                'kecamatanCount' => 0,
                'backupCount' => 0,
                'errorMessage' => 'Gagal memuat data dashboard: ' . $e->getMessage()
            ]);
        }
    }
}