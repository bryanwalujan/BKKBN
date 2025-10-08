<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Stunting - Admin Kelurahan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
        .status-sehat {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-waspada {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-bahaya {
            background-color: #fee2e2;
            color: #991b1b;
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
                            <i class="fas fa-chart-line text-green-500 mr-3"></i>
                            Tambah Data Stunting
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data stunting baru ke dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kelurahan.stunting.index') }}" 
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
                        <p class="text-red-800 font-medium">Terjadi kesalahan:</p>
                        <p class="mt-1 text-red-700">{{ session('error') }}</p>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
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

            @if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan)
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">Data tidak lengkap:</p>
                        <p class="mt-1 text-red-700">
                            {{ $kartuKeluargas->isEmpty() ? 'Tidak ada data Kartu Keluarga. ' : '' }}
                            {{ !$kecamatan || !$kelurahan ? 'Data kecamatan atau kelurahan tidak ditemukan. ' : '' }}
                            Silakan tambahkan data terlebih dahulu.
                        </p>
                    </div>
                </div>
            @else
                <form action="{{ route('kelurahan.stunting.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Informasi Lokasi -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                Informasi Lokasi
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Lokasi tempat tinggal balita</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-map text-blue-500 mr-2 text-xs"></i>
                                        Kecamatan
                                    </label>
                                    <div class="relative">
                                        <input type="text" value="{{ $kecamatan->nama_kecamatan }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 p-3 pl-10" readonly>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-city text-gray-400"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-map-pin text-green-500 mr-2 text-xs"></i>
                                        Kelurahan
                                    </label>
                                    <div class="relative">
                                        <input type="text" value="{{ $kelurahan->nama_kelurahan }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 p-3 pl-10" readonly>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-home text-gray-400"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="kelurahan_id" value="{{ $kelurahan->id }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Kartu Keluarga -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-id-card text-blue-500 mr-2"></i>
                                Informasi Kartu Keluarga
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Pilih kartu keluarga yang sesuai</p>
                        </div>
                        <div class="form-section-body">
                            <div>
                                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-hashtag text-purple-500 mr-2 text-xs"></i>
                                    Nomor Kartu Keluarga
                                </label>
                                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <option value="">-- Pilih Kartu Keluarga --</option>
                                    @foreach ($kartuKeluargas as $kk)
                                        <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>
                                            {{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kartu_keluarga_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pribadi Balita -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-user text-yellow-500 mr-2"></i>
                                Informasi Pribadi Balita
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Masukkan data pribadi balita</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-address-card text-blue-500 mr-2 text-xs"></i>
                                        NIK
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="nik" id="nik" value="{{ old('nik') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               pattern="[0-9]{16}" inputmode="numeric" maxlength="16" placeholder="Masukkan 16 digit NIK">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-id-card text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('nik')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-signature text-green-500 mr-2 text-xs"></i>
                                        Nama Lengkap
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               placeholder="Masukkan nama lengkap balita" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('nama')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-calendar-alt text-purple-500 mr-2 text-xs"></i>
                                        Tanggal Lahir
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-birthday-cake text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('tanggal_lahir')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-venus-mars text-pink-500 mr-2 text-xs"></i>
                                        Jenis Kelamin
                                    </label>
                                    <div class="relative">
                                        <select name="jenis_kelamin" id="jenis_kelamin" 
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                                required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('jenis_kelamin')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Pengukuran -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-ruler-combined text-red-500 mr-2"></i>
                                Data Pengukuran
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Masukkan data pengukuran fisik balita</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="berat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-weight-scale text-blue-500 mr-2 text-xs"></i>
                                        Berat (kg)
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="berat" id="berat" value="{{ old('berat') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               step="0.1" placeholder="0.0" required>
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
                                        Tinggi (cm)
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               step="0.1" placeholder="0.0" required>
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

                    <!-- Status Gizi dan Tindak Lanjut -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                                Status Gizi dan Tindak Lanjut
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Tentukan status gizi dan rencana tindak lanjut</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="status_gizi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-apple-whole text-green-500 mr-2 text-xs"></i>
                                        Status Gizi
                                    </label>
                                    <div class="relative">
                                        <select name="status_gizi" id="status_gizi" 
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                                required>
                                            <option value="">-- Pilih Status Gizi --</option>
                                            <option value="Sehat" {{ old('status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                            <option value="Stunting" {{ old('status_gizi') == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                                            <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                            <option value="Obesitas" {{ old('status_gizi') == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('status_gizi')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="warna_gizi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-palette text-purple-500 mr-2 text-xs"></i>
                                        Warna Status Gizi
                                    </label>
                                    <div class="relative">
                                        <select name="warna_gizi" id="warna_gizi" 
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                                required>
                                            <option value="">-- Pilih Warna Status --</option>
                                            <option value="Sehat" {{ old('warna_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                            <option value="Waspada" {{ old('warna_gizi') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                            <option value="Bahaya" {{ old('warna_gizi') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('warna_gizi')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tindak_lanjut" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-clipboard-check text-blue-500 mr-2 text-xs"></i>
                                        Tindak Lanjut
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="tindak_lanjut" id="tindak_lanjut" value="{{ old('tindak_lanjut') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               placeholder="Rencana tindak lanjut">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-tasks text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('tindak_lanjut')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="warna_tindak_lanjut" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-palette text-yellow-500 mr-2 text-xs"></i>
                                        Warna Tindak Lanjut
                                    </label>
                                    <div class="relative">
                                        <select name="warna_tindak_lanjut" id="warna_tindak_lanjut" 
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                                required>
                                            <option value="">-- Pilih Warna Tindak Lanjut --</option>
                                            <option value="Sehat" {{ old('warna_tindak_lanjut') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                            <option value="Waspada" {{ old('warna_tindak_lanjut') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                            <option value="Bahaya" {{ old('warna_tindak_lanjut') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class="fas fa-chevron-down text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('warna_tindak_lanjut')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                                Informasi Tambahan
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Masukkan informasi tambahan tentang balita</p>
                        </div>
                        <div class="form-section-body">
                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-camera text-green-500 mr-2 text-xs"></i>
                                    Foto Kartu Identitas
                                </label>
                                <div class="relative">
                                    <input type="file" name="foto" id="foto" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           accept="image/*">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                </div>
                                @error('foto')
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
                        <a href="{{ route('kelurahan.stunting.index') }}" 
                           class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                        <button type="submit" 
                                class="flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors card-hover">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Data Stunting
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            // Validasi sisi klien untuk NIK
            $('#nik').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Hanya izinkan angka
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16); // Batasi 16 digit
                }
            });
        });
    </script>
</body>
</html>