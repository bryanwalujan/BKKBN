<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ibu Hamil - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #8b5cf6;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .badge-verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-trimester-1 {
            background-color: #fce7f3;
            color: #be185d;
        }
        
        .badge-trimester-2 {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .badge-trimester-3 {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-gizi-baik {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-gizi-kurang {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .badge-gizi-buruk {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }
        
        .table-container table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8fafc;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
        
        .search-box input {
            padding-left: 40px;
        }
        
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: scale(1.05);
        }
        
        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            margin: 0 2px;
            font-weight: 500;
        }
        
        .pagination .page-link.active {
            background-color: #8b5cf6;
            color: white;
        }
        
        .select2-container--default .select2-selection--single {
            height: 48px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
            padding-left: 0;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        
        .tab-active {
            background-color: #f3f4f6;
            color: #8b5cf6;
            font-weight: 600;
        }
        
        .status-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        
        .status-trimester-1 { background-color: #fce7f3; color: #be185d; }
        .status-trimester-2 { background-color: #f3e8ff; color: #7c3aed; }
        .status-trimester-3 { background-color: #dbeafe; color: #1e40af; }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }
        
        .progress-trimester-1 { background-color: #ec4899; }
        .progress-trimester-2 { background-color: #8b5cf6; }
        .progress-trimester-3 { background-color: #3b82f6; }
    </style>
</head>
<body class="bg-gray-50">
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Ibu Hamil</h1>
                    <p class="text-gray-600">Kelola data ibu hamil di wilayah {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
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
        
        <!-- Tab Navigation -->
        <div class="bg-white rounded-xl shadow-sm p-1 mb-6 inline-flex">
            <a href="{{ route('kelurahan.ibu_hamil.index', ['tab' => 'pending', 'search' => $search, 'category' => $category]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'pending' ? 'bg-purple-50 text-purple-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-clock mr-2"></i>
                <span>Menunggu Verifikasi</span>
                @if($tab == 'pending')
                <span class="ml-2 bg-purple-100 text-purple-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $ibuHamils->total() }}
                </span>
                @endif
            </a>
            <a href="{{ route('kelurahan.ibu_hamil.index', ['tab' => 'verified', 'search' => $search, 'category' => $category]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'verified' ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Terverifikasi</span>
                @if($tab == 'verified')
                <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $ibuHamils->total() }}
                </span>
                @endif
            </a>
        </div>
        
        <!-- Action Bar -->
        <div class="bg-white rounded-xl shadow-sm p-5 mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="w-full md:w-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Kelola Data Ibu Hamil</h3>
                    <p class="text-gray-600 text-sm">Cari, filter, dan kelola data ibu hamil dengan mudah</p>
                </div>
                
                @if ($tab == 'pending')
                <a href="{{ route('kelurahan.ibu_hamil.create') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-5 py-2.5 rounded-lg hover:from-purple-600 hover:to-purple-700 transition flex items-center shadow-md action-btn">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Tambah Data Ibu Hamil</span>
                </a>
                @endif
            </div>
            
            <!-- Search and Filter -->
            <div class="mt-6">
                <form method="GET" action="{{ route('kelurahan.ibu_hamil.index') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    
                    <div class="search-box flex-1">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK ibu hamil" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    
                    <div class="flex gap-4">
                        <select name="category" id="category" class="border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 w-48">
                            <option value="">Semua Trimester</option>
                            <option value="Trimester 1" {{ $category == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                            <option value="Trimester 2" {{ $category == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                            <option value="Trimester 3" {{ $category == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                        </select>
                        
                        <button type="submit" class="bg-purple-500 text-white px-5 py-3 rounded-lg hover:bg-purple-600 transition flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            <span>Terapkan Filter</span>
                        </button>
                        
                        @if($search || $category)
                        <a href="{{ route('kelurahan.ibu_hamil.index', ['tab' => $tab]) }}" class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            <span>Reset</span>
                        </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-5 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Daftar Ibu Hamil 
                        <span class="text-purple-500">({{ $ibuHamils->total() }} data ditemukan)</span>
                    </h3>
                    
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $ibuHamils->firstItem() ?? 0 }} - {{ $ibuHamils->lastItem() ?? 0 }} dari {{ $ibuHamils->total() }} data
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-4 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Nama Ibu</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">NIK</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Trimester</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Usia Kehamilan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Status Gizi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Status Data</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($ibuHamils as $index => $ibuHamil)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">{{ $ibuHamils->firstItem() + $index }}</td>
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-purple-500"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $ibuHamil->pendingIbu->nama ?? $ibuHamil->ibu->nama }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $ibuHamil->pendingIbu->nik ?? $ibuHamil->ibu->nik ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-700">{{ $ibuHamil->pendingIbu->nik ?? $ibuHamil->ibu->nik ?? '-' }}</td>
                            <td class="p-4">
                                @php
                                    $trimesterClass = 'badge-trimester-1';
                                    $statusIconClass = 'status-trimester-1';
                                    $progressClass = 'progress-trimester-1';
                                    $progressWidth = '33%';
                                    
                                    if ($ibuHamil->trimester == 'Trimester 2') {
                                        $trimesterClass = 'badge-trimester-2';
                                        $statusIconClass = 'status-trimester-2';
                                        $progressClass = 'progress-trimester-2';
                                        $progressWidth = '66%';
                                    } elseif ($ibuHamil->trimester == 'Trimester 3') {
                                        $trimesterClass = 'badge-trimester-3';
                                        $statusIconClass = 'status-trimester-3';
                                        $progressClass = 'progress-trimester-3';
                                        $progressWidth = '100%';
                                    }
                                @endphp
                                
                                <div class="flex items-center">
                                    <div class="status-icon {{ $statusIconClass }}">
                                        <i class="fas fa-baby"></i>
                                    </div>
                                    <div>
                                        <span class="badge {{ $trimesterClass }}">{{ $ibuHamil->trimester }}</span>
                                        <div class="progress-bar mt-1 w-20">
                                            <div class="progress-fill {{ $progressClass }}" style="width: {{ $progressWidth }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900">{{ $ibuHamil->usia_kehamilan }} minggu</div>
                                    <div class="text-gray-500 text-xs">HPL: {{ $ibuHamil->hpl ?? 'Tidak tersedia' }}</div>
                                </div>
                            </td>
                            <td class="p-4">
                                @php
                                    $giziClass = 'badge-gizi-baik';
                                    $giziIcon = 'fas fa-heart';
                                    
                                    if (strpos(strtolower($ibuHamil->status_gizi), 'kurang') !== false) {
                                        $giziClass = 'badge-gizi-kurang';
                                        $giziIcon = 'fas fa-exclamation-triangle';
                                    } elseif (strpos(strtolower($ibuHamil->status_gizi), 'buruk') !== false) {
                                        $giziClass = 'badge-gizi-buruk';
                                        $giziIcon = 'fas fa-times-circle';
                                    }
                                @endphp
                                
                                <div class="flex items-center">
                                    <i class="{{ $giziIcon }} mr-2 text-gray-500"></i>
                                    <span class="badge {{ $giziClass }}">{{ $ibuHamil->status_gizi }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($ibuHamil->source == 'verified')
                                <span class="badge badge-verified text-xs">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                                @else
                                <span class="badge badge-pending text-xs">
                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kelurahan.ibu_hamil.edit', ['id' => $ibuHamil->id, 'source' => $ibuHamil->source]) }}" 
                                       class="bg-blue-100 text-blue-600 p-2 rounded-lg hover:bg-blue-200 transition action-btn" 
                                       title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if ($ibuHamil->source == 'pending')
                                    <button type="button" 
                                            class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200 transition action-btn" 
                                            title="Hapus Data"
                                            onclick="showDeleteModal('{{ route('kelurahan.ibu_hamil.destroy', $ibuHamil->id) }}', '{{ $ibuHamil->pendingIbu->nama ?? $ibuHamil->ibu->nama }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                    
                                    <!-- Detail Button -->
                                    <button class="bg-gray-100 text-gray-600 p-2 rounded-lg hover:bg-gray-200 transition action-btn" 
                                            title="Lihat Detail"
                                            onclick="showDetailModal({{ $ibuHamil }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <h3 class="text-lg font-medium text-gray-500">Tidak ada data ditemukan</h3>
                                    <p class="text-gray-400 mt-1">Coba ubah filter pencarian atau tambahkan data baru</p>
                                    @if ($tab == 'pending')
                                    <a href="{{ route('kelurahan.ibu_hamil.create') }}" class="mt-4 bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition">
                                        <i class="fas fa-plus mr-2"></i> Tambah Data Ibu Hamil
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
            @if($ibuHamils->hasPages())
            <div class="p-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $ibuHamils->firstItem() ?? 0 }} - {{ $ibuHamils->lastItem() ?? 0 }} dari {{ $ibuHamils->total() }} data
                    </div>
                    
                    <div class="pagination flex space-x-1">
                        <!-- Previous Page Link -->
                        @if ($ibuHamils->onFirstPage())
                            <span class="page-link bg-gray-100 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $ibuHamils->previousPageUrl() }}&tab={{ $tab }}&search={{ $search }}&category={{ $category }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($ibuHamils->getUrlRange(1, $ibuHamils->lastPage()) as $page => $url)
                            @if ($page == $ibuHamils->currentPage())
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}&tab={{ $tab }}&search={{ $search }}&category={{ $category }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($ibuHamils->hasMorePages())
                            <a href="{{ $ibuHamils->nextPageUrl() }}&tab={{ $tab }}&search={{ $search }}&category={{ $category }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="page-link bg-gray-100 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Detail Data Ibu Hamil</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-red-600 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Konfirmasi Penghapusan
                </h3>
            </div>
            <div class="p-6">
                <p class="mb-4 text-gray-700">Apakah Anda yakin ingin menghapus data ibu hamil <span id="deleteName" class="font-bold text-gray-900"></span>?</p>
                <p class="mb-6 text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan dan data akan dihapus secara permanen.</p>
                
                <div id="secondConfirm" class="hidden mb-4 p-4 bg-red-50 rounded-lg border border-red-200">
                    <p class="text-red-700 font-medium flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Konfirmasi sekali lagi
                    </p>
                    <p class="text-red-600 text-sm mt-1">Data akan dihapus permanen. Lanjutkan?</p>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button id="cancelDelete" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button id="confirmDelete" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                        Ya, Lanjutkan
                    </button>
                    <form id="deleteForm" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="finalDelete" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Hapus Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category').select2({
                placeholder: "Semua Trimester",
                allowClear: true,
                width: '100%'
            });
        });

        function showDetailModal(ibuHamil) {
            // Format data untuk ditampilkan
            const modalContent = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                <i class="fas fa-user text-purple-500 text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800">${ibuHamil.pending_ibu?.nama || ibuHamil.ibu?.nama || 'Nama tidak tersedia'}</h4>
                                <p class="text-gray-600">${ibuHamil.pending_ibu?.nik || ibuHamil.ibu?.nik || 'Tidak ada NIK'}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-baby text-purple-500 mr-2"></i> Informasi Kehamilan
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Trimester</span>
                                <span class="font-medium">${ibuHamil.trimester || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Usia Kehamilan</span>
                                <span class="font-medium">${ibuHamil.usia_kehamilan || 'Tidak Diketahui'} minggu</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">HPL</span>
                                <span class="font-medium">${ibuHamil.hpl || 'Tidak tersedia'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-heartbeat text-red-500 mr-2"></i> Status Kesehatan
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Gizi</span>
                                <span class="font-medium">${ibuHamil.status_gizi || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Berat Badan</span>
                                <span class="font-medium">${ibuHamil.berat_badan || 'Tidak tersedia'} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tinggi Badan</span>
                                <span class="font-medium">${ibuHamil.tinggi_badan || 'Tidak tersedia'} cm</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-file-medical text-blue-500 mr-2"></i> Data Medis
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tekanan Darah</span>
                                <span class="font-medium">${ibuHamil.tekanan_darah || 'Tidak tersedia'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Lingkar Lengan</span>
                                <span class="font-medium">${ibuHamil.lingkar_lengan || 'Tidak tersedia'} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Riwayat Penyakit</span>
                                <span class="font-medium">${ibuHamil.riwayat_penyakit || 'Tidak ada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-2">
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tags text-amber-500 mr-2"></i> Status & Keterangan
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Data</span>
                                <span class="${ibuHamil.source == 'verified' ? 'badge badge-verified' : 'badge badge-pending'}">
                                    ${ibuHamil.source == 'verified' ? '<i class="fas fa-check-circle mr-1"></i> Terverifikasi' : '<i class="fas fa-clock mr-1"></i> Menunggu'}
                                </span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600 block mb-1">Keterangan:</span>
                                <p class="bg-gray-50 p-3 rounded-lg">${ibuHamil.keterangan || 'Tidak ada keterangan'}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Set modal content and show
            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('detailModal').classList.remove('hidden');
        }
        
        // Close detail modal functionality
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('detailModal').classList.add('hidden');
        });
        
        // Close detail modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        // Delete modal functionality
        function showDeleteModal(url, name) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = url;
            document.getElementById('secondConfirm').classList.add('hidden');
            document.getElementById('confirmDelete').classList.remove('hidden');
            document.getElementById('finalDelete').classList.add('hidden');
        }

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });

        document.getElementById('confirmDelete').addEventListener('click', function() {
            document.getElementById('secondConfirm').classList.remove('hidden');
            document.getElementById('confirmDelete').classList.add('hidden');
            document.getElementById('finalDelete').classList.remove('hidden');
        });
    </script>
</body>
</html>