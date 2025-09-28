<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Ibu - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .card-hover {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #ec4899;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #ec4899, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
        }
        
        .form-input:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
            outline: none;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: #ec4899;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #db2777;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(236, 72, 153, 0.3);
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
        }
        
        .btn-outline:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }
        
        .info-box {
            background-color: #fdf2f8;
            border-left: 4px solid #ec4899;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        
        .info-box p {
            margin: 0;
            color: #831843;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 46px;
            padding: 0.75rem;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
            outline: none;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        
        .file-input-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-input-container input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .file-input-label:hover {
            border-color: #ec4899;
            background-color: #fdf2f8;
        }
        
        .file-input-label.has-file {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-hamil {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-nifas {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-menyusui {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-tidak-aktif {
            background-color: #f3f4f6;
            color: #374151;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Data Ibu</span></h1>
                    <p class="text-gray-600">Tambah data ibu baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('ibu.index') }}" class="text-pink-500 hover:text-pink-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Ibu
                    </a>
                </div>
            </div>
        </div>
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            </div>
        @endif
        
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Form Data Ibu</h3>
                    <p class="text-gray-600 text-sm mt-1">Isi informasi data ibu dengan lengkap dan benar</p>
                </div>
                <div class="flex items-center text-sm text-pink-500">
                    <i class="fas fa-user mr-2"></i>
                    <span>Data Ibu</span>
                </div>
            </div>
            
            <form action="{{ route('ibu.store') }}" method="POST" enctype="multipart/form-data" id="ibuForm">
                @csrf
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan sudah sesuai dengan dokumen yang valid.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <div>
                            <label for="kecamatan_id" class="form-label">
                                <i class="fas fa-map-marker-alt mr-1 text-pink-500"></i> Kecamatan
                            </label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-input" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="kelurahan_id" class="form-label">
                                <i class="fas fa-map-marker mr-1 text-pink-500"></i> Kelurahan
                            </label>
                            <select name="kelurahan_id" id="kelurahan_id" class="form-input" required>
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>
                            @error('kelurahan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="kartu_keluarga_id" class="form-label">
                                <i class="fas fa-address-card mr-1 text-pink-500"></i> Kartu Keluarga
                            </label>
                            <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="form-input" required>
                                <option value="">-- Pilih Kartu Keluarga --</option>
                            </select>
                            @error('kartu_keluarga_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="nik" class="form-label">
                                <i class="fas fa-id-card mr-1 text-pink-500"></i> NIK
                            </label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="form-input" placeholder="Masukkan NIK">
                            @error('nik')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <div>
                            <label for="nama" class="form-label">
                                <i class="fas fa-user mr-1 text-pink-500"></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-input" placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="alamat" class="form-label">
                                <i class="fas fa-home mr-1 text-pink-500"></i> Alamat Lengkap
                            </label>
                            <textarea name="alamat" id="alamat" class="form-input" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="status" class="form-label">
                                <i class="fas fa-toggle-on mr-1 text-pink-500"></i> Status
                            </label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="" {{ old('status') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                                <option value="Hamil" {{ old('status') == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                                <option value="Nifas" {{ old('status') == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                                <option value="Menyusui" {{ old('status') == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="foto" class="form-label">
                                <i class="fas fa-camera mr-1 text-pink-500"></i> Foto
                            </label>
                            <div class="file-input-container">
                                <input type="file" name="foto" id="foto" class="form-input" accept="image/*">
                                <label for="foto" class="file-input-label" id="fileInputLabel">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Pilih file foto atau seret ke sini</span>
                                </label>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</div>
                            @error('foto')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('ibu.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 with custom styling
            $('#kecamatan_id').select2({
                placeholder: '-- Pilih Kecamatan --',
                allowClear: true,
                width: '100%'
            });
            
            $('#kelurahan_id').select2({
                placeholder: '-- Pilih Kelurahan --',
                allowClear: true,
                width: '100%'
            });
            
            $('#kartu_keluarga_id').select2({
                placeholder: '-- Pilih Kartu Keluarga --',
                allowClear: true,
                width: '100%'
            });
            
            $('#status').select2({
                placeholder: '-- Pilih Status --',
                allowClear: false,
                width: '100%',
                templateResult: formatStatus,
                templateSelection: formatStatus
            });

            // Format status dengan badge berwarna
            function formatStatus(state) {
                if (!state.id) {
                    return state.text;
                }
                
                var statusClass = '';
                if (state.id === 'Hamil') {
                    statusClass = 'status-hamil';
                } else if (state.id === 'Nifas') {
                    statusClass = 'status-nifas';
                } else if (state.id === 'Menyusui') {
                    statusClass = 'status-menyusui';
                } else if (state.id === 'Tidak Aktif') {
                    statusClass = 'status-tidak-aktif';
                }
                
                if (statusClass) {
                    return $('<span class="status-badge ' + statusClass + '">' + state.text + '</span>');
                }
                
                return state.text;
            }

            // Fetch kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().trigger('change');
                $('#kartu_keluarga_id').empty().trigger('change');

                if (kecamatanId) {
                    // Tampilkan loading state
                    $('#kelurahan_id').html('<option value="">Memuat data kelurahan...</option>').trigger('change');
                    
                    $.ajax({
                        url: '/kelurahans/by-kecamatan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>').trigger('change');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kelurahan:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#ec4899'
                            });
                        }
                    });
                }
            });

            // Fetch kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $(this).val();
                $('#kartu_keluarga_id').empty().trigger('change');

                if (kecamatanId && kelurahanId) {
                    // Tampilkan loading state
                    $('#kartu_keluarga_id').html('<option value="">Memuat data kartu keluarga...</option>').trigger('change');
                    
                    $.ajax({
                        url: '/kartu-keluarga/by-kecamatan-kelurahan?kecamatan_id=' + kecamatanId + '&kelurahan_id=' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>').trigger('change');
                            
                            if (data.length === 0) {
                                $('#kartu_keluarga_id').append('<option value="" disabled>Tidak ada data Kartu Keluarga</option>').trigger('change');
                                
                                // Tampilkan pesan dengan link untuk menambah KK
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Data Tidak Ditemukan',
                                    html: 'Tidak ada data Kartu Keluarga untuk kecamatan dan kelurahan yang dipilih. <a href="{{ route('kartu_keluarga.create') }}" class="text-pink-500 hover:underline">Tambah Kartu Keluarga</a> terlebih dahulu.',
                                    confirmButtonColor: '#ec4899'
                                });
                            } else {
                                $.each(data, function(index, kk) {
                                    $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                                });
                            }
                            $('#kartu_keluarga_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kartu keluarga:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data kartu keluarga. Silakan coba lagi.',
                                confirmButtonColor: '#ec4899'
                            });
                        }
                    });
                }
            });

            // Handle file input change
            $('#foto').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $('#fileInputLabel').addClass('has-file').html('<i class="fas fa-check-circle text-green-500"></i> ' + fileName);
                } else {
                    $('#fileInputLabel').removeClass('has-file').html('<i class="fas fa-cloud-upload-alt"></i> Pilih file foto atau seret ke sini');
                }
            });

            // Form validation sebelum submit
            $('#ibuForm').on('submit', function(e) {
                var isValid = true;
                var errorFields = [];
                
                // Validasi field required
                $('[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        errorFields.push($(this).attr('name'));
                        $(this).addClass('border-red-500');
                    } else {
                        $(this).removeClass('border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Form Tidak Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi.',
                        confirmButtonColor: '#ec4899'
                    });
                    
                    // Scroll ke field pertama yang error
                    if (errorFields.length > 0) {
                        $('[name="' + errorFields[0] + '"]').focus();
                    }
                }
            });

            // Restore old values if available
            @if(old('kelurahan_id'))
                $('#kelurahan_id').val('{{ old('kelurahan_id') }}').trigger('change');
            @endif
            
            @if(old('kartu_keluarga_id'))
                setTimeout(function() {
                    $('#kartu_keluarga_id').val('{{ old('kartu_keluarga_id') }}').trigger('change');
                }, 500);
            @endif
            
            @if(old('status'))
                $('#status').val('{{ old('status') }}').trigger('change');
            @endif
        });
    </script>
</body>
</html>