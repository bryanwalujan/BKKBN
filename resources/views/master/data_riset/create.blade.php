<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Riset - Master Panel</title>
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
                            <i class="fas fa-chart-line text-purple-600 mr-3"></i>
                            Tambah Data Riset
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data riset baru ke dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('data_riset.index') }}" 
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

            <form action="{{ route('data_riset.store') }}" method="POST">
                @csrf
                
                <!-- Informasi Judul Riset -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-heading text-purple-500 mr-2"></i>
                            Informasi Judul Riset
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih atau masukkan judul riset yang sesuai</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-tag text-blue-500 mr-2 text-xs"></i>
                                    Judul Riset
                                </label>
                                <div class="relative">
                                    <select name="judul" id="judul" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            onchange="toggleJudulKustom()" required>
                                        <option value="" disabled selected>-- Pilih Judul --</option>
                                        @foreach ($realtimeJudul as $judul)
                                            <option value="{{ $judul }}">{{ $judul }}</option>
                                        @endforeach
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('judul')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div id="judul_kustom_div" class="hidden">
                                <label for="judul_kustom" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-pen text-green-500 mr-2 text-xs"></i>
                                    Judul Kustom
                                </label>
                                <div class="relative">
                                    <input type="text" name="judul_kustom" id="judul_kustom" value="{{ old('judul_kustom') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan judul riset kustom">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-edit text-gray-400"></i>
                                    </div>
                                </div>
                                @error('judul_kustom')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Numerik -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                            Data Numerik
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan data numerik untuk riset</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="angka" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-hashtag text-green-500 mr-2 text-xs"></i>
                                    Angka
                                </label>
                                <div class="relative">
                                    <input type="number" name="angka" id="angka" value="{{ old('angka') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           min="0" placeholder="0" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calculator text-gray-400"></i>
                                    </div>
                                </div>
                                @error('angka')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-2 flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                    Angka akan diisi otomatis untuk judul realtime.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('data_riset.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Riset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        function toggleJudulKustom() {
            const judulSelect = document.getElementById('judul');
            const judulKustomDiv = document.getElementById('judul_kustom_div');
            const angkaInput = document.getElementById('angka');
            
            if (judulSelect.value === 'Lainnya') {
                judulKustomDiv.classList.remove('hidden');
                angkaInput.disabled = false;
            } else {
                judulKustomDiv.classList.add('hidden');
                angkaInput.disabled = judulSelect.value !== '';
            }
        }

        // Inisialisasi status form berdasarkan nilai awal
        document.addEventListener('DOMContentLoaded', function() {
            toggleJudulKustom();
            
            // Set nilai awal jika ada data lama
            const initialJudul = '{{ old("judul") }}';
            if (initialJudul) {
                document.getElementById('judul').value = initialJudul;
                toggleJudulKustom();
            }
        });
    </script>
</body>
</html>