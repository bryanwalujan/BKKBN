<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/download-template', [AuthController::class, 'downloadTemplate'])->name('download.template');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::middleware('role:master')->group(function () {
        Route::get('/verifikasi-akun', [VerificationController::class, 'index'])->name('verifikasi.index');
        Route::post('/verifikasi-akun/{id}/approve', [VerificationController::class, 'approve'])->name('verifikasi.approve');
        Route::post('/verifikasi-akun/{id}/reject', [VerificationController::class, 'reject'])->name('verifikasi.reject');
        Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
        Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
        Route::delete('/templates/{id}', [TemplateController::class, 'destroy'])->name('templates.destroy');
    });
    Route::middleware('role:admin_kelurahan')->group(function () {
        Route::get('/admin-kelurahan/dashboard', function () {
            return view('admin_kelurahan.dashboard');
        })->name('admin_kelurahan.dashboard');
    });
    Route::middleware('role:perangkat_desa')->group(function () {
        Route::get('/perangkat-desa/dashboard', function () {
            return view('perangkat_desa.dashboard');
        })->name('perangkat_desa.dashboard');
    });
});