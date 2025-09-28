<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan Kami - CSSR</title>
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
        
        .character-counter {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: right;
            margin-top: 0.25rem;
        }
        
        .character-counter.warning {
            color: #f59e0b;
        }
        
        .character-counter.danger {
            color: #dc2626;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }
        
        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .custom-checkbox.checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .custom-checkbox.checked::after {
            content: '✓';
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        .checkbox-label {
            font-weight: 500;
            color: #374151;
            font-size: 0.875rem;
        }
        
        .photo-preview {
            width: 80px;
            height: 80px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #d1d5db;
            display: none;
            margin-top: 1rem;
        }
        
        .photo-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-top: 0.5rem;
            max-width: 300px;
        }
        
        .photo-upload-area:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .photo-upload-area i {
            font-size: 1.5rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }
        
        .photo-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .form-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Layanan Kami</span></h1>
                    <p class="text-gray-600">Tambah layanan baru untuk ditampilkan di halaman utama</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('layanan_kami.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Layanan
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
        
        <form action="{{ route('layanan_kami.store') }}" method="POST" enctype="multipart/form-data" id="layananForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Layanan</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap tentang layanan baru</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-hand-holding-heart mr-2"></i>
                        <span>Form Tambah Layanan</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan informasi layanan yang dimasukkan jelas dan menarik untuk pengguna.
                    </p>
                </div>
                
                <!-- Data Utama -->
                <div class="form-section">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Utama</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="judul_layanan" class="form-label">
                                <i class="fas fa-heading mr-1 text-blue-500"></i> Judul Layanan
                            </label>
                            <input type="text" name="judul_layanan" id="judul_layanan" value="{{ old('judul_layanan') }}" class="form-input" placeholder="Masukkan judul layanan" required>
                            @error('judul_layanan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="urutan" class="form-label">
                                <i class="fas fa-sort-numeric-down mr-1 text-blue-500"></i> Urutan Tampil
                            </label>
                            <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 1) }}" class="form-input" min="1" required>
                            @error('urutan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Deskripsi -->
                <div class="form-section">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Deskripsi Layanan</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="deskripsi_singkat" class="form-label">
                                <i class="fas fa-align-left mr-1 text-blue-500"></i> Deskripsi Singkat
                                <span class="text-xs text-gray-500 ml-1">(maks. 500 karakter)</span>
                            </label>
                            <textarea name="deskripsi_singkat" id="deskripsi_singkat" class="form-input" rows="3" placeholder="Masukkan deskripsi singkat layanan" maxlength="500" required>{{ old('deskripsi_singkat') }}</textarea>
                            <div id="counter-singkat" class="character-counter">0/500 karakter</div>
                            @error('deskripsi_singkat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="deskripsi_lengkap" class="form-label">
                                <i class="fas fa-align-justify mr-1 text-blue-500"></i> Deskripsi Lengkap
                                <span class="text-xs text-gray-500 ml-1">(opsional)</span>
                            </label>
                            <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" class="form-input" rows="5" placeholder="Masukkan deskripsi lengkap layanan (opsional)">{{ old('deskripsi_lengkap') }}</textarea>
                            @error('deskripsi_lengkap')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Ikon -->
                <div class="form-section">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Ikon Layanan</h4>
                    <div class="form-group">
                        <label for="ikon" class="form-label">
                            <i class="fas fa-icons mr-1 text-blue-500"></i> Ikon Layanan
                            <span class="text-xs text-gray-500 ml-1">(Format: JPG, PNG)</span>
                        </label>
                        
                        <div class="photo-upload-area" id="photoUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="text-gray-600">Klik untuk memilih ikon atau seret dan lepas di sini</p>
                            <p class="text-sm text-gray-500 mt-1">Rekomendasi: 64x64 px untuk tampilan optimal</p>
                        </div>
                        
                        <input type="file" name="ikon" id="ikon" class="hidden" accept="image/jpeg,image/jpg,image/png" required>
                        <img id="photoPreview" class="photo-preview" src="#" alt="Preview Ikon">
                        
                        @error('ikon')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Status -->
                <div class="form-section">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Status Layanan</h4>
                    <div class="form-group">
                        <div class="checkbox-container">
                            <div class="custom-checkbox" id="customCheckbox">
                                <input type="checkbox" name="status_aktif" id="status_aktif" class="hidden" {{ old('status_aktif', 1) ? 'checked' : '' }}>
                            </div>
                            <span class="checkbox-label">Aktifkan layanan ini</span>
                        </div>
                        @error('status_aktif')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('layanan_kami.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Layanan
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
            // Character counter for deskripsi_singkat
            $('#deskripsi_singkat').on('input', function() {
                const maxLength = 500;
                const currentLength = $(this).val().length;
                const counter = $('#counter-singkat');
                
                counter.text(`${currentLength}/${maxLength} karakter`);
                
                // Update counter color based on length
                if (currentLength > maxLength * 0.9) {
                    counter.addClass('danger').removeClass('warning');
                } else if (currentLength > maxLength * 0.7) {
                    counter.addClass('warning').removeClass('danger');
                } else {
                    counter.removeClass('warning danger');
                }
            });
            
            // Initialize character counter
            $('#deskripsi_singkat').trigger('input');
            
            // Custom checkbox functionality
            $('#customCheckbox').on('click', function() {
                const checkbox = $('#status_aktif');
                const isChecked = checkbox.prop('checked');
                
                checkbox.prop('checked', !isChecked);
                $(this).toggleClass('checked', !isChecked);
            });
            
            // Initialize checkbox state
            if ($('#status_aktif').prop('checked')) {
                $('#customCheckbox').addClass('checked');
            }
            
            // Photo upload functionality
            $('#photoUploadArea').on('click', function() {
                $('#ikon').click();
            });
            
            $('#ikon').on('change', function(e) {
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
                    $('#ikon')[0].files = files;
                    $('#ikon').trigger('change');
                }
            });
            
            // Form validation before submission
            $('#layananForm').on('submit', function(e) {
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
                
                // Check character limit for deskripsi_singkat
                const deskripsiSingkat = $('#deskripsi_singkat').val();
                if (deskripsiSingkat.length > 500) {
                    isValid = false;
                    $('#deskripsi_singkat').addClass('border-red-500');
                    
                    if (!firstErrorField) {
                        firstErrorField = $('#deskripsi_singkat')[0];
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi dan periksa batas karakter.',
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