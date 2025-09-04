<?php
namespace App\Http\Controllers;

use App\Models\TentangKami;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangKamiController extends Controller
{
    public function index()
    {
        $tentangKami = TentangKami::first();
        return view('master.tentang_kami.index', compact('tentangKami'));
    }

    public function create()
    {
        if (TentangKami::exists()) {
            return redirect()->route('tentang_kami.index')->with('error', 'Data Tentang Kami sudah ada. Silakan edit data yang ada.');
        }
        return view('master.tentang_kami.create');
    }

    public function store(Request $request)
    {
        if (TentangKami::exists()) {
            return redirect()->route('tentang_kami.index')->with('error', 'Data Tentang Kami sudah ada. Silakan edit data yang ada.');
        }

        $request->validate([
            'sub_judul' => ['required', 'string', 'max:255'],
            'judul_utama' => ['required', 'string', 'max:255'],
            'paragraf_1' => ['required', 'string'],
            'paragraf_2' => ['nullable', 'string'],
            'teks_tombol' => ['nullable', 'string', 'max:100'],
            'link_tombol' => ['nullable', 'string', 'max:255', 'url'],
            'gambar_utama' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
            'gambar_overlay' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
        ]);

        $data = $request->all();
        $data['gambar_utama'] = $request->file('gambar_utama')->store('tentang_kami', 'public');
        if ($request->hasFile('gambar_overlay')) {
            $data['gambar_overlay'] = $request->file('gambar_overlay')->store('tentang_kami', 'public');
        }
        $data['tanggal_update'] = now();

        TentangKami::create($data);

        return redirect()->route('tentang_kami.index')->with('success', 'Data Tentang Kami berhasil ditambahkan.');
    }

    public function edit()
    {
        $tentangKami = TentangKami::first();
        if (!$tentangKami) {
            return redirect()->route('tentang_kami.create')->with('error', 'Data Tentang Kami belum ada. Silakan tambah data.');
        }
        return view('master.tentang_kami.edit', compact('tentangKami'));
    }

    public function update(Request $request)
    {
        $tentangKami = TentangKami::first();
        if (!$tentangKami) {
            return redirect()->route('tentang_kami.create')->with('error', 'Data Tentang Kami belum ada. Silakan tambah data.');
        }

        $request->validate([
            'sub_judul' => ['required', 'string', 'max:255'],
            'judul_utama' => ['required', 'string', 'max:255'],
            'paragraf_1' => ['required', 'string'],
            'paragraf_2' => ['nullable', 'string'],
            'teks_tombol' => ['nullable', 'string', 'max:100'],
            'link_tombol' => ['nullable', 'string', 'max:255', 'url'],
            'gambar_utama' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
            'gambar_overlay' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10000'],
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar_utama')) {
            Storage::disk('public')->delete($tentangKami->gambar_utama);
            $data['gambar_utama'] = $request->file('gambar_utama')->store('tentang_kami', 'public');
        } else {
            $data['gambar_utama'] = $tentangKami->gambar_utama;
        }
        if ($request->hasFile('gambar_overlay')) {
            if ($tentangKami->gambar_overlay) {
                Storage::disk('public')->delete($tentangKami->gambar_overlay);
            }
            $data['gambar_overlay'] = $request->file('gambar_overlay')->store('tentang_kami', 'public');
        } elseif ($request->input('remove_gambar_overlay')) {
            if ($tentangKami->gambar_overlay) {
                Storage::disk('public')->delete($tentangKami->gambar_overlay);
            }
            $data['gambar_overlay'] = null;
        } else {
            $data['gambar_overlay'] = $tentangKami->gambar_overlay;
        }
        $data['tanggal_update'] = now();

        $tentangKami->update($data);

        return redirect()->route('tentang_kami.index')->with('success', 'Data Tentang Kami berhasil diperbarui.');
    }
}