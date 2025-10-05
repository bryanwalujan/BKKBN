<?php

namespace App\Http\Controllers;

use App\Models\Ibu;
use App\Models\IbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelurahanIbuHamilController extends Controller
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

        $query = IbuHamil::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
            ->whereHas('ibu', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
            });

        if ($search) {
            $query->whereHas('ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            })->orWhere('riwayat_penyakit', 'like', '%' . $search . '%');
        }

        $ibuHamils = $query->paginate(10)->appends(['search' => $search]);
        $totalData = $ibuHamils->total();

        return view('kelurahan.ibu_hamil.index', compact('ibuHamils', 'search', 'totalData'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Hamil')
            ->get(['id', 'nama', 'nik']);

        if ($ibus->isEmpty()) {
            return view('kelurahan.ibu_hamil.create', compact('ibus'))
                ->with('warning', 'Tidak ada data ibu dengan status Hamil. Silakan tambahkan data ibu terlebih dahulu.');
        }

        return view('kelurahan.ibu_hamil.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'tinggi_fundus_uteri' => ['nullable', 'numeric', 'min:0'],
            'imt' => ['nullable', 'numeric', 'min:0'],
            'riwayat_penyakit' => ['nullable', 'string', 'max:255'],
            'kadar_hb' => ['nullable', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'taksiran_berat_janin' => ['nullable', 'numeric', 'min:0'],
        ]);

        try {
            $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);

            $existingIbuHamil = IbuHamil::where('ibu_id', $ibu->id)->first();
            if ($existingIbuHamil) {
                $existingIbuHamil->delete();
            }

            IbuHamil::create([
                'ibu_id' => $ibu->id,
                'trimester' => $request->trimester,
                'intervensi' => $request->intervensi,
                'status_gizi' => $request->status_gizi,
                'warna_status_gizi' => $request->warna_status_gizi,
                'usia_kehamilan' => $request->usia_kehamilan,
                'berat' => $request->berat,
                'tinggi' => $request->tinggi,
                'tinggi_fundus_uteri' => $request->tinggi_fundus_uteri,
                'imt' => $request->imt,
                'riwayat_penyakit' => $request->riwayat_penyakit,
                'kadar_hb' => $request->kadar_hb,
                'lingkar_kepala' => $request->lingkar_kepala,
                'taksiran_berat_janin' => $request->taksiran_berat_janin,
                'created_by' => $user->id,
            ]);

            return redirect()->route('kelurahan.ibu_hamil.index')->with('success', 'Data ibu hamil berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu hamil: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu hamil: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $ibuHamil = IbuHamil::whereHas('ibu', function ($q) use ($user) {
            $q->where('kelurahan_id', $user->kelurahan_id);
        })->findOrFail($id);

        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Hamil')
            ->get(['id', 'nama', 'nik']);

        return view('kelurahan.ibu_hamil.edit', compact('ibuHamil', 'ibus'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'ibu_id' => ['required', 'exists:ibus,id'],
            'trimester' => ['required', 'in:Trimester 1,Trimester 2,Trimester 3'],
            'intervensi' => ['required', 'in:Tidak Ada,Gizi,Konsultasi Medis,Lainnya'],
            'status_gizi' => ['required', 'in:Normal,Kurang Gizi,Berisiko'],
            'warna_status_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'usia_kehamilan' => ['required', 'integer', 'min:0', 'max:40'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'tinggi_fundus_uteri' => ['nullable', 'numeric', 'min:0'],
            'imt' => ['nullable', 'numeric', 'min:0'],
            'riwayat_penyakit' => ['nullable', 'string', 'max:255'],
            'kadar_hb' => ['nullable', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'taksiran_berat_janin' => ['nullable', 'numeric', 'min:0'],
        ]);

        try {
            $ibuHamil = IbuHamil::whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);

            $ibuHamil->update([
                'ibu_id' => $request->ibu_id,
                'trimester' => $request->trimester,
                'intervensi' => $request->intervensi,
                'status_gizi' => $request->status_gizi,
                'warna_status_gizi' => $request->warna_status_gizi,
                'usia_kehamilan' => $request->usia_kehamilan,
                'berat' => $request->berat,
                'tinggi' => $request->tinggi,
                'tinggi_fundus_uteri' => $request->tinggi_fundus_uteri,
                'imt' => $request->imt,
                'riwayat_penyakit' => $request->riwayat_penyakit,
                'kadar_hb' => $request->kadar_hb,
                'lingkar_kepala' => $request->lingkar_kepala,
                'taksiran_berat_janin' => $request->taksiran_berat_janin,
                'created_by' => $user->id,
            ]);

            return redirect()->route('kelurahan.ibu_hamil.index')->with('success', 'Data ibu hamil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu hamil: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu hamil: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $ibuHamil = IbuHamil::whereHas('ibu', function ($q) use ($user) {
                $q->where('kelurahan_id', $user->kelurahan_id);
            })->findOrFail($id);
            $ibuHamil->delete();

            return redirect()->route('kelurahan.ibu_hamil.index')->with('success', 'Data ibu hamil berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu hamil: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu_hamil.index')->with('error', 'Gagal menghapus data ibu hamil: ' . $e->getMessage());
        }
    }
}