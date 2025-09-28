<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Audit Stunting - CSSR</title>
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
        
        .audit-status {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .audit-status.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .audit-status.completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .audit-status.review {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .text-area {
            min-height: 120px;
            resize: vertical;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Data Audit Stunting</span></h1>
                    <p class="text-gray-600">Tambah data audit stunting baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('audit_stunting.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Audit
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
        
        <form method="POST" action="{{ route('audit_stunting.store') }}" enctype="multipart/form-data" id="auditForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Audit Stunting</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap data audit stunting</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-clipboard-check mr-2"></i>
                        <span>Form Tambah Audit</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan akurat dan lengkap untuk audit yang berkualitas.
                    </p>
                </div>
                
                <!-- Data Audit -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Audit</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="data_monitoring_id" class="form-label">
                                <i class="fas fa-chart-line mr-1 text-blue-500"></i> Data Monitoring
                            </label>
                            <select name="data_monitoring_id" id="data_monitoring_id" class="form-input" required>
                                <option value="">-- Pilih Data Monitoring --</option>
                                @foreach (App\Models\DataMonitoring::all() as $monitoring)
                                    <option value="{{ $monitoring->id }}" {{ $dataMonitoring && $dataMonitoring->id == $monitoring->id ? 'selected' : '' }}>
                                        {{ $monitoring->nama }} ({{ $monitoring->target }} - {{ $monitoring->kategori }})
                                    </option>
                                @endforeach
                            </select>
                            @error('data_monitoring_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-check mr-1 text-blue-500"></i> Pengaudit
                            </label>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <i class="fas fa-user-circle text-gray-400 mr-3 text-xl"></i>
                                <div>
                                    <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="pihak_pengaudit" class="form-label">
                                <i class="fas fa-users mr-1 text-blue-500"></i> Pihak Pengaudit
                            </label>
                            <input type="text" name="pihak_pengaudit" id="pihak_pengaudit" value="{{ old('pihak_pengaudit') }}" class="form-input" placeholder="Masukkan pihak pengaudit">
                            @error('pihak_pengaudit')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Dokumentasi -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Dokumentasi</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="foto_dokumentasi" class="form-label">
                                <i class="fas fa-camera mr-1 text-blue-500"></i> Foto Dokumentasi
                            </label>
                            
                            <div class="photo-upload-area" id="photoUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="text-gray-600">Klik untuk memilih foto atau seret dan lepas di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                            </div>
                            
                            <input type="file" name="foto_dokumentasi" id="foto_dokumentasi" class="hidden" accept="image/*">
                            <img id="photoPreview" class="photo-preview" src="#" alt="Preview Foto">
                            
                            @error('foto_dokumentasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Konten Audit -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Konten Audit</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="laporan" class="form-label">
                                <i class="fas fa-file-alt mr-1 text-blue-500"></i> Laporan
                            </label>
                            <textarea name="laporan" id="laporan" rows="4" class="form-input text-area" placeholder="Masukkan laporan audit">{{ old('laporan') }}</textarea>
                            @error('laporan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="narasi" class="form-label">
                                <i class="fas fa-align-left mr-1 text-blue-500"></i> Narasi
                            </label>
                            <textarea name="narasi" id="narasi" rows="4" class="form-input text-area" placeholder="Masukkan narasi audit">{{ old('narasi') }}</textarea>
                            @error('narasi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('audit_stunting.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data Audit
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
            $('#data_monitoring_id').select2({
                placeholder: 'Pilih Data Monitoring',
                allowClear: true,
                width: '100%'
            });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Photo upload functionality
            $('#photoUploadArea').on('click', function() {
                $('#foto_dokumentasi').click();
            });

            $('#foto_dokumentasi').on('change', function(e) {
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
                    $('#foto_dokumentasi')[0].files = files;
                    $('#foto_dokumentasi').trigger('change');
                }
            });

            // Form validation before submission
            $('#auditForm').on('submit', function(e) {
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