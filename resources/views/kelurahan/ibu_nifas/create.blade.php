<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Ibu Nifas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Ibu Nifas</h2>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ session('warning') }}
            </div>
        @endif
        <form action="{{ route('kelurahan.ibu_nifas.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">-- Pilih Ibu --</option>
                    @foreach ($ibus as $ibu)
                        <option value="{{ $ibu->id }}" data-source="verified" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }}) - Terverifikasi</option>
                    @endforeach
                    @foreach ($pendingIbus as $ibu)
                        <option value="{{ $ibu->id }}" data-source="pending" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }}) - Menunggu Verifikasi</option>
                    @endforeach
                </select>
                <input type="hidden" name="ibu_source" id="ibu_source" value="{{ old('ibu_source') }}">
                @error('ibu_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                @error('ibu_source')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="hari_nifas" class="block text-sm font-medium text-gray-700">Hari ke-Nifas</label>
                <input type="number" name="hari_nifas" id="hari_nifas" value="{{ old('hari_nifas') }}" min="0" max="42" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('hari_nifas')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kondisi_kesehatan" class="block text-sm font-medium text-gray-700">Kondisi Kesehatan</label>
                <select name="kondisi_kesehatan" id="kondisi_kesehatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
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
                <select name="warna_kondisi" id="warna_kondisi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
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
                <input type="number" name="berat" id="berat" value="{{ old('berat') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('berat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('tinggi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('kelurahan.ibu_nifas.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ibu_id').select2({
                placeholder: '-- Pilih Ibu --',
                allowClear: true
            });

            $('#ibu_id').on('change', function() {
                var source = $(this).find('option:selected').data('source');
                $('#ibu_source').val(source);
            });

            var initialSource = $('#ibu_id').find('option:selected').data('source');
            if (initialSource) {
                $('#ibu_source').val(initialSource);
            }
        });
    </script>
</body>
</html>