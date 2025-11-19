<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Calon Pengantin - Master Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
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
        .input-with-icon {
            position: relative;
        }
        .input-with-icon i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .input-with-icon input, .input-with-icon textarea, .input-with-icon select {
            padding-left: 40px;
        }
        .progress-bar {
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            width: 0%;
            transition: width 0.5s ease;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('master.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-blue-600 mr-3"></i>
                            Edit Data Calon Pengantin
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui data calon pengantin dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('catin.index') }}" 
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

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">Terdapat kesalahan dalam pengisian form:</p>
                        <ul class="mt-1 list-disc list-inside text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <form action="{{ route('catin.update', $catin->id) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')
                
                <!-- Informasi Umum -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                            Informasi Umum
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui tanggal pencatatan data</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hari_tanggal" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-day text-blue-500 mr-2 text-xs"></i>
                                    Hari/Tanggal
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar"></i>
                                    <input type="date" name="hari_tanggal" id="hari_tanggal" 
                                           value="{{ $catin->hari_tanggal ? $catin->hari_tanggal->format('Y-m-d') : '' }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           required>
                                </div>
                                @error('hari_tanggal')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biodata Catin Wanita -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-female text-pink-500 mr-2"></i>
                            Biodata Catin Wanita
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data lengkap calon pengantin wanita</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="catin_wanita_nama" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user text-pink-500 mr-2 text-xs"></i>
                                    Nama Lengkap
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-signature"></i>
                                    <input type="text" name="catin_wanita_nama" id="catin_wanita_nama" 
                                           value="{{ $catin->catin_wanita_nama ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan nama lengkap" required>
                                </div>
                                @error('catin_wanita_nama')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_wanita_nik" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-address-card text-pink-500 mr-2 text-xs"></i>
                                    NIK
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-id-card"></i>
                                    <input type="text" name="catin_wanita_nik" id="catin_wanita_nik" 
                                           value="{{ $catin->catin_wanita_nik ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan NIK" required>
                                </div>
                                @error('catin_wanita_nik')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_wanita_tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map-marker-alt text-pink-500 mr-2 text-xs"></i>
                                    Tempat Lahir
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-city"></i>
                                    <input type="text" name="catin_wanita_tempat_lahir" id="catin_wanita_tempat_lahir" 
                                           value="{{ $catin->catin_wanita_tempat_lahir ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan tempat lahir" required>
                                </div>
                                @error('catin_wanita_tempat_lahir')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_wanita_tgl_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-birthday-cake text-pink-500 mr-2 text-xs"></i>
                                    Tanggal Lahir
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar"></i>
                                    <input type="date" name="catin_wanita_tgl_lahir" id="catin_wanita_tgl_lahir" 
                                           value="{{ $catin->catin_wanita_tgl_lahir ? $catin->catin_wanita_tgl_lahir->format('Y-m-d') : '' }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           required>
                                </div>
                                @error('catin_wanita_tgl_lahir')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_wanita_no_hp" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-phone text-pink-500 mr-2 text-xs"></i>
                                    No HP
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                    <input type="text" name="catin_wanita_no_hp" id="catin_wanita_no_hp" 
                                           value="{{ $catin->catin_wanita_no_hp ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan nomor HP" required>
                                </div>
                                @error('catin_wanita_no_hp')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="catin_wanita_alamat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-home text-pink-500 mr-2 text-xs"></i>
                                    Alamat Lengkap
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-map-pin"></i>
                                    <textarea name="catin_wanita_alamat" id="catin_wanita_alamat" rows="3"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                              placeholder="Masukkan alamat lengkap" required>{{ $catin->catin_wanita_alamat ?? '' }}</textarea>
                                </div>
                                @error('catin_wanita_alamat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biodata Catin Pria -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-male text-blue-500 mr-2"></i>
                            Biodata Catin Pria
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data lengkap calon pengantin pria</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="catin_pria_nama" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user text-blue-500 mr-2 text-xs"></i>
                                    Nama Lengkap
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-signature"></i>
                                    <input type="text" name="catin_pria_nama" id="catin_pria_nama" 
                                           value="{{ $catin->catin_pria_nama ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan nama lengkap" required>
                                </div>
                                @error('catin_pria_nama')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_pria_nik" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-address-card text-blue-500 mr-2 text-xs"></i>
                                    NIK
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-id-card"></i>
                                    <input type="text" name="catin_pria_nik" id="catin_pria_nik" 
                                           value="{{ $catin->catin_pria_nik ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan NIK" required>
                                </div>
                                @error('catin_pria_nik')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_pria_tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-2 text-xs"></i>
                                    Tempat Lahir
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-city"></i>
                                    <input type="text" name="catin_pria_tempat_lahir" id="catin_pria_tempat_lahir" 
                                           value="{{ $catin->catin_pria_tempat_lahir ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan tempat lahir" required>
                                </div>
                                @error('catin_pria_tempat_lahir')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_pria_tgl_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-birthday-cake text-blue-500 mr-2 text-xs"></i>
                                    Tanggal Lahir
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar"></i>
                                    <input type="date" name="catin_pria_tgl_lahir" id="catin_pria_tgl_lahir" 
                                           value="{{ $catin->catin_pria_tgl_lahir ? $catin->catin_pria_tgl_lahir->format('Y-m-d') : '' }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           required>
                                </div>
                                @error('catin_pria_tgl_lahir')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="catin_pria_no_hp" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-phone text-blue-500 mr-2 text-xs"></i>
                                    No HP
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                    <input type="text" name="catin_pria_no_hp" id="catin_pria_no_hp" 
                                           value="{{ $catin->catin_pria_no_hp ?? '' }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan nomor HP" required>
                                </div>
                                @error('catin_pria_no_hp')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="catin_pria_alamat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-home text-blue-500 mr-2 text-xs"></i>
                                    Alamat Lengkap
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-map-pin"></i>
                                    <textarea name="catin_pria_alamat" id="catin_pria_alamat" rows="3"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                              placeholder="Masukkan alamat lengkap" required>{{ $catin->catin_pria_alamat ?? '' }}</textarea>
                                </div>
                                @error('catin_pria_alamat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hasil Pemeriksaan Catin Wanita -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-stethoscope text-green-500 mr-2"></i>
                            Hasil Pemeriksaan Catin Wanita
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui hasil pemeriksaan kesehatan calon pengantin wanita</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tanggal_pernikahan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-heart text-red-500 mr-2 text-xs"></i>
                                    Tanggal Pernikahan
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar"></i>
                                    <input type="date" name="tanggal_pernikahan" id="tanggal_pernikahan" 
                                           value="{{ $catin->tanggal_pernikahan ? $catin->tanggal_pernikahan->format('Y-m-d') : '' }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                </div>
                                @error('tanggal_pernikahan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="berat_badan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-weight-scale text-green-500 mr-2 text-xs"></i>
                                    Berat Badan (kg)
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-weight"></i>
                                    <input type="number" name="berat_badan" id="berat_badan" 
                                           value="{{ $catin->berat_badan ?? '' }}" step="0.1" min="0" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="0.0">
                                </div>
                                @error('berat_badan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tinggi_badan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-ruler-vertical text-green-500 mr-2 text-xs"></i>
                                    Tinggi Badan (cm)
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-arrows-up-down"></i>
                                    <input type="number" name="tinggi_badan" id="tinggi_badan" 
                                           value="{{ $catin->tinggi_badan ?? '' }}" step="0.1" min="0" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="0.0">
                                </div>
                                @error('tinggi_badan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="imt" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calculator text-green-500 mr-2 text-xs"></i>
                                    IMT
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-chart-line"></i>
                                    <input type="number" name="imt" id="imt" 
                                           value="{{ $catin->imt ?? '' }}" step="0.1" min="0" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="0.0">
                                </div>
                                @error('imt')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kadar_hb" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-tint text-red-500 mr-2 text-xs"></i>
                                    Kadar HB (g/dL)
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-vial"></i>
                                    <input type="number" name="kadar_hb" id="kadar_hb" 
                                           value="{{ $catin->kadar_hb ?? '' }}" step="0.1" min="0" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="0.0">
                                </div>
                                @error('kadar_hb')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="merokok" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-smoking text-orange-500 mr-2 text-xs"></i>
                                    Merokok
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-question-circle"></i>
                                    <select name="merokok" id="merokok" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
                                        <option value="" {{ $catin->merokok == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                                        <option value="Ya" {{ $catin->merokok == 'Ya' ? 'selected' : '' }}>Ya</option>
                                        <option value="Tidak" {{ $catin->merokok == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                                @error('merokok')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('catin.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Data Calon Pengantin
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        // Animasi loading saat form disubmit
        document.getElementById('editForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memperbarui...';
            submitBtn.disabled = true;
        });

        // Validasi form sebelum submit
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('input[required], textarea[required], select[required]');
            let valid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Tidak Lengkap',
                    text: 'Harap lengkapi semua field yang wajib diisi',
                    confirmButtonColor: '#3b82f6'
                });
            }
        });

        // Animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.form-section');
            sections.forEach((section, index) => {
                setTimeout(() => {
                    section.style.opacity = '0';
                    section.style.transform = 'translateY(20px)';
                    section.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
</body>
</html>