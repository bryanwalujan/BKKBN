<!DOCTYPE html>
<html>
<head>
    <title>Edit Referensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '{{ $referensi->icon ? asset('storage/' . $referensi->icon) : '' }}';
                preview.classList.toggle('hidden', !preview.src);
            }
        }
        function previewPDF(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '{{ $referensi->pdf ? asset('storage/' . $referensi->pdf) : '' }}';
                preview.classList.toggle('hidden', !preview.src);
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Referensi</h2>
        <form action="{{ route('referensi.update', $referensi->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul', $referensi->judul) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('judul')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('deskripsi', $referensi->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="icon" class="block text-sm font-medium text-gray-700">Ikon</label>
                @if ($referensi->icon)
                    <img src="{{ asset('storage/' . $referensi->icon) }}" alt="Ikon" class="w-8 h-8 object-cover rounded mb-2 {{ $referensi->warna_icon == 'Biru' ? 'text-blue-500' : ($referensi->warna_icon == 'Merah' ? 'text-red-500' : ($referensi->warna_icon == 'Hijau' ? 'text-green-500' : 'text-yellow-500')) }}">
                @else
                    <p class="text-sm text-gray-500 mb-2">Tidak ada ikon</p>
                @endif
                <input type="file" name="icon" id="icon" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewImage(this, 'preview_icon')">
                <img id="preview_icon" class="w-8 h-8 object-cover rounded mt-2 {{ $referensi->icon ? '' : 'hidden' }}" src="{{ $referensi->icon ? asset('storage/' . $referensi->icon) : '' }}">
                @error('icon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pdf" class="block text-sm font-medium text-gray-700">PDF</label>
                @if ($referensi->pdf)
                    <a href="{{ asset('storage/' . $referensi->pdf) }}" target="_blank" class="text-blue-500 hover:underline mb-2 block">Lihat PDF Saat Ini</a>
                @else
                    <p class="text-sm text-gray-500 mb-2">Tidak ada PDF</p>
                @endif
                <input type="file" name="pdf" id="pdf" accept="application/pdf" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewPDF(this, 'preview_pdf')">
                <embed id="preview_pdf" class="w-full h-64 mt-2 {{ $referensi->pdf ? '' : 'hidden' }}" src="{{ $referensi->pdf ? asset('storage/' . $referensi->pdf) : '' }}" type="application/pdf">
                @error('pdf')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_icon" class="block text-sm font-medium text-gray-700">Warna Ikon</label>
                <select name="warna_icon" id="warna_icon" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Biru" {{ old('warna_icon', $referensi->warna_icon) == 'Biru' ? 'selected' : '' }}>Biru</option>
                    <option value="Merah" {{ old('warna_icon', $referensi->warna_icon) == 'Merah' ? 'selected' : '' }}>Merah</option>
                    <option value="Hijau" {{ old('warna_icon', $referensi->warna_icon) == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                    <option value="Kuning" {{ old('warna_icon', $referensi->warna_icon) == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                </select>
                @error('warna_icon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="link_file" class="block text-sm font-medium text-gray-700">Link File (opsional)</label>
                <input type="url" name="link_file" id="link_file" value="{{ old('link_file', $referensi->link_file) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('link_file')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="teks_tombol" class="block text-sm font-medium text-gray-700">Teks Tombol</label>
                <input type="text" name="teks_tombol" id="teks_tombol" value="{{ old('teks_tombol', $referensi->teks_tombol) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" maxlength="50" required>
                @error('teks_tombol')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $referensi->urutan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
                @error('urutan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="status_aktif" id="status_aktif" class="form-checkbox" {{ old('status_aktif', $referensi->status_aktif) ? 'checked' : '' }}>
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