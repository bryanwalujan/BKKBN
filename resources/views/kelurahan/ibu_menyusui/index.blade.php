<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ibu Menyusui - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            background: linear-gradient(90deg, #3b82f6, #06b6d4);
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
        
        .badge-eksklusif {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-non-eksklusif {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .badge-hijau {
            background-color: #10b981;
            color: white;
        }
        
        .badge-kuning {
            background-color: #f59e0b;
            color: white;
        }
        
        .badge-merah {
            background-color: #ef4444;
            color: white;
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
            background-color: #3b82f6;
            color: white;
        }
        
        .tab-active {
            background-color: #f3f4f6;
            color: #3b82f6;
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
        
        .status-hijau { background-color: #d1fae5; color: #065f46; }
        .status-kuning { background-color: #fef3c7; color: #d97706; }
        .status-merah { background-color: #fecaca; color: #dc2626; }
        
        .health-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        .health-hijau { background-color: #10b981; }
        .health-kuning { background-color: #f59e0b; }
        .health-merah { background-color: #ef4444; }
        
        .foto-container {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3f4f6;
        }
        
        .foto-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Ibu Menyusui</h1>
                    <p class="text-gray-600">Kelola data ibu menyusui di wilayah {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</p>
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
            <a href="{{ route('kelurahan.ibu_menyusui.index', ['tab' => 'pending', 'search' => $search, 'category' => $category]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'pending' ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-clock mr-2"></i>
                <span>Menunggu Verifikasi</span>
                @if($tab == 'pending')
                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $ibuMenyusuis->total() }}
                </span>
                @endif
            </a>
            <a href="{{ route('kelurahan.ibu_menyusui.index', ['tab' => 'verified', 'search' => $search, 'category' => $category]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'verified' ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Terverifikasi</span>
                @if($tab == 'verified')
                <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $ibuMenyusuis->total() }}
                </span>
                @endif
            </a>
        </div>
        
        <!-- Action Bar -->
        <div class="bg-white rounded-xl shadow-sm p-5 mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="w-full md:w-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Kelola Data Ibu Menyusui</h3>
                    <p class="text-gray-600 text-sm">Cari, filter, dan kelola data ibu menyusui dengan mudah</p>
                </div>
                
                @if ($tab == 'pending')
                <a href="{{ route('kelurahan.ibu_menyusui.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex items-center shadow-md action-btn">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Tambah Data Ibu Menyusui</span>
                </a>
                @endif
            </div>
            
            <!-- Search and Filter -->
            <div class="mt-6">
                <form method="GET" action="{{ route('kelurahan.ibu_menyusui.index') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    
                    <div class="search-box flex-1">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK ibu" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="flex gap-4">
                        <select name="category" id="category" class="border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-48">
                            <option value="">Semua Status Menyusui</option>
                            <option value="Eksklusif" {{ $category == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                            <option value="Non-Eksklusif" {{ $category == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                        </select>
                        
                        <button type="submit" class="bg-blue-500 text-white px-5 py-3 rounded-lg hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            <span>Terapkan Filter</span>
                        </button>
                        
                        @if($search || $category)
                        <a href="{{ route('kelurahan.ibu_menyusui.index', ['tab' => $tab]) }}" class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition flex items-center">
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
                        Daftar Ibu Menyusui 
                        <span class="text-blue-500">({{ $ibuMenyusuis->total() }} data ditemukan)</span>
                    </h3>
                    
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $ibuMenyusuis->firstItem() ?? 0 }} - {{ $ibuMenyusuis->lastItem() ?? 0 }} dari {{ $ibuMenyusuis->total() }} data
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-4 text-left text-sm font-medium text-gray-500">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Foto</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Nama Ibu</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Kelurahan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Kecamatan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Status Menyusui</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Frekuensi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Kondisi Ibu</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Warna Kondisi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Berat/Tinggi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($ibuMenyusuis as $index => $ibu)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-gray-700 font-medium">{{ $ibuMenyusuis->firstItem() + $index }}</td>
                            <td class="p-4">
                                <div class="foto-container">
                                    @if ($tab == 'verified' && $ibu->ibu->foto)
                                        <img src="{{ Storage::url($ibu->ibu->foto) }}" alt="Foto Ibu Menyusui">
                                    @elseif ($tab == 'pending' && $ibu->pendingIbu->foto)
                                        <img src="{{ Storage::url($ibu->pendingIbu->foto) }}" alt="Foto Ibu Menyusui">
                                    @else
                                        <i class="fas fa-user-circle text-gray-400 text-2xl"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-gray-900">{{ $tab == 'verified' ? $ibu->ibu->nama : $ibu->pendingIbu->nama }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($ibu->status_verifikasi == 'verified')
                                    <span class="badge badge-verified text-xs">
                                        <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                    </span>
                                    @else
                                    <span class="badge badge-pending text-xs">
                                        <i class="fas fa-clock mr-1"></i> Menunggu
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-gray-700">{{ $tab == 'verified' ? ($ibu->ibu->kelurahan->nama_kelurahan ?? '-') : ($ibu->pendingIbu->kelurahan->nama_kelurahan ?? '-') }}</td>
                            <td class="p-4 text-gray-700">{{ $tab == 'verified' ? ($ibu->ibu->kecamatan->nama_kecamatan ?? '-') : ($ibu->pendingIbu->kecamatan->nama_kecamatan ?? '-') }}</td>
                            <td class="p-4">
                                @php
                                    $badgeClass = $ibu->status_menyusui == 'Eksklusif' ? 'badge-eksklusif' : 'badge-non-eksklusif';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $ibu->status_menyusui }}</span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="status-icon bg-blue-100 text-blue-600">
                                        <i class="fas fa-baby"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $ibu->frekuensi_menyusui }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-gray-700">{{ $ibu->kondisi_ibu }}</td>
                            <td class="p-4">
                                @php
                                    $badgeClass = 'badge-hijau';
                                    $healthClass = 'health-hijau';
                                    if ($ibu->warna_kondisi == 'Kuning (warning)') {
                                        $badgeClass = 'badge-kuning';
                                        $healthClass = 'health-kuning';
                                    } elseif ($ibu->warna_kondisi == 'Merah (danger)') {
                                        $badgeClass = 'badge-merah';
                                        $healthClass = 'health-merah';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <span class="health-indicator {{ $healthClass }}"></span>
                                    {{ $ibu->warna_kondisi }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900">{{ $ibu->berat }} kg</div>
                                    <div class="text-gray-500">{{ $ibu->tinggi }} cm</div>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($ibu->status_verifikasi == 'verified')
                                <span class="badge badge-verified">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                                @else
                                <span class="badge badge-pending">
                                    <i class="fas fa-clock mr-1"></i> Menunggu
                                </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kelurahan.ibu_menyusui.edit', [$ibu->id, $tab]) }}" 
                                       class="bg-blue-100 text-blue-600 p-2 rounded-lg hover:bg-blue-200 transition action-btn" 
                                       title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if ($tab == 'pending')
                                    <button type="button" 
                                            class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200 transition action-btn" 
                                            title="Hapus Data"
                                            onclick="showDeleteModal('{{ route('kelurahan.ibu_menyusui.destroy', $ibu->id) }}', '{{ $tab == 'verified' ? $ibu->ibu->nama : $ibu->pendingIbu->nama }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                    
                                    <!-- Detail Button -->
                                    <button class="bg-gray-100 text-gray-600 p-2 rounded-lg hover:bg-gray-200 transition action-btn" 
                                            title="Lihat Detail"
                                            onclick="showDetailModal({{ json_encode($ibu) }}, '{{ $tab }}')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="p-8 text-center">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                    <h3 class="text-lg font-medium text-gray-500">Tidak ada data ditemukan</h3>
                                    <p class="text-gray-400 mt-1">Coba ubah filter pencarian atau tambahkan data baru</p>
                                    @if ($tab == 'pending')
                                    <a href="{{ route('kelurahan.ibu_menyusui.create') }}" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                                        <i class="fas fa-plus mr-2"></i> Tambah Data Ibu Menyusui
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
            @if($ibuMenyusuis->hasPages())
            <div class="p-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $ibuMenyusuis->firstItem() ?? 0 }} - {{ $ibuMenyusuis->lastItem() ?? 0 }} dari {{ $ibuMenyusuis->total() }} data
                    </div>
                    
                    <div class="pagination flex space-x-1">
                        <!-- Previous Page Link -->
                        @if ($ibuMenyusuis->onFirstPage())
                            <span class="page-link bg-gray-100 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $ibuMenyusuis->previousPageUrl() }}&tab={{ $tab }}&search={{ $search }}&category={{ $category }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($ibuMenyusuis->getUrlRange(1, $ibuMenyusuis->lastPage()) as $page => $url)
                            @if ($page == $ibuMenyusuis->currentPage())
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}&tab={{ $tab }}&search={{ $search }}&category={{ $category }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($ibuMenyusuis->hasMorePages())
                            <a href="{{ $ibuMenyusuis->nextPageUrl() }}&tab={{ $tab }}&search={{ $search }}&category={{ $category }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
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
                <h3 class="text-xl font-semibold text-gray-800">Detail Data Ibu Menyusui</h3>
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
                <p class="mb-4 text-gray-700">Apakah Anda yakin ingin menghapus data ibu menyusui <span id="deleteName" class="font-bold text-gray-900"></span>?</p>
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

    <script>
        function showDetailModal(ibu, tab) {
            // Format data untuk ditampilkan
            const modalContent = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 rounded-full overflow-hidden mr-4 flex-shrink-0 bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-user text-blue-500 text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800">${tab === 'verified' ? ibu.ibu.nama : ibu.pending_ibu.nama}</h4>
                                <p class="text-gray-600">${tab === 'verified' ? ibu.ibu.nik : ibu.pending_ibu.nik}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-baby text-blue-500 mr-2"></i> Informasi Menyusui
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Menyusui</span>
                                <span class="font-medium">${ibu.status_menyusui}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Frekuensi Menyusui</span>
                                <span class="font-medium">${ibu.frekuensi_menyusui}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kondisi Ibu</span>
                                <span class="font-medium">${ibu.kondisi_ibu}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-weight text-green-500 mr-2"></i> Data Fisik
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Berat Badan</span>
                                <span class="font-medium">${ibu.berat} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tinggi Badan</span>
                                <span class="font-medium">${ibu.tinggi} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Warna Kondisi</span>
                                <span class="font-medium">${ibu.warna_kondisi}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-2">
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt text-amber-500 mr-2"></i> Lokasi
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kelurahan</span>
                                <span class="font-medium">${tab === 'verified' ? (ibu.ibu.kelurahan ? ibu.ibu.kelurahan.nama_kelurahan : '-') : (ibu.pending_ibu.kelurahan ? ibu.pending_ibu.kelurahan.nama_kelurahan : '-')}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kecamatan</span>
                                <span class="font-medium">${tab === 'verified' ? (ibu.ibu.kecamatan ? ibu.ibu.kecamatan.nama_kecamatan : '-') : (ibu.pending_ibu.kecamatan ? ibu.pending_ibu.kecamatan.nama_kecamatan : '-')}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-2">
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tags text-amber-500 mr-2"></i> Status & Keterangan
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Verifikasi</span>
                                <span class="${ibu.status_verifikasi == 'verified' ? 'badge badge-verified' : 'badge badge-pending'}">
                                    ${ibu.status_verifikasi == 'verified' ? '<i class="fas fa-check-circle mr-1"></i> Terverifikasi' : '<i class="fas fa-clock mr-1"></i> Menunggu'}
                                </span>
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