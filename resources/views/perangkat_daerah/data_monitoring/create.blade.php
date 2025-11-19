<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Monitoring - Perangkat Daerah</title>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
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
        .bg-gradient-sidebar {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .form-section-header {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-bottom: 1px solid #d1fae5;
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
        .badge-preview {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('perangkat_daerah.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-chart-line text-green-600 mr-3"></i>
                            Tambah Data Monitoring
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data monitoring baru ke dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('perangkat_daerah.data_monitoring.index') }}" 
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

            <form action="{{ route('perangkat_daerah.data_monitoring.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Informasi Wilayah -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                            Informasi Wilayah
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Informasi wilayah tempat tinggal target monitoring</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map text-green-500 mr-2 text-xs"></i>
                                    Kecamatan
                                </label>
                                <div class="info-box">
                                    <p class="text-gray-800 font-medium">{{ $kecamatan->nama_kecamatan ?? '-' }}</p>
                                    <p class="text-sm text-gray-600 mt-1">Wilayah kerja Anda</p>
                                </div>
                            </div>

                            <div>
                                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map-pin text-green-500 mr-2 text-xs"></i>
                                    Kelurahan
                                </label>
                                <div class="relative">
                                    <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3" required>
                                        <option value="">-- Pilih Kelurahan --</option>
                                        @foreach ($kelurahans as $kelurahan)
                                            <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kelurahan_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Target Monitoring -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-bullseye text-green-500 mr-2"></i>
                            Target Monitoring
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Tentukan target yang akan dimonitoring</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="target" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-crosshairs text-green-500 mr-2 text-xs"></i>
                                    Target Monitoring
                                </label>
                                <div class="relative">
                                    <select name="target" id="target" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none" required>
                                        <option value="">-- Pilih Target --</option>
                                        <option value="Ibu" {{ old('target') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                        <option value="Balita" {{ old('target') == 'Balita' ? 'selected' : '' }}>Balita</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('target')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-id-card text-green-500 mr-2 text-xs"></i>
                                    Kartu Keluarga
                                </label>
                                <div class="relative">
                                    <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3" required>
                                        <option value="">-- Pilih Kartu Keluarga --</option>
                                        @if ($kartuKeluarga)
                                            <option value="{{ $kartuKeluarga->id }}" selected>{{ $kartuKeluarga->no_kk }} - {{ $kartuKeluarga->kepala_keluarga }}</option>
                                        @endif
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kartu_keluarga_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Target -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user text-green-500 mr-2"></i>
                            Informasi Target
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih target yang akan dimonitoring</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div id="ibu_id_div" style="display: {{ old('target') == 'Ibu' ? 'block' : 'none' }};">
                                <label for="ibu_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-female text-pink-500 mr-2 text-xs"></i>
                                    Nama Ibu
                                </label>
                                <div class="relative">
                                    <select name="ibu_id" id="ibu_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none">
                                        <option value="">-- Pilih Nama Ibu --</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('ibu_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div id="balita_id_div" style="display: {{ old('target') == 'Balita' ? 'block' : 'none' }};">
                                <label for="balita_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-baby text-blue-500 mr-2 text-xs"></i>
                                    Nama Balita
                                </label>
                                <div class="relative">
                                    <select name="balita_id" id="balita_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none">
                                        <option value="">-- Pilih Nama Balita --</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('balita_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori dan Perkembangan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-tags text-purple-500 mr-2"></i>
                            Kategori dan Perkembangan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Tentukan kategori dan perkembangan target</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-tag text-purple-500 mr-2 text-xs"></i>
                                    Kategori
                                </label>
                                <div class="relative">
                                    <select name="kategori" id="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoriOptions as $kategoriOption)
                                            <option value="{{ $kategoriOption }}" {{ old('kategori') == $kategoriOption ? 'selected' : '' }}>{{ $kategoriOption }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kategori')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-info-circle text-green-500 mr-2 text-xs"></i>
                                    Status
                                </label>
                                <div class="relative">
                                    <select name="status" id="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none" required>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach ($statusOptions as $statusOption)
                                            <option value="{{ $statusOption }}" {{ old('status') == $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                        @endforeach
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

                        <div class="mt-6">
                            <label for="perkembangan_anak" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-chart-line text-green-500 mr-2 text-xs"></i>
                                Perkembangan Anak
                            </label>
                            <textarea name="perkembangan_anak" id="perkembangan_anak" rows="3"
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3"
                                      placeholder="Masukkan perkembangan anak">{{ old('perkembangan_anak') }}</textarea>
                            @error('perkembangan_anak')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Program dan Intervensi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-clipboard-list text-orange-500 mr-2"></i>
                            Program dan Intervensi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Informasi program dan intervensi yang diberikan</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kunjungan Rumah -->
                            <div>
                                <label for="kunjungan_rumah" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-home text-green-500 mr-2 text-xs"></i>
                                    Kunjungan Rumah
                                </label>
                                <div class="relative">
                                    <select name="kunjungan_rumah" id="kunjungan_rumah" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none">
                                        <option value="0" {{ old('kunjungan_rumah') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="1" {{ old('kunjungan_rumah') == '1' ? 'selected' : '' }}>Ada</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kunjungan_rumah')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Frekuensi Kunjungan -->
                            <div id="frekuensi_kunjungan_div" style="display: {{ old('kunjungan_rumah') == '1' ? 'block' : 'none' }};">
                                <label for="frekuensi_kunjungan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-green-500 mr-2 text-xs"></i>
                                    Frekuensi Kunjungan
                                </label>
                                <div class="relative">
                                    <select name="frekuensi_kunjungan" id="frekuensi_kunjungan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none">
                                        <option value="" {{ old('frekuensi_kunjungan') == '' ? 'selected' : '' }}>-- Pilih Frekuensi --</option>
                                        <option value="Per Minggu" {{ old('frekuensi_kunjungan') == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                                        <option value="Per Bulan" {{ old('frekuensi_kunjungan') == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                                        <option value="Per 3 Bulan" {{ old('frekuensi_kunjungan') == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('frekuensi_kunjungan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Pemberian PMT -->
                            <div>
                                <label for="pemberian_pmt" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-apple-whole text-yellow-500 mr-2 text-xs"></i>
                                    Pemberian PMT
                                </label>
                                <div class="relative">
                                    <select name="pemberian_pmt" id="pemberian_pmt" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none">
                                        <option value="0" {{ old('pemberian_pmt') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="1" {{ old('pemberian_pmt') == '1' ? 'selected' : '' }}>Ada</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('pemberian_pmt')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Frekuensi PMT -->
                            <div id="frekuensi_pmt_div" style="display: {{ old('pemberian_pmt') == '1' ? 'block' : 'none' }};">
                                <label for="frekuensi_pmt" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-green-500 mr-2 text-xs"></i>
                                    Frekuensi PMT
                                </label>
                                <div class="relative">
                                    <select name="frekuensi_pmt" id="frekuensi_pmt" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none">
                                        <option value="" {{ old('frekuensi_pmt') == '' ? 'selected' : '' }}>-- Pilih Frekuensi --</option>
                                        <option value="Per Minggu" {{ old('frekuensi_pmt') == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                                        <option value="Per Bulan" {{ old('frekuensi_pmt') == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                                        <option value="Per 3 Bulan" {{ old('frekuensi_pmt') == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('frekuensi_pmt')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Monitoring -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-calendar-check text-indigo-500 mr-2"></i>
                            Informasi Monitoring
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Detail informasi monitoring</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="tanggal_monitoring" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-day text-green-500 mr-2 text-xs"></i>
                                    Tanggal Monitoring
                                </label>
                                <div class="relative">
                                    <input type="date" name="tanggal_monitoring" id="tanggal_monitoring" value="{{ old('tanggal_monitoring') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
                                           required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tanggal_monitoring')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-sort-numeric-up text-green-500 mr-2 text-xs"></i>
                                    Urutan
                                </label>
                                <div class="relative">
                                    <input type="number" name="urutan" id="urutan" value="{{ old('urutan') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
                                           required min="1" placeholder="Masukkan urutan">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-list-ol text-gray-400"></i>
                                    </div>
                                </div>
                                @error('urutan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="warna_badge" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-palette text-purple-500 mr-2 text-xs"></i>
                                    Warna Badge
                                </label>
                                <div class="relative">
                                    <select name="warna_badge" id="warna_badge" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none"
                                            required>
                                        <option value="Hijau" {{ old('warna_badge') == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                                        <option value="Kuning" {{ old('warna_badge') == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                                        <option value="Merah" {{ old('warna_badge') == 'Merah' ? 'selected' : '' }}>Merah</option>
                                        <option value="Biru" {{ old('warna_badge') == 'Biru' ? 'selected' : '' }}>Biru</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('warna_badge')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="status_aktif" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-toggle-on text-green-500 mr-2 text-xs"></i>
                                    Status Aktif
                                </label>
                                <div class="relative">
                                    <select name="status_aktif" id="status_aktif" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none"
                                            required>
                                        <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status_aktif')
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
                    <a href="{{ route('perangkat_daerah.data_monitoring.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Monitoring
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
            $('#target').select2({
                placeholder: 'Pilih Target',
                allowClear: true
            });

            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true
            });

            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            $('#ibu_id').select2({
                placeholder: 'Pilih Nama Ibu',
                allowClear: true
            });

            $('#balita_id').select2({
                placeholder: 'Pilih Nama Balita',
                allowClear: true
            });

            $('#kategori').select2({
                placeholder: 'Pilih Kategori',
                allowClear: true
            });

            $('#status').select2({
                placeholder: 'Pilih Status',
                allowClear: true
            });

            $('#kunjungan_rumah').select2({
                placeholder: 'Pilih Kunjungan Rumah',
                allowClear: true
            });

            $('#pemberian_pmt').select2({
                placeholder: 'Pilih Pemberian PMT',
                allowClear: true
            });

            $('#frekuensi_kunjungan').select2({
                placeholder: 'Pilih Frekuensi',
                allowClear: true
            });

            $('#frekuensi_pmt').select2({
                placeholder: 'Pilih Frekuensi',
                allowClear: true
            });

            $('#warna_badge').select2({
                placeholder: 'Pilih Warna Badge',
                allowClear: true
            });

            $('#status_aktif').select2({
                placeholder: 'Pilih Status Aktif',
                allowClear: true
            });

            // Show/hide ibu_id and balita_id based on target
            $('#target').on('change', function() {
                var target = $(this).val();
                if (target === 'Ibu') {
                    $('#ibu_id_div').show();
                    $('#balita_id_div').hide();
                    $('#balita_id').val('').trigger('change');
                } else if (target === 'Balita') {
                    $('#balita_id_div').show();
                    $('#ibu_id_div').hide();
                    $('#ibu_id').val('').trigger('change');
                } else {
                    $('#ibu_id_div').hide();
                    $('#balita_id_div').hide();
                    $('#ibu_id').val('').trigger('change');
                    $('#balita_id').val('').trigger('change');
                }
            });

            // Show/hide frekuensi_kunjungan based on kunjungan_rumah
            $('#kunjungan_rumah').on('change', function() {
                if ($(this).val() === '1') {
                    $('#frekuensi_kunjungan_div').show();
                } else {
                    $('#frekuensi_kunjungan_div').hide();
                    $('#frekuensi_kunjungan').val('').trigger('change');
                }
            });

            // Show/hide frekuensi_pmt based on pemberian_pmt
            $('#pemberian_pmt').on('change', function() {
                if ($(this).val() === '1') {
                    $('#frekuensi_pmt_div').show();
                } else {
                    $('#frekuensi_pmt_div').hide();
                    $('#frekuensi_pmt').val('').trigger('change');
                }
            });

            // Load kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                var kelurahanId = $(this).val();
                if (kelurahanId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.data_monitoring.getKartuKeluargaByKelurahan", ":kelurahan_id") }}'.replace(':kelurahan_id', kelurahanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                            $.each(data, function(index, kk) {
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                            $('#kartu_keluarga_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kartu keluarga:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                                confirmButtonColor: '#059669',
                            });
                        }
                    });
                } else {
                    $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                    $('#kartu_keluarga_id').trigger('change');
                }
            });

            // Load ibu and balita when kartu keluarga changes
            $('#kartu_keluarga_id').on('change', function() {
                var kartuKeluargaId = $(this).val();
                if (kartuKeluargaId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.data_monitoring.getIbuAndBalita", ":kartu_keluarga_id") }}'.replace(':kartu_keluarga_id', kartuKeluargaId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#ibu_id').empty().append('<option value="">Pilih Nama Ibu</option>');
                            if (data.ibus && data.ibus.length > 0) {
                                $.each(data.ibus, function(index, ibu) {
                                    $('#ibu_id').append('<option value="' + ibu.id + '">' + ibu.nama + '</option>');
                                });
                            } else {
                                $('#ibu_id').append('<option value="" disabled>Tidak ada data ibu</option>');
                            }

                            $('#balita_id').empty().append('<option value="">Pilih Nama Balita</option>');
                            if (data.balitas && data.balitas.length > 0) {
                                $.each(data.balitas, function(index, balita) {
                                    $('#balita_id').append('<option value="' + balita.id + '">' + balita.nama + '</option>');
                                });
                            } else {
                                $('#balita_id').append('<option value="" disabled>Tidak ada data balita</option>');
                            }

                            $('#ibu_id').trigger('change');
                            $('#balita_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching ibu and balita:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data ibu dan balita: ' + (xhr.responseJSON?.error || 'Silakan coba lagi.'),
                                confirmButtonColor: '#059669',
                            });
                        }
                    });
                } else {
                    $('#ibu_id').empty().append('<option value="">Pilih Nama Ibu</option>');
                    $('#balita_id').empty().append('<option value="">Pilih Nama Balita</option>');
                    $('#ibu_id').trigger('change');
                    $('#balita_id').trigger('change');
                }
            });

            // Load initial kartu keluarga and ibu/balita if applicable
            @if (old('kelurahan_id'))
                $('#kelurahan_id').val('{{ old('kelurahan_id') }}').trigger('change');
            @endif
            @if ($kartuKeluarga)
                $('#kartu_keluarga_id').val('{{ $kartuKeluarga->id }}').trigger('change');
            @endif
        });
    </script>
</body>
</html>