<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Balita - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: linear-gradient(90deg, #3b82f6, #10b981);
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
        
        .badge-baduata {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-balita {
            background-color: #dcfce7;
            color: #166534;
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
        
        .progress-bar {
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
            background-color: #e5e7eb;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.5s ease;
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
    </style>
</head>
<body class="bg-gray-50">
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Balita</h1>
                    <p class="text-gray-600">Kelola data balita di wilayah {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</p>
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
            <a href="{{ route('kelurahan.balita.index', ['tab' => 'pending', 'search' => $search, 'kategori_umur' => $kategoriUmur]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'pending' ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-clock mr-2"></i>
                <span>Menunggu Verifikasi</span>
                @if($tab == 'pending')
                <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $balitas->total() }}
                </span>
                @endif
            </a>
            <a href="{{ route('kelurahan.balita.index', ['tab' => 'verified', 'search' => $search, 'kategori_umur' => $kategoriUmur]) }}"
               class="px-6 py-3 rounded-lg flex items-center transition-all duration-300 {{ $tab == 'verified' ? 'bg-green-50 text-green-600 font-medium' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Terverifikasi</span>
                @if($tab == 'verified')
                <span class="ml-2 bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $balitas->total() }}
                </span>
                @endif
            </a>
        </div>
        
        <!-- Action Bar -->
        <div class="bg-white rounded-xl shadow-sm p-5 mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="w-full md:w-auto">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Kelola Data Balita</h3>
                    <p class="text-gray-600 text-sm">Cari, filter, dan kelola data balita dengan mudah</p>
                </div>
                
                @if ($tab == 'pending')
                <a href="{{ route('kelurahan.balita.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex items-center shadow-md action-btn">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Tambah Data Balita</span>
                </a>
                @endif
            </div>
            
            <!-- Search and Filter -->
            <div class="mt-6">
                <form method="GET" action="{{ route('kelurahan.balita.index') }}" class="flex flex-col md:flex-row gap-4">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    
                    <div class="search-box flex-1">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK balita" class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="flex gap-4">
                        <select name="kategori_umur" class="border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori Umur</option>
                            <option value="Baduata" {{ $kategoriUmur == 'Baduata' ? 'selected' : '' }}>Baduata (0-24 bulan)</option>
                            <option value="Balita" {{ $kategoriUmur == 'Balita' ? 'selected' : '' }}>Balita (25-60 bulan)</option>
                        </select>
                        
                        <button type="submit" class="bg-blue-500 text-white px-5 py-3 rounded-lg hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-filter mr-2"></i>
                            <span>Terapkan Filter</span>
                        </button>
                        
                        @if($search || $kategoriUmur)
                        <a href="{{ route('kelurahan.balita.index', ['tab' => $tab]) }}" class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition flex items-center">
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
                        Daftar Balita 
                        <span class="text-blue-500">({{ $balitas->total() }} data ditemukan)</span>
                    </h3>
                    
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $balitas->firstItem() ?? 0 }} - {{ $balitas->lastItem() ?? 0 }} dari {{ $balitas->total() }} data
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Nama Balita</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">NIK</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Usia</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Jenis Kelamin</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Berat/Tinggi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Status Gizi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($balitas as $balita)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-child text-blue-500"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $balita->nama }}</div>
                                        <div class="text-xs text-gray-500">No KK: {{ $balita->kartuKeluarga->no_kk ?? 'Tidak ada' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-700">{{ $balita->nik ?? 'Tidak ada' }}</td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900">{{ $balita->usia ? $balita->usia . ' bulan' : 'Tidak Diketahui' }}</span>
                                    <span class="text-xs">
                                        @if($balita->kategoriUmur == 'Baduata')
                                        <span class="badge badge-baduata">Baduata</span>
                                        @else
                                        <span class="badge badge-balita">Balita</span>
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($balita->jenis_kelamin == 'Laki-laki')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-mars mr-1"></i> Laki-laki
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                    <i class="fas fa-venus mr-1"></i> Perempuan
                                </span>
                                @endif
                            </td>
                            <td class="p-4">
                                @php
                                    $beratTinggi = explode('/', $balita->berat_tinggi ?? '0/0');
                                    $berat = $beratTinggi[0];
                                    $tinggi = $beratTinggi[1] ?? '0';
                                @endphp
                                <div class="text-sm">
                                    <div class="flex items-center">
                                        <i class="fas fa-weight-scale text-gray-400 mr-1 text-xs"></i>
                                        <span>{{ $berat }} kg</span>
                                    </div>
                                    <div class="flex items-center mt-1">
                                        <i class="fas fa-ruler-vertical text-gray-400 mr-1 text-xs"></i>
                                        <span>{{ $tinggi }} cm</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $balita->status_gizi ?? 'Tidak ada' }}</span>
                                    @if($balita->warna_label)
                                    <div class="flex items-center mt-1">
                                        <div class="w-3 h-3 rounded-full mr-1" style="background-color: {{ $balita->warna_label }}"></div>
                                        <span class="text-xs text-gray-500">Label</span>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                @if ($balita->source == 'verified')
                                <span class="badge badge-verified">
                                    <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                </span>
                                @else
                                <span class="badge badge-pending">
                                    <i class="fas fa-clock mr-1"></i> {{ $balita->status }}
                                </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex space-x-2">
                                    @if ($balita->source == 'pending')
                                    <a href="{{ route('kelurahan.balita.edit', ['id' => $balita->id, 'source' => 'pending']) }}" 
                                       class="bg-blue-100 text-blue-600 p-2 rounded-lg hover:bg-blue-200 transition action-btn" 
                                       title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kelurahan.balita.destroy', $balita->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200 transition action-btn" 
                                                title="Hapus Data"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <a href="{{ route('kelurahan.balita.edit', ['id' => $balita->id, 'source' => 'verified']) }}" 
                                       class="bg-blue-100 text-blue-600 p-2 rounded-lg hover:bg-blue-200 transition action-btn" 
                                       title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endif
                                    
                                    <!-- Detail Button -->
                                    <button class="bg-gray-100 text-gray-600 p-2 rounded-lg hover:bg-gray-200 transition action-btn" 
                                            title="Lihat Detail"
                                            onclick="showDetailModal({{ $balita }})">
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
                                    <a href="{{ route('kelurahan.balita.create') }}" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                                        <i class="fas fa-plus mr-2"></i> Tambah Data Balita
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
            @if($balitas->hasPages())
            <div class="p-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-500">
                        Menampilkan {{ $balitas->firstItem() ?? 0 }} - {{ $balitas->lastItem() ?? 0 }} dari {{ $balitas->total() }} data
                    </div>
                    
                    <div class="pagination flex space-x-1">
                        <!-- Previous Page Link -->
                        @if ($balitas->onFirstPage())
                            <span class="page-link bg-gray-100 text-gray-400 cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $balitas->previousPageUrl() }}&tab={{ $tab }}&search={{ $search }}&kategori_umur={{ $kategoriUmur }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($balitas->getUrlRange(1, $balitas->lastPage()) as $page => $url)
                            @if ($page == $balitas->currentPage())
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}&tab={{ $tab }}&search={{ $search }}&kategori_umur={{ $kategoriUmur }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($balitas->hasMorePages())
                            <a href="{{ $balitas->nextPageUrl() }}&tab={{ $tab }}&search={{ $search }}&kategori_umur={{ $kategoriUmur }}" class="page-link bg-white text-gray-700 border border-gray-300 hover:bg-gray-50">
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

    <!-- Detail Modal (akan diisi dengan JavaScript) -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800">Detail Data Balita</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        function showDetailModal(balita) {
            // Format tanggal lahir
            const tanggalLahir = balita.tanggal_lahir ? 
                new Date(balita.tanggal_lahir).toLocaleDateString('id-ID', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                }) : 'Tidak ada';
            
            // Parse berat dan tinggi
            const beratTinggi = (balita.berat_tinggi || '0/0').split('/');
            const berat = beratTinggi[0];
            const tinggi = beratTinggi[1] || '0';
            
            // Tentukan ikon jenis kelamin
            const jkIcon = balita.jenis_kelamin === 'Laki-laki' ? 
                '<i class="fas fa-mars text-blue-500"></i>' : 
                '<i class="fas fa-venus text-pink-500"></i>';
            
            // Tentukan status badge
            const statusBadge = balita.source === 'verified' ? 
                '<span class="badge badge-verified"><i class="fas fa-check-circle mr-1"></i> Terverifikasi</span>' : 
                `<span class="badge badge-pending"><i class="fas fa-clock mr-1"></i> ${balita.status || 'Menunggu'}</span>`;
            
            // Tentukan kategori umur badge
            const kategoriBadge = balita.kategoriUmur === 'Baduata' ? 
                '<span class="badge badge-baduata">Baduata (0-24 bulan)</span>' : 
                '<span class="badge badge-balita">Balita (25-60 bulan)</span>';
            
            // Build modal content
            const modalContent = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-child text-blue-500 text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800">${balita.nama}</h4>
                                <p class="text-gray-600">${balita.nik ? 'NIK: ' + balita.nik : 'Tidak ada NIK'}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i> Informasi Pribadi
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Lahir</span>
                                <span class="font-medium">${tanggalLahir}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Usia</span>
                                <span class="font-medium">${balita.usia ? balita.usia + ' bulan' : 'Tidak Diketahui'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori Umur</span>
                                <span>${kategoriBadge}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Kelamin</span>
                                <span class="font-medium">${jkIcon} ${balita.jenis_kelamin}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-chart-line text-green-500 mr-2"></i> Data Kesehatan
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Berat Badan</span>
                                <span class="font-medium">${berat} kg</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tinggi Badan</span>
                                <span class="font-medium">${tinggi} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Lingkar Kepala</span>
                                <span class="font-medium">${balita.lingkar_kepala || 'Tidak ada'} cm</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Lingkar Lengan</span>
                                <span class="font-medium">${balita.lingkar_lengan || 'Tidak ada'} cm</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt text-purple-500 mr-2"></i> Alamat
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Alamat</span>
                                <span class="font-medium text-right">${balita.alamat || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kelurahan</span>
                                <span class="font-medium">${balita.kelurahan?.nama_kelurahan || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kecamatan</span>
                                <span class="font-medium">${balita.kecamatan?.nama_kecamatan || 'Tidak ada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-tags text-amber-500 mr-2"></i> Klasifikasi
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Gizi</span>
                                <span class="font-medium">${balita.status_gizi || 'Tidak ada'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Warna Label</span>
                                <div class="flex items-center">
                                    ${balita.warna_label ? `<div class="w-4 h-4 rounded-full mr-2" style="background-color: ${balita.warna_label}"></div>` : ''}
                                    <span class="font-medium">${balita.warna_label || 'Tidak ada'}</span>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Pemantauan</span>
                                <span class="font-medium">${balita.status_pemantauan || 'Tidak ada'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-span-2">
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-sticky-note text-gray-500 mr-2"></i> Catatan & Status
                        </h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Data</span>
                                <span>${statusBadge}</span>
                            </div>
                            <div class="mt-2">
                                <span class="text-gray-600 block mb-1">Catatan:</span>
                                <p class="bg-gray-50 p-3 rounded-lg">${balita.catatan || 'Tidak ada catatan'}</p>
                            </div>
                        </div>
                    </div>
                    
                    ${balita.foto ? `
                    <div class="col-span-2">
                        <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                            <i class="fas fa-camera text-red-500 mr-2"></i> Foto
                        </h5>
                        <div class="flex justify-center">
                            <a href="${balita.foto}" target="_blank" class="inline-block">
                                <img src="${balita.foto}" alt="Foto ${balita.nama}" class="max-h-48 rounded-lg shadow-md">
                            </a>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
            
            // Set modal content and show
            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('detailModal').classList.remove('hidden');
        }
        
        // Close modal functionality
        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('detailModal').classList.add('hidden');
        });
        
        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
</body>
</html>