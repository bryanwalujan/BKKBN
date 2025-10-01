<?php

namespace App\Http\Controllers;

use App\Models\DataMonitoring;
use App\Models\PendingDataMonitoring;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use App\Models\Ibu;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerangkatDaerahDataMonitoringController extends Controller
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
        $query->with(['kartuKeluarga', 'ibu', 'balita', 'kecamatan', 'kelurahan'])
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

        if ($tab === 'pending') {
            $query->where('status_verifikasi', 'pending')
                  ->where('created_by', $user->id);
        }

        $dataMonitorings = $query->paginate(10);
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        $kecamatan = Kecamatan::find($user->kecamatan_id);
        $kategoriOptions = $this->realtimeKategori;
        $warnaBadgeOptions = ['Hijau', 'Kuning', 'Merah', 'Biru'];

        return view('perangkat_daerah.data_monitoring.index', compact(
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

    public function create(Request $request)
    {
        $user = Auth::user();
        $kecamatan = Kecamatan::find($user->kecamatan_id);
        $kartu_keluarga_id = $request->query('kartu_keluarga_id');
        $kartuKeluarga = $kartu_keluarga_id ? KartuKeluarga::with(['kecamatan', 'kelurahan'])->find($kartu_keluarga_id) : null;
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        $kategoriOptions = $this->realtimeKategori;
        $statusOptions = $this->statusOptions;

        return view('perangkat_daerah.data_monitoring.create', compact(
            'kecamatan',
            'kartuKeluarga',
            'kelurahans',
            'kategoriOptions',
            'statusOptions'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'target' => ['required', 'in:Ibu,Balita'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'ibu_id' => ['nullable', 'exists:ibus,id', 'required_if:target,Ibu'],
            'balita_id' => ['nullable', 'exists:balitas,id', 'required_if:target,Balita'],
            'kategori' => ['required', 'in:' . implode(',', $this->realtimeKategori)],
            'perkembangan_anak' => ['nullable', 'string'],
            'kunjungan_rumah' => ['nullable', 'in:0,1'],
            'frekuensi_kunjungan' => ['nullable', 'in:Per Minggu,Per Bulan,Per 3 Bulan'],
            'pemberian_pmt' => ['nullable', 'in:0,1'],
            'frekuensi_pmt' => ['nullable', 'in:Per Minggu,Per Bulan,Per 3 Bulan'],
            'status' => ['required', 'in:' . implode(',', $this->statusOptions)],
            'warna_badge' => ['required', 'in:Hijau,Kuning,Merah,Biru'],
            'tanggal_monitoring' => ['required', 'date'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['required', 'boolean'],
        ]);

        try {
            $validated['nama'] = $request->target === 'Ibu'
                ? Ibu::findOrFail($request->ibu_id)->nama
                : Balita::findOrFail($request->balita_id)->nama;
            $validated['kecamatan_id'] = $user->kecamatan_id;
            $validated['created_by'] = $user->id;
            $validated['status_verifikasi'] = 'pending';

            PendingDataMonitoring::create($validated);
            return redirect()->route('perangkat_daerah.data_monitoring.index', ['tab' => 'pending'])->with('success', 'Data Monitoring berhasil diajukan untuk verifikasi.');
        } catch (\Exception $e) {
            \Log::error('Error storing PendingDataMonitoring: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan data Monitoring: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        $dataMonitoring = ($source === 'verified') 
            ? DataMonitoring::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id)
            : PendingDataMonitoring::where('kecamatan_id', $user->kecamatan_id)
                  ->where('status_verifikasi', 'pending')
                  ->where('created_by', $user->id)
                  ->findOrFail($id);
        $kecamatan = Kecamatan::find($user->kecamatan_id);
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('kelurahan_id', $dataMonitoring->kelurahan_id)
            ->get();
        $target = $dataMonitoring->ibu_id ? 'Ibu' : 'Balita';
        $kategoriOptions = $this->realtimeKategori;
        $statusOptions = $this->statusOptions;

        return view('perangkat_daerah.data_monitoring.edit', compact(
            'dataMonitoring',
            'kecamatan',
            'kelurahans',
            'kartuKeluargas',
            'target',
            'kategoriOptions',
            'statusOptions',
            'source'
        ));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        $dataMonitoring = ($source === 'verified') 
            ? DataMonitoring::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id)
            : PendingDataMonitoring::where('kecamatan_id', $user->kecamatan_id)
                  ->where('status_verifikasi', 'pending')
                  ->where('created_by', $user->id)
                  ->findOrFail($id);

        $validated = $request->validate([
            'target' => ['required', 'in:Ibu,Balita'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'ibu_id' => ['nullable', 'exists:ibus,id', 'required_if:target,Ibu'],
            'balita_id' => ['nullable', 'exists:balitas,id', 'required_if:target,Balita'],
            'kategori' => ['required', 'in:' . implode(',', $this->realtimeKategori)],
            'perkembangan_anak' => ['nullable', 'string'],
            'kunjungan_rumah' => ['nullable', 'in:0,1'],
            'frekuensi_kunjungan' => ['nullable', 'in:Per Minggu,Per Bulan,Per 3 Bulan'],
            'pemberian_pmt' => ['nullable', 'in:0,1'],
            'frekuensi_pmt' => ['nullable', 'in:Per Minggu,Per Bulan,Per 3 Bulan'],
            'status' => ['required', 'in:' . implode(',', $this->statusOptions)],
            'warna_badge' => ['required', 'in:Hijau,Kuning,Merah,Biru'],
            'tanggal_monitoring' => ['required', 'date'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['required', 'boolean'],
        ]);

        try {
            $validated['nama'] = $request->target === 'Ibu'
                ? Ibu::findOrFail($request->ibu_id)->nama
                : Balita::findOrFail($request->balita_id)->nama;
            $validated['kecamatan_id'] = $user->kecamatan_id;

            if ($source === 'verified') {
                // Jika data verified, buat entri baru di pending untuk perubahan
                $validated['created_by'] = $user->id;
                $validated['status_verifikasi'] = 'pending';
                $validated['original_id'] = $dataMonitoring->id;
                PendingDataMonitoring::create($validated);
                $message = 'Perubahan Data Monitoring berhasil diajukan untuk verifikasi.';
            } else {
                // Update data pending
                $dataMonitoring->update($validated);
                $message = 'Data Monitoring berhasil diperbarui dan menunggu verifikasi.';
            }

            return redirect()->route('perangkat_daerah.data_monitoring.index', ['tab' => 'pending'])->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Error updating PendingDataMonitoring: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data Monitoring: ' . $e->getMessage());
        }
    }

    public function destroy($id, $source = 'pending')
    {
        $user = Auth::user();
        if ($source === 'verified') {
            return redirect()->route('perangkat_daerah.data_monitoring.index', ['tab' => 'verified'])
                ->with('error', 'Data Monitoring yang sudah terverifikasi tidak dapat dihapus.');
        }

        try {
            $dataMonitoring = PendingDataMonitoring::where('kecamatan_id', $user->kecamatan_id)
                ->where('status_verifikasi', 'pending')
                ->where('created_by', $user->id)
                ->findOrFail($id);
            $dataMonitoring->delete();
            return redirect()->route('perangkat_daerah.data_monitoring.index', ['tab' => 'pending'])
                ->with('success', 'Data Monitoring berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error deleting PendingDataMonitoring: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('perangkat_daerah.data_monitoring.index', ['tab' => 'pending'])
                ->with('error', 'Gagal menghapus data Monitoring: ' . $e->getMessage());
        }
    }

    public function getKelurahansByKecamatan($kecamatan_id)
    {
        $user = Auth::user();
        if ($user->kecamatan_id != $kecamatan_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($kelurahans);
    }

    public function getKartuKeluargaByKelurahan($kelurahan_id)
    {
        $user = Auth::user();
        $kelurahan = Kelurahan::where('id', $kelurahan_id)->where('kecamatan_id', $user->kecamatan_id)->first();
        if (!$kelurahan) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $kelurahan_id)->get();
        return response()->json($kartuKeluargas);
    }

    public function getIbuAndBalita($kartu_keluarga_id)
    {
        $user = Auth::user();
        $kartuKeluarga = KartuKeluarga::where('id', $kartu_keluarga_id)->where('kecamatan_id', $user->kecamatan_id)->first();
        if (!$kartuKeluarga) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $ibus = Ibu::where('kartu_keluarga_id', $kartu_keluarga_id)->get();
        $balitas = Balita::where('kartu_keluarga_id', $kartu_keluarga_id)->get();
        return response()->json(['ibus' => $ibus, 'balitas' => $balitas]);
    }
}