<?php

namespace App\Http\Controllers;

use App\Models\PendingKartuKeluarga;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanKartuKeluargaController extends Controller
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
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingKartuKeluarga
        $pendingQuery = PendingKartuKeluarga::with(['kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $pendingKartuKeluargas = $pendingQuery->get()->map(function ($kk) {
            $kk->source = 'pending';
            return $kk;
        });

        // Query untuk KartuKeluarga (terverifikasi)
        $verifiedQuery = KartuKeluarga::with(['kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $verifiedQuery->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%');
            });
        }

        $verifiedKartuKeluargas = $verifiedQuery->get()->map(function ($kk) {
            $kk->source = 'verified';
            $kk->createdBy = $kk->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $kk;
        });

        // Gabungkan data untuk tab yang dipilih
        $kartuKeluargas = $tab === 'verified' ? $verifiedKartuKeluargas : $pendingKartuKeluargas;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $kartuKeluargas->count();
        $paginatedKartuKeluargas = $kartuKeluargas->slice($offset, $perPage);
        $kartuKeluargas = new LengthAwarePaginator($paginatedKartuKeluargas, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kelurahan.kartu_keluarga.index', compact('kartuKeluargas', 'search', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kecamatans = Kecamatan::where('id', $user->kecamatan_id)->get();
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        return view('kelurahan.kartu_keluarga.create', compact('kecamatans', 'kelurahans'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'no_kk' => ['required', 'string', 'max:16', 'unique:pending_kartu_keluargas,no_kk', 'unique:kartu_keluargas,no_kk'],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        try {
            $data = $request->all();
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;
            $data['status_verifikasi'] = 'pending';

            Log::info('Menyimpan data kartu keluarga ke pending_kartu_keluargas', ['data' => $data]);
            PendingKartuKeluarga::create($data);

            return redirect()->route('kelurahan.kartu_keluarga.index')->with('success', 'Data kartu keluarga berhasil ditambahkan, menunggu verifikasi admin kecamatan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data kartu keluarga: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data kartu keluarga: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        if ($source === 'verified') {
            $kartuKeluarga = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        } else {
            $kartuKeluarga = PendingKartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        }

        $kecamatans = Kecamatan::where('id', $user->kecamatan_id)->get();
        $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
        return view('kelurahan.kartu_keluarga.edit', compact('kartuKeluarga', 'kecamatans', 'kelurahans', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'no_kk' => ['required', 'string', 'max:16', 'unique:pending_kartu_keluargas,no_kk,' . ($source === 'pending' ? $id : null), 'unique:kartu_keluargas,no_kk,' . ($source === 'verified' ? $id : null)],
            'kepala_keluarga' => ['required', 'string', 'max:255'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
        ]);

        try {
            if ($source === 'verified') {
                $verifiedKartuKeluarga = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = $request->all();
                $data['kecamatan_id'] = $user->kecamatan_id;
                $data['kelurahan_id'] = $user->kelurahan_id;
                $data['created_by'] = $user->id;
                $data['status_verifikasi'] = 'pending';
                $data['original_kartu_keluarga_id'] = $verifiedKartuKeluarga->id;

                Log::info('Menyimpan data kartu keluarga terverifikasi ke pending_kartu_keluargas untuk edit', ['data' => $data]);
                PendingKartuKeluarga::create($data);

                return redirect()->route('kelurahan.kartu_keluarga.index')->with('success', 'Data kartu keluarga terverifikasi berhasil diedit, menunggu verifikasi admin kecamatan.');
            } else {
                $kartuKeluarga = PendingKartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = $request->all();
                $data['kecamatan_id'] = $user->kecamatan_id;
                $data['kelurahan_id'] = $user->kelurahan_id;
                $data['created_by'] = $user->id;
                $data['status_verifikasi'] = 'pending';

                Log::info('Memperbarui data kartu keluarga di pending_kartu_keluargas', ['id' => $id, 'data' => $data]);
                $kartuKeluarga->update($data);

                return redirect()->route('kelurahan.kartu_keluarga.index')->with('success', 'Data kartu keluarga berhasil diperbarui, menunggu verifikasi admin kecamatan.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data kartu keluarga: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data kartu keluarga: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $kartuKeluarga = PendingKartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            $kartuKeluarga->delete();

            return redirect()->route('kelurahan.kartu_keluarga.index')->with('success', 'Data kartu keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data kartu keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.kartu_keluarga.index')->with('error', 'Gagal menghapus data kartu keluarga: ' . $e->getMessage());
        }
    }
}