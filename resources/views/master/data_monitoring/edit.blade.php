<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Monitoring</title>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Monitoring</h2>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('data_monitoring.update', $dataMonitoring->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="target" class="block text-sm font-medium text-gray-700">Target Monitoring</label>
                <select name="target" id="target" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="Ibu" {{ old('target', $target) == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                    <option value="Balita" {{ old('target', $target) == 'Balita' ? 'selected' : '' }}>Balita</option>
                </select>
                @error('target')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $dataMonitoring->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kelurahan</option>
                    @foreach ($kelurahans as $kelurahan)
                        <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $dataMonitoring->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
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
                    @foreach ($kartuKeluargas as $kk)
                        <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $dataMonitoring->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                    @endforeach
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="ibu_id_div" style="display: {{ old('target', $target) == 'Ibu' ? 'block' : 'none' }};">
                <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="">Pilih Nama Ibu</option>
                </select>
                @error('ibu_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="balita_id_div" style="display: {{ old('target', $target) == 'Balita' ? 'block' : 'none' }};">
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
                        <option value="{{ $kategoriOption }}" {{ old('kategori', $dataMonitoring->kategori) == $kategoriOption ? 'selected' : '' }}>{{ $kategoriOption }}</option>
                    @endforeach
                </select>
                @error('kategori')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="perkembangan_anak" class="block text-sm font-medium text-gray-700">Perkembangan Anak</label>
                <textarea name="perkembangan_anak" id="perkembangan_anak" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('perkembangan_anak', $dataMonitoring->perkembangan_anak) }}</textarea>
                @error('perkembangan_anak')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kunjungan_rumah" class="block text-sm font-medium text-gray-700">Kunjungan Rumah</label>
                <select name="kunjungan_rumah" id="kunjungan_rumah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="0" {{ old('kunjungan_rumah', $dataMonitoring->kunjungan_rumah) == '0' ? 'selected' : '' }}>Tidak Ada</option>
                    <option value="1" {{ old('kunjungan_rumah', $dataMonitoring->kunjungan_rumah) == '1' ? 'selected' : '' }}>Ada</option>
                </select>
                @error('kunjungan_rumah')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="frekuensi_kunjungan_div" style="display: {{ old('kunjungan_rumah', $dataMonitoring->kunjungan_rumah) == '1' ? 'block' : 'none' }};">
                <label for="frekuensi_kunjungan" class="block text-sm font-medium text-gray-700">Frekuensi Kunjungan</label>
                <select name="frekuensi_kunjungan" id="frekuensi_kunjungan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="" {{ old('frekuensi_kunjungan', $dataMonitoring->frekuensi_kunjungan) == '' ? 'selected' : '' }}>Pilih Frekuensi</option>
                    <option value="Per Minggu" {{ old('frekuensi_kunjungan', $dataMonitoring->frekuensi_kunjungan) == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                    <option value="Per Bulan" {{ old('frekuensi_kunjungan', $dataMonitoring->frekuensi_kunjungan) == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                    <option value="Per 3 Bulan" {{ old('frekuensi_kunjungan', $dataMonitoring->frekuensi_kunjungan) == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                </select>
                @error('frekuensi_kunjungan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pemberian_pmt" class="block text-sm font-medium text-gray-700">Pemberian PMT</label>
                <select name="pemberian_pmt" id="pemberian_pmt" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="0" {{ old('pemberian_pmt', $dataMonitoring->pemberian_pmt) == '0' ? 'selected' : '' }}>Tidak Ada</option>
                    <option value="1" {{ old('pemberian_pmt', $dataMonitoring->pemberian_pmt) == '1' ? 'selected' : '' }}>Ada</option>
                </select>
                @error('pemberian_pmt')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4" id="frekuensi_pmt_div" style="display: {{ old('pemberian_pmt', $dataMonitoring->pemberian_pmt) == '1' ? 'block' : 'none' }};">
                <label for="frekuensi_pmt" class="block text-sm font-medium text-gray-700">Frekuensi PMT</label>
                <select name="frekuensi_pmt" id="frekuensi_pmt" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="" {{ old('frekuensi_pmt', $dataMonitoring->frekuensi_pmt) == '' ? 'selected' : '' }}>Pilih Frekuensi</option>
                    <option value="Per Minggu" {{ old('frekuensi_pmt', $dataMonitoring->frekuensi_pmt) == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                    <option value="Per Bulan" {{ old('frekuensi_pmt', $dataMonitoring->frekuensi_pmt) == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                    <option value="Per 3 Bulan" {{ old('frekuensi_pmt', $dataMonitoring->frekuensi_pmt) == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
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
                        <option value="{{ $statusOption }}" {{ old('status', $dataMonitoring->status) == $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                    @endforeach
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_badge" class="block text-sm font-medium text-gray-700">Warna Badge</label>
                <select name="warna_badge" id="warna_badge" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="Hijau" {{ old('warna_badge', $dataMonitoring->warna_badge) == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                    <option value="Kuning" {{ old('warna_badge', $dataMonitoring->warna_badge) == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                    <option value="Merah" {{ old('warna_badge', $dataMonitoring->warna_badge) == 'Merah' ? 'selected' : '' }}>Merah</option>
                    <option value="Biru" {{ old('warna_badge', $dataMonitoring->warna_badge) == 'Biru' ? 'selected' : '' }}>Biru</option>
                </select>
                @error('warna_badge')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_monitoring" class="block text-sm font-medium text-gray-700">Tanggal Monitoring</label>
                <input type="date" name="tanggal_monitoring" id="tanggal_monitoring" value="{{ old('tanggal_monitoring', $dataMonitoring->tanggal_monitoring->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('tanggal_monitoring')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $dataMonitoring->urutan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required min="1">
                @error('urutan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_aktif" class="block text-sm font-medium text-gray-700">Status Aktif</label>
                <select name="status_aktif" id="status_aktif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="1" {{ old('status_aktif', $dataMonitoring->status_aktif) == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif', $dataMonitoring->status_aktif) == '0' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status_aktif')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="border-t pt-4 mt-4">
                <h3 class="text-lg font-semibold mb-4">Audit Stunting</h3>
                <div class="mb-4">
                    <label for="audit_user_id" class="block text-sm font-medium text-gray-700">Pengaudit</label>
                    <select name="audit_user_id" id="audit_user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih Pengaudit</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('audit_user_id', $dataMonitoring->auditStunting->user_id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('audit_user_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="audit_foto_dokumentasi" class="block text-sm font-medium text-gray-700">Foto Dokumentasi</label>
                    @if ($dataMonitoring->auditStunting && $dataMonitoring->auditStunting->foto_dokumentasi)
                        <img src="{{ Storage::url($dataMonitoring->auditStunting->foto_dokumentasi) }}" alt="Foto Dokumentasi" class="w-32 h-32 object-cover rounded mb-2">
                    @endif
                    <input type="file" name="audit_foto_dokumentasi" id="audit_foto_dokumentasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('audit_foto_dokumentasi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="audit_pihak_pengaudit" class="block text-sm font-medium text-gray-700">Pihak Pengaudit</label>
                    <input type="text" name="audit_pihak_pengaudit" id="audit_pihak_pengaudit" value="{{ old('audit_pihak_pengaudit', $dataMonitoring->auditStunting->pihak_pengaudit ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('audit_pihak_pengaudit')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="audit_laporan" class="block text-sm font-medium text-gray-700">Laporan</label>
                    <textarea name="audit_laporan" id="audit_laporan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('audit_laporan', $dataMonitoring->auditStunting->laporan ?? '') }}</textarea>
                    @error('audit_laporan')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="audit_narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                    <textarea name="audit_narasi" id="audit_narasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('audit_narasi', $dataMonitoring->auditStunting->narasi ?? '') }}</textarea>
                    @error('audit_narasi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
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
            $('#kecamatan_id').select2({ placeholder: 'Pilih Kecamatan', allowClear: true });
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
            $('#audit_user_id').select2({ placeholder: 'Pilih Pengaudit', allowClear: true });

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

            // Load kelurahans and kartu keluarga on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == {{ old('kelurahan_id', $dataMonitoring->kelurahan_id) }} ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr.responseText);
                        alert('Gagal memuat kelurahan. Silakan coba lagi.');
                    }
                });
            }

            // Load kartu keluarga on page load
            var initialKelurahanId = $('#kelurahan_id').val();
            if (initialKecamatanId && initialKelurahanId) {
                $.ajax({
                    url: '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}?kecamatan_id=' + initialKecamatanId + '&kelurahan_id=' + initialKelurahanId,
                    type: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                        $.each(data, function(index, kk) {
                            var selected = kk.id == {{ old('kartu_keluarga_id', $dataMonitoring->kartu_keluarga_id) }} ? 'selected' : '';
                            $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                        });
                        $('#kartu_keluarga_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr.responseText);
                        alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                    }
                });
            }

            // Load ibu and balita on page load
            var initialKartuKeluargaId = $('#kartu_keluarga_id').val();
            if (initialKartuKeluargaId) {
                $.ajax({
                    url: '{{ route("kartu_keluarga.get-ibu-balita", ":kartu_keluarga_id") }}'.replace(':kartu_keluarga_id', initialKartuKeluargaId),
                    type: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        $('#ibu_id').empty().append('<option value="">Pilih Nama Ibu</option>');
                        if (data.ibus && data.ibus.length > 0) {
                            $.each(data.ibus, function(index, ibu) {
                                var selected = ibu.id == {{ old('ibu_id', $dataMonitoring->ibu_id ?? 'null') }} ? 'selected' : '';
                                $('#ibu_id').append('<option value="' + ibu.id + '" ' + selected + '>' + ibu.nama + '</option>');
                            });
                        } else {
                            $('#ibu_id').append('<option value="" disabled>Tidak ada data ibu</option>');
                        }

                        $('#balita_id').empty().append('<option value="">Pilih Nama Balita</option>');
                        if (data.balitas && data.balitas.length > 0) {
                            $.each(data.balitas, function(index, balita) {
                                var selected = balita.id == {{ old('balita_id', $dataMonitoring->balita_id ?? 'null') }} ? 'selected' : '';
                                $('#balita_id').append('<option value="' + balita.id + '" ' + selected + '>' + balita.nama + '</option>');
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
            }

            // Update kelurahans and kartu keluarga when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr.responseText);
                            alert('Gagal memuat kelurahan. Silakan coba lagi.');
                        }
                    });
                } else {
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
                updateKartuKeluarga();
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            // Update ibu and balita when kartu keluarga changes
            $('#kartu_keluarga_id').on('change', function() {
                updateIbuAndBalita();
            });

            function updateKartuKeluarga() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $('#kelurahan_id').val();
                if (kecamatanId && kelurahanId) {
                    $.ajax({
                        url: '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}?kecamatan_id=' + kecamatanId + '&kelurahan_id=' + kelurahanId,
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
            }

            function updateIbuAndBalita() {
                var kartuKeluargaId = $('#kartu_keluarga_id').val();
                if (kartuKeluargaId) {
                    $.ajax({
                        url: '{{ route("kartu_keluarga.get-ibu-balita", ":kartu_keluarga_id") }}'.replace(':kartu_keluarga_id', kartuKeluargaId),
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
            }
        });
    </script>
</body>
</html>