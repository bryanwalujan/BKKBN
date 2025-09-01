<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Ibu Menyusui</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Ibu Menyusui</h2>
        <form action="{{ route('ibu_menyusui.update', $ibuMenyusui->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $ibuMenyusui->nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $ibuMenyusui->kelurahan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kelurahan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $ibuMenyusui->kecamatan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kecamatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_menyusui" class="block text-sm font-medium text-gray-700">Status Menyusui</label>
                <select name="status_menyusui" id="status_menyusui" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == '' ? 'selected' : '' }}>-- Pilih Status Menyusui --</option>
                    <option value="Eksklusif" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                    <option value="Non-Eksklusif" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                </select>
                @error('status_menyusui')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="frekuensi_menyusui" class="block text-sm font-medium text-gray-700">Frekuensi Menyusui per Hari</label>
                <input type="number" name="frekuensi_menyusui" id="frekuensi_menyusui" value="{{ old('frekuensi_menyusui', $ibuMenyusui->frekuensi_menyusui) }}" min="0" max="24" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('frekuensi_menyusui')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kondisi_ibu" class="block text-sm font-medium text-gray-700">Kondisi Ibu</label>
                <input type="text" name="kondisi_ibu" id="kondisi_ibu" value="{{ old('kondisi_ibu', $ibuMenyusui->kondisi_ibu) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kondisi_ibu')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_kondisi" class="block text-sm font-medium text-gray-700">Warna Kondisi</label>
                <select name="warna_kondisi" id="warna_kondisi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                    <option value="Hijau (success)" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == 'Hijau (success)' ? 'selected' : '' }}>Hijau (success)</option>
                    <option value="Kuning (warning)" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == 'Kuning (warning)' ? 'selected' : '' }}>Kuning (warning)</option>
                    <option value="Merah (danger)" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == 'Merah (danger)' ? 'selected' : '' }}>Merah (danger)</option>
                </select>
                @error('warna_kondisi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                <input type="number" name="berat" id="berat" value="{{ old('berat', $ibuMenyusui->berat) }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('berat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi', $ibuMenyusui->tinggi) }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tinggi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                @if ($ibuMenyusui->foto)
                    <img src="{{ Storage::url($ibuMenyusui->foto) }}" alt="Foto Ibu Menyusui" class="w-16 h-16 object-cover rounded mb-2">
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