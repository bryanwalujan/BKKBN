<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Remaja Putri - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #ec4899;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
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
            background: linear-gradient(90deg, #ec4899, #f472b6);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #ec4899, #f472b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .table-row-hover:hover {
            background-color: #fdf2f8;
            transform: scale(1.005);
            transition: all 0.2s ease;
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-pink {
            background-color: #fce7f3;
            color: #be185d;
        }
        
        .anemia-tidak {
            background-color: #10b981;
            color: white;
        }
        
        .anemia-ringan {
            background-color: #f59e0b;
            color: white;
        }
        
        .anemia-sedang {
            background-color: #f97316;
            color: white;
        }
        
        .anemia-berat {
            background-color: #ef4444;
            color: white;
        }
        
        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            color: #4b5563;
            text-decoration: none;
        }
        
        .pagination .page-link:hover {
            background-color: #f3f4f6;
        }
        
        .pagination .active .page-link {
            background-color: #ec4899;
            border-color: #ec4899;
            color: white;
        }
        
        .photo-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .photo-thumbnail:hover {
            border-color: #ec4899;
            transform: scale(1.05);
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .status-tidak {
            background-color: #10b981;
        }
        
        .status-ringan {
            background-color: #f59e0b;
        }
        
        .status-sedang {
            background-color: #f97316;
        }
        
        .status-berat {
            background-color: #ef4444;
        }
        
        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }
        
        .sticky-header th {
            position: sticky;
            top: 0;
            background-color: #fdf2f8;
            z-index: 10;
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
            transition: all 0.3s;
        }
        
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 12px;
            padding: 24px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s;
        }
        
        .modal-overlay.active .modal-content {
            transform: scale(1);
        }
        
        .modal-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        
        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .modal-close:hover {
            background-color: #e5e7eb;
            color: #1f2937;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        
        .search-box input {
            padding-left: 40px;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Remaja Putri</span></h1>
                    <p class="text-gray-600">Kelola data remaja putri dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-pink-500 hover:text-pink-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('remaja_putri.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Data Remaja Putri
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Data Remaja Putri</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $remajaPutris->total() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-friends text-pink-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-database mr-1"></i>
                    <span>Data terbaru</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tidak Anemia</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $remajaPutris->where('status_anemia', 'Tidak Anemia')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span class="status-indicator status-tidak"></span>
                    <span>Status tidak anemia</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Anemia Ringan</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $remajaPutris->where('status_anemia', 'Anemia Ringan')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span class="status-indicator status-ringan"></span>
                    <span>Status anemia ringan</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Anemia Sedang/Berat</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $remajaPutris->whereIn('status_anemia', ['Anemia Sedang', 'Anemia Berat'])->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-warning text-red-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span class="status-indicator status-berat"></span>
                    <span>Status anemia sedang/berat</span>
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
        
        <!-- Filter dan Pencarian -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Pencarian Data</h3>
                    <p class="text-gray-600 text-sm mt-1">Cari data remaja putri berdasarkan nama</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-search mr-2 text-pink-500"></i>
                    <span>Cari data</span>
                </div>
            </div>
            
            <form action="{{ route('remaja_putri.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Remaja Putri" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    </div>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition flex items-center gap-2 h-10">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                    @if ($search)
                        <a href="{{ route('remaja_putri.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
            
            @if ($search)
                <div class="mt-4 p-3 bg-pink-50 rounded-lg border border-pink-200">
                    <p class="text-sm text-pink-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan data dengan pencarian: <span class="font-semibold">"{{ $search }}"</span>
                        ({{ $remajaPutris->total() }} data ditemukan)
                    </p>
                </div>
            @else
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan semua data remaja putri ({{ $remajaPutris->total() }} data)
                    </p>
                </div>
            @endif
        </div>
        
        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Remaja Putri</h3>
                        <p class="text-gray-600 text-sm mt-1">Daftar lengkap data remaja putri dalam sistem</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $remajaPutris->currentPage() }} dari {{ $remajaPutris->lastPage() }}
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto table-container">
                <table class="w-full">
                    <thead class="bg-gray-50 sticky-header">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Foto</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Nama</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No KK</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kecamatan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Sekolah</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kelas</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Umur</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Status Anemia</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Konsumsi TTD</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($remajaPutris as $index => $remaja)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $remajaPutris->firstItem() + $index }}</td>
                                <td class="p-4">
                                    @if ($remaja->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($remaja->foto))
                                        <img src="{{ Storage::url($remaja->foto) }}" alt="Foto {{ $remaja->nama ?? 'Remaja Putri' }}" class="photo-thumbnail" onclick="showPhotoModal('{{ Storage::url($remaja->foto) }}', '{{ $remaja->nama ?? 'Remaja Putri' }}')">
                                    @else
                                        <div class="photo-thumbnail bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('remaja_putri.edit', $remaja->id) }}" class="text-pink-600 hover:text-pink-800 font-medium">
                                        {{ $remaja->nama ?? '-' }}
                                    </a>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $remaja->kartuKeluarga->no_kk ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $remaja->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $remaja->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $remaja->sekolah ?? '-' }}</td>
                                <td class="p-4">
                                    <span class="badge badge-pink">
                                        <i class="fas fa-graduation-cap mr-1"></i> {{ $remaja->kelas ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $remaja->umur ?? '-' }} tahun</td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white
                                        {{ $remaja->status_anemia == 'Tidak Anemia' ? 'anemia-tidak' : ($remaja->status_anemia == 'Anemia Ringan' ? 'anemia-ringan' : ($remaja->status_anemia == 'Anemia Sedang' ? 'anemia-sedang' : 'anemia-berat')) }}">
                                        <span class="status-indicator {{ $remaja->status_anemia == 'Tidak Anemia' ? 'status-tidak' : ($remaja->status_anemia == 'Anemia Ringan' ? 'status-ringan' : ($remaja->status_anemia == 'Anemia Sedang' ? 'status-sedang' : 'status-berat')) }}"></span>
                                        {{ $remaja->status_anemia ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $remaja->konsumsi_ttd == 'Ya' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <i class="fas {{ $remaja->konsumsi_ttd == 'Ya' ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ $remaja->konsumsi_ttd ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('remaja_putri.edit', $remaja->id) }}" class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 delete-btn" 
                                                data-url="{{ route('remaja_putri.destroy', $remaja->id) }}" 
                                                data-name="{{ $remaja->nama ?? 'Remaja Putri' }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data remaja putri yang sesuai dengan pencarian.</p>
                                        @if ($search)
                                            <a href="{{ route('remaja_putri.index') }}" class="text-pink-500 hover:text-pink-700 mt-2 flex items-center">
                                                <i class="fas fa-undo mr-2"></i> Tampilkan semua data
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
            @if($remajaPutris->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $remajaPutris->appends(['search' => $search])->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal Foto -->
    <div id="photoModal" class="modal-overlay">
        <div class="modal-content">
            <span class="modal-close"><i class="fas fa-times"></i></span>
            <img id="modalImage" src="" alt="Foto Remaja Putri" class="mx-auto">
            <p id="modalCaption" class="text-center text-gray-600 mt-4"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle delete button click with SweetAlert2
            $('.delete-btn').on('click', function() {
                var url = $(this).data('url');
                var name = $(this).data('name');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: `Apakah Anda yakin ingin menghapus data remaja putri ${name}? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Hapus',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data remaja putri berhasil dihapus!',
                                    confirmButtonColor: '#ec4899'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.error('Error deleting data:', xhr);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menghapus data remaja putri. Silakan coba lagi.',
                                    confirmButtonColor: '#ec4899'
                                });
                            }
                        });
                    }
                });
            });

            // Handle session messages with SweetAlert2
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#ec4899'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#ec4899'
                });
            @endif

            // Photo modal
            window.showPhotoModal = function(src, name) {
                $('#modalImage').attr('src', src);
                $('#modalCaption').text('Foto ' + name);
                $('#photoModal').addClass('active');
            };

            $('.modal-close').on('click', function() {
                $('#photoModal').removeClass('active');
            });

            $(document).on('click', function(e) {
                if ($(e.target).hasClass('modal-overlay')) {
                    $('#photoModal').removeClass('active');
                }
            });
        });
    </script>
</body>
</html>