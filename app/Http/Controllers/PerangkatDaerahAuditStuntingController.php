<?php

namespace App\Http\Controllers;

use App\Models\AuditStunting;
use App\Models\PendingAuditStunting;
use App\Models\DataMonitoring;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerangkatDaerahAuditStuntingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:perangkat_daerah');
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'verified');
        $kelurahan_id = $request->query('kelurahan_id');
        $kecamatan_id = Auth::user()->kecamatan_id;

        if ($tab == 'pending') {
            $query = PendingAuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan', 'user', 'createdBy'])
                ->where('created_by', Auth::id())
                ->where('status_verifikasi', 'pending')
                ->whereHas('dataMonitoring', function ($q) use ($kecamatan_id) {
                    $q->where('kecamatan_id', $kecamatan_id);
                });
        } else {
            $query = AuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan', 'user'])
                ->whereHas('dataMonitoring', function ($q) use ($kecamatan_id) {
                    $q->where('kecamatan_id', $kecamatan_id);
                });
        }

        if ($kelurahan_id) {
            $query->whereHas('dataMonitoring', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
            });
        }

        $auditStuntings = $query->orderBy('created_at', 'desc')->paginate(10);
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        $kecamatan = Kecamatan::find($kecamatan_id);

        return view('perangkat_daerah.audit_stunting.index', compact(
            'auditStuntings',
            'kecamatan',
            'kelurahans',
            'kelurahan_id',
            'tab'
        ));
    }

    public function create(Request $request)
    {
        $kecamatan_id = Auth::user()->kecamatan_id;
        $kecamatan = Kecamatan::find($kecamatan_id);
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        $data_monitoring_id = $request->query('data_monitoring_id');
        $dataMonitoring = $data_monitoring_id ? DataMonitoring::with(['kecamatan', 'kelurahan', 'kartuKeluarga'])
            ->where('kecamatan_id', $kecamatan_id)
            ->find($data_monitoring_id) : null;

        return view('perangkat_daerah.audit_stunting.create', compact('kecamatan', 'kelurahans', 'dataMonitoring'));
    }

    public function store(Request $request)
    {
        $kecamatan_id = Auth::user()->kecamatan_id;

        $validated = $request->validate([
            'data_monitoring_id' => ['required', 'exists:data_monitorings,id,kecamatan_id,' . $kecamatan_id],
            'kelurahan_id' => ['required', 'exists:kelurahans,id,kecamatan_id,' . $kecamatan_id],
            'pihak_pengaudit' => ['nullable', 'string', 'max:255'],
            'foto_dokumentasi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'laporan' => ['nullable', 'string'],
            'narasi' => ['nullable', 'string'],
        ]);

        try {
            if ($request->hasFile('foto_dokumentasi')) {
                $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('audit_stunting', 'public');
            }

            $validated['user_id'] = Auth::id();
            $validated['created_by'] = Auth::id();
            $validated['status_verifikasi'] = 'pending';

            PendingAuditStunting::create($validated);
            return redirect()->route('perangkat_daerah.audit_stunting.index', ['tab' => 'pending'])
                ->with('success', 'Data Audit Stunting berhasil diajukan dan menunggu verifikasi.');
        } catch (\Exception $e) {
            \Log::error('Error storing PendingAuditStunting: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan data Audit Stunting: ' . $e->getMessage());
        }
    }

    public function edit($id, $source)
    {
        $kecamatan_id = Auth::user()->kecamatan_id;
        $kecamatan = Kecamatan::find($kecamatan_id);
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();

        if ($source == 'pending') {
            $auditStunting = PendingAuditStunting::where('created_by', Auth::id())
                ->where('status_verifikasi', 'pending')
                ->findOrFail($id);
        } else {
            $auditStunting = AuditStunting::findOrFail($id);
        }

        $dataMonitoring = DataMonitoring::where('kecamatan_id', $kecamatan_id)
            ->findOrFail($auditStunting->data_monitoring_id);

        return view('perangkat_daerah.audit_stunting.edit', compact('auditStunting', 'kecamatan', 'kelurahans', 'dataMonitoring', 'source'));
    }

    public function update(Request $request, $id, $source)
    {
        $kecamatan_id = Auth::user()->kecamatan_id;

        $validated = $request->validate([
            'data_monitoring_id' => ['required', 'exists:data_monitorings,id,kecamatan_id,' . $kecamatan_id],
            'kelurahan_id' => ['required', 'exists:kelurahans,id,kecamatan_id,' . $kecamatan_id],
            'pihak_pengaudit' => ['nullable', 'string', 'max:255'],
            'foto_dokumentasi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'laporan' => ['nullable', 'string'],
            'narasi' => ['nullable', 'string'],
        ]);

        try {
            if ($source == 'pending') {
                $auditStunting = PendingAuditStunting::where('created_by', Auth::id())
                    ->where('status_verifikasi', 'pending')
                    ->findOrFail($id);
                if ($request->hasFile('foto_dokumentasi')) {
                    if ($auditStunting->foto_dokumentasi) {
                        Storage::disk('public')->delete($auditStunting->foto_dokumentasi);
                    }
                    $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('audit_stunting', 'public');
                }
                $auditStunting->update($validated);
                $message = 'Data Audit Stunting berhasil diperbarui dan menunggu verifikasi.';
            } else {
                $original = AuditStunting::findOrFail($id);
                if ($request->hasFile('foto_dokumentasi')) {
                    if ($original->foto_dokumentasi) {
                        Storage::disk('public')->delete($original->foto_dokumentasi);
                    }
                    $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('audit_stunting', 'public');
                }
                $validated['user_id'] = Auth::id();
                $validated['created_by'] = Auth::id();
                $validated['status_verifikasi'] = 'pending';
                $validated['original_id'] = $id;
                PendingAuditStunting::create($validated);
                $message = 'Perubahan Data Audit Stunting berhasil diajukan untuk verifikasi.';
            }

            return redirect()->route('perangkat_daerah.audit_stunting.index', ['tab' => 'pending'])
                ->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Error updating AuditStunting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data Audit Stunting: ' . $e->getMessage());
        }
    }

    public function destroy($id, $source)
    {
        if ($source == 'verified') {
            return redirect()->route('perangkat_daerah.audit_stunting.index', ['tab' => 'verified'])
                ->with('error', 'Data Audit Stunting yang sudah terverifikasi tidak dapat dihapus.');
        }

        try {
            $auditStunting = PendingAuditStunting::where('created_by', Auth::id())
                ->where('status_verifikasi', 'pending')
                ->findOrFail($id);
            if ($auditStunting->foto_dokumentasi) {
                Storage::disk('public')->delete($auditStunting->foto_dokumentasi);
            }
            $auditStunting->delete();
            return redirect()->route('perangkat_daerah.audit_stunting.index', ['tab' => 'pending'])
                ->with('success', 'Data Audit Stunting berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error deleting PendingAuditStunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('perangkat_daerah.audit_stunting.index', ['tab' => 'pending'])
                ->with('error', 'Gagal menghapus data Audit Stunting: ' . $e->getMessage());
        }
    }

    public function getDataMonitoringByKecamatan($kecamatan_id)
    {
        if (Auth::user()->kecamatan_id != $kecamatan_id) {
            return response()->json(['error' => 'Akses ditolak'], 403);
        }

        $dataMonitorings = DataMonitoring::where('kecamatan_id', $kecamatan_id)
            ->get(['id', 'nama', 'target', 'kategori']);
        return response()->json($dataMonitorings);
    }

    public function getKelurahanByDataMonitoring($id)
    {
        $kecamatan_id = Auth::user()->kecamatan_id;
        $dataMonitoring = DataMonitoring::where('kecamatan_id', $kecamatan_id)
            ->findOrFail($id);

        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)
            ->get(['id', 'nama_kelurahan'])
            ->map(function ($kelurahan) {
                return [
                    'id' => $kelurahan->id,
                    'text' => $kelurahan->nama_kelurahan
                ];
            });

        return response()->json([
            'kelurahan_id' => $dataMonitoring->kelurahan_id,
            'kelurahans' => $kelurahans
        ]);
    }
}