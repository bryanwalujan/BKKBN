<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Ibu</h2>
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
        <form action="{{ route('kelurahan.ibu.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kartu Keluarga</option>
                    @foreach ($kartuKeluargas as $kk)
                        <option value="{{ $kk->id }}" data-source="{{ $kk->source }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }} ({{ $kk->source == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi' }})</option>
                    @endforeach
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                @error('nik')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="" {{ old('status') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                    <option value="Hamil" {{ old('status') == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                    <option value="Nifas" {{ old('status') == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                    <option value="Menyusui" {{ old('status') == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                    <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div id="ibu_hamil_fields" class="hidden">
                <div class="mb-4">
                    <label for="trimester" class="block text-sm font-medium text-gray-700">Trimester</label>
                    <select name="trimester" id="trimester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
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
                    <select name="intervensi" id="intervensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
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
                    <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
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
                    <select name="warna_status_gizi" id="warna_status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
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
                    <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ old('usia_kehamilan') }}" min="0" max="40" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('usia_kehamilan')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                    <input type="number" name="berat" id="berat" value="{{ old('berat') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('berat')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                    <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('tinggi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto" class="mt-1 block w-full" accept="image/*">
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('kelurahan.ibu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            $.ajax({
                url: '{{ route("kelurahan.ibu.getKartuKeluarga") }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#kartu_keluarga_id').empty();
                    $('#kartu_keluarga_id').append('<option value="">Pilih Kartu Keluarga</option>');
                    $.each(data, function(index, kk) {
                        var text = `${kk.no_kk} - ${kk.kepala_keluarga} (${kk.source == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi'})`;
                        var selected = kk.id == {{ old('kartu_keluarga_id') ?? 'null' }} ? 'selected' : '';
                        $('#kartu_keluarga_id').append(`<option value="${kk.id}" data-source="${kk.source}" ${selected}>${text}</option>`);
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching kartu keluarga:', xhr);
                    alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                }
            });

            // Show/hide ibu hamil fields based on status
            $('#status').on('change', function() {
                if ($(this).val() === 'Hamil') {
                    $('#ibu_hamil_fields').removeClass('hidden');
                    $('#trimester, #intervensi, #status_gizi, #warna_status_gizi, #usia_kehamilan, #berat, #tinggi').attr('required', true);
                } else {
                    $('#ibu_hamil_fields').addClass('hidden');
                    $('#trimester, #intervensi, #status_gizi, #warna_status_gizi, #usia_kehamilan, #berat, #tinggi').removeAttr('required');
                }
            });

            // Trigger change on page load to handle old input
            if ($('#status').val() === 'Hamil') {
                $('#ibu_hamil_fields').removeClass('hidden');
                $('#trimester, #intervensi, #status_gizi, #warna_status_gizi, #usia_kehamilan, #berat, #tinggi').attr('required', true);
            }
        });
    </script>
</body>
</html>