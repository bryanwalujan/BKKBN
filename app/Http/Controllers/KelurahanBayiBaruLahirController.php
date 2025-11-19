<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BayiBaruLahir;
use App\Models\IbuNifas;
use App\Models\Balita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class KelurahanBayiBaruLahirController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin_kelurahan']);
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $kelurahan_id = Auth::user()->kelurahan_id;
        $query = BayiBaruLahir::with(['ibuNifas.ibu.kartuKeluarga', 'ibuNifas.ibu.kecamatan', 'ibuNifas.ibu.kelurahan'])
            ->whereHas('ibuNifas.ibu', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
            });

        if ($search) {
            $query->whereHas('ibuNifas.ibu', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            })->orWhere('umur_dalam_kandungan', 'like', '%' . $search . '%');
        }

        $bayiBaruLahirs = $query->paginate(10)->appends(['search' => $search]);
        return view('kelurahan.bayi_baru_lahir.index', compact('bayiBaruLahirs', 'search'));
    }

    public function create()
    {
        $kelurahan_id = Auth::user()->kelurahan_id;
        $ibuNifas = IbuNifas::with('ibu')->whereHas('ibu', function ($q) use ($kelurahan_id) {
            $q->where('kelurahan_id', $kelurahan_id);
        })->get();
        return view('kelurahan.bayi_baru_lahir.create', compact('ibuNifas'));
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
            $kelurahan_id = Auth::user()->kelurahan_id;
            $ibuNifas = IbuNifas::findOrFail($request->ibu_nifas_id);
            if ($ibuNifas->ibu->kelurahan_id != $kelurahan_id) {
                return redirect()->back()->withInput()->with('error', 'Anda tidak memiliki izin untuk menambahkan data bayi untuk ibu nifas ini.');
            }

            BayiBaruLahir::create(array_merge($request->all(), [
                'created_by' => Auth::id(),
            ]));
            return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('success', 'Data bayi baru lahir berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data bayi baru lahir: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data bayi baru lahir: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kelurahan_id = Auth::user()->kelurahan_id;
        $bayiBaruLahir = BayiBaruLahir::with('ibuNifas.ibu')->findOrFail($id);
        if ($bayiBaruLahir->ibuNifas->ibu->kelurahan_id != $kelurahan_id) {
            return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('error', 'Anda tidak memiliki izin untuk mengedit data ini.');
        }
        $ibuNifas = IbuNifas::with('ibu')->whereHas('ibu', function ($q) use ($kelurahan_id) {
            $q->where('kelurahan_id', $kelurahan_id);
        })->get();
        return view('kelurahan.bayi_baru_lahir.edit', compact('bayiBaruLahir', 'ibuNifas'));
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
            $kelurahan_id = Auth::user()->kelurahan_id;
            $bayiBaruLahir = BayiBaruLahir::findOrFail($id);
            if ($bayiBaruLahir->ibuNifas->ibu->kelurahan_id != $kelurahan_id) {
                return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui data ini.');
            }
            $ibuNifas = IbuNifas::findOrFail($request->ibu_nifas_id);
            if ($ibuNifas->ibu->kelurahan_id != $kelurahan_id) {
                return redirect()->back()->withInput()->with('error', 'Anda tidak memiliki izin untuk memperbarui data dengan ibu nifas ini.');
            }

            $bayiBaruLahir->update(array_merge($request->all(), [
                'created_by' => Auth::id(),
            ]));
            return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('success', 'Data bayi baru lahir berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data bayi baru lahir: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data bayi baru lahir: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $kelurahan_id = Auth::user()->kelurahan_id;
            $bayiBaruLahir = BayiBaruLahir::findOrFail($id);
            if ($bayiBaruLahir->ibuNifas->ibu->kelurahan_id != $kelurahan_id) {
                return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
            }
            $bayiBaruLahir->delete();
            return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('success', 'Data bayi baru lahir berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data bayi baru lahir: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('error', 'Gagal menghapus data bayi baru lahir: ' . $e->getMessage());
        }
    }

    public function moveToBalita($id)
    {
        try {
            $kelurahan_id = Auth::user()->kelurahan_id;
            $bayiBaruLahir = BayiBaruLahir::with('ibuNifas.ibu')->findOrFail($id);
            if ($bayiBaruLahir->ibuNifas->ibu->kelurahan_id != $kelurahan_id) {
                return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('error', 'Anda tidak memiliki izin untuk memindahkan data ini.');
            }
            $ibuNifas = $bayiBaruLahir->ibuNifas;

            Balita::create([
                'created_by' => Auth::id(),
                'nik' => null,
                'nama' => 'Bayi ' . ($ibuNifas->ibu->nama ?? 'Tanpa Nama'),
                'tanggal_lahir' => $ibuNifas->tanggal_melahirkan,
                'berat_tinggi' => ($bayiBaruLahir->berat_badan_lahir ? $bayiBaruLahir->berat_badan_lahir . ' kg' : '') . 
                                 ($bayiBaruLahir->panjang_badan_lahir ? ' / ' . $bayiBaruLahir->panjang_badan_lahir . ' cm' : ''),
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

            $bayiBaruLahir->delete();
            return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('success', 'Data bayi berhasil dipindahkan ke tabel balita.');
        } catch (\Exception $e) {
            Log::error('Gagal memindahkan data bayi ke balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.bayi_baru_lahir.index')->with('error', 'Gagal memindahkan data bayi ke balita: ' . $e->getMessage());
        }
    }
}