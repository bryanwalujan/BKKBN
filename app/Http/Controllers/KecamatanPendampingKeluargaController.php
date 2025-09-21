<?php

namespace App\Http\Controllers;

use App\Models\PendingPendampingKeluarga;
use App\Models\PendampingKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KecamatanPendampingKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');
        $search = $request->query('search');
        $user = Auth::user();
        $kecamatanId = $user->kecamatan_id;

        if ($tab === 'verified') {
            $query = PendampingKeluarga::with(['kecamatan', 'kelurahan'])
                ->where('kecamatan_id', $kecamatanId);
            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }
            $pendampingKeluargas = $query->paginate(10)->appends(['tab' => 'verified', 'search' => $search]);
        } else {
            $query = PendingPendampingKeluarga::with(['kecamatan', 'kelurahan', 'createdBy'])
                ->where('kecamatan_id', $kecamatanId);
            if ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            }
            $pendampingKeluargas = $query->paginate(10)->appends(['tab' => 'pending', 'search' => $search]);
        }

        return view('kecamatan.pendamping_keluarga.index', compact('pendampingKeluargas', 'tab', 'search'));
    }

    public function approve($id)
    {
        try {
            $pendamping = PendingPendampingKeluarga::where('kecamatan_id', Auth::user()->kecamatan_id)->findOrFail($id);
            if ($pendamping->status_verifikasi !== 'pending') {
                return redirect()->route('kecamatan.pendamping_keluarga.index')->with('error', 'Data sudah diverifikasi.');
            }

            $data = $pendamping->only([
                'nama', 'peran', 'kecamatan_id', 'kelurahan_id', 'status', 'tahun_bergabung',
                'penyuluhan', 'penyuluhan_frekuensi', 'rujukan', 'rujukan_frekuensi',
                'kunjungan_krs', 'kunjungan_krs_frekuensi', 'pendataan_bansos', 'pendataan_bansos_frekuensi',
                'pemantauan_kesehatan', 'pemantauan_kesehatan_frekuensi'
            ]);

            if ($pendamping->foto) {
                $newPath = str_replace('pending_pendamping_fotos', 'pendamping_fotos', $pendamping->foto);
                Storage::disk('public')->move($pendamping->foto, $newPath);
                $data['foto'] = $newPath;
            }

            if ($pendamping->original_id) {
                $original = PendampingKeluarga::findOrFail($pendamping->original_id);
                if ($original->foto && $original->foto !== $data['foto']) {
                    Storage::disk('public')->delete($original->foto);
                }
                $original->update($data);
                $original->kartuKeluargas()->sync($pendamping->kartuKeluargas->pluck('id')->toArray());
            } else {
                $newPendamping = PendampingKeluarga::create($data);
                $newPendamping->kartuKeluargas()->sync($pendamping->kartuKeluargas->pluck('id')->toArray());
            }

            $pendamping->update(['status_verifikasi' => 'approved']);
            $pendamping->kartuKeluargas()->detach();
            $pendamping->delete();

            return redirect()->route('kecamatan.pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil disetujui.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data Pendamping Keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.pendamping_keluarga.index')->with('error', 'Gagal menyetujui data: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'max:1000'],
        ]);

        try {
            $pendamping = PendingPendampingKeluarga::where('kecamatan_id', Auth::user()->kecamatan_id)->findOrFail($id);
            if ($pendamping->status_verifikasi !== 'pending') {
                return redirect()->route('kecamatan.pendamping_keluarga.index')->with('error', 'Data sudah diverifikasi.');
            }

            $pendamping->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $request->catatan,
            ]);

            if ($pendamping->foto) {
                Storage::disk('public')->delete($pendamping->foto);
            }
            $pendamping->kartuKeluargas()->detach();
            $pendamping->delete();

            return redirect()->route('kecamatan.pendamping_keluarga.index')->with('success', 'Data Pendamping Keluarga berhasil ditolak.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data Pendamping Keluarga: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.pendamping_keluarga.index')->with('error', 'Gagal menolak data: ' . $e->getMessage());
        }
    }
}