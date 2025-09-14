<!DOCTYPE html>
<html>
<head>
    <title>Tambah Edukasi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Edukasi</h2>
        <a href="{{ route('edukasi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>
        <form method="POST" action="{{ route('edukasi.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    @error('judul')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="penyebaran_informasi_media" class="block text-sm font-medium text-gray-700">Penyebaran Informasi melalui Media</label>
                    <textarea name="penyebaran_informasi_media" id="penyebaran_informasi_media" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('penyebaran_informasi_media') }}</textarea>
                    @error('penyebaran_informasi_media')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="konseling_perubahan_perilaku" class="block text-sm font-medium text-gray-700">Konseling Perubahan Perilaku Antar Pribadi</label>
                    <textarea name="konseling_perubahan_perilaku" id="konseling_perubahan_perilaku" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('konseling_perubahan_perilaku') }}</textarea>
                    @error('konseling_perubahan_perilaku')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="konseling_pengasuhan" class="block text-sm font-medium text-gray-700">Konseling Pengasuhan untuk Orang Tua</label>
                    <textarea name="konseling_pengasuhan" id="konseling_pengasuhan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('konseling_pengasuhan') }}</textarea>
                    @error('konseling_pengasuhan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="paud" class="block text-sm font-medium text-gray-700">PAUD (Pendidikan Anak Usia Dini)</label>
                    <textarea name="paud" id="paud" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('paud') }}</textarea>
                    @error('paud')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="konseling_kesehatan_reproduksi" class="block text-sm font-medium text-gray-700">Konseling Kesehatan Reproduksi untuk Remaja</label>
                    <textarea name="konseling_kesehatan_reproduksi" id="konseling_kesehatan_reproduksi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('konseling_kesehatan_reproduksi') }}</textarea>
                    @error('konseling_kesehatan_reproduksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="ppa" class="block text-sm font-medium text-gray-700">PPA (Pemberdayaan Perempuan dan Perlindungan Anak)</label>
                    <textarea name="ppa" id="ppa" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('ppa') }}</textarea>
                    @error('ppa')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="modul_buku_saku" class="block text-sm font-medium text-gray-700">Modul dan Buku Saku Pencegahan dan Penanganan Stunting</label>
                    <textarea name="modul_buku_saku" id="modul_buku_saku" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('modul_buku_saku') }}</textarea>
                    @error('modul_buku_saku')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('gambar')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status_aktif" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                    <select name="status_aktif" id="status_aktif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="1" {{ old('status_aktif', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status_aktif', 1) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status_aktif')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>