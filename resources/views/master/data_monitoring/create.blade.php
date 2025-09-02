<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function updateBadgePreview() {
            const status = document.getElementById('status').value;
            const warnaBadge = document.getElementById('warna_badge').value;
            const badgePreview = document.getElementById('badge_preview');
            badgePreview.className = 'px-2 py-1 rounded text-white';
            badgePreview.className += status === 'Normal' && warnaBadge === 'Hijau' ? ' bg-green-500' :
                                     warnaBadge === 'Kuning' ? ' bg-yellow-500' :
                                     warnaBadge === 'Merah' ? ' bg-red-500' : ' bg-blue-500';
            badgePreview.textContent = warnaBadge;
        }
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Monitoring</h2>
        <form action="{{ route('data_monitoring.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kelurahan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="Pencegahan Stunting" {{ old('kategori') == 'Pencegahan Stunting' ? 'selected' : '' }}>Pencegahan Stunting</option>
                    <option value="Gizi Balita" {{ old('kategori') == 'Gizi Balita' ? 'selected' : '' }}>Gizi Balita</option>
                    <option value="Kesehatan Ibu" {{ old('kategori') == 'Kesehatan Ibu' ? 'selected' : '' }}>Kesehatan Ibu</option>
                    <option value="Posyandu" {{ old('kategori') == 'Posyandu' ? 'selected' : '' }}>Posyandu</option>
                </select>
                @error('kategori')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="balita" class="block text-sm font-medium text-gray-700">Nama Balita</label>
                <input type="text" name="balita" id="balita" value="{{ old('balita') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('balita')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required onchange="updateBadgePreview()">
                    <option value="Normal" {{ old('status', 'Normal') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Kurang Gizi" {{ old('status') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                    <option value="Stunting" {{ old('status') == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                    <option value="Lainnya" {{ old('status') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_badge" class="block text-sm font-medium text-gray-700">Warna Badge</label>
                <select name="warna_badge" id="warna_badge" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required onchange="updateBadgePreview()">
                    <option value="Hijau" {{ old('warna_badge', 'Hijau') == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                    <option value="Kuning" {{ old('warna_badge') == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                    <option value="Merah" {{ old('warna_badge') == 'Merah' ? 'selected' : '' }}>Merah</option>
                    <option value="Biru" {{ old('warna_badge') == 'Biru' ? 'selected' : '' }}>Biru</option>
                </select>
                <span id="badge_preview" class="px-2 py-1 rounded text-white bg-green-500 mt-2 inline-block">{{ old('warna_badge', 'Hijau') }}</span>
                @error('warna_badge')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tanggal_monitoring" class="block text-sm font-medium text-gray-700">Tanggal Monitoring</label>
                <input type="date" name="tanggal_monitoring" id="tanggal_monitoring" value="{{ old('tanggal_monitoring') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('tanggal_monitoring')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="urutan" class="block text-sm font-medium text-gray-700">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 1) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1" required>
                @error('urutan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="status_aktif" id="status_aktif" class="form-checkbox" {{ old('status_aktif', 1) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Status Aktif</span>
                </label>
                @error('status_aktif')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>