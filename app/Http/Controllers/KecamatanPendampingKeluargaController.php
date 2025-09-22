<?php
namespace App\Http\Controllers;

use App\Models\PendingPendampingKeluarga;
use App\Models\PendampingKeluarga;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KecamatanPendampingKeluargaController extends Controller
{
    protected $peranOptions = [
        'Bidan',
        'Kader Posyandu',
        'Kader Kesehatan',
        'Tim Penggerak PKK'
    ];

    protected $statusOptions = [
        'Aktif',
        'Non-Aktif'
    ];

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin_kecamatan']);
    }

    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user->kecamatan_id) {
                Log::warning('Admin kecamatan tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
                return redirect()->route('dashboard')->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
            }

            $tab = $request->query('tab', 'pending');
            $kelurahan_id = $request->query('kelurahan_id', '');
            $peran = $request->query('peran', '');
            $status = $request->query('status', '');

            // Validasi input
            if ($peran && !in_array($peran, $this->peranOptions)) {
                Log::warning('Peran tidak valid', ['peran' => $peran, 'user_id' => $user->id]);
                $peran = '';
            }
            if ($status && !in_array($status, $this->statusOptions)) {
                Log::warning('Status tidak valid', ['status' => $status, 'user_id' => $user->id]);
                $status = '';
            }

            // Query data berdasarkan tab
            $query = ($tab === 'verified') ? PendampingKeluarga::query() : PendingPendampingKeluarga::query();
            $query->with(['kecamatan', 'kelurahan', 'kartuKeluargas'])
                  ->where('kecamatan_id', $user->kecamatan_id)
                  ->orderBy('created_at', 'desc');

            // Terapkan filter
            if ($kelurahan_id) {
                $query->where('kelurahan_id', $kelurahan_id);
            }
            if ($peran) {
                $query->where('peran', $peran);
            }
            if ($status) {
                $query->where('status', $status);
            }

            // Ambil data dengan paginasi
            $pendampingKeluargas = $query->paginate(10);
            $kelurahans = Kelurahan::where('kecamatan_id', $user->kecamatan_id)->get();
            $kecamatan = Kecamatan::find($user->kecamatan_id);
            $peranOptions = $this->peranOptions;
            $statusOptions = $this->statusOptions;

            // Log hasil query
            Log::info('Data pendamping keluarga diambil', [
                'tab' => $tab,
                'kecamatan_id' => $user->kecamatan_id,
                'kelurahan_id' => $kelurahan_id ?: 'none',
                'peran' => $peran ?: 'none',
                'status' => $status ?: 'none',
                'total' => $pendampingKeluargas->total(),
                'sample_data' => $pendampingKeluargas->take(3)->map(function($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'peran' => $item->peran,
                        'status' => $item->status,
                        'kartu_keluarga_ids' => $item->kartuKeluargas->pluck('id')->toArray()
                    ];
                })->toArray()
            ]);

            return view('kecamatan.pendamping_keluarga.index', compact(
                'pendampingKeluargas',
                'kecamatan',
                'kelurahans',
                'kelurahan_id',
                'peran',
                'status',
                'peranOptions',
                'statusOptions',
                'tab'
            ));
        } catch (\Exception $e) {
            Log::error('Gagal memuat data pendamping keluarga: ' . $e->getMessage(), [
                'request' => $request->all(),
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);

            return view('kecamatan.pendamping_keluarga.index', [
                'pendampingKeluargas' => collect([])->paginate(10),
                'kecamatan' => null,
                'kelurahans' => collect([]),
                'kelurahan_id' => '',
                'peran' => '',
                'status' => '',
                'peranOptions' => $this->peranOptions,
                'statusOptions' => $this->statusOptions,
                'tab' => $tab,
                'errorMessage' => 'Gagal memuat data pendamping keluarga: ' . $e->getMessage()
            ]);
        }
    }

    public function approve(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Admin kecamatan tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending'])->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $pendingPendamping = PendingPendampingKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status_verifikasi', 'pending')
            ->findOrFail($id);

        try {
            // Siapkan data untuk dipindahkan
            $data = $pendingPendamping->toArray();
            unset(
                $data['id'],
                $data['created_by'],
                $data['status_verifikasi'],
                $data['catatan'],
                $data['original_id'],
                $data['created_at'],
                $data['updated_at']
            );

            // Pindahkan foto ke storage permanen
            $fotoPath = $pendingPendamping->foto;
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                $newFotoPath = str_replace('pending_pendamping_fotos', 'pendamping_fotos', $fotoPath);
                Storage::disk('public')->move($fotoPath, $newFotoPath);
                $data['foto'] = $newFotoPath;
            }

            // Simpan atau perbarui ke tabel PendampingKeluarga
            $pendamping = PendampingKeluarga::updateOrCreate(
                ['id' => $pendingPendamping->original_id],
                $data
            );

            // Sinkronkan relasi kartu keluarga
            $kartuKeluargaIds = $pendingPendamping->kartuKeluargas()->pluck('kartu_keluargas.id')->toArray();
            $pendamping->kartuKeluargas()->sync($kartuKeluargaIds);

            // Tandai sebagai approved dan hapus dari pending
            $pendingPendamping->update(['status_verifikasi' => 'approved']);
            $pendingPendamping->delete();

            Log::info('Data pendamping keluarga disetujui', [
                'pending_id' => $id,
                'pendamping_id' => $pendamping->id,
                'kartu_keluarga_ids' => $kartuKeluargaIds,
                'user_id' => $user->id
            ]);

            return redirect()->route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending'])->with('success', 'Data Pendamping Keluarga berhasil disetujui dan dipindahkan ke data master.');
        } catch (\Exception $e) {
            Log::error('Error approving PendingPendampingKeluarga: ' . $e->getMessage(), [
                'id' => $id,
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending'])->with('error', 'Gagal menyetujui data Pendamping Keluarga: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->kecamatan_id) {
            Log::warning('Admin kecamatan tidak terkait dengan kecamatan.', ['user_id' => $user->id]);
            return redirect()->route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending'])->with('error', 'Admin kecamatan tidak terkait dengan kecamatan.');
        }

        $pendingPendamping = PendingPendampingKeluarga::where('kecamatan_id', $user->kecamatan_id)
            ->where('status_verifikasi', 'pending')
            ->findOrFail($id);

        try {
            $validated = $request->validate([
                'catatan' => ['required', 'string', 'max:1000'],
            ]);

            // Hapus foto jika ada
            if ($pendingPendamping->foto && Storage::disk('public')->exists($pendingPendamping->foto)) {
                Storage::disk('public')->delete($pendingPendamping->foto);
            }

            // Tandai sebagai rejected dan simpan catatan
            $pendingPendamping->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $validated['catatan'],
            ]);
            $pendingPendamping->delete();

            Log::info('Data pendamping keluarga ditolak', [
                'pending_id' => $id,
                'catatan' => $validated['catatan'],
                'user_id' => $user->id
            ]);

            return redirect()->route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending'])->with('success', 'Data Pendamping Keluarga ditolak dan dihapus.');
        } catch (\Exception $e) {
            Log::error('Error rejecting PendingPendampingKeluarga: ' . $e->getMessage(), [
                'id' => $id,
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending'])->with('error', 'Gagal menolak data Pendamping Keluarga: ' . $e->getMessage());
        }
    }
}