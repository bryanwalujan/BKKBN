<?php

namespace App\Http\Controllers;

use App\Models\PendingPendampingKeluarga;
use App\Models\PendampingKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PerangkatDaerahPendampingKeluargaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:perangkat_daerah']);
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');
        $search = $request->query('search');
        $user = Auth::user();
        $kecamatanId = $user->kecamatan_id;

        if (!$kecamatanId) {
            Log::warning('Perangkat daerah tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('dashboard')->with('error', 'Perangkat daerah tidak terkait dengan kecamatan.');
        }

        if ($tab === 'verified') {
            $query = PendampingKeluarga::with(['kecamatan', 'kelurahan'])
                ->where('kecamatan_id', $kecamatanId);
            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }
            $pendampingKeluargas = $query->paginate(10)->appends(['tab' => 'verified', 'search' => $search]);
        } else {
            $query = PendingPendampingKeluarga::with(['kecamatan', 'kelurahan', 'createdBy'])
                ->where('created_by', $user->id)
                ->where('kecamatan_id', $kecamatanId);
            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }
            $pendampingKeluargas = $query->paginate(10)->appends(['tab' => 'pending', 'search' => $search]);
        }

        return view('perangkat_daerah.pendamping_keluarga.index', compact('pendampingKeluargas', 'tab', 'search'));
    }

    public function create()
    {
        $user = Auth::user();
        $kecamatan = Kecamatan::find($user->kecamatan_id);
        if (!$kecamatan) {
            Log::warning('Kecamatan tidak ditemukan untuk perangkat daerah.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.pendamping_keluarga.index')->with('error', 'Kecamatan Anda belum terdaftar.');
        }

        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan->id)->get();
        if ($kelurahans->isEmpty()) {
            Log::warning('Tidak ada kelurahan untuk kecamatan_id: ' . $kecamatan->id);
            return redirect()->route('perangkat_daerah.pendamping_keluarga.index')->with('error', 'Tambahkan Kelurahan terlebih dahulu.');
        }

        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $kecamatan->id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        if ($kartuKeluargas->isEmpty()) {
            Log::warning('Tidak ada kartu keluarga aktif untuk kecamatan_id: ' . $kecamatan->id);
            return view('perangkat_daerah.pendamping_keluarga.create', compact('kecamatan', 'kelurahans', 'kartuKeluargas'))
                ->with('error', 'Tidak ada data Kartu Keluarga aktif yang tersedia.');
        }

        return view('perangkat_daerah.pendamping_keluarga.create', compact('kecamatan', 'kelurahans', 'kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peran' => ['required', 'in:Bidan,Kader Posyandu,Kader Kesehatan,Tim Penggerak PKK'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id,kecamatan_id,' . Auth::user()->kecamatan_id],
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
            'kartu_keluarga_ids' => ['array', 'nullable'],
            'kartu_keluarga_ids.*' => ['exists:kartu_keluargas,id,kecamatan_id,' . Auth::user()->kecamatan_id . ',status,Aktif'],
        ]);

        try {
            $user = Auth::user();
            if ($user->kecamatan_id != $validated['kecamatan_id']) {
                Log::warning('Akses tidak diizinkan: kecamatan_id tidak sesuai.', [
                    'user_kecamatan_id' => $user->kecamatan_id,
                    'input_kecamatan_id' => $validated['kecamatan_id'],
                ]);
                return redirect()->back()->withInput()->with('error', 'Anda hanya dapat menambahkan data untuk kecamatan Anda.');
            }

            // Log data yang divalidasi untuk debugging
            Log::info('Data yang divalidasi untuk penyimpanan:', $validated);

            // Siapkan data untuk disimpan
            $data = [
                'nama' => $validated['nama'],
                'peran' => $validated['peran'],
                'kecamatan_id' => $validated['kecamatan_id'],
                'kelurahan_id' => $validated['kelurahan_id'],
                'status' => $validated['status'],
                'tahun_bergabung' => $validated['tahun_bergabung'],
                'penyuluhan' => $validated['penyuluhan'] ?? 0,
                'penyuluhan_frekuensi' => $validated['penyuluhan_frekuensi'] ?? null,
                'rujukan' => $validated['rujukan'] ?? 0,
                'rujukan_frekuensi' => $validated['rujukan_frekuensi'] ?? null,
                'kunjungan_krs' => $validated['kunjungan_krs'] ?? 0,
                'kunjungan_krs_frekuensi' => $validated['kunjungan_krs_frekuensi'] ?? null,
                'pendataan_bansos' => $validated['pendataan_bansos'] ?? 0,
                'pendataan_bansos_frekuensi' => $validated['pendataan_bansos_frekuensi'] ?? null,
                'pemantauan_kesehatan' => $validated['pemantauan_kesehatan'] ?? 0,
                'pemantauan_kesehatan_frekuensi' => $validated['pemantauan_kesehatan_frekuensi'] ?? null,
                'created_by' => $user->id,
                'status_verifikasi' => 'pending',
            ];

            // Tangani upload foto jika ada
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pending_pendamping_fotos', 'public');
            }

            // Simpan data ke tabel pending_pendamping_keluargas
            $pendamping = PendingPendampingKeluarga::create($data);

            // Sinkronkan kartu keluarga jika ada, menggunakan tabel pivot pending_kartu_keluarga_pendamping
            if (!empty($validated['kartu_keluarga_ids'])) {
                $pendamping->kartuKeluargas()->attach($validated['kartu_keluarga_ids']);
            }

            Log::info('Data Pendamping Keluarga berhasil disimpan.', [
                'pending_pendamping_id' => $pendamping->id,
                'kartu_keluarga_ids' => $validated['kartu_keluarga_ids'] ?? [],
            ]);

            return redirect()->route('perangkat_daerah.pendamping_keluarga.index')
                ->with('success', 'Data Pendamping Keluarga berhasil diajukan untuk verifikasi.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data Pendamping Keluarga: ' . $e->getMessage(), [
                'data' => $request->all(),
                'validated' => $validated,
            ]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        $kecamatan = Kecamatan::find($user->kecamatan_id);
        if (!$kecamatan) {
            Log::warning('Kecamatan tidak ditemukan untuk perangkat daerah.', ['user_id' => $user->id]);
            return redirect()->route('perangkat_daerah.pendamping_keluarga.index')->with('error', 'Kecamatan Anda belum terdaftar.');
        }

        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan->id)->get();
        if ($kelurahans->isEmpty()) {
            Log::warning('Tidak ada kelurahan untuk kecamatan_id: ' . $kecamatan->id);
            return redirect()->route('perangkat_daerah.pendamping_keluarga.index')->with('error', 'Tambahkan Kelurahan terlebih dahulu.');
        }

        if ($source === 'verified') {
            $pendamping = PendampingKeluarga::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id);
        } else {
            $pendamping = PendingPendampingKeluarga::where('created_by', $user->id)
                ->where('kecamatan_id', $user->kecamatan_id)
                ->findOrFail($id);
        }

        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $kecamatan->id)
            ->where('kelurahan_id', $pendamping->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        if ($kartuKeluargas->isEmpty()) {
            Log::warning('Tidak ada kartu keluarga aktif untuk kelurahan_id: ' . $pendamping->kelurahan_id);
            return view('perangkat_daerah.pendamping_keluarga.edit', compact('pendamping', 'kecamatan', 'kelurahans', 'kartuKeluargas', 'source'))
                ->with('error', 'Tidak ada data Kartu Keluarga aktif untuk kelurahan ini.');
        }

        return view('perangkat_daerah.pendamping_keluarga.edit', compact('pendamping', 'kecamatan', 'kelurahans', 'kartuKeluargas', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'peran' => ['required', 'in:Bidan,Kader Posyandu,Kader Kesehatan,Tim Penggerak PKK'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id,kecamatan_id,' . Auth::user()->kecamatan_id],
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
            'kartu_keluarga_ids' => ['array', 'nullable'],
            'kartu_keluarga_ids.*' => ['exists:kartu_keluargas,id,kecamatan_id,' . Auth::user()->kecamatan_id . ',status,Aktif'],
        ]);

        try {
            $user = Auth::user();
            if ($user->kecamatan_id != $validated['kecamatan_id']) {
                Log::warning('Akses tidak diizinkan: kecamatan_id tidak sesuai.', [
                    'user_kecamatan_id' => $user->kecamatan_id,
                    'input_kecamatan_id' => $validated['kecamatan_id'],
                ]);
                return redirect()->back()->withInput()->with('error', 'Anda hanya dapat mengedit data untuk kecamatan Anda.');
            }

            // Log data yang divalidasi untuk debugging
            Log::info('Data yang divalidasi untuk pembaruan:', $validated);

            // Siapkan data untuk pembaruan
            $data = [
                'nama' => $validated['nama'],
                'peran' => $validated['peran'],
                'kecamatan_id' => $validated['kecamatan_id'],
                'kelurahan_id' => $validated['kelurahan_id'],
                'status' => $validated['status'],
                'tahun_bergabung' => $validated['tahun_bergabung'],
                'penyuluhan' => $validated['penyuluhan'] ?? 0,
                'penyuluhan_frekuensi' => $validated['penyuluhan_frekuensi'] ?? null,
                'rujukan' => $validated['rujukan'] ?? 0,
                'rujukan_frekuensi' => $validated['rujukan_frekuensi'] ?? null,
                'kunjungan_krs' => $validated['kunjungan_krs'] ?? 0,
                'kunjungan_krs_frekuensi' => $validated['kunjungan_krs_frekuensi'] ?? null,
                'pendataan_bansos' => $validated['pendataan_bansos'] ?? 0,
                'pendataan_bansos_frekuensi' => $validated['pendataan_bansos_frekuensi'] ?? null,
                'pemantauan_kesehatan' => $validated['pemantauan_kesehatan'] ?? 0,
                'pemantauan_kesehatan_frekuensi' => $validated['pemantauan_kesehatan_frekuensi'] ?? null,
            ];

            if ($source === 'verified') {
                $original = PendampingKeluarga::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id);
                $data['created_by'] = $user->id;
                $data['status_verifikasi'] = 'pending';
                $data['original_id'] = $id;

                if ($request->hasFile('foto')) {
                    $data['foto'] = $request->file('foto')->store('pending_pendamping_fotos', 'public');
                } else {
                    $data['foto'] = $original->foto;
                }

                $pendamping = PendingPendampingKeluarga::create($data);
                $pendamping->kartuKeluargas()->sync($validated['kartu_keluarga_ids'] ?? []);

                Log::info('Perubahan data Pendamping Keluarga (verified) berhasil disimpan.', [
                    'pending_pendamping_id' => $pendamping->id,
                    'kartu_keluarga_ids' => $validated['kartu_keluarga_ids'] ?? [],
                ]);

                return redirect()->route('perangkat_daerah.pendamping_keluarga.index')
                    ->with('success', 'Perubahan data Pendamping Keluarga berhasil diajukan untuk verifikasi.');
            } else {
                $pendamping = PendingPendampingKeluarga::where('created_by', $user->id)
                    ->where('kecamatan_id', $user->kecamatan_id)
                    ->findOrFail($id);

                if ($request->hasFile('foto')) {
                    if ($pendamping->foto) {
                        Storage::disk('public')->delete($pendamping->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('pending_pendamping_fotos', 'public');
                } else {
                    $data['foto'] = $pendamping->foto;
                }

                $pendamping->update($data);
                $pendamping->kartuKeluargas()->sync($validated['kartu_keluarga_ids'] ?? []);

                Log::info('Data Pendamping Keluarga (pending) berhasil diperbarui.', [
                    'pending_pendamping_id' => $pendamping->id,
                    'kartu_keluarga_ids' => $validated['kartu_keluarga_ids'] ?? [],
                ]);

                return redirect()->route('perangkat_daerah.pendamping_keluarga.index')
                    ->with('success', 'Data Pendamping Keluarga berhasil diperbarui dan menunggu verifikasi.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data Pendamping Keluarga: ' . $e->getMessage(), [
                'id' => $id,
                'data' => $request->all(),
                'validated' => $validated,
            ]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pendamping = PendingPendampingKeluarga::where('created_by', Auth::id())
                ->where('kecamatan_id', Auth::user()->kecamatan_id)
                ->findOrFail($id);
            if ($pendamping->foto) {
                Storage::disk('public')->delete($pendamping->foto);
            }
            $pendamping->kartuKeluargas()->detach();
            $pendamping->delete();

            Log::info('Data Pendamping Keluarga berhasil dihapus.', ['pending_pendamping_id' => $id]);

            return redirect()->route('perangkat_daerah.pendamping_keluarga.index')
                ->with('success', 'Data Pendamping Keluarga berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data Pendamping Keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('perangkat_daerah.pendamping_keluarga.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function getKelurahansByKecamatan($kecamatanId)
    {
        try {
            if (Auth::user()->kecamatan_id != $kecamatanId) {
                Log::warning('Akses tidak diizinkan untuk kecamatan ini.', ['kecamatan_id' => $kecamatanId, 'user_id' => Auth::id()]);
                return response()->json(['error' => 'Akses tidak diizinkan untuk kecamatan ini.'], 403);
            }

            $kelurahans = Kelurahan::where('kecamatan_id', $kecamatanId)
                ->get(['id', 'nama_kelurahan'])
                ->map(function ($kelurahan) {
                    return ['id' => $kelurahan->id, 'nama_kelurahan' => $kelurahan->nama_kelurahan];
                });

            if ($kelurahans->isEmpty()) {
                Log::warning('Tidak ada kelurahan ditemukan untuk kecamatan_id: ' . $kecamatanId);
                return response()->json(['error' => 'Tidak ada kelurahan ditemukan untuk kecamatan ini.'], 404);
            }

            return response()->json($kelurahans);
        } catch (\Exception $e) {
            Log::error('Error saat memuat kelurahan: ' . $e->getMessage(), ['kecamatan_id' => $kecamatanId]);
            return response()->json(['error' => 'Gagal memuat kelurahan: ' . $e->getMessage()], 500);
        }
    }

    public function getKartuKeluargaByKelurahan($kelurahanId)
    {
        try {
            $user = Auth::user();
            $kelurahan = Kelurahan::where('id', $kelurahanId)
                ->where('kecamatan_id', $user->kecamatan_id)
                ->firstOrFail();

            $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $kelurahanId)
                ->where('kecamatan_id', $user->kecamatan_id)
                ->where('status', 'Aktif')
                ->get(['id', 'no_kk', 'kepala_keluarga'])
                ->map(function ($kk) {
                    return [
                        'id' => $kk->id,
                        'no_kk' => $kk->no_kk,
                        'kepala_keluarga' => $kk->kepala_keluarga,
                    ];
                });

            if ($kartuKeluargas->isEmpty()) {
                Log::warning('Tidak ada kartu keluarga aktif untuk kelurahan_id: ' . $kelurahanId);
                return response()->json(['error' => 'Tidak ada kartu keluarga aktif ditemukan untuk kelurahan ini.'], 404);
            }

            return response()->json($kartuKeluargas);
        } catch (\Exception $e) {
            Log::error('Error saat memuat kartu keluarga: ' . $e->getMessage(), ['kelurahan_id' => $kelurahanId]);
            return response()->json(['error' => 'Gagal memuat kartu keluarga: ' . $e->getMessage()], 500);
        }
    }

    public function getByKecamatanKelurahan(Request $request)
    {
        try {
            $kecamatan_id = $request->query('kecamatan_id');
            $kelurahan_id = $request->query('kelurahan_id');

            Log::info('Memuat kartu keluarga', [
                'kecamatan_id' => $kecamatan_id,
                'kelurahan_id' => $kelurahan_id,
                'user_id' => Auth::id(),
            ]);

            $query = KartuKeluarga::where('status', 'Aktif');

            if ($kecamatan_id) {
                $query->where('kecamatan_id', $kecamatan_id);
            }

            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }

            $kartuKeluargas = $query->get(['id', 'no_kk', 'kepala_keluarga'])->map(function ($kk) {
                return [
                    'id' => $kk->id,
                    'no_kk' => $kk->no_kk,
                    'kepala_keluarga' => $kk->kepala_keluarga,
                ];
            });

            if ($kartuKeluargas->isEmpty()) {
                Log::warning('Tidak ada kartu keluarga aktif ditemukan', [
                    'kecamatan_id' => $kecamatan_id,
                    'kelurahan_id' => $kelurahan_id,
                ]);
                return response()->json(['error' => 'Tidak ada kartu keluarga aktif untuk kecamatan/kelurahan ini.'], 404);
            }

            return response()->json($kartuKeluargas);
        } catch (\Exception $e) {
            Log::error('Gagal memuat kartu keluarga: ' . $e->getMessage(), [
                'kecamatan_id' => $kecamatan_id,
                'kelurahan_id' => $kelurahan_id,
                'user_id' => Auth::id(),
            ]);
            return response()->json(['error' => 'Gagal memuat kartu keluarga: ' . $e->getMessage()], 500);
        }
    }
}