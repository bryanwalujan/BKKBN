<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Bayi Baru Lahir - Kelurahan Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
            height: 48px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            right: 8px;
        }
        .input-with-icon {
            position: relative;
        }
        .input-with-icon input {
            padding-left: 2.5rem;
        }
        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
        }
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: #4b5563;
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
                            <i class="fas fa-baby text-green-600 mr-3"></i>
                            Tambah Data Bayi Baru Lahir
                        </h1>
                        <p class="text-gray-600 mt-1">Tambah data bayi baru lahir ke dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kelurahan.bayi_baru_lahir.index') }}" 
                           class="btn-secondary flex items-center">
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

            @if ($ibuNifas->isEmpty())
                <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-red-800 font-medium">Tidak ada data Ibu Nifas</h3>
                            <p class="text-red-700 mt-1">Silakan tambahkan <a href="{{ route('kelurahan.ibu_nifas.create') }}" class="text-blue-600 hover:underline font-medium">data ibu nifas</a> terlebih dahulu sebelum menambahkan data bayi baru lahir.</p>
                        </div>
                    </div>
                </div>
            @else
                <form id="createBayiBaruLahirForm" action="{{ route('kelurahan.bayi_baru_lahir.store') }}" method="POST">
                    @csrf
                    
                    <!-- Informasi Ibu Nifas -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-female text-pink-500 mr-2"></i>
                                Informasi Ibu Nifas
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Pilih data ibu nifas yang melahirkan bayi</p>
                        </div>
                        <div class="form-section-body">
                            <div class="mb-4">
                                <label for="ibu_nifas_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user text-blue-500 mr-2 text-xs"></i>
                                    Nama Ibu Nifas
                                </label>
                                <div class="relative">
                                    <select name="ibu_nifas_id" id="ibu_nifas_id" class="w-full" required>
                                        <option value="">-- Pilih Ibu Nifas --</option>
                                        @foreach ($ibuNifas as $ibu)
                                            <option value="{{ $ibu->id }}" {{ old('ibu_nifas_id') == $ibu->id ? 'selected' : '' }}>
                                                {{ $ibu->ibu->nama }} ({{ $ibu->ibu->nik ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('ibu_nifas_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Bayi -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-baby text-green-500 mr-2"></i>
                                Informasi Bayi Baru Lahir
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Masukkan data bayi yang baru lahir</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="umur_dalam_kandungan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-calendar-alt text-purple-500 mr-2 text-xs"></i>
                                        Umur Dalam Kandungan
                                    </label>
                                    <div class="input-with-icon">
                                        <input type="text" name="umur_dalam_kandungan" id="umur_dalam_kandungan" value="{{ old('umur_dalam_kandungan') }}" maxlength="255" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                               placeholder="Contoh: 9 bulan">
                                        <div class="input-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    @error('umur_dalam_kandungan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="berat_badan_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-weight text-yellow-500 mr-2 text-xs"></i>
                                        Berat Badan Lahir (kg)
                                    </label>
                                    <div class="input-with-icon">
                                        <input type="text" name="berat_badan_lahir" id="berat_badan_lahir" value="{{ old('berat_badan_lahir') }}" maxlength="255" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                               placeholder="Contoh: 3.2">
                                        <div class="input-icon">
                                            <i class="fas fa-weight-hanging"></i>
                                        </div>
                                    </div>
                                    @error('berat_badan_lahir')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="panjang_badan_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-ruler-vertical text-blue-500 mr-2 text-xs"></i>
                                        Panjang Badan Lahir (cm)
                                    </label>
                                    <div class="input-with-icon">
                                        <input type="text" name="panjang_badan_lahir" id="panjang_badan_lahir" value="{{ old('panjang_badan_lahir') }}" maxlength="255" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                               placeholder="Contoh: 48">
                                        <div class="input-icon">
                                            <i class="fas fa-ruler"></i>
                                        </div>
                                    </div>
                                    @error('panjang_badan_lahir')
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
                        <a href="{{ route('kelurahan.bayi_baru_lahir.index') }}" 
                           class="btn-secondary flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                        <button type="submit" 
                                class="btn-primary flex items-center card-hover">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Data Bayi
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
            // Inisialisasi Select2
            $('#ibu_nifas_id').select2({
                placeholder: '-- Pilih Ibu Nifas --',
                allowClear: true,
                width: '100%'
            });

            // Form submission dengan SweetAlert
            $('#createBayiBaruLahirForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                
                Swal.fire({
                    title: 'Simpan Data Bayi?',
                    text: 'Apakah Anda yakin ingin menyimpan data bayi baru lahir ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-xl',
                        confirmButton: 'px-4 py-2 rounded-lg',
                        cancelButton: 'px-4 py-2 rounded-lg'
                    }
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
                                    text: 'Data bayi baru lahir berhasil ditambahkan.',
                                    confirmButtonColor: '#10b981',
                                    customClass: {
                                        popup: 'rounded-xl',
                                        confirmButton: 'px-4 py-2 rounded-lg'
                                    }
                                }).then(() => {
                                    window.location.href = '{{ route("kelurahan.bayi_baru_lahir.index") }}';
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menyimpan data.';
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
                                    confirmButtonColor: '#10b981',
                                    customClass: {
                                        popup: 'rounded-xl',
                                        confirmButton: 'px-4 py-2 rounded-lg'
                                    }
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