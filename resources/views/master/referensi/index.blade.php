<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Referensi - CSSR</title>
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
            box-shadow: 0 5px 15px -3px rgba(0, 0, 0, 0.1);
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
            padding: 4px 10px;
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
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .icon-preview {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 1.25rem;
        }
        
        .pagination-links a, .pagination-links span {
            padding: 8px 12px;
            margin: 0 2px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .pagination-links a:hover {
            background-color: #e5e7eb;
        }
        
        .pagination-links .current {
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
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola <span class="gradient-text">Referensi</span></h1>
            <p class="text-gray-600">Kelola konten referensi untuk sistem CSSR.</p>
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
        
        <!-- Toolbar -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6 card-hover">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('referensi.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Referensi
                    </a>
                    
                    <form action="{{ route('referensi.refresh') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                            <i class="fas fa-sync-alt"></i>
                            Refresh Data Realtime
                        </button>
                    </form>
                </div>
                
                <form action="{{ route('referensi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                    <select name="warna_icon" class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 px-3 py-2">
                        <option value="">Semua Warna Ikon</option>
                        @foreach ($warnaIconOptions as $option)
                            <option value="{{ $option }}" {{ $warna_icon == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Tabel Referensi -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-list-alt text-blue-500"></i>
                    Daftar Referensi
                </h3>
                <p class="text-gray-600 text-sm mt-1">Total: {{ $referensis->total() }} referensi</p>
            </div>
            
            <div class="table-responsive">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Ikon</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">PDF</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Warna</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Statistik</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($referensis as $index => $referensi)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="p-4 text-sm text-gray-700">{{ $referensis->firstItem() + $index }}</td>
                                <td class="p-4">
                                    @if ($referensi->icon)
                                        <div class="icon-preview {{ $referensi->warna_icon == 'Biru' ? 'bg-blue-100 text-blue-600' : ($referensi->warna_icon == 'Merah' ? 'bg-red-100 text-red-600' : ($referensi->warna_icon == 'Hijau' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600')) }}">
                                            <img src="{{ asset('storage/' . $referensi->icon) }}" alt="Ikon" class="w-6 h-6 object-contain">
                                        </div>
                                    @else
                                        <div class="icon-preview bg-gray-100 text-gray-400">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-900">{{ $referensi->judul }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Urutan: {{ $referensi->urutan }} | Tombol: {{ $referensi->teks_tombol }}
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-gray-700 max-w-xs">
                                    {{ Str::limit($referensi->deskripsi, 80) }}
                                </td>
                                <td class="p-4">
                                    @if ($referensi->pdf)
                                        <a href="{{ asset('storage/' . $referensi->pdf) }}" target="_blank" class="inline-flex items-center text-blue-500 hover:text-blue-700 transition">
                                            <i class="fas fa-file-pdf mr-1"></i>
                                            Lihat PDF
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $referensi->warna_icon == 'Biru' ? 'bg-blue-100 text-blue-800' : 
                                           ($referensi->warna_icon == 'Merah' ? 'bg-red-100 text-red-800' : 
                                           ($referensi->warna_icon == 'Hijau' ? 'bg-green-100 text-green-800' : 
                                           'bg-yellow-100 text-yellow-800')) }}">
                                        {{ $referensi->warna_icon }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if (isset($dataRiset[$referensi->judul]))
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-900">{{ $dataRiset[$referensi->judul] }}</span>
                                            <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Realtime</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Manual</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="status-badge {{ $referensi->status_aktif ? 'status-active' : 'status-inactive' }}">
                                        {{ $referensi->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $referensi->tanggal_update->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('referensi.edit', $referensi->id) }}" 
                                           class="text-blue-500 hover:text-blue-700 transition p-2 rounded-md hover:bg-blue-50"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('referensi.destroy', $referensi->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-500 hover:text-red-700 transition p-2 rounded-md hover:bg-red-50"
                                                    title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus referensi ini?')">
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
            
            <!-- Pagination -->
            @if ($referensis->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="pagination-links flex justify-center items-center">
                        {{ $referensis->appends(['warna_icon' => $warna_icon])->links() }}
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
        // Efek hover untuk baris tabel
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f9fafb';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
</body>
</html>