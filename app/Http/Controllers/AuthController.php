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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller; // Tambahkan impor ini

class AuthController extends Controller // Warisi Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'captcha' => ['required', 'captcha'],
        ], [
            'captcha.captcha' => 'Kode CAPTCHA tidak valid.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('User logged in: ' . $credentials['email']);
            return redirect()->route('dashboard');
        }

        Log::warning('Failed login attempt for email: ' . $credentials['email']);
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $email = Auth::user()->email;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::info('User logged out: ' . $email);
        return redirect()->route('welcome');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:pending_users'],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'role' => ['required', 'in:admin_kelurahan,perangkat_desa'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'penanggung_jawab' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:15', 'regex:/^\+?[1-9]\d{9,14}$/'],
            'pas_foto' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
            'surat_pengajuan' => ['required', 'file', 'mimes:pdf', 'max:7000'],
            'captcha' => ['required', 'captcha'],
        ], [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
            'no_telepon.regex' => 'Nomor telepon harus valid (misalnya, +6281234567890).',
            'captcha.captcha' => 'Kode CAPTCHA tidak valid.',
        ]);

        try {
            $pasFotoPath = $request->file('pas_foto')->store('pas_foto', 'private');
            $suratPath = $request->file('surat_pengajuan')->store('surat_pengajuan', 'private');

            PendingUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'penanggung_jawab' => encrypt($request->penanggung_jawab),
                'no_telepon' => encrypt($request->no_telepon),
                'pas_foto' => $pasFotoPath,
                'surat_pengajuan' => $suratPath,
                'status' => 'pending',
            ]);

            Log::info('User registered pending approval: ' . $request->email);
            return redirect()->route('register')->with('success', 'Pendaftaran berhasil, menunggu verifikasi Master.');
        } catch (\Exception $e) {
            Log::error('Gagal mendaftarkan pengguna: ' . $e->getMessage(), ['data' => $request->except(['password', 'password_confirmation'])]);
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
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