<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Remaja Putri - CSSR Kelurahan</title>
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
        
        .info-box {
            background-color: #fdf2f8;
            border-left: 4px solid #ec4899;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        
        .info-box p {
            margin: 0;
            color: #be185d;
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
            background: linear-gradient(90deg, #ec4899, #8b5cf6);
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
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
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
        
        .status-badge.tidak-anemia {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.anemia-ringan {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-badge.anemia-sedang {
            background-color: #fed7aa;
            color: #c2410c;
        }
        
        .status-badge.anemia-berat {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .ttd-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .ttd-badge.rutin {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .ttd-badge.tidak-rutin {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .ttd-badge.tidak-konsumsi {
            background-color: #fee2e2;
            color: #991b1b;
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
            border-color: #ec4899;
            background-color: #fdf2f8;
        }
        
        .photo-upload-area i {
            font-size: 2rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }
        
        .photo-upload-area.dragover {
            border-color: #ec4899;
            background-color: #fdf2f8;
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
        
        .readonly-input {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }
        
        .current-photo {
            width: 150px;
            height: 150px;
            border-radius: 0.5rem;
            object-fit: cover;
            border: 2px solid #d1d5db;
            margin-top: 1rem;
        }
        
        .source-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
            background-color: #dbeafe;
            color: #1e40af;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Data Remaja Putri</span></h1>
                    <div class="flex items-center gap-4">
                        <p class="text-gray-600">Perbarui data remaja putri dalam sistem CSSR</p>
                        <span class="source-badge">
                            <i class="fas fa-database mr-1"></i>
                            {{ $source === 'verified' ? 'Terverifikasi' : 'Pending' }}
                        </span>
                    </div>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => $source]) }}" class="text-pink-500 hover:text-pink-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Remaja Putri
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
        
        @if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <div>
                        <p class="font-medium">{{ $kartuKeluargas->isEmpty() ? 'Tidak ada data Kartu Keluarga yang terverifikasi. ' : '' }}</p>
                        <p>{{ !$kecamatan || !$kelurahan ? 'Data kecamatan atau kelurahan tidak ditemukan. ' : '' }}</p>
                        <p class="mt-1">Silakan tambahkan data terlebih dahulu.</p>
                    </div>
                </div>
            </div>
        @else
            <form action="{{ route('kelurahan.remaja_putri.update', ['id' => $remajaPutri->id, 'source' => $source]) }}" method="POST" enctype="multipart/form-data" id="remajaPutriForm">
                @csrf
                @method('PUT')
                
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">Data Remaja Putri</h3>
                            <p class="text-gray-600 text-sm mt-1">Perbarui informasi lengkap data remaja putri</p>
                        </div>
                        <div class="flex items-center text-sm text-pink-500">
                            <i class="fas fa-edit mr-2"></i>
                            <span>Form Edit Remaja Putri - Kelurahan</span>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <p>
                            <i class="fas fa-info-circle"></i> 
                            Pastikan data yang diperbarui akurat dan lengkap untuk pemantauan kesehatan remaja putri yang optimal.
                        </p>
                    </div>
                    
                    <!-- Data Wilayah -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Data Wilayah</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="kecamatan_id" class="form-label">
                                    <i class="fas fa-map-marker-alt mr-1 text-pink-500"></i> Kecamatan
                                </label>
                                <input type="text" value="{{ $kecamatan->nama_kecamatan }}" class="form-input readonly-input" readonly>
                                <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id }}">
                                @error('kecamatan_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="kelurahan_id" class="form-label">
                                    <i class="fas fa-map-pin mr-1 text-pink-500"></i> Kelurahan
                                </label>
                                <input type="text" value="{{ $kelurahan->nama_kelurahan }}" class="form-input readonly-input" readonly>
                                <input type="hidden" name="kelurahan_id" value="{{ $kelurahan->id }}">
                                @error('kelurahan_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Keluarga -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Data Keluarga</h4>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="kartu_keluarga_id" class="form-label">
                                    <i class="fas fa-id-card-alt mr-1 text-pink-500"></i> Kartu Keluarga
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
                                <label for="nama" class="form-label">
                                    <i class="fas fa-user mr-1 text-pink-500"></i> Nama Lengkap
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $remajaPutri->nama) }}" class="form-input" placeholder="Masukkan nama lengkap remaja putri" required>
                                @error('nama')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="sekolah" class="form-label">
                                    <i class="fas fa-school mr-1 text-pink-500"></i> Sekolah
                                </label>
                                <input type="text" name="sekolah" id="sekolah" value="{{ old('sekolah', $remajaPutri->sekolah) }}" class="form-input" placeholder="Masukkan nama sekolah" required>
                                @error('sekolah')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="kelas" class="form-label">
                                    <i class="fas fa-graduation-cap mr-1 text-pink-500"></i> Kelas
                                </label>
                                <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $remajaPutri->kelas) }}" class="form-input" placeholder="Masukkan kelas" required>
                                @error('kelas')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="umur" class="form-label">
                                    <i class="fas fa-birthday-cake mr-1 text-pink-500"></i> Umur
                                </label>
                                <input type="number" name="umur" id="umur" value="{{ old('umur', $remajaPutri->umur) }}" min="10" max="19" class="form-input" placeholder="10-19" required>
                                @error('umur')
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
                                <label for="status_anemia" class="form-label">
                                    <i class="fas fa-tint mr-1 text-pink-500"></i> Status Anemia
                                </label>
                                <select name="status_anemia" id="status_anemia" class="form-input" required>
                                    <option value="" {{ old('status_anemia', $remajaPutri->status_anemia) == '' ? 'selected' : '' }}>-- Pilih Status Anemia --</option>
                                    <option value="Tidak Anemia" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Tidak Anemia' ? 'selected' : '' }}>Tidak Anemia</option>
                                    <option value="Anemia Ringan" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Anemia Ringan' ? 'selected' : '' }}>Anemia Ringan</option>
                                    <option value="Anemia Sedang" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Anemia Sedang' ? 'selected' : '' }}>Anemia Sedang</option>
                                    <option value="Anemia Berat" {{ old('status_anemia', $remajaPutri->status_anemia) == 'Anemia Berat' ? 'selected' : '' }}>Anemia Berat</option>
                                </select>
                                @error('status_anemia')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="konsumsi_ttd" class="form-label">
                                    <i class="fas fa-pills mr-1 text-pink-500"></i> Konsumsi TTD
                                </label>
                                <select name="konsumsi_ttd" id="konsumsi_ttd" class="form-input" required>
                                    <option value="" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == '' ? 'selected' : '' }}>-- Pilih Konsumsi TTD --</option>
                                    <option value="Rutin" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == 'Rutin' ? 'selected' : '' }}>Rutin</option>
                                    <option value="Tidak Rutin" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == 'Tidak Rutin' ? 'selected' : '' }}>Tidak Rutin</option>
                                    <option value="Tidak Konsumsi" {{ old('konsumsi_ttd', $remajaPutri->konsumsi_ttd) == 'Tidak Konsumsi' ? 'selected' : '' }}>Tidak Konsumsi</option>
                                </select>
                                @error('konsumsi_ttd')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upload Foto -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 section-title">Foto Remaja Putri</h4>
                        <div class="form-group">
                            <label for="foto" class="form-label">
                                <i class="fas fa-camera mr-1 text-pink-500"></i> Foto Remaja Putri
                            </label>
                            
                            @if ($remajaPutri->foto)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                    <img src="{{ Storage::url($remajaPutri->foto) }}" alt="Foto Remaja Putri" class="current-photo">
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Unggah foto baru untuk mengganti foto saat ini:</p>
                            @endif
                            
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
                        <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => $source]) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui Data Remaja Putri
                        </button>
                    </div>
                </div>
            </form>
        @endif
        
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
                    url: '{{ route("kelurahan.remaja_putri.getKartuKeluarga") }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kartu_keluarga_id').empty();
                        $('#kartu_keluarga_id').append('<option value="">-- Pilih Kartu Keluarga --</option>');
                        $.each(data, function(index, kk) {
                            var text = `${kk.no_kk} - ${kk.kepala_keluarga}`;
                            var selected = kk.id == '{{ old('kartu_keluarga_id', $remajaPutri->kartu_keluarga_id) }}' ? 'selected' : '';
                            $('#kartu_keluarga_id').append(`<option value="${kk.id}" ${selected}>${text}</option>`);
                        });
                        $('#kartu_keluarga_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                            confirmButtonColor: '#ec4899'
                        });
                    }
                });
            }

            function formatKartuKeluarga(kartuKeluarga) {
                if (!kartuKeluarga.id) {
                    return kartuKeluarga.text;
                }
                
                var $wrapper = $(
                    '<div class="flex justify-between items-center w-full">' +
                        '<span>' + kartuKeluarga.text + '</span>' +
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
            $('#remajaPutriForm').on('submit', function(e) {
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
                        confirmButtonColor: '#ec4899'
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
                    confirmButtonColor: '#ec4899'
                });
            @endif
        });
    </script>
</body>
</html>