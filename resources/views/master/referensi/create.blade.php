<!DOCTYPE html>
<html>
<head>
    <title>Tambah Referensi</title>
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
        function previewPDF(input, previewId) {
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
        <h2 class="text-2xl font-semibold mb-4">Tambah Referensi</h2>
        <form action="{{ route('referensi.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('judul')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="icon" class="block text-sm font-medium text-gray-700">Ikon</label>
                <input type="file" name="icon" id="icon" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewImage(this, 'preview_icon')" required>
                <img id="preview_icon" class="w-8 h-8 object-cover rounded mt-2 hidden">
                @error('icon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pdf" class="block text-sm font-medium text-gray-700">PDF</label>
                <input type="file" name="pdf" id="pdf" accept="application/pdf" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewPDF(this, 'preview_pdf')" required>
                <embed id="preview_pdf" class="w-full h-64 mt-2 hidden" type="application/pdf">
                @error('pdf')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_icon" class="block text-sm font-medium text-gray-700">Warna Ikon</label>
                <select name="warna_icon" id="warna_icon" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Biru" {{ old('warna_icon', 'Biru') == 'Biru' ? 'selected' : '' }}>Biru</option>
                    <option value="Merah" {{ old('warna_icon') == 'Merah' ? 'selected' : '' }}>Merah</option>
                    <option value="Hijau" {{ old('warna_icon') == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                    <option value="Kuning" {{ old('warna_icon') == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                </select>
                @error('warna_icon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="link_file" class="block text-sm font-medium text-gray-700">Link File (opsional)</label>
                <input type="url" name="link_file" id="link_file" value="{{ old('link_file') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('link_file')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="teks_tombol" class="block text-sm font-medium text-gray-700">Teks Tombol</label>
                <input type="text" name="teks_tombol" id="teks_tombol" value="{{ old('teks_tombol') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" maxlength="50" required>
                @error('teks_tombol')
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