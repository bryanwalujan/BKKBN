<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Audit Stunting - Perangkat Daerah</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .bg-gradient-sidebar {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .form-section-header {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-bottom: 1px solid #bbf7d0;
            padding: 1.25rem 1.5rem;
        }
        .form-section-body {
            padding: 1.5rem;
        }
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 48px;
            padding: 0.5rem 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
        }
        .badge-kecamatan {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('perangkat_daerah.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-chart-line text-green-600 mr-3"></i>
                            Tambah Data Audit Stunting
                        </h1>
                        <div class="flex items-center mt-1 space-x-4">
                            <p class="text-gray-600">Tambah data audit stunting baru untuk wilayah Anda</p>
                            @if($kecamatan)
                            <div class="badge-kecamatan flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                {{ $kecamatan->nama_kecamatan ?? '-' }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('perangkat_daerah.audit_stunting.index') }}" 
                           class="text-sm text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">Terdapat kesalahan dalam pengisian form:</p>
                        <ul class="mt-1 list-disc list-inside text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ route('perangkat_daerah.audit_stunting.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Informasi Wilayah -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marked-alt text-green-500 mr-2"></i>
                            Informasi Wilayah
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Data wilayah yang akan diaudit</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map text-blue-500 mr-2 text-xs"></i>
                                    Kecamatan
                                </label>
                                <div class="relative">
                                    <div class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 p-3 pl-10">
                                        <p class="text-gray-800 font-medium">{{ $kecamatan->nama_kecamatan ?? '-' }}</p>
                                    </div>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-pin text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map-marker-alt text-green-500 mr-2 text-xs"></i>
                                    Kelurahan
                                </label>
                                <div class="relative">
                                    <select name="kelurahan_id" id="kelurahan_id" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Kelurahan --</option>
                                        @foreach ($kelurahans as $kelurahan)
                                            <option value="{{ $kelurahan->id }}" {{ $dataMonitoring && $dataMonitoring->kelurahan_id == $kelurahan->id ? 'selected' : '' }}>
                                                {{ $kelurahan->nama_kelurahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kelurahan_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Data Monitoring -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                            Informasi Data Monitoring
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Pilih data monitoring yang akan diaudit</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="data_monitoring_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-database text-purple-500 mr-2 text-xs"></i>
                                    Data Monitoring
                                </label>
                                <div class="relative">
                                    <select name="data_monitoring_id" id="data_monitoring_id" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Data Monitoring --</option>
                                        @if ($dataMonitoring)
                                            <option value="{{ $dataMonitoring->id }}" selected>
                                                {{ $dataMonitoring->nama }} ({{ $dataMonitoring->target }} - {{ $dataMonitoring->kategori }})
                                            </option>
                                        @endif
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('data_monitoring_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pengauditan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user-check text-green-500 mr-2"></i>
                            Informasi Pengauditan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Data pihak yang terlibat dalam audit</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user text-blue-500 mr-2 text-xs"></i>
                                    Pengunggah
                                </label>
                                <div class="relative">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 p-3 pl-10">
                                        <p class="text-gray-800 font-medium">{{ Auth::user()->name }}</p>
                                    </div>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-tie text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="pihak_pengaudit" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-users text-green-500 mr-2 text-xs"></i>
                                    Pihak Pengaudit
                                </label>
                                <div class="relative">
                                    <input type="text" name="pihak_pengaudit" id="pihak_pengaudit" value="{{ old('pihak_pengaudit') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan nama pihak pengaudit">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-check text-gray-400"></i>
                                    </div>
                                </div>
                                @error('pihak_pengaudit')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumentasi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-camera text-yellow-500 mr-2"></i>
                            Dokumentasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Unggah foto dokumentasi audit</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="foto_dokumentasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-image text-yellow-500 mr-2 text-xs"></i>
                                    Foto Dokumentasi (Maks. 2MB)
                                </label>
                                <div class="relative">
                                    <input type="file" name="foto_dokumentasi" id="foto_dokumentasi" 
                                           accept="image/jpeg,image/jpg,image/png"
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-file-image text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, JPEG, PNG</p>
                                @error('foto_dokumentasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Audit -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
                            Konten Audit
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Masukkan laporan dan narasi hasil audit</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="laporan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-file-contract text-blue-500 mr-2 text-xs"></i>
                                    Laporan
                                </label>
                                <textarea name="laporan" id="laporan" rows="4" 
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                          placeholder="Masukkan laporan hasil audit">{{ old('laporan') }}</textarea>
                                @error('laporan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="narasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-align-left text-green-500 mr-2 text-xs"></i>
                                    Narasi
                                </label>
                                <textarea name="narasi" id="narasi" rows="4" 
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                          placeholder="Masukkan narasi hasil audit">{{ old('narasi') }}</textarea>
                                @error('narasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('perangkat_daerah.audit_stunting.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Audit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#data_monitoring_id').select2({
                placeholder: 'Pilih Data Monitoring',
                allowClear: true,
                ajax: {
                    url: '{{ route("perangkat_daerah.audit_stunting.getDataMonitoring", Auth::user()->kecamatan_id) }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama + ' (' + item.target + ' - ' + item.kategori + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true
            });

            $('#data_monitoring_id').on('change', function() {
                var dataMonitoringId = $(this).val();
                if (dataMonitoringId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.audit_stunting.getKelurahan", ":id") }}'.replace(':id', dataMonitoringId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                            $.each(data.kelurahans, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.text + '</option>');
                            });
                            $('#kelurahan_id').val(data.kelurahan_id).trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahan:', xhr.responseText);
                            alert('Gagal memuat data kelurahan. Silakan coba lagi.');
                        }
                    });
                } else {
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>').trigger('change');
                }
            });

            @if ($dataMonitoring)
                $('#data_monitoring_id').val('{{ $dataMonitoring->id }}').trigger('change');
            @endif
        });
    </script>
</body>
</html>