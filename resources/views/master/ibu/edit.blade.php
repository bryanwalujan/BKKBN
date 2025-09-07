<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function updateKelurahan(kecamatanId) {
            if (!kecamatanId) {
                document.getElementById('kelurahan_id').innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
                return;
            }
            fetch(`/kelurahans/by-kecamatan/${kecamatanId}`)
                .then(response => response.json())
                .then(data => {
                    const kelurahanSelect = document.getElementById('kelurahan_id');
                    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
                    data.forEach(kelurahan => {
                        kelurahanSelect.innerHTML += `<option value="${kelurahan.id}" ${kelurahan.id == '{{ old('kelurahan_id', $ibu->kelurahan_id) }}' ? 'selected' : ''}>${kelurahan.nama_kelurahan}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching kelurahans:', error);
                    alert('Gagal memuat data kelurahan. Silakan coba lagi.');
                });
        }
        // Load kelurahan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            const kecamatanId = document.getElementById('kecamatan_id').value;
            if (kecamatanId) {
                updateKelurahan(kecamatanId);
            }
        });
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Ibu</h2>
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
        <form action="{{ route('ibu.update', $ibu->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="nik" id="nik" value="{{ old('nik', $ibu->nik) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('nik')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $ibu->nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="updateKelurahan(this.value)" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $ibu->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih Kelurahan --</option>
                    @if (old('kelurahan_id', $ibu->kelurahan_id))
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $ibu->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    @endif
                </select>
                @error('kelurahan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                @if ($kartuKeluargas->isEmpty())
                    <p class="text-red-600 text-sm">Tidak ada data Kartu Keluarga. <a href="{{ route('kartu_keluarga.create') }}" class="text-blue-600 hover:underline">Tambah Kartu Keluarga</a> terlebih dahulu.</p>
                @else
                    <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Kartu Keluarga --</option>
                        @foreach ($kartuKeluargas as $kk)
                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $ibu->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                        @endforeach
                    </select>
                @endif
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $ibu->alamat) }}</textarea>
                @error('alamat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="" {{ old('status', $ibu->status) == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                    <option value="Hamil" {{ old('status', $ibu->status) == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                    <option value="Nifas" {{ old('status', $ibu->status) == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                    <option value="Menyusui" {{ old('status', $ibu->status) == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                    <option value="Tidak Aktif" {{ old('status', $ibu->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                @if ($ibu->foto)
                    <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="w-32 h-32 object-cover rounded mb-2">
                    <p class="text-sm text-gray-600">Unggah foto baru untuk mengganti foto saat ini.</p>
                @endif
                <input type="file" name="foto" id="foto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" accept="image/*">
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('ibu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>