<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Ibu Hamil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Ibu Hamil</h2>
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
        <form action="{{ route('ibu_hamil.update', $ibuHamil->id) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih Ibu --</option>
                    @foreach ($ibus as $ibu)
                        <option value="{{ $ibu->id }}" {{ $ibuHamil->ibu_id == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})</option>
                    @endforeach
                </select>
                @error('ibu_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="trimester" class="block text-sm font-medium text-gray-700">Trimester</label>
                <select name="trimester" id="trimester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" {{ $ibuHamil->trimester == '' ? 'selected' : '' }}>-- Pilih Trimester --</option>
                    <option value="Trimester 1" {{ $ibuHamil->trimester == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                    <option value="Trimester 2" {{ $ibuHamil->trimester == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                    <option value="Trimester 3" {{ $ibuHamil->trimester == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                </select>
                @error('trimester')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="intervensi" class="block text-sm font-medium text-gray-700">Intervensi</label>
                <select name="intervensi" id="intervensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" {{ $ibuHamil->intervensi == '' ? 'selected' : '' }}>-- Pilih Intervensi --</option>
                    <option value="Tidak Ada" {{ $ibuHamil->intervensi == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                    <option value="Gizi" {{ $ibuHamil->intervensi == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                    <option value="Konsultasi Medis" {{ $ibuHamil->intervensi == 'Konsultasi Medis' ? 'selected' : '' }}>Konsultasi Medis</option>
                    <option value="Lainnya" {{ $ibuHamil->intervensi == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('intervensi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_gizi" class="block text-sm font-medium text-gray-700">Status Gizi</label>
                <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" {{ $ibuHamil->status_gizi == '' ? 'selected' : '' }}>-- Pilih Status Gizi --</option>
                    <option value="Normal" {{ $ibuHamil->status_gizi == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Kurang Gizi" {{ $ibuHamil->status_gizi == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                    <option value="Berisiko" {{ $ibuHamil->status_gizi == 'Berisiko' ? 'selected' : '' }}>Berisiko</option>
                </select>
                @error('status_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_status_gizi" class="block text-sm font-medium text-gray-700">Warna Status Gizi</label>
                <select name="warna_status_gizi" id="warna_status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" {{ $ibuHamil->warna_status_gizi == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                    <option value="Sehat" {{ $ibuHamil->warna_status_gizi == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Waspada" {{ $ibuHamil->warna_status_gizi == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                    <option value="Bahaya" {{ $ibuHamil->warna_status_gizi == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                </select>
                @error('warna_status_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="usia_kehamilan" class="block text-sm font-medium text-gray-700">Usia Kehamilan (minggu)</label>
                <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ $ibuHamil->usia_kehamilan }}" min="0" max="40" step="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('usia_kehamilan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi_fundus_uteri" class="block text-sm font-medium text-gray-700">Tinggi Fundus Uteri (cm)</label>
                <input type="text" name="tinggi_fundus_uteri" id="tinggi_fundus_uteri" value="{{ $ibuHamil->tinggi_fundus_uteri }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('tinggi_fundus_uteri')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="imt" class="block text-sm font-medium text-gray-700">Indeks Masa Tubuh (IMT)</label>
                <input type="text" name="imt" id="imt" value="{{ $ibuHamil->imt }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('imt')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700">Riwayat Penyakit</label>
                <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" value="{{ $ibuHamil->riwayat_penyakit }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('riwayat_penyakit')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kadar_hb" class="block text-sm font-medium text-gray-700">Kadar HB</label>
                <input type="text" name="kadar_hb" id="kadar_hb" value="{{ $ibuHamil->kadar_hb }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('kadar_hb')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700">Lingkar Kepala (cm)</label>
                <input type="text" name="lingkar_kepala" id="lingkar_kepala" value="{{ $ibuHamil->lingkar_kepala }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('lingkar_kepala')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="taksiran_berat_janin" class="block text-sm font-medium text-gray-700">Taksiran Berat Janin (gr)</label>
                <input type="text" name="taksiran_berat_janin" id="taksiran_berat_janin" value="{{ $ibuHamil->taksiran_berat_janin }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('taksiran_berat_janin')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                <input type="number" name="berat" id="berat" value="{{ $ibuHamil->berat }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('berat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                <input type="number" name="tinggi" id="tinggi" value="{{ $ibuHamil->tinggi }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('tinggi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('ibu_hamil.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>