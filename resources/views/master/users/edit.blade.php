<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Pengguna</h2>
        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Pilih Role</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r }}" {{ old('role', $user->role) == $r ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $r)) }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Pilih Kelurahan</option>
                    @foreach ($kelurahans as $kelurahan)
                        <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $user->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                    @endforeach
                </select>
                @error('kelurahan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="penanggung_jawab" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" id="penanggung_jawab" value="{{ old('penanggung_jawab', $user->penanggung_jawab ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('penanggung_jawab')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $user->no_telepon ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('no_telepon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pas_foto" class="block text-sm font-medium text-gray-700">Pas Foto</label>
                <input type="file" name="pas_foto" id="pas_foto" class="mt-1 block w-full">
                @if ($user->pas_foto)
                    <img src="{{ Storage::url('pas_foto/' . $user->pas_foto) }}" alt="Pas Foto" class="w-16 h-16 object-cover mt-2">
                @endif
                @error('pas_foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>