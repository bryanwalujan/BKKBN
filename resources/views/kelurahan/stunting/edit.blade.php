<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Stunting - Admin Kelurahan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Stunting</h2>
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
                {{ $kartuKeluargas->isEmpty() ? 'Tidak ada data Kartu Keluarga. ' : '' }}
                {{ !$kecamatan || !$kelurahan ? 'Data kecamatan atau kelurahan tidak ditemukan. ' : '' }}
                Silakan tambahkan data terlebih dahulu.
            </div>
        @else
            <form action="{{ route('kelurahan.stunting.update', $stunting->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
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
                        <option value="">Pilih Kartu Keluarga</option>
                        @foreach ($kartuKeluargas as $kk)
                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $stunting->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                        @endforeach
                    </select>
                    @error('kartu_keluarga_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik', $stunting->nik) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" pattern="[0-9]{16}" inputmode="numeric" maxlength="16" placeholder="Masukkan 16 digit NIK">
                    @error('nik')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $stunting->nama) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('nama')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $tanggalLahir) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('tanggal_lahir')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == '' ? 'selected' : '' }}>-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                    <input type="number" name="berat" id="berat" value="{{ old('berat', $beratTinggi[0]) }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('berat')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                    <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi', $beratTinggi[1]) }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('tinggi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="status_gizi" class="block text-sm font-medium text-gray-700">Status Gizi</label>
                    <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('status_gizi', $stunting->status_gizi) == '' ? 'selected' : '' }}>-- Pilih Status Gizi --</option>
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
                    <select name="warna_gizi" id="warna_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('warna_gizi', $stunting->warna_gizi) == '' ? 'selected' : '' }}>-- Pilih Warna Gizi --</option>
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
                    <input type="text" name="tindak_lanjut" id="tindak_lanjut" value="{{ old('tindak_lanjut', $stunting->tindak_lanjut) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('tindak_lanjut')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="warna_tindak_lanjut" class="block text-sm font-medium text-gray-700">Warna Tindak Lanjut</label>
                    <select name="warna_tindak_lanjut" id="warna_tindak_lanjut" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('warna_tindak_lanjut', $stunting->warna_tindak_lanjut) == '' ? 'selected' : '' }}>-- Pilih Warna Tindak Lanjut --</option>
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
                    <input type="file" name="foto" id="foto" class="mt-1 block w-full" accept="image/*">
                    @if ($stunting->foto)
                        <div class="mt-2">
                            <img src="{{ Storage::url($stunting->foto) }}" alt="Foto Stunting" class="w-16 h-16 object-cover rounded">
                            <p class="text-sm text-gray-600">File saat ini: {{ basename($stunting->foto) }}</p>
                        </div>
                    @endif
                    @error('foto')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    <a href="{{ route('kelurahan.stunting.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                </div>
            </form>
        @endif
    </div>
</body>
</html>