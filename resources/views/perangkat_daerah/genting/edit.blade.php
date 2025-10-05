<!DOCTYPE html>
<html>
<head>
    <title>Edit Kegiatan Genting - Perangkat Daerah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Kegiatan Genting - Kecamatan {{ $kecamatan->nama_kecamatan }}</h2>
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
        <form action="{{ route('perangkat_daerah.genting.update', $genting->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                <input type="file" name="dokumentasi" id="dokumentasi" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @if ($genting->dokumentasi)
                    <p class="mt-2 text-sm text-gray-600">Dokumentasi saat ini: <a href="{{ Storage::url($genting->dokumentasi) }}" target="_blank" class="text-blue-500 hover:underline">Lihat file</a></p>
                @endif
                @error('dokumentasi')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Dunia Usaha</label>
                    <select name="dunia_usaha" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('dunia_usaha', $genting->dunia_usaha) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('dunia_usaha', $genting->dunia_usaha) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="dunia_usaha_frekuensi" value="{{ old('dunia_usaha_frekuensi', $genting->dunia_usaha_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pemerintah</label>
                    <select name="pemerintah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('pemerintah', $genting->pemerintah) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('pemerintah', $genting->pemerintah) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="pemerintah_frekuensi" value="{{ old('pemerintah_frekuensi', $genting->pemerintah_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">BUMN dan BUMD</label>
                    <select name="bumn_bumd" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('bumn_bumd', $genting->bumn_bumd) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('bumn_bumd', $genting->bumn_bumd) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="bumn_bumd_frekuensi" value="{{ old('bumn_bumd_frekuensi', $genting->bumn_bumd_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Individu dan Perseorangan</label>
                    <select name="individu_perseorangan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('individu_perseorangan', $genting->individu_perseorangan) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('individu_perseorangan', $genting->individu_perseorangan) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="individu_perseorangan_frekuensi" value="{{ old('individu_perseorangan_frekuensi', $genting->individu_perseorangan_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">LSM dan Komunitas</label>
                    <select name="lsm_komunitas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('lsm_komunitas', $genting->lsm_komunitas) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('lsm_komunitas', $genting->lsm_komunitas) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="lsm_komunitas_frekuensi" value="{{ old('lsm_komunitas_frekuensi', $genting->lsm_komunitas_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Swasta</label>
                    <select name="swasta" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('swasta', $genting->swasta) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('swasta', $genting->swasta) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="swasta_frekuensi" value="{{ old('swasta_frekuensi', $genting->swasta_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Perguruan Tinggi dan Akademisi</label>
                    <select name="perguruan_tinggi_akademisi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('perguruan_tinggi_akademisi', $genting->perguruan_tinggi_akademisi) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('perguruan_tinggi_akademisi', $genting->perguruan_tinggi_akademisi) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="perguruan_tinggi_akademisi_frekuensi" value="{{ old('perguruan_tinggi_akademisi_frekuensi', $genting->perguruan_tinggi_akademisi_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Media</label>
                    <select name="media" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('media', $genting->media) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('media', $genting->media) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="media_frekuensi" value="{{ old('media_frekuensi', $genting->media_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tim Pendamping Keluarga</label>
                    <select name="tim_pendamping_keluarga" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('tim_pendamping_keluarga', $genting->tim_pendamping_keluarga) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('tim_pendamping_keluarga', $genting->tim_pendamping_keluarga) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="tim_pendamping_keluarga_frekuensi" value="{{ old('tim_pendamping_keluarga_frekuensi', $genting->tim_pendamping_keluarga_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tokoh Masyarakat</label>
                    <select name="tokoh_masyarakat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tidak</option>
                        <option value="ada" {{ old('tokoh_masyarakat', $genting->tokoh_masyarakat) == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('tokoh_masyarakat', $genting->tokoh_masyarakat) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <input type="text" name="tokoh_masyarakat_frekuensi" value="{{ old('tokoh_masyarakat_frekuensi', $genting->tokoh_masyarakat_frekuensi) }}" placeholder="Frekuensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Simpan</button>
                <a href="{{ route('perangkat_daerah.genting.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>