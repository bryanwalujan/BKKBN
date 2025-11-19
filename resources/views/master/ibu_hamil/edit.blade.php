<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Ibu Hamil - Master Panel</title>
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
            z-index: 10;
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
                            Edit Data Ibu Hamil
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui data kehamilan ibu dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('ibu_hamil.index') }}" 
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
                        <p class="text-red-700 mt-1">{{ session('error') }}</p>
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
                        <p class="text-green-800 font-medium">Sukses:</p>
                        <p class="text-green-700 mt-1">{{ session('success') }}</p>
                    </div>
                    <button class="ml-auto text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <form action="{{ route('ibu_hamil.update', $ibuHamil->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Informasi Ibu -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user text-pink-500 mr-2"></i>
                            Informasi Ibu
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih atau ubah data ibu</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="ibu_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user-circle text-blue-500 mr-2 text-xs"></i>
                                    Nama Ibu
                                </label>
                                <div class="input-with-icon">
                                    <select name="ibu_id" id="ibu_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Ibu --</option>
                                        @foreach ($ibus as $ibu)
                                            <option value="{{ $ibu->id }}" {{ $ibuHamil->ibu_id == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})</option>
                                        @endforeach
                                    </select>
                                    <div class="icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                @error('ibu_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kehamilan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-baby text-purple-500 mr-2"></i>
                            Informasi Kehamilan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui detail kehamilan ibu</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="trimester" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-green-500 mr-2 text-xs"></i>
                                    Trimester
                                </label>
                                <div class="input-with-icon">
                                    <select name="trimester" id="trimester" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Trimester --</option>
                                        <option value="Trimester 1" {{ $ibuHamil->trimester == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                                        <option value="Trimester 2" {{ $ibuHamil->trimester == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                                        <option value="Trimester 3" {{ $ibuHamil->trimester == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                                    </select>
                                    <div class="icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                @error('trimester')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="usia_kehamilan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-clock text-yellow-500 mr-2 text-xs"></i>
                                    Usia Kehamilan (minggu)
                                </label>
                                <div class="input-with-icon">
                                    <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ $ibuHamil->usia_kehamilan }}" min="0" max="40" step="1" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <div class="icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                @error('usia_kehamilan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Kesehatan Ibu -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                            Data Kesehatan Ibu
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data kesehatan dan pengukuran ibu</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <label for="berat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-weight-scale text-blue-500 mr-2 text-xs"></i>
                                    Berat (kg)
                                </label>
                                <div class="input-with-icon">
                                    <input type="number" name="berat" id="berat" value="{{ $ibuHamil->berat }}" step="0.1" min="0" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <div class="icon">
                                        <i class="fas fa-weight"></i>
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
                                <div class="input-with-icon">
                                    <input type="number" name="tinggi" id="tinggi" value="{{ $ibuHamil->tinggi }}" step="0.1" min="0" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <div class="icon">
                                        <i class="fas fa-ruler"></i>
                                    </div>
                                </div>
                                @error('tinggi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="imt" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calculator text-purple-500 mr-2 text-xs"></i>
                                    Indeks Masa Tubuh (IMT)
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" name="imt" id="imt" value="{{ $ibuHamil->imt }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                    <div class="icon">
                                        <i class="fas fa-calculator"></i>
                                    </div>
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
                                    Kadar HB
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" name="kadar_hb" id="kadar_hb" value="{{ $ibuHamil->kadar_hb }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                    <div class="icon">
                                        <i class="fas fa-tint"></i>
                                    </div>
                                </div>
                                @error('kadar_hb')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tinggi_fundus_uteri" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-ruler-combined text-yellow-500 mr-2 text-xs"></i>
                                    Tinggi Fundus Uteri (cm)
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" name="tinggi_fundus_uteri" id="tinggi_fundus_uteri" value="{{ $ibuHamil->tinggi_fundus_uteri }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                    <div class="icon">
                                        <i class="fas fa-ruler"></i>
                                    </div>
                                </div>
                                @error('tinggi_fundus_uteri')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-circle text-indigo-500 mr-2 text-xs"></i>
                                    Lingkar Kepala (cm)
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" name="lingkar_kepala" id="lingkar_kepala" value="{{ $ibuHamil->lingkar_kepala }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                    <div class="icon">
                                        <i class="fas fa-circle"></i>
                                    </div>
                                </div>
                                @error('lingkar_kepala')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Janin -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-baby text-blue-500 mr-2"></i>
                            Data Janin
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data perkembangan janin</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="taksiran_berat_janin" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-weight text-green-500 mr-2 text-xs"></i>
                                    Taksiran Berat Janin (gr)
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" name="taksiran_berat_janin" id="taksiran_berat_janin" value="{{ $ibuHamil->taksiran_berat_janin }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                    <div class="icon">
                                        <i class="fas fa-weight"></i>
                                    </div>
                                </div>
                                @error('taksiran_berat_janin')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-file-medical text-red-500 mr-2 text-xs"></i>
                                    Riwayat Penyakit
                                </label>
                                <div class="input-with-icon">
                                    <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" value="{{ $ibuHamil->riwayat_penyakit }}" maxlength="255" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                    <div class="icon">
                                        <i class="fas fa-file-medical"></i>
                                    </div>
                                </div>
                                @error('riwayat_penyakit')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status dan Intervensi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                            Status dan Intervensi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui status gizi dan intervensi yang diperlukan</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="status_gizi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-apple-whole text-green-500 mr-2 text-xs"></i>
                                    Status Gizi
                                </label>
                                <div class="input-with-icon">
                                    <select name="status_gizi" id="status_gizi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Status Gizi --</option>
                                        <option value="Normal" {{ $ibuHamil->status_gizi == 'Normal' ? 'selected' : '' }}>Normal</option>
                                        <option value="Kurang Gizi" {{ $ibuHamil->status_gizi == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                        <option value="Berisiko" {{ $ibuHamil->status_gizi == 'Berisiko' ? 'selected' : '' }}>Berisiko</option>
                                    </select>
                                    <div class="icon">
                                        <i class="fas fa-apple-whole"></i>
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
                                <label for="warna_status_gizi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-palette text-purple-500 mr-2 text-xs"></i>
                                    Warna Status Gizi
                                </label>
                                <div class="input-with-icon">
                                    <select name="warna_status_gizi" id="warna_status_gizi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Warna --</option>
                                        <option value="Sehat" {{ $ibuHamil->warna_status_gizi == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                        <option value="Waspada" {{ $ibuHamil->warna_status_gizi == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                        <option value="Bahaya" {{ $ibuHamil->warna_status_gizi == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                                    </select>
                                    <div class="icon">
                                        <i class="fas fa-palette"></i>
                                    </div>
                                </div>
                                @error('warna_status_gizi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="intervensi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-hands-helping text-blue-500 mr-2 text-xs"></i>
                                    Intervensi
                                </label>
                                <div class="input-with-icon">
                                    <select name="intervensi" id="intervensi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                        <option value="">-- Pilih Intervensi --</option>
                                        <option value="Tidak Ada" {{ $ibuHamil->intervensi == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                        <option value="Gizi" {{ $ibuHamil->intervensi == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                                        <option value="Konsultasi Medis" {{ $ibuHamil->intervensi == 'Konsultasi Medis' ? 'selected' : '' }}>Konsultasi Medis</option>
                                        <option value="Lainnya" {{ $ibuHamil->intervensi == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    <div class="icon">
                                        <i class="fas fa-hands-helping"></i>
                                    </div>
                                </div>
                                @error('intervensi')
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
                    <a href="{{ route('ibu_hamil.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Data Ibu Hamil
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

            $('#trimester').select2({
                placeholder: 'Pilih Trimester',
                allowClear: true
            });

            $('#status_gizi').select2({
                placeholder: 'Pilih Status Gizi',
                allowClear: true
            });

            $('#warna_status_gizi').select2({
                placeholder: 'Pilih Warna Status',
                allowClear: true
            });

            $('#intervensi').select2({
                placeholder: 'Pilih Intervensi',
                allowClear: true
            });
        });
    </script>
</body>
</html>