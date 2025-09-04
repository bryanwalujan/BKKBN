<?php
namespace App\Http\Controllers;

use App\Models\DataMonitoring;
use App\Models\DataRiset;
use Illuminate\Http\Request;

class DataMonitoringController extends Controller
{
    protected $realtimeKategori = [
        'Pencegahan Stunting',
        'Gizi Balita',
        'Kesehatan Ibu',
        'Posyandu',
    ];

    public function index(Request $request)
    {
        $kelurahan = $request->query('kelurahan');
        $kategori = $request->query('kategori');
        $warna_badge = $request->query('warna_badge');
        $query = DataMonitoring::orderBy('urutan');

        if ($kelurahan) {
            $query->where('kelurahan', 'like', '%' . $kelurahan . '%');
        }
        if ($kategori && in_array($kategori, ['Pencegahan Stunting', 'Gizi Balita', 'Kesehatan Ibu', 'Posyandu'])) {
            $query->where('kategori', $kategori);
        }
        if ($warna_badge && in_array($warna_badge, ['Hijau', 'Kuning', 'Merah', 'Biru'])) {
            $query->where('warna_badge', $warna_badge);
        }

        $dataMonitorings = $query->paginate(10);
        $dataRiset = DataRiset::whereIn('judul', $this->realtimeKategori)->pluck('angka', 'judul');
        $kategoriOptions = ['Pencegahan Stunting', 'Gizi Balita', 'Kesehatan Ibu', 'Posyandu'];
        $warnaBadgeOptions = ['Hijau', 'Kuning', 'Merah', 'Biru'];

        return view('master.data_monitoring.index', compact('dataMonitorings', 'dataRiset', 'kelurahan', 'kategori', 'warna_badge', 'kategoriOptions', 'warnaBadgeOptions'));
    }

    public function create()
    {
        return view('master.data_monitoring.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'in:Pencegahan Stunting,Gizi Balita,Kesehatan Ibu,Posyandu'],
            'balita' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Normal,Kurang Gizi,Stunting,Lainnya'],
            'warna_badge' => ['required', 'in:Hijau,Kuning,Merah,Biru'],
            'tanggal_monitoring' => ['required', 'date'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ]);

        $data = $request->all();
        $data['warna_badge'] = $request->status === 'Normal' && !$request->has('warna_badge') ? 'Hijau' : $request->warna_badge;
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        DataMonitoring::create($data);

        return redirect()->route('data_monitoring.index')->with('success', 'Data Monitoring berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dataMonitoring = DataMonitoring::findOrFail($id);
        return view('master.data_monitoring.edit', compact('dataMonitoring'));
    }

    public function update(Request $request, $id)
    {
        $dataMonitoring = DataMonitoring::findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'in:Pencegahan Stunting,Gizi Balita,Kesehatan Ibu,Posyandu'],
            'balita' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:Normal,Kurang Gizi,Stunting,Lainnya'],
            'warna_badge' => ['required', 'in:Hijau,Kuning,Merah,Biru'],
            'tanggal_monitoring' => ['required', 'date'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['nullable','in:on'],
        ]);

        $data = $request->all();
        $data['warna_badge'] = $request->status === 'Normal' && !$request->has('warna_badge') ? 'Hijau' : $request->warna_badge;
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        $dataMonitoring->update($data);

        return redirect()->route('data_monitoring.index')->with('success', 'Data Monitoring berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dataMonitoring = DataMonitoring::findOrFail($id);
        $dataMonitoring->delete();

        return redirect()->route('data_monitoring.index')->with('success', 'Data Monitoring berhasil dihapus.');
    }

    public function refresh()
    {
        $dataMonitorings = DataMonitoring::whereIn('kategori', $this->realtimeKategori)->get();
        foreach ($dataMonitorings as $dataMonitoring) {
            $dataRiset = DataRiset::where('judul', $dataMonitoring->kategori)->first();
            if ($dataRiset) {
                $dataMonitoring->update(['tanggal_update' => now()]);
            }
        }

        return redirect()->route('data_monitoring.index')->with('success', 'Data Realtime berhasil diperbarui.');
    }
}