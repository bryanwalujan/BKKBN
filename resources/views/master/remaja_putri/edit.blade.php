<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Remaja Putri - CSSR</title>
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
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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
            background-color: #8b5cf6;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.3);
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
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .step-badge {
            background-color: #f3f4f6;
            color: #6b7280;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f9fafb;
            text-align: center;
        }
        
        .file-upload-label:hover {
            border-color: #8b5cf6;
            background-color: #faf5ff;
        }
        
        .file-upload-icon {
            font-size: 2rem;
            color: #8b5cf6;
            margin-bottom: 0.5rem;
        }
        
        .file-upload-text {
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .preview-container {
            margin-top: 1rem;
        }
        
        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .current-photo-container {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
        }
        
        .current-photo-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single {
            height: 46px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            outline: none;
        }
        
        .success-badge {
            background-color: #d1fae5;
            color: #065f46;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Data Remaja Putri</span></h1>
                    <p class="text-gray-600">Perbarui data remaja putri dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('remaja_putri.index') }}" class="text-purple-500 hover:text-purple-700 mr-4 flex items-center">
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
        
        @if ($kartuKeluargas->isEmpty() || $kecamatans->isEmpty())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>
                        {{ $kartuKeluargas->isEmpty() ? 'Tidak ada data Kartu Keluarga. ' : '' }}
                        {{ $kecamatans->isEmpty() ? 'Tidak ada data Kecamatan. ' : '' }}
                        Silakan tambahkan data terlebih dahulu.
                    </span>
                </div>
            </div>
        @else
            <form action="{{ route('remaja_putri.update', $remajaPutri->id) }}" method="POST" enctype="multipart/form-data" id="remajaPutriForm">
                @csrf
                @method('PUT')
                
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <!-- Section Header -->
                    <div class="section-header">
                        <div>
                            <h3 class="section-title">
                                <i class="fas fa-user-edit text-purple-500"></i> Edit Data Remaja Putri
                            </h3>
                            <p class="section-subtitle">Perbarui informasi lengkap remaja putri</p>
                        </div>
                        <div class="success-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>ID: {{ $remajaPutri->id }}</span>
                        </div>
                    </div>
                    
                    <!-- Informasi Box -->
                    <div class="info-box">
                        <p>
                            <i class="fas fa-lightbulb"></i> 
                            Pastikan data yang diperbarui akurat dan sesuai dengan dokumen resmi.
                        </p>
                    </div>
                    
                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kecamatan -->
                        <div>
                            <label for="kecamatan_id" class="form-label">
                                <i class="fas fa-map-marker-alt mr-1 text-purple-500"></i> Kecamatan
                            </label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-input" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $remajaPutri->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Kelurahan -->
                        <div>
                            <label for="kelurahan_id" class="form-label">
                                <i class="fas fa-map-marker mr-1 text-purple-500"></i> Kelurahan
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
                        
                        <!-- Kartu Keluarga -->
                        <div class="md:col-span-2">
                            <label for="kartu_keluarga_id" class="form-label">
                                <i class="fas fa-address-card mr-1 text-purple-500"></i> Kartu Keluarga
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
                        
                        <!-- Nama -->
                        <div>
                            <label for="nama" class="form-label">
                                <i class="fas fa-user mr-1 text-purple-500"></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $remajaPutri->nama) }}" class="form-input" placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Sekolah -->
                        <div>
                            <label for="sekolah" class="form-label">
                                <i class="fas fa-school mr-1 text-purple-500"></i> Sekolah
                            </label>
                            <input type="text" name="sekolah" id="sekolah" value="{{ old('sekolah', $remajaPutri->sekolah) }}" class="form-input" placeholder="Masukkan nama sekolah" required>
                            @error('sekolah')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Kelas -->
                        <div>
                            <label for="kelas" class="form-label">
                                <i class="fas fa-graduation-cap mr-1 text-purple-500"></i> Kelas
                            </label>
                            <input type="text" name="kelas" id="kelas" value="{{ old('kelas', $remajaPutri->kelas) }}" class="form-input" placeholder="Masukkan kelas" required>
                            @error('kelas')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Umur -->
                        <div>
                            <label for="umur" class="form-label">
                                <i class="fas fa-birthday-cake mr-1 text-purple-500"></i> Umur
                            </label>
                            <input type="number" name="umur" id="umur" value="{{ old('umur', $remajaPutri->umur) }}" min="10" max="19" class="form-input" placeholder="Masukkan umur (10-19)" required>
                            @error('umur')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Status Anemia -->
                        <div>
                            <label for="status_anemia" class="form-label">
                                <i class="fas fa-heartbeat mr-1 text-purple-500"></i> Status Anemia
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
                        
                        <!-- Konsumsi TTD -->
                        <div>
                            <label for="konsumsi_ttd" class="form-label">
                                <i class="fas fa-pills mr-1 text-purple-500"></i> Konsumsi TTD
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
                        
                        <!-- Foto -->
                        <div class="md:col-span-2">
                            <!-- Current Photo -->
                            @if ($remajaPutri->foto)
                                <div class="current-photo-container">
                                    <div class="current-photo-label">
                                        <i class="fas fa-image text-purple-500"></i> Foto Saat Ini
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <img src="{{ Storage::url($remajaPutri->foto) }}" alt="Foto Remaja Putri" class="w-16 h-16 object-cover rounded border">
                                        <div>
                                            <p class="text-sm text-gray-600">Foto yang saat ini tersimpan</p>
                                            <p class="text-xs text-gray-500">Klik tombol di bawah untuk mengganti foto</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <label class="form-label">
                                <i class="fas fa-camera mr-1 text-purple-500"></i> 
                                {{ $remajaPutri->foto ? 'Ganti Foto' : 'Unggah Foto' }}
                            </label>
                            <div class="file-upload">
                                <label for="foto" class="file-upload-label">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div class="file-upload-text">
                                        <span class="font-medium text-purple-600">Klik untuk mengunggah foto</span>
                                        <p class="mt-1">atau seret dan lepas file di sini</p>
                                        <p class="text-xs mt-2">PNG, JPG, JPEG (Maks. 2MB)</p>
                                    </div>
                                </label>
                                <input type="file" name="foto" id="foto" class="file-upload-input" accept="image/*">
                            </div>
                            @error('foto')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            
                            <!-- Preview Image -->
                            <div class="preview-container" id="previewContainer" style="display: none;">
                                <p class="text-sm text-gray-600 mb-2">Pratinjau foto baru:</p>
                                <img id="previewImage" class="preview-image" src="#" alt="Pratinjau foto">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('remaja_putri.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui Data
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
            
            $('#status_anemia').select2({
                placeholder: '-- Pilih Status Anemia --',
                allowClear: false,
                width: '100%'
            });
            
            $('#konsumsi_ttd').select2({
                placeholder: '-- Pilih Konsumsi TTD --',
                allowClear: false,
                width: '100%'
            });

            // Load initial kelurahans and kartu keluarga
            var initialKecamatanId = '{{ old('kecamatan_id', $remajaPutri->kecamatan_id) }}';
            var initialKelurahanId = '{{ old('kelurahan_id', $remajaPutri->kelurahan_id) }}';
            var initialKartuKeluargaId = '{{ old('kartu_keluarga_id', $remajaPutri->kartu_keluarga_id) }}';
            
            if (initialKecamatanId) {
                $.ajax({
                    url: '/kelurahans/by-kecamatan/' + initialKecamatanId,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function() {
                        // Show loading state
                        $('#kelurahan_id').prop('disabled', true);
                    },
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == initialKelurahanId ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').prop('disabled', false).trigger('change');

                        // Load kartu keluarga for initial kecamatan and kelurahan
                        if (initialKelurahanId) {
                            $.ajax({
                                url: '/kartu-keluarga/by-kecamatan-kelurahan?kecamatan_id=' + initialKecamatanId + '&kelurahan_id=' + initialKelurahanId,
                                type: 'GET',
                                dataType: 'json',
                                beforeSend: function() {
                                    // Show loading state
                                    $('#kartu_keluarga_id').prop('disabled', true);
                                },
                                success: function(data) {
                                    $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>');
                                    if (data.length === 0) {
                                        $('#kartu_keluarga_id').after('<div class="mt-2 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700"><i class="fas fa-exclamation-triangle mr-2"></i>Tidak ada data Kartu Keluarga. <a href="{{ route('kartu_keluarga.create') }}" class="font-medium underline">Tambah Kartu Keluarga</a> terlebih dahulu.</div>');
                                    }
                                    $.each(data, function(index, kk) {
                                        var selected = kk.id == initialKartuKeluargaId ? 'selected' : '';
                                        $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                                    });
                                    $('#kartu_keluarga_id').prop('disabled', false).trigger('change');
                                },
                                error: function(xhr) {
                                    console.error('Gagal mengambil data kartu keluarga:', xhr);
                                    $('#kartu_keluarga_id').prop('disabled', false);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Gagal memuat data kartu keluarga. Silakan coba lagi.',
                                        confirmButtonColor: '#8b5cf6'
                                    });
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Gagal mengambil data kelurahan:', xhr);
                        $('#kelurahan_id').prop('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat data kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#8b5cf6'
                        });
                    }
                });
            }

            // Fetch kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>').trigger('change');
                $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>').trigger('change');

                if (kecamatanId) {
                    $.ajax({
                        url: '/kelurahans/by-kecamatan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            // Show loading state
                            $('#kelurahan_id').prop('disabled', true);
                        },
                        success: function(data) {
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').prop('disabled', false).trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kelurahan:', xhr);
                            $('#kelurahan_id').prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#8b5cf6'
                            });
                        }
                    });
                }
            });

            // Fetch kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $(this).val();
                $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>').trigger('change');

                if (kecamatanId && kelurahanId) {
                    $.ajax({
                        url: '/kartu-keluarga/by-kecamatan-kelurahan?kecamatan_id=' + kecamatanId + '&kelurahan_id=' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        beforeSend: function() {
                            // Show loading state
                            $('#kartu_keluarga_id').prop('disabled', true);
                        },
                        success: function(data) {
                            if (data.length === 0) {
                                $('#kartu_keluarga_id').after('<div class="mt-2 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700"><i class="fas fa-exclamation-triangle mr-2"></i>Tidak ada data Kartu Keluarga. <a href="{{ route('kartu_keluarga.create') }}" class="font-medium underline">Tambah Kartu Keluarga</a> terlebih dahulu.</div>');
                            }
                            $.each(data, function(index, kk) {
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                            $('#kartu_keluarga_id').prop('disabled', false).trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kartu keluarga:', xhr);
                            $('#kartu_keluarga_id').prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data kartu keluarga. Silakan coba lagi.',
                                confirmButtonColor: '#8b5cf6'
                            });
                        }
                    });
                }
            });

            // Preview image when file is selected
            $('#foto').on('change', function() {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                        $('#previewContainer').show();
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    $('#previewContainer').hide();
                }
            });

            // Form validation before submission
            $('#remajaPutriForm').on('submit', function(e) {
                var isValid = true;
                var errorFields = [];
                
                // Check required fields
                $('select[required], input[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        errorFields.push($(this).attr('name'));
                        $(this).addClass('border-red-500');
                    } else {
                        $(this).removeClass('border-red-500');
                    }
                });
                
                // Check file size if file is selected
                var fileInput = $('#foto')[0];
                if (fileInput.files.length > 0) {
                    var fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
                    if (fileSize > 2) {
                        isValid = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB. Silakan pilih file yang lebih kecil.',
                            confirmButtonColor: '#8b5cf6'
                        });
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi.',
                        confirmButtonColor: '#8b5cf6'
                    });
                }
            });
        });

        // Handle session error with SweetAlert2
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#8b5cf6'
            });
        @endif
    </script>
</body>
</html>