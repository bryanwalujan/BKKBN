<?php
namespace App\Http\Controllers;

use App\Models\PendingDataMonitoring;
use App\Models\DataMonitoring;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KecamatanDataMonitoringController extends Controller
{
    protected $realtimeKategori = [
        'Pencegahan Stunting',
        'Gizi Balita',
        'Kesehatan Ibu',
        'Posyandu',
    ];

    protected $warnaBadgeOptions = [
        'Hijau' => '#22c55e',
        'Kuning' => '#eab308',
        'Merah' => '#dc2626',
        'Biru' => '#3b82f6',
    ];

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin_kecamatan']);
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user->kecamatan_id) {
                Log::warning('Admin kecamatan tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
                return redirect()->route('dashboard')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
            }

            $tab = $request->query('tab', 'pending');
            $kelurahan_id = $request->query('kelurahan_id', '');
            $kategori = $request->query('kategori', '');
            $warna_badge = $request->query('warna_badge', '');

            // Validasi input
            if ($kategori && !in_array($kategori, $this->realtimeKategori)) {
                Log::warning('Kategori tidak valid', ['kategori' => $kategori, 'user_id' => $user->id]);
                $kategori = '';
            }
            if ($warna_badge && !array_key_exists($warna_badge, $this->warnaBadgeOptions)) {
                Log::warning('Warna badge tidak valid', ['warna_badge' => $warna_badge, 'user_id' => $user->id]);
                $warna_badge = '';
            }

            // Query data berdasarkan tab
            $query = ($tab === 'verified') ? DataMonitoring::query() : PendingDataMonitoring::query();
            $query->with(['kartuKeluarga', 'ibu', 'balita', 'kecamatan', 'kelurahan'])
                  ->where('kecamatan_id', $user->kecamatan_id)
                  ->orderBy('tanggal_monitoring', 'desc');

            // Terapkan filter
            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }
            if ($kategori) {
                $query->where('kategori', $kategori);
            }
            if ($warna_badge) {
                $query->where('warna_badge', $warna_badge);
            }

            // Ambil data dengan paginasi
            $dataMonitorings = $query->paginate(10);
            $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
            $kecamatan = Kecamatan::find($user->kecamatan_id);
            $kategoriOptions = $this->realtimeKategori;
            $warnaBadgeOptions = array_keys($this->warnaBadgeOptions);

            // Log hasil query
            Log::info('Data monitoring diambil', [
                'tab' => $tab,
                'kecamatan_id' => $user->kecamatan_id,
                'kelurahan_id' => $kelurahan_id ?: 'none',
                'kategori' => $kategori ?: 'none',
                'warna_badge' => $warna_badge ?: 'none',
                'total' => $dataMonitorings->total(),
                'sample_data' => $dataMonitorings->take(3)->map(function($item) {
                    return [
                        'id' => $item->id,
                        'kartu_keluarga_id' => $item->kartu_keluarga_id,
                        'kategori' => $item->kategori,
                        'warna_badge' => $item->warna_badge
                    ];
                })->toArray()
            ]);

            return view('kecamatan.data_monitoring.index', compact(
                'dataMonitorings',
                'kecamatan',
                'kelurahans',
                'kelurahan_id',
                'kategori',
                'warna_badge',
                'kategoriOptions',
                'warnaBadgeOptions',
                'tab'
            ));
        } catch (\Exception $e) {
            Log::error('Gagal memuat data monitoring: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return view('kecamatan.data_monitoring.index', [
                'dataMonitorings' => collect([])->paginate(10),
                'kecamatan' => null,
                'kelurahans' => collect([]),
                'kelurahan_id' => '',
                'kategori' => '',
                'warna_badge' => '',
                'kategoriOptions' => $this->realtimeKategori,
                'warnaBadgeOptions' => array_keys($this->warnaBadgeOptions),
                'tab' => $tab,
                'errorMessage' => 'Gagal memuat data monitoring: ' . $e->getMessage()
            ]);
        }
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Admin kecamatan tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $pendingData = PendingDataMonitoring::where('kecamatan_id', $user->kecamatan_id)
            ->where('status_verifikasi', 'pending')
            ->findOrFail($id);

        try {
            $data = $pendingData->toArray();
            unset(
                $data['id'],
                $data['created_by'],
                $data['status_verifikasi'],
                $data['catatan'],
                $data['original_id'],
                $data['created_at'],
                $data['updated_at']
            );

            $dataMonitoring = DataMonitoring::updateOrCreate(
                ['id' => $pendingData->original_id],
                $data
            );

            $pendingData->update(['status_verifikasi' => 'approved']);
            $pendingData->delete();

            Log::info('Data monitoring disetujui', [
                'pending_id' => $id,
                'data_monitoring_id' => $dataMonitoring->id,
                'user_id' => $user->id
            ]);

            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('success', 'Data Monitoring berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Error approving PendingDataMonitoring: ' . $e->getMessage(), [
                'id' => $id,
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Gagal menyetujui data Monitoring: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Admin kecamatan tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $pendingData = PendingDataMonitoring::where('kecamatan_id', $user->kecamatan_id)
            ->where('status_verifikasi', 'pending')
            ->findOrFail($id);

        try {
            $validated = $request->validate([
                'catatan' => ['required', 'string', 'max:1000'],
            ]);

            $pendingData->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $validated['catatan'],
            ]);
            $pendingData->delete();

            Log::info('Data monitoring ditolak', [
                'pending_id' => $id,
                'catatan' => $validated['catatan'],
                'user_id' => $user->id
            ]);

            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('success', 'Data Monitoring ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Error rejecting PendingDataMonitoring: ' . $e->getMessage(), [
                'id' => $id,
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Gagal menolak data Monitoring: ' . $e->getMessage());
        }
    }
}