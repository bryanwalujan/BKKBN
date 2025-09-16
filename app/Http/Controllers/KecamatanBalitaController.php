<?php

namespace App\Http\Controllers;

use App\Models\PendingBalita;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class KecamatanBalitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kecamatan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $kecamatan_id = $user->kecamatan_id;

        if (!$kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $query = PendingBalita::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status', 'pending');

        $balitas = $query->paginate(10);

        return view('kecamatan.balita.verifikasi', compact('balitas'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.balita.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingBalita = PendingBalita::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id);

            $data = [
                'kartu_keluarga_id' => $pendingBalita->kartu_keluarga_id,
                'nik' => $pendingBalita->nik,
                'nama' => $pendingBalita->nama,
                'tanggal_lahir' => $pendingBalita->tanggal_lahir,
                'jenis_kelamin' => $pendingBalita->jenis_kelamin,
                'kecamatan_id' => $pendingBalita->kecamatan_id,
                'kelurahan_id' => $pendingBalita->kelurahan_id,
                'berat_tinggi' => $pendingBalita->berat_tinggi,
                'lingkar_kepala' => $pendingBalita->lingkar_kepala,
                'lingkar_lengan' => $pendingBalita->lingkar_lengan,
                'alamat' => $pendingBalita->alamat,
                'status_gizi' => $pendingBalita->status_gizi,
                'warna_label' => $pendingBalita->warna_label,
                'status_pemantauan' => $pendingBalita->status_pemantauan,
                'foto' => $pendingBalita->foto,
            ];

            if ($pendingBalita->original_balita_id) {
                // Update data di balitas jika original_balita_id ada
                $existingBalita = Balita::findOrFail($pendingBalita->original_balita_id);
                $existingBalita->update($data);
                Log::info('Memperbarui data balita di balitas', ['id' => $existingBalita->id, 'data' => $data]);
            } else {
                // Buat baru jika tidak ada original_balita_id
                $existingBalita = Balita::where('nik', $pendingBalita->nik)->first();
                if ($existingBalita) {
                    $existingBalita->update($data);
                    Log::info('Memperbarui data balita di balitas', ['id' => $existingBalita->id, 'data' => $data]);
                } else {
                    Balita::create($data);
                    Log::info('Menyimpan data balita ke balitas', ['data' => $data]);
                }
            }

            $pendingBalita->update(['status' => 'approved']);
            $pendingBalita->delete();

            return redirect()->route('kecamatan.balita.index')->with('success', 'Data balita berhasil disetujui.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.balita.index')->with('error', 'Gagal menyetujui data balita: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.balita.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingBalita = PendingBalita::where('kecamatan_id', $user->kecamatan_id)->findOrFail($id);

            if ($pendingBalita->foto && Storage::disk('public')->exists($pendingBalita->foto)) {
                Storage::disk('public')->delete($pendingBalita->foto);
            }

            $pendingBalita->update([
                'status' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingBalita->delete();

            Log::info('Data balita ditolak', ['id' => $id, 'catatan' => $request->catatan]);

            return redirect()->route('kecamatan.balita.index')->with('success', 'Data balita ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.balita.index')->with('error', 'Gagal menolak data balita: ' . $e->getMessage());
        }
    }
}