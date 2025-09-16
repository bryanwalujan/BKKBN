<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Balita</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Balita</h2>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('kelurahan.balita.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Kartu Keluarga</label>
                    <select name="kartu_keluarga_id" class="w-full border p-2 rounded">
                        <option value="">Pilih Kartu Keluarga</option>
                        @foreach ($kartuKeluargas as $kk)
                            <option value="{{ $kk->id }}">{{ $kk->nomor_kk }} - {{ $kk->nama_kepala_keluarga }}</option>
                        @endforeach
                    </select>
                    @error('kartu_keluarga_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border p-2 rounded" maxlength="255">
                    @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border p-2 rounded" maxlength="255">
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border p-2 rounded">
                    @error('tanggal_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full border p-2 rounded">
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Berat (kg)</label>
                    <input type="number" name="berat" value="{{ old('berat') }}" step="0.1" class="w-full border p-2 rounded">
                    @error('berat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Tinggi (cm)</label>
                    <input type="number" name="tinggi" value="{{ old('tinggi') }}" step="0.1" class="w-full border p-2 rounded">
                    @error('tinggi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Lingkar Kepala (cm)</label>
                    <input type="number" name="lingkar_kepala" value="{{ old('lingkar_kepala') }}" step="0.1" class="w-full border p-2 rounded">
                    @error('lingkar_kepala') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Lingkar Lengan (cm)</label>
                    <input type="number" name="lingkar_lengan" value="{{ old('lingkar_lengan') }}" step="0.1" class="w-full border p-2 rounded">
                    @error('lingkar_lengan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full border p-2 rounded" maxlength="255">
                    @error('alamat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Status Gizi</label>
                    <select name="status_gizi" class="w-full border p-2 rounded">
                        <option value="Sehat" {{ old('status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Stunting" {{ old('status_gizi') == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                        <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                        <option value="Obesitas" {{ old('status_gizi') == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                    </select>
                    @error('status_gizi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Warna Label</label>
                    <select name="warna_label" class="w-full border p-2 rounded">
                        <option value="Sehat" {{ old('warna_label') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Waspada" {{ old('warna_label') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                        <option value="Bahaya" {{ old('warna_label') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                    </select>
                    @error('warna_label') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Status Pemantauan</label>
                    <input type="text" name="status_pemantauan" value="{{ old('status_pemantauan') }}" class="w-full border p-2 rounded" maxlength="255">
                    @error('status_pemantauan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Foto</label>
                    <input type="file" name="foto" accept="image/*" class="w-full border p-2 rounded">
                    @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('kelurahan.balita.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>