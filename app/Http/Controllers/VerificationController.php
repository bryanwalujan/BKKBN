<?php
namespace App\Http\Controllers;

use App\Models\PendingUser;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = PendingUser::where('status', 'pending')->with(['kecamatan', 'kelurahan'])->get();
        $kecamatans = Kecamatan::all();
        return view('master.verifikasi', compact('pendingUsers', 'kecamatans'));
    }

    public function approve(Request $request, $id)
    {
        $pendingUser = PendingUser::findOrFail($id);

        try {
            $user = User::create([
                'name' => $pendingUser->name,
                'email' => $pendingUser->email,
                'password' => $pendingUser->password,
                'role' => $pendingUser->role,
                'kecamatan_id' => $pendingUser->kecamatan_id,
                'kelurahan_id' => $pendingUser->kelurahan_id,
                'penanggung_jawab' => $pendingUser->penanggung_jawab,
                'no_telepon' => $pendingUser->no_telepon,
                'pas_foto' => $pendingUser->pas_foto,
                'surat_pengajuan' => $pendingUser->surat_pengajuan,
            ]);

            $pendingUser->delete(); // Hapus dari pending_users setelah disetujui

            Log::info('Akun disetujui: ' . $pendingUser->email, [
                'user_id' => $user->id,
                'kecamatan_id' => $pendingUser->kecamatan_id,
                'kelurahan_id' => $pendingUser->kelurahan_id,
            ]);

            return redirect()->route('verifikasi.index')->with('success', 'Akun berhasil disetujui.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui akun: ' . $e->getMessage(), [
                'pending_user_id' => $id,
                'email' => $pendingUser->email,
                'error' => $e->getTraceAsString(),
            ]);
            return redirect()->route('verifikasi.index')->with('error', 'Gagal menyetujui akun: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        $pendingUser = PendingUser::findOrFail($id);

        try {
            // Simpan catatan ke log
            Log::info("Akun ditolak: ID {$id}, Nama: {$pendingUser->name}, Catatan: {$request->catatan}");

            // Hapus pas_foto dan surat_pengajuan jika ada
            if ($pendingUser->pas_foto && Storage::disk('public')->exists($pendingUser->pas_foto)) {
                Storage::disk('public')->delete($pendingUser->pas_foto);
            } else {
                Log::warning('Pas foto tidak ditemukan: ' . $pendingUser->pas_foto, [
                    'pending_user_id' => $id,
                    'email' => $pendingUser->email,
                ]);
            }

            if ($pendingUser->surat_pengajuan && Storage::disk('public')->exists($pendingUser->surat_pengajuan)) {
                Storage::disk('public')->delete($pendingUser->surat_pengajuan);
            } else {
                Log::warning('Surat pengajuan tidak ditemukan: ' . $pendingUser->surat_pengajuan, [
                    'pending_user_id' => $id,
                    'email' => $pendingUser->email,
                ]);
            }

            $pendingUser->delete(); // Hapus record dari pending_users

            return redirect()->route('verifikasi.index')->with('success', 'Akun ditolak dan dihapus dari daftar pengajuan.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak akun: ' . $e->getMessage(), [
                'pending_user_id' => $id,
                'email' => $pendingUser->email,
                'error' => $e->getTraceAsString(),
            ]);
            return redirect()->route('verifikasi.index')->with('error', 'Gagal menolak akun: ' . $e->getMessage());
        }
    }
}