<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Pendamping Keluarga - CSSR</title>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            min-height: 46px;
        }
        
        .select2-container--default .select2-selection--multiple:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            background-color: #f9fafb;
            transition: all 0.3s ease;
        }
        
        .checkbox-group:hover {
            background-color: #f3f4f6;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            accent-color: #3b82f6;
        }
        
        .checkbox-group label {
            flex-grow: 1;
            font-weight: 500;
            color: #374151;
        }
        
        .checkbox-group .frequency-input {
            width: 200px;
            margin-left: 1rem;
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
        
        .peran-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .peran-badge.bidan {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .peran-badge.kader-posyandu {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .peran-badge.kader-kesehatan {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .peran-badge.pkk {
            background-color: #fce7f3;
            color: #9d174d;
        }
        
        .photo-preview {
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px dashed #d1d5db;
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
        
        .activity-section {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-top: 1rem;
        }
        
        .activity-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .current-photo {
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #d1d5db;
            margin-top: 1rem;
        }
        
        .photo-container {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
            flex-wrap: wrap;
        }
        
        .photo-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
        }
        
        .btn-outline:hover {
            background-color: #f9fafb;
        }
        
        .btn-danger {
            background-color: #dc2626;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #b91c1c;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Pendamping Keluarga</span></h1>
                    <p class="text-gray-600">Perbarui data pendamping keluarga dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('pendamping_keluarga.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Pendamping
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
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        <form action="{{ route('pendamping_keluarga.update', $pendamping->id) }}" method="POST" enctype="multipart/form-data" id="pendampingForm">
            @csrf
            @method('PUT')
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Edit Data Pendamping Keluarga</h3>
                        <p class="text-gray-600 text-sm mt-1">Perbarui informasi lengkap data pendamping keluarga</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-user-edit mr-2"></i>
                        <span>Form Edit Pendamping</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang diperbarui akurat dan lengkap untuk pengelolaan pendamping keluarga yang optimal.
                    </p>
                </div>
                
                <!-- Data Pribadi -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Pribadi</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama" class="form-label">
                                <i class="fas fa-user mr-1 text-blue-500"></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $pendamping->nama) }}" class="form-input" placeholder="Masukkan nama lengkap pendamping" required>
                            @error('nama')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="peran" class="form-label">
                                <i class="fas fa-user-tag mr-1 text-blue-500"></i> Peran
                            </label>
                            <select name="peran" id="peran" class="form-input" required>
                                <option value="" disabled>-- Pilih Peran --</option>
                                <option value="Bidan" {{ old('peran', $pendamping->peran) == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                                <option value="Kader Posyandu" {{ old('peran', $pendamping->peran) == 'Kader Posyandu' ? 'selected' : '' }}>Kader Posyandu</option>
                                <option value="Kader Kesehatan" {{ old('peran', $pendamping->peran) == 'Kader Kesehatan' ? 'selected' : '' }}>Kader Kesehatan</option>
                                <option value="Tim Penggerak PKK" {{ old('peran', $pendamping->peran) == 'Tim Penggerak PKK' ? 'selected' : '' }}>Tim Penggerak PKK</option>
                            </select>
                            @error('peran')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tahun_bergabung" class="form-label">
                                <i class="fas fa-calendar-plus mr-1 text-blue-500"></i> Tahun Bergabung
                            </label>
                            <input type="number" name="tahun_bergabung" id="tahun_bergabung" value="{{ old('tahun_bergabung', $pendamping->tahun_bergabung) }}" class="form-input" placeholder="Tahun bergabung" min="2000" max="{{ date('Y') }}" required>
                            @error('tahun_bergabung')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-circle mr-1 text-blue-500"></i> Status
                            </label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="" disabled>-- Pilih Status --</option>
                                <option value="Aktif" {{ old('status', $pendamping->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non-Aktif" {{ old('status', $pendamping->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Lokasi -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Lokasi</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="kecamatan_id" class="form-label">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Kecamatan
                            </label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-input" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $pendamping->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
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
                        
                        <div class="form-group md:col-span-2">
                            <label for="kartu_keluarga_id" class="form-label">
                                <i class="fas fa-id-card-alt mr-1 text-blue-500"></i> Kartu Keluarga yang Didampingi
                            </label>
                            <select name="kartu_keluarga_ids[]" id="kartu_keluarga_id" multiple class="form-input">
                                <option value="">-- Pilih Kartu Keluarga --</option>
                            </select>
                            @error('kartu_keluarga_ids')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Aktivitas -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Aktivitas Pendampingan</h4>
                    <div class="activity-section">
                        <div class="activity-title">
                            <i class="fas fa-tasks text-blue-500"></i>
                            <span>Pilih aktivitas yang dilakukan oleh pendamping:</span>
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" name="penyuluhan" id="penyuluhan" value="1" {{ old('penyuluhan', $pendamping->penyuluhan) ? 'checked' : '' }}>
                            <label for="penyuluhan">Penyuluhan dan Edukasi</label>
                            <input type="text" name="penyuluhan_frekuensi" id="penyuluhan_frekuensi" value="{{ old('penyuluhan_frekuensi', $pendamping->penyuluhan_frekuensi) }}" class="form-input frequency-input" placeholder="Frekuensi (misal: 2 kali/minggu)">
                            @error('penyuluhan_frekuensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" name="rujukan" id="rujukan" value="1" {{ old('rujukan', $pendamping->rujukan) ? 'checked' : '' }}>
                            <label for="rujukan">Memfasilitasi Pelayanan Rujukan</label>
                            <input type="text" name="rujukan_frekuensi" id="rujukan_frekuensi" value="{{ old('rujukan_frekuensi', $pendamping->rujukan_frekuensi) }}" class="form-input frequency-input" placeholder="Frekuensi (misal: 1 kali/bulan)">
                            @error('rujukan_frekuensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" name="kunjungan_krs" id="kunjungan_krs" value="1" {{ old('kunjungan_krs', $pendamping->kunjungan_krs) ? 'checked' : '' }}>
                            <label for="kunjungan_krs">Kunjungan Keluarga Berisiko Stunting (KRS)</label>
                            <input type="text" name="kunjungan_krs_frekuensi" id="kunjungan_krs_frekuensi" value="{{ old('kunjungan_krs_frekuensi', $pendamping->kunjungan_krs_frekuensi) }}" class="form-input frequency-input" placeholder="Frekuensi (misal: 3 kali/minggu)">
                            @error('kunjungan_krs_frekuensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" name="pendataan_bansos" id="pendataan_bansos" value="1" {{ old('pendataan_bansos', $pendamping->pendataan_bansos) ? 'checked' : '' }}>
                            <label for="pendataan_bansos">Pendataan dan Rekomendasi Bantuan Sosial</label>
                            <input type="text" name="pendataan_bansos_frekuensi" id="pendataan_bansos_frekuensi" value="{{ old('pendataan_bansos_frekuensi', $pendamping->pendataan_bansos_frekuensi) }}" class="form-input frequency-input" placeholder="Frekuensi (misal: 1 kali/bulan)">
                            @error('pendataan_bansos_frekuensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="checkbox-group">
                            <input type="checkbox" name="pemantauan_kesehatan" id="pemantauan_kesehatan" value="1" {{ old('pemantauan_kesehatan', $pendamping->pemantauan_kesehatan) ? 'checked' : '' }}>
                            <label for="pemantauan_kesehatan">Pemantauan Kesehatan dan Perkembangan Keluarga</label>
                            <input type="text" name="pemantauan_kesehatan_frekuensi" id="pemantauan_kesehatan_frekuensi" value="{{ old('pemantauan_kesehatan_frekuensi', $pendamping->pemantauan_kesehatan_frekuensi) }}" class="form-input frequency-input" placeholder="Frekuensi (misal: 2 kali/minggu)">
                            @error('pemantauan_kesehatan_frekuensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Upload Foto -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Foto Pendamping</h4>
                    <div class="form-group">
                        <label for="foto" class="form-label">
                            <i class="fas fa-camera mr-1 text-blue-500"></i> Foto Pendamping (opsional)
                        </label>
                        
                        <div class="photo-container">
                            @if ($pendamping->foto)
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                    <img src="{{ asset('storage/' . $pendamping->foto) }}" alt="Foto {{ $pendamping->nama }}" class="current-photo">
                                    <div class="photo-actions">
                                        <button type="button" id="removePhoto" class="btn btn-outline btn-sm">
                                            <i class="fas fa-trash mr-1"></i> Hapus Foto
                                        </button>
                                    </div>
                                </div>
                            @endif
                            
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Unggah foto baru:</p>
                                <div class="photo-upload-area" id="photoUploadArea">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p class="text-gray-600">Klik untuk memilih foto atau seret dan lepas di sini</p>
                                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                                </div>
                                
                                <input type="file" name="foto" id="foto" class="hidden" accept="image/jpeg,image/jpg,image/png">
                                <img id="photoPreview" class="photo-preview" src="#" alt="Preview Foto">
                            </div>
                        </div>
                        
                        @error('foto')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('pendamping_keluarga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Data Pendamping
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
            $('#kecamatan_id').select2({
                placeholder: 'Pilih Kecamatan',
                allowClear: true,
                width: '100%'
            });

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

            $('#peran').select2({
                placeholder: 'Pilih Peran',
                allowClear: true,
                width: '100%'
            });

            $('#status').select2({
                placeholder: 'Pilih Status',
                allowClear: true,
                width: '100%'
            });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Load kelurahans and kartu keluarga on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                loadKelurahans(initialKecamatanId, {{ old('kelurahan_id', $pendamping->kelurahan_id) ?? 'null' }});
            }

            // Update kelurahans and kartu keluarga when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    loadKelurahans(kecamatanId, null);
                } else {
                    $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>').trigger('change');
                    $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>').trigger('change');
                }
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            // Load kelurahans via AJAX
            function loadKelurahans(kecamatanId, selectedKelurahanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == selectedKelurahanId ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }

            // Load kartu keluarga via AJAX
            function updateKartuKeluarga() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $('#kelurahan_id').val();
                var url = '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}';
                var data = {};
                if (kecamatanId) data.kecamatan_id = kecamatanId;
                if (kelurahanId) data.kelurahan_id = kelurahanId;

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>');
                        $.each(data, function(index, kk) {
                            var selected = {{ json_encode($pendamping->kartuKeluargas->pluck('id')->toArray()) }}.includes(kk.id) ? 'selected' : '';
                            $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                        });
                        $('#kartu_keluarga_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }

            // Photo upload functionality
            const photoUploadArea = $('#photoUploadArea');
            const photoInput = $('#foto');
            const photoPreview = $('#photoPreview');

            photoUploadArea.on('click', function() {
                photoInput.click();
            });

            photoInput.on('change', function(e) {
                if (this.files && this.files[0]) {
                    if (!this.files[0].type.match('image/jpeg|image/jpg|image/png')) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format Tidak Didukung',
                            text: 'Silakan pilih file gambar (JPG, PNG)',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }
                    if (this.files[0].size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.attr('src', e.target.result).show();
                        photoUploadArea.hide();
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Drag and drop functionality for photo upload
            photoUploadArea.on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            photoUploadArea.on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            photoUploadArea.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    photoInput[0].files = files;
                    photoInput.trigger('change');
                }
            });

            // Remove photo functionality
            $('#removePhoto').on('click', function() {
                Swal.fire({
                    title: 'Hapus Foto Pendamping?',
                    text: 'Foto saat ini akan dihapus dari sistem. Tindakan ini tidak dapat dibatalkan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const hiddenInput = $('<input>').attr({
                            type: 'hidden',
                            name: 'remove_photo',
                            value: '1'
                        });
                        $('#pendampingForm').append(hiddenInput);
                        $(this).closest('.photo-container').find('.current-photo').parent().hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Foto Dihapus',
                            text: 'Foto telah ditandai untuk dihapus.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            });

            // Clear new photo preview
            photoPreview.on('click', function() {
                if ($(this).is(':visible')) {
                    Swal.fire({
                        title: 'Hapus Foto Baru?',
                        text: 'Foto yang baru diunggah akan dihapus.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            photoInput.val('');
                            photoPreview.hide();
                            photoUploadArea.show();
                            Swal.fire({
                                icon: 'success',
                                title: 'Foto Baru Dihapus',
                                text: 'Foto baru telah dihapus dari pratinjau.',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                }
            });

            // Activity checkbox handling
            const activities = ['penyuluhan', 'rujukan', 'kunjungan_krs', 'pendataan_bansos', 'pemantauan_kesehatan'];
            activities.forEach(function(activity) {
                const checkbox = $('#' + activity);
                const frequencyInput = $('#' + activity + '_frekuensi');
                checkbox.on('change', function() {
                    frequencyInput.prop('disabled', !this.checked);
                    if (!this.checked) {
                        frequencyInput.val('');
                    }
                });
                // Trigger initial state
                frequencyInput.prop('disabled', !checkbox.is(':checked'));
            });

            // Form validation
            $('#pendampingForm').on('submit', function(e) {
                let isValid = true;
                const requiredFields = ['nama', 'peran', 'tahun_bergabung', 'status', 'kecamatan_id', 'kelurahan_id', 'kartu_keluarga_id'];

                requiredFields.forEach(function(field) {
                    const input = $('#' + field);
                    if (!input.val()) {
                        isValid = false;
                        const errorDiv = input.parent().find('.error-message').length ? input.parent().find('.error-message') : $('<div class="error-message"><i class="fas fa-exclamation-circle"></i> Kolom ini wajib diisi</div>');
                        input.parent().append(errorDiv);
                    } else {
                        input.parent().find('.error-message').remove();
                    }
                });

                // Validate frequency inputs for checked activities
                activities.forEach(function(activity) {
                    const checkbox = $('#' + activity);
                    const frequencyInput = $('#' + activity + '_frekuensi');
                    if (checkbox.is(':checked') && !frequencyInput.val()) {
                        isValid = false;
                        const errorDiv = frequencyInput.parent().find('.error-message').length ? frequencyInput.parent().find('.error-message') : $('<div class="error-message"><i class="fas fa-exclamation-circle"></i> Frekuensi wajib diisi jika aktivitas dipilih</div>');
                        frequencyInput.parent().append(errorDiv);
                    } else {
                        frequencyInput.parent().find('.error-message').remove();
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Data Tidak Lengkap',
                        text: 'Silakan isi semua kolom wajib.',
                        confirmButtonColor: '#3b82f6'
                    });
                }
            });

            // Session messages
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3b82f6'
                });
            @endif
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