<?php

namespace App\Http\Controllers;

use App\Models\PendingGenting;
use App\Models\Genting;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class PerangkatDaerahGentingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:perangkat_daerah');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $search = $request->query('search');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingGenting
        $pendingQuery = PendingGenting::with(['kartuKeluarga', 'createdBy'])
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })
            ->where('status', 'pending')
            ->where('created_by', $user->id);

        if ($search) {
            $pendingQuery->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $pendingGentings = $pendingQuery->get()->map(function ($genting) {
            $genting->source = 'pending';
            return $genting;
        });

        // Query untuk Genting (terverifikasi)
        $verifiedQuery = Genting::with('kartuKeluarga')
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            });

        if ($search) {
            $verifiedQuery->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $verifiedGentings = $verifiedQuery->get()->map(function ($genting) {
            $genting->source = 'verified';
            return $genting;
        });

        // Gabungkan data untuk tab yang dipilih
        $gentings = $tab === 'verified' ? $verifiedGentings : $pendingGentings;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $gentings->count();
        $paginatedGentings = $gentings->slice($offset, $perPage);
        $gentings = new LengthAwarePaginator($paginatedGentings, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('perangkat_daerah.genting.index', compact('gentings', 'search', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.genting.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kecamatan = $user->kecamatan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan) {
            Log::warning('Tidak ada data Kartu Keluarga atau kecamatan tidak ditemukan untuk kecamatan_id: ' . $user->kecamatan_id);
            return view('perangkat_daerah.genting.create', compact('kartuKeluargas', 'kecamatan'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau kecamatan tidak ditemukan.');
        }

        return view('perangkat_daerah.genting.create', compact('kartuKeluargas', 'kecamatan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.genting.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'sasaran' => ['required', 'string', 'max:255'],
            'jenis_intervensi' => ['required', 'string', 'max:255'],
            'narasi' => ['nullable', 'string'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
            'dunia_usaha' => ['nullable', 'in:ada,tidak'],
            'dunia_usaha_frekuensi' => ['nullable', 'string', 'max:255'],
            'pemerintah' => ['nullable', 'in:ada,tidak'],
            'pemerintah_frekuensi' => ['nullable', 'string', 'max:255'],
            'bumn_bumd' => ['nullable', 'in:ada,tidak'],
            'bumn_bumd_frekuensi' => ['nullable', 'string', 'max:255'],
            'individu_perseorangan' => ['nullable', 'in:ada,tidak'],
            'individu_perseorangan_frekuensi' => ['nullable', 'string', 'max:255'],
            'lsm_komunitas' => ['nullable', 'in:ada,tidak'],
            'lsm_komunitas_frekuensi' => ['nullable', 'string', 'max:255'],
            'swasta' => ['nullable', 'in:ada,tidak'],
            'swasta_frekuensi' => ['nullable', 'string', 'max:255'],
            'perguruan_tinggi_akademisi' => ['nullable', 'in:ada,tidak'],
            'perguruan_tinggi_akademisi_frekuensi' => ['nullable', 'string', 'max:255'],
            'media' => ['nullable', 'in:ada,tidak'],
            'media_frekuensi' => ['nullable', 'string', 'max:255'],
            'tim_pendamping_keluarga' => ['nullable', 'in:ada,tidak'],
            'tim_pendamping_keluarga_frekuensi' => ['nullable', 'string', 'max:255'],
            'tokoh_masyarakat' => ['nullable', 'in:ada,tidak'],
            'tokoh_masyarakat_frekuensi' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = $user->id;
            $data['status'] = 'pending';

            if ($request->hasFile('dokumentasi')) {
                $data['dokumentasi'] = $request->file('dokumentasi')->store('pending_genting_dokumentasi', 'public');
            }

            PendingGenting::create($data);
            Log::info('Menyimpan data genting ke pending_gentings', ['data' => $data]);
            return redirect()->route('perangkat_daerah.genting.index', ['tab' => 'pending'])->with('success', 'Data kegiatan genting berhasil diajukan untuk verifikasi.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data genting: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan data genting: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.genting.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        if ($source === 'verified') {
            $genting = Genting::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->findOrFail($id);
        } else {
            $genting = PendingGenting::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('created_by', $user->id)
              ->where('status', 'pending')
              ->findOrFail($id);
        }

        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kecamatan = $user->kecamatan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan) {
            Log::warning('Tidak ada data Kartu Keluarga atau kecamatan tidak ditemukan untuk kecamatan_id: ' . $user->kecamatan_id);
            return view('perangkat_daerah.genting.edit', compact('genting', 'kartuKeluargas', 'kecamatan', 'source'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau kecamatan tidak ditemukan.');
        }

        return view('perangkat_daerah.genting.edit', compact('genting', 'kartuKeluargas', 'kecamatan', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.genting.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'sasaran' => ['required', 'string', 'max:255'],
            'jenis_intervensi' => ['required', 'string', 'max:255'],
            'narasi' => ['nullable', 'string'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
            'dunia_usaha' => ['nullable', 'in:ada,tidak'],
            'dunia_usaha_frekuensi' => ['nullable', 'string', 'max:255'],
            'pemerintah' => ['nullable', 'in:ada,tidak'],
            'pemerintah_frekuensi' => ['nullable', 'string', 'max:255'],
            'bumn_bumd' => ['nullable', 'in:ada,tidak'],
            'bumn_bumd_frekuensi' => ['nullable', 'string', 'max:255'],
            'individu_perseorangan' => ['nullable', 'in:ada,tidak'],
            'individu_perseorangan_frekuensi' => ['nullable', 'string', 'max:255'],
            'lsm_komunitas' => ['nullable', 'in:ada,tidak'],
            'lsm_komunitas_frekuensi' => ['nullable', 'string', 'max:255'],
            'swasta' => ['nullable', 'in:ada,tidak'],
            'swasta_frekuensi' => ['nullable', 'string', 'max:255'],
            'perguruan_tinggi_akademisi' => ['nullable', 'in:ada,tidak'],
            'perguruan_tinggi_akademisi_frekuensi' => ['nullable', 'string', 'max:255'],
            'media' => ['nullable', 'in:ada,tidak'],
            'media_frekuensi' => ['nullable', 'string', 'max:255'],
            'tim_pendamping_keluarga' => ['nullable', 'in:ada,tidak'],
            'tim_pendamping_keluarga_frekuensi' => ['nullable', 'string', 'max:255'],
            'tokoh_masyarakat' => ['nullable', 'in:ada,tidak'],
            'tokoh_masyarakat_frekuensi' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = $user->id;
            $data['status'] = 'pending';

            if ($source === 'verified') {
                $genting = Genting::whereHas('kartuKeluarga', function ($query) use ($user) {
                    $query->where('kecamatan_id', $user->kecamatan_id);
                })->findOrFail($id);
                if ($request->hasFile('dokumentasi')) {
                    $data['dokumentasi'] = $request->file('dokumentasi')->store('pending_genting_dokumentasi', 'public');
                } else {
                    $data['dokumentasi'] = $genting->dokumentasi;
                }
                $data['original_genting_id'] = $genting->id;
                PendingGenting::create($data);
                $message = 'Perubahan data kegiatan genting berhasil diajukan untuk verifikasi.';
            } else {
                $genting = PendingGenting::whereHas('kartuKeluarga', function ($query) use ($user) {
                    $query->where('kecamatan_id', $user->kecamatan_id);
                })->where('created_by', $user->id)
                  ->where('status', 'pending')
                  ->findOrFail($id);
                if ($request->hasFile('dokumentasi')) {
                    if ($genting->dokumentasi && Storage::disk('public')->exists($genting->dokumentasi)) {
                        Storage::disk('public')->delete($genting->dokumentasi);
                    }
                    $data['dokumentasi'] = $request->file('dokumentasi')->store('pending_genting_dokumentasi', 'public');
                }
                $genting->update($data);
                $message = 'Data kegiatan genting berhasil diperbarui dan menunggu verifikasi.';
            }

            Log::info('Memperbarui data genting', ['id' => $id, 'source' => $source, 'data' => $data]);
            return redirect()->route('perangkat_daerah.genting.index', ['tab' => 'pending'])->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data genting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data genting: ' . $e->getMessage());
        }
    }

    public function destroy($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.genting.index', ['tab' => 'pending'])->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        if ($source === 'verified') {
            return redirect()->route('perangkat_daerah.genting.index', ['tab' => 'verified'])->with('error', 'Data kegiatan genting yang sudah terverifikasi tidak dapat dihapus.');
        }

        try {
            $genting = PendingGenting::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('created_by', $user->id)
              ->where('status', 'pending')
              ->findOrFail($id);
            if ($genting->dokumentasi && Storage::disk('public')->exists($genting->dokumentasi)) {
                Storage::disk('public')->delete($genting->dokumentasi);
            }
            $genting->delete();
            return redirect()->route('perangkat_daerah.genting.index', ['tab' => 'pending'])->with('success', 'Data kegiatan genting berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data genting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('perangkat_daerah.genting.index', ['tab' => 'pending'])->with('error', 'Gagal menghapus data genting: ' . $e->getMessage());
        }
    }
}