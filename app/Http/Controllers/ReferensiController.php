<?php
namespace App\Http\Controllers;

use App\Models\Referensi;
use App\Models\DataRiset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReferensiController extends Controller
{
    protected $realtimeJudul = [
        'Panduan Gizi Balita',
        'Edukasi Kesehatan Ibu Hamil',
        'Pencegahan Stunting',
        'Panduan Posyandu',
    ];

    public function index(Request $request)
    {
        $warna_icon = $request->query('warna_icon');
        $query = Referensi::orderBy('urutan');

        if ($warna_icon && in_array($warna_icon, ['Biru', 'Merah', 'Hijau', 'Kuning'])) {
            $query->where('warna_icon', $warna_icon);
        }

        $referensis = $query->paginate(10);
        $dataRiset = DataRiset::whereIn('judul', $this->realtimeJudul)->pluck('angka', 'judul');
        $warnaIconOptions = ['Biru', 'Merah', 'Hijau', 'Kuning'];

        return view('master.referensi.index', compact('referensis', 'dataRiset', 'warna_icon', 'warnaIconOptions'));
    }

    public function create()
    {
        return view('master.referensi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255', 'unique:referensis,judul'],
            'deskripsi' => ['required', 'string'],
            'icon' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'warna_icon' => ['required', 'in:Biru,Merah,Hijau,Kuning'],
            'link_file' => ['nullable', 'string', 'max:255', 'url'],
            'teks_tombol' => ['required', 'string', 'max:50'],
            'urutan' => ['required', 'integer', 'min:1'],
           'status_aktif' => ['nullable', 'in:on'],
        ]);

        $data = $request->all();
        $data['icon'] = $request->file('icon')->store('referensi/icons', 'public');
        $data['pdf'] = $request->file('pdf')->store('referensi/pdfs', 'public');
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        Referensi::create($data);

        return redirect()->route('referensi.index')->with('success', 'Referensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $referensi = Referensi::findOrFail($id);
        return view('master.referensi.edit', compact('referensi'));
    }

    public function update(Request $request, $id)
    {
        $referensi = Referensi::findOrFail($id);

        $request->validate([
            'judul' => ['required', 'string', 'max:255', 'unique:referensis,judul,' . $id],
            'deskripsi' => ['required', 'string'],
            'icon' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'warna_icon' => ['required', 'in:Biru,Merah,Hijau,Kuning'],
            'link_file' => ['nullable', 'string', 'max:255', 'url'],
            'teks_tombol' => ['required', 'string', 'max:50'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ]);

        $data = $request->all();
        if ($request->hasFile('icon')) {
            if ($referensi->icon) {
                Storage::disk('public')->delete($referensi->icon);
            }
            $data['icon'] = $request->file('icon')->store('referensi/icons', 'public');
        } else {
            $data['icon'] = $referensi->icon;
        }
        if ($request->hasFile('pdf')) {
            if ($referensi->pdf) {
                Storage::disk('public')->delete($referensi->pdf);
            }
            $data['pdf'] = $request->file('pdf')->store('referensi/pdfs', 'public');
        } else {
            $data['pdf'] = $referensi->pdf;
        }
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        $referensi->update($data);

        return redirect()->route('referensi.index')->with('success', 'Referensi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $referensi = Referensi::findOrFail($id);
        if ($referensi->icon) {
            Storage::disk('public')->delete($referensi->icon);
        }
        if ($referensi->pdf) {
            Storage::disk('public')->delete($referensi->pdf);
        }
        $referensi->delete();

        return redirect()->route('referensi.index')->with('success', 'Referensi berhasil dihapus.');
    }

    public function refresh()
    {
        $referensis = Referensi::whereIn('judul', $this->realtimeJudul)->get();
        foreach ($referensis as $referensi) {
            $dataRiset = DataRiset::where('judul', $referensi->judul)->first();
            if ($dataRiset) {
                $referensi->update(['tanggal_update' => now()]);
            }
        }

        return redirect()->route('referensi.index')->with('success', 'Data Realtime berhasil diperbarui.');
    }
}