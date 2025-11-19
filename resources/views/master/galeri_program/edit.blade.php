<!DOCTYPE html>
<html>
<head>
    <title>Edit Program</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '{{ asset('storage/' . $galeriProgram->gambar) }}';
                preview.classList.remove('hidden');
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Program</h2>
        <form action="{{ route('galeri_program.update', $galeriProgram->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
                <img src="{{ asset('storage/' . $galeriProgram->gambar) }}" alt="Gambar" class="w-8 h-8 object-cover rounded mb-2">
                <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewImage(this, 'preview_gambar')">
                <img id="preview_gambar" class="w-8 h-8 object-cover rounded mt-2 hidden">
                @error('gambar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $galeriProgram->judul) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('judul')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('deskripsi', $galeriProgram->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Penyuluhan" {{ old('kategori', $galeriProgram->kategori) == 'Penyuluhan' ? 'selected' : '' }}>Penyuluhan</option>
                    <option value="Posyandu" {{ old('kategori', $galeriProgram->kategori) == 'Posyandu' ? 'selected' : '' }}>Posyandu</option>
                    <option value="Pendampingan" {{ old('kategori', $galeriProgram->kategori) == 'Pendampingan' ? 'selected' : '' }}>Pendampingan</option>
                    <option value="Lainnya" {{ old('kategori', $galeriProgram->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="link" class="block text-sm font-medium text-gray-700">Link (opsional)</label>
                <input type="url" name="link" id="link" value="{{ old('link', $galeriProgram->link) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('link')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $galeriProgram->urutan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
                @error('urutan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="status_aktif" id="status_aktif" class="form-checkbox" {{ old('status_aktif', $galeriProgram->status_aktif) ? 'checked' : '' }}>
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