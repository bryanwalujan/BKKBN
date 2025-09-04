<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Ibu Hamil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Ibu Hamil</h2>
        <form action="{{ route('ibu_hamil.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama')
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
                <label for="trimester" class="block text-sm font-medium text-gray-700">Trimester</label>
                <select name="trimester" id="trimester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('trimester') == '' ? 'selected' : '' }}>-- Pilih Trimester --</option>
                    <option value="Trimester 1" {{ old('trimester') == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                    <option value="Trimester 2" {{ old('trimester') == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                    <option value="Trimester 3" {{ old('trimester') == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                </select>
                @error('trimester')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="intervensi" class="block text-sm font-medium text-gray-700">Intervensi</label>
                <select name="intervensi" id="intervensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('intervensi') == '' ? 'selected' : '' }}>-- Pilih Intervensi --</option>
                    <option value="Tidak Ada" {{ old('intervensi') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                    <option value="Gizi" {{ old('intervensi') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                    <option value="Konsultasi Medis" {{ old('intervensi') == 'Konsultasi Medis' ? 'selected' : '' }}>Konsultasi Medis</option>
                    <option value="Lainnya" {{ old('intervensi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('intervensi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_gizi" class="block text-sm font-medium text-gray-700">Status Gizi</label>
                <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('status_gizi') == '' ? 'selected' : '' }}>-- Pilih Status Gizi --</option>
                    <option value="Normal" {{ old('status_gizi') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                    <option value="Berisiko" {{ old('status_gizi') == 'Berisiko' ? 'selected' : '' }}>Berisiko</option>
                </select>
                @error('status_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_status_gizi" class="block text-sm font-medium text-gray-700">Warna Status Gizi</label>
                <select name="warna_status_gizi" id="warna_status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('warna_status_gizi') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                    <option value="Sehat" {{ old('warna_status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Waspada" {{ old('warna_status_gizi') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                    <option value="Bahaya" {{ old('warna_status_gizi') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                </select>
                @error('warna_status_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="usia_kehamilan" class="block text-sm font-medium text-gray-700">Usia Kehamilan (minggu)</label>
                <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ old('usia_kehamilan') }}" min="0" max="40" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('usia_kehamilan')
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