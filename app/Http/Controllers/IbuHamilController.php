<?php
namespace App\Http\Controllers;

use App\Models\IbuHamil;
use App\Models\Ibu;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class IbuHamilController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $query = IbuHamil::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan']);
        
        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhereRaw('nik = ?', [Crypt::encryptString($search)]);
            })->orWhere('riwayat_penyakit', 'like', '%' . $search . '%');
        }

        if ($category) {
            $query->where('trimester', $category);
        }

        $ibuHamils = $query->get(); // Mengambil semua data tanpa pagination
        $totalData = $ibuHamils->count(); // Hitung total data untuk ditampilkan
        return view('master.ibu_hamil.index', compact('ibuHamils', 'search', 'category', 'totalData'));
    }

    public function create()
    {
        $ibus = Ibu::all();
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
            'tinggi_fundus_uteri' => ['nullable', 'string', 'max:255'],
            'imt' => ['nullable', 'string', 'max:255'],
            'riwayat_penyakit' => ['nullable', 'string', 'max:255'],
            'kadar_hb' => ['nullable', 'string', 'max:255'],
            'lingkar_kepala' => ['nullable', 'string', 'max:255'],
            'taksiran_berat_janin' => ['nullable', 'string', 'max:255'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibu = Ibu::findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Hamil']);
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
        $ibus = Ibu::all();
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
            'tinggi_fundus_uteri' => ['nullable', 'string', 'max:255'],
            'imt' => ['nullable', 'string', 'max:255'],
            'riwayat_penyakit' => ['nullable', 'string', 'max:255'],
            'kadar_hb' => ['nullable', 'string', 'max:255'],
            'lingkar_kepala' => ['nullable', 'string', 'max:255'],
            'taksiran_berat_janin' => ['nullable', 'string', 'max:255'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibuHamil = IbuHamil::findOrFail($id);
            $ibu = Ibu::findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Hamil']);
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
            $ibu->update(['status' => 'Tidak Aktif']);
            return redirect()->route('ibu_hamil.index')->with('success', 'Data ibu hamil berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu hamil: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('ibu_hamil.index')->with('error', 'Gagal menghapus data ibu hamil: ' . $e->getMessage());
        }
    }
}