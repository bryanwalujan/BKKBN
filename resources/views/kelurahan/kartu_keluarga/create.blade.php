<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kartu Keluarga - CSSR Kelurahan</title>
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
            margin-left: 0.5rem;
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
    </style>
</head>
<body class="bg-gray-50">
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Kartu Keluarga</span></h1>
                    <p class="text-gray-600">Tambah data kartu keluarga baru ke dalam sistem CSSR</p>
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
        </div>
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        @if (!$kecamatan || !$kelurahan)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>Data Kecamatan atau Kelurahan tidak tersedia. Silakan hubungi admin kecamatan.</span>
                </div>
            </div>
        @else
            <form action="{{ route('kelurahan.kartu_keluarga.store') }}" method="POST" id="kkForm">
                @csrf
                
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Data Kartu Keluarga</h3>
                            <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap kartu keluarga</p>
                        </div>
                        <div class="flex items-center text-sm text-blue-500">
                            <i class="fas fa-id-card-alt mr-2"></i>
                            <span>Form Tambah KK - Kelurahan</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <p>
                            <i class="fas fa-info-circle"></i> 
                            Pastikan data yang dimasukkan akurat dan lengkap untuk pemantauan yang optimal.
                        </p>
                    </div>
                    
                    <!-- Data Utama -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Data Utama</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="no_kk" class="form-label">
                                    <i class="fas fa-hashtag mr-1 text-blue-500"></i> Nomor KK
                                </label>
                                <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" class="form-input" placeholder="Masukkan nomor kartu keluarga" required>
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
                                <input type="text" name="kepala_keluarga" id="kepala_keluarga" value="{{ old('kepala_keluarga') }}" class="form-input" placeholder="Masukkan nama kepala keluarga" required>
                                @error('kepala_keluarga')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Wilayah -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Data Wilayah</h4>
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
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Alamat Lengkap</h4>
                        <div class="form-group">
                            <label for="alamat" class="form-label">
                                <i class="fas fa-home mr-1 text-blue-500"></i> Alamat
                            </label>
                            <textarea name="alamat" id="alamat" class="form-input" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Peta Lokasi -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Lokasi Rumah</h4>
                        
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
                                <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" class="form-input" required readonly>
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
                                <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" class="form-input" required readonly>
                                @error('longitude')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Status</h4>
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-check-circle mr-1 text-blue-500"></i> Status Kartu Keluarga
                            </label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>
                                    <span class="status-badge aktif">Aktif</span>
                                </option>
                                <option value="Non-Aktif" {{ old('status') == 'Non-Aktif' ? 'selected' : '' }}>
                                    <span class="status-badge non-aktif">Non-Aktif</span>
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
                            <i class="fas fa-save"></i> Simpan Kartu Keluarga
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
            var map = L.map('map').setView([1.319558, 124.838108], 15);
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