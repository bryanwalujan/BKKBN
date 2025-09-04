<?php
namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::all();
        return view('master.carousel.index', compact('carousels'));
    }

    public function create()
    {
        return view('master.carousel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_heading' => ['required', 'string', 'max:255'],
            'heading' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'button_1_text' => ['nullable', 'string', 'max:100'],
            'button_1_link' => ['nullable', 'string', 'max:255', 'url'],
            'button_2_text' => ['nullable', 'string', 'max:100'],
            'button_2_link' => ['nullable', 'string', 'max:255', 'url'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:7000'],
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('carousel_gambar', 'public');
        }

        Carousel::create($data);

        return redirect()->route('carousel.index')->with('success', 'Data Carousel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $carousel = Carousel::findOrFail($id);
        return view('master.carousel.edit', compact('carousel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_heading' => ['required', 'string', 'max:255'],
            'heading' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'button_1_text' => ['nullable', 'string', 'max:100'],
            'button_1_link' => ['nullable', 'string', 'max:255', 'url'],
            'button_2_text' => ['nullable', 'string', 'max:100'],
            'button_2_link' => ['nullable', 'string', 'max:255', 'url'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:7000'],
        ]);

        $carousel = Carousel::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($carousel->gambar) {
                Storage::disk('public')->delete($carousel->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('carousel_gambar', 'public');
        }

        $carousel->update($data);

        return redirect()->route('carousel.index')->with('success', 'Data Carousel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);
        if ($carousel->gambar) {
            Storage::disk('public')->delete($carousel->gambar);
        }
        $carousel->delete();

        return redirect()->route('carousel.index')->with('success', 'Data Carousel berhasil dihapus.');
    }
}