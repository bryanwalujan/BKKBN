<?php
namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::all();
        return view('master.templates', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:docx', 'max:2048'],
        ]);

        $filePath = $request->file('file')->store('templates', 'public');

        Template::create([
            'name' => $request->name,
            'file_path' => $filePath,
        ]);

        return redirect()->route('templates.index')->with('success', 'Template berhasil diupload.');
    }

    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        Storage::disk('public')->delete($template->file_path);
        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Template berhasil dihapus.');
    }
}