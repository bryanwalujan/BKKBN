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

class PendampingKeluargaController extends Controller
{
    public function index()
    {
        $pendampingKeluargas = PendampingKeluarga::with(['kecamatan', 'kelurahan'])->get();
        return view('master.pendamping_keluarga.index', compact('pendampingKeluargas'));
    }

    public function create()
    {
        $kecamatans = Kecamatan::all();
        if ($kecamatans->isEmpty()) {
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
            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('pendamping_fotos', 'public');
            }

            $pendamping = PendampingKeluarga::create($validated);

            if ($request->kartu_keluarga_ids) {
                $pendamping->kartuKeluargas()->attach($request->kartu_keluarga_ids);
            }

            return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data Pendamping Keluarga: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Pendamping Keluarga: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pendamping = PendampingKeluarga::findOrFail($id);
        $kecamatans = Kecamatan::all();
        if ($kecamatans->isEmpty()) {
            return redirect()->route('pendamping_keluarga.index')->with('error', 'Tambahkan Kecamatan terlebih dahulu sebelum mengedit data pendamping keluarga.');
        }
        $kelurahans = $pendamping->kecamatan_id ? Kelurahan::where('kecamatan_id', $pendamping->kecamatan_id)->get() : collect([]);
        return view('master.pendamping_keluarga.edit', compact('pendamping', 'kecamatans', 'kelurahans'));
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

            return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data Pendamping Keluarga: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
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

            return redirect()->route('pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data Pendamping Keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('pendamping_keluarga.index')->with('error', 'Gagal menghapus data Pendamping Keluarga: ' . $e->getMessage());
        }
    }

    public function getKelurahans($kecamatan_id)
    {
        Log::info('Memuat kelurahan untuk kecamatan_id: ' . $kecamatan_id);

        try {
            $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)
                ->get(['id', 'nama_kelurahan']) // Gunakan nama_kelurahan seperti di balita
                ->map(function ($kelurahan) {
                    return [
                        'id' => $kelurahan->id, 
                        'nama_kelurahan' => $kelurahan->nama_kelurahan // Sesuaikan dengan struktur balita
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

     public function getKelurahansAlt(Request $request)
    {
        $kecamatan_id = $request->query('kecamatan_id');
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

            return redirect()->route('pendamping_keluarga.show', $pendamping_id)->with('success', 'Laporan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan pendamping: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan laporan: ' . $e->getMessage());
        }
    }

    public function show($id)
{
    $kartuKeluarga = KartuKeluarga::with([
        'kecamatan',
        'kelurahan',
        'ibu',
        'balitas',
        'remajaPutris',
        'aksiKonvergensis',
        'gentings',
        'dataMonitorings',
        'pendampingKeluargas'
    ])->findOrFail($id);
    return view('master.kartu_keluarga.show', compact('kartuKeluarga'));
}
}