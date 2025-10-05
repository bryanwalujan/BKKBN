<!DOCTYPE html>
<html>
<head>
    <title>Edit Kegiatan Genting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Kegiatan Genting</h2>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('genting.update', $genting->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Pilih Kartu Keluarga</option>
                    @foreach ($kartuKeluargas as $kk)
                        <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $genting->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                    @endforeach
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $genting->nama_kegiatan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('nama_kegiatan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $genting->tanggal ? $genting->tanggal->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('tanggal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $genting->lokasi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('lokasi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="sasaran" class="block text-sm font-medium text-gray-700">Sasaran</label>
                <input type="text" name="sasaran" id="sasaran" value="{{ old('sasaran', $genting->sasaran) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('sasaran')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="jenis_intervensi" class="block text-sm font-medium text-gray-700">Jenis Intervensi</label>
                <input type="text" name="jenis_intervensi" id="jenis_intervensi" value="{{ old('jenis_intervensi', $genting->jenis_intervensi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('jenis_intervensi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                <textarea name="narasi" id="narasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" rows="4">{{ old('narasi', $genting->narasi) }}</textarea>
                @error('narasi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="dokumentasi" class="block text-sm font-medium text-gray-700">Dokumentasi (Maks. 7MB)</label>
                @if ($genting->dokumentasi)
                    <p class="mt-2 text-sm text-gray-600">Dokumentasi saat ini: <a href="{{ Storage::url($genting->dokumentasi) }}" target="_blank" class="text-blue-500 hover:underline">Lihat file</a></p>
                @endif
                <input type="file" name="dokumentasi" id="dokumentasi" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('dokumentasi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach (['dunia_usaha', 'pemerintah', 'bumn_bumd', 'individu_perseorangan', 'lsm_komunitas', 'swasta', 'perguruan_tinggi_akademisi', 'media', 'tim_pendamping_keluarga', 'tokoh_masyarakat'] as $pihak)
                    <div>
                        <label for="{{ $pihak }}" class="block text-sm font-medium text-gray-700">{{ ucwords(str_replace('_', ' ', $pihak)) }}</label>
                        <select name="{{ $pihak }}" id="{{ $pihak }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pihak-select">
                            <option value="">Pilih</option>
                            <option value="ada" {{ old($pihak, $genting->$pihak) == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old($pihak, $genting->$pihak) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error($pihak)
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-2 {{ old($pihak, $genting->$pihak) == 'ada' ? '' : 'hidden' }}" id="{{ $pihak }}_frekuensi_container">
                            <label for="{{ $pihak }}_frekuensi" class="block text-sm font-medium text-gray-700">Frekuensi (kali per minggu/bulan)</label>
                            <input type="text" name="{{ $pihak }}_frekuensi" id="{{ $pihak }}_frekuensi" value="{{ old($pihak . '_frekuensi', $genting->{$pihak . '_frekuensi'}) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error($pihak . '_frekuensi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('genting.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            </div>
        </form>
    </div>
    <script>
        document.querySelectorAll('.pihak-select').forEach(select => {
            select.addEventListener('change', function() {
                const container = document.getElementById(this.id + '_frekuensi_container');
                if (this.value === 'ada') {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>