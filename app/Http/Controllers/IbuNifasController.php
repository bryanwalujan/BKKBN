<?php
namespace App\Http\Controllers;

use App\Models\IbuNifas;
use App\Models\Ibu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IbuNifasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan']);
        
        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $ibuNifas = $query->paginate(10);
        return view('master.ibu_nifas.index', compact('ibuNifas', 'search'));
    }

    public function create()
    {
        $ibus = Ibu::where('status', 'Nifas')->get();
        return view('master.ibu_nifas.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            IbuNifas::create($request->all());
            return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu nifas: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu nifas: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ibuNifas = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])->findOrFail($id);
        $ibus = Ibu::where('status', 'Nifas')->get();
        return view('master.ibu_nifas.edit', compact('ibuNifas', 'ibus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibuNifas = IbuNifas::findOrFail($id);
            $ibuNifas->update($request->all());
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
            $ibuNifas->delete();
            return redirect()->route('ibu_nifas.index')->with('success', 'Data ibu nifas berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu nifas: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('ibu_nifas.index')->with('error', 'Gagal menghapus data ibu nifas: ' . $e->getMessage());
        }
    }
}