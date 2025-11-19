<?php
namespace App\Http\Controllers;

use App\Models\IbuNifas;
use App\Models\Ibu;
use App\Models\BayiBaruLahir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IbuNifasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $query = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan', 'bayiBaruLahir']);
        
        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            })->orWhere('tempat_persalinan', 'like', '%' . $search . '%');
        }

        if ($category) {
            $query->where('kondisi_kesehatan', $category);
        }

        $ibuNifas = $query->paginate(10)->appends(['search' => $search, 'category' => $category]);
        return view('master.ibu_nifas.index', compact('ibuNifas', 'search', 'category'));
    }

    public function create()
    {
        $ibus = Ibu::all();
        return view('master.ibu_nifas.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'tanggal_melahirkan' => ['nullable', 'date'],
            'tempat_persalinan' => ['nullable', 'string', 'max:255'],
            'penolong_persalinan' => ['nullable', 'string', 'max:255'],
            'cara_persalinan' => ['nullable', 'string', 'max:255'],
            'komplikasi' => ['nullable', 'string', 'max:255'],
            'keadaan_bayi' => ['nullable', 'string', 'max:255'],
            'kb_pasca_salin' => ['nullable', 'string', 'max:255'],
            'kondisi_kesehatan' => ['required', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'bayi.umur_dalam_kandungan' => ['nullable', 'string', 'max:255'],
            'bayi.berat_badan_lahir' => ['nullable', 'string', 'max:255'],
            'bayi.panjang_badan_lahir' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $ibu = Ibu::findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Nifas']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuMenyusui) {
                $ibu->ibuMenyusui->delete();
            }
            $ibuNifas = IbuNifas::create($request->only([
                'ibu_id',
                'hari_nifas',
                'tanggal_melahirkan',
                'tempat_persalinan',
                'penolong_persalinan',
                'cara_persalinan',
                'komplikasi',
                'keadaan_bayi',
                'kb_pasca_salin',
                'kondisi_kesehatan',
                'warna_kondisi',
                'berat',
                'tinggi',
            ]));

            if ($request->has('bayi')) {
                $ibuNifas->bayiBaruLahir()->create($request->input('bayi'));
            }

            return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu nifas: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu nifas: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ibuNifas = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan', 'bayiBaruLahir'])->findOrFail($id);
        $ibus = Ibu::all();
        return view('master.ibu_nifas.edit', compact('ibuNifas', 'ibus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'tanggal_melahirkan' => ['nullable', 'date'],
            'tempat_persalinan' => ['nullable', 'string', 'max:255'],
            'penolong_persalinan' => ['nullable', 'string', 'max:255'],
            'cara_persalinan' => ['nullable', 'string', 'max:255'],
            'komplikasi' => ['nullable', 'string', 'max:255'],
            'keadaan_bayi' => ['nullable', 'string', 'max:255'],
            'kb_pasca_salin' => ['nullable', 'string', 'max:255'],
            'kondisi_kesehatan' => ['required', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'bayi.umur_dalam_kandungan' => ['nullable', 'string', 'max:255'],
            'bayi.berat_badan_lahir' => ['nullable', 'string', 'max:255'],
            'bayi.panjang_badan_lahir' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $ibuNifas = IbuNifas::findOrFail($id);
            $ibu = Ibu::findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Nifas']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuMenyusui) {
                $ibu->ibuMenyusui->delete();
            }
            $ibuNifas->update($request->only([
                'ibu_id',
                'hari_nifas',
                'tanggal_melahirkan',
                'tempat_persalinan',
                'penolong_persalinan',
                'cara_persalinan',
                'komplikasi',
                'keadaan_bayi',
                'kb_pasca_salin',
                'kondisi_kesehatan',
                'warna_kondisi',
                'berat',
                'tinggi',
            ]));

            if ($request->has('bayi')) {
                if ($ibuNifas->bayiBaruLahir) {
                    $ibuNifas->bayiBaruLahir->update($request->input('bayi'));
                } else {
                    $ibuNifas->bayiBaruLahir()->create($request->input('bayi'));
                }
            }

            return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu nifas: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu nifas: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ibuNifas = IbuNifas::findOrFail($id);
            $ibu = $ibuNifas->ibu;
            $ibuNifas->delete();
            $ibu->update(['status' => 'Tidak Aktif']);
            return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu nifas: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('ibu_nifas.index')->with('error', 'Gagal menghapus data ibu nifas: ' . $e->getMessage());
        }
    }
}