<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Audit Stunting</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Audit Stunting</h2>
        <a href="{{ route('perangkat_daerah.audit_stunting.index', ['tab' => $source]) }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if ($source == 'pending' && $auditStunting->status_verifikasi != 'pending')
            <div class="bg-yellow-100 text-yellow-700 p-4 mb-4 rounded">
                Data ini memiliki status {{ ucfirst($auditStunting->status_verifikasi) }} dan tidak dapat diedit.
            </div>
        @else
            <form method="POST" action="{{ route('perangkat_daerah.audit_stunting.update', [$auditStunting->id, $source]) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="data_monitoring_id" class="block text-sm font-medium text-gray-700">Data Monitoring</label>
                        <select name="data_monitoring_id" id="data_monitoring_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                            <option value="{{ $auditStunting->data_monitoring_id }}" selected>{{ $auditStunting->dataMonitoring->nama }} ({{ $auditStunting->dataMonitoring->target }} - {{ $auditStunting->dataMonitoring->kategori }})</option>
                        </select>
                        @error('data_monitoring_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pengaudit</label>
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <p class="mt-1 text-sm text-gray-600">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
                    </div>
                    <div>
                        <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                        <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                            <option value="">Pilih Kelurahan</option>
                            @foreach ($kelurahans as $kelurahan)
                                <option value="{{ $kelurahan->id }}" {{ $auditStunting->dataMonitoring->kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                            @endforeach
                        </select>
                        @error('kelurahan_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="pihak_pengaudit" class="block text-sm font-medium text-gray-700">Pihak Pengaudit</label>
                        <input type="text" name="pihak_pengaudit" id="pihak_pengaudit" value="{{ old('pihak_pengaudit', $auditStunting->pihak_pengaudit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        @error('pihak_pengaudit')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="foto_dokumentasi" class="block text-sm font-medium text-gray-700">Foto Dokumentasi</label>
                        <input type="file" name="foto_dokumentasi" id="foto_dokumentasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @if ($auditStunting->foto_dokumentasi)
                            <p class="mt-1 text-sm text-gray-600">File saat ini: <a href="{{ Storage::url($auditStunting->foto_dokumentasi) }}" target="_blank">Lihat</a></p>
                        @endif
                        @error('foto_dokumentasi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="laporan" class="block text-sm font-medium text-gray-700">Laporan</label>
                        <textarea name="laporan" id="laporan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('laporan', $auditStunting->laporan) }}</textarea>
                        @error('laporan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                        <textarea name="narasi" id="narasi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('narasi', $auditStunting->narasi) }}</textarea>
                        @error('narasi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            </form>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data_monitoring_id').select2({
                placeholder: 'Pilih Data Monitoring',
                allowClear: true,
                ajax: {
                    url: '{{ route("perangkat_daerah.audit_stunting.getDataMonitoring", Auth::user()->kecamatan_id) }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama + ' (' + item.target + ' - ' + item.kategori + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true
            });

            $('#data_monitoring_id').on('change', function() {
                var dataMonitoringId = $(this).val();
                if (dataMonitoringId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.audit_stunting.getKelurahan", ":id") }}'.replace(':id', dataMonitoringId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                            $.each(data.kelurahans, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.text + '</option>');
                            });
                            $('#kelurahan_id').val(data.kelurahan_id).trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahan:', xhr.responseText);
                            alert('Gagal memuat data kelurahan. Silakan coba lagi.');
                        }
                    });
                } else {
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').trigger('change');
                }
            });
        });
    </script>
</body>
</html>