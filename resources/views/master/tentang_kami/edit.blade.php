<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tentang Kami - CSSR</title>
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
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #d1d5db;
            margin-top: 1rem;
        }
        
        .photo-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1.5rem;
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
        
        textarea.form-input {
            min-height: 100px;
            resize: vertical;
        }
        
        .optional-badge {
            display: inline-block;
            background-color: #f3f4f6;
            color: #6b7280;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
        }
        
        .required-badge {
            display: inline-block;
            background-color: #fee2e2;
            color: #dc2626;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            margin-left: 0.5rem;
        }
        
        .current-image-container {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .current-image-label {
            position: absolute;
            top: -10px;
            left: 10px;
            background-color: #3b82f6;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 1rem;
            padding: 0.75rem;
            background-color: #f9fafb;
            border-radius: 0.5rem;
            border-left: 3px solid #f59e0b;
        }
        
        .checkbox-container input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            margin-right: 0.75rem;
            cursor: pointer;
        }
        
        .checkbox-container label {
            cursor: pointer;
            font-size: 0.875rem;
            color: #4b5563;
        }
        
        .success-alert {
            background-color: #d1fae5;
            border-left: 4px solid #10b981;
            color: #065f46;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Tentang Kami</span></h1>
                    <p class="text-gray-600">Edit konten untuk halaman Tentang Kami</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('tentang_kami.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Tentang Kami
                    </a>
                </div>
            </div>
        </div>
        
        @if (session('success'))
            <div class="success-alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        <form action="{{ route('tentang_kami.update') }}" method="POST" enctype="multipart/form-data" id="editTentangKamiForm">
            @csrf
            @method('PUT')
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Konten Tentang Kami</h3>
                        <p class="text-gray-600 text-sm mt-1">Edit informasi untuk halaman Tentang Kami</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Form Edit Konten</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan konten yang dimasukkan menarik dan informatif untuk pengunjung website.
                    </p>
                </div>
                
                <!-- Data Teks -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Konten Teks</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="sub_judul" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Sub Judul
                                <span class="required-badge">Wajib</span>
                            </label>
                            <input type="text" name="sub_judul" id="sub_judul" value="{{ old('sub_judul', $tentangKami->sub_judul) }}" class="form-input" placeholder="Masukkan sub judul" required>
                            @error('sub_judul')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="judul_utama" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Judul Utama
                                <span class="required-badge">Wajib</span>
                            </label>
                            <input type="text" name="judul_utama" id="judul_utama" value="{{ old('judul_utama', $tentangKami->judul_utama) }}" class="form-input" placeholder="Masukkan judul utama" required>
                            @error('judul_utama')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="paragraf_1" class="form-label">
                                <i class="fas fa-paragraph mr-1 text-blue-500"></i> Paragraf 1
                                <span class="required-badge">Wajib</span>
                            </label>
                            <textarea name="paragraf_1" id="paragraf_1" class="form-input" rows="4" placeholder="Masukkan paragraf pertama" required>{{ old('paragraf_1', $tentangKami->paragraf_1) }}</textarea>
                            @error('paragraf_1')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="paragraf_2" class="form-label">
                                <i class="fas fa-paragraph mr-1 text-blue-500"></i> Paragraf 2
                                <span class="optional-badge">Opsional</span>
                            </label>
                            <textarea name="paragraf_2" id="paragraf_2" class="form-input" rows="4" placeholder="Masukkan paragraf kedua (opsional)">{{ old('paragraf_2', $tentangKami->paragraf_2) }}</textarea>
                            @error('paragraf_2')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Call-to-Action -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Tombol Call-to-Action</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="teks_tombol" class="form-label">
                                <i class="fas fa-mouse-pointer mr-1 text-blue-500"></i> Teks Tombol
                                <span class="optional-badge">Opsional</span>
                            </label>
                            <input type="text" name="teks_tombol" id="teks_tombol" value="{{ old('teks_tombol', $tentangKami->teks_tombol) }}" class="form-input" placeholder="Contoh: Pelajari Lebih Lanjut">
                            @error('teks_tombol')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="link_tombol" class="form-label">
                                <i class="fas fa-link mr-1 text-blue-500"></i> Link Tombol
                                <span class="optional-badge">Opsional</span>
                            </label>
                            <input type="url" name="link_tombol" id="link_tombol" value="{{ old('link_tombol', $tentangKami->link_tombol) }}" class="form-input" placeholder="https://example.com">
                            @error('link_tombol')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Upload Gambar -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Gambar</h4>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gambar_utama" class="form-label">
                                <i class="fas fa-image mr-1 text-blue-500"></i> Gambar Utama
                                <span class="required-badge">Wajib</span>
                            </label>
                            
                            <div class="current-image-container">
                                <span class="current-image-label">Gambar Saat Ini</span>
                                <img src="{{ asset('storage/' . $tentangKami->gambar_utama) }}" alt="Gambar Utama" class="photo-preview">
                            </div>
                            
                            <div class="photo-upload-area" id="gambarUtamaUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="text-gray-600">Klik untuk memilih gambar utama baru atau seret dan lepas di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                            </div>
                            
                            <input type="file" name="gambar_utama" id="gambar_utama" class="hidden" accept="image/jpeg,image/jpg,image/png">
                            <img id="preview_gambar_utama" class="photo-preview hidden" src="#" alt="Preview Gambar Utama">
                            
                            @error('gambar_utama')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="gambar_overlay" class="form-label">
                                <i class="fas fa-images mr-1 text-blue-500"></i> Gambar Overlay
                                <span class="optional-badge">Opsional</span>
                            </label>
                            
                            @if ($tentangKami->gambar_overlay)
                                <div class="current-image-container">
                                    <span class="current-image-label">Gambar Saat Ini</span>
                                    <img src="{{ asset('storage/' . $tentangKami->gambar_overlay) }}" alt="Gambar Overlay" class="photo-preview">
                                </div>
                                
                                <div class="checkbox-container">
                                    <input type="checkbox" name="remove_gambar_overlay" id="remove_gambar_overlay" class="form-checkbox">
                                    <label for="remove_gambar_overlay">Hapus Gambar Overlay</label>
                                </div>
                            @endif
                            
                            <div class="photo-upload-area" id="gambarOverlayUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p class="text-gray-600">Klik untuk memilih gambar overlay baru atau seret dan lepas di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                            </div>
                            
                            <input type="file" name="gambar_overlay" id="gambar_overlay" class="hidden" accept="image/jpeg,image/jpg,image/png">
                            <img id="preview_gambar_overlay" class="photo-preview hidden" src="#" alt="Preview Gambar Overlay">
                            
                            @error('gambar_overlay')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('tentang_kami.index') }}" class="btn btn-secondary">
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
            // Photo upload functionality for gambar utama
            $('#gambarUtamaUploadArea').on('click', function() {
                $('#gambar_utama').click();
            });

            $('#gambar_utama').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#preview_gambar_utama').attr('src', e.target.result);
                        $('#preview_gambar_utama').removeClass('hidden');
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Photo upload functionality for gambar overlay
            $('#gambarOverlayUploadArea').on('click', function() {
                $('#gambar_overlay').click();
            });

            $('#gambar_overlay').on('change', function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#preview_gambar_overlay').attr('src', e.target.result);
                        $('#preview_gambar_overlay').removeClass('hidden');
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Drag and drop functionality for photo upload
            function setupDragDrop(uploadAreaId, fileInputId, previewId) {
                $(uploadAreaId).on('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).addClass('dragover');
                });

                $(uploadAreaId).on('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('dragover');
                });

                $(uploadAreaId).on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).removeClass('dragover');
                    
                    var files = e.originalEvent.dataTransfer.files;
                    if (files.length > 0) {
                        $(fileInputId)[0].files = files;
                        $(fileInputId).trigger('change');
                    }
                });
            }

            setupDragDrop('#gambarUtamaUploadArea', '#gambar_utama', '#preview_gambar_utama');
            setupDragDrop('#gambarOverlayUploadArea', '#gambar_overlay', '#preview_gambar_overlay');

            // Toggle remove gambar overlay functionality
            $('#remove_gambar_overlay').on('change', function() {
                const fileInput = $('#gambar_overlay');
                const preview = $('#preview_gambar_overlay');
                
                if (this.checked) {
                    fileInput.prop('disabled', true);
                    preview.addClass('hidden');
                    $('#gambarOverlayUploadArea').hide();
                } else {
                    fileInput.prop('disabled', false);
                    $('#gambarOverlayUploadArea').show();
                }
            });

            // Form validation before submission
            $('#editTentangKamiForm').on('submit', function(e) {
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