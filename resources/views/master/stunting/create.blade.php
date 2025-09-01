<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Stunting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Stunting</h2>
        <form action="{{ route('stunting.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tanggal_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                <input type="number" name="berat" id="berat" value="{{ old('berat') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('berat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tinggi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kelurahan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kecamatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_gizi" class="block text-sm font-medium text-gray-700">Status Gizi</label>
                <input type="text" name="status_gizi" id="status_gizi" value="{{ old('status_gizi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('status_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_gizi" class="block text-sm font-medium text-gray-700">Warna Gizi (Sehat/Waspada/Bahaya)</label>
                <input type="text" name="warna_gizi" id="warna_gizi" value="{{ old('warna_gizi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('warna_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tindak_lanjut" class="block text-sm font-medium text-gray-700">Tindak Lanjut</label>
                <input type="text" name="tindak_lanjut" id="tindak_lanjut" value="{{ old('tindak_lanjut') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('tindak_lanjut')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_tindak_lanjut" class="block text-sm font-medium text-gray-700">Warna Tindak Lanjut (Sehat/Waspada/Bahaya)</label>
                <input type="text" name="warna_tindak_lanjut" id="warna_tindak_lanjut" value="{{ old('warna_tindak_lanjut') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('warna_tindak_lanjut')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
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