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
use Illuminate\Support\Facades\Log;

class AuditStuntingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $kelurahan_id = $request->query('kelurahan_id');
        $kecamatan_id = $request->query('kecamatan_id');
        $search = $request->query('search');

        $query = AuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan', 'user', 'createdBy'])
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
        if ($search) {
            $query->whereHas('dataMonitoring', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
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
            'kelurahan_id',
            'search'
        ));
    }

    public function create(Request $request)
    {
        $kecamatans = Kecamatan::all();
        $data_monitoring_id = $request->query('data_monitoring_id');
        $dataMonitoring = $data_monitoring_id ? DataMonitoring::with(['kecamatan', 'kelurahan', 'kartuKeluarga'])->find($data_monitoring_id) : null;
        $kelurahans = $dataMonitoring ? Kelurahan::where('kecamatan_id', $dataMonitoring->kecamatan_id)->get() : collect([]);
        return view('master.audit_stunting.create', compact('kecamatans', 'dataMonitoring', 'kelurahans'));
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
            $validated['created_by'] = Auth::id();
            if ($request->hasFile('foto_dokumentasi')) {
                $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('audit_stunting', 'public');
            }

            $auditStunting = AuditStunting::create($validated);
            Log::info('Data Audit Stunting berhasil ditambahkan.', ['id' => $auditStunting->id, 'user_id' => Auth::id()]);
            return redirect()->route('audit_stunting.index')->with('success', 'Data Audit Stunting berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data Audit Stunting: ' . $e->getMessage(), ['data' => $request->all(), 'user_id' => Auth::id()]);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Audit Stunting: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $auditStunting = AuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan', 'user', 'createdBy'])->findOrFail($id);
        return view('master.audit_stunting.show', compact('auditStunting'));
    }

    public function edit($id)
    {
        $auditStunting = AuditStunting::with(['dataMonitoring', 'dataMonitoring.kartuKeluarga', 'dataMonitoring.kecamatan', 'dataMonitoring.kelurahan'])->findOrFail($id);
        $kecamatans = Kecamatan::all();
        $kelurahans = $auditStunting->dataMonitoring->kecamatan_id ? Kelurahan::where('kecamatan_id', $auditStunting->dataMonitoring->kecamatan_id)->get() : collect([]);
        return view('master.audit_stunting.edit', compact('auditStunting', 'kecamatans', 'kelurahans'));
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
            $validated['created_by'] = $auditStunting->created_by ?: Auth::id();
            if ($request->hasFile('foto_dokumentasi')) {
                if ($auditStunting->foto_dokumentasi) {
                    Storage::disk('public')->delete($auditStunting->foto_dokumentasi);
                }
                $validated['foto_dokumentasi'] = $request->file('foto_dokumentasi')->store('audit_stunting', 'public');
            } else {
                $validated['foto_dokumentasi'] = $auditStunting->foto_dokumentasi;
            }

            $auditStunting->update($validated);
            Log::info('Data Audit Stunting berhasil diperbarui.', ['id' => $id, 'user_id' => Auth::id()]);
            return redirect()->route('audit_stunting.index')->with('success', 'Data Audit Stunting berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui data Audit Stunting: ' . $e->getMessage(), ['id' => $id, 'data' => $request->all(), 'user_id' => Auth::id()]);
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
            Log::info('Data Audit Stunting berhasil dihapus.', ['id' => $id, 'user_id' => Auth::id()]);
            return redirect()->route('audit_stunting.index')->with('success', 'Data Audit Stunting berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data Audit Stunting: ' . $e->getMessage(), ['id' => $id, 'user_id' => Auth::id()]);
            return redirect()->route('audit_stunting.index')->with('error', 'Gagal menghapus data Audit Stunting: ' . $e->getMessage());
        }
    }
}