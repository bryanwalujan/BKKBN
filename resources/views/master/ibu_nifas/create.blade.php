<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Ibu Nifas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  @include('master.partials.sidebar')
  <div class="ml-64 p-6">
    <h2 class="text-2xl font-semibold mb-4">Tambah Data Ibu Nifas</h2>
    <form action="{{ route('ibu_nifas.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
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
        <label for="hari_nifas" class="block text-sm font-medium text-gray-700">Hari ke-Nifas</label>
        <input type="number" name="hari_nifas" id="hari_nifas" value="{{ old('hari_nifas') }}" min="0" max="42" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        @error('hari_nifas')
          <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="mb-4">
        <label for="kondisi_kesehatan" class="block text-sm font-medium text-gray-700">Kondisi Kesehatan</label>
        <input type="text" name="kondisi_kesehatan" id="kondisi_kesehatan" value="{{ old('kondisi_kesehatan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
        @error('kondisi_kesehatan')
          <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="mb-4">
        <label for="warna_kondisi" class="block text-sm font-medium text-gray-700">Warna Kondisi</label>
        <select name="warna_kondisi" id="warna_kondisi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
          <option value="" {{ old('warna_kondisi') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
          <option value="Hijau (success)" {{ old('warna_kondisi') == 'Hijau (success)' ? 'selected' : '' }}>Hijau (success)</option>
          <option value="Kuning (warning)" {{ old('warna_kondisi') == 'Kuning (warning)' ? 'selected' : '' }}>Kuning (warning)</option>
          <option value="Merah (danger)" {{ old('warna_kondisi') == 'Merah (danger)' ? 'selected' : '' }}>Merah (danger)</option>
        </select>
        @error('warna_kondisi')
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