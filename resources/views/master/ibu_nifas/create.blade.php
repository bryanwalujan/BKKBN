<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Ibu Nifas - Master Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .bg-gradient-sidebar {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
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
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 48px;
            padding: 0.5rem 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-badge.hijau {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-badge.kuning {
            background-color: #fef9c3;
            color: #854d0e;
        }
        .status-badge.merah {
            background-color: #fee2e2;
            color: #991b1b;
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
                            <i class="fas fa-person-pregnant text-purple-600 mr-3"></i>
                            Tambah Data Ibu Nifas
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data ibu nifas baru ke dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('ibu_nifas.index') }}" 
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

            <form action="{{ route('ibu_nifas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Informasi Ibu -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user text-purple-500 mr-2"></i>
                            Informasi Ibu
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih data ibu yang akan ditambahkan ke dalam sistem nifas</p>
                    </div>
                    <div class="form-section-body">
                        <div>
                            <label for="ibu_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2 text-xs"></i>
                                Nama Ibu
                            </label>
                            <select name="ibu_id" id="ibu_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                <option value="">-- Pilih Ibu --</option>
                                @foreach ($ibus as $ibu)
                                    <option value="{{ $ibu->id }}" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>
                                        {{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('ibu_id')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Persalinan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-baby text-pink-500 mr-2"></i>
                            Informasi Persalinan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan detail persalinan dan kondisi ibu</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hari_nifas" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-day text-blue-500 mr-2 text-xs"></i>
                                    Hari ke-Nifas
                                </label>
                                <div class="relative">
                                    <input type="number" name="hari_nifas" id="hari_nifas" value="{{ old('hari_nifas') }}" 
                                           min="0" max="42" step="1"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Hari ke-nifas" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-hashtag text-gray-400"></i>
                                    </div>
                                </div>
                                @error('hari_nifas')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_melahirkan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-green-500 mr-2 text-xs"></i>
                                    Tanggal Melahirkan
                                </label>
                                <div class="relative">
                                    <input type="date" name="tanggal_melahirkan" id="tanggal_melahirkan" value="{{ old('tanggal_melahirkan') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tanggal_melahirkan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tempat_persalinan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-hospital text-purple-500 mr-2 text-xs"></i>
                                    Tempat Persalinan
                                </label>
                                <div class="relative">
                                    <input type="text" name="tempat_persalinan" id="tempat_persalinan" value="{{ old('tempat_persalinan') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Tempat persalinan">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tempat_persalinan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="penolong_persalinan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user-md text-yellow-500 mr-2 text-xs"></i>
                                    Penolong Persalinan
                                </label>
                                <div class="relative">
                                    <input type="text" name="penolong_persalinan" id="penolong_persalinan" value="{{ old('penolong_persalinan') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Penolong persalinan">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-stethoscope text-gray-400"></i>
                                    </div>
                                </div>
                                @error('penolong_persalinan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="cara_persalinan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-baby-carriage text-pink-500 mr-2 text-xs"></i>
                                    Cara Persalinan
                                </label>
                                <div class="relative">
                                    <input type="text" name="cara_persalinan" id="cara_persalinan" value="{{ old('cara_persalinan') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Cara persalinan">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-baby text-gray-400"></i>
                                    </div>
                                </div>
                                @error('cara_persalinan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="komplikasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-500 mr-2 text-xs"></i>
                                    Komplikasi
                                </label>
                                <div class="relative">
                                    <input type="text" name="komplikasi" id="komplikasi" value="{{ old('komplikasi') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Komplikasi persalinan">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-exclamation text-gray-400"></i>
                                    </div>
                                </div>
                                @error('komplikasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Kesehatan Ibu -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                            Status Kesehatan Ibu
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan data kesehatan dan pemantauan ibu nifas</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="kondisi_kesehatan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-stethoscope text-blue-500 mr-2 text-xs"></i>
                                    Kondisi Kesehatan
                                </label>
                                <div class="relative">
                                    <select name="kondisi_kesehatan" id="kondisi_kesehatan" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Kondisi --</option>
                                        <option value="Normal" {{ old('kondisi_kesehatan') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="Butuh Perhatian" {{ old('kondisi_kesehatan') == 'Butuh Perhatian' ? 'selected' : '' }}>Butuh Perhatian</option>
                                        <option value="Kritis" {{ old('kondisi_kesehatan') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kondisi_kesehatan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="warna_kondisi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-palette text-purple-500 mr-2 text-xs"></i>
                                    Warna Kondisi
                                </label>
                                <div class="relative">
                                    <select name="warna_kondisi" id="warna_kondisi" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Warna --</option>
                                        <option value="Hijau (success)" {{ old('warna_kondisi') == 'Hijau (success)' ? 'selected' : '' }}>Hijau (success)</option>
                                        <option value="Kuning (warning)" {{ old('warna_kondisi') == 'Kuning (warning)' ? 'selected' : '' }}>Kuning (warning)</option>
                                        <option value="Merah (danger)" {{ old('warna_kondisi') == 'Merah (danger)' ? 'selected' : '' }}>Merah (danger)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('warna_kondisi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kb_pasca_salin" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-pills text-green-500 mr-2 text-xs"></i>
                                    KB Pasca Salin
                                </label>
                                <div class="relative">
                                    <input type="text" name="kb_pasca_salin" id="kb_pasca_salin" value="{{ old('kb_pasca_salin') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="KB pasca salin">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-capsules text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kb_pasca_salin')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label for="berat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-weight-scale text-blue-500 mr-2 text-xs"></i>
                                    Berat Ibu (kg)
                                </label>
                                <div class="relative">
                                    <input type="number" name="berat" id="berat" value="{{ old('berat') }}" 
                                           step="0.1" min="0"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="0.0" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-weight text-gray-400"></i>
                                    </div>
                                </div>
                                @error('berat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tinggi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-ruler-vertical text-green-500 mr-2 text-xs"></i>
                                    Tinggi Ibu (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" 
                                           step="0.1" min="0"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="0.0" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-arrows-up-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tinggi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Bayi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-baby text-yellow-500 mr-2"></i>
                            Informasi Bayi Baru Lahir
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan data bayi yang baru lahir</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="keadaan_bayi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-heart text-red-500 mr-2 text-xs"></i>
                                    Keadaan Bayi
                                </label>
                                <div class="relative">
                                    <input type="text" name="keadaan_bayi" id="keadaan_bayi" value="{{ old('keadaan_bayi') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Keadaan bayi">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-baby text-gray-400"></i>
                                    </div>
                                </div>
                                @error('keadaan_bayi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="bayi_umur_dalam_kandungan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-clock text-purple-500 mr-2 text-xs"></i>
                                    Umur Dalam Kandungan
                                </label>
                                <div class="relative">
                                    <input type="text" name="bayi[umur_dalam_kandungan]" id="bayi_umur_dalam_kandungan" value="{{ old('bayi.umur_dalam_kandungan') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Umur dalam kandungan">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-hourglass-half text-gray-400"></i>
                                    </div>
                                </div>
                                @error('bayi.umur_dalam_kandungan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="bayi_berat_badan_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-weight-scale text-blue-500 mr-2 text-xs"></i>
                                    Berat Badan Lahir (kg)
                                </label>
                                <div class="relative">
                                    <input type="text" name="bayi[berat_badan_lahir]" id="bayi_berat_badan_lahir" value="{{ old('bayi.berat_badan_lahir') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Berat badan lahir">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-weight text-gray-400"></i>
                                    </div>
                                </div>
                                @error('bayi.berat_badan_lahir')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="bayi_panjang_badan_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-ruler-vertical text-green-500 mr-2 text-xs"></i>
                                    Panjang Badan Lahir (cm)
                                </label>
                                <div class="relative">
                                    <input type="text" name="bayi[panjang_badan_lahir]" id="bayi_panjang_badan_lahir" value="{{ old('bayi.panjang_badan_lahir') }}" 
                                           maxlength="255"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Panjang badan lahir">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-ruler text-gray-400"></i>
                                    </div>
                                </div>
                                @error('bayi.panjang_badan_lahir')
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
                    <a href="{{ route('ibu_nifas.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Ibu Nifas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#ibu_id').select2({
                placeholder: 'Pilih Ibu',
                allowClear: true
            });

            // Update warna kondisi preview based on selection
            $('#warna_kondisi').on('change', function() {
                const selectedValue = $(this).val();
                let badgeClass = '';
                
                if (selectedValue.includes('Hijau')) {
                    badgeClass = 'hijau';
                } else if (selectedValue.includes('Kuning')) {
                    badgeClass = 'kuning';
                } else if (selectedValue.includes('Merah')) {
                    badgeClass = 'merah';
                }
                
                // You can add a preview element if needed
            });
        });
    </script>
</body>
</html>