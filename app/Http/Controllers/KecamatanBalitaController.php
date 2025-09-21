<?php

namespace App\Http\Controllers;

use App\Models\PendingBalita;
use App\Models\Balita;
use App\Models\KartuKeluarga;
use App\Models\PendingKartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanBalitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin_kecamatan');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $kecamatan_id = $user->kecamatan_id;

        if (!$kecamatan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $search = $request->query('search');
        $kategoriUmur = $request->query('kategori_umur');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingBalita
        $pendingQuery = PendingBalita::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status', 'pending');

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
            ->where('kecamatan_id', $kecamatan_id);

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

        return view('kecamatan.balita.index', compact('balitas', 'kategoriUmur', 'search', 'tab'));
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.balita.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        try {
            $pendingBalita = PendingBalita::where('kecamatan_id', $user->kecamatan_id)
                ->where('status', 'pending')
                ->findOrFail($id);

            $data = [
                'kartu_keluarga_id' => $pendingBalita->kartu_keluarga_id,
                'nik' => $pendingBalita->nik,
                'nama' => $pendingBalita->nama,
                'tanggal_lahir' => $pendingBalita->tanggal_lahir,
                'jenis_kelamin' => $pendingBalita->jenis_kelamin,
                'kecamatan_id' => $pendingBalita->kecamatan_id,
                'kelurahan_id' => $pendingBalita->kelurahan_id,
                'berat_tinggi' => $pendingBalita->berat_tinggi,
                'lingkar_kepala' => $pendingBalita->lingkar_kepala,
                'lingkar_lengan' => $pendingBalita->lingkar_lengan,
                'alamat' => $pendingBalita->alamat,
                'status_gizi' => $pendingBalita->status_gizi,
                'warna_label' => $pendingBalita->warna_label,
                'status_pemantauan' => $pendingBalita->status_pemantauan,
                'foto' => $pendingBalita->foto,
                'created_by' => $pendingBalita->created_by,
            ];

            if ($pendingBalita->original_balita_id) {
                // Update data di balitas jika original_balita_id ada
                $existingBalita = Balita::findOrFail($pendingBalita->original_balita_id);
                $existingBalita->update($data);
                Log::info('Memperbarui data balita di balitas', ['id' => $existingBalita->id, 'data' => $data]);
            } else {
                // Buat baru jika tidak ada original_balita_id
                $existingBalita = Balita::where('nik', $pendingBalita->nik)->first();
                if ($existingBalita) {
                    $existingBalita->update($data);
                    Log::info('Memperbarui data balita di balitas', ['id' => $existingBalita->id, 'data' => $data]);
                } else {
                    Balita::create($data);
                    Log::info('Menyimpan data balita baru ke balitas', ['data' => $data]);
                }
            }

            // Tandai sebagai approved dan hapus dari pending
            $pendingBalita->update(['status' => 'approved']);
            $pendingBalita->delete();

            return redirect()->route('kecamatan.balita.index')->with('success', 'Data balita berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Gagal menyetujui data balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.balita.index')->with('error', 'Gagal menyetujui data balita: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            return redirect()->route('kecamatan.balita.index')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $request->validate([
            'catatan' => ['required', 'string', 'max:255'],
        ]);

        try {
            $pendingBalita = PendingBalita::where('kecamatan_id', $user->kecamatan_id)
                ->where('status', 'pending')
                ->findOrFail($id);

            if ($pendingBalita->foto && Storage::disk('public')->exists($pendingBalita->foto)) {
                Storage::disk('public')->delete($pendingBalita->foto);
            }

            $pendingBalita->update([
                'status' => 'rejected',
                'catatan' => $request->catatan,
            ]);
            $pendingBalita->delete();

            Log::info('Data balita ditolak', ['id' => $id, 'catatan' => $request->catatan]);

            return redirect()->route('kecamatan.balita.index')->with('success', 'Data balita ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menolak data balita: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.balita.index')->with('error', 'Gagal menolak data balita: ' . $e->getMessage());
        }
    }
}