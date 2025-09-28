<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Stunting - CSSR</title>
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
            line-height: 30px;
            padding-left: 0;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
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
            font-weight: 500;
        }
        
        .status-badge.sehat {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.waspada {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-badge.bahaya {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-badge.stunting {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .status-badge.kurang-gizi {
            background-color: #ffedd5;
            color: #c2410c;
        }
        
        .status-badge.obesitas {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .form-section {
            display: none;
        }
        
        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
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
        
        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .file-upload:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }
        
        .file-upload.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        
        .file-upload-icon {
            font-size: 2rem;
            color: #9ca3af;
            margin-bottom: 1rem;
        }
        
        .file-upload-text {
            color: #6b7280;
            margin-bottom: 0.5rem;
        }
        
        .file-upload-hint {
            font-size: 0.75rem;
            color: #9ca3af;
        }
        
        .file-preview {
            margin-top: 1rem;
            display: none;
        }
        
        .file-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Data Stunting</span></h1>
                    <p class="text-gray-600">Perbarui data stunting dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('stunting.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Stunting
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
                    <span class="step-label">Data Wilayah</span>
                </div>
                <div class="step" id="step2">
                    <div class="step-number">2</div>
                    <span class="step-label">Data Pribadi</span>
                </div>
                <div class="step" id="step3">
                    <div class="step-number">3</div>
                    <span class="step-label">Data Kesehatan</span>
                </div>
                <div class="step" id="step4">
                    <div class="step-number">4</div>
                    <span class="step-label">Konfirmasi</span>
                </div>
            </div>
            
            <form action="{{ route('stunting.update', $stunting->id) }}" method="POST" enctype="multipart/form-data" id="stuntingForm">
                @csrf
                @method('PUT')
                
                <!-- Step 1: Data Wilayah -->
                <div class="form-section active" id="section1">
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Wilayah</h3>
                                <p class="text-gray-600 text-sm mt-1">Pilih wilayah tempat tinggal balita</p>
                            </div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>Langkah 1 dari 4</span>
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <p>
                                <i class="fas fa-info-circle"></i> 
                                Pilih kecamatan dan kelurahan terlebih dahulu untuk memfilter kartu keluarga yang tersedia.
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="kecamatan_id" class="form-label">
                                    <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Kecamatan
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" class="form-input" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $stunting->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
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
                            
                            <div class="md:col-span-2 form-group">
                                <label for="kartu_keluarga_id" class="form-label">
                                    <i class="fas fa-address-card mr-1 text-blue-500"></i> Kartu Keluarga
                                </label>
                                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="form-input" required>
                                    <option value="">-- Pilih Kartu Keluarga --</option>
                                </select>
                                @error('kartu_keluarga_id')
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
                
                <!-- Step 2: Data Pribadi -->
                <div class="form-section" id="section2">
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Pribadi Balita</h3>
                                <p class="text-gray-600 text-sm mt-1">Isi informasi pribadi balita</p>
                            </div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-user mr-2"></i>
                                <span>Langkah 2 dari 4</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="nik" class="form-label">
                                    <i class="fas fa-id-card mr-1 text-blue-500"></i> NIK
                                </label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik', $stunting->nik) }}" class="form-input" placeholder="Masukkan NIK balita">
                                @error('nik')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user mr-1 text-blue-500"></i> Nama Lengkap
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $stunting->nama) }}" class="form-input" placeholder="Masukkan nama lengkap balita" required>
                                @error('nama')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="tanggal_lahir" class="form-label">
                                    <i class="fas fa-calendar-day mr-1 text-blue-500"></i> Tanggal Lahir
                                </label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $stunting->tanggal_lahir->format('Y-m-d')) }}" class="form-input" required>
                                @error('tanggal_lahir')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="jenis_kelamin" class="form-label">
                                    <i class="fas fa-venus-mars mr-1 text-blue-500"></i> Jenis Kelamin
                                </label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-input" required>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-between mt-6">
                            <button type="button" class="btn btn-secondary" onclick="showSection(1)">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection(3)">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3: Data Kesehatan -->
                <div class="form-section" id="section3">
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Data Kesehatan Balita</h3>
                                <p class="text-gray-600 text-sm mt-1">Isi informasi kesehatan balita</p>
                            </div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-heartbeat mr-2"></i>
                                <span>Langkah 3 dari 4</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="berat" class="form-label">
                                    <i class="fas fa-weight mr-1 text-blue-500"></i> Berat Badan (kg)
                                </label>
                                <input type="number" name="berat" id="berat" value="{{ old('berat', explode('/', $stunting->berat_tinggi)[0]) }}" step="0.1" class="form-input" placeholder="Masukkan berat badan" required>
                                @error('berat')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="tinggi" class="form-label">
                                    <i class="fas fa-ruler-vertical mr-1 text-blue-500"></i> Tinggi Badan (cm)
                                </label>
                                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi', explode('/', $stunting->berat_tinggi)[1]) }}" step="0.1" class="form-input" placeholder="Masukkan tinggi badan" required>
                                @error('tinggi')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="status_gizi" class="form-label">
                                    <i class="fas fa-utensils mr-1 text-blue-500"></i> Status Gizi
                                </label>
                                <select name="status_gizi" id="status_gizi" class="form-input" required>
                                    <option value="Sehat" {{ old('status_gizi', $stunting->status_gizi) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                    <option value="Stunting" {{ old('status_gizi', $stunting->status_gizi) == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                                    <option value="Kurang Gizi" {{ old('status_gizi', $stunting->status_gizi) == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                    <option value="Obesitas" {{ old('status_gizi', $stunting->status_gizi) == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                                </select>
                                @error('status_gizi')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="warna_gizi" class="form-label">
                                    <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Status Gizi
                                </label>
                                <select name="warna_gizi" id="warna_gizi" class="form-input" required>
                                    <option value="Sehat" {{ old('warna_gizi', $stunting->warna_gizi) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                    <option value="Waspada" {{ old('warna_gizi', $stunting->warna_gizi) == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                    <option value="Bahaya" {{ old('warna_gizi', $stunting->warna_gizi) == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                                </select>
                                @error('warna_gizi')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="tindak_lanjut" class="form-label">
                                    <i class="fas fa-clipboard-list mr-1 text-blue-500"></i> Tindak Lanjut
                                </label>
                                <input type="text" name="tindak_lanjut" id="tindak_lanjut" value="{{ old('tindak_lanjut', $stunting->tindak_lanjut) }}" class="form-input" placeholder="Masukkan tindak lanjut">
                                @error('tindak_lanjut')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="warna_tindak_lanjut" class="form-label">
                                    <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Tindak Lanjut
                                </label>
                                <select name="warna_tindak_lanjut" id="warna_tindak_lanjut" class="form-input" required>
                                    <option value="Sehat" {{ old('warna_tindak_lanjut', $stunting->warna_tindak_lanjut) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                    <option value="Waspada" {{ old('warna_tindak_lanjut', $stunting->warna_tindak_lanjut) == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                    <option value="Bahaya" {{ old('warna_tindak_lanjut', $stunting->warna_tindak_lanjut) == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                                </select>
                                @error('warna_tindak_lanjut')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="md:col-span-2 form-group">
                                <label for="foto" class="form-label">
                                    <i class="fas fa-camera mr-1 text-blue-500"></i> Foto Kartu Identitas
                                </label>
                                @if ($stunting->foto)
                                    <div class="file-preview" id="existingFilePreview" style="display: block;">
                                        <img id="existingImage" src="{{ Storage::url($stunting->foto) }}" alt="Existing Photo" class="max-w-200 max-h-200 rounded shadow">
                                        <button type="button" id="removeExistingImage" class="btn btn-secondary mt-2">
                                            <i class="fas fa-trash mr-1"></i> Hapus Gambar
                                        </button>
                                    </div>
                                @endif
                                <div class="file-upload" id="fileUploadArea">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="file-upload-text">Klik untuk mengunggah foto atau seret file ke sini</div>
                                    <div class="file-upload-hint">Format yang didukung: JPG, PNG, GIF (Maks. 2MB)</div>
                                    <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                                </div>
                                <div class="file-preview" id="filePreview">
                                    <img id="previewImage" src="#" alt="Preview">
                                    <button type="button" id="removeImage" class="btn btn-secondary mt-2">
                                        <i class="fas fa-trash mr-1"></i> Hapus Gambar
                                    </button>
                                </div>
                                @error('foto')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-between mt-6">
                            <button type="button" class="btn btn-secondary" onclick="showSection(2)">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary" onclick="showSection(4)">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Step 4: Konfirmasi -->
                <div class="form-section" id="section4">
                    <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800">Konfirmasi Data</h3>
                                <p class="text-gray-600 text-sm mt-1">Tinjau data sebelum disimpan</p>
                            </div>
                            <div class="flex items-center text-sm text-blue-500">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Langkah 4 dari 4</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Data Wilayah
                                </h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500">Kecamatan:</span>
                                        <p class="font-medium" id="reviewKecamatan"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Kelurahan:</span>
                                        <p class="font-medium" id="reviewKelurahan"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Kartu Keluarga:</span>
                                        <p class="font-medium" id="reviewKK"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-user mr-2 text-blue-500"></i> Data Pribadi
                                </h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500">NIK:</span>
                                        <p class="font-medium" id="reviewNIK"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Nama:</span>
                                        <p class="font-medium" id="reviewNama"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Tanggal Lahir:</span>
                                        <p class="font-medium" id="reviewTanggalLahir"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Jenis Kelamin:</span>
                                        <p class="font-medium" id="reviewJenisKelamin"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-heartbeat mr-2 text-blue-500"></i> Data Kesehatan
                                </h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500">Berat Badan:</span>
                                        <p class="font-medium" id="reviewBerat"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Tinggi Badan:</span>
                                        <p class="font-medium" id="reviewTinggi"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Status Gizi:</span>
                                        <p class="font-medium" id="reviewStatusGizi"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Warna Status Gizi:</span>
                                        <p class="font-medium" id="reviewWarnaGizi"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Tindak Lanjut:</span>
                                        <p class="font-medium" id="reviewTindakLanjut"></p>
                                    </div>
                                    <div>
                                        <span class="text-sm text-gray-500">Warna Tindak Lanjut:</span>
                                        <p class="font-medium" id="reviewWarnaTindakLanjut"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-camera mr-2 text-blue-500"></i> Foto
                                </h4>
                                <div class="space-y-2">
                                    <div>
                                        <span class="text-sm text-gray-500">Status Unggahan:</span>
                                        <p class="font-medium" id="reviewFoto"></p>
                                    </div>
                                    <div id="reviewFotoPreview" class="mt-2 hidden">
                                        <span class="text-sm text-gray-500">Preview:</span>
                                        <img id="reviewImage" src="#" alt="Preview" class="max-w-full h-auto rounded mt-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between mt-6">
                            <button type="button" class="btn btn-secondary" onclick="showSection(3)">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </button>
                            <div class="flex space-x-3">
                                <a href="{{ route('stunting.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Data
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for all dropdowns
            $('#kecamatan_id').select2({
                placeholder: '-- Pilih Kecamatan --',
                allowClear: true
            });
            $('#kelurahan_id').select2({
                placeholder: '-- Pilih Kelurahan --',
                allowClear: true
            });
            $('#kartu_keluarga_id').select2({
                placeholder: '-- Pilih Kartu Keluarga --',
                allowClear: true
            });
            $('#jenis_kelamin').select2({
                placeholder: 'Pilih Jenis Kelamin',
                minimumResultsForSearch: Infinity
            });
            $('#status_gizi').select2({
                placeholder: 'Pilih Status Gizi',
                minimumResultsForSearch: Infinity
            });
            $('#warna_gizi').select2({
                placeholder: 'Pilih Warna Status Gizi',
                minimumResultsForSearch: Infinity
            });
            $('#warna_tindak_lanjut').select2({
                placeholder: 'Pilih Warna Tindak Lanjut',
                minimumResultsForSearch: Infinity
            });

            // Load initial kelurahans and kartu keluarga
            var initialKecamatanId = '{{ old('kecamatan_id', $stunting->kecamatan_id) }}';
            var initialKelurahanId = '{{ old('kelurahan_id', $stunting->kelurahan_id) }}';
            var initialKartuKeluargaId = '{{ old('kartu_keluarga_id', $stunting->kartu_keluarga_id) }}';
            if (initialKecamatanId) {
                $.ajax({
                    url: '/kelurahans/by-kecamatan/' + initialKecamatanId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == initialKelurahanId ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');

                        if (initialKelurahanId) {
                            $.ajax({
                                url: '/kartu-keluarga/by-kecamatan-kelurahan?kecamatan_id=' + initialKecamatanId + '&kelurahan_id=' + initialKelurahanId,
                                type: 'GET',
                                dataType: 'json',
                                success: function(data) {
                                    $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>');
                                    $.each(data, function(index, kk) {
                                        var selected = kk.id == initialKartuKeluargaId ? 'selected' : '';
                                        $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                                    });
                                    $('#kartu_keluarga_id').trigger('change');
                                },
                                error: function(xhr) {
                                    console.error('Gagal mengambil data kartu keluarga:', xhr);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                                        confirmButtonColor: '#3b82f6'
                                    });
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Gagal mengambil data kelurahan:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }

            // Fetch kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>').trigger('change');

                if (kecamatanId) {
                    $.ajax({
                        url: '/kelurahans/by-kecamatan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kelurahan:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                }
            });

            // Fetch kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $(this).val();
                $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>').trigger('change');

                if (kecamatanId && kelurahanId) {
                    $.ajax({
                        url: '/kartu-keluarga/by-kecamatan-kelurahan?kecamatan_id=' + kecamatanId + '&kelurahan_id=' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(index, kk) {
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                            $('#kartu_keluarga_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kartu keluarga:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                }
            });

            // File upload handling
            const fileInput = $('#foto');
            const fileUploadArea = $('#fileUploadArea');
            const filePreview = $('#filePreview');
            const previewImage = $('#previewImage');
            const removeImageBtn = $('#removeImage');
            const existingFilePreview = $('#existingFilePreview');
            const existingImage = $('#existingImage');
            const removeExistingImageBtn = $('#removeExistingImage');

            // Show existing image if available
            @if ($stunting->foto)
                filePreview.show();
                previewImage.attr('src', '{{ Storage::url($stunting->foto) }}');
            @endif

            fileUploadArea.on('click', function() {
                fileInput.click();
            });

            fileUploadArea.on('dragover', function(e) {
                e.preventDefault();
                $(this).addClass('dragover');
            });

            fileUploadArea.on('dragleave', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
            });

            fileUploadArea.on('drop', function(e) {
                e.preventDefault();
                $(this).removeClass('dragover');
                const files = e.originalEvent.dataTransfer.files;
                if (files.length) {
                    fileInput[0].files = files;
                    handleFile(files[0]);
                }
            });

            fileInput.on('change', function() {
                if (this.files.length) {
                    handleFile(this.files[0]);
                }
            });

            removeImageBtn.on('click', function() {
                fileInput.val('');
                filePreview.hide();
                previewImage.attr('src', '#');
                existingFilePreview.show();
            });

            removeExistingImageBtn.on('click', function() {
                fileInput.val('');
                existingFilePreview.hide();
                existingImage.attr('src', '#');
                filePreview.hide();
                previewImage.attr('src', '#');
            });

            function handleFile(file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.attr('src', e.target.result);
                        filePreview.show();
                        existingFilePreview.hide();
                    };
                    reader.readAsDataURL(file);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'File yang diunggah harus berupa gambar (JPG, PNG, GIF).',
                        confirmButtonColor: '#3b82f6'
                    });
                    fileInput.val('');
                }
            }

            // Multi-step form navigation
            window.showSection = function(section) {
                // Validate current section before moving
                const currentSection = $('.form-section.active').attr('id').replace('section', '');
                if (!validateSection(currentSection)) {
                    return;
                }

                // Update step indicators
                $('.step').removeClass('active completed');
                for (let i = 1; i <= section; i++) {
                    if (i < section) {
                        $('#step' + i).addClass('completed');
                    } else {
                        $('#step' + i).addClass('active');
                    }
                }

                // Show selected section
                $('.form-section').removeClass('active');
                $('#section' + section).addClass('active');

                // Populate review section if moving to step 4
                if (section === 4) {
                    populateReview();
                }
            };

            // Validate section
            function validateSection(section) {
                let isValid = true;
                let fields = [];

                if (section == 1) {
                    fields = ['#kecamatan_id', '#kelurahan_id', '#kartu_keluarga_id'];
                } else if (section == 2) {
                    fields = ['#nama', '#tanggal_lahir', '#jenis_kelamin'];
                } else if (section == 3) {
                    fields = ['#berat', '#tinggi', '#status_gizi', '#warna_gizi', '#warna_tindak_lanjut'];
                }

                fields.forEach(function(field) {
                    if (!$(field).val()) {
                        isValid = false;
                        $(field).addClass('border-red-500');
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Harap lengkapi semua bidang wajib sebelum melanjutkan.',
                            confirmButtonColor: '#3b82f6'
                        });
                    } else {
                        $(field).removeClass('border-red-500');
                    }
                });

                return isValid;
            }

            // Populate review section
            function populateReview() {
                // Data Wilayah
                const kecamatanText = $('#kecamatan_id option:selected').text();
                const kelurahanText = $('#kelurahan_id option:selected').text();
                const kkText = $('#kartu_keluarga_id option:selected').text();
                $('#reviewKecamatan').text(kecamatanText || '-');
                $('#reviewKelurahan').text(kelurahanText || '-');
                $('#reviewKK').text(kkText || '-');

                // Data Pribadi
                const nik = $('#nik').val();
                const nama = $('#nama').val();
                const tanggalLahir = $('#tanggal_lahir').val();
                const jenisKelamin = $('#jenis_kelamin').val();
                $('#reviewNIK').text(nik || '-');
                $('#reviewNama').text(nama || '-');
                $('#reviewTanggalLahir').text(tanggalLahir ? new Date(tanggalLahir).toLocaleDateString('id-ID') : '-');
                $('#reviewJenisKelamin').text(jenisKelamin || '-');

                // Data Kesehatan
                const berat = $('#berat').val();
                const tinggi = $('#tinggi').val();
                const statusGizi = $('#status_gizi').val();
                const warnaGizi = $('#warna_gizi').val();
                const tindakLanjut = $('#tindak_lanjut').val();
                const warnaTindakLanjut = $('#warna_tindak_lanjut').val();
                $('#reviewBerat').text(berat ? berat + ' kg' : '-');
                $('#reviewTinggi').text(tinggi ? tinggi + ' cm' : '-');
                $('#reviewStatusGizi').text(statusGizi || '-');
                $('#reviewWarnaGizi').text(warnaGizi || '-');
                $('#reviewTindakLanjut').text(tindakLanjut || '-');
                $('#reviewWarnaTindakLanjut').text(warnaTindakLanjut || '-');

                // Foto
                const file = $('#foto')[0].files[0];
                if (file) {
                    $('#reviewFoto').text('Gambar baru telah diunggah');
                    $('#reviewImage').attr('src', $('#previewImage').attr('src'));
                    $('#reviewFotoPreview').show();
                } else if ($('#existingImage').attr('src') && $('#existingFilePreview').is(':visible')) {
                    $('#reviewFoto').text('Gambar lama tetap digunakan');
                    $('#reviewImage').attr('src', $('#existingImage').attr('src'));
                    $('#reviewFotoPreview').show();
                } else {
                    $('#reviewFoto').text('Tidak ada gambar diunggah');
                    $('#reviewFotoPreview').hide();
                }
            }

            // Handle session error messages
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