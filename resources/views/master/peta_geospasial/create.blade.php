<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi Geospasial - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
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
        
        .warna-label {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 0.5rem;
            vertical-align: middle;
        }
        
        .warna-label.merah {
            background-color: #ef4444;
        }
        
        .warna-label.biru {
            background-color: #3b82f6;
        }
        
        .warna-label.hijau {
            background-color: #10b981;
        }
        
        #map { 
            height: 400px; 
            border-radius: 0.5rem; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #d1d5db;
        }
        
        .map-instruction {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .map-instruction i {
            color: #3b82f6;
            margin-right: 0.5rem;
        }
        
        .coordinate-display {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .coordinate-box {
            flex: 1;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            text-align: center;
        }
        
        .coordinate-label {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }
        
        .coordinate-value {
            font-weight: 600;
            color: #374151;
            font-family: monospace;
        }
        
        .location-icon {
            color: #3b82f6;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Lokasi Geospasial</span></h1>
                    <p class="text-gray-600">Tambah data lokasi geospasial baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('peta_geospasial.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Geospasial
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
        
        <form action="{{ route('peta_geospasial.store') }}" method="POST" id="geospasialForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Lokasi Geospasial</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap data lokasi geospasial</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>Form Tambah Lokasi</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data lokasi yang dimasukkan akurat untuk pemetaan yang optimal.
                    </p>
                </div>
                
                <!-- Data Lokasi -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Lokasi</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama_lokasi" class="form-label">
                                <i class="fas fa-map-pin mr-1 text-blue-500"></i> Nama Lokasi
                            </label>
                            <input type="text" name="nama_lokasi" id="nama_lokasi" value="{{ old('nama_lokasi') }}" class="form-input" placeholder="Masukkan nama lokasi" required>
                            @error('nama_lokasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kecamatan_id" class="form-label">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Kecamatan
                            </label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-input" onchange="updateKelurahan(this.value)" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kelurahan_id" class="form-label">
                                <i class="fas fa-map-marker mr-1 text-blue-500"></i> Kelurahan
                            </label>
                            <select name="kelurahan_id" id="kelurahan_id" class="form-input" required>
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>
                            @error('kelurahan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="jenis" class="form-label">
                                <i class="fas fa-tag mr-1 text-blue-500"></i> Jenis Lokasi
                            </label>
                            <input type="text" name="jenis" id="jenis" value="{{ old('jenis') }}" class="form-input" placeholder="Masukkan jenis lokasi">
                            @error('jenis')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Status dan Warna Marker -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Status dan Marker</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-circle mr-1 text-blue-500"></i> Status
                            </label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="" disabled {{ old('status') ? '' : 'selected' }}>-- Pilih Status --</option>
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ old('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="warna_marker" class="form-label">
                                <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Marker
                            </label>
                            <select name="warna_marker" id="warna_marker" class="form-input" required>
                                <option value="" disabled {{ old('warna_marker') ? '' : 'selected' }}>-- Pilih Warna --</option>
                                <option value="Merah" {{ old('warna_marker') == 'Merah' ? 'selected' : '' }}>
                                    <span class="warna-label merah"></span> Merah
                                </option>
                                <option value="Biru" {{ old('warna_marker') == 'Biru' ? 'selected' : '' }}>
                                    <span class="warna-label biru"></span> Biru
                                </option>
                                <option value="Hijau" {{ old('warna_marker') == 'Hijau' ? 'selected' : '' }}>
                                    <span class="warna-label hijau"></span> Hijau
                                </option>
                            </select>
                            @error('warna_marker')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Koordinat Peta -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Koordinat Peta</h4>
                    
                    <div class="map-instruction">
                        <i class="fas fa-info-circle"></i>
                        Klik pada peta untuk menentukan koordinat lokasi. Koordinat akan otomatis terisi.
                    </div>
                    
                    <div id="map"></div>
                    
                    <div class="coordinate-display">
                        <div class="coordinate-box">
                            <div class="coordinate-label">Latitude</div>
                            <div class="coordinate-value" id="latitudeDisplay">1.320700</div>
                        </div>
                        <div class="coordinate-box">
                            <div class="coordinate-label">Longitude</div>
                            <div class="coordinate-value" id="longitudeDisplay">124.827700</div>
                        </div>
                    </div>
                    
                    <div class="form-grid mt-4">
                        <div class="form-group">
                            <label for="latitude" class="form-label">
                                <i class="fas fa-location-arrow mr-1 text-blue-500"></i> Latitude
                            </label>
                            <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', 1.320700) }}" class="form-input" required readonly>
                            @error('latitude')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="longitude" class="form-label">
                                <i class="fas fa-location-arrow mr-1 text-blue-500"></i> Longitude
                            </label>
                            <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', 124.827700) }}" class="form-input" required readonly>
                            @error('longitude')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('peta_geospasial.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Lokasi
                    </button>
                </div>
            </div>
        </form>
        
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
            // Initialize map
            var map = L.map('map').setView([1.320700, 124.827700], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = L.marker([1.320700, 124.827700]).addTo(map);

            // Map click event
            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                
                // Update form fields
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
                
                // Update display
                document.getElementById('latitudeDisplay').textContent = lat.toFixed(6);
                document.getElementById('longitudeDisplay').textContent = lng.toFixed(6);
                
                // Update marker position
                marker.setLatLng([lat, lng]);
            });

            // Load kelurahans for old kecamatan_id on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                updateKelurahan(initialKecamatanId);
            }

            // Form validation before submission
            $('#geospasialForm').on('submit', function(e) {
                var isValid = true;
                var firstErrorField = null;
                
                // Check required fields
                $('input[required], select[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('border-red-500');
                        
                        if (!firstErrorField) {
                            firstErrorField = this;
                        }
                    } else {
                        $(this).removeClass('border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi.',
                        confirmButtonColor: '#3b82f6'
                    });
                    
                    if (firstErrorField) {
                        $('html, body').animate({
                            scrollTop: $(firstErrorField).offset().top - 100
                        }, 500);
                    }
                }
            });

            // Handle session error with SweetAlert2
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3b82f6'
                });
            @endif
        });

        // Function to update kelurahan dropdown
        function updateKelurahan(kecamatanId) {
            const kelurahanSelect = document.getElementById('kelurahan_id');
            kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
            if (!kecamatanId) return;

            fetch(`/kelurahans/by-kecamatan/${kecamatanId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(kelurahan => {
                        kelurahanSelect.innerHTML += `<option value="${kelurahan.id}">${kelurahan.nama_kelurahan}</option>`;
                    });
                    
                    // Select old value if exists
                    var oldKelurahanId = '{{ old('kelurahan_id') }}';
                    if (oldKelurahanId) {
                        kelurahanSelect.value = oldKelurahanId;
                    }
                })
                .catch(error => {
                    console.error('Error fetching kelurahans:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data kelurahan. Silakan coba lagi.',
                        confirmButtonColor: '#3b82f6'
                    });
                });
        }
    </script>
</body>
</html>