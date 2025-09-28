<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Edukasi - CSSR</title>
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
        
        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-top: 1rem;
        }
        
        .file-upload-area:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .file-upload-area i {
            font-size: 1.5rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }
        
        .file-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .file-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .file-info i {
            color: #3b82f6;
        }
        
        .kategori-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
        }
        
        .kategori-badge.artikel {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .kategori-badge.video {
            background-color: #f3e8ff;
            color: #7e22ce;
        }
        
        .kategori-badge.infografis {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .kategori-badge.panduan {
            background-color: #fef3c7;
            color: #92400e;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Materi Edukasi</span></h1>
                    <p class="text-gray-600">Tambah materi edukasi baru untuk pencegahan stunting</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('edukasi.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Edukasi
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
        
        <form method="POST" action="{{ route('edukasi.store') }}" enctype="multipart/form-data" id="edukasiForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Edukasi</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap materi edukasi</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-book-open mr-2"></i>
                        <span>Form Tambah Edukasi</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pilih kategori yang sesuai untuk menentukan jenis konten yang akan ditambahkan.
                    </p>
                </div>
                
                <!-- Data Utama -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Utama</h4>
                    <div class="form-grid">
                        <div class="form-group md:col-span-2">
                            <label for="judul" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Judul Edukasi
                            </label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="form-input" placeholder="Masukkan judul edukasi" required>
                            @error('judul')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kategori" class="form-label">
                                <i class="fas fa-tag mr-1 text-blue-500"></i> Kategori
                            </label>
                            <select name="kategori" id="kategori" class="form-input" required>
                                <option value="" {{ old('kategori') ? '' : 'selected' }} disabled>Pilih Kategori</option>
                                @foreach (\App\Models\Edukasi::KATEGORI as $key => $label)
                                    <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_aktif" class="form-label">
                                <i class="fas fa-toggle-on mr-1 text-blue-500"></i> Status Aktif
                            </label>
                            <select name="status_aktif" id="status_aktif" class="form-input" required>
                                <option value="1" {{ old('status_aktif', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status_aktif', 1) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status_aktif')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Konten Edukasi -->
                <div class="mb-8" id="additional-fields">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Konten Edukasi</h4>
                    <div class="form-grid">
                        <div class="form-group md:col-span-2">
                            <label for="deskripsi" class="form-label">
                                <i class="fas fa-align-left mr-1 text-blue-500"></i> Deskripsi
                            </label>
                            <textarea name="deskripsi" id="deskripsi" rows="4" class="form-input" placeholder="Masukkan deskripsi edukasi">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tautan" class="form-label">
                                <i class="fas fa-link mr-1 text-blue-500"></i> Tautan Link
                            </label>
                            <input type="url" name="tautan" id="tautan" value="{{ old('tautan') }}" class="form-input" placeholder="https://example.com">
                            @error('tautan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Upload File -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Upload File</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gambar" class="form-label">
                                <i class="fas fa-image mr-1 text-blue-500"></i> Gambar
                            </label>
                            
                            <div class="photo-upload-area" id="photoUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="text-gray-600">Klik untuk memilih gambar atau seret dan lepas di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                            </div>
                            
                            <input type="file" name="gambar" id="gambar" class="hidden" accept=".jpg,.jpeg,.png">
                            <img id="photoPreview" class="photo-preview" src="#" alt="Preview Gambar">
                            
                            @error('gambar')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="file" class="form-label">
                                <i class="fas fa-file-alt mr-1 text-blue-500"></i> File (PDF/Word)
                            </label>
                            
                            <div class="file-upload-area" id="fileUploadArea">
                                <i class="fas fa-file-upload"></i>
                                <p class="text-gray-600">Klik untuk memilih file atau seret dan lepas di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: PDF, DOC, DOCX (Maks. 5MB)</p>
                            </div>
                            
                            <input type="file" name="file" id="file" class="hidden" accept=".pdf,.doc,.docx">
                            <div id="fileInfo" class="file-info hidden">
                                <i class="fas fa-file"></i>
                                <span id="fileName"></span>
                            </div>
                            
                            @error('file')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('edukasi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Edukasi
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
            $('#kategori').select2({
                placeholder: 'Pilih Kategori',
                allowClear: true,
                width: '100%'
            });

            $('#status_aktif').select2({
                placeholder: 'Pilih Status',
                allowClear: false,
                width: '100%'
            });

            // Show/hide additional fields based on kategori selection
            function toggleAdditionalFields() {
                const kategori = $('#kategori').val();
                const additionalFields = $('#additional-fields');
                
                if (kategori && kategori !== '') {
                    additionalFields.show();
                } else {
                    additionalFields.hide();
                }
            }

            // Initial state
            toggleAdditionalFields();

            // Change event
            $('#kategori').on('change', function() {
                toggleAdditionalFields();
            });

            // Photo upload functionality
            $('#photoUploadArea').on('click', function() {
                $('#gambar').click();
            });

            $('#gambar').on('change', function(e) {
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

            // File upload functionality
            $('#fileUploadArea').on('click', function() {
                $('#file').click();
            });

            $('#file').on('change', function(e) {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    $('#fileName').text(fileName);
                    $('#fileInfo').removeClass('hidden');
                    $('#fileUploadArea').hide();
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
                    $('#gambar')[0].files = files;
                    $('#gambar').trigger('change');
                }
            });

            // Drag and drop functionality for file upload
            $('#fileUploadArea').on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });

            $('#fileUploadArea').on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });

            $('#fileUploadArea').on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
                
                var files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    $('#file')[0].files = files;
                    $('#file').trigger('change');
                }
            });

            // Form validation before submission
            $('#edukasiForm').on('submit', function(e) {
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