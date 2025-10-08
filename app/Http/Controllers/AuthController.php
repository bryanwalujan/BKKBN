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
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;

class AuthController extends Controller
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
            // 'captcha' => ['required', 'captcha'],
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
        $kecamatans = \App\Models\Kecamatan::all();
        return view('auth.register', compact('kecamatans'));
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'unique:pending_users,email'],
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'role' => ['required', 'in:admin_kelurahan,perangkat_daerah'],
                'kecamatan_id' => ['required', 'exists:kecamatans,id'],
                'kelurahan_id' => ['required', 'exists:kelurahans,id'],
                'penanggung_jawab' => ['required', 'string', 'max:255'],
                'no_telepon' => ['required', 'string', 'max:15', 'regex:/^\+?[1-9]\d{9,14}$/'],
                'pas_foto' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
                'surat_pengajuan' => ['required', 'file', 'mimes:pdf', 'max:7000'],
                // 'captcha' => ['required', 'captcha'],
            ], [
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
                'no_telepon.regex' => 'Nomor telepon harus valid (misalnya, +6281234567890).',
                // 'captcha.captcha' => 'Kode CAPTCHA tidak valid.',
            ]);

            // Validasi relasi kecamatan dan kelurahan
            $kelurahan = Kelurahan::find($request->kelurahan_id);
            if (!$kelurahan || $kelurahan->kecamatan_id != $request->kecamatan_id) {
                throw ValidationException::withMessages([
                    'kelurahan_id' => 'Kelurahan yang dipilih tidak sesuai dengan kecamatan.',
                ]);
            }

            // Simpan file di disk public
            try {
                $pasFotoPath = $request->file('pas_foto')->store('pas_foto', 'public');
                $suratPath = $request->file('surat_pengajuan')->store('surat_pengajuan', 'public');
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan file: ' . $e->getMessage(), [
                    'email' => $request->email,
                    'error' => $e->getTraceAsString(),
                ]);
                throw new \Exception('Gagal menyimpan file pas foto atau surat pengajuan: ' . $e->getMessage());
            }

            // Simpan data ke pending_users
            try {
                PendingUser::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'kecamatan_id' => $request->kecamatan_id,
                    'kelurahan_id' => $request->kelurahan_id,
                    'penanggung_jawab' => $request->penanggung_jawab,
                    'no_telepon' => $request->no_telepon,
                    'pas_foto' => $pasFotoPath,
                    'surat_pengajuan' => $suratPath,
                    'status' => 'pending',
                ]);
            } catch (QueryException $e) {
                Log::error('Gagal menyimpan data ke pending_users: ' . $e->getMessage(), [
                    'email' => $request->email,
                    'data' => $request->except(['password', 'password_confirmation']),
                    'sql' => $e->getSql(),
                    'bindings' => $e->getBindings(),
                    'error' => $e->getTraceAsString(),
                ]);
                // Hapus file yang sudah diunggah jika gagal menyimpan
                if (isset($pasFotoPath)) {
                    Storage::disk('public')->delete($pasFotoPath);
                }
                if (isset($suratPath)) {
                    Storage::disk('public')->delete($suratPath);
                }
                throw new \Exception('Gagal menyimpan data pendaftaran: ' . $e->getMessage());
            }

            Log::info('User registered pending approval: ' . $request->email);
            return redirect()->route('register')->with('success', 'Pendaftaran berhasil, menunggu verifikasi Dinas PPKBD.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Gagal mendaftarkan pengguna: ' . $e->getMessage(), [
                'email' => $request->email,
                'data' => $request->except(['password', 'password_confirmation']),
                'error' => $e->getTraceAsString(),
            ]);
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
        $user = auth()->user();
        if ($user->isMaster()) {
            return view('master.dashboard');
        } elseif ($user->isAdminKecamatan()) {
            return view('kecamatan.dashboard');
        } elseif ($user->isAdminKelurahan()) {
            return view('kelurahan.dashboard');
        } else {
            return view('perangkat_daerah.dashboard');
        }
    }

    public function getKelurahansByKecamatan($kecamatanId)
    {
        try {
            $kelurahans = Kelurahan::where('kecamatan_id', $kecamatanId)->get(['id', 'nama_kelurahan']);
            return response()->json($kelurahans);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil kelurahan untuk kecamatan_id: ' . $kecamatanId, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Gagal memuat data kelurahan.'], 500);
        }
    }
}