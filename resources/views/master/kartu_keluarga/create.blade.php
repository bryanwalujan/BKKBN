<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kartu Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        #map { height: 400px; margin-bottom: 1rem; }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Kartu Keluarga</h2>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if ($kecamatans->isEmpty())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                Tidak ada data Kecamatan. Silakan tambahkan Kecamatan terlebih dahulu.
            </div>
        @else
            <form action="{{ route('kartu_keluarga.store') }}" method="POST" class="bg-white p-6 rounded shadow">
                @csrf
                <div class="mb-4">
                    <label for="no_kk" class="block text-sm font-medium text-gray-700">Nomor KK</label>
                    <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('no_kk')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kepala_keluarga" class="block text-sm font-medium text-gray-700">Kepala Keluarga</label>
                    <input type="text" name="kepala_keluarga" id="kepala_keluarga" value="{{ old('kepala_keluarga') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('kepala_keluarga')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="updateKelurahan(this.value)" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
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
                    </select>
                    @error('kelurahan_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat') }}</textarea>
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
                            <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required readonly>
                            @error('latitude')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                            <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required readonly>
                            @error('longitude')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    <a href="{{ route('kartu_keluarga.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                </div>
            </form>
        @endif
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([1.319558, 124.838108], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = null;

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
        }

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
            updateCoordinates(lat, lng);
        });

        var oldLat = {{ old('latitude', 'null') }};
        var oldLng = {{ old('longitude', 'null') }};
        if (oldLat && oldLng) {
            marker = L.marker([oldLat, oldLng]).addTo(map);
            map.setView([oldLat, oldLng], 15);
            updateCoordinates(oldLat, oldLng);
        }

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
                        kelurahanSelect.innerHTML += `<option value="${kelurahan.id}">${kelurahan.nama_kelurahan}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching kelurahans:', error);
                    alert('Gagal memuat data kelurahan. Silakan coba lagi.');
                });
        }
    </script>
</body>
</html>