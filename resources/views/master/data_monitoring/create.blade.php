<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Data Monitoring - CSSR</title>
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
        
        .warna-label {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 0.5rem;
            vertical-align: middle;
        }
        
        .warna-label.hijau {
            background-color: #10b981;
        }
        
        .warna-label.kuning {
            background-color: #f59e0b;
        }
        
        .warna-label.merah {
            background-color: #ef4444;
        }
        
        .warna-label.biru {
            background-color: #3b82f6;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tambah <span class="gradient-text">Data Monitoring</span></h1>
                    <p class="text-gray-600">Tambah data monitoring baru ke dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('data_monitoring.index') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Data Monitoring
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Session Error -->
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        <form action="{{ route('data_monitoring.store') }}" method="POST" enctype="multipart/form-data" id="monitoringForm">
            @csrf
            
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Form Data Monitoring</h3>
                        <p class="text-gray-600 text-sm mt-1">Isi informasi lengkap data monitoring</p>
                    </div>
                    <div class="flex items-center text-sm text-blue-500">
                        <i class="fas fa-clipboard-check mr-2"></i>
                        <span>Form Tambah Monitoring</span>
                    </div>
                </div>
                
                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i> 
                        Pastikan data yang dimasukkan akurat dan lengkap untuk pemantauan yang optimal.
                    </p>
                </div>
                
                <!-- Data Lokasi -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Lokasi</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="kecamatan_id" class="form-label">
                                <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i> Kecamatan
                            </label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-input" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kelurahan_id" class="form-label">
                                <i class="fas fa-map-marker mr-1 text-blue-500"></i> Kelurahan
                            </label>
                            <select name="kelurahan_id" id="kelurahan_id" class="form-input" required>
                                <option value="">-- Pilih Kelurahan --</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                                @endforeach
                            </select>
                            @error('kelurahan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kartu_keluarga_id" class="form-label">
                                <i class="fas fa-id-card-alt mr-1 text-blue-500"></i> Kartu Keluarga
                            </label>
                            <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="form-input" required>
                                <option value="">-- Pilih Kartu Keluarga --</option>
                                @if ($kartuKeluarga)
                                    <option value="{{ $kartuKeluarga->id }}" selected>{{ $kartuKeluarga->no_kk }} - {{ $kartuKeluarga->kepala_keluarga }}</option>
                                @endif
                            </select>
                            @error('kartu_keluarga_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Target -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Target</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="target" class="form-label">
                                <i class="fas fa-user-check mr-1 text-blue-500"></i> Target Monitoring
                            </label>
                            <select name="target" id="target" class="form-input" required>
                                <option value="">-- Pilih Target --</option>
                                <option value="Ibu" {{ old('target') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                <option value="Balita" {{ old('target') == 'Balita' ? 'selected' : '' }}>Balita</option>
                            </select>
                            @error('target')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="ibu_id_div" style="display: {{ old('target') == 'Ibu' ? 'block' : 'none' }};">
                            <label for="ibu_id" class="form-label">
                                <i class="fas fa-female mr-1 text-blue-500"></i> Nama Ibu
                            </label>
                            <select name="ibu_id" id="ibu_id" class="form-input">
                                <option value="">-- Pilih Nama Ibu --</option>
                            </select>
                            @error('ibu_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="balita_id_div" style="display: {{ old('target') == 'Balita' ? 'block' : 'none' }};">
                            <label for="balita_id" class="form-label">
                                <i class="fas fa-baby mr-1 text-blue-500"></i> Nama Balita
                            </label>
                            <select name="balita_id" id="balita_id" class="form-input">
                                <option value="">-- Pilih Nama Balita --</option>
                            </select>
                            @error('balita_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Monitoring -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 section-title">Data Monitoring</h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="kategori" class="form-label">
                                <i class="fas fa-list mr-1 text-blue-500"></i> Kategori
                            </label>
                            <select name="kategori" id="kategori" class="form-input" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriOptions as $kategoriOption)
                                    <option value="{{ $kategoriOption }}" {{ old('kategori') == $kategoriOption ? 'selected' : '' }}>{{ $kategoriOption }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group md:col-span-2">
                            <label for="perkembangan_anak" class="form-label">
                                <i class="fas fa-child mr-1 text-blue-500"></i> Perkembangan Anak
                            </label>
                            <textarea name="perkembangan_anak" id="perkembangan_anak" class="form-input" rows="4" placeholder="Masukkan deskripsi perkembangan anak">{{ old('perkembangan_anak') }}</textarea>
                            @error('perkembangan_anak')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kunjungan_rumah" class="form-label">
                                <i class="fas fa-home mr-1 text-blue-500"></i> Kunjungan Rumah
                            </label>
                            <select name="kunjungan_rumah" id="kunjungan_rumah" class="form-input">
                                <option value="0" {{ old('kunjungan_rumah') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                <option value="1" {{ old('kunjungan_rumah') == '1' ? 'selected' : '' }}>Ada</option>
                            </select>
                            @error('kunjungan_rumah')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="frekuensi_kunjungan_div" style="display: {{ old('kunjungan_rumah') == '1' ? 'block' : 'none' }};">
                            <label for="frekuensi_kunjungan" class="form-label">
                                <i class="fas fa-clock mr-1 text-blue-500"></i> Frekuensi Kunjungan
                            </label>
                            <select name="frekuensi_kunjungan" id="frekuensi_kunjungan" class="form-input">
                                <option value="" {{ old('frekuensi_kunjungan') == '' ? 'selected' : '' }}>-- Pilih Frekuensi --</option>
                                <option value="Per Minggu" {{ old('frekuensi_kunjungan') == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                                <option value="Per Bulan" {{ old('frekuensi_kunjungan') == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                                <option value="Per 3 Bulan" {{ old('frekuensi_kunjungan') == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                            </select>
                            @error('frekuensi_kunjungan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="pemberian_pmt" class="form-label">
                                <i class="fas fa-utensils mr-1 text-blue-500"></i> Pemberian PMT
                            </label>
                            <select name="pemberian_pmt" id="pemberian_pmt" class="form-input">
                                <option value="0" {{ old('pemberian_pmt') == '0' ? 'selected' : '' }}>Tidak Ada</option>
                                <option value="1" {{ old('pemberian_pmt') == '1' ? 'selected' : '' }}>Ada</option>
                            </select>
                            @error('pemberian_pmt')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group" id="frekuensi_pmt_div" style="display: {{ old('pemberian_pmt') == '1' ? 'block' : 'none' }};">
                            <label for="frekuensi_pmt" class="form-label">
                                <i class="fas fa-clock mr-1 text-blue-500"></i> Frekuensi PMT
                            </label>
                            <select name="frekuensi_pmt" id="frekuensi_pmt" class="form-input">
                                <option value="" {{ old('frekuensi_pmt') == '' ? 'selected' : '' }}>-- Pilih Frekuensi --</option>
                                <option value="Per Minggu" {{ old('frekuensi_pmt') == 'Per Minggu' ? 'selected' : '' }}>Per Minggu</option>
                                <option value="Per Bulan" {{ old('frekuensi_pmt') == 'Per Bulan' ? 'selected' : '' }}>Per Bulan</option>
                                <option value="Per 3 Bulan" {{ old('frekuensi_pmt') == 'Per 3 Bulan' ? 'selected' : '' }}>Per 3 Bulan</option>
                            </select>
                            @error('frekuensi_pmt')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-heartbeat mr-1 text-blue-500"></i> Status
                            </label>
                            <select name="status" id="status" class="form-input" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach ($statusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" {{ old('status') == $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="warna_badge" class="form-label">
                                <i class="fas fa-tag mr-1 text-blue-500"></i> Warna Badge
                            </label>
                            <select name="warna_badge" id="warna_badge" class="form-input" required>
                                <option value="Hijau" {{ old('warna_badge') == 'Hijau' ? 'selected' : '' }}><span class="warna-label hijau"></span> Hijau</option>
                                <option value="Kuning" {{ old('warna_badge') == 'Kuning' ? 'selected' : '' }}><span class="warna-label kuning"></span> Kuning</option>
                                <option value="Merah" {{ old('warna_badge') == 'Merah' ? 'selected' : '' }}><span class="warna-label merah"></span> Merah</option>
                                <option value="Biru" {{ old('warna_badge') == 'Biru' ? 'selected' : '' }}><span class="warna-label biru"></span> Biru</option>
                            </select>
                            @error('warna_badge')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="tanggal_monitoring" class="form-label">
                                <i class="fas fa-calendar-alt mr-1 text-blue-500"></i> Tanggal Monitoring
                            </label>
                            <input type="date" name="tanggal_monitoring" id="tanggal_monitoring" value="{{ old('tanggal_monitoring') }}" class="form-input" required>
                            @error('tanggal_monitoring')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="urutan" class="form-label">
                                <i class="fas fa-sort-numeric-up mr-1 text-blue-500"></i> Urutan
                            </label>
                            <input type="number" name="urutan" id="urutan" value="{{ old('urutan') }}" class="form-input" required min="1" placeholder="Masukkan urutan">
                            @error('urutan')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="status_aktif" class="form-label">
                                <i class="fas fa-toggle-on mr-1 text-blue-500"></i> Status Aktif
                            </label>
                            <select name="status_aktif" id="status_aktif" class="form-input" required>
                                <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status_aktif')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('data_monitoring.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data Monitoring
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
            // Initialize Select2
            $('#target').select2({ placeholder: '-- Pilih Target --', allowClear: true, width: '100%' });
            $('#kecamatan_id').select2({ placeholder: '-- Pilih Kecamatan --', allowClear: true, width: '100%' });
            $('#kelurahan_id').select2({ placeholder: '-- Pilih Kelurahan --', allowClear: true, width: '100%' });
            $('#kartu_keluarga_id').select2({ placeholder: '-- Pilih Kartu Keluarga --', allowClear: true, width: '100%' });
            $('#ibu_id').select2({ placeholder: '-- Pilih Nama Ibu --', allowClear: true, width: '100%' });
            $('#balita_id').select2({ placeholder: '-- Pilih Nama Balita --', allowClear: true, width: '100%' });
            $('#kategori').select2({ placeholder: '-- Pilih Kategori --', allowClear: true, width: '100%' });
            $('#status').select2({ placeholder: '-- Pilih Status --', allowClear: true, width: '100%' });
            $('#kunjungan_rumah').select2({ placeholder: '-- Pilih Kunjungan Rumah --', allowClear: true, width: '100%' });
            $('#pemberian_pmt').select2({ placeholder: '-- Pilih Pemberian PMT --', allowClear: true, width: '100%' });
            $('#frekuensi_kunjungan').select2({ placeholder: '-- Pilih Frekuensi --', allowClear: true, width: '100%' });
            $('#frekuensi_pmt').select2({ placeholder: '-- Pilih Frekuensi --', allowClear: true, width: '100%' });
            $('#warna_badge').select2({ placeholder: '-- Pilih Warna Badge --', allowClear: true, width: '100%' });
            $('#status_aktif').select2({ placeholder: '-- Pilih Status Aktif --', allowClear: true, width: '100%' });

            // Custom styling for Select2 dropdown
            $('.select2-container').addClass('form-input');
            $('.select2-selection').addClass('form-input');

            // Load kelurahans for old kecamatan_id on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                loadKelurahans(initialKecamatanId);
            }

            // Update kelurahans and kartu keluarga when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    loadKelurahans(kecamatanId);
                } else {
                    $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                    $('#kelurahan_id').trigger('change');
                }
                updateKartuKeluarga();
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            // Update ibu and balita when kartu keluarga changes
            $('#kartu_keluarga_id').on('change', function() {
                updateIbuAndBalita();
            });

            // Show/hide ibu_id and balita_id based on target
            $('#target').on('change', function() {
                var target = $(this).val();
                if (target === 'Ibu') {
                    $('#ibu_id_div').show();
                    $('#balita_id_div').hide();
                    $('#balita_id').val('').trigger('change');
                } else if (target === 'Balita') {
                    $('#balita_id_div').show();
                    $('#ibu_id_div').hide();
                    $('#ibu_id').val('').trigger('change');
                } else {
                    $('#ibu_id_div').hide();
                    $('#balita_id_div').hide();
                    $('#ibu_id').val('').trigger('change');
                    $('#balita_id').val('').trigger('change');
                }
            });

            // Show/hide frekuensi_kunjungan based on kunjungan_rumah
            $('#kunjungan_rumah').on('change', function() {
                if ($(this).val() === '1') {
                    $('#frekuensi_kunjungan_div').show();
                } else {
                    $('#frekuensi_kunjungan_div').hide();
                    $('#frekuensi_kunjungan').val('').trigger('change');
                }
            });

            // Show/hide frekuensi_pmt based on pemberian_pmt
            $('#pemberian_pmt').on('change', function() {
                if ($(this).val() === '1') {
                    $('#frekuensi_pmt_div').show();
                } else {
                    $('#frekuensi_pmt_div').hide();
                    $('#frekuensi_pmt').val('').trigger('change');
                }
            });

            function loadKelurahans(kecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == {{ old('kelurahan_id') ?? 'null' }} ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }

            function updateKartuKeluarga() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $('#kelurahan_id').val();
                if (kecamatanId && kelurahanId) {
                    $.ajax({
                        url: '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}?kecamatan_id=' + kecamatanId + '&kelurahan_id=' + kelurahanId,
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>');
                            $.each(data, function(index, kk) {
                                var selected = kk.id == {{ old('kartu_keluarga_id') ?? 'null' }} ? 'selected' : '';
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                            $('#kartu_keluarga_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kartu keluarga:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                } else {
                    $('#kartu_keluarga_id').empty().append('<option value="">-- Pilih Kartu Keluarga --</option>');
                    $('#kartu_keluarga_id').trigger('change');
                }
            }

            function updateIbuAndBalita() {
                var kartuKeluargaId = $('#kartu_keluarga_id').val();
                if (kartuKeluargaId) {
                    $.ajax({
                        url: '{{ route("kartu_keluarga.get-ibu-balita", ":kartu_keluarga_id") }}'.replace(':kartu_keluarga_id', kartuKeluargaId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#ibu_id').empty().append('<option value="">-- Pilih Nama Ibu --</option>');
                            if (data.ibus && data.ibus.length > 0) {
                                $.each(data.ibus, function(index, ibu) {
                                    var selected = ibu.id == {{ old('ibu_id') ?? 'null' }} ? 'selected' : '';
                                    $('#ibu_id').append('<option value="' + ibu.id + '" ' + selected + '>' + ibu.nama + '</option>');
                                });
                            } else {
                                $('#ibu_id').append('<option value="" disabled>Tidak ada data ibu</option>');
                            }

                            $('#balita_id').empty().append('<option value="">-- Pilih Nama Balita --</option>');
                            if (data.balitas && data.balitas.length > 0) {
                                $.each(data.balitas, function(index, balita) {
                                    var selected = balita.id == {{ old('balita_id') ?? 'null' }} ? 'selected' : '';
                                    $('#balita_id').append('<option value="' + balita.id + '" ' + selected + '>' + balita.nama + '</option>');
                                });
                            } else {
                                $('#balita_id').append('<option value="" disabled>Tidak ada data balita</option>');
                            }

                            $('#ibu_id').trigger('change');
                            $('#balita_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching ibu and balita:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat data ibu dan balita: ' + (xhr.responseJSON?.error || 'Silakan coba lagi.'),
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                } else {
                    $('#ibu_id').empty().append('<option value="">-- Pilih Nama Ibu --</option>');
                    $('#balita_id').empty().append('<option value="">-- Pilih Nama Balita --</option>');
                    $('#ibu_id').trigger('change');
                    $('#balita_id').trigger('change');
                }
            }

            // Form validation before submission
            $('#monitoringForm').on('submit', function(e) {
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
        });
    </script>
</body>
</html>