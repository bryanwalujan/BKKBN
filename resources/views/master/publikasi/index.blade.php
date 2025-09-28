<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Publikasi - CSSR</title>
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
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
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
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-aktif {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-nonaktif {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .image-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .image-preview:hover {
            transform: scale(1.8);
            z-index: 10;
            position: relative;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .pagination-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .pagination-link:hover {
            background-color: #3b82f6;
            color: white;
        }
        
        .pagination-link.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Manajemen <span class="gradient-text">Publikasi</span></h1>
            <p class="text-gray-600">Kelola konten publikasi untuk ditampilkan di halaman utama sistem CSSR.</p>
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
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Publikasi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $publikasis->total() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-newspaper text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-filter mr-1"></i>
                    <span>Kategori: {{ $kategori ?: 'Semua' }}</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Publikasi Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $publikasis->where('status_aktif', true)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-eye text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>Tampil di halaman utama</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Data Realtime</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ count($dataRiset) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-sync-alt text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-database mr-1"></i>
                    <span>Terkoneksi dengan sistem</span>
                </div>
            </div>
        </div>
        
        <!-- Toolbar -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6 card-hover">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('publikasi.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 font-medium">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Publikasi
                    </a>
                    
                    <form action="{{ route('publikasi.refresh') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition flex items-center gap-2 font-medium">
                            <i class="fas fa-sync-alt"></i>
                            Refresh Data Realtime
                        </button>
                    </form>
                </div>
                
                <form action="{{ route('publikasi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <select name="kategori" class="border-gray-300 rounded-lg shadow-sm pl-10 pr-4 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoriOptions as $option)
                                <option value="{{ $option }}" {{ $kategori == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-filter text-gray-400"></i>
                        </div>
                    </div>
                    <button type="submit" class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700 transition flex items-center gap-2 font-medium">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Tabel Publikasi -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Gambar</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Judul</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Statistik</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Teks Tombol</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Urutan</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Update</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($publikasis as $index => $publikasi)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $publikasis->firstItem() + $index }}</td>
                                <td class="p-4">
                                    @if ($publikasi->gambar)
                                        <img src="{{ asset('storage/' . $publikasi->gambar) }}" alt="Gambar" class="image-preview">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $publikasi->judul }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $publikasi->kategori }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm text-gray-700 max-w-xs truncate">{{ $publikasi->deskripsi }}</div>
                                    @if (strlen($publikasi->deskripsi) > 100)
                                        <button class="text-xs text-blue-500 mt-1 hover:underline" onclick="toggleDescription(this)">Lihat selengkapnya</button>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="text-sm text-gray-700">
                                        @if (isset($dataRiset[$publikasi->judul]))
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-bolt text-green-500"></i>
                                                {{ $dataRiset[$publikasi->judul] }} <span class="text-xs text-green-600">(Realtime)</span>
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-edit text-blue-500"></i>
                                                Manual
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="text-sm font-medium text-gray-700">{{ $publikasi->teks_tombol }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                        {{ $publikasi->urutan }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="status-badge {{ $publikasi->status_aktif ? 'status-aktif' : 'status-nonaktif' }}">
                                        {{ $publikasi->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-500">
                                    {{ $publikasi->tanggal_update->format('d/m/Y H:i') }}
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('publikasi.edit', $publikasi->id) }}" 
                                           class="text-blue-500 hover:text-blue-700 transition p-2 rounded-lg bg-blue-50 hover:bg-blue-100"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('publikasi.destroy', $publikasi->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-500 hover:text-red-700 transition p-2 rounded-lg bg-red-50 hover:bg-red-100"
                                                    title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus publikasi ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($publikasis->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-lg">Tidak ada data publikasi ditemukan.</p>
                    <a href="{{ route('publikasi.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus-circle mr-2"></i>Tambah Publikasi Pertama
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($publikasis->hasPages())
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan {{ $publikasis->firstItem() }} hingga {{ $publikasis->lastItem() }} dari {{ $publikasis->total() }} hasil
                </div>
                <div class="flex space-x-1">
                    @if ($publikasis->onFirstPage())
                        <span class="pagination-link bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $publikasis->previousPageUrl() }}&kategori={{ $kategori }}" class="pagination-link bg-white text-gray-700 hover:bg-blue-100">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif
                    
                    @foreach ($publikasis->getUrlRange(1, $publikasis->lastPage()) as $page => $url)
                        @if ($page == $publikasis->currentPage())
                            <span class="pagination-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}&kategori={{ $kategori }}" class="pagination-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if ($publikasis->hasMorePages())
                        <a href="{{ $publikasis->nextPageUrl() }}&kategori={{ $kategori }}" class="pagination-link bg-white text-gray-700 hover:bg-blue-100">
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
        function toggleDescription(button) {
            const cell = button.closest('td');
            const description = cell.querySelector('.truncate');
            
            if (description.classList.contains('truncate')) {
                description.classList.remove('truncate');
                description.classList.add('whitespace-normal');
                button.textContent = 'Sembunyikan';
            } else {
                description.classList.add('truncate');
                description.classList.remove('whitespace-normal');
                button.textContent = 'Lihat selengkapnya';
            }
        }
        
        // Animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.table-row-hover');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
                row.classList.add('fade-in');
            });
        });
    </script>
</body>
</html>