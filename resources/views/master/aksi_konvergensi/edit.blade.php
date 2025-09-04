<!DOCTYPE html>
<html>
<head>
    <title>Edit Aksi Konvergensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Aksi Konvergensi</h2>
        <form action="{{ route('aksi_konvergensi.update', $aksiKonvergensi->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $aksiKonvergensi->kecamatan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kecamatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $aksiKonvergensi->kelurahan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kelurahan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama_aksi" class="block text-sm font-medium text-gray-700">Nama Aksi</label>
                <input type="text" name="nama_aksi" id="nama_aksi" value="{{ old('nama_aksi', $aksiKonvergensi->nama_aksi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama_aksi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="selesai" class="block text-sm font-medium text-gray-700">Selesai</label>
                <input type="checkbox" name="selesai" id="selesai" value="1" {{ old('selesai', $aksiKonvergensi->selesai) ? 'checked' : '' }} class="mt-1">
                @error('selesai')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $aksiKonvergensi->tahun) }}" min="2020" max="2030" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tahun')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                @if ($aksiKonvergensi->foto)
                    <img src="{{ Storage::url($aksiKonvergensi->foto) }}" alt="Foto Aksi Konvergensi" class="w-16 h-16 object-cover rounded mb-2">
                @endif
                <input type="file" name="foto" id="foto" class="mt-1 block w-full" accept="image/*">
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>