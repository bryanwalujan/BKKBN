<!DOCTYPE html>
<html>
<head>
    <title>Edit Kegiatan Genting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Kegiatan Genting</h2>
        <form action="{{ route('genting.update', $genting->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $genting->nama_kegiatan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama_kegiatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($genting->tanggal)->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tanggal')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $genting->lokasi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('lokasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="sasaran" class="block text-sm font-medium text-gray-700">Sasaran</label>
                <input type="text" name="sasaran" id="sasaran" value="{{ old('sasaran', $genting->sasaran) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('sasaran')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis_intervensi" class="block text-sm font-medium text-gray-700">Jenis Intervensi</label>
                <input type="text" name="jenis_intervensi" id="jenis_intervensi" value="{{ old('jenis_intervensi', $genting->jenis_intervensi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('jenis_intervensi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="dokumentasi" class="block text-sm font-medium text-gray-700">Dokumentasi</label>
                @if ($genting->dokumentasi)
                    <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi Kegiatan" class="w-16 h-16 object-cover rounded mb-2">
                @endif
                <input type="file" name="dokumentasi" id="dokumentasi" class="mt-1 block w-full" accept="image/*">
                @error('dokumentasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>