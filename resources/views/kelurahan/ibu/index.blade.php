<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ibu - CSSR</title>
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
        
        .badge-hamil {
            background-color: #fce7f3;
            color: #be185d;
        }
        
        .badge-nifas {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .badge-menyusui {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-tidak-aktif {
            background-color: #f1f5f9;
            color: #475569;
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
        
        .status-hamil { background-color: #fce7f3; color: #be185d; }
        .status-nifas { background-color: #f3e8ff; color: #7c3aed; }
        .status-menyusui { background-color: #dbeafe; color: #1e40af; }
        .status-tidak-aktif { background-color: #f1f5f9; color: #475569; }
    </style>
</head>
<body class="bg-gray-50">
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Ibu</h1>
                    <p class="text-gray-600">Kelola data ibu di wilayah {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</p>
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
            <a href="{{ route('kelurahan.ibu.index', ['tab' => 'pending', 'search' => $search, 'status' => $status]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'pending' ? 'bg-purple-50 text-purple-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-clock mr-2"></i>
                <span>Menunggu Verifikasi</span>
                @if($tab == 'pending')
                <span class="ml-2 bg-purple-100 text-purple-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $ibus->total() }}
                </span>
                @endif
            </a>
            <a href="{{ route('kelurahan.ibu.index', ['tab' => 'verified', 'search' => $search, 'status' => $status]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'verified' ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Terverifikasi</span>
                @if($tab == 'verified')
                <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $ibus->total() }}
                </span>
                @endif
            </a>
        </div>
        
        <!-- Action Bar -->
        <div class="bg-white rounded-xl shadow-sm p-5 mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="w-full md:w-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Kelola Data Ibu</h3>
                    <p class="text-gray-600 text-sm">Cari, filter, dan kelola data ibu dengan mudah</p>
                </div>
                
                @if ($tab == 'pending')
                <a href="{{ route('kelurahan.ibu.create') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-5 py-2.5 rounded-lg hover:from-purple-600 hover:to-purple-700 transition flex items-center shadow-md action-btn">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Tambah Data Ibu</span>
                </a>
                @endif
            </div>
            
            <!-- Search and Filter -->
            <div class="mt-6">
                <form method="GET" action="{{ route('kelurahan.ibu.index') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    
                    <div class="search-box flex-1">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK ibu" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    
                    <div class="flex gap-4">
                        <select name="status" id="status" class="border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 w-48">
                            <option value="">Semua Status</option>
                            <option value="Hamil" {{ $status == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                            <option value="Nifas" {{ $status == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                            <option value="Menyusui" {{ $status == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                            <option value="Tidak Aktif" {{ $status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        
                        <button type="submit" class="bg-purple-500 text-white px-5 py-3 rounded-lg hover:bg-purple-600 transition flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            <span>Terapkan Filter</span>
                        </button>
                        
                        @if($search || $status)
                        <a href="{{ route('kelurahan.ibu.index', ['tab' => $tab]) }}" class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition flex items-center">
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
                        Daftar Ibu 
                        <span class="text-purple-500">({{ $ibus->total() }} data ditemukan)</span>
                    </h3>
                    
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $ibus->firstItem() ?? 0 }} - {{ $ibus->lastItem() ?? 0 }} dari {{ $ibus->total() }} data
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-4 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Foto & Nama</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">NIK</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Kecamatan/Kelurahan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Kartu Keluarga</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Alamat</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($ibus as $index => $ibu)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">{{ $ibus->firstItem() + $index }}</td>
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full overflow-hidden mr-3 flex-shrink-0">
                                        @if ($ibu->foto)
                                            <img src="{{ Storage::url($ibu->foto) }}" alt="Foto {{ $ibu->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-purple-100 flex items-center justify-center">
                                                <i class="fas fa-user text-purple-500 text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $ibu->nama }}</div>
                                        <div class="text-xs text-gray-500">
                                            @if($ibu->source == 'verified')
                                            <span class="badge badge-verified text-xs">
                                                <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                            </span>
                                            @else
                                            <span class="badge badge-pending text-xs">
                                                <i class="fas fa-clock mr-1"></i> Menunggu
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-700">{{ $ibu->nik ?? '-' }}</td>
                            <td class="p-4">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900">{{ $ibu->kecamatan->nama_kecamatan ?? '-' }}</div>
                                    <div class="text-gray-500">{{ $ibu->kelurahan->nama_kelurahan ?? '-' }}</div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900">{{ $ibu->kartuKeluarga->no_kk ?? '-' }}</div>
                                    <div class="text-gray-500">{{ $ibu->kartuKeluarga->kepala_keluarga ?? '-' }}</div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-700 max-w-xs truncate">{{ $ibu->alamat ?? '-' }}</td>
                            <td class="p-4">
                                @php
                                    $statusClass = 'status-tidak-aktif';
                                    $badgeClass = 'badge-tidak-aktif';
                                    $statusIcon = 'fas fa-user';
                                    
                                    if ($ibu->status == 'Hamil') {
                                        $statusClass = 'status-hamil';
                                        $badgeClass = 'badge-hamil';
                                        $statusIcon = 'fas fa-baby';
                                    } elseif ($ibu->status == 'Nifas') {
                                        $statusClass = 'status-nifas';
                                        $badgeClass = 'badge-nifas';
                                        $statusIcon = 'fas fa-bed';
                                    } elseif ($ibu->status == 'Menyusui') {
                                        $statusClass = 'status-menyusui';
                                        $badgeClass = 'badge-menyusui';
                                        $statusIcon = 'fas fa-child';
                                    }
                                @endphp
                                
                                <div class="flex items-center">
                                    <div class="status-icon {{ $statusClass }}">
                                        <i class="{{ $statusIcon }}"></i>
                                    </div>
                                    <span class="badge {{ $badgeClass }}">{{ $ibu->status }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kelurahan.ibu.edit', ['id' => $ibu->id, 'source' => $ibu->source]) }}" 
                                       class="bg-blue-100 text-blue-600 p-2 rounded-lg hover:bg-blue-200 transition action-btn" 
                                       title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if ($ibu->source == 'pending')
                                    <button type="button" 
                                            class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200 transition action-btn" 
                                            title="Hapus Data"
                                            onclick="showDeleteModal('{{ route('kelurahan.ibu.destroy', $ibu->id) }}', '{{ $ibu->nama }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                    
                                    <!-- Detail Button -->
                                    <button class="bg-gray-100 text-gray-600 p-2 rounded-lg hover:bg-gray-200 transition action-btn" 
                                            title="Lihat Detail"
                                            onclick="showDetailModal({{ $ibu }})">
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
                                    <a href="{{ route('kelurahan.ibu.create') }}" class="mt-4 bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition">
                                        <i class="fas fa-plus mr-2"></i> Tambah Data Ibu
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
            @if($ibus->hasPages())
            <div class="p-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $ibus->firstItem() ?? 0 }} - {{ $ibus->lastItem() ?? 0 }} dari {{ $ibus->total() }} data
                    </div>
                    
                    <div class="pagination flex space-x-1">
                        <!-- Previous Page Link -->
                        @if ($ibus->onFirstPage())
                            <span class="page-link bg-gray-100 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $ibus->previousPageUrl() }}&tab={{ $tab }}&search={{ $search }}&status={{ $status }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($ibus->getUrlRange(1, $ibus->lastPage()) as $page => $url)
                            @if ($page == $ibus->currentPage())
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}&tab={{ $tab }}&search={{ $search }}&status={{ $status }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($ibus->hasMorePages())
                            <a href="{{ $ibus->nextPageUrl() }}&tab={{ $tab }}&search={{ $search }}&status={{ $status }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
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
                <h3 class="text-xl font-semibold text-gray-800">Detail Data Ibu</h3>
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
                <p class="mb-4 text-gray-700">Apakah Anda yakin ingin menghapus data ibu <span id="deleteName" class="font-bold text-gray-900"></span>?</p>
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
            $('#status').select2({
                placeholder: "Semua Status",
                allowClear: true,
                width: '100%'
            });
        });

        function showDetailModal(ibu) {
            // Format data untuk ditampilkan
            const modalContent = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 rounded-full overflow-hidden mr-4 flex-shrink-0">
                                ${ibu.foto ? 
                                    `<img src="${ibu.foto}" alt="Foto ${ibu.nama}" class="w-full h-full object-cover">` : 
                                    `<div class="w-full h-full bg-purple-100 flex items-center justify-center">
                                        <i class="fas fa-user text-purple-500 text-2xl"></i>
                                    </div>`
                                }
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800">${ibu.nama}</h4>
                                <p class="text-gray-600">${ibu.nik ? 'NIK: ' + ibu.nik : 'Tidak ada NIK'}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-info-circle text-purple-500 mr-2"></i> Informasi Pribadi
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Lahir</span>
                                <span class="font-medium">${ibu.tanggal_lahir || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Usia</span>
                                <span class="font-medium">${ibu.usia || 'Tidak Diketahui'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">No. Telepon</span>
                                <span class="font-medium">${ibu.no_telepon || 'Tidak ada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i> Alamat
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Alamat</span>
                                <span class="font-medium text-right">${ibu.alamat || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kelurahan</span>
                                <span class="font-medium">${ibu.kelurahan?.nama_kelurahan || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kecamatan</span>
                                <span class="font-medium">${ibu.kecamatan?.nama_kecamatan || 'Tidak ada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-home text-blue-500 mr-2"></i> Kartu Keluarga
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">No. KK</span>
                                <span class="font-medium">${ibu.kartu_keluarga?.no_kk || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kepala Keluarga</span>
                                <span class="font-medium">${ibu.kartu_keluarga?.kepala_keluarga || 'Tidak ada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-2">
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tags text-amber-500 mr-2"></i> Status & Keterangan
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="font-medium">${ibu.status || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Data</span>
                                <span class="${ibu.source == 'verified' ? 'badge badge-verified' : 'badge badge-pending'}">
                                    ${ibu.source == 'verified' ? '<i class="fas fa-check-circle mr-1"></i> Terverifikasi' : '<i class="fas fa-clock mr-1"></i> Menunggu'}
                                </span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600 block mb-1">Keterangan:</span>
                                <p class="bg-gray-50 p-3 rounded-lg">${ibu.keterangan || 'Tidak ada keterangan'}</p>
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