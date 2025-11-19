<?php

namespace App\Http\Controllers;

use App\Models\DataMonitoring;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use App\Models\Ibu;
use App\Models\Balita;
use App\Models\AuditStunting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DataMonitoringController extends Controller
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
        $kelurahan_id = $request->query('kelurahan_id');
        $kecamatan_id = $request->query('kecamatan_id');
        $kategori = $request->query('kategori');
        $warna_badge = $request->query('warna_badge');
        $query = DataMonitoring::with(['kartuKeluarga', 'ibu', 'balita', 'kecamatan', 'kelurahan', 'user'])
            ->orderBy('tanggal_monitoring', 'desc');

        if ($kecamatan_id) {
            $query->where('kecamatan_id', $kecamatan_id);
        }
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
        $kecamatans = Kecamatan::all();
        $kelurahans = $kecamatan_id ? Kelurahan::where('kecamatan_id', $kecamatan_id)->get() : collect([]);
        $kategoriOptions = $this->realtimeKategori;
        $warnaBadgeOptions = ['Hijau', 'Kuning', 'Merah', 'Biru'];

        return view('master.data_monitoring.index', compact(
            'dataMonitorings',
            'kecamatans',
            'kelurahans',
            'kecamatan_id',
            'kelurahan_id',
            'kategori',
            'warna_badge',
            'kategoriOptions',
            'warnaBadgeOptions'
        ));
    }

    public function create(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $kartu_keluarga_id = $request->query('kartu_keluarga_id');
        $kartuKeluarga = $kartu_keluarga_id ? KartuKeluarga::with(['kecamatan', 'kelurahan'])->find($kartu_keluarga_id) : null;
        $kelurahans = $kartuKeluarga ? Kelurahan::where('kecamatan_id', $kartuKeluarga->kecamatan_id)->get() : collect([]);
        $kategoriOptions = $this->realtimeKategori;
        $statusOptions = $this->statusOptions;

        return view('master.data_monitoring.create', compact(
            'kecamatans',
            'kartuKeluarga',
            'kelurahans',
            'kategoriOptions',
            'statusOptions'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'target' => ['required', 'in:Ibu,Balita'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
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
            'terpapar_rokok' => ['nullable', 'in:0,1'],
            'suplemen_ttd' => ['nullable', 'in:0,1'],
            'rujukan' => ['nullable', 'in:0,1'],
            'bantuan_sosial' => ['nullable', 'in:0,1'],
            'posyandu_bkb' => ['nullable', 'in:0,1'],
            'kie' => ['nullable', 'in:0,1'],
        ]);

        try {
            $validated['nama'] = $request->target === 'Ibu'
                ? Ibu::findOrFail($request->ibu_id)->nama
                : Balita::findOrFail($request->balita_id)->nama;
            $validated['created_by'] = Auth::id();

            $dataMonitoring = DataMonitoring::create($validated);
            return redirect()->route('kartu_keluarga.show', $request->kartu_keluarga_id)->with('success', 'Data Monitoring berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Error storing DataMonitoring: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Monitoring: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $dataMonitoring = DataMonitoring::with(['kartuKeluarga', 'ibu', 'balita', 'kecamatan', 'kelurahan', 'auditStunting'])->findOrFail($id);
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::where('kecamatan_id', $dataMonitoring->kecamatan_id)->get();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $dataMonitoring->kecamatan_id)
            ->where('kelurahan_id', $dataMonitoring->kelurahan_id)
            ->get();
        $target = $dataMonitoring->ibu_id ? 'Ibu' : 'Balita';
        $users = User::all();
        $kategoriOptions = $this->realtimeKategori;
        $statusOptions = $this->statusOptions;

        return view('master.data_monitoring.edit', compact(
            'dataMonitoring',
            'kecamatans',
            'kelurahans',
            'kartuKeluargas',
            'target',
            'users',
            'kategoriOptions',
            'statusOptions'
        ));
    }

    public function update(Request $request, $id)
    {
        $dataMonitoring = DataMonitoring::findOrFail($id);

        $validated = $request->validate([
            'target' => ['required', 'in:Ibu,Balita'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
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
            'terpapar_rokok' => ['nullable', 'in:0,1'],
            'suplemen_ttd' => ['nullable', 'in:0,1'],
            'rujukan' => ['nullable', 'in:0,1'],
            'bantuan_sosial' => ['nullable', 'in:0,1'],
            'posyandu_bkb' => ['nullable', 'in:0,1'],
            'kie' => ['nullable', 'in:0,1'],
            'audit_user_id' => ['nullable', 'exists:users,id'],
            'audit_foto_dokumentasi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'audit_pihak_pengaudit' => ['nullable', 'string', 'max:255'],
            'audit_laporan' => ['nullable', 'string'],
            'audit_narasi' => ['nullable', 'string'],
        ]);

        try {
            $validated['nama'] = $request->target === 'Ibu'
                ? Ibu::findOrFail($request->ibu_id)->nama
                : Balita::findOrFail($request->balita_id)->nama;
            $validated['created_by'] = Auth::id();

            $dataMonitoring->update($validated);

            // Handle audit stunting
            if ($request->filled('audit_user_id')) {
                $auditData = [
                    'data_monitoring_id' => $dataMonitoring->id,
                    'user_id' => $request->audit_user_id,
                    'pihak_pengaudit' => $request->audit_pihak_pengaudit,
                    'laporan' => $request->audit_laporan,
                    'narasi' => $request->audit_narasi,
                ];

                if ($request->hasFile('audit_foto_dokumentasi')) {
                    if ($dataMonitoring->auditStunting && $dataMonitoring->auditStunting->foto_dokumentasi) {
                        Storage::disk('public')->delete($dataMonitoring->auditStunting->foto_dokumentasi);
                    }
                    $auditData['foto_dokumentasi'] = $request->file('audit_foto_dokumentasi')->store('audit_stunting', 'public');
                }

                if ($dataMonitoring->auditStunting) {
                    $dataMonitoring->auditStunting->update($auditData);
                } else {
                    AuditStunting::create($auditData);
                }
            }

            return redirect()->route('kartu_keluarga.show', $request->kartu_keluarga_id)->with('success', 'Data Monitoring berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating DataMonitoring: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data Monitoring: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $dataMonitoring = DataMonitoring::findOrFail($id);
            $kartuKeluargaId = $dataMonitoring->kartu_keluarga_id;
            $dataMonitoring->delete();
            return redirect()->route('kartu_keluarga.show', $kartuKeluargaId)->with('success', 'Data Monitoring berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error deleting DataMonitoring: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('data_monitoring.index')->with('error', 'Gagal menghapus data Monitoring: ' . $e->getMessage());
        }
    }

    public function refresh()
    {
        try {
            $dataMonitorings = DataMonitoring::whereIn('kategori', $this->realtimeKategori)->get();
            foreach ($dataMonitorings as $dataMonitoring) {
                $dataMonitoring->update(['tanggal_update' => now()]);
            }
            return redirect()->route('data_monitoring.index')->with('success', 'Data Monitoring berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error refreshing DataMonitoring: ' . $e->getMessage());
            return redirect()->route('data_monitoring.index')->with('error', 'Gagal memperbarui data Monitoring: ' . $e->getMessage());
        }
    }
}