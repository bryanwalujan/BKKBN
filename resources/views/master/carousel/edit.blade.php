<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Carousel - CSSR</title>
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
            width: 100%;
            max-width: 400px;
            height: 200px;
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
        
        .optional-badge {
            display: inline-block;
            background-color: #f3f4f6;
            color: #6b7280;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
            font-weight: 500;
        }
        
        .button-preview {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            margin: 0.25rem;
            background-color: #3b82f6;
            color: white;
            border: none;
        }
        
        .button-preview.secondary {
            background-color: #6b7280;
        }
        
        .current-image {
            width: 100%;
            max-width: 400px;
            height: 200px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #d1d5db;
            margin-top: 1rem;
        }
        
        .image-container {
            position: relative;
            display: inline-block;
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 0.5rem;
        }
        
        .image-container:hover .image-overlay {
            opacity: 1;
        }
        
        .image-overlay-text {
            color: white;
            font-weight: 500;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Carousel</span></h1>
                    <p class="text-gray-600">Edit slide carousel untuk halaman utama</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('carousel.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Carousel
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
        
        <form action="{{ route('carousel.update', $carousel->id) }}" method="POST" enctype="multipart/form-data" id="carouselForm">
            @csrf
            @method('PUT')
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Carousel</h3>
                        <p class="text-gray-600 text-sm mt-1">Edit informasi untuk slide carousel</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="status-badge {{ $carousel->status ? 'status-active' : 'status-inactive' }}">
                            <i class="fas {{ $carousel->status ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                            {{ $carousel->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                        <div class="flex items-center text-sm text-blue-500">
                            <i class="fas fa-edit mr-2"></i>
                            <span>Form Edit Carousel</span>
                        </div>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Carousel akan ditampilkan di halaman utama website. Pastikan konten menarik dan informatif.
                    </p>
                </div>
                
                <!-- Konten Utama -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Konten Utama</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="sub_heading" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Sub Heading
                            </label>
                            <input type="text" name="sub_heading" id="sub_heading" value="{{ old('sub_heading', $carousel->sub_heading) }}" class="form-input" placeholder="Masukkan sub heading" required>
                            @error('sub_heading')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="heading" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Heading Utama
                            </label>
                            <input type="text" name="heading" id="heading" value="{{ old('heading', $carousel->heading) }}" class="form-input" placeholder="Masukkan heading utama" required>
                            @error('heading')
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
                        <textarea name="deskripsi" id="deskripsi" class="form-input" rows="4" placeholder="Masukkan deskripsi carousel" required>{{ old('deskripsi', $carousel->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Tombol Aksi <span class="optional-badge">Opsional</span></h4>
                    <p class="text-gray-600 text-sm mb-4">Tambahkan tombol aksi untuk interaksi pengguna</p>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="button_1_text" class="form-label">
                                <i class="fas fa-mouse-pointer mr-1 text-blue-500"></i> Teks Tombol 1
                            </label>
                            <input type="text" name="button_1_text" id="button_1_text" value="{{ old('button_1_text', $carousel->button_1_text) }}" class="form-input" placeholder="Contoh: Pelajari Lebih Lanjut">
                            @error('button_1_text')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="button_1_link" class="form-label">
                                <i class="fas fa-link mr-1 text-blue-500"></i> Link Tombol 1
                            </label>
                            <input type="url" name="button_1_link" id="button_1_link" value="{{ old('button_1_link', $carousel->button_1_link) }}" class="form-input" placeholder="https://example.com">
                            @error('button_1_link')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="button_2_text" class="form-label">
                                <i class="fas fa-mouse-pointer mr-1 text-blue-500"></i> Teks Tombol 2
                            </label>
                            <input type="text" name="button_2_text" id="button_2_text" value="{{ old('button_2_text', $carousel->button_2_text) }}" class="form-input" placeholder="Contoh: Daftar Sekarang">
                            @error('button_2_text')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="button_2_link" class="form-label">
                                <i class="fas fa-link mr-1 text-blue-500"></i> Link Tombol 2
                            </label>
                            <input type="url" name="button_2_link" id="button_2_link" value="{{ old('button_2_link', $carousel->button_2_link) }}" class="form-input" placeholder="https://example.com">
                            @error('button_2_link')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Preview Tombol -->
                    <div id="buttonPreview" class="mt-4 p-4 bg-gray-50 rounded-lg {{ $carousel->button_1_text || $carousel->button_2_text ? '' : 'hidden' }}">
                        <p class="text-sm text-gray-600 mb-2">Preview Tombol:</p>
                        <div id="previewButtons" class="flex flex-wrap gap-2">
                            @if($carousel->button_1_text)
                                <button type="button" class="button-preview">
                                    <i class="fas fa-external-link-alt"></i>{{ $carousel->button_1_text }}
                                </button>
                            @endif
                            @if($carousel->button_2_text)
                                <button type="button" class="button-preview secondary">
                                    <i class="fas fa-external-link-alt"></i>{{ $carousel->button_2_text }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Upload Gambar -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Gambar Carousel <span class="optional-badge">Opsional</span></h4>
                    
                    @if($carousel->gambar)
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-image mr-1 text-blue-500"></i> Gambar Saat Ini
                        </label>
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $carousel->gambar) }}" alt="Gambar {{ $carousel->heading }}" class="current-image">
                            <div class="image-overlay">
                                <span class="image-overlay-text">
                                    <i class="fas fa-eye mr-1"></i> Lihat Gambar
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="gambar" class="form-label">
                            <i class="fas fa-image mr-1 text-blue-500"></i> {{ $carousel->gambar ? 'Ganti Gambar' : 'Unggah Gambar' }}
                        </label>
                        
                        <div class="photo-upload-area" id="photoUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="text-gray-600">Klik untuk memilih gambar atau seret dan lepas di sini</p>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                        </div>
                        
                        <input type="file" name="gambar" id="gambar" class="hidden" accept="image/jpeg,image/jpg,image/png">
                        <img id="photoPreview" class="photo-preview" src="#" alt="Preview Gambar">
                        
                        @error('gambar')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('carousel.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
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
                    $('#gambar')[0].files = files;
                    $('#gambar').trigger('change');
                }
            });

            // Button preview functionality
            function updateButtonPreview() {
                var button1Text = $('#button_1_text').val();
                var button2Text = $('#button_2_text').val();
                var previewContainer = $('#previewButtons');
                var previewSection = $('#buttonPreview');
                
                previewContainer.empty();
                
                if (button1Text || button2Text) {
                    previewSection.removeClass('hidden');
                    
                    if (button1Text) {
                        previewContainer.append('<button type="button" class="button-preview"><i class="fas fa-external-link-alt"></i>' + button1Text + '</button>');
                    }
                    
                    if (button2Text) {
                        previewContainer.append('<button type="button" class="button-preview secondary"><i class="fas fa-external-link-alt"></i>' + button2Text + '</button>');
                    }
                } else {
                    previewSection.addClass('hidden');
                }
            }
            
            $('#button_1_text, #button_2_text').on('input', function() {
                updateButtonPreview();
            });
            
            // Initialize button preview on page load
            updateButtonPreview();

            // Form validation before submission
            $('#carouselForm').on('submit', function(e) {
                var isValid = true;
                var firstErrorField = null;
                
                // Check required fields
                $('input[required], textarea[required]').each(function() {
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
            
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#10b981'
                });
            @endif
        });
    </script>
</body>
</html>