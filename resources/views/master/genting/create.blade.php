<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kegiatan Genting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #000 !important;
        }
        .select2-container--default .select2-results__option {
            color: #000;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #000;
        }
        .select2-container--default .select2-selection--single {
            color: #000;
        }
        select, option {
            color: #000 !important;
        }
        select option:checked, select option:hover {
            color: #000 !important;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Kegiatan Genting</h2>
        <form action="{{ route('genting.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kartu Keluarga</option>
                    @foreach ($kartuKeluargas as $kk)
                        <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                    @endforeach
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama_kegiatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tanggal')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('lokasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="sasaran" class="block text-sm font-medium text-gray-700">Sasaran</label>
                <input type="text" name="sasaran" id="sasaran" value="{{ old('sasaran') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('sasaran')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis_intervensi" class="block text-sm font-medium text-gray-700">Jenis Intervensi</label>
                <input type="text" name="jenis_intervensi" id="jenis_intervensi" value="{{ old('jenis_intervensi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('jenis_intervensi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                <textarea name="narasi" id="narasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="5">{{ old('narasi') }}</textarea>
                @error('narasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="dokumentasi" class="block text-sm font-medium text-gray-700">Dokumentasi</label>
                <input type="file" name="dokumentasi" id="dokumentasi" class="mt-1 block w-full" accept="image/*">
                @error('dokumentasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Jenis dan Bentuk Kegiatan</h3>
                @foreach (['dunia_usaha', 'pemerintah', 'bumn_bumd', 'individu_perseorangan', 'lsm_komunitas', 'swasta', 'perguruan_tinggi_akademisi', 'media', 'tim_pendamping_keluarga', 'tokoh_masyarakat'] as $pihak)
                    <div class="mt-2">
                        <label for="{{ $pihak }}" class="block text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $pihak)) }}</label>
                        <select name="{{ $pihak }}" id="{{ $pihak }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 pihak-select">
                            <option value="">Pilih</option>
                            <option value="ada" {{ old($pihak) == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old($pihak) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error($pihak)
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-2 {{ old($pihak) == 'ada' ? '' : 'hidden' }}" id="{{ $pihak }}_frekuensi_container">
                            <label for="{{ $pihak }}_frekuensi" class="block text-sm font-medium text-gray-700">Frekuensi (kali per minggu/bulan)</label>
                            <input type="text" name="{{ $pihak }}_frekuensi" id="{{ $pihak }}_frekuensi" value="{{ old($pihak . '_frekuensi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error($pihak . '_frekuensi')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
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

            $('.pihak-select').each(function() {
                $(this).select2({
                    placeholder: 'Pilih',
                    allowClear: true
                });
                $(this).on('change', function() {
                    var container = $('#' + this.id + '_frekuensi_container');
                    if (this.value === 'ada') {
                        container.removeClass('hidden');
                    } else {
                        container.addClass('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>