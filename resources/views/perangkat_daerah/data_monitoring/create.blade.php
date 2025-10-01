<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Monitoring</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Monitoring</h2>
        <a href="{{ route('perangkat_daerah.data_monitoring.index', ['tab' => 'pending']) }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('perangkat_daerah.data_monitoring.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="target" class="block text-sm font-medium text-gray-700">Target Monitoring</label>
                <select name="target" id="target" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Target</option>
                    <option value="Ibu" {{ old('target') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                    <option value="Balita" {{ old('target') == 'Balita' ? 'selected' : '' }}>Balita</option>
                </select>
                @error('target')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
            </div>
            <div class="mb-4">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kelurahan</option>
                    @foreach ($kelurahans as $kelurahan)
                        <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                    @endforeach
                </select>
                @error('kelurahan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kartu Keluarga</option>
                    @if ($kartuKeluarga)
                        <option value="{{ $kartuKeluarga->id }}" selected>{{ $kartuKeluarga->no_kk }} - {{ $kartuKeluarga->kepala_keluarga }}</option>
                    @endif
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="ibu_id_div" style="display: {{ old('target') == 'Ibu' ? 'block' : 'none' }};">
                <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="">Pilih Nama Ibu</option>
                </select>
                @error('ibu_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="balita_id_div" style="display: {{ old('target') == 'Balita' ? 'block' : 'none' }};">
                <label for="balita_id" class="block text-sm font-medium text-gray-700">Nama Balita</label>
                <select name="balita_id" id="balita_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="">Pilih Nama Balita</option>
                </select>
                @error('balita_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoriOptions as $kategoriOption)
                        <option value="{{ $kategoriOption }}" {{ old('kategori') == $kategoriOption ? 'selected' : '' }}>{{ $kategoriOption }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="perkembangan_anak" class="block text-sm font-medium text-gray-700">Perkembangan Anak</label>
                <textarea name="perkembangan_anak" id="perkembangan_anak" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('perkembangan_anak') }}</textarea>
                @error('perkembangan_anak')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kunjungan_rumah" class="block text-sm font-medium text-gray-700">Kunjungan Rumah</label>
                <select name="kunjungan_rumah" id="kunjungan_rumah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="0" {{ old('kunjungan_rumah') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                    <option value="1" {{ old('kunjungan_rumah') == '1' ? 'selected' : '' }}>Ada</option>
                </select>
                @error('kunjungan_rumah')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="frekuensi_kunjungan_div" style="display: {{ old('kunjungan_rumah') == '1' ? 'block' : 'none' }};">
                <label for="frekuensi_kunjungan" class="block text-sm font-medium text-gray-700">Frekuensi Kunjungan</label>
                <select name="frekuensi_kunjungan" id="frekuensi_kunjungan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="" {{ old('frekuensi_kunjungan') == '' ? 'selected' : '' }}>Pilih Frekuensi</option>
                    <option value="Per Minggu" {{ old('frekuensi_kunjungan') == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                    <option value="Per Bulan" {{ old('frekuensi_kunjungan') == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                    <option value="Per 3 Bulan" {{ old('frekuensi_kunjungan') == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                </select>
                @error('frekuensi_kunjungan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pemberian_pmt" class="block text-sm font-medium text-gray-700">Pemberian PMT</label>
                <select name="pemberian_pmt" id="pemberian_pmt" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="0" {{ old('pemberian_pmt') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                    <option value="1" {{ old('pemberian_pmt') == '1' ? 'selected' : '' }}>Ada</option>
                </select>
                @error('pemberian_pmt')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="frekuensi_pmt_div" style="display: {{ old('pemberian_pmt') == '1' ? 'block' : 'none' }};">
                <label for="frekuensi_pmt" class="block text-sm font-medium text-gray-700">Frekuensi PMT</label>
                <select name="frekuensi_pmt" id="frekuensi_pmt" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="" {{ old('frekuensi_pmt') == '' ? 'selected' : '' }}>Pilih Frekuensi</option>
                    <option value="Per Minggu" {{ old('frekuensi_pmt') == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                    <option value="Per Bulan" {{ old('frekuensi_pmt') == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                    <option value="Per 3 Bulan" {{ old('frekuensi_pmt') == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                </select>
                @error('frekuensi_pmt')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Status</option>
                    @foreach ($statusOptions as $statusOption)
                        <option value="{{ $statusOption }}" {{ old('status') == $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_badge" class="block text-sm font-medium text-gray-700">Warna Badge</label>
                <select name="warna_badge" id="warna_badge" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="Hijau" {{ old('warna_badge') == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                    <option value="Kuning" {{ old('warna_badge') == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                    <option value="Merah" {{ old('warna_badge') == 'Merah' ? 'selected' : '' }}>Merah</option>
                    <option value="Biru" {{ old('warna_badge') == 'Biru' ? 'selected' : '' }}>Biru</option>
                </select>
                @error('warna_badge')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_monitoring" class="block text-sm font-medium text-gray-700">Tanggal Monitoring</label>
                <input type="date" name="tanggal_monitoring" id="tanggal_monitoring" value="{{ old('tanggal_monitoring') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('tanggal_monitoring')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required min="1">
                @error('urutan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_aktif" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                <select name="status_aktif" id="status_aktif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status_aktif')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#target').select2({ placeholder: 'Pilih Target', allowClear: true });
            $('#kelurahan_id').select2({ placeholder: 'Pilih Kelurahan', allowClear: true });
            $('#kartu_keluarga_id').select2({ placeholder: 'Pilih Kartu Keluarga', allowClear: true });
            $('#ibu_id').select2({ placeholder: 'Pilih Nama Ibu', allowClear: true });
            $('#balita_id').select2({ placeholder: 'Pilih Nama Balita', allowClear: true });
            $('#kategori').select2({ placeholder: 'Pilih Kategori', allowClear: true });
            $('#status').select2({ placeholder: 'Pilih Status', allowClear: true });
            $('#kunjungan_rumah').select2({ placeholder: 'Pilih Kunjungan Rumah', allowClear: true });
            $('#pemberian_pmt').select2({ placeholder: 'Pilih Pemberian PMT', allowClear: true });
            $('#frekuensi_kunjungan').select2({ placeholder: 'Pilih Frekuensi', allowClear: true });
            $('#frekuensi_pmt').select2({ placeholder: 'Pilih Frekuensi', allowClear: true });
            $('#warna_badge').select2({ placeholder: 'Pilih Warna Badge', allowClear: true });
            $('#status_aktif').select2({ placeholder: 'Pilih Status Aktif', allowClear: true });

            // Show/hide ibu_id and balita_id based on target
            $('#target').on('change', function() {
                var target = $(this).val();
                if (target === 'Ibu') {
                    $('#ibu_id_div').show();
                    $('#balita_id_div').hide();
                    $('#balita_id').val('').trigger('change');
                } else if (target === 'Balita') {
                    $('#balita_id_div').show();
                    $('#ibu_id_div').hide();
                    $('#ibu_id').val('').trigger('change');
                } else {
                    $('#ibu_id_div').hide();
                    $('#balita_id_div').hide();
                    $('#ibu_id').val('').trigger('change');
                    $('#balita_id').val('').trigger('change');
                }
            });

            // Show/hide frekuensi_kunjungan based on kunjungan_rumah
            $('#kunjungan_rumah').on('change', function() {
                if ($(this).val() === '1') {
                    $('#frekuensi_kunjungan_div').show();
                } else {
                    $('#frekuensi_kunjungan_div').hide();
                    $('#frekuensi_kunjungan').val('').trigger('change');
                }
            });

            // Show/hide frekuensi_pmt based on pemberian_pmt
            $('#pemberian_pmt').on('change', function() {
                if ($(this).val() === '1') {
                    $('#frekuensi_pmt_div').show();
                } else {
                    $('#frekuensi_pmt_div').hide();
                    $('#frekuensi_pmt').val('').trigger('change');
                }
            });

            // Load kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                var kelurahanId = $(this).val();
                if (kelurahanId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.data_monitoring.getKartuKeluargaByKelurahan", ":kelurahan_id") }}'.replace(':kelurahan_id', kelurahanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                            $.each(data, function(index, kk) {
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                            $('#kartu_keluarga_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kartu keluarga:', xhr.responseText);
                            alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                        }
                    });
                } else {
                    $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                    $('#kartu_keluarga_id').trigger('change');
                }
            });

            // Load ibu and balita when kartu keluarga changes
            $('#kartu_keluarga_id').on('change', function() {
                var kartuKeluargaId = $(this).val();
                if (kartuKeluargaId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.data_monitoring.getIbuAndBalita", ":kartu_keluarga_id") }}'.replace(':kartu_keluarga_id', kartuKeluargaId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#ibu_id').empty().append('<option value="">Pilih Nama Ibu</option>');
                            if (data.ibus && data.ibus.length > 0) {
                                $.each(data.ibus, function(index, ibu) {
                                    $('#ibu_id').append('<option value="' + ibu.id + '">' + ibu.nama + '</option>');
                                });
                            } else {
                                $('#ibu_id').append('<option value="" disabled>Tidak ada data ibu</option>');
                            }

                            $('#balita_id').empty().append('<option value="">Pilih Nama Balita</option>');
                            if (data.balitas && data.balitas.length > 0) {
                                $.each(data.balitas, function(index, balita) {
                                    $('#balita_id').append('<option value="' + balita.id + '">' + balita.nama + '</option>');
                                });
                            } else {
                                $('#balita_id').append('<option value="" disabled>Tidak ada data balita</option>');
                            }

                            $('#ibu_id').trigger('change');
                            $('#balita_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching ibu and balita:', xhr.responseText);
                            alert('Gagal memuat data ibu dan balita: ' + (xhr.responseJSON?.error || 'Silakan coba lagi.'));
                        }
                    });
                } else {
                    $('#ibu_id').empty().append('<option value="">Pilih Nama Ibu</option>');
                    $('#balita_id').empty().append('<option value="">Pilih Nama Balita</option>');
                    $('#ibu_id').trigger('change');
                    $('#balita_id').trigger('change');
                }
            });

            // Load initial kartu keluarga and ibu/balita if applicable
            @if (old('kelurahan_id'))
                $('#kelurahan_id').val('{{ old('kelurahan_id') }}').trigger('change');
            @endif
            @if ($kartuKeluarga)
                $('#kartu_keluarga_id').val('{{ $kartuKeluarga->id }}').trigger('change');
            @endif
        });
    </script>
</body>
</html>