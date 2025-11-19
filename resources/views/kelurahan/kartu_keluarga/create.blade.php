<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kartu Keluarga - Admin Kelurahan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        #map { 
            height: 400px; 
            margin-bottom: 1rem; 
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 1;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .form-section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }
        .form-section-body {
            padding: 1.5rem;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 8px;
        }
        .bg-gradient-sidebar {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('kelurahan.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-plus-circle text-green-600 mr-3"></i>
                            Tambah Kartu Keluarga
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data kartu keluarga baru untuk wilayah kelurahan Anda</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kelurahan.kartu_keluarga.index') }}" 
                           class="text-sm text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button class="ml-auto text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (!$kecamatan || !$kelurahan)
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-red-800 font-medium">Data Wilayah Tidak Lengkap</h3>
                            <p class="text-red-700 mt-1">Data Kecamatan atau Kelurahan tidak tersedia. Silakan hubungi admin Kelurahan.</p>
                        </div>
                    </div>
                </div>
            @else
                <form action="{{ route('kelurahan.kartu_keluarga.store') }}" method="POST" id="create-form">
                    @csrf
                    
                    <!-- Informasi Dasar Kartu Keluarga -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-id-card text-green-500 mr-2"></i>
                                Informasi Dasar Kartu Keluarga
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Masukkan informasi dasar kartu keluarga</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="no_kk" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-hashtag text-green-500 mr-2 text-xs"></i>
                                        Nomor Kartu Keluarga
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
                                               placeholder="Masukkan nomor KK" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-address-card text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('no_kk')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kepala_keluarga" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-user text-blue-500 mr-2 text-xs"></i>
                                        Kepala Keluarga
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="kepala_keluarga" id="kepala_keluarga" value="{{ old('kepala_keluarga') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
                                               placeholder="Nama kepala keluarga" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user-tie text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('kepala_keluarga')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Wilayah -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-map-marked-alt text-blue-500 mr-2"></i>
                                Informasi Wilayah
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Informasi wilayah administrasi untuk kartu keluarga</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-map text-blue-500 mr-2 text-xs"></i>
                                        Kecamatan
                                    </label>
                                    <div class="relative">
                                        <div class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 pl-10 flex items-center">
                                            <i class="fas fa-map-marker-alt text-gray-400 absolute left-3"></i>
                                            <span class="text-gray-900 font-medium">{{ $kecamatan->nama_kecamatan }}</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id }}">
                                    @error('kecamatan_id')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-map-pin text-green-500 mr-2 text-xs"></i>
                                        Kelurahan
                                    </label>
                                    <div class="relative">
                                        <div class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 pl-10 flex items-center">
                                            <i class="fas fa-home text-gray-400 absolute left-3"></i>
                                            <span class="text-gray-900 font-medium">{{ $kelurahan->nama_kelurahan }}</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="kelurahan_id" value="{{ $kelurahan->id }}">
                                    @error('kelurahan_id')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-home text-purple-500 mr-2 text-xs"></i>
                                    Alamat Lengkap
                                </label>
                                <div class="relative">
                                    <textarea name="alamat" id="alamat" rows="3"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3"
                                              placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                </div>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Peta Lokasi -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-map-marked-alt text-red-500 mr-2"></i>
                                Pilih Lokasi di Peta
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Klik pada peta untuk menentukan koordinat lokasi rumah</p>
                        </div>
                        <div class="form-section-body">
                            <div class="mb-4">
                                <div id="map"></div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-globe-americas text-blue-500 mr-2 text-xs"></i>
                                        Latitude
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10 bg-gray-50"
                                               required readonly>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-latitude text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('latitude')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-globe-asia text-green-500 mr-2 text-xs"></i>
                                        Longitude
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10 bg-gray-50"
                                               required readonly>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-longitude text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('longitude')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-yellow-500 mr-2"></i>
                                Status Kartu Keluarga
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Tentukan status kartu keluarga</p>
                        </div>
                        <div class="form-section-body">
                            <div class="max-w-md">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-toggle-on text-purple-500 mr-2 text-xs"></i>
                                    Status
                                </label>
                                <div class="relative">
                                    <select name="status" id="status" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none"
                                            required>
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Non-Aktif" {{ old('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('kelurahan.kartu_keluarga.index') }}" 
                           class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                        <button type="submit" 
                                class="flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors card-hover">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Kartu Keluarga
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([1.319558, 124.838108], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = null;

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
            
            // Tambahkan animasi pada input fields
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            
            latInput.classList.add('bg-green-50', 'border-green-300');
            lngInput.classList.add('bg-green-50', 'border-green-300');
            
            setTimeout(() => {
                latInput.classList.remove('bg-green-50', 'border-green-300');
                lngInput.classList.remove('bg-green-50', 'border-green-300');
            }, 1000);
        }

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            
            if (marker) {
                map.removeLayer(marker);
            }
            
            marker = L.marker([lat, lng]).addTo(map)
                .bindPopup('<div class="text-center"><i class="fas fa-home text-green-500"></i><br>Lokasi Rumah Dipilih</div>')
                .openPopup();
                
            updateCoordinates(lat, lng);
        });

        // Set marker jika ada data lama
        var oldLat = {{ old('latitude', 'null') }};
        var oldLng = {{ old('longitude', 'null') }};
        if (oldLat && oldLng) {
            marker = L.marker([oldLat, oldLng]).addTo(map)
                .bindPopup('<div class="text-center"><i class="fas fa-home text-green-500"></i><br>Lokasi Sebelumnya</div>');
            map.setView([oldLat, oldLng], 15);
            updateCoordinates(oldLat, oldLng);
        }

        // SweetAlert2 untuk feedback penyimpanan
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#10b981',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#10b981',
            });
        @endif
    </script>
</body>
</html>