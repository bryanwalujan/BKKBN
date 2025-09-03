<?php
namespace App\Http\Controllers;

use App\Models\PendingUser;
use App\Models\User;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = PendingUser::where('status', 'pending')->get();
        $kecamatans = Kecamatan::all();
        return view('master.verifikasi', compact('pendingUsers', 'kecamatans'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
        ]);

        $pendingUser = PendingUser::findOrFail($id);

        $user = User::create([
            'name' => $pendingUser->name,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password,
            'role' => $pendingUser->role,
            'kecamatan_id' => $request->kecamatan_id,
            'penanggung_jawab' => $pendingUser->penanggung_jawab,
            'no_telepon' => $pendingUser->no_telepon,
            'pas_foto' => $pendingUser->pas_foto,
        ]);

        $pendingUser->delete(); // Hapus dari pending_users setelah disetujui

        return redirect()->route('verifikasi.index')->with('success', 'Akun berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        $pendingUser = PendingUser::findOrFail($id);

        // Simpan catatan ke log untuk referensi (opsional)
        \Log::info("Akun ditolak: ID {$id}, Nama: {$pendingUser->name}, Catatan: {$request->catatan}");

        // Hapus pas_foto dan surat_pengajuan jika ada
        if ($pendingUser->pas_foto) {
            Storage::delete('public/pas_foto/' . $pendingUser->pas_foto);
        }
        if ($pendingUser->surat_pengajuan) {
            Storage::delete('public/surat_pengajuan/' . $pendingUser->surat_pengajuan);
        }

        $pendingUser->delete(); // Hapus record dari pending_users

        return redirect()->route('verifikasi.index')->with('success', 'Akun ditolak dan dihapus dari daftar pengajuan.');
    }
}