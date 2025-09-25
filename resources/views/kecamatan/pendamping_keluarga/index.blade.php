<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendamping Keluarga - Admin Kecamatan</title>
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .table-container table {
            min-width: 100%;
        }
        
        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
            z-index: 10;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .status-aktif {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-tidak-aktif {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        
        .status-pensiun {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .peran-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .peran-kader {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        
        .peran-ketua {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .peran-konselor {
            background-color: #fef7cd;
            color: #a16207;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 12px 24px;
            cursor: pointer;
            font-weight: 600;
            color: #6b7280;
            position: relative;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .tab.active {
            color: #15803d;
        }
        
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #15803d;
            border-radius: 3px 3px 0 0;
        }
        
        .tab:hover:not(.active) {
            color: #4b5563;
            background-color: #f9fafb;
        }
        
        .pagination .page-link {
            padding: 8px 12px;
            margin: 0 2px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .pagination .page-link:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .pagination .active .page-link {
            background-color: #15803d;
            border-color: #15803d;
            color: white;
        }
        
        .filter-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: none;
            cursor: pointer;
        }
        
        .action-btn.approve {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .action-btn.approve:hover {
            background-color: #a7f3d0;
        }
        
        .action-btn.reject {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .action-btn.reject:hover {
            background-color: #fecaca;
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
        
        .rejection-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-top: 8px;
            font-size: 14px;
        }
        
        .rejection-input:focus {
            outline: none;
            border-color: #15803d;
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
        }
        
        tbody tr {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .kk-list {
            max-height: 120px;
            overflow-y: auto;
            padding-right: 8px;
        }
        
        .kk-list ul {
            margin: 0;
            padding-left: 16px;
        }
        
        .kk-list li {
            margin-bottom: 4px;
            font-size: 12px;
            color: #4b5563;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #d1d5db;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('kecamatan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Pendamping Keluarga</span></h1>
            <p class="text-gray-600">Kelola data pendamping keluarga di Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan ?? 'Kecamatan Anda' }}</p>
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
        @if (session('error') || isset($errorMessage))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') ?? $errorMessage }}</span>
                </div>
            </div>
        @endif
        
        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending', 'kelurahan_id' => $kelurahan_id, 'peran' => $peran, 'status' => $status]) }}"
               class="tab {{ $tab === 'pending' ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                Pending Verifikasi
            </a>
            <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => 'verified', 'kelurahan_id' => $kelurahan_id, 'peran' => $peran, 'status' => $status]) }}"
               class="tab {{ $tab === 'verified' ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i>
                Terverifikasi
            </a>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-card">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-filter text-green-500"></i>
                Filter Data
            </h3>
            <form method="GET" action="{{ route('kecamatan.pendamping_keluarga.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select name="kelurahan_id" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Peran</label>
                    <select name="peran" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">Semua Peran</option>
                        @foreach ($peranOptions as $p)
                            <option value="{{ $p }}" {{ $peran == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                        <option value="">Semua Status</option>
                        @foreach ($statusOptions as $s)
                            <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2 h-10 w-full justify-center">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if ($kelurahan_id || $peran || $status)
                        <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => $tab]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Filter Info -->
        @if ($kelurahan_id || $peran || $status)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <div>
                        <span class="font-medium text-blue-800">Filter Aktif:</span>
                        <span class="text-blue-700 ml-2">
                            @if ($kelurahan_id)
                                Kelurahan: {{ $kelurahans->where('id', $kelurahan_id)->first()->nama_kelurahan ?? 'Tidak diketahui' }}
                            @endif
                            @if ($peran)
                                | Peran: {{ $peran }}
                            @endif
                            @if ($status)
                                | Status: {{ $status }}
                            @endif
                            | Total: {{ $pendampingKeluargas->total() }} data
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-100 p-4 mb-6 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-database text-gray-500 mr-2"></i>
                    <span class="text-gray-700">Menampilkan semua data pendamping keluarga {{ $tab === 'pending' ? 'pending verifikasi' : 'terverifikasi' }} ({{ $pendampingKeluargas->total() }} data)</span>
                </div>
                <div class="text-sm text-gray-500">
                    <i class="fas fa-sync-alt mr-1"></i>
                    Data terbaru
                </div>
            </div>
        @endif
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-users text-green-500"></i>
                        Data Pendamping Keluarga - {{ $tab === 'pending' ? 'Pending Verifikasi' : 'Terverifikasi' }}
                    </h3>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $pendampingKeluargas->currentPage() }} dari {{ $pendampingKeluargas->lastPage() }}
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-4 text-left font-medium text-gray-700">No</th>
                            <th class="p-4 text-left font-medium text-gray-700">Nama</th>
                            <th class="p-4 text-left font-medium text-gray-700">Peran</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Status</th>
                            <th class="p-4 text-left font-medium text-gray-700">Tahun Bergabung</th>
                            <th class="p-4 text-left font-medium text-gray-700">KK Ditangani</th>
                            @if ($tab === 'pending')
                                <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendampingKeluargas as $pendamping)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-green-50 transition">
                                <td class="p-4 text-gray-600">{{ $loop->iteration + ($pendampingKeluargas->firstItem() - 1) }}</td>
                                <td class="p-4 font-medium text-gray-800">{{ $pendamping->nama ?? '-' }}</td>
                                <td class="p-4">
                                    @php
                                        $peranClass = 'peran-badge';
                                        $peranIcon = 'fas fa-user';
                                        if ($pendamping->peran === 'Kader') {
                                            $peranClass .= ' peran-kader';
                                            $peranIcon = 'fas fa-hands-helping';
                                        } elseif ($pendamping->peran === 'Ketua') {
                                            $peranClass .= ' peran-ketua';
                                            $peranIcon = 'fas fa-crown';
                                        } elseif ($pendamping->peran === 'Konselor') {
                                            $peranClass .= ' peran-konselor';
                                            $peranIcon = 'fas fa-comments';
                                        }
                                    @endphp
                                    <span class="{{ $peranClass }}">
                                        <i class="{{ $peranIcon }}"></i>
                                        {{ $pendamping->peran ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4">
                                    @php
                                        $statusClass = 'status-tidak-aktif';
                                        $statusIcon = 'fas fa-minus-circle';
                                        if ($pendamping->status === 'Aktif') {
                                            $statusClass = 'status-aktif';
                                            $statusIcon = 'fas fa-check-circle';
                                        } elseif ($pendamping->status === 'Pensiun') {
                                            $statusClass = 'status-pensiun';
                                            $statusIcon = 'fas fa-user-clock';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="{{ $statusIcon }}"></i>
                                        {{ $pendamping->status ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $pendamping->tahun_bergabung ?? '-' }}</td>
                                <td class="p-4">
                                    @if ($pendamping->kartuKeluargas->isNotEmpty())
                                        <div class="kk-list">
                                            <span class="text-sm font-medium text-gray-700">{{ $pendamping->kartuKeluargas->count() }} KK</span>
                                            <ul>
                                                @foreach ($pendamping->kartuKeluargas->take(3) as $kk)
                                                    <li>{{ $kk->no_kk }} ({{ $kk->kepala_keluarga }})</li>
                                                @endforeach
                                                @if ($pendamping->kartuKeluargas->count() > 3)
                                                    <li class="text-green-600 font-medium">... dan {{ $pendamping->kartuKeluargas->count() - 3 }} KK lainnya</li>
                                                @endif
                                            </ul>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Tidak ada</span>
                                    @endif
                                </td>
                                @if ($tab === 'pending')
                                    <td class="p-4">
                                        <div class="action-buttons">
                                            <form action="{{ route('kecamatan.pendamping_keluarga.approve', $pendamping->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="action-btn approve" onclick="return confirmAction('approve', '{{ $pendamping->nama ?? 'Pendamping' }}')">
                                                    <i class="fas fa-check"></i>
                                                    Setujui
                                                </button>
                                            </form>
                                            <button type="button" class="action-btn reject" onclick="showRejectionModal('{{ $pendamping->id }}', '{{ $pendamping->nama ?? 'Pendamping' }}')">
                                                <i class="fas fa-times"></i>
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $tab === 'pending' ? 8 : 7 }}" class="p-8 text-center">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <p class="text-gray-500 text-lg">
                                            @if ($tab === 'pending')
                                                Tidak ada data pendamping keluarga yang menunggu verifikasi.
                                            @else
                                                Tidak ada data pendamping keluarga yang telah terverifikasi.
                                            @endif
                                        </p>
                                        @if ($kelurahan_id || $peran || $status)
                                            <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => $tab]) }}" class="text-green-500 hover:text-green-700 mt-2 flex items-center gap-1">
                                                <i class="fas fa-redo"></i>
                                                Tampilkan semua data
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
            @if ($pendampingKeluargas->hasPages())
                <div class="p-4 border-t border-gray-200">
                    <div class="pagination flex justify-center">
                        {{ $pendampingKeluargas->appends(['tab' => $tab, 'kelurahan_id' => $kelurahan_id, 'peran' => $peran, 'status' => $status])->links() }}
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal Penolakan -->
    <div id="rejectionModal" class="modal-overlay">
        <div class="modal-content" style="max-width: 500px;">
            <span class="modal-close" onclick="closeRejectionModal()"><i class="fas fa-times"></i></span>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tolak Data Pendamping Keluarga</h3>
            <p class="text-gray-600 mb-4">Anda akan menolak data pendamping: <span id="rejectionPendampingName" class="font-semibold"></span></p>
            <form id="rejectionForm" method="POST">
                @csrf
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                <textarea name="catatan" id="catatan" placeholder="Masukkan alasan penolakan" class="rejection-input" rows="3" required></textarea>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="px-4 py-2 text-gray-600 hover:text-gray-800" onclick="closeRejectionModal()">Batal</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Tolak Data</button>
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

            // Rejection modal
            window.showRejectionModal = function(pendampingId, pendampingName) {
                $('#rejectionPendampingName').text(pendampingName);
                $('#rejectionForm').attr('action', '{{ url("kecamatan/pendamping-keluarga") }}/' + pendampingId + '/reject');
                $('#rejectionModal').addClass('active');
                $('#catatan').focus();
            };

            window.closeRejectionModal = function() {
                $('#rejectionModal').removeClass('active');
                $('#catatan').val('');
            };

            // Confirm action
            window.confirmAction = function(action, name) {
                if (action === 'approve') {
                    return confirm('Apakah Anda yakin ingin menyetujui data pendamping ' + name + '?');
                }
                return true;
            };

            // SweetAlert for session messages
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#15803d',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error') || isset($errorMessage))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') ?? $errorMessage }}',
                    confirmButtonColor: '#dc2626',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            // Close modal when clicking outside
            $(document).on('click', function(e) {
                if ($(e.target).hasClass('modal-overlay')) {
                    closeRejectionModal();
                }
            });
        });
    </script>
</body>
</html>