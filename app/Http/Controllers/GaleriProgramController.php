<?php
namespace App\Http\Controllers;

use App\Models\GaleriProgram;
use App\Models\DataRiset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriProgramController extends Controller
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
        $query = GaleriProgram::orderBy('urutan');

        if ($kategori && in_array($kategori, ['Penyuluhan', 'Posyandu', 'Pendampingan', 'Lainnya'])) {
            $query->where('kategori', $kategori);
        }

        $galeriPrograms = $query->paginate(10);
        $dataRiset = DataRiset::whereIn('judul', $this->realtimeJudul)->pluck('angka', 'judul');
        $kategoriOptions = ['Penyuluhan', 'Posyandu', 'Pendampingan', 'Lainnya'];

        return view('master.galeri_program.index', compact('galeriPrograms', 'dataRiset', 'kategori', 'kategoriOptions'));
    }

    public function create()
    {
        return view('master.galeri_program.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kategori' => ['required', 'in:Penyuluhan,Posyandu,Pendampingan,Lainnya'],
            'link' => ['nullable', 'string', 'max:255', 'url'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ]);

        $data = $request->all();
        $data['gambar'] = $request->file('gambar')->store('galeri_program', 'public');
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        GaleriProgram::create($data);

        return redirect()->route('galeri_program.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeriProgram = GaleriProgram::findOrFail($id);
        return view('master.galeri_program.edit', compact('galeriProgram'));
    }

    public function update(Request $request, $id)
    {
        $galeriProgram = GaleriProgram::findOrFail($id);

        $request->validate([
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kategori' => ['required', 'in:Penyuluhan,Posyandu,Pendampingan,Lainnya'],
            'link' => ['nullable', 'string', 'max:255', 'url'],
            'urutan' => ['required', 'integer', 'min:1'],
            'status_aktif' => ['boolean'],
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($galeriProgram->gambar);
            $data['gambar'] = $request->file('gambar')->store('galeri_program', 'public');
        } else {
            $data['gambar'] = $galeriProgram->gambar;
        }
        $data['status_aktif'] = $request->has('status_aktif');
        $data['tanggal_update'] = now();

        $galeriProgram->update($data);

        return redirect()->route('galeri_program.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $galeriProgram = GaleriProgram::findOrFail($id);
        Storage::disk('public')->delete($galeriProgram->gambar);
        $galeriProgram->delete();

        return redirect()->route('galeri_program.index')->with('success', 'Program berhasil dihapus.');
    }

    public function refresh()
    {
        $galeriPrograms = GaleriProgram::whereIn('judul', $this->realtimeJudul)->get();
        foreach ($galeriPrograms as $program) {
            $dataRiset = DataRiset::where('judul', $program->judul)->first();
            if ($dataRiset) {
                $program->update(['tanggal_update' => now()]);
            }
        }

        return redirect()->route('galeri_program.index')->with('success', 'Data Realtime berhasil diperbarui.');
    }
}