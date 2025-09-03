<?php
namespace App\Imports;

use App\Models\Balita;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BalitaImport implements ToModel, WithHeadingRow, SkipsOnError, WithBatchInserts
{
    use SkipsErrors;

    protected $errors = [];
    protected $successCount = 0;
    protected $rowNumber = 0;

    public function model(array $row)
    {
        $this->rowNumber++;
        Log::info("Memproses baris {$this->rowNumber}: " . json_encode($row));

        try {
            // Validasi minimal: nama harus ada
            if (!isset($row['nama']) || empty(trim($row['nama']))) {
                $this->errors[] = "Baris {$this->rowNumber}: Nama kosong atau tidak valid.";
                return null;
            }

            // Validasi NIK (opsional, unik jika ada)
            $nik = isset($row['nik']) ? trim($row['nik']) : null;
            if ($nik && Balita::where('nik', $nik)->exists()) {
                $this->errors[] = "Baris {$this->rowNumber}: NIK {$nik} sudah ada di database.";
                return null;
            }

            // Validasi tanggal lahir (opsional, menangani serial date Excel dan format tekstual)
            $tanggal_lahir = null;
            if (isset($row['tgl_lahir']) && !empty(trim($row['tgl_lahir']))) {
                $input = trim($row['tgl_lahir']);
                if (is_numeric($input) && $input > 1000) { // Deteksi serial date Excel
                    try {
                        $tanggal_lahir = Carbon::createFromFormat('Y-m-d', '1899-12-30')
                            ->addDays((int)$input)
                            ->toDateString();
                        Log::info("Baris {$this->rowNumber}: Serial date {$input} dikonversi ke {$tanggal_lahir}");
                    } catch (\Exception $e) {
                        $this->errors[] = "Baris {$this->rowNumber}: Format tanggal numerik tidak valid: {$input}";
                        return null;
                    }
                } else { // Coba parse sebagai tanggal tekstual
                    try {
                        $tanggal_lahir = Carbon::parse($input)->toDateString();
                        Log::info("Baris {$this->rowNumber}: Tanggal tekstual {$input} dikonversi ke {$tanggal_lahir}");
                    } catch (\Exception $e) {
                        $this->errors[] = "Baris {$this->rowNumber}: Format tanggal tidak valid: {$input}";
                        return null;
                    }
                }
            }

            // Validasi jenis kelamin (opsional)
            $jenis_kelamin = isset($row['jk']) ? trim($row['jk']) : null;
            if ($jenis_kelamin && !in_array($jenis_kelamin, ['L', 'P'])) {
                $this->errors[] = "Baris {$this->rowNumber}: Jenis kelamin tidak valid: {$jenis_kelamin} (harus L atau P)";
                return null;
            }
            $jenis_kelamin = $jenis_kelamin === 'L' ? 'Laki-laki' : ($jenis_kelamin === 'P' ? 'Perempuan' : null);

            $balita = new Balita([
                'nik' => $nik,
                'nama' => trim($row['nama']),
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $jenis_kelamin,
                'berat_tinggi' => '0/0',
                'kecamatan' => isset($row['kec']) ? trim($row['kec']) : null,
                'kelurahan' => isset($row['desakel']) ? trim($row['desakel']) : null,
                'alamat' => isset($row['alamat']) ? trim($row['alamat']) : null,
                'status_gizi' => 'Sehat',
                'warna_label' => 'Sehat',
                'status_pemantauan' => null,
                'foto' => null,
            ]);

            Log::info("Baris {$this->rowNumber}: Data balita akan disimpan: " . json_encode($balita->toArray()));
            $this->successCount++;
            return $balita;
        } catch (\Exception $e) {
            $this->errors[] = "Baris {$this->rowNumber}: Error: {$e->getMessage()}";
            Log::error("Baris {$this->rowNumber}: Error saat mengimpor: {$e->getMessage()}");
            return null;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function batchSize(): int
    {
        return 100; // Proses 100 baris per batch
    }
}