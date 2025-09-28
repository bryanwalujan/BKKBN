<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Kegiatan Genting - CSSR</title>
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
        
        .section-header {
            background: linear-gradient(90deg, #3b82f6, #10b981);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .section-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }
        
        .pihak-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .pihak-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .pihak-card.active {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 46px;
            padding: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151;
            line-height: 1.5;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .file-upload-container {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .file-upload-container:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .file-upload-container.dragover {
            border-color: #3b82f6;
            background-color: #e0f2fe;
        }
        
        .file-preview {
            margin-top: 1rem;
            display: none;
        }
        
        .file-preview img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Kegiatan Genting</span></h1>
                    <p class="text-gray-600">Tambah data kegiatan genting baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('genting.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Kegiatan
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
        
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active" id="step1">
                <div class="step-number">1</div>
                <span class="step-label">Data Kegiatan</span>
            </div>
            <div class="step" id="step2">
                <div class="step-number">2</div>
                <span class="step-label">Jenis & Bentuk</span>
            </div>
            <div class="step" id="step3">
                <div class="step-number">3</div>
                <span class="step-label">Konfirmasi</span>
            </div>
        </div>
        
        <form action="{{ route('genting.store') }}" method="POST" enctype="multipart/form-data" id="gentingForm">
            @csrf
            
            <!-- Step 1: Data Kegiatan -->
            <div class="form-section active" id="section1">
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Data Kegiatan Genting</h3>
                            <p class="text-gray-600 text-sm mt-1">Isi informasi dasar kegiatan genting</p>
                        </div>
                        <div class="flex items-center text-sm text-blue-500">
                            <i class="fas fa-clipboard-list mr-2"></i>
                            <span>Langkah 1 dari 3</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kartu_keluarga_id" class="form-label">
                                <i class="fas fa-id-card-alt mr-1 text-blue-500"></i> Kartu Keluarga
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
                        
                        <div>
                            <label for="nama_kegiatan" class="form-label">
                                <i class="fas fa-tasks mr-1 text-blue-500"></i> Nama Kegiatan
                            </label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="form-input" placeholder="Masukkan nama kegiatan" required>
                            @error('nama_kegiatan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tanggal" class="form-label">
                                <i class="fas fa-calendar-day mr-1 text-blue-500"></i> Tanggal
                            </label>
                            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="form-input" required>
                            @error('tanggal')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="lokasi" class="form-label">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Lokasi
                            </label>
                            <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" class="form-input" placeholder="Masukkan lokasi kegiatan" required>
                            @error('lokasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="sasaran" class="form-label">
                                <i class="fas fa-users mr-1 text-blue-500"></i> Sasaran
                            </label>
                            <input type="text" name="sasaran" id="sasaran" value="{{ old('sasaran') }}" class="form-input" placeholder="Masukkan sasaran kegiatan" required>
                            @error('sasaran')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="jenis_intervensi" class="form-label">
                                <i class="fas fa-hand-holding-heart mr-1 text-blue-500"></i> Jenis Intervensi
                            </label>
                            <input type="text" name="jenis_intervensi" id="jenis_intervensi" value="{{ old('jenis_intervensi') }}" class="form-input" placeholder="Masukkan jenis intervensi" required>
                            @error('jenis_intervensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="narasi" class="form-label">
                                <i class="fas fa-file-alt mr-1 text-blue-500"></i> Narasi
                            </label>
                            <textarea name="narasi" id="narasi" class="form-input" rows="4" placeholder="Masukkan narasi kegiatan">{{ old('narasi') }}</textarea>
                            @error('narasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="form-label">
                                <i class="fas fa-camera mr-1 text-blue-500"></i> Dokumentasi
                            </label>
                            <div class="file-upload-container" id="fileUploadContainer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Klik untuk mengunggah atau seret file ke sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format yang didukung: JPG, PNG, GIF (Maks. 5MB)</p>
                                <input type="file" name="dokumentasi" id="dokumentasi" class="hidden" accept="image/*">
                            </div>
                            <div class="file-preview" id="filePreview">
                                <img id="previewImage" src="" alt="Preview">
                                <button type="button" id="removeImage" class="mt-2 text-red-500 hover:text-red-700 text-sm flex items-center">
                                    <i class="fas fa-times mr-1"></i> Hapus Gambar
                                </button>
                            </div>
                            @error('dokumentasi')
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
            
            <!-- Step 2: Jenis dan Bentuk Kegiatan -->
            <div class="form-section" id="section2">
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Jenis dan Bentuk Kegiatan</h3>
                            <p class="text-gray-600 text-sm mt-1">Tentukan pihak yang terlibat dalam kegiatan</p>
                        </div>
                        <div class="flex items-center text-sm text-blue-500">
                            <i class="fas fa-handshake mr-2"></i>
                            <span>Langkah 2 dari 3</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <p>
                            <i class="fas fa-info-circle"></i> 
                            Pilih pihak yang terlibat dalam kegiatan. Jika memilih "Ada", isi frekuensi keterlibatan.
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $pihakLabels = [
                                'dunia_usaha' => 'Dunia Usaha',
                                'pemerintah' => 'Pemerintah',
                                'bumn_bumd' => 'BUMN/BUMD',
                                'individu_perseorangan' => 'Individu/Perseorangan',
                                'lsm_komunitas' => 'LSM/Komunitas',
                                'swasta' => 'Swasta',
                                'perguruan_tinggi_akademisi' => 'Perguruan Tinggi/Akademisi',
                                'media' => 'Media',
                                'tim_pendamping_keluarga' => 'Tim Pendamping Keluarga',
                                'tokoh_masyarakat' => 'Tokoh Masyarakat'
                            ];
                        @endphp
                        
                        @foreach (['dunia_usaha', 'pemerintah', 'bumn_bumd', 'individu_perseorangan', 'lsm_komunitas', 'swasta', 'perguruan_tinggi_akademisi', 'media', 'tim_pendamping_keluarga', 'tokoh_masyarakat'] as $pihak)
                            <div class="pihak-card" id="{{ $pihak }}_card">
                                <label for="{{ $pihak }}" class="form-label">
                                    <i class="fas fa-user-friends mr-1 text-blue-500"></i> {{ $pihakLabels[$pihak] }}
                                </label>
                                <select name="{{ $pihak }}" id="{{ $pihak }}" class="form-input pihak-select" onchange="toggleFrekuensi('{{ $pihak }}')">
                                    <option value="">Pilih</option>
                                    <option value="ada" {{ old($pihak) == 'ada' ? 'selected' : '' }}>Ada</option>
                                    <option value="tidak" {{ old($pihak) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                @error($pihak)
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                                <div class="mt-2 {{ old($pihak) == 'ada' ? '' : 'hidden' }}" id="{{ $pihak }}_frekuensi_container">
                                    <label for="{{ $pihak }}_frekuensi" class="form-label">
                                        <i class="fas fa-redo mr-1 text-blue-500"></i> Frekuensi (kali per minggu/bulan)
                                    </label>
                                    <input type="text" name="{{ $pihak }}_frekuensi" id="{{ $pihak }}_frekuensi" value="{{ old($pihak . '_frekuensi') }}" class="form-input" placeholder="Contoh: 2 kali per minggu">
                                    @error($pihak . '_frekuensi')
                                        <div class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
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
                            <h3 class="text-xl font-semibold text-gray-800">Konfirmasi Data</h3>
                            <p class="text-gray-600 text-sm mt-1">Tinjau data sebelum disimpan</p>
                        </div>
                        <div class="flex items-center text-sm text-blue-500">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>Langkah 3 dari 3</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-clipboard-list mr-2 text-blue-500"></i> Data Kegiatan
                            </h4>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Kartu Keluarga:</span>
                                    <p class="font-medium" id="reviewKK">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Nama Kegiatan:</span>
                                    <p class="font-medium" id="reviewNamaKegiatan">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Tanggal:</span>
                                    <p class="font-medium" id="reviewTanggal">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Lokasi:</span>
                                    <p class="font-medium" id="reviewLokasi">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Sasaran:</span>
                                    <p class="font-medium" id="reviewSasaran">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Jenis Intervensi:</span>
                                    <p class="font-medium" id="reviewJenisIntervensi">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Narasi:</span>
                                    <p class="font-medium" id="reviewNarasi">-</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Dokumentasi:</span>
                                    <p class="font-medium" id="reviewDokumentasi">-</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-handshake mr-2 text-blue-500"></i> Pihak Terlibat
                            </h4>
                            <div class="space-y-2" id="reviewPihak"></div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-6">
                        <button type="button" class="btn btn-outline" onclick="showSection(2)">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <div class="flex space-x-3">
                            <a href="{{ route('genting.index') }}" class="btn btn-secondary">
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
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        // Initialize Select2
        $(document).ready(function() {
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            $('.pihak-select').each(function() {
                $(this).select2({
                    placeholder: 'Pilih',
                    allowClear: true
                });
            });

            // Initialize frekuensi visibility based on old input
            @foreach (['dunia_usaha', 'pemerintah', 'bumn_bumd', 'individu_perseorangan', 'lsm_komunitas', 'swasta', 'perguruan_tinggi_akademisi', 'media', 'tim_pendamping_keluarga', 'tokoh_masyarakat'] as $pihak)
                toggleFrekuensi('{{ $pihak }}');
            @endforeach
        });

        // File upload functionality
        document.addEventListener('DOMContentLoaded', function() {
            const fileUploadContainer = document.getElementById('fileUploadContainer');
            const fileInput = document.getElementById('dokumentasi');
            const filePreview = document.getElementById('filePreview');
            const previewImage = document.getElementById('previewImage');
            const removeImage = document.getElementById('removeImage');
            
            // Click to upload
            fileUploadContainer.addEventListener('click', function() {
                fileInput.click();
            });
            
            // Drag and drop functionality
            fileUploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileUploadContainer.classList.add('dragover');
            });
            
            fileUploadContainer.addEventListener('dragleave', function() {
                fileUploadContainer.classList.remove('dragover');
            });
            
            fileUploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                fileUploadContainer.classList.remove('dragover');
                
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    handleFileSelect(e.dataTransfer.files[0]);
                }
            });
            
            // File input change
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handleFileSelect(this.files[0]);
                }
            });
            
            // Remove image
            removeImage.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.style.display = 'none';
                fileUploadContainer.style.display = 'block';
                document.getElementById('reviewDokumentasi').textContent = '-';
            });
            
            function handleFileSelect(file) {
                // Check file type
                if (!file.type.match('image.*')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: 'Silakan pilih file gambar (JPG, PNG, GIF)',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }
                
                // Check file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File terlalu besar',
                        text: 'Ukuran file maksimal 5MB',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    filePreview.style.display = 'block';
                    fileUploadContainer.style.display = 'none';
                    document.getElementById('reviewDokumentasi').textContent = file.name;
                };
                reader.readAsDataURL(file);
            }
        });

        // Multi-step form functionality
        function showSection(sectionNumber) {
            // Validate current section before proceeding
            if (sectionNumber > 1) {
                if (!validateSection(sectionNumber - 1)) {
                    return;
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
                const kartuKeluarga = document.getElementById('kartu_keluarga_id').value;
                const namaKegiatan = document.getElementById('nama_kegiatan').value.trim();
                const tanggal = document.getElementById('tanggal').value;
                const lokasi = document.getElementById('lokasi').value.trim();
                const sasaran = document.getElementById('sasaran').value.trim();
                const jenisIntervensi = document.getElementById('jenis_intervensi').value.trim();
                
                if (!kartuKeluarga) {
                    highlightError('kartu_keluarga_id', 'Kartu keluarga harus dipilih');
                    isValid = false;
                }
                
                if (!namaKegiatan) {
                    highlightError('nama_kegiatan', 'Nama kegiatan harus diisi');
                    isValid = false;
                }
                
                if (!tanggal) {
                    highlightError('tanggal', 'Tanggal harus diisi');
                    isValid = false;
                }
                
                if (!lokasi) {
                    highlightError('lokasi', 'Lokasi harus diisi');
                    isValid = false;
                }
                
                if (!sasaran) {
                    highlightError('sasaran', 'Sasaran harus diisi');
                    isValid = false;
                }
                
                if (!jenisIntervensi) {
                    highlightError('jenis_intervensi', 'Jenis intervensi harus diisi');
                    isValid = false;
                }
            } else if (sectionNumber === 2) {
                const pihakFields = [
                    'dunia_usaha',
                    'pemerintah',
                    'bumn_bumd',
                    'individu_perseorangan',
                    'lsm_komunitas',
                    'swasta',
                    'perguruan_tinggi_akademisi',
                    'media',
                    'tim_pendamping_keluarga',
                    'tokoh_masyarakat'
                ];
                let hasAda = false;
                
                for (const pihak of pihakFields) {
                    const select = document.getElementById(pihak);
                    const frekuensi = document.getElementById(pihak + '_frekuensi');
                    
                    if (select.value === 'ada') {
                        hasAda = true;
                        if (!frekuensi.value.trim()) {
                            highlightError(pihak + '_frekuensi', 'Frekuensi harus diisi jika pihak dipilih "Ada"');
                            isValid = false;
                        }
                    }
                }
                
                if (!hasAda) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pihak Terlibat Dibutuhkan',
                        text: 'Setidaknya satu pihak harus dipilih dengan status "Ada".',
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
        
        function toggleFrekuensi(pihak) {
            const select = document.getElementById(pihak);
            const container = document.getElementById(pihak + '_frekuensi_container');
            const card = document.getElementById(pihak + '_card');
            
            if (select.value === 'ada') {
                container.classList.remove('hidden');
                card.classList.add('active');
            } else {
                container.classList.add('hidden');
                card.classList.remove('active');
            }
        }
        
        function updateReviewData() {
            // Data Kegiatan
            const kartuKeluargaSelect = document.getElementById('kartu_keluarga_id');
            document.getElementById('reviewKK').textContent = kartuKeluargaSelect.options[kartuKeluargaSelect.selectedIndex]?.text || '-';
            document.getElementById('reviewNamaKegiatan').textContent = document.getElementById('nama_kegiatan').value || '-';
            document.getElementById('reviewTanggal').textContent = document.getElementById('tanggal').value || '-';
            document.getElementById('reviewLokasi').textContent = document.getElementById('lokasi').value || '-';
            document.getElementById('reviewSasaran').textContent = document.getElementById('sasaran').value || '-';
            document.getElementById('reviewJenisIntervensi').textContent = document.getElementById('jenis_intervensi').value || '-';
            document.getElementById('reviewNarasi').textContent = document.getElementById('narasi').value || '-';
            document.getElementById('reviewDokumentasi').textContent = document.getElementById('dokumentasi').files[0]?.name || '-';
            
            // Pihak Terlibat
            const reviewPihak = document.getElementById('reviewPihak');
            reviewPihak.innerHTML = '';
            const pihakLabels = {
                'dunia_usaha': 'Dunia Usaha',
                'pemerintah': 'Pemerintah',
                'bumn_bumd': 'BUMN/BUMD',
                'individu_perseorangan': 'Individu/Perseorangan',
                'lsm_komunitas': 'LSM/Komunitas',
                'swasta': 'Swasta',
                'perguruan_tinggi_akademisi': 'Perguruan Tinggi/Akademisi',
                'media': 'Media',
                'tim_pendamping_keluarga': 'Tim Pendamping Keluarga',
                'tokoh_masyarakat': 'Tokoh Masyarakat'
            };
            
            const pihakFields = Object.keys(pihakLabels);
            let hasPihak = false;
            
            pihakFields.forEach(pihak => {
                const select = document.getElementById(pihak);
                const frekuensi = document.getElementById(pihak + '_frekuensi');
                if (select.value === 'ada') {
                    hasPihak = true;
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <span class="text-sm text-gray-500">${pihakLabels[pihak]}:</span>
                        <p class="font-medium">Ada ${frekuensi.value ? '(Frekuensi: ' + frekuensi.value + ')' : ''}</p>
                    `;
                    reviewPihak.appendChild(div);
                }
            });
            
            if (!hasPihak) {
                const div = document.createElement('div');
                div.innerHTML = '<p class="font-medium text-gray-500">Tidak ada pihak terlibat yang dipilih.</p>';
                reviewPihak.appendChild(div);
            }
        }
    </script>
</body>
</html>