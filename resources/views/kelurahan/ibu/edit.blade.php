<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#kartu_keluarga_id').select2({
                placeholder: '-- Pilih Kartu Keluarga --',
                allowClear: true
            });

            // Load kartu keluarga
            $.ajax({
                url: '{{ route('kelurahan.ibu.getKartuKeluarga') }}',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>');
                    if (data.length === 0) {
                        $('#kartu_keluarga_id').after('<p class="text-red-600 text-sm mt-1">Tidak ada data Kartu Keluarga yang terverifikasi. <a href="{{ route('kelurahan.kartu_keluarga.create') }}" class="text-blue-600 hover:underline">Tambah Kartu Keluarga</a> terlebih dahulu.</p>');
                    }
                    $.each(data, function (index, kk) {
                        var selected = kk.id == '{{ old('kartu_keluarga_id', $ibu->kartu_keluarga_id) }}' ? 'selected' : '';
                        $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                    });
                    $('#kartu_keluarga_id').trigger('change');
                },
                error: function (xhr) {
                    console.error('Gagal mengambil data kartu keluarga:', xhr);
                    alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                }
            });
        });
    </script>
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Ibu ({{ $source === 'verified' ? 'Terverifikasi' : 'Pending' }})</h2>
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
        @if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $kartuKeluargas->isEmpty() ? 'Tidak ada data Kartu Keluarga yang terverifikasi. ' : '' }}
                {{ !$kecamatan || !$kelurahan ? 'Data kecamatan atau kelurahan tidak ditemukan. ' : '' }}
                Silakan tambahkan data terlebih dahulu.
            </div>
        @else
            <form action="{{ route('kelurahan.ibu.update', ['id' => $ibu->id, 'source' => $source]) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <input type="text" value="{{ $kecamatan->nama_kecamatan }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                    <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id }}">
                    @error('kecamatan_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <input type="text" value="{{ $kelurahan->nama_kelurahan }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                    <input type="hidden" name="kelurahan_id" value="{{ $kelurahan->id }}">
                    @error('kelurahan_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                    <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Kartu Keluarga --</option>
                    </select>
                    @error('kartu_keluarga_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $ibu->nik) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" maxlength="16">
                    @error('nik')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $ibu->nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('nama')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $ibu->alamat) }}</textarea>
                    @error('alamat')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('status', $ibu->status) == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                        <option value="Hamil" {{ old('status', $ibu->status) == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                        <option value="Nifas" {{ old('status', $ibu->status) == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                        <option value="Menyusui" {{ old('status', $ibu->status) == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                        <option value="Tidak Aktif" {{ old('status', $ibu->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                    @if ($ibu->foto)
                        <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="w-32 h-32 object-cover rounded mb-2">
                        <p class="text-sm text-gray-600">Unggah foto baru untuk mengganti foto saat ini.</p>
                    @endif
                    <input type="file" name="foto" id="foto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" accept="image/*">
                    @error('foto')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    <a href="{{ route('kelurahan.ibu.index', ['tab' => $source]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                </div>
            </form>
        @endif
    </div>
</body>
</html>