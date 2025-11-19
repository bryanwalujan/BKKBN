<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function manualBackup(Request $request)
    {
        try {
            Log::info('Memulai backup manual dengan Spatie');

            // Jalankan backup command dengan notifikasi dinonaktifkan
            Artisan::call('backup:run', [
                '--only-db' => true,
                '--disable-notifications' => true
            ]);
            
            $output = Artisan::output();
            Log::info('Output Artisan backup: ' . $output);

            // Tunggu sebentar untuk memastikan file tersimpan
            sleep(3);

            // Cari file backup terbaru
            $latestBackup = $this->findLatestBackup();

            if ($latestBackup) {
                Log::info('File backup ditemukan: ' . $latestBackup['path']);
                $fileSize = Storage::disk('private')->size($latestBackup['path']);
                Log::info('Ukuran file backup: ' . $fileSize . ' bytes');
                
                if ($fileSize > 0) {
                    return Storage::disk('private')->download($latestBackup['path'], 'backup-spatie-' . date('Y-m-d-H-i-s') . '.zip');
                } else {
                    Log::warning('File backup kosong');
                    return redirect()->route('dashboard')->with('error', 'File backup kosong. Coba metode backup lainnya.');
                }
            }

            Log::warning('File backup tidak ditemukan');
            return redirect()->route('dashboard')->with('error', 'File backup tidak ditemukan. Silakan coba metode backup lainnya.');
            
        } catch (\Exception $e) {
            Log::error('Backup manual gagal: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function directBackup(Request $request)
    {
        try {
            Log::info('Memulai backup langsung menggunakan mysqldump');

            $dbConfig = config('database.connections.' . config('database.default'));
            
            // Buat nama file dengan timestamp
            $filename = 'backup-direct-' . date('Y-m-d-H-i-s') . '.sql';
            $filePath = storage_path('app/private/backups/' . $filename);
            
            // Pastikan direktori ada
            $backupDir = storage_path('app/private/backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Perintah mysqldump
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s --port=%s --single-transaction --routines --triggers %s > %s',
                $dbConfig['username'],
                $dbConfig['password'],
                $dbConfig['host'],
                $dbConfig['port'] ?? 3306,
                $dbConfig['database'],
                $filePath
            );

            // Eksekusi perintah
            $process = Process::fromShellCommandline($command);
            $process->setTimeout(300); // 5 menit timeout
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Periksa apakah file berhasil dibuat dan tidak kosong
            if (file_exists($filePath) && filesize($filePath) > 0) {
                Log::info('Backup langsung berhasil: ' . $filename . ' (' . filesize($filePath) . ' bytes)');
                return response()->download($filePath, $filename)->deleteFileAfterSend(false);
            } else {
                Log::error('File backup kosong atau tidak dibuat');
                return redirect()->route('dashboard')->with('error', 'Backup gagal: file tidak dibuat atau kosong.');
            }

        } catch (\Exception $e) {
            Log::error('Backup langsung gagal: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Backup langsung gagal: ' . $e->getMessage());
        }
    }

    public function laravelBackup(Request $request)
    {
        try {
            Log::info('Memulai backup menggunakan Laravel native');

            $dbConfig = config('database.connections.' . config('database.default'));
            
            // Buat nama file dengan timestamp
            $filename = 'backup-laravel-' . date('Y-m-d-H-i-s') . '.sql';
            $filePath = storage_path('app/private/backups/' . $filename);
            
            // Pastikan direktori ada
            $backupDir = storage_path('app/private/backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // Dapatkan semua tabel
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $dbConfig['database'];
            
            $sql = '';
            $sql .= "-- MySQL Database Backup\n";
            $sql .= "-- Generated on " . date('Y-m-d H:i:s') . "\n";
            $sql .= "-- Database: " . $dbConfig['database'] . "\n\n";
            $sql .= "SET foreign_key_checks = 0;\n\n";

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                
                // Dapatkan struktur tabel
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
                $sql .= "-- Structure for table `$tableName`\n";
                $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Dapatkan data tabel
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table `$tableName`\n";
                    foreach ($rows as $row) {
                        $values = array_map(function($value) {
                            return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                        }, (array)$row);
                        
                        $sql .= "INSERT INTO `$tableName` VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }
            
            $sql .= "SET foreign_key_checks = 1;\n";

            // Simpan ke file
            file_put_contents($filePath, $sql);

            if (file_exists($filePath) && filesize($filePath) > 0) {
                Log::info('Backup Laravel native berhasil: ' . $filename . ' (' . filesize($filePath) . ' bytes)');
                return response()->download($filePath, $filename)->deleteFileAfterSend(false);
            } else {
                Log::error('File backup Laravel native kosong atau tidak dibuat');
                return redirect()->route('dashboard')->with('error', 'Backup gagal: file tidak dibuat atau kosong.');
            }

        } catch (\Exception $e) {
            Log::error('Backup Laravel native gagal: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Backup Laravel native gagal: ' . $e->getMessage());
        }
    }

    public function listBackups()
    {
        try {
            $privateFiles = Storage::disk('private')->files('backups');
            
            $backupFiles = collect($privateFiles)
                ->filter(function ($file) {
                    return str_ends_with($file, '.sql') || str_ends_with($file, '.zip');
                })
                ->map(function ($file) {
                    $size = Storage::disk('private')->size($file);
                    return [
                        'name' => basename($file),
                        'path' => $file,
                        'size' => $this->formatBytes($size),
                        'size_bytes' => $size,
                        'date' => Carbon::createFromTimestamp(Storage::disk('private')->lastModified($file))->format('Y-m-d H:i:s'),
                        'timestamp' => Storage::disk('private')->lastModified($file)
                    ];
                })
                ->sortByDesc('timestamp')
                ->values();

            return response()->json($backupFiles);
            
        } catch (\Exception $e) {
            Log::error('Gagal mengambil daftar backup: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil daftar backup'], 500);
        }
    }

    public function debugInfo()
    {
        try {
            $info = [
                'timestamp' => date('Y-m-d H:i:s'),
                'database_config' => [
                    'connection' => config('database.default'),
                    'host' => config('database.connections.' . config('database.default') . '.host'),
                    'port' => config('database.connections.' . config('database.default') . '.port'),
                    'database' => config('database.connections.' . config('database.default') . '.database'),
                    'username' => config('database.connections.' . config('database.default') . '.username'),
                    'password_set' => !empty(config('database.connections.' . config('database.default') . '.password'))
                ],
                'storage_paths' => [
                    'storage_path' => storage_path(),
                    'backup_temp' => config('backup.backup.temporary_directory'),
                    'private_disk_root' => Storage::disk('private')->path(''),
                    'backup_directory' => Storage::disk('private')->path('backups')
                ],
                'directories_exist' => [
                    'storage_app' => is_dir(storage_path('app')),
                    'storage_private' => is_dir(storage_path('app/private')),
                    'backup_directory' => is_dir(Storage::disk('private')->path('backups')),
                    'backup_temp' => is_dir(config('backup.backup.temporary_directory'))
                ],
                'directories_writable' => [
                    'storage_app' => is_writable(storage_path('app')),
                    'storage_private' => is_writable(storage_path('app/private')),
                ],
                'backup_config' => [
                    'destination_disks' => config('backup.backup.destination.disks'),
                    'filename_prefix' => config('backup.backup.destination.filename_prefix'),
                    'database_connection' => config('backup.backup.source.databases')[0] ?? null,
                ],
                'recent_files' => []
            ];

            // Cek file terbaru di direktori backup
            if (Storage::disk('private')->exists('backups')) {
                $files = Storage::disk('private')->files('backups');
                foreach ($files as $file) {
                    $info['recent_files'][] = [
                        'file' => $file,
                        'size' => Storage::disk('private')->size($file),
                        'modified' => date('Y-m-d H:i:s', Storage::disk('private')->lastModified($file))
                    ];
                }
            }

            // Test database connection
            try {
                DB::connection()->getPdo();
                $info['database_connection_test'] = 'Success';
                
                // Get table count
                $tables = DB::select('SHOW TABLES');
                $info['database_tables_count'] = count($tables);
            } catch (\Exception $e) {
                $info['database_connection_test'] = 'Failed: ' . $e->getMessage();
            }

            return response()->json($info);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function debugHtml()
    {
        $debugData = $this->debugInfo()->getData();
        
        $html = '<!DOCTYPE html><html><head><title>Backup Debug Info</title><style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
            .success { color: green; }
            .error { color: red; }
            .warning { color: orange; }
            pre { background: #f5f5f5; padding: 10px; overflow: auto; }
        </style></head><body>';
        
        $html .= '<h1>Backup Debug Information</h1>';
        $html .= '<div class="section"><h2>Generated at: ' . date('Y-m-d H:i:s') . '</h2></div>';
        $html .= '<div class="section"><h2>Debug Data</h2><pre>' . json_encode($debugData, JSON_PRETTY_PRINT) . '</pre></div>';
        
        $html .= '</body></html>';
        
        return response($html)->header('Content-Type', 'text/html');
    }

    private function findLatestBackup()
    {
        try {
            // Cari di berbagai kemungkinan lokasi
            $possiblePaths = [
                'backups',
                '', // root private disk
                'Laravel'  // nama aplikasi
            ];

            $allFiles = [];
            
            foreach ($possiblePaths as $path) {
                try {
                    $files = Storage::disk('private')->files($path);
                    foreach ($files as $file) {
                        if (str_ends_with($file, '.zip') || str_ends_with($file, '.sql')) {
                            $allFiles[] = $file;
                        }
                    }
                } catch (\Exception $e) {
                    // Ignore errors for non-existent paths
                    continue;
                }
            }

            if (empty($allFiles)) {
                return null;
            }

            // Urutkan berdasarkan waktu modifikasi terbaru
            $sortedFiles = collect($allFiles)
                ->map(function ($file) {
                    return [
                        'path' => $file,
                        'modified' => Storage::disk('private')->lastModified($file),
                        'size' => Storage::disk('private')->size($file)
                    ];
                })
                ->sortByDesc('modified')
                ->first();

            return $sortedFiles;
        } catch (\Exception $e) {
            Log::error('Error finding latest backup: ' . $e->getMessage());
            return null;
        }
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
}