<!DOCTYPE html>
<html>
<head>
    <title>Peta Geospasial</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 600px; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .custom-icon { transition: transform 0.2s; }
        .custom-icon:hover { transform: scale(1.2); }
        .popup-content { max-width: 300px; font-size: 14px; }
        .popup-content table { width: 100%; border-collapse: collapse; }
        .popup-content th, .popup-content td { padding: 4px; border-bottom: 1px solid #e5e7eb; }
        .popup-content th { text-align: left; font-weight: bold; }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Peta Geospasial</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('peta_geospasial.index') }}" method="GET" class="flex flex-wrap gap-4 mb-4">
            <div class="w-full sm:w-auto">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64" onchange="updateKelurahan(this.value)">
                    <option value="">Semua Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                    <option value="">Semua Kelurahan</option>
                    @foreach ($kelurahans as $kelurahan)
                        <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="status_kesehatan" class="block text-sm font-medium text-gray-700 mb-1">Status Kesehatan</label>
                <select name="status_kesehatan" id="status_kesehatan" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                    <option value="">Semua Status</option>
                    @foreach ($statusKesehatans as $status)
                        <option value="{{ $status }}" {{ $status_kesehatan == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end w-full sm:w-auto">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                <a href="{{ route('peta_geospasial.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
            </div>
        </form>
        <div class="mb-4">
            <a href="{{ route('kartu_keluarga.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola Kartu Keluarga</a>
        </div>
        <div id="map" class="w-full bg-white"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([1.319558, 124.838108], 13);

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Data Kartu Keluarga dari PHP
        var kartuKeluargas = @json($kartuKeluargas);

        // Warna marker berdasarkan status kesehatan terburuk
        function getMarkerColor(status) {
            switch(status) {
                case 'Bahaya':
                case 'Anemia Berat': return '#dc2626'; // Merah
                case 'Waspada':
                case 'Anemia Sedang': return '#f59e0b'; // Oranye
                case 'Anemia Ringan': return '#eab308'; // Kuning
                case 'Sehat':
                case 'Tidak Anemia': return '#22c55e'; // Hijau
                default: return '#3b82f6'; // Biru
            }
        }

        // Menentukan status kesehatan terburuk
        function getWorstStatus(kk) {
            const balitas = kk.balitas || [];
            const remajaPutris = kk.remaja_putris || [];
            const statuses = [
                ...balitas.map(b => b.status_gizi),
                ...remajaPutris.map(r => r.status_anemia)
            ];
            if (statuses.includes('Bahaya') || statuses.includes('Anemia Berat')) return 'Bahaya';
            if (statuses.includes('Waspada') || statuses.includes('Anemia Sedang')) return 'Waspada';
            if (statuses.includes('Anemia Ringan')) return 'Anemia Ringan';
            if (statuses.includes('Sehat') || statuses.includes('Tidak Anemia')) return 'Sehat';
            return 'Sehat';
        }

        // Tambahkan marker untuk setiap Kartu Keluarga
        var markers = [];
        kartuKeluargas.forEach(function(kk) {
            if (kk.latitude && kk.longitude) {
                const balitas = kk.balitas || [];
                const remajaPutris = kk.remaja_putris || [];

                // Buat tabel balita
                let balitaTable = '<table><tr><th>Nama</th><th>Status Gizi</th></tr>';
                balitas.forEach(b => {
                    const statusColor = getMarkerColor(b.status_gizi);
                    balitaTable += `<tr><td>${b.nama}</td><td><span style="color: ${statusColor}">${b.status_gizi}</span></td></tr>`;
                });
                balitaTable += balitas.length ? '</table>' : '<p>Tidak ada balita</p>';

                // Buat tabel remaja putri
                let remajaTable = '<table><tr><th>Nama</th><th>Status Anemia</th></tr>';
                remajaPutris.forEach(r => {
                    const statusColor = getMarkerColor(r.status_anemia);
                    remajaTable += `<tr><td>${r.nama}</td><td><span style="color: ${statusColor}">${r.status_anemia}</span></td></tr>`;
                });
                remajaTable += remajaPutris.length ? '</table>' : '<p>Tidak ada remaja putri</p>';

                // Buat popup content
                const popupContent = `
                    <div class="popup-content">
                        <p><b>No KK:</b> ${kk.no_kk}</p>
                        <p><b>Kepala Keluarga:</b> ${kk.kepala_keluarga}</p>
                        <p><b>Alamat:</b> ${kk.alamat || '-'}</p>
                        <p><b>Kecamatan:</b> ${kk.kecamatan?.nama_kecamatan || '-'}</p>
                        <p><b>Kelurahan:</b> ${kk.kelurahan?.nama_kelurahan || '-'}</p>
                        <p><b>Jumlah Balita:</b> ${balitas.length}</p>
                        <p><b>Jumlah Remaja Putri:</b> ${remajaPutris.length}</p>
                        <h3 class="font-semibold mt-2">Balita:</h3>
                        ${balitaTable}
                        <h3 class="font-semibold mt-2">Remaja Putri:</h3>
                        ${remajaTable}
                        <div class="mt-2 flex gap-2">
                            <a href="{{ url('kartu_keluarga') }}/${kk.id}/edit" class="text-blue-500 hover:underline">Edit KK</a>
                            <a href="https://www.google.com/maps?q=${kk.latitude},${kk.longitude}" target="_blank" class="text-blue-500 hover:underline">Buka di Google Maps</a>
                        </div>
                    </div>
                `;

                // Buat ikon marker kustom
                const worstStatus = getWorstStatus(kk);
                const markerIcon = L.divIcon({
                    className: 'custom-icon',
                    html: `<div style="background-color: ${getMarkerColor(worstStatus)}; width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`,
                    iconSize: [24, 24],
                    iconAnchor: [12, 12],
                    popupAnchor: [0, -12]
                });

                // Tambahkan marker ke peta
                const marker = L.marker([kk.latitude, kk.longitude], { icon: markerIcon })
                    .addTo(map)
                    .bindPopup(popupContent, { maxWidth: 300 });
                markers.push(marker);
            }
        });

        // Sesuaikan peta agar menampilkan semua marker
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds(), { padding: [50, 50] });
        }

        // Fungsi untuk memperbarui dropdown kelurahan
        function updateKelurahan(kecamatanId) {
            const kelurahanSelect = document.getElementById('kelurahan_id');
            kelurahanSelect.innerHTML = '<option value="">Semua Kelurahan</option>';
            if (!kecamatanId) return;

            fetch(`/kelurahans/by-kecamatan/${kecamatanId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kelurahan => {
                        kelurahanSelect.innerHTML += `<option value="${kelurahan.id}" ${kelurahan.id == '{{ $kelurahan_id }}' ? 'selected' : ''}>${kelurahan.nama_kelurahan}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching kelurahans:', error);
                    alert('Gagal memuat data kelurahan. Silakan coba lagi.');
                });
        }

        // Inisialisasi kelurahan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            const kecamatanId = document.getElementById('kecamatan_id').value;
            if (kecamatanId) updateKelurahan(kecamatanId);
        });
    </script>
</body>
</html>