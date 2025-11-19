<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\IbuMenyusui;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelurahanIbuMenyusuiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kelurahan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $kelurahan_id = $user->kelurahan_id;

        if (!$kelurahan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $search = $request->query('search');

        $query = IbuMenyusui::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
            ->whereHas('ibu', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
            });

        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $ibuMenyusuis = $query->paginate(10)->appends(['search' => $search]);
        $totalData = $ibuMenyusuis->total();

        return view('kelurahan.ibu_menyusui.index', compact('ibuMenyusuis', 'search', 'totalData'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Menyusui')
            ->get(['id', 'nama', 'nik']);

        if ($ibus->isEmpty()) {
            return view('kelurahan.ibu_menyusui.create', compact('ibus'))
                ->with('warning', 'Tidak ada data ibu dengan status Menyusui. Silakan tambahkan data ibu terlebih dahulu.');
        }

        return view('kelurahan.ibu_menyusui.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

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
            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);

            // Update status ibu ke Menyusui dan hapus data terkait lainnya
            $ibu->update(['status' => 'Menyusui']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuNifas) {
                $ibu->ibuNifas->delete();
            }

            // Cek apakah ibu sudah memiliki entri IbuMenyusui, hapus jika ada
            $existingIbuMenyusui = IbuMenyusui::where('ibu_id', $ibu->id)->first();
            if ($existingIbuMenyusui) {
                $existingIbuMenyusui->delete();
            }

            // Simpan data ibu menyusui
            IbuMenyusui::create([
                'ibu_id' => $ibu->id,
                'status_menyusui' => $request->status_menyusui,
                'frekuensi_menyusui' => $request->frekuensi_menyusui,
                'kondisi_ibu' => $request->kondisi_ibu,
                'warna_kondisi' => $request->warna_kondisi,
                'berat' => $request->berat,
                'tinggi' => $request->tinggi,
                'created_by' => $user->id,
            ]);

            return redirect()->route('kelurahan.ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu menyusui: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu menyusui: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $ibuMenyusui = IbuMenyusui::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
            ->whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);

        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Menyusui')
            ->get(['id', 'nama', 'nik']);

        return view('kelurahan.ibu_menyusui.edit', compact('ibuMenyusui', 'ibus'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

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
            $ibuMenyusui = IbuMenyusui::whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);

            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
            $ibu->update(['status' => 'Menyusui']);
            if ($ibu->ibuHamil) {
                $ibu->ibuHamil->delete();
            }
            if ($ibu->ibuNifas) {
                $ibu->ibuNifas->delete();
            }

            $ibuMenyusui->update([
                'ibu_id' => $request->ibu_id,
                'status_menyusui' => $request->status_menyusui,
                'frekuensi_menyusui' => $request->frekuensi_menyusui,
                'kondisi_ibu' => $request->kondisi_ibu,
                'warna_kondisi' => $request->warna_kondisi,
                'berat' => $request->berat,
                'tinggi' => $request->tinggi,
                'created_by' => $user->id,
            ]);

            return redirect()->route('kelurahan.ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu menyusui: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu menyusui: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $ibuMenyusui = IbuMenyusui::whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);

            $ibu = $ibuMenyusui->ibu;
            $ibuMenyusui->delete();
            $ibu->update(['status' => 'Tidak Aktif']);

            return redirect()->route('kelurahan.ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu menyusui: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('error', 'Gagal menghapus data ibu menyusui: ' . $e->getMessage());
        }
    }
}