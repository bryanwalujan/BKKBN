<!DOCTYPE html>
<html>
<head>
    <title>Edit Publikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '{{ $publikasi->gambar ? asset('storage/' . $publikasi->gambar) : '' }}';
                preview.classList.toggle('hidden', !preview.src);
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Publikasi</h2>
        <form action="{{ route('publikasi.update', $publikasi->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $publikasi->judul) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('judul')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Berita" {{ old('kategori', $publikasi->kategori) == 'Berita' ? 'selected' : '' }}>Berita</option>
                    <option value="Artikel" {{ old('kategori', $publikasi->kategori) == 'Artikel' ? 'selected' : '' }}>Artikel</option>
                    <option value="Pengumuman" {{ old('kategori', $publikasi->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                    <option value="Lainnya" {{ old('kategori', $publikasi->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('deskripsi', $publikasi->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
                @if ($publikasi->gambar)
                    <img src="{{ asset('storage/' . $publikasi->gambar) }}" alt="Gambar" class="w-8 h-8 object-cover rounded mb-2">
                @else
                    <p class="text-sm text-gray-500 mb-2">Tidak ada gambar</p>
                @endif
                <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewImage(this, 'preview_gambar')">
                <img id="preview_gambar" class="w-8 h-8 object-cover rounded mt-2 {{ $publikasi->gambar ? '' : 'hidden' }}" src="{{ $publikasi->gambar ? asset('storage/' . $publikasi->gambar) : '' }}">
                @error('gambar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="link_aksi" class="block text-sm font-medium text-gray-700">Link Aksi (opsional)</label>
                <input type="url" name="link_aksi" id="link_aksi" value="{{ old('link_aksi', $publikasi->link_aksi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('link_aksi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="teks_tombol" class="block text-sm font-medium text-gray-700">Teks Tombol</label>
                <input type="text" name="teks_tombol" id="teks_tombol" value="{{ old('teks_tombol', $publikasi->teks_tombol) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" maxlength="50" required>
                @error('teks_tombol')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $publikasi->urutan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
                @error('urutan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="status_aktif" id="status_aktif" class="form-checkbox" {{ old('status_aktif', $publikasi->status_aktif) ? 'checked' : '' }}>
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