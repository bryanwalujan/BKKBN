<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Ibu Menyusui</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Ibu Menyusui</h2>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('kelurahan.ibu_menyusui.update', [$ibuMenyusui->id, $source]) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Pilih Ibu --</option>
                    @foreach ($ibus as $ibu)
                        <option value="{{ $ibu->id }}" data-source="{{ $ibu->source }}" {{ old('ibu_id', $source == 'verified' ? $ibuMenyusui->ibu_id : $ibuMenyusui->pending_ibu_id) == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }}) - {{ $ibu->source == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi' }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="ibu_source" id="ibu_source" value="{{ old('ibu_source', $source) }}">
                @error('ibu_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                @error('ibu_source')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_menyusui" class="block text-sm font-medium text-gray-700">Status Menyusui</label>
                <select name="status_menyusui" id="status_menyusui" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                    <option value="Eksklusif" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                    <option value="Non-Eksklusif" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                </select>
                @error('status_menyusui')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="frekuensi_menyusui" class="block text-sm font-medium text-gray-700">Frekuensi Menyusui (kali/hari)</label>
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
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('kelurahan.ibu_menyusui.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ibu_id').select2({
                placeholder: 'Pilih Ibu',
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