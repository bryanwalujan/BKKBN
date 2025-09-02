<!DOCTYPE html>
<html>
<head>
    <title>Edit Lokasi Geospasial</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map { height: 400px; }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Lokasi Geospasial</h2>
        <form action="{{ route('peta_geospasial.update', $petaGeospasial->id) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nama_lokasi" class="block text-sm font-medium text-gray-700">Nama Lokasi</label>
                <input type="text" name="nama_lokasi" id="nama_lokasi" value="{{ old('nama_lokasi', $petaGeospasial->nama_lokasi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('nama_lokasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $petaGeospasial->kecamatan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kecamatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $petaGeospasial->kelurahan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('kelurahan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" disabled>-- Pilih Status --</option>
                    <option value="Aktif" {{ old('status', $petaGeospasial->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-Aktif" {{ old('status', $petaGeospasial->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $petaGeospasial->latitude) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required readonly>
                @error('latitude')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $petaGeospasial->longitude) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required readonly>
                @error('longitude')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis</label>
                <input type="text" name="jenis" id="jenis" value="{{ old('jenis', $petaGeospasial->jenis) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('jenis')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="warna_marker" class="block text-sm font-medium text-gray-700">Warna Marker</label>
                <select name="warna_marker" id="warna_marker" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="" disabled>-- Pilih Warna --</option>
                    <option value="Merah" {{ old('warna_marker', $petaGeospasial->warna_marker) == 'Merah' ? 'selected' : '' }}>Merah</option>
                    <option value="Biru" {{ old('warna_marker', $petaGeospasial->warna_marker) == 'Biru' ? 'selected' : '' }}>Biru</option>
                    <option value="Hijau" {{ old('warna_marker', $petaGeospasial->warna_marker) == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                </select>
                @error('warna_marker')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Ambil Lokasi dari Peta</label>
                <div id="map" class="mt-1"></div>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
    <script>
        var map = L.map('map').setView([{{ $petaGeospasial->latitude }}, {{ $petaGeospasial->longitude }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ $petaGeospasial->latitude }}, {{ $petaGeospasial->longitude }}]).addTo(map);

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            marker.setLatLng([lat, lng]);
        });
    </script>
</body>
</html>