<?php
namespace App\Imports;

use App\Models\Balita;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BalitaImport implements ToModel, WithHeadingRow, SkipsOnError, WithBatchInserts
{
    use SkipsErrors;

    protected $errors = [];
    protected $successCount = 0;
    protected $rowNumber = 0;

    // Pemetaan angka kata ke Romawi
    protected $numberToRoman = [
        'SATU' => 'I',
        'DUA' => 'II',
        'TIGA' => 'III',
        'EMPAT' => 'IV',
        'LIMA' => 'V',
        'ENAM' => 'VI',
        'TUJUH' => 'VII',
        'DELAPAN' => 'VIII',
        'SEMBILAN' => 'IX',
        'SEPULUH' => 'X',
    ];

    // Pemetaan Romawi ke angka kata
    protected $romanToNumber = [
        'I' => 'SATU',
        'II' => 'DUA',
        'III' => 'TIGA',
        'IV' => 'EMPAT',
        'V' => 'LIMA',
        'VI' => 'ENAM',
        'VII' => 'TUJUH',
        'VIII' => 'DELAPAN',
        'IX' => 'SEMBILAN',
        'X' => 'SEPULUH',
    ];

    /**
     * Normalisasi nama kelurahan untuk pencocokan
     */
    protected function normalizeKelurahanName($name)
    {
        if (!$name) {
            return null;
        }

        // Ubah ke huruf besar dan hapus spasi berlebih
        $name = trim(strtoupper($name));

        // Ganti angka kata dengan Romawi
        foreach ($this->numberToRoman as $word => $roman) {
            $name = str_replace(" $word", " $roman", $name);
            $name = str_replace("-$word", "-$roman", $name);
        }

        // Ganti angka numerik dengan Romawi (misalnya, "WOLOAN 1" menjadi "WOLOAN I")
        $name = preg_replace_callback('/\b(\d+)\b/', function ($matches) {
            $number = (int)$matches[1];
            if ($number >= 1 && $number <= 10) {
                return array_values($this->numberToRoman)[$number - 1] ?? $matches[1];
            }
            return $matches[1];
        }, $name);

        return $name;
    }

    /**
     * Cari kelurahan dengan nama yang dinormalisasi
     */
    protected function findKelurahan($kelurahanName, $kecamatanId)
    {
        if (!$kelurahanName || !$kecamatanId) {
            return null;
        }

        $normalizedName = $this->normalizeKelurahanName($kelurahanName);

        // Cari kelurahan dengan nama yang dinormalisasi
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatanId)
            ->where('nama_kelurahan', $normalizedName)
            ->first();

        // Jika tidak ditemukan, coba cari dengan nama asli
        if (!$kelurahan) {
            $kelurahan = Kelurahan::where('kecamatan_id', $kecamatanId)
                ->where('nama_kelurahan', trim(strtoupper($kelurahanName)))
                ->first();
        }

        // Jika masih tidak ditemukan, coba ganti Romawi dengan kata angka
        if (!$kelurahan) {
            $alternateName = $normalizedName;
            foreach ($this->romanToNumber as $roman => $word) {
                $alternateName = str_replace(" $roman", " $word", $alternateName);
                $alternateName = str_replace("-$roman", "-$word", $alternateName);
            }
            $kelurahan = Kelurahan::where('kecamatan_id', $kecamatanId)
                ->where('nama_kelurahan', $alternateName)
                ->first();
        }

        return $kelurahan;
    }

    public function model(array $row)
    {
        $this->rowNumber++;
        Log::info("Memproses baris {$this->rowNumber}: " . json_encode($row));

        try {
            // Validasi minimal: nama harus ada
            if (!isset($row['nama']) || empty(trim($row['nama']))) {
                $this->errors[] = "Baris {$this->rowNumber}: Nama kosong atau tidak valid.";
                Log::warning("Baris {$this->rowNumber}: Nama kosong atau tidak valid.");
                return null;
            }

            // Handle no_kk (boleh kosong)
            $kartu_keluarga_id = null;
            if (isset($row['no_kk']) && !empty(trim($row['no_kk']))) {
                // Bersihkan no_kk
                $no_kk = trim(Str::replace([' ', "\xc2\xa0"], '', $row['no_kk']));
                if (strlen($no_kk) > 16) {
                    $this->errors[] = "Baris {$this->rowNumber}: Nomor KK {$no_kk} melebihi 16 karakter.";
                    Log::warning("Baris {$this->rowNumber}: Nomor KK {$no_kk} melebihi 16 karakter.");
                    return null;
                }

                // Cari atau buat Kartu Keluarga
                $kartuKeluarga = KartuKeluarga::firstOrCreate(
                    ['no_kk' => $no_kk],
                    [
                        'kepala_keluarga' => isset($row['kepala_keluarga']) ? trim($row['kepala_keluarga']) : 'Tidak Diketahui',
                        'kecamatan' => isset($row['kec']) ? trim($row['kec']) : null,
                        'kelurahan' => isset($row['desakel']) ? trim($row['desakel']) : null,
                        'alamat' => isset($row['alamat']) ? trim($row['alamat']) : null,
                        'latitude' => isset($row['latitude']) ? floatval($row['latitude']) : null,
                        'longitude' => isset($row['longitude']) ? floatval($row['longitude']) : null,
                        'status' => 'Aktif',
                    ]
                );
                $kartu_keluarga_id = $kartuKeluarga->id;
                Log::info("Baris {$this->rowNumber}: Kartu Keluarga ID: {$kartu_keluarga_id}, No KK: {$no_kk}");
            } else {
                Log::info("Baris {$this->rowNumber}: Nomor KK kosong, kartu_keluarga_id diset ke null.");
            }

            // Validasi NIK (opsional, unik jika ada)
            $nik = isset($row['nik']) ? trim(Str::replace([' ', "\xc2\xa0"], '', $row['nik'])) : null;
            Log::info("Baris {$this->rowNumber}: NIK mentah: {$row['nik']}, NIK setelah pembersihan: {$nik}");
            if ($nik && Balita::where('nik', $nik)->exists()) {
                $this->errors[] = "Baris {$this->rowNumber}: NIK {$nik} sudah ada di database.";
                Log::warning("Baris {$this->rowNumber}: NIK {$nik} sudah ada di database.");
                return null;
            }
            if ($nik === '') {
                $nik = null;
            }

           // Validasi tanggal lahir (opsional)
$tanggal_lahir = null;
if (isset($row['tgl_lahir']) && !empty(trim($row['tgl_lahir']))) {
    $input = trim($row['tgl_lahir']);
    if (is_numeric($input) && $input > 1000) {
        try {
            $tanggal_lahir = Carbon::createFromFormat('Y-m-d', '1899-12-30')
                ->addDays((int)$input)
                ->toDateString();
            Log::info("Baris {$this->rowNumber}: Serial date {$input} dikonversi ke {$tanggal_lahir}");
        } catch (\Exception $e) {
            $this->errors[] = "Baris {$this->rowNumber}: Format tanggal numerik tidak valid: {$input}";
            Log::error("Baris {$this->rowNumber}: Error tanggal numerik: {$e->getMessage()}");
            return null;
        }
    } else {
        try {
            $tanggal_lahir = Carbon::parse($input)->toDateString();
            Log::info("Baris {$this->rowNumber}: Tanggal tekstual {$input} dikonversi ke {$tanggal_lahir}");
        } catch (\Exception $e) {
            $this->errors[] = "Baris {$this->rowNumber}: Format tanggal tidak valid: {$input}";
            Log::error("Baris {$this->rowNumber}: Error tanggal tekstual: {$e->getMessage()}");
            return null;
        }
    }
}

            // Validasi jenis kelamin (opsional)
            $jenis_kelamin = isset($row['jk']) ? trim($row['jk']) : null;
            if ($jenis_kelamin && !in_array(strtoupper($jenis_kelamin), ['L', 'P'])) {
                $this->errors[] = "Baris {$this->rowNumber}: Jenis kelamin tidak valid: {$jenis_kelamin} (harus L atau P)";
                Log::warning("Baris {$this->rowNumber}: Jenis kelamin tidak valid: {$jenis_kelamin}");
                return null;
            }
            $jenis_kelamin = strtoupper($jenis_kelamin) === 'L' ? 'Laki-laki' : (strtoupper($jenis_kelamin) === 'P' ? 'Perempuan' : null);

            // Cari kecamatan
            $kecamatan = isset($row['kec']) ? Kecamatan::where('nama_kecamatan', trim(strtoupper($row['kec'])))->first() : null;
            if (!$kecamatan) {
                $this->errors[] = "Baris {$this->rowNumber}: Kecamatan '{$row['kec']}' tidak ditemukan.";
                Log::warning("Baris {$this->rowNumber}: Kecamatan '{$row['kec']}' tidak ditemukan.");
                return null;
            }

            // Cari kelurahan (boleh kosong)
            $kelurahan_id = null;
            if (isset($row['desakel']) && !empty(trim($row['desakel']))) {
                $kelurahan = $this->findKelurahan($row['desakel'], $kecamatan->id);
                if (!$kelurahan) {
                    $this->errors[] = "Baris {$this->rowNumber}: Kelurahan '{$row['desakel']}' tidak ditemukan untuk kecamatan '{$row['kec']}'.";
                    Log::warning("Baris {$this->rowNumber}: Kelurahan '{$row['desakel']}' tidak ditemukan untuk kecamatan '{$row['kec']}'.");
                    return null;
                }
                $kelurahan_id = $kelurahan->id;
                Log::info("Baris {$this->rowNumber}: Kelurahan ditemukan: {$kelurahan->nama_kelurahan}, ID: {$kelurahan_id}");
            } else {
                Log::info("Baris {$this->rowNumber}: Kolom desakel kosong, kelurahan_id diset ke null.");
            }

            $balita = new Balita([
                'kartu_keluarga_id' => $kartu_keluarga_id,
                'nik' => $nik,
                'nama' => trim($row['nama']),
                'tanggal_lahir' => $tanggal_lahir,
                'jenis_kelamin' => $jenis_kelamin,
                'berat_tinggi' => '0/0',
                'kecamatan_id' => $kecamatan->id,
                'kelurahan_id' => $kelurahan_id,
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
        return 100;
    }
}