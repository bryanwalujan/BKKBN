<?php
namespace App\Http\Controllers;

use App\Models\RemajaPutri;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RemajaPutriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = RemajaPutri::with(['kartuKeluarga', 'kecamatan', 'kelurahan']);
        
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $remajaPutris = $query->paginate(10);
        return view('master.remaja_putri.index', compact('remajaPutris', 'search'));
    }

    public function create()
    {
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        return view('master.remaja_putri.create', compact('kartuKeluargas', 'kecamatans', 'kelurahans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $data = $request->all();
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('remaja_putri_fotos', 'public');
            }
            RemajaPutri::create($data);
            return redirect()->route('remaja_putri.index')->with('success', 'Data remaja putri berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data remaja putri: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data remaja putri: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $remajaPutri = RemajaPutri::findOrFail($id);
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        return view('master.remaja_putri.edit', compact('remajaPutri', 'kartuKeluargas', 'kecamatans', 'kelurahans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $remajaPutri = RemajaPutri::findOrFail($id);
            $data = $request->all();
            if ($request->hasFile('foto')) {
                if ($remajaPutri->foto) {
                    Storage::disk('public')->delete($remajaPutri->foto);
                }
                $data['foto'] = $request->file('foto')->store('remaja_putri_fotos', 'public');
            }
            $remajaPutri->update($data);
            return redirect()->route('remaja_putri.index')->with('success', 'Data remaja putri berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data remaja putri: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data remaja putri: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $remajaPutri = RemajaPutri::findOrFail($id);
            if ($remajaPutri->foto) {
                Storage::disk('public')->delete($remajaPutri->foto);
            }
            $remajaPutri->delete();
            return redirect()->route('remaja_putri.index')->with('success', 'Data remaja putri berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data remaja putri: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('remaja_putri.index')->with('error', 'Gagal menghapus data remaja putri: ' . $e->getMessage());
        }
    }
}