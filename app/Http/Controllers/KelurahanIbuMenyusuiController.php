<?php

namespace App\Http\Controllers;

use App\Models\PendingIbu;
use App\Models\PendingIbuMenyusui;
use App\Models\Ibu;
use App\Models\IbuMenyusui;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelurahanIbuMenyusuiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('search');
        $category = $request->query('category');
        $tab = $request->query('tab', 'pending');

        if ($tab == 'verified') {
            $query = IbuMenyusui::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
                ->whereHas('ibu', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                });
        } else {
            $query = PendingIbuMenyusui::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan'])
                ->where('created_by', $user->id)
                ->where('status_verifikasi', 'pending');
        }

        if ($search) {
            $query->whereHas($tab == 'verified' ? 'ibu' : 'pendingIbu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        if ($category) {
            $query->where('status_menyusui', $category);
        }

        $ibuMenyusuis = $query->paginate(10)->appends(['search' => $search, 'category' => $category, 'tab' => $tab]);
        return view('kelurahan.ibu_menyusui.index', compact('ibuMenyusuis', 'search', 'category', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        $ibus = PendingIbu::where('created_by', $user->id)
            ->where('status_verifikasi', 'pending')
            ->get();
        $verifiedIbus = Ibu::where('kelurahan_id', $user->kelurahan_id)->get();
        $ibus = $ibus->merge($verifiedIbus);
        return view('kelurahan.ibu_menyusui.create', compact('ibus'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'ibu_id' => ['required'],
            'ibu_source' => ['required', 'in:pending,verified'],
            'status_menyusui' => ['required', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            if ($request->ibu_source == 'verified') {
                $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
                $ibu->update(['status' => 'Menyusui']);
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuNifas) {
                    $ibu->ibuNifas->delete();
                }
                IbuMenyusui::create([
                    'ibu_id' => $ibu->id,
                    'status_menyusui' => $request->status_menyusui,
                    'frekuensi_menyusui' => $request->frekuensi_menyusui,
                    'kondisi_ibu' => $request->kondisi_ibu,
                    'warna_kondisi' => $request->warna_kondisi,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                ]);
            } else {
                $pendingIbu = PendingIbu::where('created_by', $user->id)->findOrFail($request->ibu_id);
                $pendingIbu->update(['status' => 'Menyusui']);
                if ($pendingIbu->pendingIbuHamil) {
                    $pendingIbu->pendingIbuHamil->delete();
                }
                if ($pendingIbu->pendingIbuNifas) {
                    $pendingIbu->pendingIbuNifas->delete();
                }
                PendingIbuMenyusui::create([
                    'pending_ibu_id' => $pendingIbu->id,
                    'status_menyusui' => $request->status_menyusui,
                    'frekuensi_menyusui' => $request->frekuensi_menyusui,
                    'kondisi_ibu' => $request->kondisi_ibu,
                    'warna_kondisi' => $request->warna_kondisi,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                ]);
            }
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu menyusui: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu menyusui: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if ($source == 'verified') {
            $ibuMenyusui = IbuMenyusui::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
                ->whereHas('ibu', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                })
                ->findOrFail($id);
            $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)->get()->map(function ($ibu) {
                $ibu->source = 'verified';
                return $ibu;
            });
        } else {
            $ibuMenyusui = PendingIbuMenyusui::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan'])
                ->where('created_by', $user->id)
                ->findOrFail($id);
            $ibus = PendingIbu::where('created_by', $user->id)
                ->where('status_verifikasi', 'pending')
                ->get()
                ->map(function ($ibu) {
                    $ibu->source = 'pending';
                    return $ibu;
                });
            $verifiedIbus = Ibu::where('kelurahan_id', $user->kelurahan_id)->get()->map(function ($ibu) {
                $ibu->source = 'verified';
                return $ibu;
            });
            $ibus = $ibus->merge($verifiedIbus);
        }
        return view('kelurahan.ibu_menyusui.edit', compact('ibuMenyusui', 'ibus', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        $request->validate([
            'ibu_id' => ['required'],
            'ibu_source' => ['required', 'in:pending,verified'],
            'status_menyusui' => ['required', 'in:Eksklusif,Non-Eksklusif'],
            'frekuensi_menyusui' => ['required', 'integer', 'min:0', 'max:24'],
            'kondisi_ibu' => ['required', 'string', 'max:255'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            if ($source == 'verified') {
                $ibuMenyusui = IbuMenyusui::findOrFail($id);
                $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
                $ibu->update(['status' => 'Menyusui']);
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuNifas) {
                    $ibu->ibuNifas->delete();
                }
                $ibuMenyusui->update([
                    'ibu_id' => $ibu->id,
                    'status_menyusui' => $request->status_menyusui,
                    'frekuensi_menyusui' => $request->frekuensi_menyusui,
                    'kondisi_ibu' => $request->kondisi_ibu,
                    'warna_kondisi' => $request->warna_kondisi,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                ]);
            } else {
                $ibuMenyusui = PendingIbuMenyusui::where('created_by', $user->id)->findOrFail($id);
                $pendingIbu = PendingIbu::where('created_by', $user->id)->findOrFail($request->ibu_id);
                $pendingIbu->update(['status' => 'Menyusui']);
                if ($pendingIbu->pendingIbuHamil) {
                    $pendingIbu->pendingIbuHamil->delete();
                }
                if ($pendingIbu->pendingIbuNifas) {
                    $pendingIbu->pendingIbuNifas->delete();
                }
                $ibuMenyusui->update([
                    'pending_ibu_id' => $pendingIbu->id,
                    'status_menyusui' => $request->status_menyusui,
                    'frekuensi_menyusui' => $request->frekuensi_menyusui,
                    'kondisi_ibu' => $request->kondisi_ibu,
                    'warna_kondisi' => $request->warna_kondisi,
                    'berat' => $request->berat,
                    'tinggi' => $request->tinggi,
                    'created_by' => $user->id,
                    'status_verifikasi' => 'pending',
                ]);
            }
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu menyusui: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu menyusui: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        try {
            $ibuMenyusui = PendingIbuMenyusui::where('created_by', $user->id)->findOrFail($id);
            $pendingIbu = $ibuMenyusui->pendingIbu;
            $ibuMenyusui->delete();
            $pendingIbu->update(['status' => 'Tidak Aktif']);
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('success', 'Data ibu menyusui berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu menyusui: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu_menyusui.index')->with('error', 'Gagal menghapus data ibu menyusui: ' . $e->getMessage());
        }
    }
}