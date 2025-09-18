<?php
namespace App\Http\Controllers;

use App\Models\Genting;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GentingController extends Controller
{
    public function index()
    {
        $gentings = Genting::with('kartuKeluarga')->get();
        return view('master.genting.index', compact('gentings'));
    }

    public function create()
    {
        $kartuKeluargas = KartuKeluarga::all();
        return view('master.genting.create', compact('kartuKeluargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'sasaran' => ['required', 'string', 'max:255'],
            'jenis_intervensi' => ['required', 'string', 'max:255'],
            'narasi' => ['nullable', 'string'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
            'dunia_usaha' => ['nullable', 'in:ada,tidak'],
            'dunia_usaha_frekuensi' => ['nullable', 'string', 'max:255'],
            'pemerintah' => ['nullable', 'in:ada,tidak'],
            'pemerintah_frekuensi' => ['nullable', 'string', 'max:255'],
            'bumn_bumd' => ['nullable', 'in:ada,tidak'],
            'bumn_bumd_frekuensi' => ['nullable', 'string', 'max:255'],
            'individu_perseorangan' => ['nullable', 'in:ada,tidak'],
            'individu_perseorangan_frekuensi' => ['nullable', 'string', 'max:255'],
            'lsm_komunitas' => ['nullable', 'in:ada,tidak'],
            'lsm_komunitas_frekuensi' => ['nullable', 'string', 'max:255'],
            'swasta' => ['nullable', 'in:ada,tidak'],
            'swasta_frekuensi' => ['nullable', 'string', 'max:255'],
            'perguruan_tinggi_akademisi' => ['nullable', 'in:ada,tidak'],
            'perguruan_tinggi_akademisi_frekuensi' => ['nullable', 'string', 'max:255'],
            'media' => ['nullable', 'in:ada,tidak'],
            'media_frekuensi' => ['nullable', 'string', 'max:255'],
            'tim_pendamping_keluarga' => ['nullable', 'in:ada,tidak'],
            'tim_pendamping_keluarga_frekuensi' => ['nullable', 'string', 'max:255'],
            'tokoh_masyarakat' => ['nullable', 'in:ada,tidak'],
            'tokoh_masyarakat_frekuensi' => ['nullable', 'string', 'max:255'],
        ]);

        $data = $request->all();

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('genting_dokumentasi', 'public');
        }

        Genting::create($data);

        return redirect()->route('genting.index')->with('success', 'Data kegiatan Genting berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $genting = Genting::findOrFail($id);
        $kartuKeluargas = KartuKeluarga::all();
        return view('master.genting.edit', compact('genting', 'kartuKeluargas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kartu_keluarga_id' => ['required', 'exists:kartu_keluargas,id'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'sasaran' => ['required', 'string', 'max:255'],
            'jenis_intervensi' => ['required', 'string', 'max:255'],
            'narasi' => ['nullable', 'string'],
            'dokumentasi' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:7000'],
            'dunia_usaha' => ['nullable', 'in:ada,tidak'],
            'dunia_usaha_frekuensi' => ['nullable', 'string', 'max:255'],
            'pemerintah' => ['nullable', 'in:ada,tidak'],
            'pemerintah_frekuensi' => ['nullable', 'string', 'max:255'],
            'bumn_bumd' => ['nullable', 'in:ada,tidak'],
            'bumn_bumd_frekuensi' => ['nullable', 'string', 'max:255'],
            'individu_perseorangan' => ['nullable', 'in:ada,tidak'],
            'individu_perseorangan_frekuensi' => ['nullable', 'string', 'max:255'],
            'lsm_komunitas' => ['nullable', 'in:ada,tidak'],
            'lsm_komunitas_frekuensi' => ['nullable', 'string', 'max:255'],
            'swasta' => ['nullable', 'in:ada,tidak'],
            'swasta_frekuensi' => ['nullable', 'string', 'max:255'],
            'perguruan_tinggi_akademisi' => ['nullable', 'in:ada,tidak'],
            'perguruan_tinggi_akademisi_frekuensi' => ['nullable', 'string', 'max:255'],
            'media' => ['nullable', 'in:ada,tidak'],
            'media_frekuensi' => ['nullable', 'string', 'max:255'],
            'tim_pendamping_keluarga' => ['nullable', 'in:ada,tidak'],
            'tim_pendamping_keluarga_frekuensi' => ['nullable', 'string', 'max:255'],
            'tokoh_masyarakat' => ['nullable', 'in:ada,tidak'],
            'tokoh_masyarakat_frekuensi' => ['nullable', 'string', 'max:255'],
        ]);

        $genting = Genting::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('dokumentasi')) {
            if ($genting->dokumentasi) {
                Storage::disk('public')->delete($genting->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('genting_dokumentasi', 'public');
        }

        $genting->update($data);

        return redirect()->route('genting.index')->with('success', 'Data kegiatan Genting berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $genting = Genting::findOrFail($id);
        if ($genting->dokumentasi) {
            Storage::disk('public')->delete($genting->dokumentasi);
        }
        $genting->delete();

        return redirect()->route('genting.index')->with('success', 'Data kegiatan Genting berhasil dihapus.');
    }
}