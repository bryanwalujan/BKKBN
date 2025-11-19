<!DOCTYPE html>
<html>
<head>
    <title>Edit Tentang Kami</title>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
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
        function toggleRemoveOverlay() {
            const removeCheckbox = document.getElementById('remove_gambar_overlay');
            const fileInput = document.getElementById('gambar_overlay');
            if (removeCheckbox.checked) {
                fileInput.disabled = true;
                document.getElementById('preview_gambar_overlay').classList.add('hidden');
            } else {
                fileInput.disabled = false;
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Tentang Kami</h2>
        <form action="{{ route('tentang_kami.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="sub_judul" class="block text-sm font-medium text-gray-700">Sub Judul</label>
                <input type="text" name="sub_judul" id="sub_judul" value="{{ old('sub_judul', $tentangKami->sub_judul) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('sub_judul')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="judul_utama" class="block text-sm font-medium text-gray-700">Judul Utama</label>
                <input type="text" name="judul_utama" id="judul_utama" value="{{ old('judul_utama', $tentangKami->judul_utama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('judul_utama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="paragraf_1" class="block text-sm font-medium text-gray-700">Paragraf 1</label>
                <textarea name="paragraf_1" id="paragraf_1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('paragraf_1', $tentangKami->paragraf_1) }}</textarea>
                @error('paragraf_1')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="paragraf_2" class="block text-sm font-medium text-gray-700">Paragraf 2 (opsional)</label>
                <textarea name="paragraf_2" id="paragraf_2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('paragraf_2', $tentangKami->paragraf_2) }}</textarea>
                @error('paragraf_2')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="teks_tombol" class="block text-sm font-medium text-gray-700">Teks Tombol (opsional)</label>
                <input type="text" name="teks_tombol" id="teks_tombol" value="{{ old('teks_tombol', $tentangKami->teks_tombol) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('teks_tombol')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="link_tombol" class="block text-sm font-medium text-gray-700">Link Tombol (opsional)</label>
                <input type="url" name="link_tombol" id="link_tombol" value="{{ old('link_tombol', $tentangKami->link_tombol) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('link_tombol')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="gambar_utama" class="block text-sm font-medium text-gray-700">Gambar Utama</label>
                <img src="{{ asset('storage/' . $tentangKami->gambar_utama) }}" alt="Gambar Utama" class="w-32 h-32 object-cover rounded mb-2">
                <input type="file" name="gambar_utama" id="gambar_utama" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewImage(this, 'preview_gambar_utama')">
                <img id="preview_gambar_utama" class="w-32 h-32 object-cover rounded mt-2 hidden">
                @error('gambar_utama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="gambar_overlay" class="block text-sm font-medium text-gray-700">Gambar Overlay (opsional)</label>
                @if ($tentangKami->gambar_overlay)
                    <img src="{{ asset('storage/' . $tentangKami->gambar_overlay) }}" alt="Gambar Overlay" class="w-32 h-32 object-cover rounded mb-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remove_gambar_overlay" id="remove_gambar_overlay" class="form-checkbox" onchange="toggleRemoveOverlay()">
                        <span class="ml-2 text-sm text-gray-700">Hapus Gambar Overlay</span>
                    </label>
                @endif
                <input type="file" name="gambar_overlay" id="gambar_overlay" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="previewImage(this, 'preview_gambar_overlay')">
                <img id="preview_gambar_overlay" class="w-32 h-32 object-cover rounded mt-2 hidden">
                @error('gambar_overlay')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>