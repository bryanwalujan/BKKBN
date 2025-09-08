<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Stunting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: 'Pilih Kecamatan',
                allowClear: true
            });
            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true
            });
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            // Load initial kelurahans and kartu keluarga
            var initialKecamatanId = '{{ old('kecamatan_id', $stunting->kecamatan_id) }}';
            var initialKelurahanId = '{{ old('kelurahan_id', $stunting->kelurahan_id) }}';
            if (initialKecamatanId) {
                $.ajax({
                    url: '/kelurahans/by-kecamatan/' + initialKecamatanId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == initialKelurahanId ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');

                        // Load kartu keluarga for initial kecamatan and kelurahan
                        if (initialKelurahanId) {
                            $.ajax({
                                url: '/kartu-keluarga/by-kecamatan-kelurahan?kecamatan_id=' + initialKecamatanId + '&kelurahan_id=' + initialKelurahanId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                                    $.each(data, function(index, kk) {
                                        var selected = kk.id == '{{ old('kartu_keluarga_id', $stunting->kartu_keluarga_id) }}' ? 'selected' : '';
                                        $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                                    });
                                    $('#kartu_keluarga_id').trigger('change');
                                },
                                error: function(xhr) {
                                    console.error('Gagal mengambil data kartu keluarga:', xhr);
                                    alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Gagal mengambil data kelurahan:', xhr);
                        alert('Gagal memuat kelurahan. Silakan coba lagi.');
                    }
                });
            }

            // Fetch kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>').trigger('change');

                if (kecamatanId) {
                    $.ajax({
                        url: '/kelurahans/by-kecamatan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kelurahan:', xhr);
                            alert('Gagal memuat kelurahan. Silakan coba lagi.');
                        }
                    });
                }
            });

            // Fetch kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $(this).val();
                $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>').trigger('change');

                if (kecamatanId && kelurahanId) {
                    $.ajax({
                        url: '/kartu-keluarga/by-kecamatan-kelurahan?kecamatan_id=' + kecamatanId + '&kelurahan_id=' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(index, kk) {
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                            $('#kartu_keluarga_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kartu keluarga:', xhr);
                            alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                        }
                    });
                }
            });
        });
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Stunting</h2>
        <form action="{{ route('stunting.update', $stunting->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $stunting->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Pilih Kelurahan</option>
                </select>
                @error('kelurahan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Pilih Kartu Keluarga</option>
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik', $stunting->nik) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('nik')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $stunting->nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $stunting->tanggal_lahir->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tanggal_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                <input type="number" name="berat" id="berat" value="{{ old('berat', explode('/', $stunting->berat_tinggi)[0]) }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('berat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi', explode('/', $stunting->berat_tinggi)[1]) }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tinggi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_gizi" class="block text-sm font-medium text-gray-700">Status Gizi</label>
                <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Sehat" {{ old('status_gizi', $stunting->status_gizi) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Stunting" {{ old('status_gizi', $stunting->status_gizi) == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                    <option value="Kurang Gizi" {{ old('status_gizi', $stunting->status_gizi) == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                    <option value="Obesitas" {{ old('status_gizi', $stunting->status_gizi) == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                </select>
                @error('status_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_gizi" class="block text-sm font-medium text-gray-700">Warna Gizi</label>
                <select name="warna_gizi" id="warna_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Sehat" {{ old('warna_gizi', $stunting->warna_gizi) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Waspada" {{ old('warna_gizi', $stunting->warna_gizi) == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                    <option value="Bahaya" {{ old('warna_gizi', $stunting->warna_gizi) == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                </select>
                @error('warna_gizi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tindak_lanjut" class="block text-sm font-medium text-gray-700">Tindak Lanjut</label>
                <input type="text" name="tindak_lanjut" id="tindak_lanjut" value="{{ old('tindak_lanjut', $stunting->tindak_lanjut) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('tindak_lanjut')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_tindak_lanjut" class="block text-sm font-medium text-gray-700">Warna Tindak Lanjut</label>
                <select name="warna_tindak_lanjut" id="warna_tindak_lanjut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Sehat" {{ old('warna_tindak_lanjut', $stunting->warna_tindak_lanjut) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                    <option value="Waspada" {{ old('warna_tindak_lanjut', $stunting->warna_tindak_lanjut) == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                    <option value="Bahaya" {{ old('warna_tindak_lanjut', $stunting->warna_tindak_lanjut) == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                </select>
                @error('warna_tindak_lanjut')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto Kartu Identitas</label>
                @if ($stunting->foto)
                    <img src="{{ Storage::url($stunting->foto) }}" alt="Foto Stunting" class="w-16 h-16 object-cover rounded mb-2">
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