<!DOCTYPE html>
<html>
<head>
    <title>Edit Edukasi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Edukasi</h2>
        <a href="{{ route('edukasi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>
        <form method="POST" action="{{ route('edukasi.update', $edukasi->id) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $edukasi->judul) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    @error('judul')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="" {{ old('kategori', $edukasi->kategori) ? '' : 'selected' }} disabled>Pilih Kategori</option>
                        @foreach (\App\Models\Edukasi::KATEGORI as $key => $label)
                            <option value="{{ $key }}" {{ old('kategori', $edukasi->kategori) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2 {{ $edukasi->kategori ? '' : 'hidden' }}" id="additional-fields">
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('deskripsi', $edukasi->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tautan" class="block text-sm font-medium text-gray-700">Tautan Link</label>
                        <input type="url" name="tautan" id="tautan" value="{{ old('tautan', $edukasi->tautan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" placeholder="https://example.com">
                        @error('tautan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700">File (PDF/Word)</label>
                        <input type="file" name="file" id="file" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept=".pdf,.doc,.docx">
                        @if ($edukasi->file)
                            <p class="text-sm text-gray-600">File saat ini: <a href="{{ Storage::url($edukasi->file) }}" target="_blank" class="text-blue-500 hover:underline">Lihat file</a></p>
                        @endif
                        @error('file')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" accept=".jpg,.jpeg,.png">
                    @if ($edukasi->gambar)
                        <p class="text-sm text-gray-600">Gambar saat ini: <img src="{{ Storage::url($edukasi->gambar) }}" alt="Gambar Edukasi" class="w-24 h-24 object-cover rounded mt-2"></p>
                    @endif
                    @error('gambar')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status_aktif" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                    <select name="status_aktif" id="status_aktif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="1" {{ old('status_aktif', $edukasi->status_aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status_aktif', $edukasi->status_aktif) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status_aktif')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
    <script>
        document.getElementById('kategori').addEventListener('change', function() {
            const additionalFields = document.getElementById('additional-fields');
            additionalFields.classList.toggle('hidden', this.value === '');
        });
    </script>
</body>
</html>