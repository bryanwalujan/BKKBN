<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Ibu Hamil - Panel Kelurahan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
                            <i class="fas fa-person-pregnant text-pink-600 mr-3"></i>
                            Tambah Data Ibu Hamil
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data ibu hamil baru ke dalam sistem kelurahan</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kelurahan.ibu_hamil.index') }}" 
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

            @if ($ibus->isEmpty())
                <div class="form-section">
                    <div class="p-6 text-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Data Ibu Hamil</h3>
                        <p class="text-gray-600 mb-4">Tidak ada data ibu dengan status Hamil. Silakan tambahkan data ibu terlebih dahulu.</p>
                        <a href="{{ route('kelurahan.ibu.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Data Ibu
                        </a>
                    </div>
                </div>
            @else
                <form id="createIbuHamilForm" action="{{ route('kelurahan.ibu_hamil.store') }}" method="POST">
                    @csrf
                    
                    <!-- Informasi Ibu -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-user text-pink-500 mr-2"></i>
                                Informasi Ibu
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Pilih data ibu yang akan ditambahkan kehamilannya</p>
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
                                                <option value="{{ $ibu->id }}" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})</option>
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
                            <p class="text-sm text-gray-600 mt-1">Masukkan detail kehamilan ibu</p>
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
                                            <option value="" {{ old('trimester') == '' ? 'selected' : '' }}>-- Pilih Trimester --</option>
                                            <option value="Trimester 1" {{ old('trimester') == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                                            <option value="Trimester 2" {{ old('trimester') == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                                            <option value="Trimester 3" {{ old('trimester') == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
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
                                        <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ old('usia_kehamilan') }}" min="0" max="40" step="1" 
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
                            <p class="text-sm text-gray-600 mt-1">Masukkan data kesehatan dan pengukuran ibu</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="berat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-weight-scale text-blue-500 mr-2 text-xs"></i>
                                        Berat (kg)
                                    </label>
                                    <div class="input-with-icon">
                                        <input type="number" name="berat" id="berat" value="{{ old('berat') }}" step="0.1" min="0" 
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
                                        <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" step="0.1" min="0" 
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
                            <p class="text-sm text-gray-600 mt-1">Tentukan status gizi dan intervensi yang diperlukan</p>
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
                                            <option value="" {{ old('status_gizi') == '' ? 'selected' : '' }}>-- Pilih Status Gizi --</option>
                                            <option value="Normal" {{ old('status_gizi') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                            <option value="Berisiko" {{ old('status_gizi') == 'Berisiko' ? 'selected' : '' }}>Berisiko</option>
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
                                            <option value="" {{ old('warna_status_gizi') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                                            <option value="Sehat" {{ old('warna_status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                            <option value="Waspada" {{ old('warna_status_gizi') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                            <option value="Bahaya" {{ old('warna_status_gizi') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
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
                                            <option value="" {{ old('intervensi') == '' ? 'selected' : '' }}>-- Pilih Intervensi --</option>
                                            <option value="Tidak Ada" {{ old('intervensi') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            <option value="Gizi" {{ old('intervensi') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                                            <option value="Konsultasi Medis" {{ old('intervensi') == 'Konsultasi Medis' ? 'selected' : '' }}>Konsultasi Medis</option>
                                            <option value="Lainnya" {{ old('intervensi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                        <a href="{{ route('kelurahan.ibu_hamil.index') }}" 
                           class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                        <button type="submit" 
                                class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Data Ibu Hamil
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

            // SweetAlert2 confirmation for form submission
            $('#createIbuHamilForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                Swal.fire({
                    title: 'Simpan Data?',
                    text: 'Apakah Anda yakin ingin menyimpan data ibu hamil ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: new FormData(form[0]),
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data ibu hamil berhasil ditambahkan.',
                                    confirmButtonColor: '#3b82f6',
                                }).then(() => {
                                    window.location.href = '{{ route("kelurahan.ibu_hamil.index") }}';
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menambahkan data.';
                                if (xhr.status === 419) {
                                    message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                } else if (xhr.status === 403) {
                                    message = 'Anda tidak memiliki izin untuk menambahkan data ini.';
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: message,
                                    confirmButtonColor: '#3b82f6',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>