<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Aksi Konvergensi - CSSR</title>
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
        
        .photo-preview {
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px dashed #d1d5db;
            display: none;
            margin-top: 1rem;
        }
        
        .current-photo {
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #d1d5db;
            margin-top: 1rem;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .checkbox-container input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            cursor: pointer;
        }
        
        .checkbox-container label {
            margin-bottom: 0;
            cursor: pointer;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Aksi Konvergensi</span></h1>
                    <p class="text-gray-600">Edit data aksi konvergensi dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('aksi_konvergensi.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Aksi Konvergensi
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Session Error -->
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Session Success -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        <form action="{{ route('aksi_konvergensi.update', $aksiKonvergensi->id) }}" method="POST" enctype="multipart/form-data" id="aksiKonvergensiForm">
            @csrf
            @method('PUT')
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Form Edit Aksi Konvergensi</h3>
                        <p class="text-gray-600 text-sm mt-1">Perbarui informasi aksi konvergensi</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Form Edit Aksi</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan akurat dan lengkap untuk pemantauan yang optimal.
                    </p>
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
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $aksiKonvergensi->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
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
                                @foreach ($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $aksiKonvergensi->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
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
                                <i class="fas fa-id-card-alt mr-1 text-blue-500"></i> Kartu Keluarga
                            </label>
                            <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="form-input" required>
                                <option value="">-- Pilih Kartu Keluarga --</option>
                                @foreach ($kartuKeluargas as $kk)
                                    <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $aksiKonvergensi->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
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
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Aksi</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nama_aksi" class="form-label">
                                <i class="fas fa-tasks mr-1 text-blue-500"></i> Nama Aksi
                            </label>
                            <input type="text" name="nama_aksi" id="nama_aksi" value="{{ old('nama_aksi', $aksiKonvergensi->nama_aksi) }}" class="form-input" placeholder="Masukkan nama aksi" required>
                            @error('nama_aksi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-check-circle mr-1 text-blue-500"></i> Status
                            </label>
                            <div class="checkbox-container">
                                <input type="checkbox" name="selesai" id="selesai" value="1" {{ old('selesai', $aksiKonvergensi->selesai) ? 'checked' : '' }}>
                                <label for="selesai" class="text-gray-600">Tandai jika aksi telah selesai</label>
                            </div>
                            @error('selesai')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tahun" class="form-label">
                                <i class="fas fa-calendar mr-1 text-blue-500"></i> Tahun
                            </label>
                            <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $aksiKonvergensi->tahun) }}" min="2000" max="2050" class="form-input" placeholder="Masukkan tahun" required>
                            @error('tahun')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group md:col-span-2">
                            <label for="narasi" class="form-label">
                                <i class="fas fa-file-alt mr-1 text-blue-500"></i> Narasi
                            </label>
                            <textarea name="narasi" id="narasi" class="form-input" rows="4" placeholder="Masukkan narasi aksi">{{ old('narasi', $aksiKonvergensi->narasi) }}</textarea>
                            @error('narasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="pelaku_aksi" class="form-label">
                                <i class="fas fa-user mr-1 text-blue-500"></i> Pelaku Aksi
                            </label>
                            <input type="text" name="pelaku_aksi" id="pelaku_aksi" value="{{ old('pelaku_aksi', $aksiKonvergensi->pelaku_aksi) }}" class="form-input" placeholder="Masukkan pelaku aksi">
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
                            <input type="datetime-local" name="waktu_pelaksanaan" id="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan', $aksiKonvergensi->waktu_pelaksanaan ? $aksiKonvergensi->waktu_pelaksanaan->format('Y-m-d\TH:i') : '') }}" class="form-input">
                            @error('waktu_pelaksanaan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Upload Foto -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Foto Aksi</h4>
                    <div class="form-group">
                        <label for="foto" class="form-label">
                            <i class="fas fa-camera mr-1 text-blue-500"></i> Foto Aksi
                        </label>
                        
                        @if ($aksiKonvergensi->foto)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                <img src="{{ Storage::url($aksiKonvergensi->foto) }}" alt="Foto Aksi" class="current-photo">
                                <div class="mt-2">
                                    <a href="{{ Storage::url($aksiKonvergensi->foto) }}" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm flex items-center">
                                        <i class="fas fa-external-link-alt mr-1"></i> Lihat Foto
                                    </a>
                                    <button type="button" id="removeCurrentPhoto" class="text-red-500 hover:text-red-700 text-sm flex items-center mt-2">
                                        <i class="fas fa-trash mr-1"></i> Hapus Foto Saat Ini
                                    </button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Unggah foto baru (opsional):</p>
                        @endif
                        
                        <div class="photo-upload-area" id="photoUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="text-gray-600">Klik untuk memilih foto atau seret dan lepas di sini</p>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                        </div>
                        <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                        <div class="mt-2">
                            <img id="photoPreview" class="photo-preview" src="#" alt="Preview Foto">
                            <button type="button" id="removeNewPhoto" class="text-red-500 hover:text-red-700 text-sm flex items-center mt-2 hidden">
                                <i class="fas fa-trash mr-1"></i> Hapus Foto Baru
                            </button>
                        </div>
                        @error('foto')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Intervensi Sensitif -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Intervensi Sensitif</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="air_bersih_sanitasi" class="form-label">
                                <i class="fas fa-tint mr-1 text-blue-500"></i> Ketersediaan Air Bersih dan Sanitasi
                            </label>
                            <select name="air_bersih_sanitasi" id="air_bersih_sanitasi" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada-baik" {{ old('air_bersih_sanitasi', $aksiKonvergensi->air_bersih_sanitasi) == 'ada-baik' ? 'selected' : '' }}>Ada - Baik</option>
                                <option value="ada-buruk" {{ old('air_bersih_sanitasi', $aksiKonvergensi->air_bersih_sanitasi) == 'ada-buruk' ? 'selected' : '' }}>Ada - Buruk</option>
                                <option value="tidak" {{ old('air_bersih_sanitasi', $aksiKonvergensi->air_bersih_sanitasi) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('air_bersih_sanitasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="akses_layanan_kesehatan_kb" class="form-label">
                                <i class="fas fa-hospital mr-1 text-blue-500"></i> Akses Layanan Kesehatan dan KB
                            </label>
                            <select name="akses_layanan_kesehatan_kb" id="akses_layanan_kesehatan_kb" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('akses_layanan_kesehatan_kb', $aksiKonvergensi->akses_layanan_kesehatan_kb) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('akses_layanan_kesehatan_kb', $aksiKonvergensi->akses_layanan_kesehatan_kb) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('akses_layanan_kesehatan_kb')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="pendidikan_pengasuhan_ortu" class="form-label">
                                <i class="fas fa-book mr-1 text-blue-500"></i> Pendidikan Pengasuhan Orang Tua
                            </label>
                            <select name="pendidikan_pengasuhan_ortu" id="pendidikan_pengasuhan_ortu" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('pendidikan_pengasuhan_ortu', $aksiKonvergensi->pendidikan_pengasuhan_ortu) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('pendidikan_pengasuhan_ortu', $aksiKonvergensi->pendidikan_pengasuhan_ortu) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('pendidikan_pengasuhan_ortu')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="edukasi_kesehatan_remaja" class="form-label">
                                <i class="fas fa-heartbeat mr-1 text-blue-500"></i> Edukasi Kesehatan Remaja
                            </label>
                            <select name="edukasi_kesehatan_remaja" id="edukasi_kesehatan_remaja" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('edukasi_kesehatan_remaja', $aksiKonvergensi->edukasi_kesehatan_remaja) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('edukasi_kesehatan_remaja', $aksiKonvergensi->edukasi_kesehatan_remaja) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('edukasi_kesehatan_remaja')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kesadaran_pengasuhan_gizi" class="form-label">
                                <i class="fas fa-utensils mr-1 text-blue-500"></i> Kesadaran Pengasuhan dan Gizi
                            </label>
                            <select name="kesadaran_pengasuhan_gizi" id="kesadaran_pengasuhan_gizi" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('kesadaran_pengasuhan_gizi', $aksiKonvergensi->kesadaran_pengasuhan_gizi) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('kesadaran_pengasuhan_gizi', $aksiKonvergensi->kesadaran_pengasuhan_gizi) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('kesadaran_pengasuhan_gizi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="akses_pangan_bergizi" class="form-label">
                                <i class="fas fa-carrot mr-1 text-blue-500"></i> Akses Pangan Bergizi
                            </label>
                            <select name="akses_pangan_bergizi" id="akses_pangan_bergizi" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('akses_pangan_bergizi', $aksiKonvergensi->akses_pangan_bergizi) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('akses_pangan_bergizi', $aksiKonvergensi->akses_pangan_bergizi) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('akses_pangan_bergizi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Intervensi Spesifik -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Intervensi Spesifik</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="makanan_ibu_hamil" class="form-label">
                                <i class="fas fa-utensils mr-1 text-blue-500"></i> Makanan Ibu Hamil
                            </label>
                            <select name="makanan_ibu_hamil" id="makanan_ibu_hamil" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('makanan_ibu_hamil', $aksiKonvergensi->makanan_ibu_hamil) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('makanan_ibu_hamil', $aksiKonvergensi->makanan_ibu_hamil) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('makanan_ibu_hamil')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tablet_tambah_darah" class="form-label">
                                <i class="fas fa-pills mr-1 text-blue-500"></i> Tablet Tambah Darah
                            </label>
                            <select name="tablet_tambah_darah" id="tablet_tambah_darah" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('tablet_tambah_darah', $aksiKonvergensi->tablet_tambah_darah) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('tablet_tambah_darah', $aksiKonvergensi->tablet_tambah_darah) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('tablet_tambah_darah')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="inisiasi_menyusui_dini" class="form-label">
                                <i class="fas fa-baby mr-1 text-blue-500"></i> Inisiasi Menyusui Dini
                            </label>
                            <select name="inisiasi_menyusui_dini" id="inisiasi_menyusui_dini" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('inisiasi_menyusui_dini', $aksiKonvergensi->inisiasi_menyusui_dini) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('inisiasi_menyusui_dini', $aksiKonvergensi->inisiasi_menyusui_dini) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('inisiasi_menyusui_dini')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="asi_eksklusif" class="form-label">
                                <i class="fas fa-breastfeeding mr-1 text-blue-500"></i> ASI Eksklusif
                            </label>
                            <select name="asi_eksklusif" id="asi_eksklusif" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('asi_eksklusif', $aksiKonvergensi->asi_eksklusif) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('asi_eksklusif', $aksiKonvergensi->asi_eksklusif) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('asi_eksklusif')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="asi_mpasi" class="form-label">
                                <i class="fas fa-utensils mr-1 text-blue-500"></i> ASI dan MPASI
                            </label>
                            <select name="asi_mpasi" id="asi_mpasi" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('asi_mpasi', $aksiKonvergensi->asi_mpasi) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('asi_mpasi', $aksiKonvergensi->asi_mpasi) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('asi_mpasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="imunisasi_lengkap" class="form-label">
                                <i class="fas fa-syringe mr-1 text-blue-500"></i> Imunisasi Lengkap
                            </label>
                            <select name="imunisasi_lengkap" id="imunisasi_lengkap" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('imunisasi_lengkap', $aksiKonvergensi->imunisasi_lengkap) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('imunisasi_lengkap', $aksiKonvergensi->imunisasi_lengkap) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('imunisasi_lengkap')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="pencegahan_infeksi" class="form-label">
                                <i class="fas fa-shield-alt mr-1 text-blue-500"></i> Pencegahan Infeksi
                            </label>
                            <select name="pencegahan_infeksi" id="pencegahan_infeksi" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="ada" {{ old('pencegahan_infeksi', $aksiKonvergensi->pencegahan_infeksi) == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('pencegahan_infeksi', $aksiKonvergensi->pencegahan_infeksi) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('pencegahan_infeksi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_gizi_ibu" class="form-label">
                                <i class="fas fa-heart mr-1 text-blue-500"></i> Status Gizi Ibu
                            </label>
                            <select name="status_gizi_ibu" id="status_gizi_ibu" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="baik" {{ old('status_gizi_ibu', $aksiKonvergensi->status_gizi_ibu) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="buruk" {{ old('status_gizi_ibu', $aksiKonvergensi->status_gizi_ibu) == 'buruk' ? 'selected' : '' }}>Buruk</option>
                            </select>
                            @error('status_gizi_ibu')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="penyakit_menular" class="form-label">
                                <i class="fas fa-virus mr-1 text-blue-500"></i> Penyakit Menular
                            </label>
                            <select name="penyakit_menular" id="penyakit_menular" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="tidak" {{ old('penyakit_menular', $aksiKonvergensi->penyakit_menular) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                <option value="ada" {{ old('penyakit_menular', $aksiKonvergensi->penyakit_menular) == 'ada' ? 'selected' : '' }}>Ada</option>
                            </select>
                            @error('penyakit_menular')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="jenis_penyakit_container" style="display: {{ old('penyakit_menular', $aksiKonvergensi->penyakit_menular) == 'ada' ? 'block' : 'none' }};">
                            <label for="jenis_penyakit" class="form-label">
                                <i class="fas fa-disease mr-1 text-blue-500"></i> Jenis Penyakit
                            </label>
                            <input type="text" name="jenis_penyakit" id="jenis_penyakit" value="{{ old('jenis_penyakit', $aksiKonvergensi->jenis_penyakit) }}" class="form-input" placeholder="Masukkan jenis penyakit" {{ old('penyakit_menular', $aksiKonvergensi->penyakit_menular) == 'ada' ? 'required' : '' }}>
                            @error('jenis_penyakit')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kesehatan_lingkungan" class="form-label">
                                <i class="fas fa-leaf mr-1 text-blue-500"></i> Kesehatan Lingkungan
                            </label>
                            <select name="kesehatan_lingkungan" id="kesehatan_lingkungan" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="baik" {{ old('kesehatan_lingkungan', $aksiKonvergensi->kesehatan_lingkungan) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="buruk" {{ old('kesehatan_lingkungan', $aksiKonvergensi->kesehatan_lingkungan) == 'buruk' ? 'selected' : '' }}>Buruk</option>
                            </select>
                            @error('kesehatan_lingkungan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Form Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('aksi_konvergensi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
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
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: '-- Pilih Kecamatan --',
                allowClear: true,
                width: '100%'
            });

            $('#kelurahan_id').select2({
                placeholder: '-- Pilih Kelurahan --',
                allowClear: true,
                width: '100%'
            });

            $('#kartu_keluarga_id').select2({
                placeholder: '-- Pilih Kartu Keluarga --',
                allowClear: true,
                width: '100%'
            });

            $('#air_bersih_sanitasi, #akses_layanan_kesehatan_kb, #pendidikan_pengasuhan_ortu, #edukasi_kesehatan_remaja, #kesadaran_pengasuhan_gizi, #akses_pangan_bergizi, #makanan_ibu_hamil, #tablet_tambah_darah, #inisiasi_menyusui_dini, #asi_eksklusif, #asi_mpasi, #imunisasi_lengkap, #pencegahan_infeksi, #status_gizi_ibu, #penyakit_menular, #kesehatan_lingkungan').select2({
                placeholder: '-- Pilih --',
                allowClear: true,
                width: '100%'
            });

            // Load kelurahans and kartu keluarga on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                updateKelurahan(initialKecamatanId);
            }

            // Update kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    updateKelurahan(kecamatanId);
                } else {
                    $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>').trigger('change');
                }
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            // Handle penyakit_menular change
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

            // Trigger initial state for penyakit_menular
            $('#penyakit_menular').trigger('change');

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

            // Photo upload functionality
            const photoUploadArea = document.getElementById('photoUploadArea');
            const photoInput = document.getElementById('foto');
            const photoPreview = document.getElementById('photoPreview');
            const removeNewPhoto = document.getElementById('removeNewPhoto');
            const removeCurrentPhoto = document.getElementById('removeCurrentPhoto');
            const currentPhotoContainer = document.querySelector('.mb-4');

            // Click to upload
            photoUploadArea.addEventListener('click', function() {
                photoInput.click();
            });

            // Drag and drop
            photoUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                photoUploadArea.classList.add('dragover');
            });

            photoUploadArea.addEventListener('dragleave', function() {
                photoUploadArea.classList.remove('dragover');
            });

            photoUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                photoUploadArea.classList.remove('dragover');
                if (e.dataTransfer.files.length) {
                    photoInput.files = e.dataTransfer.files;
                    handlePhotoSelect(e.dataTransfer.files[0]);
                }
            });

            // Photo input change
            photoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handlePhotoSelect(this.files[0]);
                }
            });

            // Remove new photo
            removeNewPhoto.addEventListener('click', function() {
                photoInput.value = '';
                photoPreview.style.display = 'none';
                removeNewPhoto.classList.add('hidden');
                photoUploadArea.style.display = 'block';
            });

            // Remove current photo
            if (removeCurrentPhoto) {
                removeCurrentPhoto.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Hapus Foto Saat Ini?',
                        text: 'Foto saat ini akan dihapus dari sistem. Tindakan ini tidak dapat dibatalkan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'remove_current_photo';
                            hiddenInput.value = '1';
                            document.getElementById('aksiKonvergensiForm').appendChild(hiddenInput);
                            
                            currentPhotoContainer.style.display = 'none';
                            
                            Swal.fire(
                                'Dihapus!',
                                'Foto saat ini telah ditandai untuk dihapus.',
                                'success'
                            );
                        }
                    });
                });
            }

            function handlePhotoSelect(file) {
                if (!file.type.match('image.*')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Didukung',
                        text: 'Silakan pilih file gambar (JPG, PNG)',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 2MB',
                        confirmButtonColor: '#3b82f6'
                    });
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    photoPreview.style.display = 'block';
                    removeNewPhoto.classList.remove('hidden');
                    photoUploadArea.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }

            // Form validation
            $('#aksiKonvergensiForm').on('submit', function(e) {
                const requiredFields = ['kecamatan_id', 'kelurahan_id', 'kartu_keluarga_id', 'nama_aksi', 'tahun'];
                let isValid = true;

                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value) {
                        isValid = false;
                        const errorDiv = input.parentElement.querySelector('.error-message') || document.createElement('div');
                        errorDiv.className = 'error-message';
                        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Kolom ini wajib diisi';
                        input.parentElement.appendChild(errorDiv);
                    } else {
                        const errorDiv = input.parentElement.querySelector('.error-message');
                        if (errorDiv) errorDiv.remove();
                    }
                });

                if ($('#penyakit_menular').val() === 'ada' && !$('#jenis_penyakit').val()) {
                    isValid = false;
                    const errorDiv = document.getElementById('jenis_penyakit').parentElement.querySelector('.error-message') || document.createElement('div');
                    errorDiv.className = 'error-message';
                    errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Jenis penyakit wajib diisi jika penyakit menular dipilih';
                    document.getElementById('jenis_penyakit').parentElement.appendChild(errorDiv);
                }

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

            // AJAX functions
            function updateKelurahan(kecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == {{ old('kelurahan_id', $aksiKonvergensi->kelurahan_id) ?? 'null' }} ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memuat',
                            text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }

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
                            var selected = kk.id == {{ old('kartu_keluarga_id', $aksiKonvergensi->kartu_keluarga_id) ?? 'null' }} ? 'selected' : '';
                            $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                        });
                        $('#kartu_keluarga_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memuat',
                            text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>