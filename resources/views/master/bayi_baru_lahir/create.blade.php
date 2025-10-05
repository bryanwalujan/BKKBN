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
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('ibu_nifas.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                <label for="hari_nifas" class="block text-sm font-medium text-gray-700">Hari ke-Nifas</label>
                <input type="number" name="hari_nifas" id="hari_nifas" value="{{ old('hari_nifas') }}" min="0" max="42" step="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('hari_nifas')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_melahirkan" class="block text-sm font-medium text-gray-700">Tanggal Melahirkan</label>
                <input type="date" name="tanggal_melahirkan" id="tanggal_melahirkan" value="{{ old('tanggal_melahirkan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('tanggal_melahirkan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tempat_persalinan" class="block text-sm font-medium text-gray-700">Tempat Persalinan</label>
                <input type="text" name="tempat_persalinan" id="tempat_persalinan" value="{{ old('tempat_persalinan') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('tempat_persalinan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="penolong_persalinan" class="block text-sm font-medium text-gray-700">Penolong Persalinan</label>
                <input type="text" name="penolong_persalinan" id="penolong_persalinan" value="{{ old('penolong_persalinan') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('penolong_persalinan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="cara_persalinan" class="block text-sm font-medium text-gray-700">Cara Persalinan</label>
                <input type="text" name="cara_persalinan" id="cara_persalinan" value="{{ old('cara_persalinan') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('cara_persalinan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="komplikasi" class="block text-sm font-medium text-gray-700">Komplikasi</label>
                <input type="text" name="komplikasi" id="komplikasi" value="{{ old('komplikasi') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('komplikasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="keadaan_bayi" class="block text-sm font-medium text-gray-700">Keadaan Bayi</label>
                <input type="text" name="keadaan_bayi" id="keadaan_bayi" value="{{ old('keadaan_bayi') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('keadaan_bayi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kb_pasca_salin" class="block text-sm font-medium text-gray-700">KB Pasca Salin</label>
                <input type="text" name="kb_pasca_salin" id="kb_pasca_salin" value="{{ old('kb_pasca_salin') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('kb_pasca_salin')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kondisi_kesehatan" class="block text-sm font-medium text-gray-700">Kondisi Kesehatan</label>
                <select name="kondisi_kesehatan" id="kondisi_kesehatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" {{ old('kondisi_kesehatan') == '' ? 'selected' : '' }}>-- Pilih Kondisi --</option>
                    <option value="Normal" {{ old('kondisi_kesehatan') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Butuh Perhatian" {{ old('kondisi_kesehatan') == 'Butuh Perhatian' ? 'selected' : '' }}>Butuh Perhatian</option>
                    <option value="Kritis" {{ old('kondisi_kesehatan') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                </select>
                @error('kondisi_kesehatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_kondisi" class="block text-sm font-medium text-gray-700">Warna Kondisi</label>
                <select name="warna_kondisi" id="warna_kondisi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
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
                <input type="number" name="berat" id="berat" value="{{ old('berat') }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('berat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('tinggi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <h3 class="text-lg font-semibold mt-6 mb-4">Data Bayi Baru Lahir</h3>
            <div class="mb-4">
                <label for="bayi_umur_dalam_kandungan" class="block text-sm font-medium text-gray-700">Umur Dalam Kandungan</label>
                <input type="text" name="bayi[umur_dalam_kandungan]" id="bayi_umur_dalam_kandungan" value="{{ old('bayi.umur_dalam_kandungan') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('bayi.umur_dalam_kandungan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="bayi_berat_badan_lahir" class="block text-sm font-medium text-gray-700">Berat Badan Lahir (kg)</label>
                <input type="text" name="bayi[berat_badan_lahir]" id="bayi_berat_badan_lahir" value="{{ old('bayi.berat_badan_lahir') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('bayi.berat_badan_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="bayi_panjang_badan_lahir" class="block text-sm font-medium text-gray-700">Panjang Badan Lahir (cm)</label>
                <input type="text" name="bayi[panjang_badan_lahir]" id="bayi_panjang_badan_lahir" value="{{ old('bayi.panjang_badan_lahir') }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('bayi.panjang_badan_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('ibu_nifas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>