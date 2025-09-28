<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Ibu Menyusui - CSSR Kelurahan</title>
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
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
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
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1.5rem;
        }
        
        .info-box p {
            margin: 0;
            color: #1e40af;
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
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
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
        
        .status-badge.verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .warna-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .warna-badge.hijau {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .warna-badge.kuning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .warna-badge.merah {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-error {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            color: #991b1b;
        }
        
        .alert-success {
            background-color: #f0fdf4;
            border-left: 4px solid #16a34a;
            color: #166534;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
        
        .input-with-icon input, .input-with-icon select {
            padding-left: 2.5rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }
        
        .stat-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .stat-card p {
            opacity: 0.9;
            font-size: 0.875rem;
        }
        
        .edit-indicator {
            display: inline-flex;
            align-items: center;
            background-color: #fef3c7;
            color: #92400e;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        
        .edit-indicator i {
            margin-right: 0.5rem;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Data Ibu Menyusui</span></h1>
                    <p class="text-gray-600">Perbarui data ibu menyusui dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('kelurahan.ibu_menyusui.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Ibu Menyusui
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Edit Indicator -->
        <div class="edit-indicator">
            <i class="fas fa-edit"></i>
            <span>Anda sedang mengedit data ibu menyusui - 
                @if($source == 'verified')
                    <span class="font-semibold">Data Terverifikasi</span>
                @else
                    <span class="font-semibold">Data Menunggu Verifikasi</span>
                @endif
            </span>
        </div>
        
        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card">
                <i class="fas fa-female"></i>
                <h3>{{ $ibus->count() }}</h3>
                <p>Total Ibu Tersedia</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <h3>{{ $ibus->where('source', 'verified')->count() }}</h3>
                <p>Ibu Terverifikasi</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <h3>{{ $ibus->where('source', 'pending')->count() }}</h3>
                <p>Menunggu Verifikasi</p>
            </div>
        </div>
        
        <form action="{{ route('kelurahan.ibu_menyusui.update', [$ibuMenyusui->id, $source]) }}" method="POST" id="ibuMenyusuiForm">
            @csrf
            @method('PUT')
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Ibu Menyusui</h3>
                        <p class="text-gray-600 text-sm mt-1">Perbarui informasi lengkap data ibu menyusui</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Form Edit Ibu Menyusui - Kelurahan</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang diperbarui akurat dan lengkap untuk pemantauan kesehatan ibu dan bayi yang optimal.
                    </p>
                </div>
                
                <!-- Data Ibu -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Ibu</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ibu_id" class="form-label">
                                <i class="fas fa-female mr-1 text-blue-500"></i> Pilih Ibu
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <select name="ibu_id" id="ibu_id" class="form-input" required>
                                    <option value="">-- Pilih Ibu --</option>
                                    @foreach ($ibus as $ibu)
                                        <option value="{{ $ibu->id }}" data-source="{{ $ibu->source }}" 
                                            {{ old('ibu_id', $source == 'verified' ? $ibuMenyusui->ibu_id : $ibuMenyusui->pending_ibu_id) == $ibu->id ? 'selected' : '' }}>
                                            {{ $ibu->nama }} ({{ $ibu->nik ?? '-' }}) 
                                            <span class="status-badge {{ $ibu->source == 'verified' ? 'verified' : 'pending' }}">
                                                {{ $ibu->source == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                                            </span>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="ibu_source" id="ibu_source" value="{{ old('ibu_source', $source) }}">
                            @error('ibu_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            @error('ibu_source')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Menyusui -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Menyusui</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="status_menyusui" class="form-label">
                                <i class="fas fa-baby-carriage mr-1 text-blue-500"></i> Status Menyusui
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-list input-icon"></i>
                                <select name="status_menyusui" id="status_menyusui" class="form-input" required>
                                    <option value="" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                                    <option value="Eksklusif" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                                    <option value="Non-Eksklusif" {{ old('status_menyusui', $ibuMenyusui->status_menyusui) == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                                </select>
                            </div>
                            @error('status_menyusui')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="frekuensi_menyusui" class="form-label">
                                <i class="fas fa-sync-alt mr-1 text-blue-500"></i> Frekuensi Menyusui (kali/hari)
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-redo input-icon"></i>
                                <input type="number" name="frekuensi_menyusui" id="frekuensi_menyusui" value="{{ old('frekuensi_menyusui', $ibuMenyusui->frekuensi_menyusui) }}" min="0" max="24" class="form-input" required>
                            </div>
                            @error('frekuensi_menyusui')
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
                            <label for="kondisi_ibu" class="form-label">
                                <i class="fas fa-heartbeat mr-1 text-blue-500"></i> Kondisi Ibu
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-stethoscope input-icon"></i>
                                <input type="text" name="kondisi_ibu" id="kondisi_ibu" value="{{ old('kondisi_ibu', $ibuMenyusui->kondisi_ibu) }}" class="form-input" placeholder="Masukkan kondisi kesehatan ibu" required>
                            </div>
                            @error('kondisi_ibu')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="warna_kondisi" class="form-label">
                                <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Kondisi
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-tint input-icon"></i>
                                <select name="warna_kondisi" id="warna_kondisi" class="form-input" required>
                                    <option value="" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                                    <option value="Hijau (success)" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == 'Hijau (success)' ? 'selected' : '' }}>
                                        Hijau (success) <span class="warna-badge hijau">Normal</span>
                                    </option>
                                    <option value="Kuning (warning)" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == 'Kuning (warning)' ? 'selected' : '' }}>
                                        Kuning (warning) <span class="warna-badge kuning">Perhatian</span>
                                    </option>
                                    <option value="Merah (danger)" {{ old('warna_kondisi', $ibuMenyusui->warna_kondisi) == 'Merah (danger)' ? 'selected' : '' }}>
                                        Merah (danger) <span class="warna-badge merah">Darurat</span>
                                    </option>
                                </select>
                            </div>
                            @error('warna_kondisi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="berat" class="form-label">
                                <i class="fas fa-weight mr-1 text-blue-500"></i> Berat (kg)
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-balance-scale input-icon"></i>
                                <input type="number" name="berat" id="berat" value="{{ old('berat', $ibuMenyusui->berat) }}" step="0.1" class="form-input" placeholder="Contoh: 55.5" required>
                            </div>
                            @error('berat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tinggi" class="form-label">
                                <i class="fas fa-ruler-vertical mr-1 text-blue-500"></i> Tinggi (cm)
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-text-height input-icon"></i>
                                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi', $ibuMenyusui->tinggi) }}" step="0.1" class="form-input" placeholder="Contoh: 160.5" required>
                            </div>
                            @error('tinggi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('kelurahan.ibu_menyusui.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Data Ibu Menyusui
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
            $('#ibu_id').select2({
                placeholder: 'Pilih Ibu',
                allowClear: true,
                width: '100%',
                templateResult: formatIbuOption,
                templateSelection: formatIbuOption
            });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Format ibu option with badge
            function formatIbuOption(ibu) {
                if (!ibu.id) {
                    return ibu.text;
                }
                
                var $option = $('<span>' + ibu.text + '</span>');
                return $option;
            }

            // Update ibu source when selection changes
            $('#ibu_id').on('change', function() {
                var source = $(this).find('option:selected').data('source');
                $('#ibu_source').val(source);
            });

            // Set initial ibu source
            var initialSource = $('#ibu_id').find('option:selected').data('source');
            if (initialSource) {
                $('#ibu_source').val(initialSource);
            }

            // Form validation before submission
            $('#ibuMenyusuiForm').on('submit', function(e) {
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
            
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3b82f6'
                });
            @endif
        });
    </script>
</body>
</html>