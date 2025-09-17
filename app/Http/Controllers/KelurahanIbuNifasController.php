<?php

namespace App\Http\Controllers;

use App\Models\PendingIbuNifas;
use App\Models\PendingIbu;
use App\Models\IbuNifas;
use App\Models\Ibu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KelurahanIbuNifasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('search');
        $category = $request->query('category');
        $tab = $request->query('tab', 'pending');

        if ($tab == 'verified') {
            $query = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
                ->whereHas('ibu', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                });
        } else {
            $query = PendingIbuNifas::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan', 'ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
                ->where('created_by', $user->id)
                ->where('status_verifikasi', 'pending');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('pendingIbu', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('nik', 'like', '%' . $search . '%');
                })->orWhereHas('ibu', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('nik', 'like', '%' . $search . '%');
                });
            });
        }

        if ($category) {
            $query->where('kondisi_kesehatan', $category);
        }

        $ibuNifas = $query->paginate(10)->appends(['search' => $search, 'category' => $category, 'tab' => $tab]);
        return view('kelurahan.ibu_nifas.index', compact('ibuNifas', 'search', 'category', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)->where('status', 'Nifas')->get();
        $pendingIbus = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->where('status', 'Nifas')->get();
        return view('kelurahan.ibu_nifas.create', compact('ibus', 'pendingIbus'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'ibu_id' => ['required'],
            'ibu_source' => ['required', 'in:verified,pending'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = $user->id;
            $data['status_verifikasi'] = 'pending';

            if ($request->ibu_source == 'verified') {
                $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
                $data['ibu_id'] = $ibu->id;
                $data['pending_ibu_id'] = null;
                $ibu->update(['status' => 'Nifas']);
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuMenyusui) {
                    $ibu->ibuMenyusui->delete();
                }
            } else {
                $pendingIbu = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
                $data['pending_ibu_id'] = $pendingIbu->id;
                $data['ibu_id'] = null;
                $pendingIbu->update(['status' => 'Nifas']);
                if ($pendingIbu->pendingIbuHamil) {
                    $pendingIbu->pendingIbuHamil->delete();
                }
            }

            PendingIbuNifas::create($data);
            return redirect()->route('kelurahan.ibu_nifas.index')->with('success', 'Data ibu nifas berhasil ditambahkan dan menunggu verifikasi.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data ibu nifas: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data ibu nifas: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if ($source == 'verified') {
            $ibuNifas = IbuNifas::with(['ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
                ->whereHas('ibu', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                })->findOrFail($id);
        } else {
            $ibuNifas = PendingIbuNifas::with(['pendingIbu.kartuKeluarga', 'pendingIbu.kecamatan', 'pendingIbu.kelurahan', 'ibu.kartuKeluarga', 'ibu.kecamatan', 'ibu.kelurahan'])
                ->where('created_by', $user->id)->findOrFail($id);
        }
        $ibus = Ibu::where('kelurahan_id', $user->kelurahan_id)->where('status', 'Nifas')->get();
        $pendingIbus = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->where('status', 'Nifas')->get();
        return view('kelurahan.ibu_nifas.edit', compact('ibuNifas', 'ibus', 'pendingIbus', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        $request->validate([
            'ibu_id' => ['required'],
            'ibu_source' => ['required', 'in:verified,pending'],
            'hari_nifas' => ['required', 'integer', 'min:0', 'max:42'],
            'kondisi_kesehatan' => ['required', 'in:Normal,Butuh Perhatian,Kritis'],
            'warna_kondisi' => ['required', 'in:Hijau (success),Kuning (warning),Merah (danger)'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            if ($source == 'verified') {
                $ibuNifas = IbuNifas::whereHas('ibu', function ($q) use ($user) {
                    $q->where('kelurahan_id', $user->kelurahan_id);
                })->findOrFail($id);
                $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
                $ibu->update(['status' => 'Nifas']);
                if ($ibu->ibuHamil) {
                    $ibu->ibuHamil->delete();
                }
                if ($ibu->ibuMenyusui) {
                    $ibu->ibuMenyusui->delete();
                }
                $ibuNifas->update($request->all());
            } else {
                $ibuNifas = PendingIbuNifas::where('created_by', $user->id)->findOrFail($id);
                $data = $request->all();
                $data['created_by'] = $user->id;
                $data['status_verifikasi'] = 'pending';
                if ($request->ibu_source == 'verified') {
                    $ibu = Ibu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
                    $data['ibu_id'] = $ibu->id;
                    $data['pending_ibu_id'] = null;
                    $ibu->update(['status' => 'Nifas']);
                    if ($ibu->ibuHamil) {
                        $ibu->ibuHamil->delete();
                    }
                    if ($ibu->ibuMenyusui) {
                        $ibu->ibuMenyusui->delete();
                    }
                } else {
                    $pendingIbu = PendingIbu::where('kelurahan_id', $user->kelurahan_id)->findOrFail($request->ibu_id);
                    $data['pending_ibu_id'] = $pendingIbu->id;
                    $data['ibu_id'] = null;
                    $pendingIbu->update(['status' => 'Nifas']);
                    if ($pendingIbu->pendingIbuHamil) {
                        $pendingIbu->pendingIbuHamil->delete();
                    }
                }
                $ibuNifas->update($data);
            }
            return redirect()->route('kelurahan.ibu_nifas.index')->with('success', 'Data ibu nifas berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data ibu nifas: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data ibu nifas: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        try {
            $ibuNifas = PendingIbuNifas::where('created_by', $user->id)->findOrFail($id);
            $pendingIbu = $ibuNifas->pendingIbu;
            $ibuNifas->delete();
            if ($pendingIbu) {
                $pendingIbu->update(['status' => 'Tidak Aktif']);
            }
            return redirect()->route('kelurahan.ibu_nifas.index')->with('success', 'Data ibu nifas berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data ibu nifas: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.ibu_nifas.index')->with('error', 'Gagal menghapus data ibu nifas: ' . $e->getMessage());
        }
    }
}