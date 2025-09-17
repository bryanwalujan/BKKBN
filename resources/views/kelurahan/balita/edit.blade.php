<!DOCTYPE html>
<html>
<head>
    <title>Edit Balita</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Balita</h2>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('kelurahan.balita.update', ['id' => $balita->id, 'source' => $source]) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kartu Keluarga</option>
                    @foreach ($kartuKeluargas as $kk)
                        <option value="{{ $kk->id }}" data-source="{{ $kk->source }}" {{ old('kartu_keluarga_id', $balita->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }} ({{ $kk->source == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi' }})</option>
                    @endforeach
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik', $balita->nik) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                @error('nik')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $balita->nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $balita->tanggal_lahir) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('tanggal_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                <input type="number" step="0.1" name="berat" id="berat" value="{{ old('berat', $beratTinggi[0]) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('berat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                <input type="number" step="0.1" name="tinggi" id="tinggi" value="{{ old('tinggi', $beratTinggi[1]) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('tinggi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700">Lingkar Kepala (cm)</label>
                <input type="number" step="0.1" name="lingkar_kepala" id="lingkar_kepala" value="{{ old('lingkar_kepala', $balita->lingkar_kepala) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                @error('lingkar_kepala')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700">Lingkar Lengan (cm)</label>
                <input type="number" step="0.1" name="lingkar_lengan" id="lingkar_lengan" value="{{ old('lingkar_lengan', $balita->lingkar_lengan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                @error('lingkar_lengan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('alamat', $balita->alamat) }}</textarea>
                @error('alamat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_gizi" class="block text-sm font-medium text-gray-700">Status Gizi</label>
                <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="Sehat" {{ old('status_gizi', $balita->status_gizi) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Stunting" {{ old('status_gizi', $balita->status_gizi) == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                    <option value="Kurang Gizi" {{ old('status_gizi', $balita->status_gizi) == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                    <option value="Obesitas" {{ old('status_gizi', $balita->status_gizi) == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                </select>
                @error('status_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_label" class="block text-sm font-medium text-gray-700">Warna Label</label>
                <select name="warna_label" id="warna_label" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="Sehat" {{ old('warna_label', $balita->warna_label) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Waspada" {{ old('warna_label', $balita->warna_label) == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                    <option value="Bahaya" {{ old('warna_label', $balita->warna_label) == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                </select>
                @error('warna_label')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_pemantauan" class="block text-sm font-medium text-gray-700">Status Pemantauan</label>
                <input type="text" name="status_pemantauan" id="status_pemantauan" value="{{ old('status_pemantauan', $balita->status_pemantauan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                @error('status_pemantauan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                @if ($balita->foto)
                    <img src="{{ Storage::url($balita->foto) }}" alt="Foto Balita" class="h-32 mb-2">
                    <p class="text-sm text-gray-600">Ganti foto (jika perlu):</p>
                @endif
                <input type="file" name="foto" id="foto" class="mt-1 block w-full">
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('kelurahan.balita.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            // Load kartu keluarga on page load
            $.ajax({
                url: '{{ route("kelurahan.balita.getKartuKeluarga") }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#kartu_keluarga_id').empty();
                    $('#kartu_keluarga_id').append('<option value="">Pilih Kartu Keluarga</option>');
                    $.each(data, function(index, kk) {
                        var text = `${kk.no_kk} - ${kk.kepala_keluarga} (${kk.source == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi'})`;
                        var selected = kk.id == {{ old('kartu_keluarga_id', $balita->kartu_keluarga_id) ?? 'null' }} ? 'selected' : '';
                        $('#kartu_keluarga_id').append(`<option value="${kk.id}" data-source="${kk.source}" ${selected}>${text}</option>`);
                    });
                },
                error: function(xhr) {
                    console.error('Error fetching kartu keluarga:', xhr);
                    alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                }
            });
        });
    </script>
</body>
</html>