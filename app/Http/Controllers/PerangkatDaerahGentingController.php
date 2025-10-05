<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genting;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        $query = Genting::with('kartuKeluarga')
            ->whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })
            ->where('created_by', $user->id);

        if ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $gentings = $query->paginate(10)->appends(['search' => $search]);
        return view('perangkat_daerah.genting.index', compact('gentings', 'search'));
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

            if ($request->hasFile('dokumentasi')) {
                $data['dokumentasi'] = $request->file('dokumentasi')->store('genting_dokumentasi', 'public');
            }

            Genting::create($data);
            Log::info('Menyimpan data genting', ['data' => $data]);
            return redirect()->route('perangkat_daerah.genting.index')->with('success', 'Data kegiatan genting berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data genting: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data genting: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.genting.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        $genting = Genting::whereHas('kartuKeluarga', function ($query) use ($user) {
            $query->where('kecamatan_id', $user->kecamatan_id);
        })->where('created_by', $user->id)->findOrFail($id);

        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);
        $kecamatan = $user->kecamatan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan) {
            Log::warning('Tidak ada data Kartu Keluarga atau kecamatan tidak ditemukan untuk kecamatan_id: ' . $user->kecamatan_id);
            return view('perangkat_daerah.genting.edit', compact('genting', 'kartuKeluargas', 'kecamatan'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau kecamatan tidak ditemukan.');
        }

        return view('perangkat_daerah.genting.edit', compact('genting', 'kartuKeluargas', 'kecamatan'));
    }

    public function update(Request $request, $id)
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
            $genting = Genting::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('created_by', $user->id)->findOrFail($id);

            $data = $request->all();
            $data['created_by'] = $user->id;

            if ($request->hasFile('dokumentasi')) {
                if ($genting->dokumentasi && Storage::disk('public')->exists($genting->dokumentasi)) {
                    Storage::disk('public')->delete($genting->dokumentasi);
                }
                $data['dokumentasi'] = $request->file('dokumentasi')->store('genting_dokumentasi', 'public');
            }

            $genting->update($data);
            Log::info('Memperbarui data genting', ['id' => $id, 'data' => $data]);
            return redirect()->route('perangkat_daerah.genting.index')->with('success', 'Data kegiatan genting berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data genting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data genting: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('perangkat_daerah.genting.index')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        try {
            $genting = Genting::whereHas('kartuKeluarga', function ($query) use ($user) {
                $query->where('kecamatan_id', $user->kecamatan_id);
            })->where('created_by', $user->id)->findOrFail($id);

            if ($genting->dokumentasi && Storage::disk('public')->exists($genting->dokumentasi)) {
                Storage::disk('public')->delete($genting->dokumentasi);
            }
            $genting->delete();
            Log::info('Menghapus data genting', ['id' => $id]);
            return redirect()->route('perangkat_daerah.genting.index')->with('success', 'Data kegiatan genting berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data genting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('perangkat_daerah.genting.index')->with('error', 'Gagal menghapus data genting: ' . $e->getMessage());
        }
    }
}