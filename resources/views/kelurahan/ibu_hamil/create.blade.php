<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Ibu Hamil - CSSR Kelurahan</title>
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
        
        .alert-warning {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }
        
        .alert-success {
            background-color: #f0fdf4;
            border-left: 4px solid #16a34a;
            color: #166534;
        }
        
        .gizi-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .gizi-badge.normal {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .gizi-badge.kurang {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .gizi-badge.berisiko {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .warna-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .warna-badge.sehat {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .warna-badge.waspada {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .warna-badge.bahaya {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .trimester-card {
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }
        
        .trimester-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .trimester-card.selected {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        
        .trimester-card.trimester-1 {
            background-color: #f0f9ff;
            border-left: 4px solid #0ea5e9;
        }
        
        .trimester-card.trimester-2 {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
        }
        
        .trimester-card.trimester-3 {
            background-color: #fef7ff;
            border-left: 4px solid #a855f7;
        }
        
        .intervensi-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
        }
        
        .intervensi-icon.gizi {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .intervensi-icon.medis {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .intervensi-icon.lainnya {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .intervensi-icon.tidak-ada {
            background-color: #f1f5f9;
            color: #64748b;
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
        
        .input-with-icon input {
            padding-left: 2.5rem;
        }
        
        .progress-bar {
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            border-radius: 4px;
            transition: width 0.3s ease;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Data Ibu Hamil</span></h1>
                    <p class="text-gray-600">Tambah data kehamilan baru untuk pemantauan kesehatan ibu</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('kelurahan.ibu_hamil.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Ibu Hamil
                    </a>
                </div>
            </div>
        </div>
        
        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        @if (session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <span>{{ session('warning') }}</span>
            </div>
        @endif
        
        <form action="{{ route('kelurahan.ibu_hamil.store') }}" method="POST" id="ibuHamilForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Kehamilan</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap data kehamilan ibu</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-baby mr-2"></i>
                        <span>Form Tambah Data Ibu Hamil - Kelurahan</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan akurat untuk pemantauan kesehatan ibu hamil yang optimal.
                    </p>
                </div>
                
                <!-- Data Ibu -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Ibu</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="ibu_id" class="form-label">
                                <i class="fas fa-female mr-1 text-blue-500"></i> Nama Ibu
                            </label>
                            <select name="ibu_id" id="ibu_id" class="form-input" required>
                                <option value="">-- Pilih Ibu --</option>
                                @foreach ($ibus as $ibu)
                                    <option value="{{ $ibu->id }}" data-source="{{ $ibu->source }}" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>
                                        {{ $ibu->nama }} ({{ $ibu->nik ?? '-' }}) 
                                        <span class="status-badge {{ $ibu->source == 'verified' ? 'verified' : 'pending' }}">
                                            {{ $ibu->source == 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
                                        </span>
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="ibu_source" id="ibu_source" value="{{ old('ibu_source') }}">
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
                
                <!-- Data Kehamilan -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Kehamilan</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar-check mr-1 text-blue-500"></i> Trimester
                            </label>
                            <div class="trimester-selector">
                                <div class="trimester-card trimester-1" data-value="Trimester 1">
                                    <div class="flex items-center">
                                        <i class="fas fa-1 text-sky-500 text-xl mr-3"></i>
                                        <div>
                                            <h5 class="font-medium text-gray-800">Trimester 1</h5>
                                            <p class="text-sm text-gray-600">Minggu 1-12</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="trimester-card trimester-2" data-value="Trimester 2">
                                    <div class="flex items-center">
                                        <i class="fas fa-2 text-emerald-500 text-xl mr-3"></i>
                                        <div>
                                            <h5 class="font-medium text-gray-800">Trimester 2</h5>
                                            <p class="text-sm text-gray-600">Minggu 13-27</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="trimester-card trimester-3" data-value="Trimester 3">
                                    <div class="flex items-center">
                                        <i class="fas fa-3 text-purple-500 text-xl mr-3"></i>
                                        <div>
                                            <h5 class="font-medium text-gray-800">Trimester 3</h5>
                                            <p class="text-sm text-gray-600">Minggu 28-40</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="trimester" id="trimester" value="{{ old('trimester') }}" required>
                            @error('trimester')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="usia_kehamilan" class="form-label">
                                <i class="fas fa-clock mr-1 text-blue-500"></i> Usia Kehamilan (minggu)
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-week input-icon"></i>
                                <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ old('usia_kehamilan') }}" min="1" max="40" class="form-input" placeholder="Masukkan usia kehamilan" required>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" id="kehamilanProgress" style="width: 0%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Minggu 1-40 dari kehamilan normal</div>
                            @error('usia_kehamilan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Fisik -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Fisik</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="berat" class="form-label">
                                <i class="fas fa-weight mr-1 text-blue-500"></i> Berat Badan (kg)
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-weight-scale input-icon"></i>
                                <input type="number" name="berat" id="berat" value="{{ old('berat') }}" step="0.1" class="form-input" placeholder="Masukkan berat badan" required>
                            </div>
                            @error('berat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tinggi" class="form-label">
                                <i class="fas fa-ruler-vertical mr-1 text-blue-500"></i> Tinggi Badan (cm)
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-ruler input-icon"></i>
                                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" step="0.1" class="form-input" placeholder="Masukkan tinggi badan" required>
                            </div>
                            @error('tinggi')
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
                            <label for="intervensi" class="form-label">
                                <i class="fas fa-hand-holding-medical mr-1 text-blue-500"></i> Intervensi
                            </label>
                            <select name="intervensi" id="intervensi" class="form-input" required>
                                <option value="" {{ old('intervensi') == '' ? 'selected' : '' }}>-- Pilih Intervensi --</option>
                                <option value="Tidak Ada" {{ old('intervensi') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                <option value="Gizi" {{ old('intervensi') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                                <option value="Konsultasi Medis" {{ old('intervensi') == 'Konsultasi Medis' ? 'selected' : '' }}>Konsultasi Medis</option>
                                <option value="Lainnya" {{ old('intervensi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('intervensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_gizi" class="form-label">
                                <i class="fas fa-apple-alt mr-1 text-blue-500"></i> Status Gizi
                            </label>
                            <select name="status_gizi" id="status_gizi" class="form-input" required>
                                <option value="" {{ old('status_gizi') == '' ? 'selected' : '' }}>-- Pilih Status Gizi --</option>
                                <option value="Normal" {{ old('status_gizi') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                <option value="Berisiko" {{ old('status_gizi') == 'Berisiko' ? 'selected' : '' }}>Berisiko</option>
                            </select>
                            @error('status_gizi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="warna_status_gizi" class="form-label">
                                <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Status Gizi
                            </label>
                            <select name="warna_status_gizi" id="warna_status_gizi" class="form-input" required>
                                <option value="" {{ old('warna_status_gizi') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                                <option value="Sehat" {{ old('warna_status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                <option value="Waspada" {{ old('warna_status_gizi') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                <option value="Bahaya" {{ old('warna_status_gizi') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                            </select>
                            @error('warna_status_gizi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('kelurahan.ibu_hamil.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data Ibu Hamil
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
                templateResult: function(data) {
                    if (!data.id) { return data.text; }
                    
                    var $result = $(
                        '<span>' + data.text + '</span>'
                    );
                    
                    return $result;
                }
            });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Set ibu_source value when ibu is selected
            $('#ibu_id').on('change', function() {
                var source = $(this).find('option:selected').data('source');
                $('#ibu_source').val(source);
            });

            // Set initial ibu_source value
            var initialSource = $('#ibu_id').find('option:selected').data('source');
            if (initialSource) {
                $('#ibu_source').val(initialSource);
            }

            // Trimester selection
            $('.trimester-card').on('click', function() {
                $('.trimester-card').removeClass('selected');
                $(this).addClass('selected');
                $('#trimester').val($(this).data('value'));
            });

            // Set initial trimester selection
            var initialTrimester = $('#trimester').val();
            if (initialTrimester) {
                $('.trimester-card[data-value="' + initialTrimester + '"]').addClass('selected');
            }

            // Update progress bar for usia kehamilan
            $('#usia_kehamilan').on('input', function() {
                var value = $(this).val();
                var percentage = (value / 40) * 100;
                $('#kehamilanProgress').css('width', percentage + '%');
                
                // Auto-select trimester based on usia kehamilan
                if (value >= 1 && value <= 12) {
                    $('.trimester-card').removeClass('selected');
                    $('.trimester-card[data-value="Trimester 1"]').addClass('selected');
                    $('#trimester').val('Trimester 1');
                } else if (value >= 13 && value <= 27) {
                    $('.trimester-card').removeClass('selected');
                    $('.trimester-card[data-value="Trimester 2"]').addClass('selected');
                    $('#trimester').val('Trimester 2');
                } else if (value >= 28 && value <= 40) {
                    $('.trimester-card').removeClass('selected');
                    $('.trimester-card[data-value="Trimester 3"]').addClass('selected');
                    $('#trimester').val('Trimester 3');
                }
            });

            // Set initial progress bar value
            var initialUsia = $('#usia_kehamilan').val();
            if (initialUsia) {
                var percentage = (initialUsia / 40) * 100;
                $('#kehamilanProgress').css('width', percentage + '%');
            }

            // Form validation before submission
            $('#ibuHamilForm').on('submit', function(e) {
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

            // Handle session messages with SweetAlert2
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3b82f6'
                });
            @endif
            
            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: '{{ session('warning') }}',
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