<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kartu Keluarga - CSSR Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
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
        
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
        }
        
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .info-box {
            background-color: #f0f9ff;
            border-left: 4px solid #0ea5e9;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        
        .info-box p {
            margin: 0;
            color: #0369a1;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
            border-radius: 3px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-badge.aktif {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.non-aktif {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        #map { 
            height: 400px; 
            margin-bottom: 1rem; 
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .map-instruction {
            background-color: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #1e40af;
        }
        
        .location-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background-color: #f8fafc;
            border-radius: 0.5rem;
            border-left: 4px solid #10b981;
        }
        
        .location-info i {
            color: #10b981;
            font-size: 1.25rem;
        }
        
        .location-info p {
            margin: 0;
            font-size: 0.875rem;
            color: #374151;
        }
        
        .coordinates-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .breadcrumb a:hover {
            color: #2563eb;
        }
        
        .breadcrumb .separator {
            color: #9ca3af;
        }
        
        .form-section {
            background-color: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .form-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-section-title i {
            color: #3b82f6;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-error {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            color: #991b1b;
        }
        
        .alert-error i {
            color: #dc2626;
        }
        
        .alert-info {
            background-color: #f0f9ff;
            border-left: 4px solid #0ea5e9;
            color: #0369a1;
        }
        
        .alert-info i {
            color: #0ea5e9;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Kartu Keluarga</span></h1>
                    <p class="text-gray-600">Perbarui data kartu keluarga dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('kelurahan.kartu_keluarga.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data KK
                    </a>
                </div>
            </div>
            
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('kelurahan.dashboard') }}" class="flex items-center gap-1">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <span class="separator">/</span>
                <a href="{{ route('kelurahan.kartu_keluarga.index') }}">Data Kartu Keluarga</a>
                <span class="separator">/</span>
                <span>Edit KK: {{ $kartuKeluarga->no_kk }}</span>
            </div>
        </div>
        
        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        @if (!$kecamatan || !$kelurahan)
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Data Kecamatan atau Kelurahan tidak tersedia. Silakan hubungi admin kecamatan.</span>
            </div>
        @else
            <form action="{{ route('kelurahan.kartu_keluarga.update', [$kartuKeluarga->id, $source]) }}" method="POST" id="kkForm">
                @csrf
                @method('PUT')
                
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Edit Data Kartu Keluarga</h3>
                            <p class="text-gray-600 text-sm mt-1">Perbarui informasi kartu keluarga dengan data yang valid</p>
                        </div>
                        <div class="flex items-center text-sm text-blue-500">
                            <i class="fas fa-edit mr-2"></i>
                            <span>Form Edit KK - Kelurahan</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <p>
                            <i class="fas fa-info-circle"></i> 
                            Pastikan data yang diperbarui akurat dan lengkap untuk pemantauan yang optimal.
                        </p>
                    </div>
                    
                    <!-- Data Utama -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-id-card"></i> Data Utama
                        </h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="no_kk" class="form-label">
                                    <i class="fas fa-hashtag mr-1 text-blue-500"></i> Nomor KK
                                </label>
                                <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $kartuKeluarga->no_kk) }}" class="form-input" placeholder="Masukkan nomor kartu keluarga" required>
                                @error('no_kk')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="kepala_keluarga" class="form-label">
                                    <i class="fas fa-user mr-1 text-blue-500"></i> Kepala Keluarga
                                </label>
                                <input type="text" name="kepala_keluarga" id="kepala_keluarga" value="{{ old('kepala_keluarga', $kartuKeluarga->kepala_keluarga) }}" class="form-input" placeholder="Masukkan nama kepala keluarga" required>
                                @error('kepala_keluarga')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Wilayah -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-map-marked-alt"></i> Data Wilayah
                        </h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Kecamatan
                                </label>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-800 font-medium">{{ $kecamatan->nama_kecamatan }}</p>
                                </div>
                                <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id }}">
                                @error('kecamatan_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Kelurahan
                                </label>
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-800 font-medium">{{ $kelurahan->nama_kelurahan }}</p>
                                </div>
                                <input type="hidden" name="kelurahan_id" value="{{ $kelurahan->id }}">
                                @error('kelurahan_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alamat -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-home"></i> Alamat Lengkap
                        </h4>
                        <div class="form-group">
                            <label for="alamat" class="form-label">
                                <i class="fas fa-home mr-1 text-blue-500"></i> Alamat
                            </label>
                            <textarea name="alamat" id="alamat" class="form-input" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat', $kartuKeluarga->alamat) }}</textarea>
                            @error('alamat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Peta Lokasi -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-map"></i> Lokasi Rumah
                        </h4>
                        
                        <div class="map-instruction">
                            <i class="fas fa-info-circle mr-2"></i>
                            Klik pada peta untuk menandai lokasi rumah. Pastikan lokasi yang dipilih akurat.
                        </div>
                        
                        <div id="map"></div>
                        
                        <div class="location-info">
                            <i class="fas fa-map-pin"></i>
                            <p>Koordinat yang dipilih akan digunakan untuk pemetaan dan analisis wilayah</p>
                        </div>
                        
                        <div class="coordinates-grid">
                            <div class="form-group">
                                <label for="latitude" class="form-label">
                                    <i class="fas fa-globe-americas mr-1 text-blue-500"></i> Latitude
                                </label>
                                <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $kartuKeluarga->latitude) }}" class="form-input" required readonly>
                                @error('latitude')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="longitude" class="form-label">
                                    <i class="fas fa-globe-americas mr-1 text-blue-500"></i> Longitude
                                </label>
                                <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $kartuKeluarga->longitude) }}" class="form-input" required readonly>
                                @error('longitude')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="form-section">
                        <h4 class="form-section-title">
                            <i class="fas fa-check-circle"></i> Status
                        </h4>
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-check-circle mr-1 text-blue-500"></i> Status Kartu Keluarga
                            </label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="Aktif" {{ old('status', $kartuKeluarga->status) == 'Aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="Non-Aktif" {{ old('status', $kartuKeluarga->status) == 'Non-Aktif' ? 'selected' : '' }}>
                                    Non-Aktif
                                </option>
                            </select>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('kelurahan.kartu_keluarga.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui Kartu Keluarga
                        </button>
                    </div>
                </div>
            </form>
        @endif
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta
            var map = L.map('map').setView([{{ old('latitude', $kartuKeluarga->latitude) }}, {{ old('longitude', $kartuKeluarga->longitude) }}], 15);
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

            var oldLat = {{ old('latitude', $kartuKeluarga->latitude) }};
            var oldLng = {{ old('longitude', $kartuKeluarga->longitude) }};
            if (oldLat && oldLng) {
                marker = L.marker([oldLat, oldLng]).addTo(map);
                map.setView([oldLat, oldLng], 15);
                updateCoordinates(oldLat, oldLng);
            }

            // Form validation
            const form = document.getElementById('kkForm');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = form.querySelectorAll('input[required], select[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });
                
                // Validasi khusus untuk koordinat
                const latitude = document.getElementById('latitude').value;
                const longitude = document.getElementById('longitude').value;
                
                if (!latitude || !longitude) {
                    isValid = false;
                    alert('Harap pilih lokasi rumah pada peta dengan mengklik lokasi yang sesuai.');
                    e.preventDefault();
                    return;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Harap lengkapi semua field yang wajib diisi.');
                }
            });
        });
    </script>
</body>
</html>