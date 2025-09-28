<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kartu Keluarga - CSSR</title>
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
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-verified {
            background-color: #d1fae5;
            color: #065f46;
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
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .table-row-hover:hover {
            background-color: #f8fafc;
        }
        
        .pagination-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            margin: 0 2px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .pagination-link:hover {
            background-color: #e2e8f0;
        }
        
        .pagination-link.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .search-input {
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
        }
        
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .action-btn {
            transition: all 0.2s ease;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Kartu Keluarga</h1>
                    <p class="text-gray-600">Kelola data kartu keluarga di wilayah {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                <div>
                    <span class="font-medium">Sukses!</span> {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                <div>
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            </div>
        @endif
        
        <!-- Tab Navigasi -->
        <div class="bg-white rounded-xl shadow-sm p-1 mb-6 inline-flex">
            <a href="{{ route('kelurahan.kartu_keluarga.index', ['tab' => 'pending', 'search' => $search]) }}"
               class="px-6 py-3 rounded-lg font-medium flex items-center transition-all {{ $tab == 'pending' ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-clock mr-2"></i>
                Menunggu Verifikasi
                @if($tab == 'pending' && $kartuKeluargas->total() > 0)
                    <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $kartuKeluargas->total() }}</span>
                @endif
            </a>
            <a href="{{ route('kelurahan.kartu_keluarga.index', ['tab' => 'verified', 'search' => $search]) }}"
               class="px-6 py-3 rounded-lg font-medium flex items-center transition-all {{ $tab == 'verified' ? 'bg-green-50 text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-check-circle mr-2"></i>
                Terverifikasi
                @if($tab == 'verified' && $kartuKeluargas->total() > 0)
                    <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $kartuKeluargas->total() }}</span>
                @endif
            </a>
        </div>
        
        <!-- Toolbar: Pencarian dan Tambah Data -->
        <div class="bg-white rounded-xl shadow-sm p-5 mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div class="w-full md:w-auto">
                    <form method="GET" action="{{ route('kelurahan.kartu_keluarga.index') }}" class="flex space-x-2">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        <div class="relative flex-1 md:w-80">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search }}" 
                                   placeholder="Cari nomor KK atau kepala keluarga" 
                                   class="search-input pl-10 pr-4 py-2 w-full rounded-lg focus:outline-none">
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-search mr-2"></i> Cari
                        </button>
                    </form>
                </div>
                
                @if ($tab == 'pending')
                    <a href="{{ route('kelurahan.kartu_keluarga.create') }}" 
                       class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition flex items-center shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Kartu Keluarga
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            @if($kartuKeluargas->count() > 0)
                <div class="table-container">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Nomor KK</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Kepala Keluarga</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Kecamatan</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Kelurahan</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Diupload Oleh</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($kartuKeluargas as $kk)
                                <tr class="table-row-hover">
                                    <td class="p-4 text-sm font-medium text-gray-900">{{ $kk->no_kk }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $kk->kepala_keluarga }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $kk->kecamatan->nama_kecamatan ?? 'Tidak diketahui' }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $kk->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $kk->alamat ?? 'Tidak ada' }}</td>
                                    <td class="p-4">
                                        @if($kk->source == 'verified')
                                            <span class="status-badge status-verified">
                                                <i class="fas fa-check-circle mr-1"></i> {{ $kk->status }}
                                            </span>
                                        @else
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock mr-1"></i> {{ $kk->status_verifikasi }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-700">{{ $kk->createdBy->name ?? 'Tidak diketahui' }}</td>
                                    <td class="p-4">
                                        <div class="flex space-x-2">
                                            @if ($kk->source == 'verified')
                                                <a href="{{ route('kelurahan.kartu_keluarga.show', $kk->id) }}" 
                                                   class="action-btn bg-green-100 text-green-700 hover:bg-green-200">
                                                    <i class="fas fa-eye mr-1"></i> Detail
                                                </a>
                                            @endif
                                            
                                            @if ($kk->source == 'pending')
                                                <a href="{{ route('kelurahan.kartu_keluarga.edit', ['id' => $kk->id, 'source' => 'pending']) }}" 
                                                   class="action-btn bg-blue-100 text-blue-700 hover:bg-blue-200">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                                <form action="{{ route('kelurahan.kartu_keluarga.destroy', $kk->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="action-btn bg-red-100 text-red-700 hover:bg-red-200"
                                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('kelurahan.kartu_keluarga.edit', ['id' => $kk->id, 'source' => 'verified']) }}" 
                                                   class="action-btn bg-blue-100 text-blue-700 hover:bg-blue-200">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3 class="text-xl font-semibold text-gray-500 mb-2">Tidak ada data ditemukan</h3>
                    <p class="text-gray-400 max-w-md mx-auto">
                        @if($search)
                            Tidak ada data kartu keluarga yang sesuai dengan pencarian "{{ $search }}".
                        @else
                            {{ $tab == 'pending' ? 'Belum ada data kartu keluarga yang menunggu verifikasi.' : 'Belum ada data kartu keluarga yang terverifikasi.' }}
                        @endif
                    </p>
                    @if($tab == 'pending' && !$search)
                        <a href="{{ route('kelurahan.kartu_keluarga.create') }}" 
                           class="inline-flex items-center mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Kartu Keluarga Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($kartuKeluargas->count() > 0)
            <div class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $kartuKeluargas->firstItem() }} - {{ $kartuKeluargas->lastItem() }} dari {{ $kartuKeluargas->total() }} data
                </div>
                <div class="flex space-x-1">
                    @if ($kartuKeluargas->onFirstPage())
                        <span class="pagination-link bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $kartuKeluargas->previousPageUrl() }}&tab={{ $tab }}&search={{ $search }}" class="pagination-link text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif
                    
                    @foreach ($kartuKeluargas->getUrlRange(1, $kartuKeluargas->lastPage()) as $page => $url)
                        @if ($page == $kartuKeluargas->currentPage())
                            <span class="pagination-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}&tab={{ $tab }}&search={{ $search }}" class="pagination-link text-gray-700">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if ($kartuKeluargas->hasMorePages())
                        <a href="{{ $kartuKeluargas->nextPageUrl() }}&tab={{ $tab }}&search={{ $search }}" class="pagination-link text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="pagination-link bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi untuk elemen yang muncul
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.card-hover').forEach(card => {
                observer.observe(card);
            });
        });
    </script>
</body>
</html>