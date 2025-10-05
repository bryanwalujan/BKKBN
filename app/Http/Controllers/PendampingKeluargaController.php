<?php

namespace App\Http\Controllers;

use App\Models\PendampingKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use App\Models\LaporanPendamping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PendampingKeluargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pendampingKeluargas = PendampingKeluarga::with(['kecamatan', 'kelurahan', 'createdBy'])->paginate(10);
        return view('master.pendamping_keluarga.index', compact('pendampingKeluargas'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
        if ($kecamatans->isEmpty()) {
            Log::warning('Tidak ada kecamatan tersedia saat membuat pendamping keluarga.');
            return redirect()->route('pendamping_keluarga.index')->with('error', 'Tambahkan Kecamatan terlebih dahulu sebelum menambah data pendamping keluarga.');
        }
        return view('master.pendamping_keluarga.create', compact('kecamatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peran' => ['required', 'in:Bidan,Kader Posyandu,Kader Kesehatan,Tim Penggerak PKK'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'tahun_bergabung' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:7000'],
            'penyuluhan' => ['boolean'],
            'penyuluhan_frekuensi' => ['nullable', 'string', 'max:255'],
            'rujukan' => ['boolean'],
            'rujukan_frekuensi' => ['nullable', 'string', 'max:255'],
            'kunjungan_krs' => ['boolean'],
            'kunjungan_krs_frekuensi' => ['nullable', 'string', 'max:255'],
            'pendataan_bansos' => ['boolean'],
            'pendataan_bansos_frekuensi' => ['nullable', 'string', 'max:255'],
            'pemantauan_kesehatan' => ['boolean'],
            'pemantauan_kesehatan_frekuensi' => ['nullable', 'string', 'max:255'],
            'kartu_keluarga_ids' => ['array'],
            'kartu_keluarga_ids.*' => ['exists:kartu_keluargas,id'],
        ]);

        try {
            $validated['created_by'] = Auth::id();
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('pendamping_fotos', 'public');
            }

            $pendamping = PendampingKeluarga::create($validated);
            if ($request->kartu_keluarga_ids) {
                $pendamping->kartuKeluargas()->attach($request->kartu_keluarga_ids);
            }

            Log::info('Data Pendamping Keluarga berhasil ditambahkan.', ['id' => $pendamping->id, 'user_id' => Auth::id()]);
            return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data Pendamping Keluarga: ' . $e->getMessage(), ['data' => $request->all(), 'user_id' => Auth::id()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Pendamping Keluarga: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pendamping = PendampingKeluarga::with(['kecamatan', 'kelurahan', 'kartuKeluargas', 'createdBy'])->findOrFail($id);
        $kecamatans = Kecamatan::all();
        if ($kecamatans->isEmpty()) {
            Log::warning('Tidak ada kecamatan tersedia saat mengedit pendamping keluarga.', ['id' => $id]);
            return redirect()->route('pendamping_keluarga.index')->with('error', 'Tambahkan Kecamatan terlebih dahulu sebelum mengedit data pendamping keluarga.');
        }
        $kelurahans = $pendamping->kecamatan_id ? Kelurahan::where('kecamatan_id', $pendamping->kecamatan_id)->get() : collect([]);
        $kartuKeluargas = $pendamping->kelurahan_id ? KartuKeluarga::where('kelurahan_id', $pendamping->kelurahan_id)->get() : collect([]);
        return view('master.pendamping_keluarga.edit', compact('pendamping', 'kecamatans', 'kelurahans', 'kartuKeluargas'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peran' => ['required', 'in:Bidan,Kader Posyandu,Kader Kesehatan,Tim Penggerak PKK'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'tahun_bergabung' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:7000'],
            'penyuluhan' => ['boolean'],
            'penyuluhan_frekuensi' => ['nullable', 'string', 'max:255'],
            'rujukan' => ['boolean'],
            'rujukan_frekuensi' => ['nullable', 'string', 'max:255'],
            'kunjungan_krs' => ['boolean'],
            'kunjungan_krs_frekuensi' => ['nullable', 'string', 'max:255'],
            'pendataan_bansos' => ['boolean'],
            'pendataan_bansos_frekuensi' => ['nullable', 'string', 'max:255'],
            'pemantauan_kesehatan' => ['boolean'],
            'pemantauan_kesehatan_frekuensi' => ['nullable', 'string', 'max:255'],
            'kartu_keluarga_ids' => ['array'],
            'kartu_keluarga_ids.*' => ['exists:kartu_keluargas,id'],
        ]);

        try {
            $pendamping = PendampingKeluarga::findOrFail($id);
            $validated['created_by'] = $pendamping->created_by ?: Auth::id();

            if ($request->hasFile('foto')) {
                if ($pendamping->foto) {
                    Storage::disk('public')->delete($pendamping->foto);
                }
                $validated['foto'] = $request->file('foto')->store('pendamping_fotos', 'public');
            } else {
                $validated['foto'] = $pendamping->foto;
            }

            $pendamping->update($validated);
            $pendamping->kartuKeluargas()->sync($request->kartu_keluarga_ids ?? []);

            Log::info('Data Pendamping Keluarga berhasil diperbarui.', ['id' => $id, 'user_id' => Auth::id()]);
            return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data Pendamping Keluarga: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all(), 'user_id' => Auth::id()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data Pendamping Keluarga: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pendamping = PendampingKeluarga::findOrFail($id);
            if ($pendamping->foto) {
                Storage::disk('public')->delete($pendamping->foto);
            }
            $pendamping->kartuKeluargas()->detach();
            $pendamping->delete();

            Log::info('Data Pendamping Keluarga berhasil dihapus.', ['id' => $id, 'user_id' => Auth::id()]);
            return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data Pendamping Keluarga: ' . $e->getMessage(), ['id' => $id, 'user_id' => Auth::id()]);
            return redirect()->route('pendamping_keluarga.index')->with('error', 'Gagal menghapus data Pendamping Keluarga: ' . $e->getMessage());
        }
    }

    public function getKelurahans($kecamatan_id)
    {
        Log::info('Memuat kelurahan untuk kecamatan_id: ' . $kecamatan_id);

        try {
            $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)
                ->get(['id', 'nama_kelurahan'])
                ->map(function ($kelurahan) {
                    return [
                        'id' => $kelurahan->id,
                        'nama_kelurahan' => $kelurahan->nama_kelurahan
                    ];
                });

            if ($kelurahans->isEmpty()) {
                Log::warning('Tidak ada kelurahan ditemukan untuk kecamatan_id: ' . $kecamatan_id);
            }

            return response()->json($kelurahans);
        } catch (\Exception $e) {
            Log::error('Error saat memuat kelurahan: ' . $e->getMessage(), ['kecamatan_id' => $kecamatan_id]);
            return response()->json(['error' => 'Gagal memuat kelurahan'], 500);
        }
    }

    public function getByKecamatanKelurahan(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id');
        $kelurahan_id = $request->query('kelurahan_id');

        $query = KartuKeluarga::where('status', 'Aktif');
        if ($kecamatan_id) {
            $query->where('kecamatan_id', $kecamatan_id);
        }
        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }

        $kartuKeluargas = $query->get(['id', 'no_kk', 'kepala_keluarga']);
        return response()->json($kartuKeluargas);
    }

    public function storeLaporan(Request $request, $pendamping_id)
    {
        $validated = $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'laporan' => ['required', 'string'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:7000'],
            'tanggal_laporan' => ['required', 'date'],
        ]);

        try {
            if ($request->hasFile('dokumentasi')) {
                $validated['dokumentasi'] = $request->file('dokumentasi')->store('laporan_dokumentasi', 'public');
            }

            $validated['pendamping_keluarga_id'] = $pendamping_id;
            LaporanPendamping::create($validated);

            Log::info('Laporan pendamping berhasil ditambahkan.', ['pendamping_id' => $pendamping_id, 'user_id' => Auth::id()]);
            return redirect()->route('kartu_keluarga.show', $pendamping_id)->with('success', 'Laporan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan pendamping: ' . $e->getMessage(), ['pendamping_id' => $pendamping_id, 'data' => $request->all(), 'user_id' => Auth::id()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan laporan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pendamping = PendampingKeluarga::with(['kecamatan', 'kelurahan', 'kartuKeluargas', 'laporan', 'createdBy'])->findOrFail($id);
        return view('master.kartu_keluarga.show', compact('pendamping'));
    }
}