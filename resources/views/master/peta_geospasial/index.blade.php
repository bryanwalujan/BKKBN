<!DOCTYPE html>
<html>
<head>
    <title>Peta Geospasial</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        #map { height: 600px; }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Peta Geospasial</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <div class="flex space-x-4 mb-4">
            <form action="{{ route('peta_geospasial.index') }}" method="GET" class="flex space-x-2">
                <select name="kecamatan" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="">Semua Kecamatan</option>
                    @foreach ($kecamatans as $kec)
                        <option value="{{ $kec }}" {{ $kecamatan == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
                <select name="status_gizi" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    <option value="">Semua Status Gizi</option>
                    @foreach ($statusGizis as $status)
                        <option value="{{ $status }}" {{ $status_gizi == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Filter</button>
            </form>
            <a href="{{ route('kartu_keluarga.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola Kartu Keluarga</a>
        </div>
        <div id="map" class="w-full bg-white shadow-md rounded"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([1.319558, 124.838108], 13); // Koordinat tengah Indonesia

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Data Kartu Keluarga dari PHP
        var kartuKeluargas = @json($kartuKeluargas);

        // Warna marker berdasarkan status gizi
        function getMarkerColor(statusGizi) {
            switch(statusGizi) {
                case 'Sehat': return 'green';
                case 'Waspada': return 'yellow';
                case 'Bahaya': return 'red';
                default: return 'blue';
            }
        }

        // Tambahkan marker untuk setiap Kartu Keluarga
        kartuKeluargas.forEach(function(kk) {
            if (kk.latitude && kk.longitude) {
                // Hitung status gizi dominan untuk popup
                var balitas = kk.balitas || [];
                var statusGiziSummary = balitas.length > 0 ? 
                    balitas.map(b => b.status_gizi).join(', ') : 'Tidak ada balita';

                // Buat popup dengan informasi
                var popupContent = `
                    <b>No KK:</b> ${kk.no_kk}<br>
                    <b>Kepala Keluarga:</b> ${kk.kepala_keluarga}<br>
                    <b>Alamat:</b> ${kk.alamat || '-'}<br>
                    <b>Kecamatan:</b> ${kk.kecamatan}<br>
                    <b>Kelurahan:</b> ${kk.kelurahan}<br>
                    <b>Jumlah Balita:</b> ${balitas.length}<br>
                    <b>Status Gizi Balita:</b> ${statusGiziSummary}<br>
                    <a href="{{ url('kartu_keluarga') }}/${kk.id}/edit" class="text-blue-500 hover:underline">Edit KK</a>
                `;

                // Warna marker berdasarkan status gizi terburuk
                var worstStatus = balitas.length > 0 ? 
                    (balitas.some(b => b.status_gizi === 'Bahaya') ? 'Bahaya' :
                    balitas.some(b => b.status_gizi === 'Waspada') ? 'Waspada' : 'Sehat') : 'Sehat';

                // Buat ikon marker dengan warna dinamis
                var markerIcon = L.divIcon({
                    className: 'custom-icon',
                    html: `<div style="background-color: ${getMarkerColor(worstStatus)}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white;"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                    popupAnchor: [0, -10]
                });

                // Tambahkan marker ke peta
                L.marker([kk.latitude, kk.longitude], { icon: markerIcon })
                    .addTo(map)
                    .bindPopup(popupContent);
            }
        });

        // Sesuaikan peta agar menampilkan semua marker
        if (kartuKeluargas.length > 0) {
            var group = new L.featureGroup(
                kartuKeluargas
                    .filter(kk => kk.latitude && kk.longitude)
                    .map(kk => L.marker([kk.latitude, kk.longitude]))
            );
            map.fitBounds(group.getBounds(), { padding: [50, 50] });
        }
    </script>
</body>
</html>