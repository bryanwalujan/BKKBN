<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Ibu Hamil - CSSR</title>
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
        
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 46px;
            padding: 0.75rem;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
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
            font-weight: 500;
        }
        
        .status-trimester-1 {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-trimester-2 {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-trimester-3 {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-intervensi {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .status-gizi-normal {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-gizi-kurang {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-gizi-berisiko {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-warna-sehat {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-warna-waspada {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-warna-bahaya {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .form-section {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #3b82f6;
        }
        
        .form-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            width: 0%;
            transition: width 0.5s ease;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
        
        .input-with-icon input, .input-with-icon select {
            padding-left: 40px;
        }
        
        .number-input-container {
            display: flex;
            align-items: center;
        }
        
        .number-input {
            text-align: center;
            border-left: none;
            border-right: none;
            border-radius: 0;
        }
        
        .number-btn {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .number-btn:hover {
            background-color: #e5e7eb;
        }
        
        .number-btn:first-child {
            border-radius: 0.5rem 0 0 0.5rem;
        }
        
        .number-btn:last-child {
            border-radius: 0 0.5rem 0.5rem 0;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Data Ibu Hamil</span></h1>
                    <p class="text-gray-600">Tambah data kehamilan baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('ibu_hamil.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Ibu Hamil
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
        
        @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            </div>
        @endif
        
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Form Data Ibu Hamil</h3>
                    <p class="text-gray-600 text-sm mt-1">Isi informasi data kehamilan dengan lengkap dan benar</p>
                </div>
                <div class="flex items-center text-sm text-blue-500">
                    <i class="fas fa-baby mr-2"></i>
                    <span>Data Kehamilan</span>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" id="formProgress"></div>
            </div>
            
            <form action="{{ route('ibu_hamil.store') }}" method="POST" id="ibuHamilForm">
                @csrf
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan sudah sesuai dengan kondisi ibu hamil.
                    </p>
                </div>
                
                <!-- Data Ibu Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-user text-blue-500"></i>
                        <span>Data Ibu</span>
                    </div>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="ibu_id" class="form-label">
                                <i class="fas fa-user mr-1 text-blue-500"></i> Nama Ibu
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-user input-icon"></i>
                                <select name="ibu_id" id="ibu_id" class="form-input" required>
                                    <option value="">-- Pilih Ibu --</option>
                                    @foreach ($ibus as $ibu)
                                        <option value="{{ $ibu->id }}" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ibu_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Kehamilan Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-baby text-blue-500"></i>
                        <span>Data Kehamilan</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="trimester" class="form-label">
                                <i class="fas fa-calendar-alt mr-1 text-blue-500"></i> Trimester
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-alt input-icon"></i>
                                <select name="trimester" id="trimester" class="form-input" required>
                                    <option value="" {{ old('trimester') == '' ? 'selected' : '' }}>-- Pilih Trimester --</option>
                                    <option value="Trimester 1" {{ old('trimester') == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                                    <option value="Trimester 2" {{ old('trimester') == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                                    <option value="Trimester 3" {{ old('trimester') == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                                </select>
                            </div>
                            @error('trimester')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="usia_kehamilan" class="form-label">
                                <i class="fas fa-clock mr-1 text-blue-500"></i> Usia Kehamilan (minggu)
                            </label>
                            <div class="number-input-container">
                                <button type="button" class="number-btn" id="decreaseUsia">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ old('usia_kehamilan', 0) }}" min="0" max="40" class="form-input number-input" required>
                                <button type="button" class="number-btn" id="increaseUsia">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @error('usia_kehamilan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Kesehatan Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-heartbeat text-blue-500"></i>
                        <span>Data Kesehatan</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="berat" class="form-label">
                                <i class="fas fa-weight mr-1 text-blue-500"></i> Berat (kg)
                            </label>
                            <div class="number-input-container">
                                <button type="button" class="number-btn" id="decreaseBerat">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="berat" id="berat" value="{{ old('berat', 0) }}" step="0.1" class="form-input number-input" required>
                                <button type="button" class="number-btn" id="increaseBerat">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @error('berat')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tinggi" class="form-label">
                                <i class="fas fa-ruler-vertical mr-1 text-blue-500"></i> Tinggi (cm)
                            </label>
                            <div class="number-input-container">
                                <button type="button" class="number-btn" id="decreaseTinggi">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi', 0) }}" step="0.1" class="form-input number-input" required>
                                <button type="button" class="number-btn" id="increaseTinggi">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @error('tinggi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Intervensi Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-stethoscope text-blue-500"></i>
                        <span>Data Intervensi</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="intervensi" class="form-label">
                                <i class="fas fa-hand-holding-medical mr-1 text-blue-500"></i> Intervensi
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-hand-holding-medical input-icon"></i>
                                <select name="intervensi" id="intervensi" class="form-input" required>
                                    <option value="" {{ old('intervensi') == '' ? 'selected' : '' }}>-- Pilih Intervensi --</option>
                                    <option value="Tidak Ada" {{ old('intervensi') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Gizi" {{ old('intervensi') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                                    <option value="Konsultasi Medis" {{ old('intervensi') == 'Konsultasi Medis' ? 'selected' : '' }}>Konsultasi Medis</option>
                                    <option value="Lainnya" {{ old('intervensi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            @error('intervensi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="status_gizi" class="form-label">
                                <i class="fas fa-apple-alt mr-1 text-blue-500"></i> Status Gizi
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-apple-alt input-icon"></i>
                                <select name="status_gizi" id="status_gizi" class="form-input" required>
                                    <option value="" {{ old('status_gizi') == '' ? 'selected' : '' }}>-- Pilih Status Gizi --</option>
                                    <option value="Normal" {{ old('status_gizi') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                    <option value="Berisiko" {{ old('status_gizi') == 'Berisiko' ? 'selected' : '' }}>Berisiko</option>
                                </select>
                            </div>
                            @error('status_gizi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="warna_status_gizi" class="form-label">
                                <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Status Gizi
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-palette input-icon"></i>
                                <select name="warna_status_gizi" id="warna_status_gizi" class="form-input" required>
                                    <option value="" {{ old('warna_status_gizi') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                                    <option value="Sehat" {{ old('warna_status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                    <option value="Waspada" {{ old('warna_status_gizi') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                    <option value="Bahaya" {{ old('warna_status_gizi') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                                </select>
                            </div>
                            @error('warna_status_gizi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('ibu_hamil.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
        
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
                placeholder: '-- Pilih Ibu --',
                allowClear: true,
                width: '100%'
            });
            
            $('#trimester').select2({
                placeholder: '-- Pilih Trimester --',
                allowClear: false,
                width: '100%',
                templateResult: formatTrimester,
                templateSelection: formatTrimester
            });
            
            $('#intervensi').select2({
                placeholder: '-- Pilih Intervensi --',
                allowClear: false,
                width: '100%'
            });
            
            $('#status_gizi').select2({
                placeholder: '-- Pilih Status Gizi --',
                allowClear: false,
                width: '100%',
                templateResult: formatStatusGizi,
                templateSelection: formatStatusGizi
            });
            
            $('#warna_status_gizi').select2({
                placeholder: '-- Pilih Warna Status Gizi --',
                allowClear: false,
                width: '100%',
                templateResult: formatWarnaStatus,
                templateSelection: formatWarnaStatus
            });

            // Format trimester dengan badge berwarna
            function formatTrimester(state) {
                if (!state.id) {
                    return state.text;
                }
                
                var statusClass = '';
                if (state.id === 'Trimester 1') {
                    statusClass = 'status-trimester-1';
                } else if (state.id === 'Trimester 2') {
                    statusClass = 'status-trimester-2';
                } else if (state.id === 'Trimester 3') {
                    statusClass = 'status-trimester-3';
                }
                
                if (statusClass) {
                    return $('<span class="status-badge ' + statusClass + '">' + state.text + '</span>');
                }
                
                return state.text;
            }

            // Format status gizi dengan badge berwarna
            function formatStatusGizi(state) {
                if (!state.id) {
                    return state.text;
                }
                
                var statusClass = '';
                if (state.id === 'Normal') {
                    statusClass = 'status-gizi-normal';
                } else if (state.id === 'Kurang Gizi') {
                    statusClass = 'status-gizi-kurang';
                } else if (state.id === 'Berisiko') {
                    statusClass = 'status-gizi-berisiko';
                }
                
                if (statusClass) {
                    return $('<span class="status-badge ' + statusClass + '">' + state.text + '</span>');
                }
                
                return state.text;
            }

            // Format warna status dengan badge berwarna
            function formatWarnaStatus(state) {
                if (!state.id) {
                    return state.text;
                }
                
                var statusClass = '';
                if (state.id === 'Sehat') {
                    statusClass = 'status-warna-sehat';
                } else if (state.id === 'Waspada') {
                    statusClass = 'status-warna-waspada';
                } else if (state.id === 'Bahaya') {
                    statusClass = 'status-warna-bahaya';
                }
                
                if (statusClass) {
                    return $('<span class="status-badge ' + statusClass + '">' + state.text + '</span>');
                }
                
                return state.text;
            }

            // Number input controls
            $('#increaseUsia').click(function() {
                var currentVal = parseInt($('#usia_kehamilan').val());
                if (currentVal < 40) {
                    $('#usia_kehamilan').val(currentVal + 1);
                }
            });
            
            $('#decreaseUsia').click(function() {
                var currentVal = parseInt($('#usia_kehamilan').val());
                if (currentVal > 0) {
                    $('#usia_kehamilan').val(currentVal - 1);
                }
            });
            
            $('#increaseBerat').click(function() {
                var currentVal = parseFloat($('#berat').val());
                $('#berat').val((currentVal + 0.1).toFixed(1));
            });
            
            $('#decreaseBerat').click(function() {
                var currentVal = parseFloat($('#berat').val());
                if (currentVal > 0) {
                    $('#berat').val((currentVal - 0.1).toFixed(1));
                }
            });
            
            $('#increaseTinggi').click(function() {
                var currentVal = parseFloat($('#tinggi').val());
                $('#tinggi').val((currentVal + 0.1).toFixed(1));
            });
            
            $('#decreaseTinggi').click(function() {
                var currentVal = parseFloat($('#tinggi').val());
                if (currentVal > 0) {
                    $('#tinggi').val((currentVal - 0.1).toFixed(1));
                }
            });

            // Update progress bar based on form completion
            function updateProgressBar() {
                var totalFields = 7; // Jumlah field yang harus diisi
                var filledFields = 0;
                
                // Cek setiap field yang required
                $('[required]').each(function() {
                    if ($(this).val()) {
                        filledFields++;
                    }
                });
                
                var progressPercentage = (filledFields / totalFields) * 100;
                $('#formProgress').css('width', progressPercentage + '%');
            }
            
            // Update progress bar saat form berubah
            $('input, select').on('change keyup', function() {
                updateProgressBar();
            });
            
            // Inisialisasi progress bar
            updateProgressBar();

            // Form validation sebelum submit
            $('#ibuHamilForm').on('submit', function(e) {
                var isValid = true;
                var errorFields = [];
                
                // Validasi field required
                $('[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        errorFields.push($(this).attr('name'));
                        $(this).addClass('border-red-500');
                    } else {
                        $(this).removeClass('border-red-500');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Form Tidak Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi.',
                        confirmButtonColor: '#3b82f6'
                    });
                    
                    // Scroll ke field pertama yang error
                    if (errorFields.length > 0) {
                        $('[name="' + errorFields[0] + '"]').focus();
                    }
                }
            });

            // Restore old values if available
            @if(old('ibu_id'))
                $('#ibu_id').val('{{ old('ibu_id') }}').trigger('change');
            @endif
            
            @if(old('trimester'))
                $('#trimester').val('{{ old('trimester') }}').trigger('change');
            @endif
            
            @if(old('intervensi'))
                $('#intervensi').val('{{ old('intervensi') }}').trigger('change');
            @endif
            
            @if(old('status_gizi'))
                $('#status_gizi').val('{{ old('status_gizi') }}').trigger('change');
            @endif
            
            @if(old('warna_status_gizi'))
                $('#warna_status_gizi').val('{{ old('warna_status_gizi') }}').trigger('change');
            @endif
        });
    </script>
</body>
</html>