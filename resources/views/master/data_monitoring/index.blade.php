<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - CSSR</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
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
        
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .table-container table {
            min-width: 1200px;
        }
        
        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
            z-index: 10;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-hijau {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-kuning {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .status-merah {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .status-biru {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .pagination .page-link {
            padding: 8px 12px;
            margin: 0 2px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .pagination .page-link:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .pagination .active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
        
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 8px 12px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
            padding-left: 0;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        
        .filter-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .action-btn.edit {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .action-btn.edit:hover {
            background-color: #bfdbfe;
        }
        
        .action-btn.delete {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .action-btn.delete:hover {
            background-color: #fecaca;
        }
        
        .action-btn.view {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .action-btn.view:hover {
            background-color: #a7f3d0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .stat-item {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-left: 4px solid #3b82f6;
        }
        
        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin: 8px 0;
        }
        
        .stat-label {
            font-size: 14px;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }
        
        .badge-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 4px;
        }
        
        .badge-hijau { background-color: #10b981; }
        .badge-kuning { background-color: #f59e0b; }
        .badge-merah { background-color: #ef4444; }
        .badge-biru { background-color: #3b82f6; }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Monitoring</span></h1>
            <p class="text-gray-600">Kelola dan pantau data monitoring stunting di wilayah Anda.</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Stats Overview -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-label">
                    <i class="fas fa-chart-line text-blue-500"></i>
                    Total Data
                </div>
                <div class="stat-value">{{ $dataMonitorings->total() }}</div>
                <div class="text-xs text-gray-500">Data Monitoring</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">
                    <i class="fas fa-map-marker-alt text-green-500"></i>
                    Kecamatan
                </div>
                <div class="stat-value">{{ count($kecamatans) }}</div>
                <div class="text-xs text-gray-500">Wilayah Terdata</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">
                    <i class="fas fa-tags text-purple-500"></i>
                    Kategori
                </div>
                <div class="stat-value">{{ count($kategoriOptions) }}</div>
                <div class="text-xs text-gray-500">Jenis Kategori</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">
                    <i class="fas fa-palette text-yellow-500"></i>
                    Warna Badge
                </div>
                <div class="stat-value">{{ count($warnaBadgeOptions) }}</div>
                <div class="text-xs text-gray-500">Status Warna</div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <a href="{{ route('data_monitoring.create') }}" class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition flex items-center justify-center gap-2 card-hover">
                <i class="fas fa-plus-circle"></i>
                Tambah Data Monitoring
            </a>
            <a href="{{ route('balita.index') }}" class="bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-600 transition flex items-center justify-center gap-2 card-hover">
                <i class="fas fa-baby"></i>
                Kelola Data Balita
            </a>
            <a href="{{ route('peta_geospasial.index') }}" class="bg-purple-500 text-white px-4 py-3 rounded-lg hover:bg-purple-600 transition flex items-center justify-center gap-2 card-hover">
                <i class="fas fa-map-marked-alt"></i>
                Peta Geospasial
            </a>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-card mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-filter text-blue-500"></i>
                Filter Data
            </h3>
            <form action="{{ route('data_monitoring.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="w-full">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="w-full">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" id="kategori" class="w-full">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriOptions as $kategoriOption)
                            <option value="{{ $kategoriOption }}" {{ $kategori == $kategoriOption ? 'selected' : '' }}>{{ $kategoriOption }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warna Badge</label>
                    <select name="warna_badge" id="warna_badge" class="w-full">
                        <option value="">Semua Warna</option>
                        @foreach ($warnaBadgeOptions as $warna)
                            <option value="{{ $warna }}" {{ $warna_badge == $warna ? 'selected' : '' }}>{{ $warna }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition flex items-center gap-2 h-10 w-full justify-center">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if ($kecamatan_id || $kelurahan_id || $kategori || $warna_badge)
                        <a href="{{ route('data_monitoring.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Filter Info -->
        @if ($kecamatan_id || $kelurahan_id || $kategori || $warna_badge)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <div>
                        <span class="font-medium text-blue-800">Filter Aktif:</span>
                        <span class="text-blue-700 ml-2">
                            @if ($kecamatan_id)
                                Kecamatan: {{ \App\Models\Kecamatan::find($kecamatan_id)?->nama_kecamatan ?? '-' }}
                            @endif
                            @if ($kelurahan_id)
                                | Kelurahan: {{ \App\Models\Kelurahan::find($kelurahan_id)?->nama_kelurahan ?? '-' }}
                            @endif
                            @if ($kategori)
                                | Kategori: {{ $kategori }}
                            @endif
                            @if ($warna_badge)
                                | Warna Badge: {{ $warna_badge }}
                            @endif
                            | Total: {{ $dataMonitorings->total() }} data
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-100 p-4 mb-6 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-database text-gray-500 mr-2"></i>
                    <span class="text-gray-700">Menampilkan semua data monitoring ({{ $dataMonitorings->total() }} data)</span>
                </div>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-sync-alt mr-1"></i>
                    Data terbaru
                </div>
            </div>
        @endif
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-chart-bar text-blue-500"></i>
                        Data Monitoring
                    </h3>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $dataMonitorings->currentPage() }} dari {{ $dataMonitorings->lastPage() }}
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-4 text-left font-medium text-gray-700">No</th>
                            <th class="p-4 text-left font-medium text-gray-700">Nama</th>
                            <th class="p-4 text-left font-medium text-gray-700">Target</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kecamatan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kategori</th>
                            <th class="p-4 text-left font-medium text-gray-700">Status</th>
                            <th class="p-4 text-left font-medium text-gray-700">Warna Badge</th>
                            <th class="p-4 text-left font-medium text-gray-700">Tanggal Monitoring</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kartu Keluarga</th>
                            <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataMonitorings as $dataMonitoring)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                                <td class="p-4 text-gray-600">{{ $loop->iteration + ($dataMonitorings->firstItem() - 1) }}</td>
                                <td class="p-4 font-medium text-gray-800">{{ $dataMonitoring->nama ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $dataMonitoring->target ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $dataMonitoring->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $dataMonitoring->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4">
                                    <span class="status-badge status-biru">
                                        {{ $dataMonitoring->kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="status-badge status-biru">
                                        {{ $dataMonitoring->status ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @php
                                        $badgeClass = 'status-biru';
                                        if ($dataMonitoring->warna_badge == 'Hijau') {
                                            $badgeClass = 'status-hijau';
                                        } elseif ($dataMonitoring->warna_badge == 'Kuning') {
                                            $badgeClass = 'status-kuning';
                                        } elseif ($dataMonitoring->warna_badge == 'Merah') {
                                            $badgeClass = 'status-merah';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $badgeClass }}">
                                        <span class="badge-indicator badge-{{ strtolower($dataMonitoring->warna_badge) }}"></span>
                                        {{ $dataMonitoring->warna_badge ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">
                                    @if ($dataMonitoring->tanggal_monitoring)
                                        {{ $dataMonitoring->tanggal_monitoring->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if ($dataMonitoring->kartuKeluarga)
                                        <a href="{{ route('kartu_keluarga.show', $dataMonitoring->kartuKeluarga->id) }}" class="action-btn view">
                                            <i class="fas fa-eye"></i>
                                            Lihat KK
                                        </a>
                                    @else
                                        <span class="text-gray-500 text-sm">Tidak ada KK</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="action-buttons">
                                        <a href="{{ route('data_monitoring.edit', $dataMonitoring->id) }}" class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="action-btn delete" onclick="showDeleteModal('{{ route('data_monitoring.destroy', $dataMonitoring->id) }}', '{{ $dataMonitoring->nama ?? 'Data Monitoring' }}')">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data monitoring yang sesuai dengan filter.</p>
                                        <a href="{{ route('data_monitoring.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 flex items-center gap-1">
                                            <i class="fas fa-redo"></i>
                                            Tampilkan semua data
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if ($dataMonitorings->hasPages())
                <div class="p-4 border-t border-gray-200">
                    <div class="pagination flex justify-center">
                        {{ $dataMonitorings->appends([
                            'kecamatan_id' => $kecamatan_id, 
                            'kelurahan_id' => $kelurahan_id, 
                            'kategori' => $kategori, 
                            'warna_badge' => $warna_badge
                        ])->links() }}
                    </div>
                </div>
            @endif
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
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: 'Semua Kecamatan',
                allowClear: true
            });

            $('#kelurahan_id').select2({
                placeholder: 'Semua Kelurahan',
                allowClear: true
            });

            $('#kategori').select2({
                placeholder: 'Semua Kategori',
                allowClear: true
            });

            $('#warna_badge').select2({
                placeholder: 'Semua Warna',
                allowClear: true
            });

            // Load kelurahans for selected kecamatan on page load
            var initialKecamatanId = '{{ $kecamatan_id ?? '' }}';
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(data) {
                        $('#kelurahan_id').empty().append('<option value="">Semua Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == '{{ $kelurahan_id ?? '' }}' ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memuat Kelurahan',
                            text: 'Terjadi kesalahan saat memuat data kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                });
            }

            // Update kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">Semua Kelurahan</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat Kelurahan',
                                text: 'Terjadi kesalahan saat memuat data kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty().append('<option value="">Semua Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
            });

            // Delete modal with SweetAlert2
            window.showDeleteModal = function(url, name) {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Apakah Anda yakin ingin menghapus data monitoring <span class="font-bold text-red-600">${name}</span>? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Hapus',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);
                        
                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };
        });
    </script>
</body>
</html>