<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = ['master', 'admin_kelurahan', 'perangkat_daerah'];
        $role = $request->query('role', '');
        $kecamatan_id = $request->query('kecamatan_id', '');
        $kelurahan_id = $request->query('kelurahan_id', '');

        $query = User::query()->with(['kecamatan', 'kelurahan']);
        if ($role) {
            $query->where('role', $role);
        }
        if ($kecamatan_id) {
            $query->where('kecamatan_id', $kecamatan_id);
        }
        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }

        $users = $query->paginate(10);
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();

         // Log untuk debugging path pas_foto
        foreach ($users as $user) {
            if ($user->pas_foto && !Storage::disk('public')->exists($user->pas_foto)) {
                Log::warning('Pas foto tidak ditemukan di storage: ' . $user->pas_foto, [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);
            }
        }

        return view('master.users.index', compact('users', 'roles', 'role', 'kecamatan_id', 'kelurahan_id', 'kecamatans', 'kelurahans'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:master,admin_kelurahan,perangkat_daerah'],
            'kecamatan_id' => ['nullable', 'exists:kecamatans,id'],
            'kelurahan_id' => ['nullable', 'exists:kelurahans,id'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'pas_foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:7000'],
        ]);

        $data = $request->only(['name', 'email', 'role', 'kecamatan_id', 'kelurahan_id', 'penanggung_jawab', 'no_telepon']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('pas_foto')) {
            $path = $request->file('pas_foto')->store('pas_foto', 'public');
            $data['pas_foto'] = basename($path);
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = ['master', 'admin_kelurahan', 'perangkat_daerah'];
        $kecamatans = Kecamatan::all();
        $kelurahans = Kelurahan::all();

        return view('master.users.edit', compact('user', 'roles', 'kecamatans', 'kelurahans'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:master,admin_kelurahan,perangkat_daerah'],
            'kecamatan_id' => ['nullable', 'exists:kecamatans,id'],
            'kelurahan_id' => ['nullable', 'exists:kelurahans,id'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'pas_foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:7000'],
        ]);

        $data = $request->only(['name', 'email', 'role', 'kecamatan_id', 'kelurahan_id', 'penanggung_jawab', 'no_telepon']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('pas_foto')) {
            if ($user->pas_foto) {
                Storage::disk('public')->delete('pas_foto/' . $user->pas_foto);
            }
            $path = $request->file('pas_foto')->store('pas_foto', 'public');
            $data['pas_foto'] = basename($path);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        if ($user->pas_foto) {
            Storage::disk('public')->delete('pas_foto/' . $user->pas_foto);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}