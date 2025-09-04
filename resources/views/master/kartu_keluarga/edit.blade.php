<!DOCTYPE html>
<html>
<head>
    <title>Edit Kartu Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        #map { height: 400px; margin-bottom: 1rem; }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Kartu Keluarga</h2>
        <form action="{{ route('kartu_keluarga.update', $kartuKeluarga->id) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="no_kk" class="block text-sm font-medium text-gray-700">Nomor KK</label>
                <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $kartuKeluarga->no_kk) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('no_kk')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kepala_keluarga" class="block text-sm font-medium text-gray-700">Kepala Keluarga</label>
                <input type="text" name="kepala_keluarga" id="kepala_keluarga" value="{{ old('kepala_keluarga', $kartuKeluarga->kepala_keluarga) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('kepala_keluarga')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan', $kartuKeluarga->kecamatan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('kecamatan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan', $kartuKeluarga->kelurahan) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('kelurahan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('alamat', $kartuKeluarga->alamat) }}</textarea>
                @error('alamat')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Pilih Lokasi Rumah</label>
                <div id="map" class="w-full"></div>
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $kartuKeluarga->latitude) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required readonly>
                        @error('latitude')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $kartuKeluarga->longitude) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required readonly>
                        @error('longitude')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="Aktif" {{ old('status', $kartuKeluarga->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-Aktif" {{ old('status', $kartuKeluarga->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var initialLat = {{ old('latitude', $kartuKeluarga->latitude ?? 'null') }};
        var initialLng = {{ old('longitude', $kartuKeluarga->longitude ?? 'null') }};
        var map = L.map('map').setView(
            [initialLat || -2.5489, initialLng || 118.0149], 
            initialLat && initialLng ? 15 : 5
        ); // Koordinat tengah Indonesia jika tidak ada data

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Variabel untuk menyimpan marker
        var marker = null;

        // Fungsi untuk memperbarui input latitude dan longitude
        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
        }

        // Tambahkan marker awal jika ada koordinat
        if (initialLat && initialLng) {
            marker = L.marker([initialLat, initialLng]).addTo(map);
            updateCoordinates(initialLat, initialLng);
        }

        // Event listener untuk klik pada peta
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Hapus marker sebelumnya jika ada
            if (marker) {
                map.removeLayer(marker);
            }

            // Tambahkan marker baru
            marker = L.marker([lat, lng]).addTo(map);

            // Perbarui input form
            updateCoordinates(lat, lng);
        });
    </script>
</body>
</html>