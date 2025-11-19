<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Aksi Konvergensi - Perangkat Daerah</title>

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
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
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
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
        }
        .checkbox-container input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            margin-right: 0.5rem;
            cursor: pointer;
        }
        .checkbox-container input[type="checkbox"]:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .intervensi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        @media (max-width: 768px) {
            .intervensi-grid {
                grid-template-columns: 1fr;
            }
        }
        .input-with-icon {
            position: relative;
        }
        .input-with-icon input, .input-with-icon select {
            padding-left: 2.5rem;
        }
        .input-with-icon .icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
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
                            <i class="fas fa-handshake text-blue-600 mr-3"></i>
                            Tambah Aksi Konvergensi
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah aksi konvergensi baru untuk penanganan stunting</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" 
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

            <form action="{{ route('perangkat_daerah.aksi_konvergensi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Informasi Lokasi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                            Informasi Lokasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Tentukan lokasi aksi konvergensi</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map text-blue-500 mr-2 text-xs"></i>
                                    Kecamatan
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-map-marker-alt icon"></i>
                                    <select name="kecamatan_id" id="kecamatan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($kecamatans as $kecamatan)
                                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                                <div class="input-with-icon">
                                    <i class="fas fa-map-pin icon"></i>
                                    <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Kelurahan --</option>
                                        @foreach ($kelurahans as $kelurahan)
                                            <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kelurahan_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-id-card text-purple-500 mr-2 text-xs"></i>
                                    Kartu Keluarga
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-address-card icon"></i>
                                    <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Kartu Keluarga --</option>
                                        @foreach ($kartuKeluargas as $kk)
                                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                                        @endforeach
                                    </select>
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

                <!-- Informasi Aksi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-tasks text-blue-500 mr-2"></i>
                            Informasi Aksi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan detail aksi konvergensi</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_aksi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-signature text-green-500 mr-2 text-xs"></i>
                                    Nama Aksi
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-tag icon"></i>
                                    <input type="text" name="nama_aksi" id="nama_aksi" value="{{ old('nama_aksi') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan nama aksi" required>
                                </div>
                                @error('nama_aksi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-purple-500 mr-2 text-xs"></i>
                                    Tahun
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar icon"></i>
                                    <input type="number" name="tahun" id="tahun" value="{{ old('tahun') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           min="2000" max="2050" placeholder="Tahun aksi" required>
                                </div>
                                @error('tahun')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="pelaku_aksi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-users text-yellow-500 mr-2 text-xs"></i>
                                    Pelaku Aksi
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user-friends icon"></i>
                                    <input type="text" name="pelaku_aksi" id="pelaku_aksi" value="{{ old('pelaku_aksi') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           placeholder="Masukkan pelaku aksi">
                                </div>
                                @error('pelaku_aksi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-clock text-red-500 mr-2 text-xs"></i>
                                    Waktu Pelaksanaan
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-calendar-day icon"></i>
                                    <input type="datetime-local" name="waktu_pelaksanaan" id="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                </div>
                                @error('waktu_pelaksanaan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="narasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-align-left text-indigo-500 mr-2 text-xs"></i>
                                    Narasi
                                </label>
                                <textarea name="narasi" id="narasi" rows="4"
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                          placeholder="Masukkan narasi aksi konvergensi">{{ old('narasi') }}</textarea>
                                @error('narasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Aksi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                            Status Aksi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Tentukan status aksi konvergensi</p>
                    </div>
                    <div class="form-section-body">
                        <div class="flex items-center">
                            <div class="checkbox-container">
                                <input type="checkbox" name="selesai" id="selesai" value="1" {{ old('selesai') ? 'checked' : '' }}>
                                <label for="selesai" class="text-sm font-medium text-gray-700 flex items-center">
                                    <i class="fas fa-check text-green-500 mr-1"></i>
                                    Aksi Selesai
                                </label>
                            </div>
                        </div>
                        @error('selesai')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Intervensi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                            Intervensi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih jenis intervensi yang dilakukan</p>
                    </div>
                    <div class="form-section-body">
                        <div class="intervensi-grid">
                            <!-- Intervensi Sensitif -->
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                                    <i class="fas fa-hand-holding-heart text-blue-500 mr-2"></i>
                                    Intervensi Sensitif
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="air_bersih_sanitasi" class="block text-sm font-medium text-gray-700 mb-2">Ketersediaan Air Bersih dan Sanitasi</label>
                                        <select name="air_bersih_sanitasi" id="air_bersih_sanitasi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada-baik" {{ old('air_bersih_sanitasi') == 'ada-baik' ? 'selected' : '' }}>Ada - Baik</option>
                                            <option value="ada-buruk" {{ old('air_bersih_sanitasi') == 'ada-buruk' ? 'selected' : '' }}>Ada - Buruk</option>
                                            <option value="tidak" {{ old('air_bersih_sanitasi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="akses_layanan_kesehatan_kb" class="block text-sm font-medium text-gray-700 mb-2">Akses Layanan Kesehatan dan KB</label>
                                        <select name="akses_layanan_kesehatan_kb" id="akses_layanan_kesehatan_kb" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('akses_layanan_kesehatan_kb') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('akses_layanan_kesehatan_kb') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="pendidikan_pengasuhan_ortu" class="block text-sm font-medium text-gray-700 mb-2">Pendidikan Pengasuhan Orang Tua</label>
                                        <select name="pendidikan_pengasuhan_ortu" id="pendidikan_pengasuhan_ortu" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('pendidikan_pengasuhan_ortu') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('pendidikan_pengasuhan_ortu') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="edukasi_kesehatan_remaja" class="block text-sm font-medium text-gray-700 mb-2">Edukasi Kesehatan Remaja</label>
                                        <select name="edukasi_kesehatan_remaja" id="edukasi_kesehatan_remaja" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('edukasi_kesehatan_remaja') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('edukasi_kesehatan_remaja') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="kesadaran_pengasuhan_gizi" class="block text-sm font-medium text-gray-700 mb-2">Kesadaran Pengasuhan dan Gizi</label>
                                        <select name="kesadaran_pengasuhan_gizi" id="kesadaran_pengasuhan_gizi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('kesadaran_pengasuhan_gizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('kesadaran_pengasuhan_gizi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="akses_pangan_bergizi" class="block text-sm font-medium text-gray-700 mb-2">Akses Pangan Bergizi</label>
                                        <select name="akses_pangan_bergizi" id="akses_pangan_bergizi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('akses_pangan_bergizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('akses_pangan_bergizi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi Spesifik -->
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                                    <i class="fas fa-stethoscope text-green-500 mr-2"></i>
                                    Intervensi Spesifik
                                </h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="makanan_ibu_hamil" class="block text-sm font-medium text-gray-700 mb-2">Makanan Ibu Hamil</label>
                                        <select name="makanan_ibu_hamil" id="makanan_ibu_hamil" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('makanan_ibu_hamil') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('makanan_ibu_hamil') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="tablet_tambah_darah" class="block text-sm font-medium text-gray-700 mb-2">Tablet Tambah Darah</label>
                                        <select name="tablet_tambah_darah" id="tablet_tambah_darah" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('tablet_tambah_darah') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('tablet_tambah_darah') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="inisiasi_menyusui_dini" class="block text-sm font-medium text-gray-700 mb-2">Inisiasi Menyusui Dini</label>
                                        <select name="inisiasi_menyusui_dini" id="inisiasi_menyusui_dini" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('inisiasi_menyusui_dini') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('inisiasi_menyusui_dini') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="asi_eksklusif" class="block text-sm font-medium text-gray-700 mb-2">ASI Eksklusif</label>
                                        <select name="asi_eksklusif" id="asi_eksklusif" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('asi_eksklusif') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('asi_eksklusif') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="asi_mpasi" class="block text-sm font-medium text-gray-700 mb-2">ASI & MPASI</label>
                                        <select name="asi_mpasi" id="asi_mpasi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('asi_mpasi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('asi_mpasi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="imunisasi_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Imunisasi Lengkap</label>
                                        <select name="imunisasi_lengkap" id="imunisasi_lengkap" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('imunisasi_lengkap') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('imunisasi_lengkap') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="pencegahan_infeksi" class="block text-sm font-medium text-gray-700 mb-2">Pencegahan Infeksi</label>
                                        <select name="pencegahan_infeksi" id="pencegahan_infeksi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="ada" {{ old('pencegahan_infeksi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old('pencegahan_infeksi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="status_gizi_ibu" class="block text-sm font-medium text-gray-700 mb-2">Status Gizi Ibu</label>
                                        <select name="status_gizi_ibu" id="status_gizi_ibu" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="baik" {{ old('status_gizi_ibu') == 'baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="buruk" {{ old('status_gizi_ibu') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="penyakit_menular" class="block text-sm font-medium text-gray-700 mb-2">Penyakit Menular</label>
                                        <select name="penyakit_menular" id="penyakit_menular" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="tidak" {{ old('penyakit_menular') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            <option value="ada" {{ old('penyakit_menular') == 'ada' ? 'selected' : '' }}>Ada</option>
                                        </select>
                                    </div>
                                    <div id="jenis_penyakit_container" class="{{ old('penyakit_menular') == 'ada' ? '' : 'hidden' }}">
                                        <label for="jenis_penyakit" class="block text-sm font-medium text-gray-700 mb-2">Jenis Penyakit</label>
                                        <input type="text" name="jenis_penyakit" id="jenis_penyakit" value="{{ old('jenis_penyakit') }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                               {{ old('penyakit_menular') == 'ada' ? 'required' : '' }}>
                                    </div>
                                    <div>
                                        <label for="kesehatan_lingkungan" class="block text-sm font-medium text-gray-700 mb-2">Kesehatan Lingkungan</label>
                                        <select name="kesehatan_lingkungan" id="kesehatan_lingkungan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2">
                                            <option value="">-- Pilih --</option>
                                            <option value="baik" {{ old('kesehatan_lingkungan') == 'baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="buruk" {{ old('kesehatan_lingkungan') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumentasi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-camera text-purple-500 mr-2"></i>
                            Dokumentasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Unggah foto dokumentasi aksi</p>
                    </div>
                    <div class="form-section-body">
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-image text-green-500 mr-2 text-xs"></i>
                                Foto (Maks. 7MB)
                            </label>
                            <input type="file" name="foto" id="foto" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                   accept="image/*">
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
                    <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Aksi Konvergensi
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

            // Load kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.aksi_konvergensi.getKelurahansByKecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $('#kelurahan_id').empty();
                            $('#kelurahan_id').append('<option value="">-- Pilih Kelurahan --</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6',
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">-- Pilih Kelurahan --</option>');
                    $('#kelurahan_id').trigger('change');
                }
                updateKartuKeluarga();
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            function updateKartuKeluarga() {
                var kelurahanId = $('#kelurahan_id').val();
                if (kelurahanId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.aksi_konvergensi.getKartuKeluargaByKelurahan", ":kelurahan_id") }}'.replace(':kelurahan_id', kelurahanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $('#kartu_keluarga_id').empty();
                            $('#kartu_keluarga_id').append('<option value="">-- Pilih Kartu Keluarga --</option>');
                            $.each(data, function(index, kk) {
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.error('Error fetching kartu keluarga:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6',
                            });
                        }
                    });
                } else {
                    $('#kartu_keluarga_id').empty();
                    $('#kartu_keluarga_id').append('<option value="">-- Pilih Kartu Keluarga --</option>');
                }
            }

            // Handle penyakit_menular change
            $('#penyakit_menular').on('change', function() {
                var jenisPenyakitContainer = $('#jenis_penyakit_container');
                var jenisPenyakitInput = $('#jenis_penyakit');
                if (this.value === 'ada') {
                    jenisPenyakitContainer.removeClass('hidden');
                    jenisPenyakitInput.prop('required', true);
                } else {
                    jenisPenyakitContainer.addClass('hidden');
                    jenisPenyakitInput.prop('required', false);
                    jenisPenyakitInput.val('');
                }
            });

            // Inisialisasi kelurahan jika ada data lama
            const initialKecamatanId = '{{ old("kecamatan_id") }}';
            if (initialKecamatanId) {
                $('#kecamatan_id').val(initialKecamatanId).trigger('change');
            }
        });
    </script>
</body>
</html>