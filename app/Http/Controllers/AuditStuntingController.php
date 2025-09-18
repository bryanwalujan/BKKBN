<?php

namespace App\Http\Controllers;

use App\Models\AuditStunting;
use App\Models\DataMonitoring;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuditStuntingController extends Controller
{
    public function index(Request $request)
    {
        $kelurahan_id = $request->query('kelurahan_id');
        $kecamatan_id = $request->query('kecamatan_id');
        $query = AuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan', 'user'])
            ->orderBy('created_at', 'desc');

        if ($kecamatan_id) {
            $query->whereHas('dataMonitoring', function ($q) use ($kecamatan_id) {
                $q->where('kecamatan_id', $kecamatan_id);
            });
        }
        if ($kelurahan_id) {
            $query->whereHas('dataMonitoring', function ($q) use ($kelurahan_id) {
                $q->where('kelurahan_id', $kelurahan_id);
            });
        }

        $auditStuntings = $query->paginate(10);
        $kecamatans = Kecamatan::all();
        $kelurahans = $kecamatan_id ? Kelurahan::where('kecamatan_id', $kecamatan_id)->get() : collect([]);

        return view('master.audit_stunting.index', compact(
            'auditStuntings',
            'kecamatans',
            'kelurahans',
            'kecamatan_id',
            'kelurahan_id'
        ));
    }

    public function create(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $data_monitoring_id = $request->query('data_monitoring_id');
        $dataMonitoring = $data_monitoring_id ? DataMonitoring::with(['kecamatan', 'kelurahan', 'kartuKeluarga'])->find($data_monitoring_id) : null;
        $kelurahans = $dataMonitoring ? Kelurahan::where('kecamatan_id', $dataMonitoring->kecamatan_id)->get() : collect([]);
        $users = User::all();
        return view('master.audit_stunting.create', compact('kecamatans', 'dataMonitoring', 'kelurahans', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_monitoring_id' => ['required', 'exists:data_monitorings,id'],
            'user_id' => ['required', 'exists:users,id'],
            'foto_dokumentasi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'pihak_pengaudit' => ['nullable', 'string', 'max:255'],
            'laporan' => ['nullable', 'string'],
            'narasi' => ['nullable', 'string'],
        ]);

        try {
            if ($request->hasFile('foto_dokumentasi')) {
                $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('audit_stunting', 'public');
            }

            AuditStunting::create($validated);
            return redirect()->route('audit_stunting.index')->with('success', 'Data Audit Stunting berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('Error storing AuditStunting: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Audit Stunting: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $auditStunting = AuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan'])->findOrFail($id);
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::where('kecamatan_id', $auditStunting->dataMonitoring->kecamatan_id)->get();
        $users = User::all();
        return view('master.audit_stunting.edit', compact('auditStunting', 'kecamatans', 'kelurahans', 'users'));
    }

    public function update(Request $request, $id)
    {
        $auditStunting = AuditStunting::findOrFail($id);

        $validated = $request->validate([
            'data_monitoring_id' => ['required', 'exists:data_monitorings,id'],
            'user_id' => ['required', 'exists:users,id'],
            'foto_dokumentasi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'pihak_pengaudit' => ['nullable', 'string', 'max:255'],
            'laporan' => ['nullable', 'string'],
            'narasi' => ['nullable', 'string'],
        ]);

        try {
            if ($request->hasFile('foto_dokumentasi')) {
                // Hapus foto lama jika ada
                if ($auditStunting->foto_dokumentasi) {
                    Storage::disk('public')->delete($auditStunting->foto_dokumentasi);
                }
                $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('audit_stunting', 'public');
            }

            $auditStunting->update($validated);
            return redirect()->route('audit_stunting.index')->with('success', 'Data Audit Stunting berhasil diperbarui.');
        } catch (\Exception $e) {
            \Log::error('Error updating AuditStunting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data Audit Stunting: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $auditStunting = AuditStunting::findOrFail($id);
            if ($auditStunting->foto_dokumentasi) {
                Storage::disk('public')->delete($auditStunting->foto_dokumentasi);
            }
            $auditStunting->delete();
            return redirect()->route('audit_stunting.index')->with('success', 'Data Audit Stunting berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error deleting AuditStunting: ' . $e->getMessage(), ['id' => $id]);
            return redirect()->route('audit_stunting.index')->with('error', 'Gagal menghapus data Audit Stunting: ' . $e->getMessage());
        }
    }
}