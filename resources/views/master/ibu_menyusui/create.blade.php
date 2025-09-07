<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Ibu Menyusui</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Ibu Menyusui</h2>
        <form action="{{ route('ibu_menyusui.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Pilih Ibu --</option>
                    @foreach ($ibus as $ibu)
                        <option value="{{ $ibu->id }}" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})</option>
                    @endforeach
                </select>
                @error('ibu_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_menyusui" class="block text-sm font-medium text-gray-700">Status Menyusui</label>
                <select name="status_menyusui" id="status_menyusui" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('status_menyusui') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                    <option value="Eksklusif" {{ old('status_menyusui') == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                    <option value="Non-Eksklusif" {{ old('status_menyusui') == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                </select>
                @error('status_menyusui')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="frekuensi_menyusui" class="block text-sm font-medium text-gray-700">Frekuensi Menyusui (kali/hari)</label>
                <input type="number" name="frekuensi_menyusui" id="frekuensi_menyusui" value="{{ old('frekuensi_menyusui') }}" min="0" max="24" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('frekuensi_menyusui')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kondisi_ibu" class="block text-sm font-medium text-gray-700">Kondisi Ibu</label>
                <input type="text" name="kondisi_ibu" id="kondisi_ibu" value="{{ old('kondisi_ibu') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kondisi_ibu')
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
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>