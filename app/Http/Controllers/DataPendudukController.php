<?php
namespace App\Http\Controllers;

use App\Models\DataPenduduk;
use App\Models\DataRiset;
use Illuminate\Http\Request;

class DataPendudukController extends Controller
{
    protected $realtimeKategori = ['Jumlah Penduduk'];

    public function index(Request $request)
    {
        $tahun = $request->query('tahun');
        $query = DataPenduduk::orderBy('urutan');

        if ($tahun) {
            $query->where('tahun', 'like', '%' . $tahun . '%');
        }

        $dataPenduduks = $query->paginate(10);
        $dataRiset = DataRiset::whereIn('judul', $this->realtimeKategori)->pluck('angka', 'judul');
        $chartData = DataPenduduk::orderBy('tahun')->get(['tahun', 'jumlah_penduduk'])->toArray();

        return view('master.data_penduduk.index', compact('dataPenduduks', 'dataRiset', 'tahun', 'chartData'));
    }

    public function create()
    {
        return view('master.data_penduduk.create');
    }

    public function store(Request $request)
    {
        $currentYear = date('Y');
        $request->validate([
            'tahun' => ['required', 'integer', 'min:1900', 'max:' . $currentYear],
            'jumlah_penduduk' => ['required', 'integer', 'min:0'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ]);

        $data = $request->all();
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        DataPenduduk::create($data);

        return redirect()->route('data_penduduk.index')->with('success', 'Data Penduduk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dataPenduduk = DataPenduduk::findOrFail($id);
        return view('master.data_penduduk.edit', compact('dataPenduduk'));
    }

    public function update(Request $request, $id)
    {
        $dataPenduduk = DataPenduduk::findOrFail($id);
        $currentYear = date('Y');

        $request->validate([
            'tahun' => ['required', 'integer', 'min:1900', 'max:' . $currentYear],
            'jumlah_penduduk' => ['required', 'integer', 'min:0'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['nuallable', 'in:on'],
        ]);

        $data = $request->all();
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        $dataPenduduk->update($data);

        return redirect()->route('data_penduduk.index')->with('success', 'Data Penduduk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dataPenduduk = DataPenduduk::findOrFail($id);
        $dataPenduduk->delete();

        return redirect()->route('data_penduduk.index')->with('success', 'Data Penduduk berhasil dihapus.');
    }

    public function refresh()
    {
        $dataPenduduks = DataPenduduk::where('status_aktif', true)->get();
        foreach ($dataPenduduks as $dataPenduduk) {
            $dataRiset = DataRiset::where('judul', 'Jumlah Penduduk')->where('tahun', $dataPenduduk->tahun)->first();
            if ($dataRiset) {
                $dataPenduduk->update(['jumlah_penduduk' => $dataRiset->angka, 'tanggal_update' => now()]);
            }
        }

        return redirect()->route('data_penduduk.index')->with('success', 'Data Realtime berhasil diperbarui.');
    }
}