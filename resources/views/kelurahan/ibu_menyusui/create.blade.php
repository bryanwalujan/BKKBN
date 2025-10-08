<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Ibu Menyusui - Panel Kelurahan</title>
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
            border-bottom: 1px solid #bbf7d0;
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
        .status-badge.success {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-badge.warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-badge.danger {
            background-color: #fee2e2;
            color: #991b1b;
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
                            <i class="fas fa-female text-green-500 mr-3"></i>
                            Tambah Data Ibu Menyusui
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data ibu menyusui baru ke dalam sistem kelurahan</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kelurahan.ibu_menyusui.index') }}" 
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
            <!-- Alert Notifications -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">Terjadi Kesalahan:</p>
                        <p class="text-red-700 mt-1">{{ session('error') }}</p>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
            
            @if (session('warning'))
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-yellow-800 font-medium">Peringatan:</p>
                        <p class="text-yellow-700 mt-1">{{ session('warning') }}</p>
                    </div>
                    <button class="ml-auto text-yellow-600 hover:text-yellow-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3 mt-0.5"></i>
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

            <form action="{{ route('kelurahan.ibu_menyusui.store') }}" method="POST">
                @csrf
                
                <!-- Informasi Ibu -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user text-green-500 mr-2"></i>
                            Informasi Ibu
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih data ibu yang akan ditambahkan ke dalam sistem ibu menyusui</p>
                    </div>
                    <div class="form-section-body">
                        <div>
                            <label for="ibu_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-user-friends text-green-500 mr-2 text-xs"></i>
                                Nama Ibu
                            </label>
                            <select name="ibu_id" id="ibu_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3" required>
                                <option value="">-- Pilih Ibu --</option>
                                @foreach ($ibus as $ibu)
                                    <option value="{{ $ibu->id }}" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})</option>
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

                <!-- Status Menyusui -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-baby text-purple-500 mr-2"></i>
                            Status Menyusui
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Tentukan status dan frekuensi menyusui</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status_menyusui" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-2 text-xs"></i>
                                    Status Menyusui
                                </label>
                                <div class="relative">
                                    <select name="status_menyusui" id="status_menyusui" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Eksklusif" {{ old('status_menyusui') == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                                        <option value="Non-Eksklusif" {{ old('status_menyusui') == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status_menyusui')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="frekuensi_menyusui" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-clock text-yellow-500 mr-2 text-xs"></i>
                                    Frekuensi Menyusui (kali/hari)
                                </label>
                                <div class="relative">
                                    <input type="number" name="frekuensi_menyusui" id="frekuensi_menyusui" value="{{ old('frekuensi_menyusui') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
                                           min="0" max="24" placeholder="0" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-sync-alt text-gray-400"></i>
                                    </div>
                                </div>
                                @error('frekuensi_menyusui')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kondisi Ibu -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-heartbeat text-red-500 mr-2"></i>
                            Kondisi Ibu
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan informasi kondisi kesehatan ibu</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kondisi_ibu" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-stethoscope text-blue-500 mr-2 text-xs"></i>
                                    Kondisi Ibu
                                </label>
                                <div class="relative">
                                    <input type="text" name="kondisi_ibu" id="kondisi_ibu" value="{{ old('kondisi_ibu') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
                                           placeholder="Masukkan kondisi kesehatan ibu" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-heart text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kondisi_ibu')
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
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Warna --</option>
                                        <option value="Hijau (success)" {{ old('warna_kondisi') == 'Hijau (success)' ? 'selected' : '' }}>
                                            Hijau (Kondisi Baik)
                                        </option>
                                        <option value="Kuning (warning)" {{ old('warna_kondisi') == 'Kuning (warning)' ? 'selected' : '' }}>
                                            Kuning (Perlu Perhatian)
                                        </option>
                                        <option value="Merah (danger)" {{ old('warna_kondisi') == 'Merah (danger)' ? 'selected' : '' }}>
                                            Merah (Kondisi Darurat)
                                        </option>
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
                        </div>
                    </div>
                </div>

                <!-- Data Pengukuran Fisik -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-ruler-combined text-orange-500 mr-2"></i>
                            Data Pengukuran Fisik
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan data pengukuran fisik ibu</p>
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
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
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
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 pl-10"
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

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('kelurahan.ibu_menyusui.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Ibu Menyusui
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

            // Validasi sisi klien untuk frekuensi menyusui
            $('#frekuensi_menyusui').on('input', function() {
                if (this.value < 0) this.value = 0;
                if (this.value > 24) this.value = 24;
            });
            
            // Validasi untuk berat dan tinggi
            $('#berat, #tinggi').on('input', function() {
                if (this.value < 0) this.value = 0;
            });
        });
    </script>
</body>
</html>