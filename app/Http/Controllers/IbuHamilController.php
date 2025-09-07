<?php
namespace App\Http\Controllers;

use App\Models\IbuHamil;
use App\Models\Ibu;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IbuHamilController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = IbuHamil::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan']);
        
        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $ibuHamils = $query->paginate(10);
        return view('master.ibu_hamil.index', compact('ibuHamils', 'search'));
    }

    public function create()
    {
        $ibus = Ibu::all(); // Ambil semua ibu, bukan hanya status 'Hamil'
        return view('master.ibu_hamil.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibu = Ibu::findOrFail($request->ibu_id);
            // Perbarui status ibu menjadi 'Hamil'
            $ibu->update(['status' => 'Hamil']);
            // Hapus data dari tabel lain jika ada
            if ($ibu->ibuNifas) {
                $ibu->ibuNifas->delete();
            }
            if ($ibu->ibuMenyusui) {
                $ibu->ibuMenyusui->delete();
            }
            IbuHamil::create($request->all());
            return redirect()->route('ibu_hamil.index')->with('success', 'Data ibu hamil berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu hamil: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu hamil: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ibuHamil = IbuHamil::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])->findOrFail($id);
        $ibus = Ibu::all(); // Ambil semua ibu
        return view('master.ibu_hamil.edit', compact('ibuHamil', 'ibus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibuHamil = IbuHamil::findOrFail($id);
            $ibu = Ibu::findOrFail($request->ibu_id);
            // Perbarui status ibu menjadi 'Hamil'
            $ibu->update(['status' => 'Hamil']);
            // Hapus data dari tabel lain jika ada
            if ($ibu->ibuNifas) {
                $ibu->ibuNifas->delete();
            }
            if ($ibu->ibuMenyusui) {
                $ibu->ibuMenyusui->delete();
            }
            $ibuHamil->update($request->all());
            return redirect()->route('ibu_hamil.index')->with('success', 'Data ibu hamil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu hamil: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu hamil: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ibuHamil = IbuHamil::findOrFail($id);
            $ibu = $ibuHamil->ibu;
            $ibuHamil->delete();
            // Ubah status ibu menjadi 'Tidak Aktif'
            $ibu->update(['status' => 'Tidak Aktif']);
            return redirect()->route('ibu_hamil.index')->with('success', 'Data ibu hamil berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu hamil: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('ibu_hamil.index')->with('error', 'Gagal menghapus data ibu hamil: ' . $e->getMessage());
        }
    }
}