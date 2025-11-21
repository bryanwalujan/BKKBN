<?php
namespace App\Http\Controllers;

use App\Models\BayiBaruLahir;
use App\Models\IbuNifas;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BayiBaruLahirController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = BayiBaruLahir::with(['ibuNifas.ibu.kartuKeluarga', 'ibuNifas.ibu.kecamatan', 'ibuNifas.ibu.kelurahan']);
        
        if ($search) {
            $query->whereHas('ibuNifas.ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            })->orWhere('umur_dalam_kandungan', 'like', '%' . $search . '%');
        }

        $bayiBaruLahirs = $query->paginate(10)->appends(['search' => $search]);
        
        // Hitung rata-rata dari semua data (bukan hanya dari halaman pagination)
        $allBayi = BayiBaruLahir::all();
        $avgBeratBadan = $this->calculateAverage($allBayi, 'berat_badan_lahir');
        $avgPanjangBadan = $this->calculateAverage($allBayi, 'panjang_badan_lahir');
        
        return view('master.bayi_baru_lahir.index', compact('bayiBaruLahirs', 'search', 'avgBeratBadan', 'avgPanjangBadan'));
    }

    /**
     * Helper untuk menghitung rata-rata dengan normalisasi koma ke titik
     */
    private function calculateAverage($collection, $field)
    {
        $values = [];
        
        foreach ($collection as $item) {
            $value = $item->$field;
            
            // Skip jika nilai kosong atau null
            if (empty($value)) {
                continue;
            }
            
            // Konversi koma ke titik untuk format Indonesia
            $normalized = str_replace(',', '.', trim($value));
            
            // Validasi apakah hasilnya numerik
            if (is_numeric($normalized)) {
                $values[] = (float)$normalized;
            }
        }
        
        // Hitung rata-rata jika ada data valid
        if (count($values) > 0) {
            return array_sum($values) / count($values);
        }
        
        return 0;
    }

    /**
     * Helper untuk normalisasi input angka (koma ke titik)
     * Tidak mengubah format, hanya memastikan format konsisten
     */
    private function normalizeNumericInput($value)
    {
        if (empty($value)) {
            return null;
        }
        
        // Biarkan format asli (dengan koma) karena tipe data varchar
        // Hanya bersihkan spasi berlebih
        return trim($value);
    }

    public function create()
    {
        $ibuNifas = IbuNifas::with('ibu')->get();
        return view('master.bayi_baru_lahir.create', compact('ibuNifas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ibu_nifas_id' => ['required', 'exists:ibu_nifas,id'],
            'umur_dalam_kandungan' => ['nullable', 'string', 'max:255'],
            'berat_badan_lahir' => ['nullable', 'string', 'max:255'],
            'panjang_badan_lahir' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $data = $request->all();
            
            // Normalisasi input (bersihkan spasi)
            $data['berat_badan_lahir'] = $this->normalizeNumericInput($request->berat_badan_lahir);
            $data['panjang_badan_lahir'] = $this->normalizeNumericInput($request->panjang_badan_lahir);
            
            BayiBaruLahir::create($data);
            return redirect()->route('bayi_baru_lahir.index')->with('success', 'Data bayi baru lahir berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data bayi baru lahir: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data bayi baru lahir: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $bayiBaruLahir = BayiBaruLahir::with('ibuNifas.ibu')->findOrFail($id);
        $ibuNifas = IbuNifas::with('ibu')->get();
        return view('master.bayi_baru_lahir.edit', compact('bayiBaruLahir', 'ibuNifas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ibu_nifas_id' => ['required', 'exists:ibu_nifas,id'],
            'umur_dalam_kandungan' => ['nullable', 'string', 'max:255'],
            'berat_badan_lahir' => ['nullable', 'string', 'max:255'],
            'panjang_badan_lahir' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $bayiBaruLahir = BayiBaruLahir::findOrFail($id);
            
            $data = $request->all();
            
            // Normalisasi input (bersihkan spasi)
            $data['berat_badan_lahir'] = $this->normalizeNumericInput($request->berat_badan_lahir);
            $data['panjang_badan_lahir'] = $this->normalizeNumericInput($request->panjang_badan_lahir);
            
            $bayiBaruLahir->update($data);
            return redirect()->route('bayi_baru_lahir.index')->with('success', 'Data bayi baru lahir berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data bayi baru lahir: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data bayi baru lahir: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $bayiBaruLahir = BayiBaruLahir::findOrFail($id);
            $bayiBaruLahir->delete();
            return redirect()->route('bayi_baru_lahir.index')->with('success', 'Data bayi baru lahir berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data bayi baru lahir: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('bayi_baru_lahir.index')->with('error', 'Gagal menghapus data bayi baru lahir: ' . $e->getMessage());
        }
    }

    public function moveToBalita($id)
    {
        try {
            $bayiBaruLahir = BayiBaruLahir::with('ibuNifas.ibu')->findOrFail($id);
            $ibuNifas = $bayiBaruLahir->ibuNifas;

            // Ambil data berat dan panjang badan langsung dari database
            $beratBadan = $bayiBaruLahir->berat_badan_lahir;
            $panjangBadan = $bayiBaruLahir->panjang_badan_lahir;

            // Buat data balita
            Balita::create([
                'created_by' => auth()->id(),
                'nik' => null,
                'nama' => 'Bayi ' . ($ibuNifas->ibu->nama ?? 'Tanpa Nama'),
                'tanggal_lahir' => $ibuNifas->tanggal_melahirkan,
                'berat_tinggi' => ($beratBadan ? $beratBadan . ' kg' : '') . 
                                 ($panjangBadan ? ' / ' . $panjangBadan . ' cm' : ''),
                'kelurahan_id' => $ibuNifas->ibu->kelurahan_id,
                'kecamatan_id' => $ibuNifas->ibu->kecamatan_id,
                'kartu_keluarga_id' => $ibuNifas->ibu->kartu_keluarga_id,
                'jenis_kelamin' => null,
                'lingkar_kepala' => null,
                'lingkar_lengan' => null,
                'alamat' => $ibuNifas->ibu->alamat ?? null,
                'status_gizi' => null,
                'warna_label' => null,
                'status_pemantauan' => null,
                'foto' => null,
            ]);

            // Hapus data dari bayi_baru_lahir
            $bayiBaruLahir->delete();

            return redirect()->route('bayi_baru_lahir.index')->with('success', 'Data bayi berhasil dipindahkan ke tabel balita.');
        } catch (\Exception $e) {
            Log::error('Gagal memindahkan data bayi ke balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('bayi_baru_lahir.index')->with('error', 'Gagal memindahkan data bayi ke balita: ' . $e->getMessage());
        }
    }
}