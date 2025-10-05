<!DOCTYPE html>
<html>
<head>
    <title>Peta Geospasial - Perangkat Daerah</title>
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
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Peta Geospasial - {{ auth()->user()->kecamatan->nama_kecamatan }}</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error') || isset($errorMessage))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') ?? $errorMessage }}
            </div>
        @endif
        <form action="{{ route('perangkat_daerah.peta_geospasial.index') }}" method="GET" class="flex flex-wrap gap-4 mb-4">
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
                <label for="marker_color" class="block text-sm font-medium text-gray-700 mb-1">Warna Marker</label>
                <select name="marker_color" id="marker_color" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                    <option value="">Semua Warna</option>
                    @foreach ($markerColors as $color)
                        <option value="{{ $color['value'] }}" {{ $marker_color == $color['value'] ? 'selected' : '' }}>{{ $color['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end w-full sm:w-auto">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                <a href="{{ route('perangkat_daerah.peta_geospasial.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
            </div>
        </form>
        <div class="mb-4">
            <a href="{{ route('perangkat_daerah.kartu_keluarga.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola Kartu Keluarga</a>
        </div>
        <div id="map" class="w-full bg-white"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta dengan koordinat kecamatan
        var kecamatan = @json(auth()->user()->kecamatan);
        var defaultLatLng = kecamatan.latitude && kecamatan.longitude ? [kecamatan.latitude, kecamatan.longitude] : [1.319558, 124.838108];
        var map = L.map('map').setView(defaultLatLng, 12);

        // Tambahkan tile layer dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Data Kartu Keluarga dari PHP
        var kartuKeluargas = @json($kartuKeluargas);

        // Log data untuk debugging
        console.log('Kartu Keluargas:', kartuKeluargas);
        kartuKeluargas.forEach(kk => {
            console.log(`KK ID: ${kk.id}, No KK: ${kk.no_kk}, Marker Color: ${kk.marker_color}`);
        });

        // Base URL untuk route
        const showKkBaseUrl = '{{ route("perangkat_daerah.kartu_keluarga.show", ["id" => ":id"]) }}';

        // Tambahkan legenda
        var legend = L.control({ position: 'bottomright' });
        legend.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'legend');
            div.innerHTML = `
                <div><span style="background: #dc2626"></span>Merah (Bahaya)</div>
                <div><span style="background: #f59e0b"></span>Oranye (Waspada)</div>
                <div><span style="background: #eab308"></span>Kuning (Kurang Gizi)</div>
                <div><span style="background: #22c55e"></span>Hijau (Sehat)</div>
                <div><span style="background: #3b82f6"></span>Biru (Tidak Diketahui)</div>
            `;
            return div;
        };
        legend.addTo(map);

        // Tambahkan marker untuk setiap Kartu Keluarga
        var markers = [];
        kartuKeluargas.forEach(function(kk) {
            if (kk.latitude && kk.longitude && !isNaN(kk.latitude) && !isNaN(kk.longitude)) {
                const balitas = kk.balitas || [];
                const ibus = kk.ibu || [];

                // Buat tabel balita
                let balitaTable = '<table><tr><th>Nama</th><th>Usia (bln)</th><th>Tanggal Lahir</th><th>Status Gizi</th></tr>';
                balitas.forEach(b => {
                    const statusColor = kk.marker_color;
                    const usia = b.usia !== null ? b.usia : 'Tanggal Lahir Tidak Tersedia';
                    const tanggalLahir = b.tanggal_lahir ? new Date(b.tanggal_lahir).toLocaleDateString('id-ID') : '-';
                    balitaTable += `<tr><td>${b.nama || '-'}</td><td>${usia}</td><td>${tanggalLahir}</td><td><span style="color: ${statusColor}">${b.status_gizi || '-'}</span></td></tr>`;
                });
                balitaTable += balitas.length ? '</table>' : '<p>Tidak ada balita</p>';

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

                // Buat popup content
                const popupContent = `
                    <div class="popup-content">
                        <div class="tabs">
                            <div class="tab active" data-tab="info">Informasi</div>
                            <div class="tab" data-tab="balita">Balita</div>
                            <div class="tab" data-tab="ibu">Ibu</div>
                        </div>
                        <div class="tab-content active" id="tab-info">
                            <p><b>No KK:</b> ${kk.no_kk || '-'}</p>
                            <p><b>Kepala Keluarga:</b> ${kk.kepala_keluarga || '-'}</p>
                            <p><b>Alamat:</b> ${kk.alamat || '-'}</p>
                            <p><b>Kelurahan:</b> ${kk.kelurahan?.nama_kelurahan || '-'}</p>
                            <p><b>Jumlah Balita:</b> ${balitas.length}</p>
                            <p><b>Jumlah Ibu:</b> ${ibus.length}</p>
                        </div>
                        <div class="tab-content" id="tab-balita">${balitaTable}</div>
                        <div class="tab-content" id="tab-ibu">${ibuTable}</div>
                        <div class="mt-2 flex gap-2">
                            <a href="${showKkBaseUrl.replace(':id', kk.id)}" class="text-blue-500 hover:underline">Lihat Keluarga</a>
                            <a href="https://www.google.com/maps?q=${kk.latitude},${kk.longitude}" target="_blank" class="text-blue-500 hover:underline">Buka di Google Maps</a>
                        </div>
                    </div>
                `;

                // Buat ikon marker kustom
                const markerIcon = L.divIcon({
                    className: 'custom-icon',
                    html: `<div style="background-color: ${kk.marker_color}; width: 28px; height: 28px; border-radius: 50%; border: 3px solid white; box-shadow: 0 3px 6px rgba(0,0,0,0.3);"></div>`,
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
            } else {
                console.warn(`Kartu Keluarga tidak memiliki koordinat valid: ID=${kk.id}, No KK=${kk.no_kk}`);
            }
        });

        // Sesuaikan peta agar menampilkan semua marker
        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds(), { padding: [50, 50] });
        } else {
            map.setView(defaultLatLng, 12);
        }
    </script>
</body>
</html>