<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kartu Keluarga - Admin Kecamatan</title>
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
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #15803d;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #15803d, #10b981);
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
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
            background: white;
            border-radius: 12px 12px 0 0;
            padding: 0 20px;
        }
        
        .tab {
            padding: 15px 25px;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            position: relative;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            color: #15803d;
            border-bottom-color: #15803d;
        }
        
        .tab:hover:not(.active) {
            color: #4b5563;
            background-color: #f9fafb;
        }
        
        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .action-btn-approve {
            background-color: #10b981;
            color: white;
        }
        
        .action-btn-approve:hover {
            background-color: #059669;
        }
        
        .action-btn-reject {
            background-color: #ef4444;
            color: white;
        }
        
        .action-btn-reject:hover {
            background-color: #dc2626;
        }
        
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        
        .status-pending {
            background-color: #f59e0b;
        }
        
        .status-verified {
            background-color: #10b981;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-left: 2.5rem;
        }
        
        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #d1d5db;
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
            background-color: #15803d;
            border-color: #15803d;
            color: white;
        }
        
        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }
        
        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('kecamatan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Kartu Keluarga</span></h1>
            <p class="text-gray-600">Kelola verifikasi kartu keluarga di Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan }}</p>
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
        
        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="tabs">
                <a href="{{ route('kecamatan.kartu_keluarga.index', ['tab' => 'pending', 'search' => $search]) }}"
                   class="tab {{ $tab === 'pending' ? 'active' : '' }}">
                    <i class="fas fa-clock mr-2"></i>Pending Verifikasi
                </a>
                <a href="{{ route('kecamatan.kartu_keluarga.index', ['tab' => 'verified', 'search' => $search]) }}"
                   class="tab {{ $tab === 'verified' ? 'active' : '' }}">
                    <i class="fas fa-check-circle mr-2"></i>Terverifikasi
                </a>
            </div>
            
            <!-- Filter dan Pencarian -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Kartu Keluarga</h3>
                        <p class="text-gray-600 text-sm mt-1">
                            @if($tab === 'pending')
                                Menampilkan data yang menunggu verifikasi
                            @else
                                Menampilkan data yang sudah diverifikasi
                            @endif
                        </p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $kartuKeluargas->currentPage() }} dari {{ $kartuKeluargas->lastPage() }}
                    </div>
                </div>
                
                <form method="GET" action="{{ route('kecamatan.kartu_keluarga.index') }}" class="flex space-x-4">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="search-box flex-grow">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No KK atau Kepala Keluarga" 
                               class="w-full border border-gray-300 rounded-lg p-2 pl-10 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                    @if ($search)
                        <a href="{{ route('kecamatan.kartu_keluarga.index', ['tab' => $tab]) }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-2">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </form>
                
                @if ($search)
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            Menampilkan hasil pencarian untuk: <span class="font-semibold">"{{ $search }}"</span>
                            ({{ $kartuKeluargas->total() }} data ditemukan)
                        </p>
                    </div>
                @endif
            </div>
            
            <!-- Tabel Data -->
            <div class="table-container">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No KK</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kepala Keluarga</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Alamat</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Koordinat</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Diupload Oleh</th>
                            @if ($tab === 'pending')
                                <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($kartuKeluargas as $index => $kk)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $kartuKeluargas->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <div class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                        <i class="fas fa-id-card text-blue-400"></i>
                                        {{ $kk->no_kk }}
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-gray-800 font-medium">{{ $kk->kepala_keluarga }}</td>
                                <td class="p-4 text-sm text-gray-700 max-w-xs truncate">{{ $kk->alamat ?? 'Tidak ada' }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $kk->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                                <td class="p-4 text-sm text-gray-700">
                                    @if($kk->latitude)
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-red-400"></i>
                                            {{ number_format($kk->latitude, 6) }}, {{ number_format($kk->longitude, 6) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($kk->status == 'Aktif')
                                        <span class="badge badge-success">
                                            <span class="status-indicator status-verified"></span>
                                            <i class="fas fa-check-circle mr-1"></i> Aktif
                                        </span>
                                    @elseif($kk->status == 'Pending')
                                        <span class="badge badge-pending">
                                            <span class="status-indicator status-pending"></span>
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge badge-pending">
                                            <span class="status-indicator status-pending"></span>
                                            <i class="fas fa-clock mr-1"></i> Tidak diketahui
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-user text-gray-400 mr-2"></i>
                                        {{ $kk->createdBy->name ?? 'Tidak diketahui' }}
                                    </div>
                                </td>
                                @if ($tab === 'pending')
                                    <td class="p-4">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('kecamatan.kartu_keluarga.approve', $kk->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="action-btn action-btn-approve" title="Setujui Kartu Keluarga">
                                                    <i class="fas fa-check mr-1"></i> Setujui
                                                </button>
                                            </form>
                                            <button type="button" 
                                                    class="action-btn action-btn-reject reject-btn" 
                                                    data-id="{{ $kk->id }}"
                                                    data-no-kk="{{ $kk->no_kk }}"
                                                    title="Tolak Kartu Keluarga">
                                                <i class="fas fa-times mr-1"></i> Tolak
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $tab === 'pending' ? 9 : 8 }}" class="p-8">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data kartu keluarga yang sesuai dengan filter.</p>
                                        @if ($search)
                                            <a href="{{ route('kecamatan.kartu_keluarga.index', ['tab' => $tab]) }}" class="text-green-500 hover:text-green-700 mt-2 flex items-center justify-center">
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
            @if($kartuKeluargas->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $kartuKeluargas->appends(['tab' => $tab, 'search' => $search])->links() }}
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal Penolakan -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Tolak Kartu Keluarga</h3>
                <p class="text-sm text-gray-600 mt-1">Berikan alasan penolakan untuk kartu keluarga <span id="kk-number" class="font-semibold"></span></p>
            </div>
            <form id="rejectForm" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea name="catatan" id="catatan" rows="3" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Masukkan alasan penolakan..." required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelReject" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">Batal</button>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Table row animation
            $('tbody tr').each(function(index) {
                $(this).css({
                    opacity: 0,
                    transform: 'translateY(10px)'
                }).delay(index * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 300);
            });

            // Handle reject button click
            $('.reject-btn').on('click', function() {
                var id = $(this).data('id');
                var noKK = $(this).data('no-kk');
                
                $('#kk-number').text(noKK);
                $('#rejectForm').attr('action', '{{ url("kecamatan/kartu-keluarga") }}/' + id + '/reject');
                $('#rejectModal').removeClass('hidden');
            });
            
            // Cancel reject modal
            $('#cancelReject').on('click', function() {
                $('#rejectModal').addClass('hidden');
                $('#catatan').val('');
            });
            
            // Handle approve button click with confirmation
            $('form[action*="/approve"]').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                var noKK = $(this).closest('tr').find('td:nth-child(2)').text().trim();
                
                Swal.fire({
                    title: 'Konfirmasi Persetujuan',
                    text: `Apakah Anda yakin ingin menyetujui kartu keluarga ${noKK}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Setujui',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
            
            // Handle session messages with SweetAlert2
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#15803d',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#15803d',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
        });
    </script>
</body>
</html>