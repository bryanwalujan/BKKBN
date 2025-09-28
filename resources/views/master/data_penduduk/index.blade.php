<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penduduk - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
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
        
        .badge-aktif {
            background: linear-gradient(90deg, #10b981, #059669);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .badge-nonaktif {
            background: linear-gradient(90deg, #6b7280, #4b5563);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
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
        
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }
        
        .pagination-links {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .pagination-links a, .pagination-links span {
            padding: 8px 16px;
            margin: 0 4px;
            border-radius: 6px;
            text-decoration: none;
            color: #3b82f6;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
        }
        
        .pagination-links a:hover {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        .pagination-links span.current {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        .filter-form {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .filter-form input {
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            width: 150px;
        }
        
        .filter-form button {
            background: #6b7280;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .filter-form button:hover {
            background: #4b5563;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Penduduk</span></h1>
                    <p class="text-gray-600">Kelola data penduduk dan statistik untuk sistem CSSR.</p>
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
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $dataPenduduks->total() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-database mr-1"></i>
                    <span>Semua data penduduk</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Data Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $dataPenduduks->where('status_aktif', true)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-toggle-on mr-1"></i>
                    <span>Status aktif</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tahun Terbaru</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            @if($dataPenduduks->count() > 0)
                                {{ $dataPenduduks->sortByDesc('tahun')->first()->tahun }}
                            @else
                                -
                            @endif
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    <span>Tahun terbaru</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Update Terakhir</p>
                        <h3 class="text-lg font-bold text-gray-800 mt-1">
                            @if($dataPenduduks->count() > 0)
                                {{ $dataPenduduks->sortByDesc('tanggal_update')->first()->tanggal_update->format('d/m H:i') }}
                            @else
                                -
                            @endif
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-history text-indigo-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-sync-alt mr-1"></i>
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
        
        <!-- Grafik Data Penduduk -->
        <div class="chart-container card-hover">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Grafik Perkembangan Jumlah Penduduk</h3>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-2"></i>
                    <span>Data Historis</span>
                </div>
            </div>
            <canvas id="pendudukChart" height="100"></canvas>
        </div>
        
        <!-- Toolbar -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a href="{{ route('data_penduduk.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg transition duration-200 font-medium shadow-md pulse-animation flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i>
                        Tambah Data Penduduk
                    </a>
                </div>
                
                <form action="{{ route('data_penduduk.index') }}" method="GET" class="filter-form">
                    <input type="text" name="tahun" placeholder="Cari Tahun" value="{{ $tahun }}" class="border-gray-300 rounded-md shadow-sm">
                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded flex items-center gap-2">
                        <i class="fas fa-filter"></i>
                        Tampilkan
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Tabel Data Penduduk -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Tahun</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Jumlah Penduduk</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Statistik</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Urutan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Status Aktif</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Tanggal Update</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($dataPenduduks as $index => $dataPenduduk)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-800">{{ $dataPenduduks->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-900">{{ $dataPenduduk->tahun }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="text-lg font-bold text-blue-600">{{ number_format($dataPenduduk->jumlah_penduduk, 0, ',', '.') }}</span>
                                </td>
                                <td class="p-4">
                                    @if (isset($dataRiset['Jumlah Penduduk']) && $dataRiset['Jumlah Penduduk'] == $dataPenduduk->jumlah_penduduk)
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
                                <td class="p-4 text-sm text-gray-800">
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $dataPenduduk->urutan }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if($dataPenduduk->status_aktif)
                                        <span class="badge-aktif flex items-center gap-1 w-fit">
                                            <i class="fas fa-check-circle text-xs"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge-nonaktif flex items-center gap-1 w-fit">
                                            <i class="fas fa-times-circle text-xs"></i>
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="far fa-calendar-alt text-gray-400"></i>
                                        {{ $dataPenduduk->tanggal_update->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="action-buttons">
                                        <a href="{{ route('data_penduduk.edit', $dataPenduduk->id) }}" class="btn-edit flex items-center gap-1">
                                            <i class="fas fa-edit text-xs"></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('data_penduduk.destroy', $dataPenduduk->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete flex items-center gap-1" onclick="return confirm('Hapus data penduduk ini?')">
                                                <i class="fas fa-trash text-xs"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8">
                                    <div class="empty-state">
                                        <i class="fas fa-users-slash"></i>
                                        <h3 class="text-lg font-medium text-gray-700 mb-2">Tidak ada data penduduk</h3>
                                        <p class="text-gray-500 mb-4">Mulai dengan menambahkan data penduduk pertama Anda.</p>
                                        <a href="{{ route('data_penduduk.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition inline-flex items-center gap-2">
                                            <i class="fas fa-plus"></i>
                                            Tambah Data Penduduk
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Footer Tabel -->
            @if($dataPenduduks->count() > 0)
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan {{ $dataPenduduks->firstItem() }} - {{ $dataPenduduks->lastItem() }} dari {{ $dataPenduduks->total() }} data penduduk
                    </div>
                    <div class="pagination-links">
                        {{ $dataPenduduks->appends(['tahun' => $tahun])->links() }}
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
        // Grafik Data Penduduk
        const ctx = document.getElementById('pendudukChart').getContext('2d');
        const chartData = @json($chartData);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(data => data.tahun),
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: chartData.map(data => data.jumlah_penduduk),
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            family: 'Inter'
                        },
                        bodyFont: {
                            family: 'Inter'
                        },
                        callbacks: {
                            label: function(context) {
                                return `Jumlah Penduduk: ${context.parsed.y.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    x: { 
                        grid: {
                            display: false
                        },
                        title: { 
                            display: true, 
                            text: 'Tahun',
                            font: {
                                family: 'Inter',
                                size: 14,
                                weight: '500'
                            }
                        } 
                    },
                    y: { 
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        title: { 
                            display: true, 
                            text: 'Jumlah Penduduk',
                            font: {
                                family: 'Inter',
                                size: 14,
                                weight: '500'
                            }
                        }, 
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>