<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Referensi - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
        
        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid #d1d5db;
            margin-right: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .checkbox-container input[type="checkbox"]:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .checkbox-container span {
            font-size: 0.875rem;
            color: #374151;
        }
        
        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 2rem;
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
            font-size: 2rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }
        
        .file-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .preview-container {
            margin-top: 1rem;
            display: none;
        }
        
        .preview-icon {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
        }
        
        .preview-pdf {
            width: 100%;
            height: 300px;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
        }
        
        .warna-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .warna-option:hover {
            background-color: #f3f4f6;
        }
        
        .warna-badge {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
        }
        
        .warna-badge.biru {
            background-color: #3b82f6;
        }
        
        .warna-badge.merah {
            background-color: #ef4444;
        }
        
        .warna-badge.hijau {
            background-color: #10b981;
        }
        
        .warna-badge.kuning {
            background-color: #f59e0b;
        }
        
        .form-section {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .form-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Referensi</span></h1>
                    <p class="text-gray-600">Tambah referensi baru untuk sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('referensi.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Referensi
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
        
        <form action="{{ route('referensi.store') }}" method="POST" enctype="multipart/form-data" id="referensiForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Referensi</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap referensi baru</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-book mr-2"></i>
                        <span>Form Tambah Referensi</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan akurat dan lengkap untuk referensi yang optimal.
                    </p>
                </div>
                
                <!-- Informasi Dasar -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-info-circle text-blue-500"></i> Informasi Dasar
                    </h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="judul" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Judul Referensi
                            </label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="form-input" placeholder="Masukkan judul referensi" required>
                            @error('judul')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="urutan" class="form-label">
                                <i class="fas fa-sort-numeric-down mr-1 text-blue-500"></i> Urutan Tampilan
                            </label>
                            <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 1) }}" class="form-input" min="1" required>
                            @error('urutan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left mr-1 text-blue-500"></i> Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" class="form-input" rows="4" placeholder="Masukkan deskripsi referensi" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- File dan Ikon -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-file-alt text-blue-500"></i> File dan Ikon
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="icon" class="form-label">
                                <i class="fas fa-image mr-1 text-blue-500"></i> Ikon Referensi
                            </label>
                            
                            <div class="file-upload-area" id="iconUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="text-gray-600">Klik untuk memilih ikon atau seret dan lepas di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                            </div>
                            
                            <input type="file" name="icon" id="icon" class="hidden" accept="image/jpeg,image/jpg,image/png" required>
                            
                            <div class="preview-container" id="iconPreviewContainer">
                                <p class="text-sm text-gray-600 mb-2">Preview Ikon:</p>
                                <img id="preview_icon" class="preview-icon" src="#" alt="Preview Ikon">
                            </div>
                            
                            @error('icon')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="pdf" class="form-label">
                                <i class="fas fa-file-pdf mr-1 text-blue-500"></i> File PDF
                            </label>
                            
                            <div class="file-upload-area" id="pdfUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="text-gray-600">Klik untuk memilih PDF atau seret dan lepas di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: PDF (Maks. 5MB)</p>
                            </div>
                            
                            <input type="file" name="pdf" id="pdf" class="hidden" accept="application/pdf" required>
                            
                            <div class="preview-container" id="pdfPreviewContainer">
                                <p class="text-sm text-gray-600 mb-2">Preview PDF:</p>
                                <embed id="preview_pdf" class="preview-pdf" type="application/pdf">
                            </div>
                            
                            @error('pdf')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="warna_icon" class="form-label">
                                <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Ikon
                            </label>
                            <select name="warna_icon" id="warna_icon" class="form-input" required>
                                <option value="Biru" {{ old('warna_icon', 'Biru') == 'Biru' ? 'selected' : '' }}>Biru</option>
                                <option value="Merah" {{ old('warna_icon') == 'Merah' ? 'selected' : '' }}>Merah</option>
                                <option value="Hijau" {{ old('warna_icon') == 'Hijau' ? 'selected' : '' }}>Hijau</option>
                                <option value="Kuning" {{ old('warna_icon') == 'Kuning' ? 'selected' : '' }}>Kuning</option>
                            </select>
                            @error('warna_icon')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="teks_tombol" class="form-label">
                                <i class="fas fa-font mr-1 text-blue-500"></i> Teks Tombol
                            </label>
                            <input type="text" name="teks_tombol" id="teks_tombol" value="{{ old('teks_tombol') }}" class="form-input" placeholder="Teks untuk tombol" maxlength="50" required>
                            @error('teks_tombol')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Pengaturan Tambahan -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-cog text-blue-500"></i> Pengaturan Tambahan
                    </h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="link_file" class="form-label">
                                <i class="fas fa-link mr-1 text-blue-500"></i> Link File (Opsional)
                            </label>
                            <input type="url" name="link_file" id="link_file" value="{{ old('link_file') }}" class="form-input" placeholder="https://example.com/file.pdf">
                            @error('link_file')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-toggle-on mr-1 text-blue-500"></i> Status
                            </label>
                            <div class="checkbox-container">
                                <input type="checkbox" name="status_aktif" id="status_aktif" class="form-checkbox" {{ old('status_aktif', 1) ? 'checked' : '' }}>
                                <span>Aktifkan referensi ini</span>
                            </div>
                            @error('status_aktif')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('referensi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Referensi
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Photo upload functionality for icon
            $('#iconUploadArea').on('click', function() {
                $('#icon').click();
            });

            $('#icon').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#preview_icon').attr('src', e.target.result);
                        $('#iconPreviewContainer').show();
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Photo upload functionality for PDF
            $('#pdfUploadArea').on('click', function() {
                $('#pdf').click();
            });

            $('#pdf').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#preview_pdf').attr('src', e.target.result);
                        $('#pdfPreviewContainer').show();
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Drag and drop functionality for file uploads
            function setupDragDrop(areaId, inputId) {
                $(areaId).on('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass('dragover');
                });

                $(areaId).on('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('dragover');
                });

                $(areaId).on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('dragover');
                    
                    var files = e.originalEvent.dataTransfer.files;
                    if (files.length > 0) {
                        $(inputId)[0].files = files;
                        $(inputId).trigger('change');
                    }
                });
            }

            setupDragDrop('#iconUploadArea', '#icon');
            setupDragDrop('#pdfUploadArea', '#pdf');

            // Form validation before submission
            $('#referensiForm').on('submit', function(e) {
                var isValid = true;
                var firstErrorField = null;
                
                // Check required fields
                $('input[required], select[required], textarea[required]').each(function() {
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