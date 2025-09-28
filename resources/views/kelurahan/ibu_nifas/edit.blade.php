<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Ibu Nifas - CSSR Kelurahan</title>
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
        
        .color-indicator {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }
        
        .color-hijau { background-color: #10b981; }
        .color-kuning { background-color: #f59e0b; }
        .color-merah { background-color: #ef4444; }
        
        .health-status {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }
        
        .health-option {
            flex: 1;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .health-option:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        
        .health-option.selected {
            border-color: #3b82f6;
            background-color: #eff6ff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .health-option i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .health-option.normal i { color: #10b981; }
        .health-option.attention i { color: #f59e0b; }
        .health-option.critical i { color: #ef4444; }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
        
        .input-with-icon input {
            padding-left: 40px;
        }
        
        .input-with-icon select {
            padding-left: 40px;
        }
        
        .edit-indicator {
            display: inline-flex;
            align-items: center;
            background-color: #fef3c7;
            color: #92400e;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-left: 1rem;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Data Ibu Nifas</span></h1>
                    <p class="text-gray-600">Perbarui data kesehatan ibu nifas dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        <span class="edit-indicator">
                            <i class="fas fa-edit mr-1"></i> Mode Edit Data
                        </span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('kelurahan.ibu_nifas.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Ibu Nifas
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
        
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        <form action="{{ route('kelurahan.ibu_nifas.update', ['id' => $ibuNifas->id, 'source' => $source]) }}" method="POST" id="nifasForm">
            @csrf
            @method('PUT')
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Ibu Nifas</h3>
                        <p class="text-gray-600 text-sm mt-1">Perbarui informasi kesehatan ibu nifas</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Form Edit Ibu Nifas - Kelurahan</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan akurat untuk pemantauan kesehatan ibu setelah melahirkan (periode 42 hari).
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
                                    <option value="{{ $ibu->id }}" data-source="verified" {{ old('ibu_id', $ibuNifas->ibu_id ?? ($ibuNifas->pending_ibu_id ?? '')) == $ibu->id ? 'selected' : '' }}>
                                        {{ $ibu->nama }} ({{ $ibu->nik ?? '-' }}) 
                                        <span class="status-badge verified">
                                            <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                        </span>
                                    </option>
                                @endforeach
                                @foreach ($pendingIbus as $ibu)
                                    <option value="{{ $ibu->id }}" data-source="pending" {{ old('ibu_id', $ibuNifas->pending_ibu_id ?? ($ibuNifas->ibu_id ?? '')) == $ibu->id ? 'selected' : '' }}>
                                        {{ $ibu->nama }} ({{ $ibu->nik ?? '-' }}) 
                                        <span class="status-badge pending">
                                            <i class="fas fa-clock mr-1"></i> Menunggu Verifikasi
                                        </span>
                                    </option>
                                @endforeach
                            </select>
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
                
                <!-- Data Kesehatan -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Kesehatan</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="hari_nifas" class="form-label">
                                <i class="fas fa-calendar-day mr-1 text-blue-500"></i> Hari ke-Nifas
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-check"></i>
                                <input type="number" name="hari_nifas" id="hari_nifas" value="{{ old('hari_nifas', $ibuNifas->hari_nifas) }}" min="0" max="42" class="form-input" placeholder="Masukkan hari ke-nifas" required>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Periode nifas: 0-42 hari setelah melahirkan
                            </div>
                            @error('hari_nifas')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-heartbeat mr-1 text-blue-500"></i> Kondisi Kesehatan
                            </label>
                            <div class="health-status">
                                <div class="health-option normal {{ old('kondisi_kesehatan', $ibuNifas->kondisi_kesehatan) == 'Normal' ? 'selected' : '' }}" data-value="Normal">
                                    <i class="fas fa-smile"></i>
                                    <div>Normal</div>
                                </div>
                                <div class="health-option attention {{ old('kondisi_kesehatan', $ibuNifas->kondisi_kesehatan) == 'Butuh Perhatian' ? 'selected' : '' }}" data-value="Butuh Perhatian">
                                    <i class="fas fa-meh"></i>
                                    <div>Butuh Perhatian</div>
                                </div>
                                <div class="health-option critical {{ old('kondisi_kesehatan', $ibuNifas->kondisi_kesehatan) == 'Kritis' ? 'selected' : '' }}" data-value="Kritis">
                                    <i class="fas fa-frown"></i>
                                    <div>Kritis</div>
                                </div>
                            </div>
                            <input type="hidden" name="kondisi_kesehatan" id="kondisi_kesehatan" value="{{ old('kondisi_kesehatan', $ibuNifas->kondisi_kesehatan) }}" required>
                            @error('kondisi_kesehatan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="warna_kondisi" class="form-label">
                                <i class="fas fa-palette mr-1 text-blue-500"></i> Warna Kondisi
                            </label>
                            <select name="warna_kondisi" id="warna_kondisi" class="form-input" required>
                                <option value="" {{ old('warna_kondisi', $ibuNifas->warna_kondisi) == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                                <option value="Hijau (success)" {{ old('warna_kondisi', $ibuNifas->warna_kondisi) == 'Hijau (success)' ? 'selected' : '' }}>
                                    <span class="color-indicator color-hijau"></span> Hijau (success)
                                </option>
                                <option value="Kuning (warning)" {{ old('warna_kondisi', $ibuNifas->warna_kondisi) == 'Kuning (warning)' ? 'selected' : '' }}>
                                    <span class="color-indicator color-kuning"></span> Kuning (warning)
                                </option>
                                <option value="Merah (danger)" {{ old('warna_kondisi', $ibuNifas->warna_kondisi) == 'Merah (danger)' ? 'selected' : '' }}>
                                    <span class="color-indicator color-merah"></span> Merah (danger)
                                </option>
                            </select>
                            @error('warna_kondisi')
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
                                <i class="fas fa-weight mr-1 text-blue-500"></i> Berat (kg)
                            </label>
                            <div class="input-with-icon">
                                <i class="fas fa-weight-hanging"></i>
                                <input type="number" name="berat" id="berat" value="{{ old('berat', $ibuNifas->berat) }}" step="0.1" class="form-input" placeholder="Masukkan berat badan" required>
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
                                <i class="fas fa-text-height"></i>
                                <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi', $ibuNifas->tinggi) }}" step="0.1" class="form-input" placeholder="Masukkan tinggi badan" required>
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
                    <a href="{{ route('kelurahan.ibu_nifas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Data Ibu Nifas
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
                templateSelection: formatIbuSelection
            });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Handle ibu selection change
            $('#ibu_id').on('change', function() {
                var source = $(this).find('option:selected').data('source');
                $('#ibu_source').val(source);
            });

            // Set initial source value
            var initialSource = $('#ibu_id').find('option:selected').data('source');
            if (initialSource) {
                $('#ibu_source').val(initialSource);
            }

            // Health status selection
            $('.health-option').on('click', function() {
                $('.health-option').removeClass('selected');
                $(this).addClass('selected');
                $('#kondisi_kesehatan').val($(this).data('value'));
            });

            // Form validation before submission
            $('#nifasForm').on('submit', function(e) {
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

        // Format ibu option in Select2
        function formatIbuOption(ibu) {
            if (!ibu.id) {
                return ibu.text;
            }
            
            var $option = $(ibu.element);
            var source = $option.data('source');
            var badgeClass = source === 'verified' ? 'verified' : 'pending';
            var badgeText = source === 'verified' ? 'Terverifikasi' : 'Menunggu Verifikasi';
            var badgeIcon = source === 'verified' ? 'fa-check-circle' : 'fa-clock';
            
            var $wrapper = $('<span></span>');
            $wrapper.text(ibu.text.replace(/ - Terverifikasi| - Menunggu Verifikasi/g, ''));
            
            var $badge = $('<span class="status-badge ' + badgeClass + ' ml-2"><i class="fas ' + badgeIcon + ' mr-1"></i>' + badgeText + '</span>');
            
            return $wrapper.append($badge);
        }

        // Format ibu selection in Select2
        function formatIbuSelection(ibu) {
            if (!ibu.id) {
                return ibu.text;
            }
            
            // Remove badge from selected text
            return $(ibu.element).text().replace(/ - Terverifikasi| - Menunggu Verifikasi/g, '');
        }
    </script>
</body>
</html>