<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Calon Pengantin - Admin Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Calon Pengantin</h2>
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
        <form action="{{ route('kelurahan.catin.update', $catin->id) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="hari_tanggal" class="block text-sm font-medium text-gray-700">Hari/Tanggal</label>
                <input type="date" name="hari_tanggal" id="hari_tanggal" value="{{ old('hari_tanggal', $catin->hari_tanggal ? $catin->hari_tanggal->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('hari_tanggal')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <h3 class="text-lg font-semibold mt-6 mb-4">Biodata Catin Wanita</h3>
            <div class="mb-4">
                <label for="catin_wanita_nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="catin_wanita_nama" id="catin_wanita_nama" value="{{ old('catin_wanita_nama', $catin->catin_wanita_nama) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_wanita_nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_wanita_nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="catin_wanita_nik" id="catin_wanita_nik" value="{{ old('catin_wanita_nik', $catin->catin_wanita_nik) }}" maxlength="16" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" inputmode="numeric" maxlength="16" placeholder="Masukkan 16 digit NIK" inputmode="numeric" maxlength="16" placeholder="Masukkan 16 digit NIK">
                @error('catin_wanita_nik')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_wanita_tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input type="text" name="catin_wanita_tempat_lahir" id="catin_wanita_tempat_lahir" value="{{ old('catin_wanita_tempat_lahir', $catin->catin_wanita_tempat_lahir) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_wanita_tempat_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_wanita_tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="catin_wanita_tgl_lahir" id="catin_wanita_tgl_lahir" value="{{ old('catin_wanita_tgl_lahir', $catin->catin_wanita_tgl_lahir ? $catin->catin_wanita_tgl_lahir->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_wanita_tgl_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_wanita_no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
                <input type="text" name="catin_wanita_no_hp" id="catin_wanita_no_hp" value="{{ old('catin_wanita_no_hp', $catin->catin_wanita_no_hp) }}" maxlength="15" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_wanita_no_hp')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_wanita_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="catin_wanita_alamat" id="catin_wanita_alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('catin_wanita_alamat', $catin->catin_wanita_alamat) }}</textarea>
                @error('catin_wanita_alamat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <h3 class="text-lg font-semibold mt-6 mb-4">Biodata Catin Pria</h3>
            <div class="mb-4">
                <label for="catin_pria_nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="catin_pria_nama" id="catin_pria_nama" value="{{ old('catin_pria_nama', $catin->catin_pria_nama) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_pria_nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_pria_nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" name="catin_pria_nik" id="catin_pria_nik" value="{{ old('catin_pria_nik', $catin->catin_pria_nik) }}" maxlength="16" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" inputmode="numeric" maxlength="16" placeholder="Masukkan 16 digit NIK">
                @error('catin_pria_nik')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_pria_tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input type="text" name="catin_pria_tempat_lahir" id="catin_pria_tempat_lahir" value="{{ old('catin_pria_tempat_lahir', $catin->catin_pria_tempat_lahir) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_pria_tempat_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_pria_tgl_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="catin_pria_tgl_lahir" id="catin_pria_tgl_lahir" value="{{ old('catin_pria_tgl_lahir', $catin->catin_pria_tgl_lahir ? $catin->catin_pria_tgl_lahir->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_pria_tgl_lahir')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_pria_no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
                <input type="text" name="catin_pria_no_hp" id="catin_pria_no_hp" value="{{ old('catin_pria_no_hp', $catin->catin_pria_no_hp) }}" maxlength="15" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('catin_pria_no_hp')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="catin_pria_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="catin_pria_alamat" id="catin_pria_alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('catin_pria_alamat', $catin->catin_pria_alamat) }}</textarea>
                @error('catin_pria_alamat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <h3 class="text-lg font-semibold mt-6 mb-4">Hasil Pemeriksaan Catin Wanita</h3>
            <div class="mb-4">
                <label for="tanggal_pernikahan" class="block text-sm font-medium text-gray-700">Tanggal Pernikahan</label>
                <input type="date" name="tanggal_pernikahan" id="tanggal_pernikahan" value="{{ old('tanggal_pernikahan', $catin->tanggal_pernikahan ? $catin->tanggal_pernikahan->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('tanggal_pernikahan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="berat_badan" class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                <input type="number" name="berat_badan" id="berat_badan" value="{{ old('berat_badan', $catin->berat_badan) }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('berat_badan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tinggi_badan" class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                <input type="number" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan', $catin->tinggi_badan) }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('tinggi_badan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="imt" class="block text-sm font-medium text-gray-700">IMT</label>
                <input type="number" name="imt" id="imt" value="{{ old('imt', $catin->imt) }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('imt')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kadar_hb" class="block text-sm font-medium text-gray-700">Kadar HB (g/dL)</label>
                <input type="number" name="kadar_hb" id="kadar_hb" value="{{ old('kadar_hb', $catin->kadar_hb) }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('kadar_hb')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="merokok" class="block text-sm font-medium text-gray-700">Merokok</label>
                <select name="merokok" id="merokok" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" {{ old('merokok', $catin->merokok) == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                    <option value="Ya" {{ old('merokok', $catin->merokok) == 'Ya' ? 'selected' : '' }}>Ya</option>
                    <option value="Tidak" {{ old('merokok', $catin->merokok) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                </select>
                @error('merokok')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('kelurahan.catin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>