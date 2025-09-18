<?php
namespace App\Http\Controllers;

use App\Models\PendingStunting;
use App\Models\Stunting;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanStuntingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kelurahan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $kelurahan_id = $user->kelurahan_id;

        if (!$kelurahan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $search = $request->query('search');
        $kategoriUmur = $request->query('kategori_umur');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingStunting
        $pendingQuery = PendingStunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $kelurahan_id)
            ->where('status', 'pending');

        if ($search) {
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $pendingStuntings = $pendingQuery->get()->map(function ($stunting) {
            $stunting->source = 'pending';
            return $stunting;
        });

        // Query untuk Stunting (terverifikasi)
        $verifiedQuery = Stunting::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $verifiedQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $verifiedStuntings = $verifiedQuery->get()->map(function ($stunting) {
            $stunting->source = 'verified';
            $stunting->createdBy = $stunting->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $stunting;
        });

        // Filter berdasarkan kategori umur
        if ($kategoriUmur && in_array($kategoriUmur, ['Baduata', 'Balita'])) {
            $pendingStuntings = $pendingStuntings->filter(function ($stunting) use ($kategoriUmur) {
                return $stunting->kategori_umur === $kategoriUmur;
            });
            $verifiedStuntings = $verifiedStuntings->filter(function ($stunting) use ($kategoriUmur) {
                return $stunting->kategori_umur === $kategoriUmur;
            });
        }

        // Gabungkan data untuk tab yang dipilih
        $stuntings = $tab === 'verified' ? $verifiedStuntings : $pendingStuntings;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $stuntings->count();
        $paginatedStuntings = $stuntings->slice($offset, $perPage);
        $stuntings = new LengthAwarePaginator($paginatedStuntings, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kelurahan.stunting.index', compact('stuntings', 'kategoriUmur', 'search', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kecamatan = Kecamatan::where('id', $user->kecamatan_id)->first();
        $kelurahan = Kelurahan::where('id', $user->kelurahan_id)->first();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get();

        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kelurahan.kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum menambah data stunting.');
        }
        if (!$kecamatan || !$kelurahan) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Data kecamatan atau kelurahan tidak ditemukan.');
        }

        return view('kelurahan.stunting.create', compact('kartuKeluargas', 'kecamatan', 'kelurahan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id . ',kelurahan_id,' . $user->kelurahan_id],
            'nik' => ['nullable', 'string', 'max:255', 'unique:pending_stuntings,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $data = $request->except(['kecamatan_id', 'kelurahan_id']);
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['created_by'] = Auth::id();
            $data['status'] = 'pending';

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pending_stunting_fotos', 'public');
            }

            Log::info('Menyimpan data stunting ke pending_stuntings', ['data' => $data]);
            PendingStunting::create($data);

            return redirect()->route('kelurahan.stunting.index')->with('success', 'Data stunting berhasil diajukan untuk verifikasi.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data stunting: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan data stunting: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        if ($source === 'verified') {
            $stunting = Stunting::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        } else {
            $stunting = PendingStunting::where('created_by', Auth::id())->where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        }

        $kecamatan = Kecamatan::where('id', $user->kecamatan_id)->first();
        $kelurahan = Kelurahan::where('id', $user->kelurahan_id)->first();
        $kartuKeluargas = KartuKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get();

        if ($kartuKeluargas->isEmpty()) {
            return redirect()->route('kelurahan.kartu_keluarga.create')->with('error', 'Tambahkan Kartu Keluarga terlebih dahulu sebelum mengedit data stunting.');
        }
        if (!$kecamatan || !$kelurahan) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Data kecamatan atau kelurahan tidak ditemukan.');
        }

        // Pisahkan berat_tinggi menjadi berat dan tinggi
        $beratTinggi = explode('/', $stunting->berat_tinggi ?? '0/0');

        // Pastikan tanggal_lahir dalam format Y-m-d
        $tanggalLahir = $stunting->tanggal_lahir ? \Carbon\Carbon::parse($stunting->tanggal_lahir)->format('Y-m-d') : null;

        // Log untuk debugging
        Log::info('Edit Stunting', [
            'id' => $id,
            'source' => $source,
            'tanggal_lahir_raw' => $stunting->tanggal_lahir,
            'tanggal_lahir_formatted' => $tanggalLahir,
        ]);

        return view('kelurahan.stunting.edit', compact('stunting', 'kartuKeluargas', 'kecamatan', 'kelurahan', 'source', 'beratTinggi', 'tanggalLahir'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id,kecamatan_id,' . $user->kecamatan_id . ',kelurahan_id,' . $user->kelurahan_id],
            'nik' => ['nullable', 'string', 'max:255', 'unique:pending_stuntings,nik,' . ($source === 'pending' ? $id : null)],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_gizi' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'warna_tindak_lanjut' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $data = $request->except(['kecamatan_id', 'kelurahan_id']);
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['created_by'] = Auth::id();
            $data['status'] = 'pending';

            if ($source === 'verified') {
                if ($request->hasFile('foto')) {
                    $data['foto'] = $request->file('foto')->store('pending_stunting_fotos', 'public');
                } else {
                    $stunting = Stunting::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                    if ($stunting->foto) {
                        $fileName = basename($stunting->foto);
                        $newPath = 'pending_stunting_fotos/' . $fileName;
                        Storage::disk('public')->copy($stunting->foto, $newPath);
                        $data['foto'] = $newPath;
                    }
                }
                Log::info('Menyimpan perubahan stunting terverifikasi ke pending_stuntings', ['id' => $id, 'data' => $data]);
                PendingStunting::create($data);
                $message = 'Perubahan data stunting berhasil diajukan untuk verifikasi.';
            } else {
                $stunting = PendingStunting::where('created_by', Auth::id())->where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                if ($request->hasFile('foto')) {
                    if ($stunting->foto) {
                        Storage::disk('public')->delete($stunting->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('pending_stunting_fotos', 'public');
                }
                Log::info('Memperbarui data stunting di pending_stuntings', ['id' => $id, 'data' => $data]);
                $stunting->update($data);
                $message = 'Data stunting berhasil diperbarui dan diajukan untuk verifikasi.';
            }

            return redirect()->route('kelurahan.stunting.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data stunting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data stunting: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $stunting = PendingStunting::where('created_by', Auth::id())->where('kelurahan_id', Auth::user()->kelurahan_id)->findOrFail($id);
            if ($stunting->foto) {
                Storage::disk('public')->delete($stunting->foto);
            }
            $stunting->delete();

            return redirect()->route('kelurahan.stunting.index')->with('success', 'Data stunting berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data stunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.stunting.index')->with('error', 'Gagal menghapus data stunting: ' . $e->getMessage());
        }
    }
}