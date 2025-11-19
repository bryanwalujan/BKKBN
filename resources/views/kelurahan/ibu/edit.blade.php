<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Ibu - Panel Kelurahan</title>
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
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .photo-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
                            <i class="fas fa-edit text-purple-600 mr-3"></i>
                            Edit Data Ibu
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui data ibu dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kelurahan.ibu.index') }}" 
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

            @if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan)
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">
                            {{ $kartuKeluargas->isEmpty() ? 'Tidak ada data Kartu Keluarga yang terverifikasi. ' : '' }}
                            {{ !$kecamatan || !$kelurahan ? 'Data kecamatan atau kelurahan tidak ditemukan. ' : '' }}
                            Silakan tambahkan data terlebih dahulu.
                        </p>
                    </div>
                </div>
            @else
                <form id="editIbuForm" action="{{ route('kelurahan.ibu.update', $ibu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Informasi Lokasi -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                Informasi Lokasi
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Lokasi tempat tinggal ibu</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-map text-blue-500 mr-2 text-xs"></i>
                                        Kecamatan
                                    </label>
                                    <div class="relative">
                                        <input type="text" value="{{ $kecamatan->nama_kecamatan }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10 bg-gray-50" 
                                               readonly>
                                        <div class="input-icon">
                                            <i class="fas fa-city"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id }}">
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
                                    <div class="relative">
                                        <input type="text" value="{{ $kelurahan->nama_kelurahan }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10 bg-gray-50" 
                                               readonly>
                                        <div class="input-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" name="kelurahan_id" value="{{ $kelurahan->id }}">
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
                                <select name="kartu_keluarga_id" id="kartu_keluarga_id" 
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" 
                                        required>
                                    <option value="">-- Pilih Kartu Keluarga --</option>
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

                    <!-- Informasi Pribadi Ibu -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-user text-pink-500 mr-2"></i>
                                Informasi Pribadi Ibu
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Perbarui data pribadi ibu</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-address-card text-blue-500 mr-2 text-xs"></i>
                                        NIK
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="nik" id="nik" value="{{ old('nik', $ibu->nik) }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               pattern="[0-9]{16}" inputmode="numeric" maxlength="16" 
                                               title="NIK harus terdiri dari 16 digit angka" 
                                               placeholder="Masukkan 16 digit NIK">
                                        <div class="input-icon">
                                            <i class="fas fa-id-card"></i>
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
                                        <input type="text" name="nama" id="nama" value="{{ old('nama', $ibu->nama) }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               placeholder="Masukkan nama lengkap ibu" required>
                                        <div class="input-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    @error('nama')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Keluarga -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-home text-indigo-500 mr-2"></i>
                                Informasi Keluarga
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Perbarui informasi keluarga ibu</p>
                        </div>
                        <div class="form-section-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-home text-blue-500 mr-2 text-xs"></i>
                                        Alamat Lengkap
                                    </label>
                                    <textarea name="alamat" id="alamat" rows="3"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                              placeholder="Masukkan alamat lengkap ibu">{{ old('alamat', $ibu->alamat) }}</textarea>
                                    @error('alamat')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-heart text-red-500 mr-2 text-xs"></i>
                                        Status
                                    </label>
                                    <div class="relative">
                                        <select name="status" id="status" 
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                                required>
                                            <option value="">-- Pilih Status --</option>
                                            <option value="Hamil" {{ old('status', $ibu->status) == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                                            <option value="Nifas" {{ old('status', $ibu->status) == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                                            <option value="Menyusui" {{ old('status', $ibu->status) == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                                            <option value="Tidak Aktif" {{ old('status', $ibu->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
                        </div>
                    </div>

                    <!-- Informasi Foto -->
                    <div class="form-section card-hover">
                        <div class="form-section-header">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-camera text-green-500 mr-2"></i>
                                Foto Ibu
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Perbarui foto ibu</p>
                        </div>
                        <div class="form-section-body">
                            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                                <div class="photo-preview">
                                    @if ($ibu->foto)
                                        <img id="currentPhoto" src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu">
                                    @else
                                        <div id="noPhoto" class="text-gray-400 flex flex-col items-center">
                                            <i class="fas fa-user text-4xl mb-2"></i>
                                            <span class="text-sm">Tidak ada foto</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-upload text-blue-500 mr-2 text-xs"></i>
                                        Unggah Foto Baru
                                    </label>
                                    <input type="file" name="foto" id="foto" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           accept="image/*">
                                    <p class="text-sm text-gray-500 mt-2">Unggah foto baru untuk mengganti foto saat ini. Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                                    @error('foto')
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
                        <a href="{{ route('kelurahan.ibu.index') }}" 
                           class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                        <button type="submit" 
                                class="flex items-center px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition-colors card-hover">
                            <i class="fas fa-save mr-2"></i>
                            Perbarui Data Ibu
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

            $('#status').select2({
                placeholder: 'Pilih Status',
                allowClear: true
            });

            // Load kartu keluarga
            $.ajax({
                url: '{{ route('kelurahan.ibu.getKartuKeluarga') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>');
                    if (data.length === 0) {
                        $('#kartu_keluarga_id').after('<p class="text-red-600 text-sm mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>Tidak ada data Kartu Keluarga yang terverifikasi. <a href="{{ route('kelurahan.kartu_keluarga.create') }}" class="text-blue-600 hover:underline ml-1">Tambah Kartu Keluarga</a> terlebih dahulu.</p>');
                    }
                    $.each(data, function(index, kk) {
                        var selected = kk.id == '{{ old('kartu_keluarga_id', $ibu->kartu_keluarga_id) }}' ? 'selected' : '';
                        $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                    });
                    $('#kartu_keluarga_id').trigger('change');
                },
                error: function(xhr) {
                    console.error('Gagal mengambil data kartu keluarga:', xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                        confirmButtonColor: '#3b82f6',
                    });
                }
            });

            // Validasi input hanya angka untuk NIK
            $('#nik').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Preview foto baru
            $('#foto').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Hapus foto lama atau placeholder
                        $('#currentPhoto').remove();
                        $('#noPhoto').remove();
                        
                        // Tambahkan foto baru
                        $('.photo-preview').html('<img id="currentPhoto" src="' + e.target.result + '" alt="Preview Foto">');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // SweetAlert2 confirmation for form submission
            $('#editIbuForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                Swal.fire({
                    title: 'Perbarui Data?',
                    text: 'Apakah Anda yakin ingin memperbarui data ibu ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#8b5cf6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Perbarui!',
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
                                    text: 'Data ibu berhasil diperbarui.',
                                    confirmButtonColor: '#8b5cf6',
                                }).then(() => {
                                    window.location.href = '{{ route("kelurahan.ibu.index") }}';
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal memperbarui data.';
                                if (xhr.status === 419) {
                                    message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                } else if (xhr.status === 403) {
                                    message = 'Anda tidak memiliki izin untuk memperbarui data ini.';
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: message,
                                    confirmButtonColor: '#8b5cf6',
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