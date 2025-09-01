<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\StuntingController;
use App\Http\Controllers\IbuHamilController;
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
        Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index');
        Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
        Route::post('/balita', [BalitaController::class, 'store'])->name('balita.store');
        Route::get('/balita/{id}/edit', [BalitaController::class, 'edit'])->name('balita.edit');
        Route::put('/balita/{id}', [BalitaController::class, 'update'])->name('balita.update');
        Route::delete('/balita/{id}', [BalitaController::class, 'destroy'])->name('balita.destroy');
        Route::get('/stunting', [StuntingController::class, 'index'])->name('stunting.index');
        Route::get('/stunting/create', [StuntingController::class, 'create'])->name('stunting.create');
        Route::post('/stunting', [StuntingController::class, 'store'])->name('stunting.store');
        Route::get('/stunting/{id}/edit', [StuntingController::class, 'edit'])->name('stunting.edit');
        Route::put('/stunting/{id}', [StuntingController::class, 'update'])->name('stunting.update');
        Route::delete('/stunting/{id}', [StuntingController::class, 'destroy'])->name('stunting.destroy');
        Route::get('/ibu-hamil', [IbuHamilController::class, 'index'])->name('ibu_hamil.index');
        Route::get('/ibu-hamil/create', [IbuHamilController::class, 'create'])->name('ibu_hamil.create');
        Route::post('/ibu-hamil', [IbuHamilController::class, 'store'])->name('ibu_hamil.store');
        Route::get('/ibu-hamil/{id}/edit', [IbuHamilController::class, 'edit'])->name('ibu_hamil.edit');
        Route::put('/ibu-hamil/{id}', [IbuHamilController::class, 'update'])->name('ibu_hamil.update');
        Route::delete('/ibu-hamil/{id}', [IbuHamilController::class, 'destroy'])->name('ibu_hamil.destroy');
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