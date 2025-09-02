<?php
namespace App\Http\Controllers;

use App\Models\Publikasi;
use App\Models\DataRiset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    protected $realtimeJudul = [
        'Data Balita Terpantau',
        'Ibu Hamil Mendapat Edukasi',
        'Penyuluhan Cegah Stunting',
        'Keluarga Dampingan Aktif',
    ];

    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $query = Publikasi::orderBy('urutan');

        if ($kategori && in_array($kategori, ['Berita', 'Artikel', 'Pengumuman', 'Lainnya'])) {
            $query->where('kategori', $kategori);
        }

        $publikasis = $query->paginate(10);
        $dataRiset = DataRiset::whereIn('judul', $this->realtimeJudul)->pluck('angka', 'judul');
        $kategoriOptions = ['Berita', 'Artikel', 'Pengumuman', 'Lainnya'];

        return view('master.publikasi.index', compact('publikasis', 'dataRiset', 'kategori', 'kategoriOptions'));
    }

    public function create()
    {
        return view('master.publikasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Berita,Artikel,Pengumuman,Lainnya'],
            'deskripsi' => ['required', 'string'],
            'gambar' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
            'link_aksi' => ['nullable', 'string', 'max:255', 'url'],
            'teks_tombol' => ['required', 'string', 'max:50'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['nullable','in:on'],
        ]);

        $data = $request->all();
        $data['gambar'] = $request->file('gambar')->store('publikasi', 'public');
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        Publikasi::create($data);

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        return view('master.publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, $id)
    {
        $publikasi = Publikasi::findOrFail($id);

        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Berita,Artikel,Pengumuman,Lainnya'],
            'deskripsi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
            'link_aksi' => ['nullable', 'string', 'max:255', 'url'],
            'teks_tombol' => ['required', 'string', 'max:50'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            if ($publikasi->gambar) {
                Storage::disk('public')->delete($publikasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('publikasi', 'public');
        } else {
            $data['gambar'] = $publikasi->gambar;
        }
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        $publikasi->update($data);

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $publikasi = Publikasi::findOrFail($id);
        if ($publikasi->gambar) {
            Storage::disk('public')->delete($publikasi->gambar);
        }
        $publikasi->delete();

        return redirect()->route('publikasi.index')->with('success', 'Publikasi berhasil dihapus.');
    }

    public function refresh()
    {
        $publikasis = Publikasi::whereIn('judul', $this->realtimeJudul)->get();
        foreach ($publikasis as $publikasi) {
            $dataRiset = DataRiset::where('judul', $publikasi->judul)->first();
            if ($dataRiset) {
                $publikasi->update(['tanggal_update' => now()]);
            }
        }

        return redirect()->route('publikasi.index')->with('success', 'Data Realtime berhasil diperbarui.');
    }
}