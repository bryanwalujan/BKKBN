<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\StuntingController;
use App\Http\Controllers\IbuHamilController;
use App\Http\Controllers\IbuNifasController;
use App\Http\Controllers\IbuMenyusuiController;
use App\Http\Controllers\GentingController;
use App\Http\Controllers\AksiKonvergensiController;
use App\Http\Controllers\PetaGeospasialController;
use App\Http\Controllers\PendampingKeluargaController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\DataRisetController;
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\LayananKamiController;
use App\Http\Controllers\GaleriProgramController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\DataMonitoringController;
use App\Http\Controllers\DataPendudukController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\IbuController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AuditStuntingController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\BayiBaruLahirController;
use App\Http\Controllers\CatinController;
use App\Http\Controllers\LandingController;

// Kelurahan Controllers
use App\Http\Controllers\KelurahanBalitaController;
use App\Http\Controllers\KelurahanKartuKeluargaController;
use App\Http\Controllers\KelurahanIbuController;
use App\Http\Controllers\KelurahanIbuHamilController;
use App\Http\Controllers\KelurahanIbuNifasController;
use App\Http\Controllers\KelurahanIbuMenyusuiController;
use App\Http\Controllers\KelurahanStuntingController;
use App\Http\Controllers\KelurahanBayiBaruLahirController;
use App\Http\Controllers\KelurahanCatinController;


// Perangkat Daerah Controllers
use App\Http\Controllers\PerangkatDaerahGentingController;
use App\Http\Controllers\PerangkatDaerahAksiKonvergensiController;
use App\Http\Controllers\PerangkatDaerahPendampingKeluargaController;
use App\Http\Controllers\PerangkatDaerahDataMonitoringController;
use App\Http\Controllers\PerangkatDaerahAuditStuntingController;
use App\Http\Controllers\PerangkatDaerahKartuKeluargaController;
use App\Http\Controllers\PerangkatDaerahPetaGeospasialController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\DataRiset;
use App\Models\PendingUser;

/*
|--------------------------------------------------------------------------
| Guest Routes (Tanpa Authentication)
|--------------------------------------------------------------------------
*/

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::get('/landing/data', [LandingController::class, 'data'])->name('landing.data');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('register.post');

// Public API Routes
Route::get('/download-template', [AuthController::class, 'downloadTemplate'])->name('download.template');
Route::get('/kelurahans/by-kecamatan/{kecamatan_id}', [KelurahanController::class, 'getByKecamatan'])->name('kelurahans.by-kecamatan');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Dashboard & Logout
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Kartu Keluarga API for all authenticated users with appropriate roles
    Route::get('/kartu-keluarga/by-kecamatan-kelurahan', [KartuKeluargaController::class, 'getByKecamatanKelurahan'])
        ->middleware('role:master,admin_kelurahan,admin_kecamatan,perangkat_daerah')
        ->name('kartu_keluarga.by-kecamatan-kelurahan');
    Route::get('/kartu-keluarga/{kartu_keluarga_id}/ibu-balita', [KartuKeluargaController::class, 'getIbuAndBalita'])
        ->middleware('role:master,admin_kelurahan,admin_kecamatan,perangkat_daerah')
        ->name('kartu_keluarga.get-ibu-balita');

    /*
    |--------------------------------------------------------------------------
    | Master Role Routes
    |--------------------------------------------------------------------------
    */
    
    Route::middleware('role:master')->group(function () {

        Route::get('/dashboard', function () {
    $dataRisets = DataRiset::all();
    $pendingCount = PendingUser::where('status', 'pending')->count();
    return view('master.dashboard', compact('dataRisets', 'pendingCount'));
})->name('dashboard');
        
        // User Verification
        Route::prefix('verifikasi-akun')->name('verifikasi.')->group(function () {
            Route::get('/', [VerificationController::class, 'index'])->name('index');
            Route::post('/{id}/approve', [VerificationController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [VerificationController::class, 'reject'])->name('reject');
        });

        // Template Management
        Route::prefix('templates')->name('templates.')->group(function () {
            Route::get('/', [TemplateController::class, 'index'])->name('index');
            Route::post('/', [TemplateController::class, 'store'])->name('store');
            Route::delete('/{id}', [TemplateController::class, 'destroy'])->name('destroy');
        });

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Backup Management
        Route::prefix('backup')->name('backup.')->group(function () {
            Route::post('/manual', [BackupController::class, 'manualBackup'])->name('manual');
            Route::post('/direct', [BackupController::class, 'directBackup'])->name('direct');
            Route::post('/laravel', [BackupController::class, 'laravelBackup'])->name('laravel');
            Route::get('/list', [BackupController::class, 'listBackups'])->name('list');
            Route::get('/debug', [BackupController::class, 'debugInfo'])->name('debug');
            Route::get('/debug/html', [BackupController::class, 'debugHtml'])->name('debug.html');
        });

        /*
        |--------------------------------------------------------------------------
        | Data Management Routes (Master)
        |--------------------------------------------------------------------------
        */
        
        // Kartu Keluarga (Base for other modules)
        Route::prefix('kartu-keluarga')->name('kartu_keluarga.')->group(function () {
            Route::get('/', [KartuKeluargaController::class, 'index'])->name('index');
            Route::get('/create', [KartuKeluargaController::class, 'create'])->name('create');
            Route::post('/', [KartuKeluargaController::class, 'store'])->name('store');
            Route::get('/{id}', [KartuKeluargaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [KartuKeluargaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KartuKeluargaController::class, 'update'])->name('update');
            Route::delete('/{id}', [KartuKeluargaController::class, 'destroy'])->name('destroy');
        });

         // Catin
        Route::prefix('catin')->name('catin.')->group(function () {
            Route::get('/', [CatinController::class, 'index'])->name('index');
            Route::get('/create', [CatinController::class, 'create'])->name('create');
            Route::post('/', [CatinController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CatinController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CatinController::class, 'update'])->name('update');
            Route::delete('/{id}', [CatinController::class, 'destroy'])->name('destroy');
        });

        // Bayi
        Route::prefix('bayi-baru-lahir')->name('bayi_baru_lahir.')->group(function () {
            Route::get('/', [BayiBaruLahirController::class, 'index'])->name('index');
            Route::get('/create', [BayiBaruLahirController::class, 'create'])->name('create');
            Route::post('/', [BayiBaruLahirController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [BayiBaruLahirController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BayiBaruLahirController::class, 'update'])->name('update');
            Route::delete('/{id}', [BayiBaruLahirController::class, 'destroy'])->name('destroy');
        });

        // Bayi masuk balita
        Route::post('bayi_baru_lahir/{id}/move-to-balita', [BayiBaruLahirController::class, 'moveToBalita'])->name('bayi_baru_lahir.moveToBalita');

        // Balita
        Route::prefix('balita')->name('balita.')->group(function () {
            Route::get('/', [BalitaController::class, 'index'])->name('index');
            Route::get('/create', [BalitaController::class, 'create'])->name('create');
            Route::post('/', [BalitaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [BalitaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [BalitaController::class, 'update'])->name('update');
            Route::delete('/{id}', [BalitaController::class, 'destroy'])->name('destroy');
            Route::post('/import', [BalitaController::class, 'import'])->name('import');
            Route::get('/download-template', [BalitaController::class, 'downloadTemplate'])->name('downloadTemplate');
        });

        // Stunting
        Route::prefix('stunting')->name('stunting.')->group(function () {
            Route::get('/', [StuntingController::class, 'index'])->name('index');
            Route::get('/create', [StuntingController::class, 'create'])->name('create');
            Route::post('/', [StuntingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [StuntingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [StuntingController::class, 'update'])->name('update');
            Route::delete('/{id}', [StuntingController::class, 'destroy'])->name('destroy');
        });

        // Ibu
        Route::prefix('ibu')->name('ibu.')->group(function () {
            Route::get('/', [IbuController::class, 'index'])->name('index');
            Route::get('/create', [IbuController::class, 'create'])->name('create');
            Route::post('/', [IbuController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [IbuController::class, 'edit'])->name('edit');
            Route::put('/{id}', [IbuController::class, 'update'])->name('update');
            Route::delete('/{id}', [IbuController::class, 'destroy'])->name('destroy');
        });

        // Ibu Hamil
        Route::prefix('ibu-hamil')->name('ibu_hamil.')->group(function () {
            Route::get('/', [IbuHamilController::class, 'index'])->name('index');
            Route::get('/create', [IbuHamilController::class, 'create'])->name('create');
            Route::post('/', [IbuHamilController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [IbuHamilController::class, 'edit'])->name('edit');
            Route::put('/{id}', [IbuHamilController::class, 'update'])->name('update');
            Route::delete('/{id}', [IbuHamilController::class, 'destroy'])->name('destroy');
        });

        // Ibu Nifas
        Route::prefix('ibu-nifas')->name('ibu_nifas.')->group(function () {
            Route::get('/', [IbuNifasController::class, 'index'])->name('index');
            Route::get('/create', [IbuNifasController::class, 'create'])->name('create');
            Route::post('/', [IbuNifasController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [IbuNifasController::class, 'edit'])->name('edit');
            Route::put('/{id}', [IbuNifasController::class, 'update'])->name('update');
            Route::delete('/{id}', [IbuNifasController::class, 'destroy'])->name('destroy');
        });

        // Ibu Menyusui
        Route::prefix('ibu-menyusui')->name('ibu_menyusui.')->group(function () {
            Route::get('/', [IbuMenyusuiController::class, 'index'])->name('index');
            Route::get('/create', [IbuMenyusuiController::class, 'create'])->name('create');
            Route::post('/', [IbuMenyusuiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [IbuMenyusuiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [IbuMenyusuiController::class, 'update'])->name('update');
            Route::delete('/{id}', [IbuMenyusuiController::class, 'destroy'])->name('destroy');
        });

        // Genting
        Route::prefix('genting')->name('genting.')->group(function () {
            Route::get('/', [GentingController::class, 'index'])->name('index');
            Route::get('/create', [GentingController::class, 'create'])->name('create');
            Route::post('/', [GentingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GentingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [GentingController::class, 'update'])->name('update');
            Route::delete('/{id}', [GentingController::class, 'destroy'])->name('destroy');
        });

        // Aksi Konvergensi
        Route::prefix('aksi-konvergensi')->name('aksi_konvergensi.')->group(function () {
            Route::get('/', [AksiKonvergensiController::class, 'index'])->name('index');
            Route::get('/create', [AksiKonvergensiController::class, 'create'])->name('create');
            Route::post('/', [AksiKonvergensiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AksiKonvergensiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AksiKonvergensiController::class, 'update'])->name('update');
            Route::delete('/{id}', [AksiKonvergensiController::class, 'destroy'])->name('destroy');
            Route::get('/kartu-keluarga/{kartu_keluarga_id}', [AksiKonvergensiController::class, 'showByKK'])->name('show_by_kk');
        });

        // Peta Geospasial
        Route::prefix('peta-geospasial')->name('peta_geospasial.')->group(function () {
            Route::get('/', [PetaGeospasialController::class, 'index'])->name('index');
            Route::get('/create', [PetaGeospasialController::class, 'create'])->name('create');
            Route::post('/', [PetaGeospasialController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PetaGeospasialController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PetaGeospasialController::class, 'update'])->name('update');
            Route::delete('/{id}', [PetaGeospasialController::class, 'destroy'])->name('destroy');
        });

        // Pendamping Keluarga
        Route::prefix('pendamping-keluarga')->name('pendamping_keluarga.')->group(function () {
            Route::get('/', [PendampingKeluargaController::class, 'index'])->name('index');
            Route::get('/create', [PendampingKeluargaController::class, 'create'])->name('create');
            Route::post('/', [PendampingKeluargaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PendampingKeluargaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PendampingKeluargaController::class, 'update'])->name('update');
            Route::delete('/{id}', [PendampingKeluargaController::class, 'destroy'])->name('destroy');
            Route::post('/{pendamping}/laporan', [PendampingKeluargaController::class, 'storeLaporan'])->name('storeLaporan');
            Route::get('/by-kecamatan-kelurahan', [PendampingKeluargaController::class, 'getByKecamatanKelurahan'])->name('by-kecamatan-kelurahan');
            Route::get('/kelurahans/{kecamatan_id}', [PendampingKeluargaController::class, 'getKelurahans'])->name('kelurahans');
        });

        // Audit Stunting
        Route::prefix('audit-stunting')->name('audit_stunting.')->group(function () {
            Route::get('/', [AuditStuntingController::class, 'index'])->name('index');
            Route::get('/create', [AuditStuntingController::class, 'create'])->name('create');
            Route::post('/', [AuditStuntingController::class, 'store'])->name('store');
            Route::get('/{id}', [AuditStuntingController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AuditStuntingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AuditStuntingController::class, 'update'])->name('update');
            Route::delete('/{id}', [AuditStuntingController::class, 'destroy'])->name('destroy');
        });

        // Edukasi
        Route::prefix('edukasi')->name('edukasi.')->group(function () {
            Route::get('/', [EdukasiController::class, 'index'])->name('index');
            Route::get('/create', [EdukasiController::class, 'create'])->name('create');
            Route::post('/', [EdukasiController::class, 'store'])->name('store');
            Route::get('/{id}', [EdukasiController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [EdukasiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EdukasiController::class, 'update'])->name('update');
            Route::delete('/{id}', [EdukasiController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | CMS Routes (Master)
        |--------------------------------------------------------------------------
        */

        // Carousel
        Route::prefix('carousel')->name('carousel.')->group(function () {
            Route::get('/', [CarouselController::class, 'index'])->name('index');
            Route::get('/create', [CarouselController::class, 'create'])->name('create');
            Route::post('/', [CarouselController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CarouselController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CarouselController::class, 'update'])->name('update');
            Route::delete('/{id}', [CarouselController::class, 'destroy'])->name('destroy');
        });

        // Data Riset
        Route::prefix('data-riset')->name('data_riset.')->group(function () {
            Route::get('/', [DataRisetController::class, 'index'])->name('index');
            Route::get('/create', [DataRisetController::class, 'create'])->name('create');
            Route::post('/', [DataRisetController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataRisetController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DataRisetController::class, 'update'])->name('update');
            Route::delete('/{id}', [DataRisetController::class, 'destroy'])->name('destroy');
            Route::post('/refresh', [DataRisetController::class, 'refresh'])->name('refresh');
        });

        // Tentang Kami
        Route::prefix('tentang-kami')->name('tentang_kami.')->group(function () {
            Route::get('/', [TentangKamiController::class, 'index'])->name('index');
            Route::get('/create', [TentangKamiController::class, 'create'])->name('create');
            Route::post('/', [TentangKamiController::class, 'store'])->name('store');
            Route::get('/edit', [TentangKamiController::class, 'edit'])->name('edit');
            Route::put('/', [TentangKamiController::class, 'update'])->name('update');
        });

        // Layanan Kami
        Route::prefix('layanan-kami')->name('layanan_kami.')->group(function () {
            Route::get('/', [LayananKamiController::class, 'index'])->name('index');
            Route::get('/create', [LayananKamiController::class, 'create'])->name('create');
            Route::post('/', [LayananKamiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [LayananKamiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LayananKamiController::class, 'update'])->name('update');
            Route::delete('/{id}', [LayananKamiController::class, 'destroy'])->name('destroy');
            Route::post('/refresh', [LayananKamiController::class, 'refresh'])->name('refresh');
        });

        // Galeri Program
        Route::prefix('galeri-program')->name('galeri_program.')->group(function () {
            Route::get('/', [GaleriProgramController::class, 'index'])->name('index');
            Route::get('/create', [GaleriProgramController::class, 'create'])->name('create');
            Route::post('/', [GaleriProgramController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GaleriProgramController::class, 'edit'])->name('edit');
            Route::put('/{id}', [GaleriProgramController::class, 'update'])->name('update');
            Route::delete('/{id}', [GaleriProgramController::class, 'destroy'])->name('destroy');
            Route::post('/refresh', [GaleriProgramController::class, 'refresh'])->name('refresh');
        });

        // Publikasi
        Route::prefix('publikasi')->name('publikasi.')->group(function () {
            Route::get('/', [PublikasiController::class, 'index'])->name('index');
            Route::get('/create', [PublikasiController::class, 'create'])->name('create');
            Route::post('/', [PublikasiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PublikasiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PublikasiController::class, 'update'])->name('update');
            Route::delete('/{id}', [PublikasiController::class, 'destroy'])->name('destroy');
            Route::post('/refresh', [PublikasiController::class, 'refresh'])->name('refresh');
        });

        // Referensi
        Route::prefix('referensi')->name('referensi.')->group(function () {
            Route::get('/', [ReferensiController::class, 'index'])->name('index');
            Route::get('/create', [ReferensiController::class, 'create'])->name('create');
            Route::post('/', [ReferensiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ReferensiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ReferensiController::class, 'update'])->name('update');
            Route::delete('/{id}', [ReferensiController::class, 'destroy'])->name('destroy');
            Route::post('/refresh', [ReferensiController::class, 'refresh'])->name('refresh');
        });

        // Data Monitoring
        Route::prefix('data-monitoring')->name('data_monitoring.')->group(function () {
            Route::get('/', [DataMonitoringController::class, 'index'])->name('index');
            Route::get('/create', [DataMonitoringController::class, 'create'])->name('create');
            Route::post('/', [DataMonitoringController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataMonitoringController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DataMonitoringController::class, 'update'])->name('update');
            Route::delete('/{id}', [DataMonitoringController::class, 'destroy'])->name('destroy');
            Route::post('/refresh', [DataMonitoringController::class, 'refresh'])->name('refresh');
        });

        // Data Penduduk
        Route::prefix('data-penduduk')->name('data_penduduk.')->group(function () {
            Route::get('/', [DataPendudukController::class, 'index'])->name('index');
            Route::get('/create', [DataPendudukController::class, 'create'])->name('create');
            Route::post('/', [DataPendudukController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DataPendudukController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DataPendudukController::class, 'update'])->name('update');
            Route::delete('/{id}', [DataPendudukController::class, 'destroy'])->name('destroy');
            Route::post('/refresh', [DataPendudukController::class, 'refresh'])->name('refresh');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Kelurahan Routes
    |--------------------------------------------------------------------------
    */
    
    Route::prefix('kelurahan')->middleware('role:admin_kelurahan')->name('kelurahan.')->group(function () {
        
        // Peta Geospasial untuk Kelurahan
        Route::get('/peta-geospasial', function (Request $request) {
            $user = Auth::user();
            if (!$user->kelurahan_id) {
                return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
            }
            $modifiedRequest = $request->duplicate(
                array_merge($request->query(), ['kelurahan_id' => $user->kelurahan_id])
            );
            return app(PetaGeospasialController::class)->index($modifiedRequest, 'kelurahan.peta_geospasial.index');
        })->name('peta_geospasial.index');

        // Kartu Keluarga
        Route::prefix('kartu-keluarga')->name('kartu_keluarga.')->group(function () {
            Route::get('/', [KelurahanKartuKeluargaController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanKartuKeluargaController::class, 'create'])->name('create');
            Route::post('/', [KelurahanKartuKeluargaController::class, 'store'])->name('store');
            Route::get('/{id}', [KelurahanKartuKeluargaController::class, 'show'])->where('id', '[0-9]+')->name('show');
            Route::get('/{id}/edit', [KelurahanKartuKeluargaController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [KelurahanKartuKeluargaController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [KelurahanKartuKeluargaController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/{source}', [KelurahanKartuKeluargaController::class, 'show'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('show.source');
            Route::get('/{id}/edit/{source}', [KelurahanKartuKeluargaController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [KelurahanKartuKeluargaController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
        });

        // Balita
        Route::prefix('balita')->name('balita.')->group(function () {
            Route::get('/', [KelurahanBalitaController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanBalitaController::class, 'create'])->name('create');
            Route::post('/', [KelurahanBalitaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanBalitaController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [KelurahanBalitaController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [KelurahanBalitaController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [KelurahanBalitaController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [KelurahanBalitaController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
            Route::get('/kartu-keluarga', [KelurahanBalitaController::class, 'getKartuKeluarga'])->name('getKartuKeluarga');
        });

        // Ibu
        Route::prefix('ibu')->name('ibu.')->group(function () {
            Route::get('/', [KelurahanIbuController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanIbuController::class, 'create'])->name('create');
            Route::post('/', [KelurahanIbuController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanIbuController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [KelurahanIbuController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [KelurahanIbuController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [KelurahanIbuController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [KelurahanIbuController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
            Route::get('/get-kartu-keluarga', [KelurahanIbuController::class, 'getKartuKeluarga'])->name('getKartuKeluarga');
        });

        // Ibu Hamil
        Route::prefix('ibu-hamil')->name('ibu_hamil.')->group(function () {
            Route::get('/', [KelurahanIbuHamilController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanIbuHamilController::class, 'create'])->name('create');
            Route::post('/', [KelurahanIbuHamilController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanIbuHamilController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [KelurahanIbuHamilController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [KelurahanIbuHamilController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [KelurahanIbuHamilController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [KelurahanIbuHamilController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
        });

        // Ibu Nifas
        Route::prefix('ibu-nifas')->name('ibu_nifas.')->group(function () {
            Route::get('/', [KelurahanIbuNifasController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanIbuNifasController::class, 'create'])->name('create');
            Route::post('/', [KelurahanIbuNifasController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanIbuNifasController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [KelurahanIbuNifasController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [KelurahanIbuNifasController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [KelurahanIbuNifasController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [KelurahanIbuNifasController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
        });

        // Ibu Menyusui
        Route::prefix('ibu-menyusui')->name('ibu_menyusui.')->group(function () {
            Route::get('/', [KelurahanIbuMenyusuiController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanIbuMenyusuiController::class, 'create'])->name('create');
            Route::post('/', [KelurahanIbuMenyusuiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanIbuMenyusuiController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [KelurahanIbuMenyusuiController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [KelurahanIbuMenyusuiController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [KelurahanIbuMenyusuiController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [KelurahanIbuMenyusuiController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
        });

        // Stunting
        Route::prefix('stunting')->name('stunting.')->group(function () {
            Route::get('/', [KelurahanStuntingController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanStuntingController::class, 'create'])->name('create');
            Route::post('/', [KelurahanStuntingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanStuntingController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [KelurahanStuntingController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [KelurahanStuntingController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [KelurahanStuntingController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [KelurahanStuntingController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
        });

        //Bayi Baru Lahir
       Route::prefix('bayi-baru-lahir')->name('bayi_baru_lahir.')->group(function () {
            Route::get('/', [KelurahanBayiBaruLahirController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanBayiBaruLahirController::class, 'create'])->name('create');
            Route::post('/', [KelurahanBayiBaruLahirController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanBayiBaruLahirController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KelurahanBayiBaruLahirController::class, 'update'])->name('update');
            Route::delete('/{id}', [KelurahanBayiBaruLahirController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/move-to-balita', [KelurahanBayiBaruLahirController::class, 'moveToBalita'])->name('moveToBalita');
        });
        
         // Bayi masuk balita
        Route::post('bayi_baru_lahir/{id}/move-to-balita', [KelurahanBayiBaruLahirController::class, 'moveToBalita'])->name('bayi_baru_lahir.moveToBalita');

        //Catin
        Route::prefix('catin')->name('catin.')->group(function () {
            Route::get('/', [KelurahanCatinController::class, 'index'])->name('index');
            Route::get('/create', [KelurahanCatinController::class, 'create'])->name('create');
            Route::post('/', [KelurahanCatinController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelurahanCatinController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KelurahanCatinController::class, 'update'])->name('update');
            Route::delete('/{id}', [KelurahanCatinController::class, 'destroy'])->name('destroy');
    });
    });

    

    /*
    |--------------------------------------------------------------------------
    | Perangkat Daerah Routes
    |--------------------------------------------------------------------------
    */
    
    Route::prefix('perangkat-daerah')->middleware('role:perangkat_daerah')->name('perangkat_daerah.')->group(function () {
        
        // Genting
        Route::prefix('genting')->name('genting.')->group(function () {
            Route::get('/', [PerangkatDaerahGentingController::class, 'index'])->name('index');
            Route::get('/create', [PerangkatDaerahGentingController::class, 'create'])->name('create');
            Route::post('/', [PerangkatDaerahGentingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PerangkatDaerahGentingController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [PerangkatDaerahGentingController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [PerangkatDaerahGentingController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [PerangkatDaerahGentingController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [PerangkatDaerahGentingController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
        });

        // Aksi Konvergensi
        Route::prefix('aksi-konvergensi')->name('aksi_konvergensi.')->group(function () {
            Route::get('/', [PerangkatDaerahAksiKonvergensiController::class, 'index'])->name('index');
            Route::get('/create', [PerangkatDaerahAksiKonvergensiController::class, 'create'])->name('create');
            Route::post('/', [PerangkatDaerahAksiKonvergensiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PerangkatDaerahAksiKonvergensiController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [PerangkatDaerahAksiKonvergensiController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [PerangkatDaerahAksiKonvergensiController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [PerangkatDaerahAksiKonvergensiController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [PerangkatDaerahAksiKonvergensiController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
            Route::get('/kelurahans/{kecamatanId}', [PerangkatDaerahAksiKonvergensiController::class, 'getKelurahansByKecamatan'])->name('getKelurahansByKecamatan');
            Route::get('/kartu-keluarga/{kelurahanId}', [PerangkatDaerahAksiKonvergensiController::class, 'getKartuKeluargaByKelurahan'])->name('getKartuKeluargaByKelurahan');
        });

        // Pendamping Keluarga
        Route::prefix('pendamping-keluarga')->name('pendamping_keluarga.')->group(function () {
            Route::get('/', [PerangkatDaerahPendampingKeluargaController::class, 'index'])->name('index');
            Route::get('/create', [PerangkatDaerahPendampingKeluargaController::class, 'create'])->name('create');
            Route::post('/', [PerangkatDaerahPendampingKeluargaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PerangkatDaerahPendampingKeluargaController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [PerangkatDaerahPendampingKeluargaController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [PerangkatDaerahPendampingKeluargaController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [PerangkatDaerahPendampingKeluargaController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [PerangkatDaerahPendampingKeluargaController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
            Route::get('/kelurahans/{kecamatan_id}', [PerangkatDaerahPendampingKeluargaController::class, 'getKelurahansByKecamatan'])->name('getKelurahansByKecamatan');
            Route::get('/kartu-keluarga/{kelurahan_id}', [PerangkatDaerahPendampingKeluargaController::class, 'getKartuKeluargaByKelurahan'])->name('getKartuKeluargaByKelurahan');
        });

        // Data Monitoring
        Route::prefix('data-monitoring')->name('data_monitoring.')->group(function () {
            Route::get('/', [PerangkatDaerahDataMonitoringController::class, 'index'])->name('index');
            Route::get('/create', [PerangkatDaerahDataMonitoringController::class, 'create'])->name('create');
            Route::post('/', [PerangkatDaerahDataMonitoringController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PerangkatDaerahDataMonitoringController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [PerangkatDaerahDataMonitoringController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [PerangkatDaerahDataMonitoringController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [PerangkatDaerahDataMonitoringController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [PerangkatDaerahDataMonitoringController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
            Route::get('/kelurahans/{kecamatan_id}', [PerangkatDaerahDataMonitoringController::class, 'getKelurahansByKecamatan'])->name('getKelurahansByKecamatan');
            Route::get('/kartu-keluarga/{kelurahan_id}', [PerangkatDaerahDataMonitoringController::class, 'getKartuKeluargaByKelurahan'])->name('getKartuKeluargaByKelurahan');
            Route::get('/ibu-balita/{kartu_keluarga_id}', [PerangkatDaerahDataMonitoringController::class, 'getIbuAndBalita'])->name('getIbuAndBalita');
        });

        // Audit Stunting
        Route::prefix('audit-stunting')->name('audit_stunting.')->group(function () {
            Route::get('/', [PerangkatDaerahAuditStuntingController::class, 'index'])->name('index');
            Route::get('/create', [PerangkatDaerahAuditStuntingController::class, 'create'])->name('create');
            Route::post('/', [PerangkatDaerahAuditStuntingController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PerangkatDaerahAuditStuntingController::class, 'edit'])->where('id', '[0-9]+')->name('edit');
            Route::put('/{id}', [PerangkatDaerahAuditStuntingController::class, 'update'])->where('id', '[0-9]+')->name('update');
            Route::delete('/{id}', [PerangkatDaerahAuditStuntingController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit/{source}', [PerangkatDaerahAuditStuntingController::class, 'edit'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('edit.source');
            Route::put('/{id}/{source}', [PerangkatDaerahAuditStuntingController::class, 'update'])->where(['id' => '[0-9]+', 'source' => '[a-zA-Z0-9_-]+'])->name('update.source');
            Route::get('/data-monitoring/{kecamatan_id}', [PerangkatDaerahAuditStuntingController::class, 'getDataMonitoringByKecamatan'])->name('getDataMonitoring');
            Route::get('/data-monitoring/{id}/kelurahan', [PerangkatDaerahAuditStuntingController::class, 'getKelurahanByDataMonitoring'])->name('getKelurahan');
        });

        // Kartu Keluarga (Read Only for Perangkat Daerah)
        Route::prefix('kartu-keluarga')->name('kartu_keluarga.')->group(function () {
            Route::get('/', [PerangkatDaerahKartuKeluargaController::class, 'index'])->name('index');
            Route::get('/{id}', [PerangkatDaerahKartuKeluargaController::class, 'show'])->name('show');
        });

        // Peta Geospasial (Read Only for Perangkat Daerah)
        Route::get('/peta-geospasial', [PerangkatDaerahPetaGeospasialController::class, 'index'])->name('peta_geospasial.index');
          Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});