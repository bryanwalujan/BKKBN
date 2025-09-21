<?php

namespace App\Http\Controllers;

use App\Models\PendingDataMonitoring;
use App\Models\DataMonitoring;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KecamatanDataMonitoringController extends Controller
{
    protected $realtimeKategori = [
        'Pencegahan Stunting',
        'Gizi Balita',
        'Kesehatan Ibu',
        'Posyandu',
    ];

    protected $statusOptions = [
        'Normal',
        'Kurang Gizi',
        'Stunting',
        'Lainnya',
    ];

    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'pending');
        $kelurahan_id = $request->query('kelurahan_id');
        $kategori = $request->query('kategori');
        $warna_badge = $request->query('warna_badge');

        $query = ($tab === 'verified') ? DataMonitoring::query() : PendingDataMonitoring::query();
        $query->with(['kartuKeluarga', 'ibu', 'balita', 'kecamatan', 'kelurahan', 'createdBy'])
              ->where('kecamatan_id', $user->kecamatan_id)
              ->orderBy('tanggal_monitoring', 'desc');

        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }
        if ($kategori && in_array($kategori, $this->realtimeKategori)) {
            $query->where('kategori', $kategori);
        }
        if ($warna_badge && in_array($warna_badge, ['Hijau', 'Kuning', 'Merah', 'Biru'])) {
            $query->where('warna_badge', $warna_badge);
        }

        $dataMonitorings = $query->paginate(10);
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        $kecamatan = Kecamatan::find($user->kecamatan_id);
        $kategoriOptions = $this->realtimeKategori;
        $warnaBadgeOptions = ['Hijau', 'Kuning', 'Merah', 'Biru'];

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
    }

    public function approve($id)
    {
        $user = Auth::user();
        $pendingData = PendingDataMonitoring::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id);

        try {
            if ($pendingData->status_verifikasi !== 'pending') {
                return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Data sudah diverifikasi.');
            }

            $data = $pendingData->toArray();
            unset($data['id', 'created_by', 'status_verifikasi', 'catatan', 'original_id', 'created_at', 'updated_at']);
            $dataMonitoring = DataMonitoring::updateOrCreate(
                ['id' => $pendingData->original_id],
                $data
            );

            $pendingData->update(['status_verifikasi' => 'approved']);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('success', 'Data Monitoring berhasil disetujui.');
        } catch (\Exception $e) {
            \Log::error('Error approving PendingDataMonitoring: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Gagal menyetujui data Monitoring: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        $pendingData = PendingDataMonitoring::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id);

        $validated = $request->validate([
            'catatan' => ['required', 'string'],
        ]);

        try {
            if ($pendingData->status_verifikasi !== 'pending') {
                return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Data sudah diverifikasi.');
            }

            $pendingData->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $validated['catatan'],
            ]);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('success', 'Data Monitoring berhasil ditolak.');
        } catch (\Exception $e) {
            \Log::error('Error rejecting PendingDataMonitoring: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.data_monitoring.index', ['tab' => 'pending'])->with('error', 'Gagal menolak data Monitoring: ' . $e->getMessage());
        }
    }
}