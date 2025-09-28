<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Geospasial - Admin Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        #map { 
            height: 600px; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
        
        .card-hover {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .custom-icon { 
            transition: transform 0.2s; 
            filter: drop-shadow(0 3px 5px rgba(0,0,0,0.3));
        }
        
        .custom-icon:hover { 
            transform: scale(1.3); 
            z-index: 1000 !important;
        }
        
        .popup-content { 
            max-width: 400px; 
            font-size: 14px; 
            border-radius: 12px;
        }
        
        .popup-content table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 8px;
        }
        
        .popup-content th, .popup-content td { 
            padding: 8px; 
            border-bottom: 1px solid #e5e7eb; 
            text-align: left;
        }
        
        .popup-content th { 
            font-weight: 600; 
            background-color: #f8fafc;
        }
        
        .tabs { 
            display: flex; 
            border-bottom: 1px solid #e5e7eb; 
            margin-bottom: 12px; 
            border-radius: 8px 8px 0 0;
            overflow: hidden;
        }
        
        .tab { 
            padding: 10px 16px; 
            cursor: pointer; 
            font-weight: 500; 
            color: #6b7280;
            flex: 1;
            text-align: center;
            transition: all 0.2s;
            background-color: #f9fafb;
        }
        
        .tab:hover {
            background-color: #f3f4f6;
            color: #4b5563;
        }
        
        .tab.active { 
            color: #3b82f6; 
            background-color: white;
            border-bottom: 2px solid #3b82f6;
        }
        
        .tab-content { 
            display: none; 
            max-height: 300px;
            overflow-y: auto;
        }
        
        .tab-content.active { 
            display: block; 
        }
        
        .legend { 
            position: absolute; 
            bottom: 30px; 
            right: 10px; 
            background: white; 
            padding: 16px; 
            border-radius: 12px; 
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            z-index: 1000; 
            border: 1px solid #e5e7eb;
            max-width: 250px;
        }
        
        .legend h4 {
            margin: 0 0 12px 0;
            font-weight: 600;
            color: #374151;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        
        .legend h4 i {
            margin-right: 8px;
            color: #3b82f6;
        }
        
        .legend div { 
            display: flex; 
            align-items: center; 
            margin-bottom: 8px; 
            font-size: 14px;
        }
        
        .legend span { 
            display: inline-block; 
            width: 18px; 
            height: 18px; 
            border-radius: 50%; 
            margin-right: 10px; 
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .map-container {
            position: relative;
            margin-top: 20px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: #f3f4f6;
            border-radius: 6px;
            color: #4b5563;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }
        
        .action-btn i {
            margin-right: 4px;
            font-size: 12px;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #6b7280;
        }
        
        .no-data i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #d1d5db;
        }
        
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .leaflet-popup-tip {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .filter-box {
            position: relative;
        }
        
        .filter-box select {
            padding-left: 2.5rem;
        }
        
        .filter-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Peta <span class="gradient-text">Geospasial</span></h1>
                    <p class="text-gray-600">Visualisasi data kartu keluarga di Kelurahan {{ auth()->user()->kelurahan->nama_kelurahan }}</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-map-marked-alt mr-2"></i>
                        <span>Menampilkan {{ $kartuKeluargas->count() }} lokasi keluarga</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('kelurahan.kartu_keluarga.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-address-card"></i>
                        Kelola Kartu Keluarga
                    </a>
                    <a href="{{ route('kelurahan.remaja_putri.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-female"></i>
                        Kelola Remaja Putri
                    </a>
                    <a href="{{ route('kelurahan.balita.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-baby"></i>
                        Kelola Balita
                    </a>
                    <a href="{{ route('kelurahan.ibu.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-female"></i>
                        Kelola Data Ibu
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Lokasi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-database mr-1"></i>
                    <span>Lokasi terpetakan</span>
                </div>
            </div>
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status Hijau</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('marker_color', '#22c55e')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-check-circle mr-1"></i>
                    <span>Sehat/Tidak Anemia</span>
                </div>
            </div>
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status Kuning</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('marker_color', '#eab308')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    <span>Anemia Ringan</span>
                </div>
            </div>
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status Oranye</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('marker_color', '#f59e0b')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-orange-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    <span>Anemia Sedang</span>
                </div>
            </div>
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status Merah</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('marker_color', '#dc2626')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    <span>Bahaya/Anemia Berat</span>
                </div>
            </div>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if (session('error') || isset($errorMessage))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') ?? $errorMessage }}</span>
                </div>
            </div>
        @endif
        
        <!-- Filter dan Pencarian -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Filter Peta</h3>
                    <p class="text-gray-600 text-sm mt-1">Saring data berdasarkan status kesehatan</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-filter mr-2 text-blue-500"></i>
                    <span>Filter peta</span>
                </div>
            </div>
            
            <form action="{{ route('kelurahan.peta_geospasial.index') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="filter-box flex-grow">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Kesehatan</label>
                    <i class="fas fa-traffic-light filter-icon"></i>
                    <select name="marker_color" id="marker_color" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                        <option value="">Semua Status</option>
                        @foreach ($markerColors as $color)
                            <option value="{{ $color['value'] }}" {{ $marker_color == $color['value'] ? 'selected' : '' }}>{{ $color['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 h-10">
                        <i class="fas fa-search"></i>
                        Terapkan Filter
                    </button>
                    @if ($marker_color)
                        <a href="{{ route('kelurahan.peta_geospasial.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
            
            @if ($marker_color)
                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan data dengan status: <span class="font-semibold">
                            @php
                                $filtered = array_filter($markerColors, fn($color) => $color['value'] === $marker_color);
                                $label = !empty($filtered) ? reset($filtered)['label'] : '-';
                            @endphp
                            {{ $label }}
                        </span>
                        ({{ $kartuKeluargas->count() }} data ditemukan)
                    </p>
                </div>
            @else
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan semua data lokasi keluarga ({{ $kartuKeluargas->count() }} data)
                    </p>
                </div>
            @endif
        </div>
        
        <!-- Peta -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Peta Geospasial</h3>
                    <p class="text-gray-600 text-sm mt-1">Visualisasi lokasi keluarga berdasarkan koordinat GPS</p>
                </div>
                <div class="text-sm text-gray-500 flex items-center">
                    <i class="fas fa-sync-alt mr-2 text-blue-500 cursor-pointer" id="refresh-map" title="Refresh Peta"></i>
                    <span>Klik marker untuk detail</span>
                </div>
            </div>
            
            <div class="map-container">
                <div id="map"></div>
                <div class="legend">
                    <h4><i class="fas fa-key"></i> Legenda Status</h4>
                    <div><span style="background: #dc2626"></span>Merah (Bahaya/Anemia Berat)</div>
                    <div><span style="background: #f59e0b"></span>Oranye (Waspada/Anemia Sedang)</div>
                    <div><span style="background: #eab308"></span>Kuning (Anemia Ringan)</div>
                    <div><span style="background: #22c55e"></span>Hijau (Sehat/Tidak Anemia)</div>
                    <div><span style="background: #3b82f6"></span>Biru (Tidak Diketahui)</div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi peta dengan koordinat kelurahan admin
            var kelurahan = @json(auth()->user()->kelurahan);
            var defaultLatLng = kelurahan.latitude && kelurahan.longitude ? [kelurahan.latitude, kelurahan.longitude] : [1.319558, 124.838108];
            var map = L.map('map').setView(defaultLatLng, 14);

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
            const showKkBaseUrl = '{{ route("kelurahan.kartu_keluarga.show", ["id" => ":id"]) }}';
            const editKkBaseUrl = '{{ route("kelurahan.kartu_keluarga.edit", ["id" => ":id", "source" => "verified"]) }}';

            // Tambahkan marker untuk setiap Kartu Keluarga
            var markers = [];
            kartuKeluargas.forEach(function(kk) {
                if (kk.latitude && kk.longitude && !isNaN(kk.latitude) && !isNaN(kk.longitude)) {
                    const balitas = kk.balitas || [];
                    const remajaPutris = kk.remaja_putris || [];
                    const ibus = kk.ibu || [];

                    // Buat tabel balita
                    let balitaTable = balitas.length ? '<table><tr><th>Nama</th><th>Usia (bln)</th><th>Tanggal Lahir</th><th>Status Gizi</th></tr>' : '';
                    balitas.forEach(b => {
                        const statusColor = kk.marker_color;
                        const usia = b.usia !== null ? b.usia : 'Tanggal Lahir Tidak Tersedia';
                        const tanggalLahir = b.tanggal_lahir ? new Date(b.tanggal_lahir).toLocaleDateString('id-ID') : '-';
                        balitaTable += `<tr><td>${b.nama || '-'}</td><td>${usia}</td><td>${tanggalLahir}</td><td><span style="color: ${statusColor}">${b.status_gizi || '-'}</span></td></tr>`;
                    });
                    balitaTable += balitas.length ? '</table>' : '<div class="no-data"><i class="fas fa-baby"></i><p>Tidak ada data balita</p></div>';

                    // Buat tabel remaja putri
                    let remajaTable = remajaPutris.length ? '<table><tr><th>Nama</th><th>Umur</th><th>Status Anemia</th></tr>' : '';
                    remajaPutris.forEach(r => {
                        const statusColor = kk.marker_color;
                        remajaTable += `<tr><td>${r.nama || '-'}</td><td>${r.umur || '-'}</td><td><span style="color: ${statusColor}">${r.status_anemia || '-'}</span></td></tr>`;
                    });
                    remajaTable += remajaPutris.length ? '</table>' : '<div class="no-data"><i class="fas fa-female"></i><p>Tidak ada data remaja putri</p></div>';

                    // Buat tabel ibu
                    let ibuTable = ibus.length ? '<table><tr><th>Nama</th><th>Status</th></tr>' : '';
                    ibus.forEach(i => {
                        let status = 'Tidak Diketahui';
                        if (i.ibu_hamil) status = 'Hamil';
                        else if (i.ibu_nifas) status = 'Nifas';
                        else if (i.ibu_menyusui) status = 'Menyusui';
                        ibuTable += `<tr><td>${i.nama || '-'}</td><td>${status}</td></tr>`;
                    });
                    ibuTable += ibus.length ? '</table>' : '<div class="no-data"><i class="fas fa-female"></i><p>Tidak ada data ibu</p></div>';

                    // Buat popup content
                    const popupContent = `
                        <div class="popup-content">
                            <div class="tabs">
                                <div class="tab active" data-tab="info">Informasi</div>
                                <div class="tab" data-tab="balita">Balita (${balitas.length})</div>
                                <div class="tab" data-tab="remaja">Remaja (${remajaPutris.length})</div>
                                <div class="tab" data-tab="ibu">Ibu (${ibus.length})</div>
                            </div>
                            <div class="tab-content active" id="tab-info">
                                <p><b>No KK:</b> ${kk.no_kk || '-'}</p>
                                <p><b>Kepala Keluarga:</b> ${kk.kepala_keluarga || '-'}</p>
                                <p><b>Alamat:</b> ${kk.alamat || '-'}</p>
                                <p><b>Kelurahan:</b> ${kk.kelurahan?.nama_kelurahan || '-'}</p>
                                <p><b>Jumlah Balita:</b> ${balitas.length}</p>
                                <p><b>Jumlah Remaja Putri:</b> ${remajaPutris.length}</p>
                                <p><b>Jumlah Ibu:</b> ${ibus.length}</p>
                            </div>
                            <div class="tab-content" id="tab-balita">${balitaTable}</div>
                            <div class="tab-content" id="tab-remaja">${remajaTable}</div>
                            <div class="tab-content" id="tab-ibu">${ibuTable}</div>
                            <div class="action-buttons">
                                <a href="${editKkBaseUrl.replace(':id', kk.id)}" class="action-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="${showKkBaseUrl.replace(':id', kk.id)}" class="action-btn">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="https://www.google.com/maps?q=${kk.latitude},${kk.longitude}" target="_blank" class="action-btn">
                                    <i class="fas fa-external-link-alt"></i> Google Maps
                                </a>
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
                        .bindPopup(popupContent, { maxWidth: 400, className: 'custom-popup' })
                        .bindTooltip(kk.kepala_keluarga || 'Tidak Diketahui', { 
                            direction: 'top', 
                            offset: [0, -15],
                            className: 'custom-tooltip'
                        });
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
                map.setView(defaultLatLng, 14);
                Swal.fire({
                    icon: 'info',
                    title: 'Tidak Ada Data',
                    text: 'Tidak ada data lokasi keluarga yang sesuai dengan filter.',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true
                });
            }

            // Refresh map button
            $('#refresh-map').on('click', function() {
                location.reload();
            });

            // Handle session messages with SweetAlert2
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
            @if (session('error') || isset($errorMessage))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') ?? $errorMessage }}',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
        });
    </script>
</body>
</html>