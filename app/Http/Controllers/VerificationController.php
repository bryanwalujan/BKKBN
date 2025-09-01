<?php
namespace App\Http\Controllers;

use App\Models\PendingUser;
use App\Models\User;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = PendingUser::where('status', 'pending')->get();
        $kelurahans = Kelurahan::all();
        return view('master.verifikasi', compact('pendingUsers', 'kelurahans'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
        ]);

        $pendingUser = PendingUser::findOrFail($id);

        $user = User::create([
            'name' => $pendingUser->name,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password,
            'role' => $pendingUser->role,
            'kelurahan_id' => $request->kelurahan_id,
            'penanggung_jawab' => $pendingUser->penanggung_jawab,
            'no_telepon' => $pendingUser->no_telepon,
            'pas_foto' => $pendingUser->pas_foto,
        ]);

        $pendingUser->update(['status' => 'approved']);

        return redirect()->route('verifikasi.index')->with('success', 'Akun berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        $pendingUser = PendingUser::findOrFail($id);
        $pendingUser->update([
            'status' => 'rejected',
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('verifikasi.index')->with('success', 'Akun ditolak.');
    }
}