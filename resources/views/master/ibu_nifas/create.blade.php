<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Ibu Nifas - CSSR</title>
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
        
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 46px;
            padding: 0.75rem;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
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
        
        .status-hijau {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-kuning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-merah {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .form-section {
            background-color: #fdf2f8;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #ec4899;
        }
        
        .form-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #831843;
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
            background: linear-gradient(90deg, #ec4899, #8b5cf6);
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
        
        .warna-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .warna-hijau {
            background-color: #10b981;
        }
        
        .warna-kuning {
            background-color: #f59e0b;
        }
        
        .warna-merah {
            background-color: #ef4444;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Data Ibu Nifas</span></h1>
                    <p class="text-gray-600">Tambah data nifas baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('ibu_nifas.index') }}" class="text-pink-500 hover:text-pink-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Ibu Nifas
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
                    <h3 class="text-xl font-semibold text-gray-800">Form Data Ibu Nifas</h3>
                    <p class="text-gray-600 text-sm mt-1">Isi informasi data nifas dengan lengkap dan benar</p>
                </div>
                <div class="flex items-center text-sm text-pink-500">
                    <i class="fas fa-heart mr-2"></i>
                    <span>Data Nifas</span>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" id="formProgress"></div>
            </div>
            
            <form action="{{ route('ibu_nifas.store') }}" method="POST" id="ibuNifasForm">
                @csrf
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Masa nifas adalah periode setelah persalinan yang berlangsung selama 6 minggu (42 hari).
                    </p>
                </div>
                
                <!-- Data Ibu Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-user text-pink-500"></i>
                        <span>Data Ibu</span>
                    </div>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="ibu_id" class="form-label">
                                <i class="fas fa-user mr-1 text-pink-500"></i> Nama Ibu
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
                
                <!-- Data Nifas Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-heartbeat text-pink-500"></i>
                        <span>Data Nifas</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="hari_nifas" class="form-label">
                                <i class="fas fa-calendar-day mr-1 text-pink-500"></i> Hari ke-Nifas
                            </label>
                            <div class="number-input-container">
                                <button type="button" class="number-btn" id="decreaseHari">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" name="hari_nifas" id="hari_nifas" value="{{ old('hari_nifas', 0) }}" min="0" max="42" class="form-input number-input" required>
                                <button type="button" class="number-btn" id="increaseHari">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">Masa nifas: 0-42 hari</div>
                            @error('hari_nifas')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="kondisi_kesehatan" class="form-label">
                                <i class="fas fa-heart mr-1 text-pink-500"></i> Kondisi Kesehatan
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-heart input-icon"></i>
                                <input type="text" name="kondisi_kesehatan" id="kondisi_kesehatan" value="{{ old('kondisi_kesehatan') }}" class="form-input" placeholder="Contoh: Kondisi stabil, tekanan darah normal" required>
                            </div>
                            @error('kondisi_kesehatan')
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
                        <i class="fas fa-stethoscope text-pink-500"></i>
                        <span>Data Kesehatan</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="berat" class="form-label">
                                <i class="fas fa-weight mr-1 text-pink-500"></i> Berat (kg)
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
                                <i class="fas fa-ruler-vertical mr-1 text-pink-500"></i> Tinggi (cm)
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
                
                <!-- Data Kondisi Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-palette text-pink-500"></i>
                        <span>Status Kondisi</span>
                    </div>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="warna_kondisi" class="form-label">
                                <i class="fas fa-tint mr-1 text-pink-500"></i> Warna Kondisi
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-tint input-icon"></i>
                                <select name="warna_kondisi" id="warna_kondisi" class="form-input" required>
                                    <option value="" {{ old('warna_kondisi') == '' ? 'selected' : '' }}>-- Pilih Warna Kondisi --</option>
                                    <option value="Hijau (success)" {{ old('warna_kondisi') == 'Hijau (success)' ? 'selected' : '' }}>Hijau (Kondisi Baik)</option>
                                    <option value="Kuning (warning)" {{ old('warna_kondisi') == 'Kuning (warning)' ? 'selected' : '' }}>Kuning (Perlu Perhatian)</option>
                                    <option value="Merah (danger)" {{ old('warna_kondisi') == 'Merah (danger)' ? 'selected' : '' }}>Merah (Kondisi Kritis)</option>
                                </select>
                            </div>
                            @error('warna_kondisi')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('ibu_nifas.index') }}" class="btn btn-secondary">
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
            
            $('#warna_kondisi').select2({
                placeholder: '-- Pilih Warna Kondisi --',
                allowClear: false,
                width: '100%',
                templateResult: formatWarnaKondisi,
                templateSelection: formatWarnaKondisi
            });

            // Format warna kondisi dengan badge berwarna
            function formatWarnaKondisi(state) {
                if (!state.id) {
                    return state.text;
                }
                
                var statusClass = '';
                var indicatorClass = '';
                if (state.id === 'Hijau (success)') {
                    statusClass = 'status-hijau';
                    indicatorClass = 'warna-hijau';
                } else if (state.id === 'Kuning (warning)') {
                    statusClass = 'status-kuning';
                    indicatorClass = 'warna-kuning';
                } else if (state.id === 'Merah (danger)') {
                    statusClass = 'status-merah';
                    indicatorClass = 'warna-merah';
                }
                
                if (statusClass) {
                    return $('<span class="status-badge ' + statusClass + '"><span class="warna-indicator ' + indicatorClass + '"></span>' + state.text + '</span>');
                }
                
                return state.text;
            }

            // Number input controls
            $('#increaseHari').click(function() {
                var currentVal = parseInt($('#hari_nifas').val());
                if (currentVal < 42) {
                    $('#hari_nifas').val(currentVal + 1);
                }
            });
            
            $('#decreaseHari').click(function() {
                var currentVal = parseInt($('#hari_nifas').val());
                if (currentVal > 0) {
                    $('#hari_nifas').val(currentVal - 1);
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
                var totalFields = 5; // Jumlah field yang harus diisi
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
            $('#ibuNifasForm').on('submit', function(e) {
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
                        confirmButtonColor: '#ec4899'
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
            
            @if(old('warna_kondisi'))
                $('#warna_kondisi').val('{{ old('warna_kondisi') }}').trigger('change');
            @endif
        });
    </script>
</body>
</html>