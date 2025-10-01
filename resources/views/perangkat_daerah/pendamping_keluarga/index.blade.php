<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendamping Keluarga - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
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
        
        .tab-active {
            background: linear-gradient(135deg, #3b82f6, #10b981);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
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
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-active {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-inactive {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        .table-row-hover:hover {
            background-color: #f8fafc;
        }
        
        .search-box {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-gray-400' viewBox='0 0 20 20' fill='currentColor'%3E%3Cpath fill-rule='evenodd' d='M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z' clip-rule='evenodd' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 12px center;
            background-size: 16px;
            padding-left: 40px;
        }
        
        .pagination-active {
            background-color: #3b82f6;
            color: white;
        }
        
        .photo-container {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f3f4f6;
        }
        
        .photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e5e7eb;
            color: #9ca3af;
        }
        
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('perangkat_daerah.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Pendamping Keluarga</h1>
                    <p class="text-gray-600">Kelola data pendamping keluarga untuk {{ auth()->user()->kecamatan->nama_kecamatan ?? 'Kecamatan Tidak Diketahui' }}</p>
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
        <div class="bg-white p-2 rounded-xl shadow-sm mb-6 inline-flex">
            <a href="{{ route('perangkat_daerah.pendamping_keluarga.index', ['tab' => 'pending']) }}" 
               class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center {{ $tab == 'pending' ? 'tab-active' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="fas fa-clock mr-2"></i>
                <span>Pending</span>
                @if($tab == 'pending')
                    <span class="ml-2 bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded-full">{{ $pendampingKeluargas->total() }}</span>
                @endif
            </a>
            <a href="{{ route('perangkat_daerah.pendamping_keluarga.index', ['tab' => 'verified']) }}" 
               class="px-6 py-3 rounded-lg font-medium transition-all duration-300 flex items-center {{ $tab == 'verified' ? 'tab-active' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Terverifikasi</span>
                @if($tab == 'verified')
                    <span class="ml-2 bg-white text-blue-600 text-xs font-bold px-2 py-1 rounded-full">{{ $pendampingKeluargas->total() }}</span>
                @endif
            </a>
        </div>
        
        <!-- Search and Action Bar -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <form method="GET" action="{{ route('perangkat_daerah.pendamping_keluarga.index') }}" class="w-full md:w-auto">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="relative">
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Cari nama pendamping..." 
                               class="search-box border border-gray-300 rounded-lg py-2 px-4 w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                @if ($tab == 'pending')
                    <a href="{{ route('perangkat_daerah.pendamping_keluarga.create') }}" 
                       class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex items-center shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Tambah Pendamping</span>
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-700">No</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Foto</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Nama</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Peran</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Status</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Tahun Bergabung</th>
                            @if ($tab == 'pending')
                                <th class="p-4 text-left font-semibold text-gray-700">Status Verifikasi</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Catatan</th>
                            @endif
                            <th class="p-4 text-left font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($pendampingKeluargas as $index => $pendamping)
                            <tr class="table-row-hover">
                                <td class="p-4 text-gray-600">{{ $pendampingKeluargas->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <div class="photo-container">
                                        @if ($pendamping->foto)
                                            <img src="{{ asset('storage/' . $pendamping->foto) }}" 
                                                 alt="Foto {{ $pendamping->nama }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="photo-placeholder">
                                                <i class="fas fa-user text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-800">{{ $pendamping->nama }}</div>
                                </td>
                                <td class="p-4 text-gray-600">{{ $pendamping->peran }}</td>
                                <td class="p-4 text-gray-600">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4">
                                    <span class="status-badge {{ $pendamping->status == 'aktif' ? 'status-active' : 'status-inactive' }}">
                                        <i class="fas {{ $pendamping->status == 'aktif' ? 'fa-check-circle' : 'fa-pause-circle' }} mr-1"></i>
                                        {{ ucfirst($pendamping->status) }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $pendamping->tahun_bergabung }}</td>
                                @if ($tab == 'pending')
                                    <td class="p-4">
                                        <span class="status-badge 
                                            {{ $pendamping->status_verifikasi == 'pending' ? 'status-pending' : 
                                               ($pendamping->status_verifikasi == 'verified' ? 'status-verified' : 'status-rejected') }}">
                                            <i class="fas 
                                                {{ $pendamping->status_verifikasi == 'pending' ? 'fa-clock' : 
                                                   ($pendamping->status_verifikasi == 'verified' ? 'fa-check' : 'fa-times') }} mr-1"></i>
                                            {{ ucfirst($pendamping->status_verifikasi) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-600">{{ $pendamping->catatan ?? '-' }}</td>
                                @endif
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        @if ($pendamping->kartuKeluargas->isNotEmpty())
                                            <a href="{{ route('kartu_keluarga.show', $pendamping->kartuKeluargas->first()->id) }}" 
                                               class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50 transition action-btn" 
                                               title="Detail Kartu Keluarga">
                                                <i class="fas fa-id-card"></i>
                                            </a>
                                        @endif
                                        
                                        @if ($tab == 'pending' && $pendamping->status_verifikasi == 'pending')
                                            <a href="{{ route('perangkat_daerah.pendamping_keluarga.edit', [$pendamping->id, 'pending']) }}" 
                                               class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50 transition action-btn" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('perangkat_daerah.pendamping_keluarga.destroy', $pendamping->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition action-btn" 
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @elseif ($tab == 'verified')
                                            <a href="{{ route('perangkat_daerah.pendamping_keluarga.edit', [$pendamping->id, 'verified']) }}" 
                                               class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50 transition action-btn" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($pendampingKeluargas->isEmpty())
                <div class="p-8 text-center">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Tidak ada data pendamping keluarga ditemukan.</p>
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($pendampingKeluargas->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="bg-white rounded-lg shadow-sm p-2 inline-flex space-x-1">
                    {{ $pendampingKeluargas->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle session messages with SweetAlert2
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3b82f6',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
            
            // Add confirmation for delete actions
            $('form[action*="destroy"]').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus data pendamping keluarga ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>