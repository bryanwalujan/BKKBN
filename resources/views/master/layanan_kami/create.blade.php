<!DOCTYPE html>
<html>
<head>
    <title>Tambah Layanan Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Layanan Kami</h2>
        <form action="{{ route('layanan_kami.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="judul_layanan" class="block text-sm font-medium text-gray-700">Judul Layanan</label>
                <input type="text" name="judul_layanan" id="judul_layanan" value="{{ old('judul_layanan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('judul_layanan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700">Deskripsi Singkat (maks. 500 karakter)</label>
                <textarea name="deskripsi_singkat" id="deskripsi_singkat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" maxlength="500" required>{{ old('deskripsi_singkat') }}</textarea>
                @error('deskripsi_singkat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi_lengkap" class="block text-sm font-medium text-gray-700">Deskripsi Lengkap (opsional)</label>
                <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('deskripsi_lengkap') }}</textarea>
                @error('deskripsi_lengkap')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="ikon" class="block text-sm font-medium text-gray-700">Ikon</label>
                <input type="file" name="ikon" id="ikon" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewImage(this, 'preview_ikon')" required>
                <img id="preview_ikon" class="w-6 h-6 object-cover rounded mt-2 hidden">
                @error('ikon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 1) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
                @error('urutan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="status_aktif" id="status_aktif" class="form-checkbox" {{ old('status_aktif', 1) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Status Aktif</span>
                </label>
                @error('status_aktif')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>