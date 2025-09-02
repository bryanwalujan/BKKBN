<?php
namespace App\Http\Controllers;

use App\Models\DataRiset;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Stunting;
use App\Models\PendampingKeluarga;
use Illuminate\Http\Request;

class DataRisetController extends Controller
{
    protected $realtimeJudul = [
        'Data Balita Terpantau',
        'Ibu Hamil Mendapat Edukasi',
        'Penyuluhan Cegah Stunting',
        'Keluarga Dampingan Aktif',
    ];

    public function index()
    {
        $dataRisets = DataRiset::all();
        return view('master.data_riset.index', compact('dataRisets'));
    }

    public function create()
    {
        return view('master.data_riset.create', ['realtimeJudul' => $this->realtimeJudul]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'judul_kustom' => ['required_if:judul,Lainnya', 'string', 'max:255', 'unique:data_risets,judul'],
            'angka' => ['required', 'integer', 'min:0'],
        ]);

        $data = $this->prepareData($request);

        DataRiset::create($data);

        return redirect()->route('data_riset.index')->with('success', 'Data Riset berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dataRiset = DataRiset::findOrFail($id);
        return view('master.data_riset.edit', compact('dataRiset'), ['realtimeJudul' => $this->realtimeJudul]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'judul_kustom' => ['required_if:judul,Lainnya', 'string', 'max:255', 'unique:data_risets,judul,' . $id],
            'angka' => ['required', 'integer', 'min:0'],
        ]);

        $dataRiset = DataRiset::findOrFail($id);
        $data = $this->prepareData($request);

        $dataRiset->update($data);

        return redirect()->route('data_riset.index')->with('success', 'Data Riset berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dataRiset = DataRiset::findOrFail($id);
        $dataRiset->delete();

        return redirect()->route('data_riset.index')->with('success', 'Data Riset berhasil dihapus.');
    }

    public function refresh()
    {
        $existingData = DataRiset::whereIn('judul', $this->realtimeJudul)->get()->keyBy('judul');

        foreach ($this->realtimeJudul as $judul) {
            $angka = $this->getRealtimeAngka($judul);
            $data = [
                'judul' => $judul,
                'angka' => $angka,
                'is_realtime' => true,
                'tanggal_update' => now(),
            ];

            if (isset($existingData[$judul])) {
                $existingData[$judul]->update($data);
            } else {
                DataRiset::create($data);
            }
        }

        return redirect()->route('data_riset.index')->with('success', 'Data Realtime berhasil diperbarui.');
    }

    protected function prepareData(Request $request)
    {
        $judul = $request->judul === 'Lainnya' ? $request->judul_kustom : $request->judul;
        $isRealtime = in_array($request->judul, $this->realtimeJudul);
        $angka = $isRealtime ? $this->getRealtimeAngka($request->judul) : $request->angka;

        return [
            'judul' => $judul,
            'angka' => $angka,
            'is_realtime' => $isRealtime,
            'tanggal_update' => now(),
        ];
    }

    protected function getRealtimeAngka($judul)
    {
        return match ($judul) {
            'Data Balita Terpantau' => Balita::count(),
            'Ibu Hamil Mendapat Edukasi' => IbuHamil::count(),
            'Penyuluhan Cegah Stunting' => Stunting::count(),
            'Keluarga Dampingan Aktif' => PendampingKeluarga::where('status', 'Aktif')->count(),
            default => 0,
        };
    }
}