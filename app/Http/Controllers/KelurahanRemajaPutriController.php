<?php
namespace App\Http\Controllers;

use App\Models\PendingRemajaPutri;
use App\Models\RemajaPutri;
use App\Models\KartuKeluarga;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class KelurahanRemajaPutriController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $kelurahan_id = $user->kelurahan_id;

        if (!$kelurahan_id) {
            return redirect()->route('dashboard')->with('error', 'Admin kelurahan tidak terkait dengan kelurahan.');
        }

        $search = $request->query('search');
        $tab = $request->query('tab', 'pending');

        // Query untuk PendingRemajaPutri
        $pendingQuery = PendingRemajaPutri::with(['kartuKeluarga', 'kecamatan', 'kelurahan', 'createdBy'])
            ->where('kelurahan_id', $kelurahan_id)
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
            ->where('kelurahan_id', $kelurahan_id);

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
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        return view('kelurahan.remaja_putri.create', compact('kecamatans', 'kelurahans', 'kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $data['status'] = 'pending';
            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('pending_remaja_putri_fotos', 'public');
            }
            PendingRemajaPutri::create($data);
            return redirect()->route('kelurahan.remaja_putri.index')->with('success', 'Data remaja putri berhasil diajukan untuk verifikasi.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan data remaja putri: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan data remaja putri: ' . $e->getMessage());
        }
    }

    public function edit($id, $source = 'pending')
    {
        if ($source === 'verified') {
            $remajaPutri = RemajaPutri::where('kelurahan_id', Auth::user()->kelurahan_id)->findOrFail($id);
        } else {
            $remajaPutri = PendingRemajaPutri::where('created_by', Auth::id())->findOrFail($id);
        }
        $kecamatans = Kecamatan::all();
        $kelurahans = $remajaPutri->kecamatan_id ? Kelurahan::where('kecamatan_id', $remajaPutri->kecamatan_id)->get() : collect([]);
        $kartuKeluargas = KartuKeluarga::where('status', 'Aktif')->get();
        return view('kelurahan.remaja_putri.edit', compact('remajaPutri', 'kecamatans', 'kelurahans', 'kartuKeluargas', 'source'));
    }

    public function update(Request $request, $id, $source = 'pending')
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kelurahan_id' => ['required', 'exists:kelurahans,id'],
            'sekolah' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:50'],
            'umur' => ['required', 'integer', 'min:10', 'max:19'],
            'status_anemia' => ['required', 'in:Tidak Anemia,Anemia Ringan,Anemia Sedang,Anemia Berat'],
            'konsumsi_ttd' => ['required', 'in:Rutin,Tidak Rutin,Tidak Konsumsi'],
            'foto' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:10000'],
        ]);

        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();
            $data['status'] = 'pending';

            if ($source === 'verified') {
                if ($request->hasFile('foto')) {
                    $data['foto'] = $request->file('foto')->store('pending_remaja_putri_fotos', 'public');
                } else {
                    $remajaPutri = RemajaPutri::where('kelurahan_id', Auth::user()->kelurahan_id)->findOrFail($id);
                    if ($remajaPutri->foto) {
                        $fileName = basename($remajaPutri->foto);
                        $newPath = 'pending_remaja_putri_fotos/' . $fileName;
                        Storage::disk('public')->copy($remajaPutri->foto, $newPath);
                        $data['foto'] = $newPath;
                    }
                }
                PendingRemajaPutri::create($data);
                $message = 'Perubahan data remaja putri berhasil diajukan untuk verifikasi.';
            } else {
                $remajaPutri = PendingRemajaPutri::where('created_by', Auth::id())->findOrFail($id);
                if ($request->hasFile('foto')) {
                    if ($remajaPutri->foto) {
                        Storage::disk('public')->delete($remajaPutri->foto);
                    }
                    $data['foto'] = $request->file('foto')->store('pending_remaja_putri_fotos', 'public');
                }
                $remajaPutri->update($data);
                $message = 'Data remaja putri berhasil diperbarui dan diajukan untuk verifikasi.';
            }

            return redirect()->route('kelurahan.remaja_putri.index')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data remaja putri: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data remaja putri: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $remajaPutri = PendingRemajaPutri::where('created_by', Auth::id())->findOrFail($id);
            if ($remajaPutri->foto) {
                Storage::disk('public')->delete($remajaPutri->foto);
            }
            $remajaPutri->delete();
            return redirect()->route('kelurahan.remaja_putri.index')->with('success', 'Data remaja putri berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data remaja putri: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kelurahan.remaja_putri.index')->with('error', 'Gagal menghapus data remaja putri: ' . $e->getMessage());
        }
    }
}