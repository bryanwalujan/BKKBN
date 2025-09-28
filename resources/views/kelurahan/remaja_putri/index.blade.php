<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Remaja Putri - CSSR</title>
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
        
        .anemia-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 16px;
            font-size: 0.7rem;
            font-weight: 600;
            text-align: center;
            min-width: 80px;
        }
        
        .anemia-normal {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .anemia-ringan {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .anemia-sedang {
            background-color: #fed7aa;
            color: #9a3412;
        }
        
        .anemia-berat {
            background-color: #fecaca;
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
        
        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .modal-overlay.active .modal-content {
            transform: scale(1);
        }
        
        .ttd-status {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 16px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .ttd-ya {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .ttd-tidak {
            background-color: #fef3c7;
            color: #92400e;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Remaja Putri</h1>
                    <p class="text-gray-600">Kelola data remaja putri di wilayah {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</p>
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
            <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => 'pending', 'search' => $search]) }}"
               class="px-6 py-3 rounded-lg font-medium flex items-center transition-all {{ $tab == 'pending' ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-clock mr-2"></i>
                Menunggu Verifikasi
                @if($tab == 'pending' && $remajaPutris->total() > 0)
                    <span class="ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $remajaPutris->total() }}</span>
                @endif
            </a>
            <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => 'verified', 'search' => $search]) }}"
               class="px-6 py-3 rounded-lg font-medium flex items-center transition-all {{ $tab == 'verified' ? 'bg-green-50 text-green-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                <i class="fas fa-check-circle mr-2"></i>
                Terverifikasi
                @if($tab == 'verified' && $remajaPutris->total() > 0)
                    <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $remajaPutris->total() }}</span>
                @endif
            </a>
        </div>
        
        <!-- Toolbar: Pencarian dan Tambah Data -->
        <div class="bg-white rounded-xl shadow-sm p-5 mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div class="w-full md:w-auto">
                    <form method="GET" action="{{ route('kelurahan.remaja_putri.index') }}" class="flex space-x-2">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        <div class="relative flex-1 md:w-80">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search }}" 
                                   placeholder="Cari berdasarkan nama remaja putri" 
                                   class="search-input pl-10 pr-4 py-2 w-full rounded-lg focus:outline-none">
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center">
                            <i class="fas fa-search mr-2"></i> Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => $tab]) }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center">
                                <i class="fas fa-times mr-2"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>
                
                @if ($tab == 'pending')
                    <a href="{{ route('kelurahan.remaja_putri.create') }}" 
                       class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition flex items-center shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah Remaja Putri
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Informasi Tampilan -->
        <div class="mb-4 text-sm text-gray-600">
            <p>
                Menampilkan {{ $tab == 'verified' ? 'data terverifikasi' : 'data menunggu verifikasi' }}
                @if ($search)
                    dengan pencarian: "<span class="font-medium">{{ $search }}</span>"
                @endif
                ({{ $remajaPutris->total() }} data)
            </p>
        </div>
        
        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            @if($remajaPutris->count() > 0)
                <div class="table-container">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Foto</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">No KK</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Kecamatan</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Kelurahan</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Sekolah</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Kelas</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Umur</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status Anemia</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Konsumsi TTD</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Diupload Oleh</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($remajaPutris as $index => $remaja)
                                <tr class="table-row-hover">
                                    <td class="p-4 text-sm font-medium text-gray-900">{{ $remajaPutris->firstItem() + $index }}</td>
                                    <td class="p-4">
                                        @if ($remaja->foto)
                                            <img src="{{ Storage::url($remaja->foto) }}" alt="Foto Remaja Putri" class="avatar">
                                        @else
                                            <div class="avatar bg-gray-100 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm font-medium text-gray-900">{{ $remaja->nama }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $remaja->kartuKeluarga->no_kk ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $remaja->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $remaja->kelurahan->nama_kelurahan ?? '-' }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $remaja->sekolah }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $remaja->kelas }}</td>
                                    <td class="p-4 text-sm text-gray-700">{{ $remaja->umur }} tahun</td>
                                    <td class="p-4">
                                        <span class="anemia-badge 
                                            {{ $remaja->status_anemia == 'Tidak Anemia' ? 'anemia-normal' : 
                                               ($remaja->status_anemia == 'Anemia Ringan' ? 'anemia-ringan' : 
                                               ($remaja->status_anemia == 'Anemia Sedang' ? 'anemia-sedang' : 'anemia-berat')) }}">
                                            {{ $remaja->status_anemia }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <span class="ttd-status {{ $remaja->konsumsi_ttd == 'Ya' ? 'ttd-ya' : 'ttd-tidak' }}">
                                            <i class="fas {{ $remaja->konsumsi_ttd == 'Ya' ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                            {{ $remaja->konsumsi_ttd }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @if($remaja->source == 'verified')
                                            <span class="status-badge status-verified">
                                                <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                            </span>
                                        @else
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock mr-1"></i> {{ ucfirst($remaja->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-700">{{ $remaja->createdBy->name ?? 'Tidak diketahui' }}</td>
                                    <td class="p-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('kelurahan.remaja_putri.edit', [$remaja->id, $remaja->source]) }}" 
                                               class="action-btn bg-blue-100 text-blue-700 hover:bg-blue-200">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            
                                            @if ($remaja->source == 'pending')
                                                <button type="button" 
                                                        class="action-btn bg-red-100 text-red-700 hover:bg-red-200"
                                                        onclick="showDeleteModal('{{ route('kelurahan.remaja_putri.destroy', $remaja->id) }}', '{{ $remaja->nama }}')">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
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
                    <i class="fas fa-user-friends"></i>
                    <h3 class="text-xl font-semibold text-gray-500 mb-2">Tidak ada data ditemukan</h3>
                    <p class="text-gray-400 max-w-md mx-auto">
                        @if($search)
                            Tidak ada data remaja putri yang sesuai dengan pencarian "{{ $search }}".
                        @else
                            {{ $tab == 'pending' ? 'Belum ada data remaja putri yang menunggu verifikasi.' : 'Belum ada data remaja putri yang terverifikasi.' }}
                        @endif
                    </p>
                    @if($tab == 'pending' && !$search)
                        <a href="{{ route('kelurahan.remaja_putri.create') }}" 
                           class="inline-flex items-center mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-plus-circle mr-2"></i> Tambah Remaja Putri Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($remajaPutris->count() > 0)
            <div class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $remajaPutris->firstItem() }} - {{ $remajaPutris->lastItem() }} dari {{ $remajaPutris->total() }} data
                </div>
                <div class="flex space-x-1">
                    @if ($remajaPutris->onFirstPage())
                        <span class="pagination-link bg-gray-100 text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $remajaPutris->previousPageUrl() }}&tab={{ $tab }}&search={{ $search }}" class="pagination-link text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif
                    
                    @foreach ($remajaPutris->getUrlRange(1, $remajaPutris->lastPage()) as $page => $url)
                        @if ($page == $remajaPutris->currentPage())
                            <span class="pagination-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}&tab={{ $tab }}&search={{ $search }}" class="pagination-link text-gray-700">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if ($remajaPutris->hasMorePages())
                        <a href="{{ $remajaPutris->nextPageUrl() }}&tab={{ $tab }}&search={{ $search }}" class="pagination-link text-gray-700 hover:bg-gray-100">
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

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-content">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="bg-red-100 p-3 rounded-full mr-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Penghapusan</h3>
                </div>
                <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus data remaja putri <span id="deleteName" class="font-bold text-gray-800"></span>? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelDelete" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Batal</button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Hapus</button>
                    </form>
                </div>
            </div>
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

        function showDeleteModal(url, name) {
            const modal = document.getElementById('deleteModal');
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = url;
            modal.classList.add('active');
        }

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.remove('active');
        });

        // Tutup modal saat mengklik di luar konten modal
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    </script>
</body>
</html>