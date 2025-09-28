<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aksi Konvergensi - CSSR Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
        
        .select2-container--default .select2-selection--single {
            height: 46px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 46px;
            padding-left: 0;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
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
        
        .status-badge.sehat {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.stunting {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-badge.kurang-gizi {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-badge.obesitas {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .warna-label {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 0.5rem;
            vertical-align: middle;
        }
        
        .warna-label.sehat {
            background-color: #10b981;
        }
        
        .warna-label.waspada {
            background-color: #f59e0b;
        }
        
        .warna-label.bahaya {
            background-color: #ef4444;
        }
        
        .photo-preview {
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px dashed #d1d5db;
            display: none;
            margin-top: 1rem;
        }
        
        .photo-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-top: 1rem;
        }
        
        .photo-upload-area:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .photo-upload-area i {
            font-size: 2rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }
        
        .photo-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .verification-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .verification-badge.verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .verification-badge.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .intervention-section {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #3b82f6;
        }
        
        .intervention-section h3 {
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .checkbox-container input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
            accent-color: #3b82f6;
        }
        
        .checkbox-container label {
            margin: 0;
            font-weight: 500;
            color: #374151;
        }
        
        .form-section {
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
        
        .toggle-container {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
            margin-right: 0.5rem;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #3b82f6;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        
        .toggle-label {
            font-weight: 500;
            color: #374151;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('perangkat_daerah.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Aksi Konvergensi</span></h1>
                    <p class="text-gray-600">Tambah aksi konvergensi baru untuk penanganan stunting</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Aksi
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
        
        <form action="{{ route('perangkat_daerah.aksi_konvergensi.store') }}" method="POST" enctype="multipart/form-data" id="aksiKonvergensiForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Aksi Konvergensi</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap aksi konvergensi</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-handshake mr-2"></i>
                        <span>Form Tambah Aksi - Perangkat Daerah</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data aksi konvergensi yang dimasukkan akurat dan lengkap untuk pemantauan yang optimal.
                    </p>
                </div>
                
                <!-- Data Lokasi -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-map-marker-alt"></i> Data Lokasi
                    </h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="kecamatan_id" class="form-label">
                                <i class="fas fa-map mr-1 text-blue-500"></i> Kecamatan
                            </label>
                            <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" class="form-input bg-gray-100" readonly>
                            <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id ?? '' }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="kelurahan_id" class="form-label">
                                <i class="fas fa-map-pin mr-1 text-blue-500"></i> Kelurahan
                            </label>
                            <select name="kelurahan_id" id="kelurahan_id" class="form-input" required>
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                                @endforeach
                            </select>
                            @error('kelurahan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kartu_keluarga_id" class="form-label">
                                <i class="fas fa-id-card mr-1 text-blue-500"></i> Kartu Keluarga
                            </label>
                            <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="form-input" required>
                                <option value="">Pilih Kartu Keluarga</option>
                                @foreach ($kartuKeluargas as $kk)
                                    <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                                @endforeach
                            </select>
                            @error('kartu_keluarga_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Aksi -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-tasks"></i> Data Aksi
                    </h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama_aksi" class="form-label">
                                <i class="fas fa-signature mr-1 text-blue-500"></i> Nama Aksi
                            </label>
                            <input type="text" name="nama_aksi" id="nama_aksi" value="{{ old('nama_aksi') }}" class="form-input" placeholder="Masukkan nama aksi" required>
                            @error('nama_aksi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tahun" class="form-label">
                                <i class="fas fa-calendar mr-1 text-blue-500"></i> Tahun
                            </label>
                            <input type="number" name="tahun" id="tahun" value="{{ old('tahun') }}" min="2000" max="2050" class="form-input" placeholder="Tahun pelaksanaan" required>
                            @error('tahun')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="selesai" class="form-label">
                                <i class="fas fa-check-circle mr-1 text-blue-500"></i> Status Penyelesaian
                            </label>
                            <div class="toggle-container">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="selesai" id="selesai" value="1" {{ old('selesai') ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="toggle-label">Aksi telah selesai</span>
                            </div>
                            @error('selesai')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pelaku_aksi" class="form-label">
                                <i class="fas fa-users mr-1 text-blue-500"></i> Pelaku Aksi
                            </label>
                            <input type="text" name="pelaku_aksi" id="pelaku_aksi" value="{{ old('pelaku_aksi') }}" class="form-input" placeholder="Masukkan pelaku aksi">
                            @error('pelaku_aksi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="waktu_pelaksanaan" class="form-label">
                                <i class="fas fa-clock mr-1 text-blue-500"></i> Waktu Pelaksanaan
                            </label>
                            <input type="datetime-local" name="waktu_pelaksanaan" id="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan') }}" class="form-input">
                            @error('waktu_pelaksanaan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="narasi" class="form-label">
                            <i class="fas fa-align-left mr-1 text-blue-500"></i> Narasi
                        </label>
                        <textarea name="narasi" id="narasi" class="form-input" rows="4" placeholder="Deskripsi lengkap aksi konvergensi">{{ old('narasi') }}</textarea>
                        @error('narasi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Upload Foto -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-camera"></i> Dokumentasi Aksi
                    </h4>
                    <div class="form-group">
                        <label for="foto" class="form-label">
                            <i class="fas fa-image mr-1 text-blue-500"></i> Foto Dokumentasi
                        </label>
                        
                        <div class="photo-upload-area" id="photoUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="text-gray-600">Klik untuk memilih foto atau seret dan lepas di sini</p>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                        </div>
                        
                        <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                        <img id="photoPreview" class="photo-preview" src="#" alt="Preview Foto">
                        
                        @error('foto')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Intervensi Sensitif -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-heartbeat"></i> Intervensi Sensitif
                    </h4>
                    <div class="intervention-section">
                        <h3><i class="fas fa-tint"></i> Ketersediaan Air Bersih dan Sanitasi</h3>
                        <select name="air_bersih_sanitasi" id="air_bersih_sanitasi" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada-baik" {{ old('air_bersih_sanitasi') == 'ada-baik' ? 'selected' : '' }}>Ada - Baik</option>
                            <option value="ada-buruk" {{ old('air_bersih_sanitasi') == 'ada-buruk' ? 'selected' : '' }}>Ada - Buruk</option>
                            <option value="tidak" {{ old('air_bersih_sanitasi') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('air_bersih_sanitasi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-clinic-medical"></i> Akses Layanan Kesehatan dan KB</h3>
                        <select name="akses_layanan_kesehatan_kb" id="akses_layanan_kesehatan_kb" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('akses_layanan_kesehatan_kb') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('akses_layanan_kesehatan_kb') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('akses_layanan_kesehatan_kb')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-user-graduate"></i> Pendidikan Pengasuhan Orang Tua</h3>
                        <select name="pendidikan_pengasuhan_ortu" id="pendidikan_pengasuhan_ortu" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('pendidikan_pengasuhan_ortu') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('pendidikan_pengasuhan_ortu') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('pendidikan_pengasuhan_ortu')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-user-md"></i> Edukasi Kesehatan Remaja</h3>
                        <select name="edukasi_kesehatan_remaja" id="edukasi_kesehatan_remaja" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('edukasi_kesehatan_remaja') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('edukasi_kesehatan_remaja') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('edukasi_kesehatan_remaja')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-brain"></i> Kesadaran Pengasuhan dan Gizi</h3>
                        <select name="kesadaran_pengasuhan_gizi" id="kesadaran_pengasuhan_gizi" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('kesadaran_pengasuhan_gizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('kesadaran_pengasuhan_gizi') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('kesadaran_pengasuhan_gizi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-apple-alt"></i> Akses Pangan Bergizi</h3>
                        <select name="akses_pangan_bergizi" id="akses_pangan_bergizi" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('akses_pangan_bergizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('akses_pangan_bergizi') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('akses_pangan_bergizi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Intervensi Spesifik -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-stethoscope"></i> Intervensi Spesifik
                    </h4>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-utensils"></i> Makanan Ibu Hamil</h3>
                        <select name="makanan_ibu_hamil" id="makanan_ibu_hamil" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('makanan_ibu_hamil') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('makanan_ibu_hamil') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('makanan_ibu_hamil')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-pills"></i> Tablet Tambah Darah</h3>
                        <select name="tablet_tambah_darah" id="tablet_tambah_darah" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('tablet_tambah_darah') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('tablet_tambah_darah') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('tablet_tambah_darah')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-baby"></i> Inisiasi Menyusui Dini</h3>
                        <select name="inisiasi_menyusui_dini" id="inisiasi_menyusui_dini" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('inisiasi_menyusui_dini') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('inisiasi_menyusui_dini') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('inisiasi_menyusui_dini')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-child"></i> ASI Eksklusif</h3>
                        <select name="asi_eksklusif" id="asi_eksklusif" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('asi_eksklusif') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('asi_eksklusif') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('asi_eksklusif')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-bread-slice"></i> ASI dan MPASI</h3>
                        <select name="asi_mpasi" id="asi_mpasi" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('asi_mpasi') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('asi_mpasi') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('asi_mpasi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-syringe"></i> Imunisasi Lengkap</h3>
                        <select name="imunisasi_lengkap" id="imunisasi_lengkap" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('imunisasi_lengkap') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('imunisasi_lengkap') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('imunisasi_lengkap')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-shield-virus"></i> Pencegahan Infeksi</h3>
                        <select name="pencegahan_infeksi" id="pencegahan_infeksi" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="ada" {{ old('pencegahan_infeksi') == 'ada' ? 'selected' : '' }}>Ada</option>
                            <option value="tidak" {{ old('pencegahan_infeksi') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                        @error('pencegahan_infeksi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-female"></i> Status Gizi Ibu</h3>
                        <select name="status_gizi_ibu" id="status_gizi_ibu" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="baik" {{ old('status_gizi_ibu') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="buruk" {{ old('status_gizi_ibu') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                        </select>
                        @error('status_gizi_ibu')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-virus"></i> Penyakit Menular</h3>
                        <select name="penyakit_menular" id="penyakit_menular" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="tidak" {{ old('penyakit_menular') == 'tidak' ? 'selected' : '' }}>Tidak Ada</option>
                            <option value="ada" {{ old('penyakit_menular') == 'ada' ? 'selected' : '' }}>Ada</option>
                        </select>
                        @error('penyakit_menular')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section" id="jenis_penyakit_container" style="display: {{ old('penyakit_menular') == 'ada' ? 'block' : 'none' }};">
                        <h3><i class="fas fa-disease"></i> Jenis Penyakit</h3>
                        <input type="text" name="jenis_penyakit" id="jenis_penyakit" value="{{ old('jenis_penyakit') }}" class="form-input" placeholder="Masukkan jenis penyakit" {{ old('penyakit_menular') == 'ada' ? 'required' : '' }}>
                        @error('jenis_penyakit')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="intervention-section">
                        <h3><i class="fas fa-leaf"></i> Kesehatan Lingkungan</h3>
                        <select name="kesehatan_lingkungan" id="kesehatan_lingkungan" class="form-input">
                            <option value="">Pilih Status</option>
                            <option value="baik" {{ old('kesehatan_lingkungan') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="buruk" {{ old('kesehatan_lingkungan') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                        </select>
                        @error('kesehatan_lingkungan')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Aksi Konvergensi
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 with custom styling
            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true,
                width: '100%'
            });

            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true,
                width: '100%'
            });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Photo upload functionality
            $('#photoUploadArea').on('click', function() {
                $('#foto').click();
            });

            $('#foto').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#photoPreview').attr('src', e.target.result);
                        $('#photoPreview').show();
                        $('#photoUploadArea').hide();
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Drag and drop functionality for photo upload
            $('#photoUploadArea').on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $('#photoUploadArea').on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            $('#photoUploadArea').on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
                
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    $('#foto')[0].files = files;
                    $('#foto').trigger('change');
                }
            });

            // Toggle jenis penyakit container based on penyakit_menular selection
            $('#penyakit_menular').on('change', function() {
                var jenisPenyakitContainer = $('#jenis_penyakit_container');
                var jenisPenyakitInput = $('#jenis_penyakit');
                if (this.value === 'ada') {
                    jenisPenyakitContainer.css('display', 'block');
                    jenisPenyakitInput.prop('required', true);
                } else {
                    jenisPenyakitContainer.css('display', 'none');
                    jenisPenyakitInput.prop('required', false);
                    jenisPenyakitInput.val('');
                }
            });

            // Form validation before submission
            $('#aksiKonvergensiForm').on('submit', function(e) {
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
    </script>
</body>
</html>