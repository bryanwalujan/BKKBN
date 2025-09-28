<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Balita - CSSR</title>
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .table-container table {
            min-width: 1200px;
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
            display: inline-block;
        }
        
        .status-stunting {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .status-normal {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-risiko {
            background-color: #fef3c7;
            color: #d97706;
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
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
        
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 8px 12px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
            padding-left: 0;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
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
        }
        
        .action-btn.edit {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .action-btn.edit:hover {
            background-color: #bfdbfe;
        }
        
        .action-btn.delete {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .action-btn.delete:hover {
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
        
        .thumbnail {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .thumbnail:hover {
            transform: scale(1.1);
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-input-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-input-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background-color: #f3f4f6;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .file-input-label:hover {
            background-color: #e5e7eb;
            border-color: #9ca3af;
        }
        
        .file-name {
            margin-left: 8px;
            font-size: 14px;
            color: #6b7280;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Data <span class="gradient-text">Balita</span></h1>
            <p class="text-gray-600">Kelola data balita untuk monitoring stunting di wilayah Anda.</p>
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
        
        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <a href="{{ route('balita.create') }}" class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition flex items-center justify-center gap-2 card-hover">
                <i class="fas fa-plus-circle"></i>
                Tambah Balita
            </a>
            <a href="{{ route('balita.downloadTemplate') }}" class="bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-600 transition flex items-center justify-center gap-2 card-hover">
                <i class="fas fa-download"></i>
                Template Excel
            </a>
            <div class="file-input-wrapper">
                <form action="{{ route('balita.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="h-full">
                    @csrf
                    <input type="file" name="file" accept=".xlsx,.xls" id="fileInput" class="border-gray-300 rounded-md shadow-sm">
                    <label for="fileInput" class="file-input-label h-full w-full cursor-pointer">
                        <i class="fas fa-file-import text-purple-500"></i>
                        <span>Import Excel</span>
                    </label>
                    <span id="fileName" class="file-name"></span>
                </form>
            </div>
            <a href="{{ route('peta_geospasial.index') }}" class="bg-purple-500 text-white px-4 py-3 rounded-lg hover:bg-purple-600 transition flex items-center justify-center gap-2 card-hover">
                <i class="fas fa-map-marked-alt"></i>
                Peta Geospasial
            </a>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-card mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-filter text-blue-500"></i>
                Filter Data
            </h3>
            <form action="{{ route('balita.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="w-full">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="w-full">
                        <option value="">Semua Kelurahan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Umur</label>
                    <select name="kategori_umur" class="w-full border-gray-300 rounded-md shadow-sm p-2">
                        <option value="" {{ $kategoriUmur == '' ? 'selected' : '' }}>Semua Kategori</option>
                        <option value="Baduata" {{ $kategoriUmur == 'Baduata' ? 'selected' : '' }}>Baduata (0-24 bulan)</option>
                        <option value="Balita" {{ $kategoriUmur == 'Balita' ? 'selected' : '' }}>Balita (25-60 bulan)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama atau NIK" class="w-full border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition flex items-center gap-2 h-10 w-full justify-center">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if ($kecamatan_id || $kelurahan_id || $kategoriUmur || $search)
                        <a href="{{ route('balita.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Filter Info -->
        @if ($kecamatan_id || $kelurahan_id || $kategoriUmur || $search)
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <div>
                        <span class="font-medium text-blue-800">Filter Aktif:</span>
                        <span class="text-blue-700 ml-2">
                            @if ($kecamatan_id)
                                Kecamatan: {{ $kecamatans->find($kecamatan_id)->nama_kecamatan ?? '-' }}
                            @endif
                            @if ($kelurahan_id)
                                | Kelurahan: {{ \App\Models\Kelurahan::find($kelurahan_id)->nama_kelurahan ?? '-' }}
                            @endif
                            @if ($kategoriUmur)
                                | Kategori: {{ $kategoriUmur }} ({{ $kategoriUmur == 'Baduata' ? '0-24 bulan' : '25-60 bulan' }})
                            @endif
                            @if ($search)
                                | Pencarian: "{{ $search }}"
                            @endif
                            | Total: {{ $balitas->total() }} data
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-100 p-4 mb-6 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-database text-gray-500 mr-2"></i>
                    <span class="text-gray-700">Menampilkan semua data balita ({{ $balitas->total() }} data)</span>
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
                        <i class="fas fa-baby text-blue-500"></i>
                        Data Balita
                    </h3>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $balitas->currentPage() }} dari {{ $balitas->lastPage() }}
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-4 text-left font-medium text-gray-700">No</th>
                            <th class="p-4 text-left font-medium text-gray-700">Foto</th>
                            <th class="p-4 text-left font-medium text-gray-700">Nama</th>
                            <th class="p-4 text-left font-medium text-gray-700">NIK</th>
                            <th class="p-4 text-left font-medium text-gray-700">No KK</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kecamatan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Usia</th>
                            <th class="p-4 text-left font-medium text-gray-700">Kategori</th>
                            <th class="p-4 text-left font-medium text-gray-700">Berat/Tinggi</th>
                            <th class="p-4 text-left font-medium text-gray-700">Lingkar Kepala</th>
                            <th class="p-4 text-left font-medium text-gray-700">Lingkar Lengan</th>
                            <th class="p-4 text-left font-medium text-gray-700">Status Gizi</th>
                            <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($balitas as $balita)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                                <td class="p-4 text-gray-600">{{ $loop->iteration + ($balitas->firstItem() - 1) }}</td>
                                <td class="p-4">
                                    @if ($balita->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($balita->foto))
                                        <img src="{{ asset('storage/' . $balita->foto) }}" alt="Foto {{ $balita->nama ?? 'Balita' }}" class="thumbnail" onclick="showPhotoModal('{{ asset('storage/' . $balita->foto) }}', '{{ $balita->nama ?? 'Balita' }}')">
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="p-4 font-medium text-gray-800">{{ $balita->nama ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $balita->nik ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $balita->kartuKeluarga->no_kk ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $balita->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $balita->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $balita->usia !== null ? $balita->usia . ' bulan' : '-' }}</td>
                                <td class="p-4">
                                    <span class="status-badge {{ $balita->kategoriUmur == 'Baduata' ? 'status-risiko' : 'status-normal' }}">
                                        {{ $balita->kategoriUmur ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">{{ $balita->berat_tinggi ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $balita->lingkar_kepala ? $balita->lingkar_kepala . ' cm' : '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $balita->lingkar_lengan ? $balita->lingkar_lengan . ' cm' : '-' }}</td>
                                <td class="p-4">
                                    @php
                                        $statusClass = 'status-normal';
                                        if (strpos(strtolower($balita->status_gizi ?? ''), 'stunting') !== false) {
                                            $statusClass = 'status-stunting';
                                        } elseif (strpos(strtolower($balita->status_gizi ?? ''), 'risiko') !== false) {
                                            $statusClass = 'status-risiko';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $balita->status_gizi ?? '-' }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="action-buttons">
                                        <a href="{{ route('balita.edit', $balita->id) }}" class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="action-btn delete" onclick="showDeleteModal('{{ route('balita.destroy', $balita->id) }}', '{{ $balita->nama ?? 'Balita' }}')">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data balita yang sesuai dengan filter.</p>
                                        <a href="{{ route('balita.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 flex items-center gap-1">
                                            <i class="fas fa-redo"></i>
                                            Tampilkan semua data
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if ($balitas->hasPages())
                <div class="p-4 border-t border-gray-200">
                    <div class="pagination flex justify-center">
                        {{ $balitas->appends(['kecamatan_id' => $kecamatan_id, 'kelurahan_id' => $kelurahan_id, 'kategori_umur' => $kategoriUmur, 'search' => $search])->links() }}
                    </div>
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
            <img id="modalImage" src="" alt="Foto Balita" class="mx-auto">
            <p id="modalCaption" class="text-center text-gray-600 mt-4"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: 'Semua Kecamatan',
                allowClear: true
            });

            $('#kelurahan_id').select2({
                placeholder: 'Semua Kelurahan',
                allowClear: true
            });

            // Load kelurahans for selected kecamatan on page load
            var initialKecamatanId = '{{ $kecamatan_id ?? '' }}';
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty();
                        $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == '{{ $kelurahan_id ?? '' }}' ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Memuat Kelurahan',
                            text: 'Terjadi kesalahan saat memuat data kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                });
            }

            // Update kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kelurahan_id').empty();
                            $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Memuat Kelurahan',
                                text: 'Terjadi kesalahan saat memuat data kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
            });

            // File input handler
            $('#fileInput').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $('#fileName').text(fileName);
                    $('#importForm').submit();
                }
            });

            // Delete modal with SweetAlert2
            window.showDeleteModal = function(url, name) {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Apakah Anda yakin ingin menghapus data balita <span class="font-bold text-red-600">${name}</span>? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Hapus',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = url;
                        
                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = '{{ csrf_token() }}';
                        form.appendChild(csrf);
                        
                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

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