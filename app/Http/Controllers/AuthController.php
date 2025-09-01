<?php
namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\PendingUser;
use App\Models\User;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TemplateController;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:pending_users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', 'in:admin_kelurahan,perangkat_desa'],
            'kelurahan_nama' => ['required', 'string', 'max:255'],
            'penanggung_jawab' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:15'],
            'pas_foto' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'surat_pengajuan' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        $pasFotoPath = $request->file('pas_foto')->store('pas_foto', 'public');
        $suratPath = $request->file('surat_pengajuan')->store('surat_pengajuan', 'public');

        PendingUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'kelurahan_nama' => $request->kelurahan_nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'no_telepon' => $request->no_telepon,
            'pas_foto' => $pasFotoPath,
            'surat_pengajuan' => $suratPath,
            'status' => 'pending',
        ]);

        return redirect()->route('register')->with('success', 'Pendaftaran berhasil, menunggu verifikasi Master.');
    }

    public function downloadTemplate()
{
    $template = Template::latest()->first();
    if ($template && Storage::disk('public')->exists($template->file_path)) {
        return response()->download(Storage::disk('public')->path($template->file_path), $template->name . '.docx');
    }
    return redirect()->back()->with('error', 'Template tidak ditemukan.');
}

    public function dashboard()
    {
        if (auth()->user()->isMaster()) {
            return view('master.dashboard');
        } elseif (auth()->user()->isAdminKelurahan()) {
            return view('admin_kelurahan.dashboard');
        } else {
            return view('perangkat_desa.dashboard');
        }
    }
    
}