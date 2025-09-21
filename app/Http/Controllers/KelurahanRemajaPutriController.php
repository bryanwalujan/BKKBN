<?php

namespace App\Http\Controllers;

use App\Models\PendingRemajaPutri;
use App\Models\RemajaPutri;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanRemajaPutriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kelurahan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $search = $request->query('search');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingRemajaPutri
        $pendingQuery = PendingRemajaPutri::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'pending');

        if ($search) {
            $pendingQuery->where('nama', 'like', '%' . $search . '%');
        }

        $pendingRemajaPutris = $pendingQuery->get()->map(function ($remaja) {
            $remaja->source = 'pending';
            return $remaja;
        });

        // Query untuk RemajaPutri (terverifikasi)
        $verifiedQuery = RemajaPutri::with(['kartuKeluarga', 'kecamatan', 'kelurahan'])
            ->where('kelurahan_id', $user->kelurahan_id);

        if ($search) {
            $verifiedQuery->where('nama', 'like', '%' . $search . '%');
        }

        $verifiedRemajaPutris = $verifiedQuery->get()->map(function ($remaja) {
            $remaja->source = 'verified';
            $remaja->createdBy = $remaja->createdBy ?? (object) ['name' => 'Tidak diketahui'];
            return $remaja;
        });

        // Gabungkan data untuk tab yang dipilih
        $remajaPutris = $tab === 'verified' ? $verifiedRemajaPutris : $pendingRemajaPutris;

        // Paginate
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $total = $remajaPutris->count();
        $paginatedRemajaPutris = $remajaPutris->slice($offset, $perPage);
        $remajaPutris = new LengthAwarePaginator($paginatedRemajaPutris, $total, $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('kelurahan.remaja_putri.index', compact('remajaPutris', 'search', 'tab'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.remaja_putri.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kecamatan = $user->kecamatan;
        $kelurahan = $user->kelurahan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan) {
            Log::warning('Tidak ada data Kartu Keluarga atau data kecamatan/kelurahan tidak ditemukan untuk kelurahan_id: ' . $user->kelurahan_id);
            return view('kelurahan.remaja_putri.create', compact('kartuKeluargas', 'kecamatan', 'kelurahan'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau data kecamatan/kelurahan tidak ditemukan. Silakan tambahkan data terlebih dahulu.');
        }

        return view('kelurahan.remaja_putri.create', compact('kartuKeluargas', 'kecamatan', 'kelurahan'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.remaja_putri.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $data = $request->all();
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;
            $data['status'] = 'pending';

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pending_remaja_putri_fotos', 'public');
            }

            PendingRemajaPutri::create($data);
            Log::info('Menyimpan data remaja putri ke pending_remaja_putris', ['data' => $data]);
            return redirect()->route('kelurahan.remaja_putri.index', ['tab' => 'pending'])->with('success', 'Data remaja putri berhasil diajukan untuk verifikasi.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data remaja putri: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan data remaja putri: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.remaja_putri.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        if ($source === 'verified') {
            $remajaPutri = RemajaPutri::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        } else {
            $remajaPutri = PendingRemajaPutri::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga']);

        $kecamatan = $user->kecamatan;
        $kelurahan = $user->kelurahan;

        if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan) {
            Log::warning('Tidak ada data Kartu Keluarga atau data kecamatan/kelurahan tidak ditemukan untuk kelurahan_id: ' . $user->kelurahan_id);
            return view('kelurahan.remaja_putri.edit', compact('remajaPutri', 'kartuKeluargas', 'kecamatan', 'kelurahan', 'source'))
                ->with('error', 'Tidak ada data Kartu Keluarga yang terverifikasi atau data kecamatan/kelurahan tidak ditemukan. Silakan tambahkan data terlebih dahulu.');
        }

        return view('kelurahan.remaja_putri.edit', compact('remajaPutri', 'kartuKeluargas', 'kecamatan', 'kelurahan', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $user = Auth::user();
        if (!$user->kelurahan_id || !$user->kecamatan_id) {
            return redirect()->route('kelurahan.remaja_putri.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan atau kecamatan.');
        }

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $data = $request->all();
            $data['kecamatan_id'] = $user->kecamatan_id;
            $data['kelurahan_id'] = $user->kelurahan_id;
            $data['created_by'] = $user->id;
            $data['status'] = 'pending';

            if ($source === 'verified') {
                $remajaPutri = RemajaPutri::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                if ($request->hasFile('foto')) {
                    $data['foto'] = $request->file('foto')->store('pending_remaja_putri_fotos', 'public');
                } else {
                    $data['foto'] = $remajaPutri->foto;
                }
                $data['original_remaja_putri_id'] = $remajaPutri->id;
                PendingRemajaPutri::create($data);
                $message = 'Perubahan data remaja putri berhasil diajukan untuk verifikasi.';
            } else {
                $remajaPutri = PendingRemajaPutri::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
                if ($request->hasFile('foto')) {
                    if ($remajaPutri->foto && Storage::disk('public')->exists($remajaPutri->foto)) {
                        Storage::disk('public')->delete($remajaPutri->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('pending_remaja_putri_fotos', 'public');
                }
                $remajaPutri->update($data);
                $message = 'Data remaja putri berhasil diperbarui dan diajukan untuk verifikasi.';
            }

            Log::info('Memperbarui data remaja putri', ['id' => $id, 'source' => $source, 'data' => $data]);
            return redirect()->route('kelurahan.remaja_putri.index', ['tab' => 'pending'])->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data remaja putri: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data remaja putri: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return redirect()->route('kelurahan.remaja_putri.index')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        try {
            $remajaPutri = PendingRemajaPutri::where('kelurahan_id', $user->kelurahan_id)->findOrFail($id);
            if ($remajaPutri->foto && Storage::disk('public')->exists($remajaPutri->foto)) {
                Storage::disk('public')->delete($remajaPutri->foto);
            }
            $remajaPutri->delete();
            return redirect()->route('kelurahan.remaja_putri.index', ['tab' => 'pending'])->with('success', 'Data remaja putri berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data remaja putri: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.remaja_putri.index', ['tab' => 'pending'])->with('error', 'Gagal menghapus data remaja putri: ' . $e->getMessage());
        }
    }

    public function getKartuKeluarga(Request $request)
    {
        $user = Auth::user();
        if (!$user->kelurahan_id) {
            return response()->json(['error' => 'Admin kelurahan tidak terkait dengan kelurahan.'], 403);
        }

        $kartuKeluargas = KartuKeluarga::where('kelurahan_id', $user->kelurahan_id)
            ->where('status', 'Aktif')
            ->get(['id', 'no_kk', 'kepala_keluarga'])
            ->map(function ($kk) {
                return [
                    'id' => $kk->id,
                    'no_kk' => $kk->no_kk,
                    'kepala_keluarga' => $kk->kepala_keluarga,
                ];
            });

        return response()->json($kartuKeluargas);
    }
}   