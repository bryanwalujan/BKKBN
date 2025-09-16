<?php

namespace App\Http\Controllers;

use App\Models\PendingBalita;
use App\Models\Balita;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanBalitaController extends Controller
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

        // Query untuk PendingBalita
        $pendingQuery = PendingBalita::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $pendingQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $pendingBalitas = $pendingQuery->get()->map(function ($balita) {
            $balita->source = 'pending';
            return $balita;
        });

        // Query untuk Balita (terverifikasi)
        $verifiedQuery = Balita::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $kelurahan_id);

        if ($search) {
            $verifiedQuery->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nik', 'like', '%' . $search . '%');
            });
        }

        $verifiedBalitas = $verifiedQuery->get()->map(function ($balita) {
            $balita->source = 'verified';
            $balita->createdBy = $balita->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $balita;
        });

        // Filter berdasarkan kategori umur
        if ($kategoriUmur && in_array($kategoriUmur, ['Baduata', 'Balita'])) {
            $pendingBalitas = $pendingBalitas->filter(function ($balita) use ($kategoriUmur) {
                return $balita->kategoriUmur === $kategoriUmur;
            });
            $verifiedBalitas = $verifiedBalitas->filter(function ($balita) use ($kategoriUmur) {
                return $balita->kategoriUmur === $kategoriUmur;
            });
        }

        // Gabungkan data untuk tab yang dipilih
        $balitas = $tab === 'verified' ? $verifiedBalitas : $pendingBalitas;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $balitas->count();
        $paginatedBalitas = $balitas->slice($offset, $perPage);
        $balitas = new LengthAwarePaginator($paginatedBalitas, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kelurahan.balita.index', compact('balitas', 'kategoriUmur', 'search', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->get();
        return view('kelurahan.balita.create', compact('kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'unique:pending_balitas,nik', 'unique:balitas,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'lingkar_lengan' => ['nullable', 'numeric', 'min:0'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            $data = $request->all();
            $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;
            $data['status'] = 'pending';

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
            }

            Log::info('Menyimpan data balita ke pending_balitas', ['data' => $data]);
            PendingBalita::create($data);

            return redirect()->route('kelurahan.balita.index')->with('success', 'Data balita berhasil ditambahkan, menunggu verifikasi admin kecamatan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data balita: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data balita: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        if ($source === 'verified') {
            $balita = Balita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        } else {
            $balita = PendingBalita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)->get();
        $beratTinggi = explode('/', $balita->berat_tinggi ?? '0/0');
        $balita->tanggal_lahir = $balita->tanggal_lahir instanceof \Carbon\Carbon 
            ? $balita->tanggal_lahir->format('Y-m-d') 
            : $balita->tanggal_lahir;

        return view('kelurahan.balita.edit', compact('balita', 'kartuKeluargas', 'beratTinggi', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nik' => ['nullable', 'string', 'max:255', 'unique:pending_balitas,nik,' . ($source === 'pending' ? $id : null), 'unique:balitas,nik,' . ($source === 'verified' ? $id : null)],
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'berat' => ['required', 'numeric', 'min:0'],
            'tinggi' => ['required', 'numeric', 'min:0'],
            'lingkar_kepala' => ['nullable', 'numeric', 'min:0'],
            'lingkar_lengan' => ['nullable', 'numeric', 'min:0'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'status_gizi' => ['required', 'in:Sehat,Stunting,Kurang Gizi,Obesitas'],
            'warna_label' => ['required', 'in:Sehat,Waspada,Bahaya'],
            'status_pemantauan' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
        ]);

        try {
            if ($source === 'verified') {
                $verifiedBalita = Balita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = [
                    'kartu_keluarga_id' => $request->kartu_keluarga_id,
                    'nik' => $request->nik,
                    'nama' => $request->nama,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'berat_tinggi' => $request->berat . '/' . $request->tinggi,
                    'lingkar_kepala' => $request->lingkar_kepala,
                    'lingkar_lengan' => $request->lingkar_lengan,
                    'alamat' => $request->alamat,
                    'status_gizi' => $request->status_gizi,
                    'warna_label' => $request->warna_label,
                    'status_pemantauan' => $request->status_pemantauan,
                    'kecamatan_id' => $user->kecamatan_id,
                    'kelurahan_id' => $user->kelurahan_id,
                    'created_by' => $user->id,
                    'status' => 'pending',
                    'original_balita_id' => $verifiedBalita->id,
                ];

                if ($request->hasFile('foto')) {
                    if ($verifiedBalita->foto && Storage::disk('public')->exists($verifiedBalita->foto)) {
                        Storage::disk('public')->delete($verifiedBalita->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
                } else {
                    $data['foto'] = $verifiedBalita->foto;
                }

                Log::info('Menyimpan data balita terverifikasi ke pending_balitas untuk edit', ['data' => $data]);
                PendingBalita::create($data);

                return redirect()->route('kelurahan.balita.index')->with('success', 'Data balita terverifikasi berhasil diedit, menunggu verifikasi admin kecamatan.');
            } else {
                $balita = PendingBalita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                $data = $request->all();
                $data['berat_tinggi'] = $request->berat . '/' . $request->tinggi;
                $data['kecamatan_id'] = $user->kecamatan_id;
                $data['kelurahan_id'] = $user->kelurahan_id;
                $data['created_by'] = $user->id;
                $data['status'] = 'pending';

                if ($request->hasFile('foto')) {
                    if ($balita->foto && Storage::disk('public')->exists($balita->foto)) {
                        Storage::disk('public')->delete($balita->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('balita_fotos', 'public');
                }

                Log::info('Memperbarui data balita di pending_balitas', ['id' => $id, 'data' => $data]);
                $balita->update($data);

                return redirect()->route('kelurahan.balita.index')->with('success', 'Data balita berhasil diperbarui, menunggu verifikasi admin kecamatan.');
            }
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data balita: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data balita: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.balita.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $balita = PendingBalita::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($balita->foto && Storage::disk('public')->exists($balita->foto)) {
                Storage::disk('public')->delete($balita->foto);
            }
            $balita->delete();

            return redirect()->route('kelurahan.balita.index')->with('success', 'Data balita berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.balita.index')->with('error', 'Gagal menghapus data balita: ' . $e->getMessage());
        }
    }
}