<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - Perangkat Daerah</title>
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
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6;
        }
        
        .tab-hover {
            transition: all 0.2s ease;
        }
        
        .tab-hover:hover {
            background-color: #f8fafc;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
            color: #d97706;
        }
        
        .status-verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .table-row-hover {
            transition: background-color 0.2s ease;
        }
        
        .table-row-hover:hover {
            background-color: #f8fafc;
        }
        
        .badge-hijau {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-kuning {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .badge-merah {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .badge-biru {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            padding-left: 12px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        
        .filter-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Monitoring</h1>
                    <p class="text-gray-600">Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan ?? '-' }}</p>
                </div>
                <a href="{{ route('perangkat_daerah.data_monitoring.create') }}" 
                   class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition flex items-center shadow-md">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Data Monitoring
                </a>
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
        <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
            <div class="flex">
                <a href="{{ route('perangkat_daerah.data_monitoring.index', ['tab' => 'pending', 'kelurahan_id' => $kelurahan_id, 'kategori' => $kategori, 'warna_badge' => $warna_badge]) }}"
                   class="flex-1 py-4 px-6 text-center tab-hover {{ $tab === 'pending' ? 'border-b-2 border-red-500 text-red-600 font-semibold' : 'text-gray-500' }}">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Pending Verifikasi</span>
                        @if($tab === 'pending')
                            <span class="ml-2 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">{{ $dataMonitorings->total() }}</span>
                        @endif
                    </div>
                </a>
                <a href="{{ route('perangkat_daerah.data_monitoring.index', ['tab' => 'verified', 'kelurahan_id' => $kelurahan_id, 'kategori' => $kategori, 'warna_badge' => $warna_badge]) }}"
                   class="flex-1 py-4 px-6 text-center tab-hover {{ $tab === 'verified' ? 'border-b-2 border-green-500 text-green-600 font-semibold' : 'text-gray-500' }}">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Terverifikasi</span>
                        @if($tab === 'verified')
                            <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ $dataMonitorings->total() }}</span>
                        @endif
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-card rounded-xl shadow-sm mb-6 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-blue-500"></i>
                Filter Data
            </h3>
            <form method="GET" action="{{ route('perangkat_daerah.data_monitoring.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="hidden" name="tab" value="{{ $tab }}">
                
                <div>
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" 
                               class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg bg-gray-50" readonly>
                    </div>
                </div>
                
                <div>
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="w-full border border-gray-300 rounded-lg">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" id="kategori" class="w-full border border-gray-300 rounded-lg">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriOptions as $kategoriOption)
                            <option value="{{ $kategoriOption }}" {{ $kategori == $kategoriOption ? 'selected' : '' }}>{{ $kategoriOption }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="warna_badge" class="block text-sm font-medium text-gray-700 mb-1">Warna Badge</label>
                    <select name="warna_badge" id="warna_badge" class="w-full border border-gray-300 rounded-lg">
                        <option value="">Semua Warna</option>
                        @foreach ($warnaBadgeOptions as $warna)
                            <option value="{{ $warna }}" {{ $warna_badge == $warna ? 'selected' : '' }}>{{ $warna }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="md:col-span-4 flex justify-end space-x-3 mt-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center">
                        <i class="fas fa-filter mr-2"></i>
                        Terapkan Filter
                    </button>
                    <a href="{{ route('perangkat_daerah.data_monitoring.index', ['tab' => $tab]) }}" 
                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition flex items-center">
                        <i class="fas fa-redo mr-2"></i>
                        Reset
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">No</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Nama & Target</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Lokasi</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Kategori & Status</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Warna Badge</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Tanggal Monitoring</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Kartu Keluarga</th>
                            @if ($tab == 'pending')
                                <th class="p-4 text-left text-sm font-semibold text-gray-600">Status Verifikasi</th>
                                <th class="p-4 text-left text-sm font-semibold text-gray-600">Catatan</th>
                            @endif
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($dataMonitorings as $index => $dataMonitoring)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $dataMonitorings->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900">{{ $dataMonitoring->nama }}</span>
                                        <span class="text-sm text-gray-600 mt-1">{{ $dataMonitoring->target }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <div class="flex items-center text-sm text-gray-600 mb-1">
                                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                                            <span>{{ $dataMonitoring->kecamatan->nama_kecamatan ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-map-pin mr-2 text-blue-500"></i>
                                            <span>{{ $dataMonitoring->kelurahan->nama_kelurahan ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-gray-700 mb-1">{{ $dataMonitoring->kategori }}</span>
                                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full inline-block">{{ $dataMonitoring->status }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="status-badge badge-{{ strtolower($dataMonitoring->warna_badge) }}">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $dataMonitoring->warna_badge }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if ($dataMonitoring->tanggal_monitoring)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                            <span>{{ $dataMonitoring->tanggal_monitoring->format('d M Y') }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm flex items-center">
                                            <i class="fas fa-ban mr-1"></i>
                                            Tidak ada
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if ($dataMonitoring->kartuKeluarga)
                                        <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $dataMonitoring->kartuKeluarga->id) }}" 
                                           class="text-blue-500 hover:underline text-sm flex items-center">
                                            <i class="fas fa-link mr-1 text-xs"></i>
                                            Lihat KK
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-sm flex items-center">
                                            <i class="fas fa-ban mr-1"></i>
                                            Belum ada
                                        </span>
                                    @endif
                                </td>
                                @if ($tab == 'pending')
                                    <td class="p-4">
                                        <span class="status-badge {{ $dataMonitoring->status_verifikasi === 'pending' ? 'status-pending' : 'status-verified' }}">
                                            <i class="fas {{ $dataMonitoring->status_verifikasi === 'pending' ? 'fa-clock' : 'fa-check-circle' }} mr-1"></i>
                                            {{ ucfirst($dataMonitoring->status_verifikasi) }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        @if ($dataMonitoring->catatan)
                                            <button onclick="showNote('{{ $dataMonitoring->catatan }}')" 
                                                    class="text-blue-500 hover:text-blue-700 flex items-center text-sm">
                                                <i class="fas fa-sticky-note mr-1"></i>
                                                Lihat Catatan
                                            </button>
                                        @else
                                            <span class="text-gray-400 text-sm flex items-center">
                                                <i class="fas fa-ban mr-1"></i>
                                                Tidak ada
                                            </span>
                                        @endif
                                    </td>
                                @endif
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('perangkat_daerah.data_monitoring.edit', [$dataMonitoring->id, $tab]) }}" 
                                           class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50 transition" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($tab == 'pending')
                                            <form action="{{ route('perangkat_daerah.data_monitoring.destroy', [$dataMonitoring->id, 'pending']) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition" 
                                                        title="Hapus"
                                                        onclick="return confirmDelete()">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button onclick="showDetails({{ json_encode($dataMonitoring) }})" 
                                                class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50 transition" 
                                                title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $tab == 'pending' ? 10 : 8 }}" class="p-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg">Tidak ada data monitoring</p>
                                        <p class="text-sm mt-2">Silakan tambah data monitoring baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($dataMonitorings->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $dataMonitorings->links() }}
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal for Note -->
    <div id="noteModal" class="modal-overlay">
        <div class="modal-content w-full max-w-md">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Catatan</h3>
                <button onclick="closeNoteModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <p id="noteContent" class="text-gray-700"></p>
            </div>
        </div>
    </div>

    <!-- Modal for Details -->
    <div id="detailsModal" class="modal-overlay">
        <div class="modal-content w-full max-w-4xl">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Detail Data Monitoring</h3>
                <button onclick="closeDetailsModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <div id="detailsContent"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kelurahan_id').select2({ 
                placeholder: 'Semua Kelurahan', 
                allowClear: true,
                width: '100%'
            });
            $('#kategori').select2({ 
                placeholder: 'Semua Kategori', 
                allowClear: true,
                width: '100%'
            });
            $('#warna_badge').select2({ 
                placeholder: 'Semua Warna', 
                allowClear: true,
                width: '100%'
            });
        });
        
        function showNote(note) {
            document.getElementById('noteContent').textContent = note;
            document.getElementById('noteModal').style.display = 'flex';
        }
        
        function closeNoteModal() {
            document.getElementById('noteModal').style.display = 'none';
        }
        
        function showDetails(dataMonitoring) {
            const detailsHtml = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700">Nama</h4>
                            <p class="text-gray-900">${dataMonitoring.nama}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700">Target</h4>
                            <p class="text-gray-900">${dataMonitoring.target}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700">Kecamatan</h4>
                            <p class="text-gray-900">${dataMonitoring.kecamatan ? dataMonitoring.kecamatan.nama_kecamatan : '-'}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700">Kelurahan</h4>
                            <p class="text-gray-900">${dataMonitoring.kelurahan ? dataMonitoring.kelurahan.nama_kelurahan : '-'}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700">Kategori</h4>
                            <p class="text-gray-900">${dataMonitoring.kategori}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700">Status</h4>
                            <p class="text-gray-900">${dataMonitoring.status}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700">Warna Badge</h4>
                            <span class="status-badge badge-${dataMonitoring.warna_badge.toLowerCase()}">
                                <i class="fas fa-tag mr-1"></i>
                                ${dataMonitoring.warna_badge}
                            </span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700">Tanggal Monitoring</h4>
                            <p class="text-gray-900">${dataMonitoring.tanggal_monitoring ? new Date(dataMonitoring.tanggal_monitoring).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) : '-'}</p>
                        </div>
                    </div>
                    ${dataMonitoring.tab === 'pending' ? `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-semibold text-gray-700">Status Verifikasi</h4>
                                <span class="status-badge ${dataMonitoring.status_verifikasi === 'pending' ? 'status-pending' : 'status-verified'}">
                                    <i class="fas ${dataMonitoring.status_verifikasi === 'pending' ? 'fa-clock' : 'fa-check-circle'} mr-1"></i>
                                    ${dataMonitoring.status_verifikasi.charAt(0).toUpperCase() + dataMonitoring.status_verifikasi.slice(1)}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-700">Catatan</h4>
                                <p class="text-gray-900">${dataMonitoring.catatan || '-'}</p>
                            </div>
                        </div>
                    ` : ''}
                </div>
            `;
            
            document.getElementById('detailsContent').innerHTML = detailsHtml;
            document.getElementById('detailsModal').style.display = 'flex';
        }
        
        function closeDetailsModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }
        
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data monitoring ini?');
        }
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            const noteModal = document.getElementById('noteModal');
            const detailsModal = document.getElementById('detailsModal');
            
            if (event.target === noteModal) {
                closeNoteModal();
            }
            
            if (event.target === detailsModal) {
                closeDetailsModal();
            }
        }
        
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
    </script>
</body>
</html>