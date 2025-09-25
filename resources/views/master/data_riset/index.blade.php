<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Riset - CSSR</title>
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
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
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
        
        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .badge-realtime {
            background: linear-gradient(90deg, #10b981, #059669);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-manual {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-edit {
            background: #3b82f6;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        
        .btn-delete {
            background: #ef4444;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #d1d5db;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-left: 40px;
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Riset <span class="gradient-text">CSSR</span></h1>
                    <p class="text-gray-600">Kelola data riset realtime dan manual untuk sistem CSSR.</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Data</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ count($dataRisets) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-bar text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-database mr-1"></i>
                    <span>Semua data riset</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Data Realtime</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $dataRisets->where('is_realtime', true)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-sync-alt mr-1"></i>
                    <span>Update otomatis</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Data Manual</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $dataRisets->where('is_realtime', false)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-edit text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-user-edit mr-1"></i>
                    <span>Input manual</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Update Terakhir</p>
                        <h3 class="text-lg font-bold text-gray-800 mt-1">
                            @if($dataRisets->count() > 0)
                                {{ $dataRisets->sortByDesc('tanggal_update')->first()->tanggal_update->format('d/m H:i') }}
                            @else
                                -
                            @endif
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-indigo-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-history mr-1"></i>
                    <span>Data terbaru</span>
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
        
        <!-- Toolbar -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a href="{{ route('data_riset.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg transition duration-200 font-medium shadow-md pulse-animation flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i>
                        Tambah Data Riset
                    </a>
                    <form action="{{ route('data_riset.refresh') }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg transition duration-200 font-medium shadow-md flex items-center justify-center gap-2 w-full">
                            <i class="fas fa-sync-alt"></i>
                            Refresh Data Realtime
                        </button>
                    </form>
                </div>
                
                <div class="search-box w-full md:w-64">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari data riset..." class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>
        
        <!-- Tabel Data Riset -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Judul</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Angka</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Sumber</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Tanggal Update</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($dataRisets as $index => $dataRiset)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-800">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-900">{{ $dataRiset->judul }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="text-lg font-bold text-blue-600">{{ $dataRiset->angka }}</span>
                                </td>
                                <td class="p-4">
                                    @if($dataRiset->is_realtime)
                                        <span class="badge-realtime flex items-center gap-1 w-fit">
                                            <i class="fas fa-bolt text-xs"></i>
                                            Realtime
                                        </span>
                                    @else
                                        <span class="badge-manual flex items-center gap-1 w-fit">
                                            <i class="fas fa-edit text-xs"></i>
                                            Manual
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar-alt text-gray-400"></i>
                                        {{ $dataRiset->tanggal_update->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="action-buttons">
                                        <a href="{{ route('data_riset.edit', $dataRiset->id) }}" class="btn-edit flex items-center gap-1">
                                            <i class="fas fa-edit text-xs"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('data_riset.destroy', $dataRiset->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete flex items-center gap-1" onclick="return confirm('Hapus data riset ini?')">
                                                <i class="fas fa-trash text-xs"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h3 class="text-lg font-medium text-gray-700 mb-2">Tidak ada data riset</h3>
                                        <p class="text-gray-500 mb-4">Mulai dengan menambahkan data riset pertama Anda.</p>
                                        <a href="{{ route('data_riset.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition inline-flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            Tambah Data Riset
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Footer Tabel -->
            @if($dataRisets->count() > 0)
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-medium">{{ $dataRisets->count() }}</span> data riset
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>Urutkan berdasarkan:</span>
                        <select class="border border-gray-300 rounded p-1 text-sm">
                            <option>Tanggal Update (Terbaru)</option>
                            <option>Tanggal Update (Terlama)</option>
                            <option>Judul (A-Z)</option>
                            <option>Judul (Z-A)</option>
                        </select>
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

    <script>
        // Fungsi untuk pencarian data
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-box input');
            const tableRows = document.querySelectorAll('tbody tr');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>