<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Kegiatan Genting</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Kegiatan Genting</h2>
        <a href="{{ route('perangkat_daerah.genting.index', ['tab' => $source]) }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if ($source === 'pending' && $genting->status !== 'pending')
            <div class="bg-yellow-100 text-yellow-700 p-4 mb-4 rounded">
                Data ini memiliki status {{ ucfirst($genting->status) }} dan tidak dapat diedit.
            </div>
        @else
            <form method="POST" action="{{ route('perangkat_daerah.genting.update', ['id' => $genting->id, 'source' => $source]) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                        <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                            <option value="">Pilih Kartu Keluarga</option>
                            @foreach ($kartuKeluargas as $kk)
                                <option value="{{ $kk->id }}" {{ $genting->kartu_keluarga_id == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                            @endforeach
                        </select>
                        @error('kartu_keluarga_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                        <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
                    </div>
                    <div>
                        <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $genting->nama_kegiatan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        @error('nama_kegiatan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($genting->tanggal)->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        @error('tanggal')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $genting->lokasi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        @error('lokasi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="sasaran" class="block text-sm font-medium text-gray-700">Sasaran</label>
                        <input type="text" name="sasaran" id="sasaran" value="{{ old('sasaran', $genting->sasaran) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        @error('sasaran')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="jenis_intervensi" class="block text-sm font-medium text-gray-700">Jenis Intervensi</label>
                        <input type="text" name="jenis_intervensi" id="jenis_intervensi" value="{{ old('jenis_intervensi', $genting->jenis_intervensi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        @error('jenis_intervensi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="dokumentasi" class="block text-sm font-medium text-gray-700">Dokumentasi</label>
                        <input type="file" name="dokumentasi" id="dokumentasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @if ($genting->dokumentasi)
                            <p class="mt-1 text-sm text-gray-600">File saat ini: <a href="{{ Storage::url($genting->dokumentasi) }}" target="_blank">Lihat</a></p>
                        @endif
                        @error('dokumentasi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                        <textarea name="narasi" id="narasi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('narasi', $genting->narasi) }}</textarea>
                        @error('narasi')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Pihak Ketiga</label>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            @foreach (['dunia_usaha', 'pemerintah', 'bumn_bumd', 'individu_perseorangan', 'lsm_komunitas', 'swasta', 'perguruan_tinggi_akademisi', 'media', 'tim_pendamping_keluarga', 'tokoh_masyarakat'] as $pihak)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $pihak)) }}</label>
                                    <select name="{{ $pihak }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                                        <option value="">Pilih</option>
                                        <option value="ada" {{ old($pihak, $genting->$pihak) == 'ada' ? 'selected' : '' }}>Ada</option>
                                        <option value="tidak" {{ old($pihak, $genting->$pihak) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                    @error($pihak)
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    <label class="block text-sm font-medium text-gray-700 mt-2">Frekuensi</label>
                                    <input type="text" name="{{ $pihak }}_frekuensi" value="{{ old($pihak . '_frekuensi', $genting->{$pihak . '_frekuensi'}) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                                    @error($pihak . '_frekuensi')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
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
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });
        });
    </script>
</body>
</html>