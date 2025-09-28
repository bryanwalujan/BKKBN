<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kartu Keluarga - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
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
        
        .map-container {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }
        
        #map { 
            height: 400px; 
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e5e7eb;
            z-index: 1;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .step.active .step-number {
            background-color: #3b82f6;
            color: white;
        }
        
        .step.completed .step-number {
            background-color: #10b981;
            color: white;
        }
        
        .step-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }
        
        .step.active .step-label {
            color: #3b82f6;
        }
        
        .step.completed .step-label {
            color: #10b981;
        }
        
        .form-section {
            display: none;
        }
        
        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
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
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
        }
        
        .btn-outline:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
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
        
        .current-location-badge {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Kartu Keluarga</span></h1>
                    <p class="text-gray-600">Edit data kartu keluarga dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-id-card mr-2"></i>
                        <span>No. KK: {{ $kartuKeluarga->no_kk }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('kartu_keluarga.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
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
        
        @if ($kecamatans->isEmpty())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>Tidak ada data Kecamatan. Silakan tambahkan Kecamatan terlebih dahulu.</span>
                </div>
            </div>
        @else
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" id="step1">
                    <div class="step-number">1</div>
                    <span class="step-label">Data Utama</span>
                </div>
                <div class="step" id="step2">
                    <div class="step-number">2</div>
                    <span class="step-label">Lokasi</span>
                </div>
                <div class="step" id="step3">
                    <div class="step-number">3</div>
                    <span class="step-label">Konfirmasi</span>
                </div>
            </div>
            
            <form action="{{ route('kartu_keluarga.update', $kartuKeluarga->id) }}" method="POST" id="kkForm">
                @csrf
                @method('PUT')
                
                <!-- Step 1: Data Utama -->
                <div class="form-section active" id="section1">
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Utama Kartu Keluarga</h3>
                                <p class="text-gray-600 text-sm mt-1">Perbarui informasi dasar kartu keluarga</p>
                            </div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-address-card mr-2"></i>
                                <span>Langkah 1 dari 3</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="no_kk" class="form-label">
                                    <i class="fas fa-id-card mr-1 text-blue-500"></i> Nomor KK
                                </label>
                                <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk', $kartuKeluarga->no_kk) }}" class="form-input" placeholder="Masukkan nomor kartu keluarga" required>
                                @error('no_kk')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div>
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
                            
                            <div>
                                <label for="kecamatan_id" class="form-label">
                                    <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Kecamatan
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" class="form-input" onchange="updateKelurahan(this.value)" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $kartuKeluarga->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div>
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
                            
                            <div class="md:col-span-2">
                                <label for="alamat" class="form-label">
                                    <i class="fas fa-home mr-1 text-blue-500"></i> Alamat Lengkap
                                </label>
                                <textarea name="alamat" id="alamat" class="form-input" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat', $kartuKeluarga->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="button" class="btn btn-primary" onclick="showSection(2)">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Lokasi -->
                <div class="form-section" id="section2">
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Lokasi Rumah</h3>
                                <p class="text-gray-600 text-sm mt-1">Perbarui lokasi rumah pada peta</p>
                            </div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-map mr-2"></i>
                                <span>Langkah 2 dari 3</span>
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <p>
                                <i class="fas fa-info-circle"></i> 
                                Klik pada peta untuk mengubah lokasi rumah. Lokasi saat ini sudah ditandai.
                            </p>
                        </div>
                        
                        <div class="current-location-badge">
                            <i class="fas fa-map-pin"></i>
                            <span>Lokasi saat ini: Latitude {{ number_format($kartuKeluarga->latitude, 6) }}, Longitude {{ number_format($kartuKeluarga->longitude, 6) }}</span>
                        </div>
                        
                        <div class="map-container">
                            <div id="map"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
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
                            
                            <div>
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
                        
                        <div class="flex justify-between mt-6">
                            <button type="button" class="btn btn-outline" onclick="showSection(1)">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection(3)">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3: Konfirmasi -->
                <div class="form-section" id="section3">
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Konfirmasi Perubahan</h3>
                                <p class="text-gray-600 text-sm mt-1">Tinjau perubahan data sebelum disimpan</p>
                            </div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Langkah 3 dari 3</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-address-card mr-2 text-blue-500"></i> Data Utama
                                </h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500">No. KK:</span>
                                        <p class="font-medium" id="reviewNoKK"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Kepala Keluarga:</span>
                                        <p class="font-medium" id="reviewKepalaKeluarga"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Kecamatan:</span>
                                        <p class="font-medium" id="reviewKecamatan"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Kelurahan:</span>
                                        <p class="font-medium" id="reviewKelurahan"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Alamat:</span>
                                        <p class="font-medium" id="reviewAlamat"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Lokasi
                                </h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500">Latitude:</span>
                                        <p class="font-medium" id="reviewLatitude"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Longitude:</span>
                                        <p class="font-medium" id="reviewLongitude"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Status:</span>
                                        <p class="font-medium" id="reviewStatus"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="status" class="form-label">
                                <i class="fas fa-toggle-on mr-1 text-blue-500"></i> Status Kartu Keluarga
                            </label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="Aktif" {{ old('status', $kartuKeluarga->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ old('status', $kartuKeluarga->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="flex justify-between mt-6">
                            <button type="button" class="btn btn-outline" onclick="showSection(2)">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <div class="flex space-x-3">
                                <a href="{{ route('kartu_keluarga.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        // Initialize map variable
        let map = null;
        let marker = null;

        function initMap() {
            if (map) {
                map.remove(); // Remove existing map instance if any
            }

            // Initialize map with Tomohon coordinates as fallback
            const lat = {{ old('latitude', $kartuKeluarga->latitude ?? '1.319779') }};
            const lng = {{ old('longitude', $kartuKeluarga->longitude ?? '124.838332') }};
            map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Ensure map is properly sized
            setTimeout(() => {
                map.invalidateSize();
            }, 100);

            // Handle map click to place marker
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng]).addTo(map);
                updateCoordinates(lat, lng);
            });

            // Place marker for existing or old coordinates
            if (lat && lng) {
                marker = L.marker([lat, lng]).addTo(map);
                map.setView([lat, lng], 15);
                updateCoordinates(lat, lng);
            }
        }

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
        }

        function updateKelurahan(kecamatanId) {
            if (!kecamatanId) {
                document.getElementById('kelurahan_id').innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
                return;
            }
            fetch(`/kelurahans/by-kecamatan/${kecamatanId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const kelurahanSelect = document.getElementById('kelurahan_id');
                    kelurahanSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
                    data.forEach(kelurahan => {
                        kelurahanSelect.innerHTML += `<option value="${kelurahan.id}" ${kelurahan.id == '{{ old('kelurahan_id', $kartuKeluarga->kelurahan_id) }}' ? 'selected' : ''}>${kelurahan.nama_kelurahan}</option>`;
                    });
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

        // Multi-step form functionality
        function showSection(sectionNumber) {
            // Validate current section before proceeding
            if (sectionNumber > 1) {
                if (!validateSection(sectionNumber - 1)) {
                    return;
                }
                
                // Initialize map when showing section 2
                if (sectionNumber === 2) {
                    initMap();
                }
                
                // Update review data when showing section 3
                if (sectionNumber === 3) {
                    updateReviewData();
                }
            }
            
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show target section
            document.getElementById('section' + sectionNumber).classList.add('active');
            
            // Update step indicators
            document.querySelectorAll('.step').forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index + 1 < sectionNumber) {
                    step.classList.add('completed');
                } else if (index + 1 === sectionNumber) {
                    step.classList.add('active');
                }
            });
        }
        
        function validateSection(sectionNumber) {
            let isValid = true;
            
            if (sectionNumber === 1) {
                const noKK = document.getElementById('no_kk').value;
                const kepalaKeluarga = document.getElementById('kepala_keluarga').value;
                const kecamatan = document.getElementById('kecamatan_id').value;
                const kelurahan = document.getElementById('kelurahan_id').value;
                
                if (!noKK) {
                    highlightError('no_kk', 'Nomor KK harus diisi');
                    isValid = false;
                }
                
                if (!kepalaKeluarga) {
                    highlightError('kepala_keluarga', 'Kepala keluarga harus diisi');
                    isValid = false;
                }
                
                if (!kecamatan) {
                    highlightError('kecamatan_id', 'Kecamatan harus dipilih');
                    isValid = false;
                }
                
                if (!kelurahan) {
                    highlightError('kelurahan_id', 'Kelurahan harus dipilih');
                    isValid = false;
                }
            } else if (sectionNumber === 2) {
                const latitude = document.getElementById('latitude').value;
                const longitude = document.getElementById('longitude').value;
                
                if (!latitude || !longitude) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih lokasi rumah pada peta dengan mengklik lokasi yang diinginkan.',
                        confirmButtonColor: '#3b82f6'
                    });
                    isValid = false;
                }
            }
            
            return isValid;
        }
        
        function highlightError(fieldId, message) {
            const field = document.getElementById(fieldId);
            field.style.borderColor = '#dc2626';
            
            // Remove any existing error message
            const existingError = field.parentNode.querySelector('.error-highlight');
            if (existingError) {
                existingError.remove();
            }
            
            // Add error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message error-highlight';
            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
            field.parentNode.appendChild(errorDiv);
            
            // Scroll to error
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        function updateReviewData() {
            document.getElementById('reviewNoKK').textContent = document.getElementById('no_kk').value || '-';
            document.getElementById('reviewKepalaKeluarga').textContent = document.getElementById('kepala_keluarga').value || '-';
            
            const kecamatanSelect = document.getElementById('kecamatan_id');
            document.getElementById('reviewKecamatan').textContent = kecamatanSelect.options[kecamatanSelect.selectedIndex]?.text || '-';
            
            const kelurahanSelect = document.getElementById('kelurahan_id');
            document.getElementById('reviewKelurahan').textContent = kelurahanSelect.options[kelurahanSelect.selectedIndex]?.text || '-';
            
            document.getElementById('reviewAlamat').textContent = document.getElementById('alamat').value || '-';
            document.getElementById('reviewLatitude').textContent = document.getElementById('latitude').value || '-';
            document.getElementById('reviewLongitude').textContent = document.getElementById('longitude').value || '-';
            
            const statusSelect = document.getElementById('status');
            document.getElementById('reviewStatus').textContent = statusSelect.options[statusSelect.selectedIndex]?.text || '-';
        }
        
        // Initialize kelurahan if kecamatan is already selected
        document.addEventListener('DOMContentLoaded', function() {
            const kecamatanId = document.getElementById('kecamatan_id').value;
            if (kecamatanId) {
                updateKelurahan(kecamatanId);
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
    </script>
</body>
</html>