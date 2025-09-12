<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BKKBN') }} - Peta Geospasial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <header class="bg-blue-700 text-white sticky top-0 z-40 shadow">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <img src="/logo.svg" alt="Logo" class="h-8 w-8 hidden sm:block" onerror="this.style.display='none'" />
                    <div class="text-sm leading-4">
                        <div class="font-semibold">CEGAH STUNTING</div>
                        <div class="font-semibold">SEHAT RAGA</div>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="{{ route('welcome') }}" class="hover:text-blue-300">Beranda</a>
                    <div class="relative group">
                        <button class="hover:text-blue-300">Program</button>
                        <div class="absolute left-0 mt-2 hidden group-hover:block bg-white text-gray-800 rounded shadow w-56">
                            <a href="{{ url('/peta-geospasial') }}" class="block px-4 py-2 hover:bg-gray-100">Peta Geospasial</a>
                        </div>
                    </div>
                    <a href="{{ route('welcome') }}#publications" class="hover:text-blue-300">Publikasi</a>
                    <a href="{{ route('welcome') }}#stats" class="hover:text-blue-300">Monitoring</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-5 py-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Peta Geospasial</h1>
            <div class="text-sm text-gray-500">Sumber data: Kartu Keluarga (koordinat lat/long)</div>
        </div>

        <form method="GET" action="{{ route('peta.public') }}" class="grid md:grid-cols-4 gap-4 mb-4">
            <select name="kecamatan_id" class="border rounded px-3 py-2">
                <option value="">Semua Kecamatan</option>
                @foreach($kecamatans as $k)
                    <option value="{{ $k->id }}" {{ (string)$kecamatan_id === (string)$k->id ? 'selected' : '' }}>{{ $k->nama_kecamatan }}</option>
                @endforeach
            </select>
            <select name="kelurahan_id" class="border rounded px-3 py-2">
                <option value="">Semua Kelurahan</option>
                @foreach($kelurahans as $kel)
                    <option value="{{ $kel->id }}" {{ (string)$kelurahan_id === (string)$kel->id ? 'selected' : '' }}>{{ $kel->nama_kelurahan }}</option>
                @endforeach
            </select>
            <select name="status_kesehatan" class="border rounded px-3 py-2">
                <option value="">Semua Status</option>
                @foreach(['Sehat','Waspada','Bahaya','Tidak Anemia','Anemia Ringan','Anemia Sedang','Anemia Berat'] as $opt)
                    <option value="{{ $opt }}" {{ $status_kesehatan === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2">Terapkan</button>
        </form>

        <div id="map" class="w-full h-[70vh] rounded shadow bg-white"></div>
    </main>

    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 py-6 text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('app.name', 'BKKBN') }}</div>
    </footer>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const POINTS = @json($points);
        const map = L.map('map').setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
        const layer = L.layerGroup().addTo(map);
        const latlngs = [];
        (POINTS || []).forEach(p => {
            if (typeof p.latitude !== 'number' || typeof p.longitude !== 'number') return;
            const m = L.marker([p.latitude, p.longitude]).bindPopup(
                `<div class="text-sm"><div class="font-semibold">KK: ${p.no_kk || '-'}</div>
                <div>Kepala Keluarga: ${p.kepala_keluarga || '-'}</div>
                <div>Alamat: ${p.alamat || '-'}</div>
                <div>Kecamatan: ${p.kecamatan || '-'}</div>
                <div>Kelurahan: ${p.kelurahan || '-'}</div>
                <div>Balita: ${p.balita_count ?? 0} | Remaja Putri: ${p.remaja_putri_count ?? 0}</div>
                <div>Status: ${p.status || '-'}</div></div>`
            );
            m.addTo(layer);
            latlngs.push([p.latitude, p.longitude]);
        });
        if (latlngs.length) map.fitBounds(latlngs, { padding: [20,20] });
    </script>
</body>
</html>
