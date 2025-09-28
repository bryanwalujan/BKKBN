<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Kami - CSSR</title>
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
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
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
        }
        
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: scale(1.05);
        }
        
        .stat-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .stat-realtime {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .stat-manual {
            background-color: #f3f4f6;
            color: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola <span class="gradient-text">Layanan Kami</span></h1>
            <p class="text-gray-600">Kelola dan pantau semua layanan yang tersedia di sistem CSSR.</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
        
        <!-- Notifikasi -->
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
        
        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-plus text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Tambah Layanan Baru</h3>
                        <p class="text-gray-600 text-sm mt-1">Tambahkan layanan baru ke sistem.</p>
                    </div>
                </div>
                <a href="{{ route('layanan_kami.create') }}" class="mt-4 inline-flex items-center text-blue-500 font-medium hover:text-blue-700 transition">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Tambah Layanan
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-sync-alt text-green-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Refresh Data Realtime</h3>
                        <p class="text-gray-600 text-sm mt-1">Perbarui data statistik realtime.</p>
                    </div>
                </div>
                <form action="{{ route('layanan_kami.refresh') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="inline-flex items-center text-green-500 font-medium hover:text-green-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Refresh Data
                    </button>
                </form>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-list text-purple-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Total Layanan</h3>
                        <p class="text-gray-600 text-sm mt-1">Jumlah layanan aktif dan non-aktif.</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-2xl font-bold text-purple-600">{{ count($layananKamis) }}</span>
                    <span class="text-sm text-gray-500 ml-2">layanan terdaftar</span>
                </div>
            </div>
        </div>
        
        <!-- Tabel Layanan -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Daftar Layanan</h3>
                <p class="text-gray-600 text-sm mt-1">Kelola semua layanan yang tersedia.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ikon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Layanan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statistik</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($layananKamis as $index => $layanan)
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <img src="{{ asset('storage/' . $layanan->ikon) }}" alt="Ikon" class="w-6 h-6 object-cover">
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $layanan->judul_layanan }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500 max-w-xs truncate">{{ $layanan->deskripsi_singkat }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (isset($dataRiset[$layanan->judul_layanan]))
                                        <span class="stat-badge stat-realtime">
                                            <i class="fas fa-bolt mr-1"></i>
                                            {{ $dataRiset[$layanan->judul_layanan] }} (Realtime)
                                        </span>
                                    @else
                                        <span class="stat-badge stat-manual">
                                            <i class="fas fa-edit mr-1"></i>
                                            Manual
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $layanan->urutan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($layanan->status_aktif)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="far fa-clock mr-1 text-gray-400"></i>
                                        {{ $layanan->tanggal_update->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('layanan_kami.edit', $layanan->id) }}" 
                                           class="action-btn text-blue-600 hover:text-blue-900 transition" 
                                           title="Edit Layanan">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('layanan_kami.destroy', $layanan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="action-btn text-red-600 hover:text-red-900 transition" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')"
                                                    title="Hapus Layanan">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if(count($layananKamis) === 0)
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 text-lg">Belum ada layanan yang ditambahkan.</p>
                        <a href="{{ route('layanan_kami.create') }}" class="inline-flex items-center mt-4 text-blue-500 hover:text-blue-700 transition">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Layanan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan efek fade-in pada setiap baris tabel
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
                row.classList.add('fade-in');
            });
        });
    </script>
</body>
</html>