<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Remaja Putri</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Remaja Putri</h2>
        <form action="{{ route('remaja_putri.update', $remajaPutri->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $remajaPutri->nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="sekolah" class="block text-sm font-medium text-gray-700">Sekolah</label>
                <input type="text" name="sekolah" id="sekolah" value="{{ old('sekolah', $remajaPutri->sekolah) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('sekolah')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $remajaPutri->kelas) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kelas')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="umur" class="block text-sm font-medium text-gray-700">Umur</label>
                <input type="number" name="umur" id="umur" value="{{ old('umur', $remajaPutri->umur) }}" min="10" max="19" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('umur')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status_anemia" class="block text-sm font-medium text-gray-700">Status Anemia</label>
                <select name="status_anemia" id="status_anemia" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('status_anemia', $remajaPutri->status_anemia) == '' ? 'selected' : '' }}>-- Pilih Status Anemia --</option>
                    <option value="Tidak Anemia" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Tidak Anemia' ? 'selected' : '' }}>Tidak Anemia</option>
                    <option value="Anemia Ringan" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Anemia Ringan' ? 'selected' : '' }}>Anemia Ringan</option>
                    <option value="Anemia Sedang" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Anemia Sedang' ? 'selected' : '' }}>Anemia Sedang</option>
                    <option value="Anemia Berat" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Anemia Berat' ? 'selected' : '' }}>Anemia Berat</option>
                </select>
                @error('status_anemia')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="konsumsi_ttd" class="block text-sm font-medium text-gray-700">Konsumsi TTD</label>
                <select name="konsumsi_ttd" id="konsumsi_ttd" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == '' ? 'selected' : '' }}>-- Pilih Konsumsi TTD --</option>
                    <option value="Rutin" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == 'Rutin' ? 'selected' : '' }}>Rutin</option>
                    <option value="Tidak Rutin" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == 'Tidak Rutin' ? 'selected' : '' }}>Tidak Rutin</option>
                    <option value="Tidak Konsumsi" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == 'Tidak Konsumsi' ? 'selected' : '' }}>Tidak Konsumsi</option>
                </select>
                @error('konsumsi_ttd')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                @if ($remajaPutri->foto)
                    <img src="{{ Storage::url($remajaPutri->foto) }}" alt="Foto Remaja Putri" class="w-16 h-16 object-cover rounded mb-2">
                @endif
                <input type="file" name="foto" id="foto" class="mt-1 block w-full" accept="image/*">
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>