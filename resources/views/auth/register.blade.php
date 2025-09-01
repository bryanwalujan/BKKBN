<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="admin_kelurahan">Admin Kelurahan</option>
                    <option value="perangkat_desa">Perangkat Desa</option>
                </select>
                @error('role')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan_nama" class="block text-sm font-medium text-gray-700" id="kelurahan_label">Kelurahan</label>
                <input type="text" name="kelurahan_nama" id="kelurahan_nama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kelurahan_nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="penanggung_jawab" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" id="penanggung_jawab" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('penanggung_jawab')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('no_telepon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pas_foto" class="block text-sm font-medium text-gray-700">Pas Foto</label>
                <input type="file" name="pas_foto" id="pas_foto" class="mt-1 block w-full" required>
                @error('pas_foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="surat_pengajuan" class="block text-sm font-medium text-gray-700">Surat Pengajuan</label>
                <input type="file" name="surat_pengajuan" id="surat_pengajuan" class="mt-1 block w-full" required>
                @error('surat_pengajuan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Daftar</button>
        </form>
        <p class="mt-4 text-center">
            <a href="{{ route('download.template') }}" class="text-blue-500 hover:underline">Download Template Surat Pengajuan</a>
        </p>
        <p class="mt-2 text-center">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            const kelurahanLabel = document.getElementById('kelurahan_label');
            kelurahanLabel.textContent = this.value === 'perangkat_desa' ? 'Desa' : 'Kelurahan';
        });
        // Trigger change event on page load to set initial label
        document.getElementById('role').dispatchEvent(new Event('change'));
    </script>
</body>
</html>