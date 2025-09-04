<?php
namespace App\Http\Controllers;

use App\Models\LayananKami;
use App\Models\DataRiset;
use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Stunting;
use App\Models\PendampingKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananKamiController extends Controller
{
    protected $realtimeJudul = [
        'Data Balita Terpantau',
        'Ibu Hamil Mendapat Edukasi',
        'Penyuluhan Cegah Stunting',
        'Keluarga Dampingan Aktif',
    ];

    public function index()
    {
        $layananKamis = LayananKami::orderBy('urutan')->get();
        $dataRiset = DataRiset::whereIn('judul', $this->realtimeJudul)->pluck('angka', 'judul');
        return view('master.layanan_kami.index', compact('layananKamis', 'dataRiset'));
    }

    public function create()
    {
        return view('master.layanan_kami.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_layanan' => ['required', 'string', 'max:255', 'unique:layanan_kamis'],
            'deskripsi_singkat' => ['required', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'ikon' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:1024'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['nullable', 'in:on'],
        ]);

        $data = $request->all();
        $data['ikon'] = $request->file('ikon')->store('layanan_kami', 'public');
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        LayananKami::create($data);

        return redirect()->route('layanan_kami.index')->with('success', 'Layanan Kami berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $layananKami = LayananKami::findOrFail($id);
        return view('master.layanan_kami.edit', compact('layananKami'));
    }

    public function update(Request $request, $id)
    {
        $layananKami = LayananKami::findOrFail($id);

        $request->validate([
            'judul_layanan' => ['required', 'string', 'max:255', 'unique:layanan_kamis,judul_layanan,' . $id],
            'deskripsi_singkat' => ['required', 'string', 'max:500'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'ikon' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:1024'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ]);

        $data = $request->all();
        if ($request->hasFile('ikon')) {
            Storage::disk('public')->delete($layananKami->ikon);
            $data['ikon'] = $request->file('ikon')->store('layanan_kami', 'public');
        } else {
            $data['ikon'] = $layananKami->ikon;
        }
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        $layananKami->update($data);

        return redirect()->route('layanan_kami.index')->with('success', 'Layanan Kami berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $layananKami = LayananKami::findOrFail($id);
        Storage::disk('public')->delete($layananKami->ikon);
        $layananKami->delete();

        return redirect()->route('layanan_kami.index')->with('success', 'Layanan Kami berhasil dihapus.');
    }

    public function refresh()
    {
        $layananKamis = LayananKami::whereIn('judul_layanan', $this->realtimeJudul)->get();
        foreach ($layananKamis as $layanan) {
            $dataRiset = DataRiset::where('judul', $layanan->judul_layanan)->first();
            if ($dataRiset) {
                $layanan->update(['tanggal_update' => now()]);
            }
        }

        return redirect()->route('layanan_kami.index')->with('success', 'Data Realtime berhasil diperbarui.');
    }
}