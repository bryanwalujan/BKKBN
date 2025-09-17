<!DOCTYPE html>
<html>
<head>
    <title>Peta Geospasial - Admin Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map { height: 600px; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .custom-icon { transition: transform 0.2s; }
        .custom-icon:hover { transform: scale(1.3); }
        .popup-content { max-width: 350px; font-size: 14px; }
        .popup-content table { width: 100%; border-collapse: collapse; }
        .popup-content th, .popup-content td { padding: 6px; border-bottom: 1px solid #e5e7eb; }
        .popup-content th { text-align: left; font-weight: bold; }
        .tabs { display: flex; border-bottom: 1px solid #e5e7eb; margin-bottom: 10px; }
        .tab { padding: 8px 12px; cursor: pointer; font-weight: bold; color: #4b5563; }
        .tab.active { color: #2563eb; border-bottom: 2px solid #2563eb; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .legend { position: absolute; bottom: 30px; right: 10px; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 1000; }
        .legend div { display: flex; align-items: center; margin-bottom: 5px; }
        .legend span { display: inline-block; width: 16px; height: 16px; border-radius: 50%; margin-right: 8px; }
    </style>
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Peta Geospasial</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error') || $errorMessage)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') ?? $errorMessage }}
            </div>
        @endif
        <div class="mb-4">
            <a href="{{ route('kelurahan.kartu_keluarga.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola Kartu Keluarga</a>
        </div>
        <div id="map" class="w-full bg-white"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([1.319558, 124.838108], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Data Kartu Keluarga dari PHP
        var kartuKeluargas = @json($kartuKeluargas);
        console.log('Kartu Keluargas:', kartuKeluargas); // Debugging data yang diterima

        // Base URL untuk route
        const showKkBaseUrl = '{{ route("kelurahan.kartu_keluarga.show", ["id" => ":id"]) }}';
        const editKkBaseUrl = '{{ route("kelurahan.kartu_keluarga.edit", ["id" => ":id", "source" => "verified"]) }}';

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
            console.log('Statuses for KK', kk.no_kk, statuses); // Debugging status kesehatan
            if (statuses.includes('Bahaya') || statuses.includes('Anemia Berat')) return 'Bahaya';
            if (statuses.includes('Waspada') || statuses.includes('Anemia Sedang')) return 'Waspada';
            if (statuses.includes('Anemia Ringan')) return 'Anemia Ringan';
            if (statuses.includes('Sehat') || statuses.includes('Tidak Anemia')) return 'Sehat';
            return 'Sehat';
        }

        // Tambahkan legenda
        var legend = L.control({ position: 'bottomright' });
        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'legend');
            div.innerHTML = `
                <div><span style="background: #dc2626"></span>Bahaya/Anemia Berat</div>
                <div><span style="background: #f59e0b"></span>Waspada/Anemia Sedang</div>
                <div><span style="background: #eab308"></span>Anemia Ringan</div>
                <div><span style="background: #22c55e"></span>Sehat/Tidak Anemia</div>
                <div><span style="background: #3b82f6"></span>Tidak Diketahui</div>
            `;
            return div;
        };
        legend.addTo(map);

        // Tambahkan marker untuk setiap Kartu Keluarga
        var markers = [];
        kartuKeluargas.forEach(function(kk) {
            if (kk.latitude && kk.longitude && !isNaN(kk.latitude) && !isNaN(kk.longitude)) {
                const balitas = kk.balitas || [];
                const remajaPutris = kk.remaja_putris || [];
                const ibus = kk.ibu || [];

                // Debugging data remaja putri
                console.log('Remaja Putris for KK', kk.no_kk, remajaPutris);

                // Buat tabel balita
                let balitaTable = '<table><tr><th>Nama</th><th>Usia (bln)</th><th>Tanggal Lahir</th><th>Status Gizi</th></tr>';
                balitas.forEach(b => {
                    const statusColor = getMarkerColor(b.status_gizi);
                    const usia = b.usia !== null ? b.usia : 'Tanggal Lahir Tidak Tersedia';
                    const tanggalLahir = b.tanggal_lahir ? new Date(b.tanggal_lahir).toLocaleDateString('id-ID') : '-';
                    balitaTable += `<tr><td>${b.nama || '-'}</td><td>${usia}</td><td>${tanggalLahir}</td><td><span style="color: ${statusColor}">${b.status_gizi || '-'}</span></td></tr>`;
                });
                balitaTable += balitas.length ? '</table>' : '<p>Tidak ada balita</p>';

                // Buat tabel remaja putri
                let remajaTable = '<table><tr><th>Nama</th><th>Umur</th><th>Status Anemia</th></tr>';
                remajaPutris.forEach(r => {
                    const statusColor = getMarkerColor(r.status_anemia);
                    remajaTable += `<tr><td>${r.nama || '-'}</td><td>${r.umur || '-'}</td><td><span style="color: ${statusColor}">${r.status_anemia || '-'}</span></td></tr>`;
                });
                remajaTable += remajaPutris.length ? '</table>' : '<p>Tidak ada remaja putri</p>';

                // Buat tabel ibu
                let ibuTable = '<table><tr><th>Nama</th><th>Status</th></tr>';
                ibus.forEach(i => {
                    let status = 'Tidak Diketahui';
                    if (i.ibu_hamil) status = 'Hamil';
                    else if (i.ibu_nifas) status = 'Nifas';
                    else if (i.ibu_menyusui) status = 'Menyusui';
                    ibuTable += `<tr><td>${i.nama || '-'}</td><td>${status}</td></tr>`;
                });
                ibuTable += ibus.length ? '</table>' : '<p>Tidak ada data ibu</p>';

                // Buat popup content dengan tab
                const popupContent = `
                    <div class="popup-content">
                        <div class="tabs">
                            <div class="tab active" data-tab="info">Informasi</div>
                            <div class="tab" data-tab="balita">Balita</div>
                            <div class="tab" data-tab="remaja">Remaja Putri</div>
                            <div class="tab" data-tab="ibu">Ibu</div>
                        </div>
                        <div class="tab-content active" id="tab-info">
                            <p><b>No KK:</b> ${kk.no_kk || '-'}</p>
                            <p><b>Kepala Keluarga:</b> ${kk.kepala_keluarga || '-'}</p>
                            <p><b>Alamat:</b> ${kk.alamat || '-'}</p>
                            <p><b>Kecamatan:</b> ${kk.kecamatan?.nama_kecamatan || '-'}</p>
                            <p><b>Kelurahan:</b> ${kk.kelurahan?.nama_kelurahan || '-'}</p>
                            <p><b>Jumlah Balita:</b> ${balitas.length}</p>
                            <p><b>Jumlah Remaja Putri:</b> ${remajaPutris.length}</p>
                            <p><b>Jumlah Ibu:</b> ${ibus.length}</p>
                        </div>
                        <div class="tab-content" id="tab-balita">${balitaTable}</div>
                        <div class="tab-content" id="tab-remaja">${remajaTable}</div>
                        <div class="tab-content" id="tab-ibu">${ibuTable}</div>
                        <div class="mt-2 flex gap-2">
                            <a href="${editKkBaseUrl.replace(':id', kk.id)}" class="text-blue-500 hover:underline">Edit Alamat</a>
                            <a href="${showKkBaseUrl.replace(':id', kk.id)}" class="text-blue-500 hover:underline">Lihat Keluarga</a>
                            <a href="https://www.google.com/maps?q=${kk.latitude},${kk.longitude}" target="_blank" class="text-blue-500 hover:underline">Buka di Google Maps</a>
                        </div>
                    </div>
                `;

                // Buat ikon marker kustom
                const worstStatus = getWorstStatus(kk);
                const markerIcon = L.divIcon({
                    className: 'custom-icon',
                    html: `<div style="background-color: ${getMarkerColor(worstStatus)}; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 6px rgba(0,0,0,0.3);"></div>`,
                    iconSize: [28, 28],
                    iconAnchor: [14, 14],
                    popupAnchor: [0, -14]
                });

                // Tambahkan marker ke peta dengan tooltip
                const marker = L.marker([kk.latitude, kk.longitude], { icon: markerIcon })
                    .addTo(map)
                    .bindPopup(popupContent, { maxWidth: 350 })
                    .bindTooltip(kk.kepala_keluarga || 'Tidak Diketahui', { direction: 'top', offset: [0, -15] });
                markers.push(marker);

                // Tambahkan event listener untuk tab
                marker.on('popupopen', function() {
                    const tabs = document.querySelectorAll('.tab');
                    const tabContents = document.querySelectorAll('.tab-content');
                    tabs.forEach(tab => {
                        tab.addEventListener('click', function() {
                            tabs.forEach(t => t.classList.remove('active'));
                            tabContents.forEach(c => c.classList.remove('active'));
                            this.classList.add('active');
                            document.getElementById(`tab-${this.dataset.tab}`).classList.add('active');
                        });
                    });
                });
            }
        });

        // Sesuaikan peta agar menampilkan semua marker
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds(), { padding: [50, 50] });
        } else {
            map.setView([1.319558, 124.838108], 13);
        }
    </script>
</body>
</html>