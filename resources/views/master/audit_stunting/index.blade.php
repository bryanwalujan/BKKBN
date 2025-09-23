<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Audit Stunting - CSSR</title>
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
        
        .status-audit {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .status-completed {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
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
        
        .modal-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
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
        
        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        
        .audit-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .audit-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .audit-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .audit-title {
            font-weight: 600;
            color: #1f2937;
            font-size: 16px;
        }
        
        .audit-date {
            color: #6b7280;
            font-size: 14px;
        }
        
        .audit-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .audit-detail {
            display: flex;
            flex-direction: column;
        }
        
        .audit-label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        
        .audit-value {
            font-size: 14px;
            color: #1f2937;
            font-weight: 500;
        }
        
        .audit-narasi {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 12px;
            margin-top: 12px;
        }
        
        .audit-narasi-text {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.5;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        
        .empty-state-icon {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 16px;
        }
        
        @media (max-width: 768px) {
            .audit-details {
                grid-template-columns: 1fr;
            }
            
            .audit-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Audit Stunting</span></h1>
            <p class="text-gray-600">Kelola data audit stunting untuk monitoring dan evaluasi program penanganan stunting.</p>
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
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-6">
            <a href="{{ route('audit_stunting.create') }}" class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition flex items-center gap-2 card-hover">
                <i class="fas fa-plus-circle"></i>
                Tambah Data Audit
            </a>
            <a href="{{ route('balita.index') }}" class="bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-600 transition flex items-center gap-2 card-hover">
                <i class="fas fa-baby"></i>
                Data Balita
            </a>
            <a href="{{ route('peta_geospasial.index') }}" class="bg-purple-500 text-white px-4 py-3 rounded-lg hover:bg-purple-600 transition flex items-center gap-2 card-hover">
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
            <form action="{{ route('audit_stunting.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
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
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition flex items-center gap-2 h-10 w-full justify-center">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if ($kecamatan_id || $kelurahan_id)
                        <a href="{{ route('audit_stunting.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Filter Info -->
        @if ($kecamatan_id || $kelurahan_id)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <div>
                        <span class="font-medium text-blue-800">Filter Aktif:</span>
                        <span class="text-blue-700 ml-2">
                            @if ($kecamatan_id)
                                Kecamatan: {{ $kecamatans->find($kecamatan_id)->nama_kecamatan ?? '-' }}
                            @endif
                            @if ($kelurahan_id)
                                | Kelurahan: {{ \App\Models\Kelurahan::find($kelurahan_id)->nama_kelurahan ?? '-' }}
                            @endif
                            | Total: {{ $auditStuntings->total() }} data
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-100 p-4 mb-6 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-database text-gray-500 mr-2"></i>
                    <span class="text-gray-700">Menampilkan semua data audit stunting ({{ $auditStuntings->total() }} data)</span>
                </div>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-sync-alt mr-1"></i>
                    Data terbaru
                </div>
            </div>
        @endif
        
        <!-- Data Display Options -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Tampilan:</span>
                <button id="cardViewBtn" class="bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-sm font-medium">
                    <i class="fas fa-th-large mr-1"></i> Card
                </button>
                <button id="tableViewBtn" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-md text-sm font-medium">
                    <i class="fas fa-table mr-1"></i> Table
                </button>
            </div>
            <div class="text-sm text-gray-500">
                <i class="fas fa-sort mr-1"></i>
                Diurutkan berdasarkan tanggal terbaru
            </div>
        </div>
        
        <!-- Card View -->
        <div id="cardView" class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @forelse ($auditStuntings as $audit)
                <div class="audit-card card-hover">
                    <div class="audit-header">
                        <div class="audit-title">{{ $audit->dataMonitoring->nama ?? 'Data Tidak Tersedia' }}</div>
                        <div class="audit-date">{{ $audit->created_at->format('d M Y') }}</div>
                    </div>
                    
                    <div class="audit-details">
                        <div class="audit-detail">
                            <span class="audit-label">Target</span>
                            <span class="audit-value">{{ $audit->dataMonitoring->target ?? '-' }}</span>
                        </div>
                        <div class="audit-detail">
                            <span class="audit-label">Kecamatan</span>
                            <span class="audit-value">{{ $audit->dataMonitoring->kecamatan->nama_kecamatan ?? '-' }}</span>
                        </div>
                        <div class="audit-detail">
                            <span class="audit-label">Kelurahan</span>
                            <span class="audit-value">{{ $audit->dataMonitoring->kelurahan->nama_kelurahan ?? '-' }}</span>
                        </div>
                        <div class="audit-detail">
                            <span class="audit-label">Pengaudit</span>
                            <span class="audit-value">{{ $audit->user->name ?? '-' }}</span>
                        </div>
                        <div class="audit-detail">
                            <span class="audit-label">Pihak Terkait</span>
                            <span class="audit-value">{{ $audit->pihak_pengaudit ?? '-' }}</span>
                        </div>
                    </div>
                    
                    @if ($audit->narasi)
                        <div class="audit-narasi">
                            <span class="audit-label">Narasi Audit</span>
                            <p class="audit-narasi-text">{{ $audit->narasi }}</p>
                        </div>
                    @endif
                    
                    <div class="flex justify-end mt-4">
                        <div class="action-buttons">
                            <a href="{{ route('audit_stunting.edit', $audit->id) }}" class="action-btn edit">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <button type="button" class="action-btn delete" onclick="showDeleteModal('{{ route('audit_stunting.destroy', $audit->id) }}', '{{ $audit->dataMonitoring->nama ?? 'Data Audit' }}')">
                                <i class="fas fa-trash"></i>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-600 mb-2">Tidak ada data audit</h3>
                        <p class="text-gray-500 mb-4">Belum ada data audit stunting yang tercatat.</p>
                        <a href="{{ route('audit_stunting.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition inline-flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Tambah Data Audit
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Table View -->
        <div id="tableView" class="bg-white rounded-xl shadow-sm overflow-hidden card-hover" style="display: none;">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-blue-500"></i>
                        Data Audit Stunting
                    </h3>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $auditStuntings->currentPage() }} dari {{ $auditStuntings->lastPage() }}
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
                            <th class="p-4 text-left font-medium text-gray-700">Pihak Pengaudit</th>
                            <th class="p-4 text-left font-medium text-gray-700">Laporan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Narasi</th>
                            <th class="p-4 text-left font-medium text-gray-700">Pengaudit</th>
                            <th class="p-4 text-left font-medium text-gray-700">Tanggal</th>
                            <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($auditStuntings as $audit)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                                <td class="p-4 text-gray-600">{{ $loop->iteration + ($auditStuntings->firstItem() - 1) }}</td>
                                <td class="p-4 font-medium text-gray-800">{{ $audit->dataMonitoring->nama ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $audit->dataMonitoring->target ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $audit->dataMonitoring->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $audit->dataMonitoring->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $audit->pihak_pengaudit ?? '-' }}</td>
                                <td class="p-4 text-gray-600 text-truncate" title="{{ $audit->laporan ?? '-' }}">{{ $audit->laporan ? Str::limit($audit->laporan, 50) : '-' }}</td>
                                <td class="p-4 text-gray-600 text-truncate" title="{{ $audit->narasi ?? '-' }}">{{ $audit->narasi ? Str::limit($audit->narasi, 50) : '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $audit->user->name ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $audit->created_at->format('d/m/Y') }}</td>
                                <td class="p-4">
                                    <div class="action-buttons">
                                        <a href="{{ route('audit_stunting.edit', $audit->id) }}" class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="action-btn delete" onclick="showDeleteModal('{{ route('audit_stunting.destroy', $audit->id) }}', '{{ $audit->dataMonitoring->nama ?? 'Data Audit' }}')">
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
                                        <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data audit yang sesuai dengan filter.</p>
                                        <a href="{{ route('audit_stunting.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 flex items-center gap-1">
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
            @if ($auditStuntings->hasPages())
                <div class="p-4 border-t border-gray-200">
                    <div class="pagination flex justify-center">
                        {{ $auditStuntings->appends(['kecamatan_id' => $kecamatan_id, 'kelurahan_id' => $kelurahan_id])->links() }}
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

            // Update kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kelurahan_id').empty();
                            $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
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
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
            });

            // View toggle functionality
            $('#cardViewBtn').on('click', function() {
                $('#cardView').show();
                $('#tableView').hide();
                $(this).addClass('bg-blue-100 text-blue-600').removeClass('bg-gray-100 text-gray-600');
                $('#tableViewBtn').addClass('bg-gray-100 text-gray-600').removeClass('bg-blue-100 text-blue-600');
            });

            $('#tableViewBtn').on('click', function() {
                $('#tableView').show();
                $('#cardView').hide();
                $(this).addClass('bg-blue-100 text-blue-600').removeClass('bg-gray-100 text-gray-600');
                $('#cardViewBtn').addClass('bg-gray-100 text-gray-600').removeClass('bg-blue-100 text-blue-600');
            });

            // Delete modal with SweetAlert2
            window.showDeleteModal = function(url, name) {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Apakah Anda yakin ingin menghapus data audit untuk <span class="font-bold text-red-600">${name}</span>? Tindakan ini tidak dapat dibatalkan.`,
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