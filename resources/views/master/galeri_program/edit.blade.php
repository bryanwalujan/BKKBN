<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Program - CSSR</title>
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
        
        .photo-preview {
            width: 200px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px dashed #d1d5db;
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
        
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
        }
        
        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            margin-right: 0.5rem;
            cursor: pointer;
        }
        
        .checkbox-container input[type="checkbox"]:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .checkbox-label {
            font-size: 0.875rem;
            color: #374151;
            cursor: pointer;
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
        
        .kategori-badge.penyuluhan {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .kategori-badge.posyandu {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .kategori-badge.pendampingan {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .kategori-badge.lainnya {
            background-color: #f3e8ff;
            color: #6b21a8;
        }
        
        .current-image {
            width: 200px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #d1d5db;
            margin-top: 1rem;
        }
        
        .image-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-start;
        }
        
        .image-info {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.5rem;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Program</span></h1>
                    <p class="text-gray-600">Edit program yang ada dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('galeri_program.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Program
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
        
        <form action="{{ route('galeri_program.update', $galeriProgram->id) }}" method="POST" enctype="multipart/form-data" id="programForm">
            @csrf
            @method('PUT')
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Program</h3>
                        <p class="text-gray-600 text-sm mt-1">Edit informasi lengkap program</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Form Edit Program</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Perbarui data program sesuai kebutuhan. Kosongkan gambar jika tidak ingin mengubahnya.
                    </p>
                </div>
                
                <!-- Gambar Program -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Gambar Program</h4>
                    <div class="form-group">
                        <label for="gambar" class="form-label">
                            <i class="fas fa-image mr-1 text-blue-500"></i> Gambar Program
                        </label>
                        
                        <div class="image-container">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $galeriProgram->gambar) }}" alt="Gambar Program" class="current-image">
                                <p class="image-info">Gambar yang sedang digunakan</p>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-700">Gambar Baru (Opsional):</p>
                                <div class="photo-upload-area" id="photoUploadArea">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p class="text-gray-600">Klik untuk memilih gambar atau seret dan lepas di sini</p>
                                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                                </div>
                                
                                <input type="file" name="gambar" id="gambar" class="hidden" accept="image/jpeg,image/jpg,image/png">
                                <img id="preview_gambar" class="photo-preview" src="#" alt="Preview Gambar Baru">
                                
                                @error('gambar')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Informasi Program -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Informasi Program</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="judul" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Judul Program
                            </label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $galeriProgram->judul) }}" class="form-input" placeholder="Masukkan judul program" required>
                            @error('judul')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kategori" class="form-label">
                                <i class="fas fa-tag mr-1 text-blue-500"></i> Kategori Program
                            </label>
                            <select name="kategori" id="kategori" class="form-input" required>
                                <option value="Penyuluhan" {{ old('kategori', $galeriProgram->kategori) == 'Penyuluhan' ? 'selected' : '' }}>
                                    Penyuluhan
                                </option>
                                <option value="Posyandu" {{ old('kategori', $galeriProgram->kategori) == 'Posyandu' ? 'selected' : '' }}>
                                    Posyandu
                                </option>
                                <option value="Pendampingan" {{ old('kategori', $galeriProgram->kategori) == 'Pendampingan' ? 'selected' : '' }}>
                                    Pendampingan
                                </option>
                                <option value="Lainnya" {{ old('kategori', $galeriProgram->kategori) == 'Lainnya' ? 'selected' : '' }}>
                                    Lainnya
                                </option>
                            </select>
                            @error('kategori')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="urutan" class="form-label">
                                <i class="fas fa-sort-numeric-down mr-1 text-blue-500"></i> Urutan Tampil
                            </label>
                            <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $galeriProgram->urutan) }}" class="form-input" min="1" required>
                            @error('urutan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="link" class="form-label">
                                <i class="fas fa-link mr-1 text-blue-500"></i> Link (Opsional)
                            </label>
                            <input type="url" name="link" id="link" value="{{ old('link', $galeriProgram->link) }}" class="form-input" placeholder="https://example.com">
                            @error('link')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Deskripsi Program -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Deskripsi Program</h4>
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left mr-1 text-blue-500"></i> Deskripsi Lengkap
                        </label>
                        <textarea name="deskripsi" id="deskripsi" class="form-input" rows="5" placeholder="Masukkan deskripsi lengkap program" required>{{ old('deskripsi', $galeriProgram->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Status Program -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Status Program</h4>
                    <div class="form-group">
                        <div class="checkbox-container">
                            <input type="checkbox" name="status_aktif" id="status_aktif" class="form-checkbox" {{ old('status_aktif', $galeriProgram->status_aktif) ? 'checked' : '' }}>
                            <label for="status_aktif" class="checkbox-label">
                                <i class="fas fa-toggle-on mr-1 text-blue-500"></i> Aktifkan Program
                            </label>
                        </div>
                        @error('status_aktif')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2">Jika dicentang, program akan ditampilkan di halaman publik.</p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('galeri_program.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Program
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
            // Photo upload functionality
            $('#photoUploadArea').on('click', function() {
                $('#gambar').click();
            });

            $('#gambar').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#preview_gambar').attr('src', e.target.result);
                        $('#preview_gambar').show();
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
                    $('#gambar')[0].files = files;
                    $('#gambar').trigger('change');
                }
            });

            // Form validation before submission
            $('#programForm').on('submit', function(e) {
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