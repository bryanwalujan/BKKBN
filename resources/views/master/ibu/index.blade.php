<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ibu - CSSR</title>
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
        
        .table-row-hover:hover {
            background-color: #f8fafc;
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
        
        .badge-hamil {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        
        .badge-nifas {
            background-color: #fce7f3;
            color: #be185d;
        }
        
        .badge-menyusui {
            background-color: #f0fdf4;
            color: #15803d;
        }
        
        .badge-tidak-aktif {
            background-color: #f1f5f9;
            color: #475569;
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
            background-color: #3b82f6;
            border-color: #3b82f6;
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
            border-color: #3b82f6;
            transform: scale(1.05);
        }
        
        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }
        
        .sticky-header th {
            position: sticky;
            top: 0;
            background-color: #f9fafb;
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
        
        .status-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 12px;
        }
        
        .status-hamil {
            background-color: #0ea5e9;
            color: white;
        }
        
        .status-nifas {
            background-color: #ec4899;
            color: white;
        }
        
        .status-menyusui {
            background-color: #10b981;
            color: white;
        }
        
        .status-tidak-aktif {
            background-color: #94a3b8;
            color: white;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Ibu</span></h1>
                    <p class="text-gray-600">Kelola data ibu dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('ibu.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Data Ibu
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Data Ibu</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $ibus->total() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-500 text-xl"></i>
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
                        <p class="text-sm font-medium text-gray-500">Ibu Hamil</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $ibus->where('status', 'Hamil')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-baby text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span class="status-icon status-hamil"><i class="fas fa-baby"></i></span>
                    <span>Status hamil</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ibu Nifas</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $ibus->where('status', 'Nifas')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-heartbeat text-pink-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span class="status-icon status-nifas"><i class="fas fa-heartbeat"></i></span>
                    <span>Status nifas</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Ibu Menyusui</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $ibus->where('status', 'Menyusui')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-child text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span class="status-icon status-menyusui"><i class="fas fa-child"></i></span>
                    <span>Status menyusui</span>
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
                    <h3 class="text-xl font-semibold text-gray-800">Filter Data</h3>
                    <p class="text-gray-600 text-sm mt-1">Saring data ibu berdasarkan kriteria tertentu</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-filter mr-2 text-blue-500"></i>
                    <span>Filter data</span>
                </div>
            </div>
            
            <form action="{{ route('ibu.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Ibu</label>
                    <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                        <option value="">Semua Status</option>
                        <option value="Hamil" {{ $category == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                        <option value="Nifas" {{ $category == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                        <option value="Menyusui" {{ $category == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                        <option value="Tidak Aktif" {{ $category == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama atau NIK" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 h-10">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if ($category || $search)
                        <a href="{{ route('ibu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
            
            @if ($category || $search)
                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan data
                        @if ($category)
                            untuk status: <span class="font-semibold">{{ $category }}</span>
                        @endif
                        @if ($search)
                            dengan pencarian: <span class="font-semibold">"{{ $search }}"</span>
                        @endif
                        ({{ $ibus->total() }} data ditemukan)
                    </p>
                </div>
            @else
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan semua data ibu ({{ $ibus->total() }} data)
                    </p>
                </div>
            @endif
        </div>
        
        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Ibu</h3>
                        <p class="text-gray-600 text-sm mt-1">Daftar lengkap data ibu dalam sistem</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $ibus->currentPage() }} dari {{ $ibus->lastPage() }}
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto table-container">
                <table class="w-full">
                    <thead class="bg-gray-50 sticky-header">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Foto</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">NIK</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Nama</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kecamatan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kartu Keluarga</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Alamat</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($ibus as $index => $ibu)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $ibus->firstItem() + $index }}</td>
                                <td class="p-4">
                                    @if ($ibu->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($ibu->foto))
                                        <img src="{{ Storage::url($ibu->foto) }}" alt="Foto {{ $ibu->nama ?? 'Ibu' }}" class="photo-thumbnail" onclick="showPhotoModal('{{ Storage::url($ibu->foto) }}', '{{ $ibu->nama ?? 'Ibu' }}')">
                                    @else
                                        <div class="photo-thumbnail bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $ibu->nik ?? '-' }}</td>
                                <td class="p-4">
                                    <a href="{{ route('ibu.edit', $ibu->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        {{ $ibu->nama ?? '-' }}
                                    </a>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700">
                                    @if($ibu->kartuKeluarga)
                                        {{ $ibu->kartuKeluarga->no_kk ?? '-' }} - {{ $ibu->kartuKeluarga->kepala_keluarga ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $ibu->alamat ?? '-' }}</td>
                                <td class="p-4">
                                    @if($ibu->status == 'Hamil')
                                        <span class="badge badge-hamil">
                                            <span class="status-icon status-hamil"><i class="fas fa-baby"></i></span>
                                            Hamil
                                        </span>
                                    @elseif($ibu->status == 'Nifas')
                                        <span class="badge badge-nifas">
                                            <span class="status-icon status-nifas"><i class="fas fa-heartbeat"></i></span>
                                            Nifas
                                        </span>
                                    @elseif($ibu->status == 'Menyusui')
                                        <span class="badge badge-menyusui">
                                            <span class="status-icon status-menyusui"><i class="fas fa-child"></i></span>
                                            Menyusui
                                        </span>
                                    @else
                                        <span class="badge badge-tidak-aktif">
                                            <span class="status-icon status-tidak-aktif"><i class="fas fa-pause"></i></span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('ibu.edit', $ibu->id) }}" class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 delete-btn" 
                                                data-url="{{ route('ibu.destroy', $ibu->id) }}" 
                                                data-name="{{ $ibu->nama ?? 'Ibu' }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data ibu yang sesuai dengan filter.</p>
                                        @if ($category || $search)
                                            <a href="{{ route('ibu.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 flex items-center">
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
            @if($ibus->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $ibus->appends(['category' => $category, 'search' => $search])->links('vendor.pagination.custom') }}
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
            <img id="modalImage" src="" alt="Foto Ibu" class="mx-auto">
            <p id="modalCaption" class="text-center text-gray-600 mt-4"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('select').select2({
                placeholder: 'Pilih opsi',
                allowClear: true
            });

            // Handle delete button click with SweetAlert2
            $('.delete-btn').on('click', function() {
                var url = $(this).data('url');
                var name = $(this).data('name');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: `Apakah Anda yakin ingin menghapus data ibu ${name}? Tindakan ini tidak dapat dibatalkan.`,
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
                                    text: 'Data ibu berhasil dihapus!',
                                    confirmButtonColor: '#3b82f6'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.error('Error deleting data:', xhr);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menghapus data ibu. Silakan coba lagi.',
                                    confirmButtonColor: '#3b82f6'
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
                    confirmButtonColor: '#3b82f6'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3b82f6'
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