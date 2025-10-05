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
        return view('master.bayi_baru_lahir.index', compact('bayiBaruLahirs', 'search'));
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
            BayiBaruLahir::create($request->all());
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
            $bayiBaruLahir->update($request->all());
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

            // Buat data balita
            Balita::create([
                'created_by' => auth()->id(),
                'nik' => null, // Nullable, sesuai permintaan
                'nama' => 'Bayi ' . ($ibuNifas->ibu->nama ?? 'Tanpa Nama'),
                'tanggal_lahir' => $ibuNifas->tanggal_melahirkan,
                'berat_tinggi' => ($bayiBaruLahir->berat_badan_lahir ? $bayiBaruLahir->berat_badan_lahir . ' kg' : '') . 
                                 ($bayiBaruLahir->panjang_badan_lahir ? ' / ' . $bayiBaruLahir->panjang_badan_lahir . ' cm' : ''),
                'kelurahan_id' => $ibuNifas->ibu->kelurahan_id,
                'kecamatan_id' => $ibuNifas->ibu->kecamatan_id,
                'kartu_keluarga_id' => $ibuNifas->ibu->kartu_keluarga_id,
                'jenis_kelamin' => null, // Nullable
                'lingkar_kepala' => null, // Nullable
                'lingkar_lengan' => null, // Nullable
                'alamat' => $ibuNifas->ibu->alamat ?? null, // Ambil dari ibu jika ada
                'status_gizi' => null, // Nullable
                'warna_label' => null, // Nullable
                'status_pemantauan' => null, // Nullable
                'foto' => null, // Nullable
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