<?php
namespace App\Http\Controllers;

use App\Models\IbuMenyusui;
use App\Models\Ibu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IbuMenyusuiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = $request->query('category');
        $query = IbuMenyusui::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan']);
        
        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($category) {
            $query->where('status_menyusui', $category);
        }

        $ibuMenyusuis = $query->paginate(10)->appends(['search' => $search, 'category' => $category]);
        return view('master.ibu_menyusui.index', compact('ibuMenyusuis', 'search', 'category'));
    }

    public function create()
    {
        $ibus = Ibu::all();
        return view('master.ibu_menyusui.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'status_menyusui' => ['required', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibu = Ibu::findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Menyusui']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuNifas) {
                $ibu->ibuNifas->delete();
            }
            IbuMenyusui::create($request->all());
            return redirect()->route('ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu menyusui: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu menyusui: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ibuMenyusui = IbuMenyusui::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])->findOrFail($id);
        $ibus = Ibu::all();
        return view('master.ibu_menyusui.edit', compact('ibuMenyusui', 'ibus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'status_menyusui' => ['required', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $ibuMenyusui = IbuMenyusui::findOrFail($id);
            $ibu = Ibu::findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Menyusui']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuNifas) {
                $ibu->ibuNifas->delete();
            }
            $ibuMenyusui->update($request->all());
            return redirect()->route('ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu menyusui: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu menyusui: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $ibuMenyusui = IbuMenyusui::findOrFail($id);
            $ibu = $ibuMenyusui->ibu;
            $ibuMenyusui->delete();
            $ibu->update(['status' => 'Tidak Aktif']);
            return redirect()->route('ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu menyusui: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('ibu_menyusui.index')->with('error', 'Gagal menghapus data ibu menyusui: ' . $e->getMessage());
        }
    }
}