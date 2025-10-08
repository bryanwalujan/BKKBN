<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Monitoring - Master Panel</title>
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
        .badge-preview {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
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
                            <i class="fas fa-chart-line text-blue-600 mr-3"></i>
                            Tambah Data Monitoring
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data monitoring baru ke dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('data_monitoring.index') }}" 
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

            <form action="{{ route('data_monitoring.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Target Monitoring -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-bullseye text-blue-500 mr-2"></i>
                            Target Monitoring
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Tentukan target yang akan dimonitoring</p>
                    </div>
                    <div class="form-section-body">
                        <div>
                            <label for="target" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-crosshairs text-blue-500 mr-2 text-xs"></i>
                                Target Monitoring
                            </label>
                            <div class="relative">
                                <select name="target" id="target" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none" required>
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
                    </div>
                </div>

                <!-- Informasi Lokasi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                            Informasi Lokasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Tentukan lokasi tempat tinggal target monitoring</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map text-blue-500 mr-2 text-xs"></i>
                                    Kecamatan
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map-pin text-green-500 mr-2 text-xs"></i>
                                    Kelurahan
                                </label>
                                <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <option value="">-- Pilih Kelurahan --</option>
                                    @foreach ($kelurahans as $kelurahan)
                                        <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                                    @endforeach
                                </select>
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
                                @if ($kartuKeluarga)
                                    <option value="{{ $kartuKeluarga->id }}" selected>{{ $kartuKeluarga->no_kk }} - {{ $kartuKeluarga->kepala_keluarga }}</option>
                                @endif
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

                <!-- Informasi Target -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user text-yellow-500 mr-2"></i>
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
                                    <select name="ibu_id" id="ibu_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
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
                                    <select name="balita_id" id="balita_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
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
                                    <select name="kategori" id="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none" required>
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
                                    <i class="fas fa-info-circle text-blue-500 mr-2 text-xs"></i>
                                    Status
                                </label>
                                <div class="relative">
                                    <select name="status" id="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none" required>
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
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
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
                                    <i class="fas fa-home text-blue-500 mr-2 text-xs"></i>
                                    Kunjungan Rumah
                                </label>
                                <div class="relative">
                                    <select name="kunjungan_rumah" id="kunjungan_rumah" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
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
                                    <select name="frekuensi_kunjungan" id="frekuensi_kunjungan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
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
                                    <select name="pemberian_pmt" id="pemberian_pmt" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
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
                                    <select name="frekuensi_pmt" id="frekuensi_pmt" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
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

                <!-- Faktor Risiko dan Layanan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            Faktor Risiko dan Layanan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Identifikasi faktor risiko dan layanan yang diterima</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label for="terpapar_rokok" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-smoking text-gray-500 mr-2 text-xs"></i>
                                    Terpapar Rokok
                                </label>
                                <div class="relative">
                                    <select name="terpapar_rokok" id="terpapar_rokok" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
                                        <option value="0" {{ old('terpapar_rokok') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('terpapar_rokok') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('terpapar_rokok')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="suplemen_ttd" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-pills text-purple-500 mr-2 text-xs"></i>
                                    Suplemen TTD
                                </label>
                                <div class="relative">
                                    <select name="suplemen_ttd" id="suplemen_ttd" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
                                        <option value="0" {{ old('suplemen_ttd') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('suplemen_ttd') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('suplemen_ttd')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="rujukan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-hospital text-red-500 mr-2 text-xs"></i>
                                    Rujukan
                                </label>
                                <div class="relative">
                                    <select name="rujukan" id="rujukan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
                                        <option value="0" {{ old('rujukan') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('rujukan') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('rujukan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="bantuan_sosial" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-hand-holding-heart text-pink-500 mr-2 text-xs"></i>
                                    Bantuan Sosial
                                </label>
                                <div class="relative">
                                    <select name="bantuan_sosial" id="bantuan_sosial" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
                                        <option value="0" {{ old('bantuan_sosial') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('bantuan_sosial') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('bantuan_sosial')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="posyandu_bkb" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-users text-green-500 mr-2 text-xs"></i>
                                    Posyandu/BKB
                                </label>
                                <div class="relative">
                                    <select name="posyandu_bkb" id="posyandu_bkb" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
                                        <option value="0" {{ old('posyandu_bkb') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('posyandu_bkb') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('posyandu_bkb')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kie" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-comments text-blue-500 mr-2 text-xs"></i>
                                    KIE
                                </label>
                                <div class="relative">
                                    <select name="kie" id="kie" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none">
                                        <option value="0" {{ old('kie') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('kie') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kie')
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
                                    <i class="fas fa-calendar-day text-blue-500 mr-2 text-xs"></i>
                                    Tanggal Monitoring
                                </label>
                                <div class="relative">
                                    <input type="date" name="tanggal_monitoring" id="tanggal_monitoring" value="{{ old('tanggal_monitoring') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
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
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
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
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
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
                                    <i class="fas fa-toggle-on text-blue-500 mr-2 text-xs"></i>
                                    Status Aktif
                                </label>
                                <div class="relative">
                                    <select name="status_aktif" id="status_aktif" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
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
                    <a href="{{ route('data_monitoring.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
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

            $('#kecamatan_id').select2({
                placeholder: 'Pilih Kecamatan',
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

            $('#terpapar_rokok').select2({
                placeholder: 'Pilih Terpapar Rokok',
                allowClear: true
            });

            $('#suplemen_ttd').select2({
                placeholder: 'Pilih Suplemen TTD',
                allowClear: true
            });

            $('#rujukan').select2({
                placeholder: 'Pilih Rujukan',
                allowClear: true
            });

            $('#bantuan_sosial').select2({
                placeholder: 'Pilih Bantuan Sosial',
                allowClear: true
            });

            $('#posyandu_bkb').select2({
                placeholder: 'Pilih Posyandu/BKB',
                allowClear: true
            });

            $('#kie').select2({
                placeholder: 'Pilih KIE',
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

            // Load kelurahans for old kecamatan_id on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == {{ old('kelurahan_id') ?? 'null' }} ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6',
                        });
                    }
                });
            }

            // Update kelurahans and kartu keluarga when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6',
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                    $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                    $('#kelurahan_id').trigger('change');
                }
                updateKartuKeluarga();
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            // Update ibu and balita when kartu keluarga changes
            $('#kartu_keluarga_id').on('change', function() {
                updateIbuAndBalita();
            });

            function updateKartuKeluarga() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $('#kelurahan_id').val();
                if (kecamatanId && kelurahanId) {
                    $.ajax({
                        url: '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}?kecamatan_id=' + kecamatanId + '&kelurahan_id=' + kelurahanId,
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
                                confirmButtonColor: '#3b82f6',
                            });
                        }
                    });
                } else {
                    $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                    $('#kartu_keluarga_id').trigger('change');
                }
            }

            function updateIbuAndBalita() {
                var kartuKeluargaId = $('#kartu_keluarga_id').val();
                if (kartuKeluargaId) {
                    $.ajax({
                        url: '{{ route("kartu_keluarga.get-ibu-balita", ":kartu_keluarga_id") }}'.replace(':kartu_keluarga_id', kartuKeluargaId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#ibu_id').empty().append('<option value="">Pilih Nama Ibu</option>');
                            if (data.ibus && data.ibus.length > 0) {
                                $.each(data.ibus, function(index, ibu) {
                                    var selected = ibu.id == {{ old('ibu_id') ?? 'null' }} ? 'selected' : '';
                                    $('#ibu_id').append('<option value="' + ibu.id + '" ' + selected + '>' + ibu.nama + '</option>');
                                });
                            } else {
                                $('#ibu_id').append('<option value="" disabled>Tidak ada data ibu</option>');
                            }

                            $('#balita_id').empty().append('<option value="">Pilih Nama Balita</option>');
                            if (data.balitas && data.balitas.length > 0) {
                                $.each(data.balitas, function(index, balita) {
                                    var selected = balita.id == {{ old('balita_id') ?? 'null' }} ? 'selected' : '';
                                    $('#balita_id').append('<option value="' + balita.id + '" ' + selected + '>' + balita.nama + '</option>');
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
                                confirmButtonColor: '#3b82f6',
                            });
                        }
                    });
                } else {
                    $('#ibu_id').empty().append('<option value="">Pilih Nama Ibu</option>');
                    $('#balita_id').empty().append('<option value="">Pilih Nama Balita</option>');
                    $('#ibu_id').trigger('change');
                    $('#balita_id').trigger('change');
                }
            }
        });
    </script>
</body>
</html>