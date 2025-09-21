<?php

namespace App\Http\Controllers;

use App\Models\AuditStunting;
use App\Models\PendingAuditStunting;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KecamatanAuditStuntingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin_kecamatan');
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'pending');
        $kelurahan_id = $request->query('kelurahan_id');
        $kecamatan_id = Auth::user()->kecamatan_id;

        if ($tab == 'pending') {
            $query = PendingAuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan', 'user', 'createdBy'])
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

        return view('kecamatan.audit_stunting.index', compact(
            'auditStuntings',
            'kecamatan',
            'kelurahans',
            'kelurahan_id',
            'tab'
        ));
    }

    public function approve($id)
    {
        $pendingAudit = PendingAuditStunting::whereHas('dataMonitoring', function ($q) {
            $q->where('kecamatan_id', Auth::user()->kecamatan_id);
        })->findOrFail($id);

        if ($pendingAudit->status_verifikasi != 'pending') {
            return redirect()->route('kecamatan.audit_stunting.index', ['tab' => 'pending'])
                ->with('error', 'Data ini sudah diverifikasi.');
        }

        try {
            $data = [
                'data_monitoring_id' => $pendingAudit->data_monitoring_id,
                'user_id' => $pendingAudit->user_id,
                'foto_dokumentasi' => $pendingAudit->foto_dokumentasi,
                'pihak_pengaudit' => $pendingAudit->pihak_pengaudit,
                'laporan' => $pendingAudit->laporan,
                'narasi' => $pendingAudit->narasi,
            ];

            if ($pendingAudit->original_id) {
                $original = AuditStunting::findOrFail($pendingAudit->original_id);
                if ($original->foto_dokumentasi && $data['foto_dokumentasi'] != $original->foto_dokumentasi) {
                    Storage::disk('public')->delete($original->foto_dokumentasi);
                }
                $original->update($data);
            } else {
                AuditStunting::create($data);
            }

            $pendingAudit->update(['status_verifikasi' => 'approved']);
            return redirect()->route('kecamatan.audit_stunting.index', ['tab' => 'pending'])
                ->with('success', 'Data Audit Stunting berhasil disetujui.');
        } catch (\Exception $e) {
            \Log::error('Error approving AuditStunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.audit_stunting.index', ['tab' => 'pending'])
                ->with('error', 'Gagal menyetujui data Audit Stunting: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $pendingAudit = PendingAuditStunting::whereHas('dataMonitoring', function ($q) {
            $q->where('kecamatan_id', Auth::user()->kecamatan_id);
        })->findOrFail($id);

        if ($pendingAudit->status_verifikasi != 'pending') {
            return redirect()->route('kecamatan.audit_stunting.index', ['tab' => 'pending'])
                ->with('error', 'Data ini sudah diverifikasi.');
        }

        $validated = $request->validate([
            'catatan' => ['required', 'string'],
        ]);

        try {
            if ($pendingAudit->foto_dokumentasi) {
                Storage::disk('public')->delete($pendingAudit->foto_dokumentasi);
            }
            $pendingAudit->update([
                'status_verifikasi' => 'rejected',
                'catatan' => $validated['catatan'],
            ]);
            return redirect()->route('kecamatan.audit_stunting.index', ['tab' => 'pending'])
                ->with('success', 'Data Audit Stunting berhasil ditolak.');
        } catch (\Exception $e) {
            \Log::error('Error rejecting AuditStunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('kecamatan.audit_stunting.index', ['tab' => 'pending'])
                ->with('error', 'Gagal menolak data Audit Stunting: ' . $e->getMessage());
        }
    }
}