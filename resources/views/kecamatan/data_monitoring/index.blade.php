<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - Admin Kecamatan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
            border-left-color: #15803d;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #15803d, #10b981);
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
            min-width: 100%;
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
        
        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .status-verified {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 12px 24px;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            position: relative;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .tab.active {
            color: #15803d;
        }
        
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #15803d;
            border-radius: 3px 3px 0 0;
        }
        
        .tab:hover:not(.active) {
            color: #4b5563;
            background-color: #f9fafb;
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
            background-color: #15803d;
            border-color: #15803d;
            color: white;
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
            border: none;
            cursor: pointer;
        }
        
        .action-btn.approve {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .action-btn.approve:hover {
            background-color: #a7f3d0;
        }
        
        .action-btn.reject {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .action-btn.reject:hover {
            background-color: #fecaca;
        }
        
        .badge {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }
        
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 12px;
            padding: 24px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s;
        }
        
        .modal-overlay.active .modal-content {
            transform: scale(1);
        }
        
        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .modal-close:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }
        
        .rejection-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-top: 8px;
            font-size: 14px;
        }
        
        .rejection-input:focus {
            outline: none;
            border-color: #15803d;
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
        }
        
        tbody tr {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            border-left: 4px solid #10b981;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .stat-icon.pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .stat-icon.verified {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .stat-info {
            flex: 1;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }
        
        .stat-label {
            font-size: 14px;
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('kecamatan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Monitoring</span></h1>
            <p class="text-gray-600">Kelola data monitoring di Kecamatan {{ $kecamatan->nama_kecamatan ?? 'Kecamatan Anda' }}</p>
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
        @if (session('error') || isset($errorMessage))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') ?? $errorMessage }}</span>
                </div>
            </div>
        @endif
        
        <!-- Stats Cards -->
        <div class="stats-card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-green-500"></i>
                Ringkasan Data Monitoring
            </h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $dataMonitorings->total() }}</div>
                        <div class="stat-label">Total Data {{ $tab === 'pending' ? 'Pending' : 'Terverifikasi' }}</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon verified">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $kelurahans->count() }}</div>
                        <div class="stat-label">Jumlah Kelurahan</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-tags text-blue-500"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ count($kategoriOptions) }}</div>
                        <div class="stat-label">Kategori Tersedia</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('kecamatan.data_monitoring.index', ['tab' => 'pending', 'kelurahan_id' => $kelurahan_id, 'kategori' => $kategori, 'warna_badge' => $warna_badge]) }}"
               class="tab {{ $tab === 'pending' ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                Pending Verifikasi
            </a>
            <a href="{{ route('kecamatan.data_monitoring.index', ['tab' => 'verified', 'kelurahan_id' => $kelurahan_id, 'kategori' => $kategori, 'warna_badge' => $warna_badge]) }}"
               class="tab {{ $tab === 'verified' ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i>
                Terverifikasi
            </a>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-filter text-green-500"></i>
                Filter Data
            </h3>
            <form method="GET" action="{{ route('kecamatan.data_monitoring.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select name="kelurahan_id" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriOptions as $k)
                            <option value="{{ $k }}" {{ $kategori == $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warna Badge</label>
                    <select name="warna_badge" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">Semua Warna</option>
                        @foreach ($warnaBadgeOptions as $w)
                            <option value="{{ $w }}" {{ $warna_badge == $w ? 'selected' : '' }}>{{ $w }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2 h-10 w-full justify-center">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if ($kelurahan_id || $kategori || $warna_badge)
                        <a href="{{ route('kecamatan.data_monitoring.index', ['tab' => $tab]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Filter Info -->
        @if ($kelurahan_id || $kategori || $warna_badge)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <div>
                        <span class="font-medium text-blue-800">Filter Aktif:</span>
                        <span class="text-blue-700 ml-2">
                            @if ($kelurahan_id)
                                Kelurahan: {{ $kelurahans->where('id', $kelurahan_id)->first()->nama_kelurahan ?? 'Tidak diketahui' }}
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
                    <span class="text-gray-700">Menampilkan semua data monitoring {{ $tab === 'pending' ? 'pending verifikasi' : 'terverifikasi' }} ({{ $dataMonitorings->total() }} data)</span>
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
                        <i class="fas fa-table text-green-500"></i>
                        Data Monitoring - {{ $tab === 'pending' ? 'Pending Verifikasi' : 'Terverifikasi' }}
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
                            <th class="p-4 text-left font-medium text-gray-700">Kartu Keluarga</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kategori</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Tanggal Monitoring</th>
                            <th class="p-4 text-left font-medium text-gray-700">Warna Badge</th>
                            @if ($tab === 'pending')
                                <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataMonitorings as $data)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-green-50 transition">
                                <td class="p-4 text-gray-600">{{ $loop->iteration + ($dataMonitorings->firstItem() - 1) }}</td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-800">{{ $data->kartuKeluarga->no_kk ?? '-' }}</div>
                                    <div class="text-sm text-gray-500">{{ $data->kartuKeluarga->kepala_keluarga ?? '-' }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="status-badge {{ $data->kategori == 'Stunting' ? 'status-rejected' : ($data->kategori == 'Risiko Stunting' ? 'status-pending' : 'status-verified') }}">
                                        {{ $data->kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $data->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4 text-gray-600">
                                    @if($data->tanggal_monitoring)
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-calendar text-green-500"></i>
                                            {{ date('d-m-Y', strtotime($data->tanggal_monitoring)) }}
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4 text-gray-600">
                                    @if($data->warna_badge)
                                        <div class="flex items-center">
                                            <span class="badge" style="background-color: {{ $warnaBadgeOptions[$data->warna_badge] ?? '#000000' }};"></span>
                                            {{ $data->warna_badge ?? '-' }}
                                        </div>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                                @if ($tab === 'pending')
                                    <td class="p-4">
                                        <div class="action-buttons">
                                            <form action="{{ route('kecamatan.data_monitoring.approve', $data->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="action-btn approve" onclick="return confirmAction('approve', '{{ $data->kartuKeluarga->no_kk ?? 'Data Monitoring' }}')">
                                                    <i class="fas fa-check"></i>
                                                    Setujui
                                                </button>
                                            </form>
                                            <button type="button" class="action-btn reject" onclick="showRejectionModal('{{ $data->id }}', '{{ $data->kartuKeluarga->no_kk ?? 'Data Monitoring' }}')">
                                                <i class="fas fa-times"></i>
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $tab === 'pending' ? 7 : 6 }}" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">
                                            @if ($tab === 'pending')
                                                Tidak ada data monitoring yang menunggu verifikasi.
                                            @else
                                                Tidak ada data monitoring yang telah terverifikasi.
                                            @endif
                                        </p>
                                        @if ($kelurahan_id || $kategori || $warna_badge)
                                            <a href="{{ route('kecamatan.data_monitoring.index', ['tab' => $tab]) }}" class="text-green-500 hover:text-green-700 mt-2 flex items-center gap-1">
                                                <i class="fas fa-redo"></i>
                                                Tampilkan semua data
                                            </a>
                                        @endif
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
                        {{ $dataMonitorings->appends(['tab' => $tab, 'kelurahan_id' => $kelurahan_id, 'kategori' => $kategori, 'warna_badge' => $warna_badge])->links() }}
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal Penolakan -->
    <div id="rejectionModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 500px;">
            <span class="modal-close" onclick="closeRejectionModal()"><i class="fas fa-times"></i></span>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tolak Data Monitoring</h3>
            <p class="text-gray-600 mb-4">Anda akan menolak data monitoring untuk KK: <span id="rejectionMonitoringKK" class="font-semibold"></span></p>
            <form id="rejectionForm" method="POST">
                @csrf
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                <input type="text" name="catatan" id="catatan" placeholder="Masukkan alasan penolakan" class="rejection-input" required>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="px-4 py-2 text-gray-600 hover:text-gray-800" onclick="closeRejectionModal()">Batal</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Tolak Data</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Table row animation
            $('tbody tr').each(function(index) {
                $(this).css({
                    opacity: 0,
                    transform: 'translateY(10px)'
                }).delay(index * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 300);
            });

            // Rejection modal
            window.showRejectionModal = function(monitoringId, monitoringKK) {
                $('#rejectionMonitoringKK').text(monitoringKK);
                $('#rejectionForm').attr('action', '{{ url("kecamatan/data-monitoring") }}/' + monitoringId + '/reject');
                $('#rejectionModal').addClass('active');
                $('#catatan').focus();
            };

            window.closeRejectionModal = function() {
                $('#rejectionModal').removeClass('active');
                $('#catatan').val('');
            };

            // Confirm action
            window.confirmAction = function(action, name) {
                if (action === 'approve') {
                    return confirm('Apakah Anda yakin ingin menyetujui data monitoring untuk ' + name + '?');
                }
                return true;
            };

            // SweetAlert for session messages
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#15803d',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error') || isset($errorMessage))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') ?? $errorMessage }}',
                    confirmButtonColor: '#dc2626',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // Close modal on overlay click
            $(document).on('click', function(e) {
                if ($(e.target).hasClass('modal-overlay')) {
                    $('#rejectionModal').removeClass('active');
                }
            });
        });
    </script>
</body>
</html>