<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $kelurahan_id = $request->query('kelurahan_id');
        $query = User::with('kelurahan');

        if ($role) {
            $query->where('role', $role);
        }
        if ($kelurahan_id) {
            $query->where('kelurahan_id', $kelurahan_id);
        }

        $users = $query->paginate(10);
        $kelurahans = Kelurahan::all();
        $roles = ['master', 'admin_kelurahan', 'perangkat_daerah'];

        return view('master.users.index', compact('users', 'kelurahans', 'roles', 'role', 'kelurahan_id'));
    }

    public function edit($id)
    {
        $user = User::with('kelurahan')->findOrFail($id);
        $kelurahans = Kelurahan::all();
        $roles = ['master', 'admin_kelurahan', 'perangkat_daerah'];

        return view('master.users.edit', compact('user', 'kelurahans', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:master,admin_kelurahan,perangkat_daerah'],
            'kelurahan_id' => ['nullable', 'exists:kelurahans,id'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'pas_foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = $request->only(['name', 'email', 'role', 'kelurahan_id', 'penanggung_jawab', 'no_telepon']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('pas_foto')) {
            $file = $request->file('pas_foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/pas_foto', $filename);
            $data['pas_foto'] = $filename;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent Master from deleting their own account
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus.');
    }
}