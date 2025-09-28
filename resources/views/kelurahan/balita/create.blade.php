<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Balita - CSSR Kelurahan</title>
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
            border-left-color: #3b82f6;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #3b82f6, #10b981);
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
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
            background-color: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .info-box {
            background-color: #f0f9ff;
            border-left: 4px solid #0ea5e9;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        
        .info-box p {
            margin: 0;
            color: #0369a1;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
            border-radius: 3px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .select2-container--default .select2-selection--single {
            height: 46px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 46px;
            padding-left: 0;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .status-badge.sehat {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.stunting {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-badge.kurang-gizi {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-badge.obesitas {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .warna-label {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 0.5rem;
            vertical-align: middle;
        }
        
        .warna-label.sehat {
            background-color: #10b981;
        }
        
        .warna-label.waspada {
            background-color: #f59e0b;
        }
        
        .warna-label.bahaya {
            background-color: #ef4444;
        }
        
        .photo-preview {
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px dashed #d1d5db;
            display: none;
            margin-top: 1rem;
        }
        
        .photo-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-top: 1rem;
        }
        
        .photo-upload-area:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .photo-upload-area i {
            font-size: 2rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }
        
        .photo-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .verification-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .verification-badge.verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .verification-badge.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Data Balita</span></h1>
                    <p class="text-gray-600">Tambah data balita baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('kelurahan.balita.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Balita
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
        
        <form action="{{ route('kelurahan.balita.store') }}" method="POST" enctype="multipart/form-data" id="balitaForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Balita</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap data balita</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-baby mr-2"></i>
                        <span>Form Tambah Balita - Kelurahan</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan akurat dan lengkap untuk pemantauan yang optimal.
                    </p>
                </div>
                
                <!-- Data Keluarga -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Keluarga</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="kartu_keluarga_id" class="form-label">
                                <i class="fas fa-id-card-alt mr-1 text-blue-500"></i> Kartu Keluarga
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
                    </div>
                </div>
                
                <!-- Data Pribadi -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Pribadi</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nik" class="form-label">
                                <i class="fas fa-id-card mr-1 text-blue-500"></i> NIK
                            </label>
                            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="form-input" placeholder="Masukkan NIK balita">
                            @error('nik')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="nama" class="form-label">
                                <i class="fas fa-user mr-1 text-blue-500"></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-input" placeholder="Masukkan nama lengkap balita" required>
                            @error('nama')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tanggal_lahir" class="form-label">
                                <i class="fas fa-birthday-cake mr-1 text-blue-500"></i> Tanggal Lahir
                            </label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-input" required>
                            @error('tanggal_lahir')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="jenis_kelamin" class="form-label">
                                <i class="fas fa-venus-mars mr-1 text-blue-500"></i> Jenis Kelamin
                            </label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-input" required>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Kesehatan -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Kesehatan</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="berat" class="form-label">
                                <i class="fas fa-weight mr-1 text-blue-500"></i> Berat Badan (kg)
                            </label>
                            <input type="number" step="0.1" name="berat" id="berat" value="{{ old('berat') }}" class="form-input" placeholder="0.0" required>
                            @error('berat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tinggi" class="form-label">
                                <i class="fas fa-ruler-vertical mr-1 text-blue-500"></i> Tinggi Badan (cm)
                            </label>
                            <input type="number" step="0.1" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" class="form-input" placeholder="0.0" required>
                            @error('tinggi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="lingkar_kepala" class="form-label">
                                <i class="fas fa-circle mr-1 text-blue-500"></i> Lingkar Kepala (cm)
                            </label>
                            <input type="number" step="0.1" name="lingkar_kepala" id="lingkar_kepala" value="{{ old('lingkar_kepala') }}" class="form-input" placeholder="0.0">
                            @error('lingkar_kepala')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="lingkar_lengan" class="form-label">
                                <i class="fas fa-circle-notch mr-1 text-blue-500"></i> Lingkar Lengan (cm)
                            </label>
                            <input type="number" step="0.1" name="lingkar_lengan" id="lingkar_lengan" value="{{ old('lingkar_lengan') }}" class="form-input" placeholder="0.0">
                            @error('lingkar_lengan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Tambahan -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Tambahan</h4>
                    <div class="form-grid">
                        <div class="form-group md:col-span-2">
                            <label for="alamat" class="form-label">
                                <i class="fas fa-home mr-1 text-blue-500"></i> Alamat Lengkap
                            </label>
                            <textarea name="alamat" id="alamat" class="form-input" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_gizi" class="form-label">
                                <i class="fas fa-utensils mr-1 text-blue-500"></i> Status Gizi
                            </label>
                            <select name="status_gizi" id="status_gizi" class="form-input" required>
                                <option value="Sehat" {{ old('status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                <option value="Stunting" {{ old('status_gizi') == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                                <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                <option value="Obesitas" {{ old('status_gizi') == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                            </select>
                            @error('status_gizi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="warna_label" class="form-label">
                                <i class="fas fa-tag mr-1 text-blue-500"></i> Warna Label
                            </label>
                            <select name="warna_label" id="warna_label" class="form-input" required>
                                <option value="Sehat" {{ old('warna_label') == 'Sehat' ? 'selected' : '' }}>
                                    <span class="warna-label sehat"></span> Sehat
                                </option>
                                <option value="Waspada" {{ old('warna_label') == 'Waspada' ? 'selected' : '' }}>
                                    <span class="warna-label waspada"></span> Waspada
                                </option>
                                <option value="Bahaya" {{ old('warna_label') == 'Bahaya' ? 'selected' : '' }}>
                                    <span class="warna-label bahaya"></span> Bahaya
                                </option>
                            </select>
                            @error('warna_label')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_pemantauan" class="form-label">
                                <i class="fas fa-heartbeat mr-1 text-blue-500"></i> Status Pemantauan
                            </label>
                            <input type="text" name="status_pemantauan" id="status_pemantauan" value="{{ old('status_pemantauan') }}" class="form-input" placeholder="Status pemantauan">
                            @error('status_pemantauan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Upload Foto -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Foto Balita</h4>
                    <div class="form-group">
                        <label for="foto" class="form-label">
                            <i class="fas fa-camera mr-1 text-blue-500"></i> Foto Balita
                        </label>
                        
                        <div class="photo-upload-area" id="photoUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="text-gray-600">Klik untuk memilih foto atau seret dan lepas di sini</p>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                        </div>
                        
                        <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                        <img id="photoPreview" class="photo-preview" src="#" alt="Preview Foto">
                        
                        @error('foto')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('kelurahan.balita.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data Balita
                    </button>
                </div>
            </div>
        </form>
        
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
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true,
                width: '100%',
                templateResult: formatKartuKeluarga,
                templateSelection: formatKartuKeluarga
            });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Load kartu keluarga on page load
            loadKartuKeluarga();

            function loadKartuKeluarga() {
                $.ajax({
                    url: '{{ route("kelurahan.balita.getKartuKeluarga") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kartu_keluarga_id').empty();
                        $('#kartu_keluarga_id').append('<option value="">-- Pilih Kartu Keluarga --</option>');
                        $.each(data, function(index, kk) {
                            var text = `${kk.no_kk} - ${kk.kepala_keluarga}`;
                            var selected = kk.id == {{ old('kartu_keluarga_id') ?? 'null' }} ? 'selected' : '';
                            $('#kartu_keluarga_id').append(`<option value="${kk.id}" data-source="${kk.source}" ${selected}>${text}</option>`);
                        });
                        $('#kartu_keluarga_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }

            function formatKartuKeluarga(kartuKeluarga) {
                if (!kartuKeluarga.id) {
                    return kartuKeluarga.text;
                }
                
                var source = $(kartuKeluarga.element).data('source');
                var badgeClass = source === 'verified' ? 'verified' : 'pending';
                var badgeText = source === 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi';
                
                var $wrapper = $(
                    '<div class="flex justify-between items-center w-full">' +
                        '<span>' + kartuKeluarga.text + '</span>' +
                        '<span class="verification-badge ' + badgeClass + '">' + badgeText + '</span>' +
                    '</div>'
                );
                
                return $wrapper;
            }

            // Photo upload functionality
            $('#photoUploadArea').on('click', function() {
                $('#foto').click();
            });

            $('#foto').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#photoPreview').attr('src', e.target.result);
                        $('#photoPreview').show();
                        $('#photoUploadArea').hide();
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Drag and drop functionality for photo upload
            $('#photoUploadArea').on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $('#photoUploadArea').on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            $('#photoUploadArea').on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
                
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    $('#foto')[0].files = files;
                    $('#foto').trigger('change');
                }
            });

            // Form validation before submission
            $('#balitaForm').on('submit', function(e) {
                var isValid = true;
                var firstErrorField = null;
                
                // Check required fields
                $('input[required], select[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('border-red-500');
                        
                        if (!firstErrorField) {
                            firstErrorField = this;
                        }
                    } else {
                        $(this).removeClass('border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi.',
                        confirmButtonColor: '#3b82f6'
                    });
                    
                    if (firstErrorField) {
                        $('html, body').animate({
                            scrollTop: $(firstErrorField).offset().top - 100
                        }, 500);
                    }
                }
            });

            // Handle session error with SweetAlert2
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3b82f6'
                });
            @endif
        });
    </script>
</body>
</html>