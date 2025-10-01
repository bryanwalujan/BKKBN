<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kegiatan Genting - CSSR</title>
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
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            position: relative;
        }
        
        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }
        
        .close-modal:hover {
            color: #374151;
        }
        
        .pihak-ketiga-list {
            max-height: 150px;
            overflow-y: auto;
        }
        
        .pihak-ketiga-item {
            display: flex;
            align-items: center;
            padding: 0.25rem 0;
            font-size: 0.875rem;
        }
        
        .pihak-ketiga-item i {
            margin-right: 0.5rem;
            width: 16px;
            color: #6b7280;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data <span class="gradient-text">Kegiatan Genting</span></h1>
                    <p class="text-gray-600">Kelola data kegiatan genting dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('genting.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Kegiatan Genting
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Kegiatan</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $gentings->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-tasks text-blue-500 text-xl"></i>
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
                        <p class="text-sm font-medium text-gray-500">Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $gentings->where('tanggal', '>=', \Carbon\Carbon::now()->startOfMonth())->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>Kegiatan bulan ini</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dengan Dokumentasi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $gentings->whereNotNull('dokumentasi')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-camera text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-image mr-1"></i>
                    <span>Kegiatan terdokumentasi</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Intervensi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $gentings->groupBy('jenis_intervensi')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart text-orange-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-hands-helping mr-1"></i>
                    <span>Jenis intervensi</span>
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
                    <p class="text-gray-600 text-sm mt-1">Saring data kegiatan genting berdasarkan kriteria tertentu</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-filter mr-2 text-blue-500"></i>
                    <span>Filter data</span>
                </div>
            </div>
            
            <form action="{{ route('genting.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Intervensi</label>
                    <select name="jenis_intervensi" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                        <option value="">Semua Jenis</option>
                        @foreach ($gentings->pluck('jenis_intervensi')->unique() as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis_intervensi') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                    <select name="bulan" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="tahun" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                        <option value="">Semua Tahun</option>
                        @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 h-10">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if (request()->hasAny(['jenis_intervensi', 'bulan', 'tahun']))
                        <a href="{{ route('genting.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
            
            @if (request()->hasAny(['jenis_intervensi', 'bulan', 'tahun']))
                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan data
                        @if (request('jenis_intervensi'))
                            untuk jenis intervensi: <span class="font-semibold">{{ request('jenis_intervensi') }}</span>
                        @endif
                        @if (request('bulan'))
                            pada bulan: <span class="font-semibold">{{ \Carbon\Carbon::create()->month(request('bulan'))->translatedFormat('F') }}</span>
                        @endif
                        @if (request('tahun'))
                            tahun: <span class="font-semibold">{{ request('tahun') }}</span>
                        @endif
                        ({{ $gentings->count() }} data ditemukan)
                    </p>
                </div>
            @else
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan semua data kegiatan genting ({{ $gentings->count() }} data)
                    </p>
                </div>
            @endif
        </div>
        
        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Kegiatan Genting</h3>
                        <p class="text-gray-600 text-sm mt-1">Daftar lengkap kegiatan genting dalam sistem</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Total {{ $gentings->count() }} data
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kartu Keluarga</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Dokumentasi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Nama Kegiatan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Tanggal</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Lokasi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Sasaran</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Jenis Intervensi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Narasi</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Pihak Ketiga</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($gentings as $index => $genting)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    @if ($genting->kartuKeluarga)
                                        <a href="{{ route('kartu_keluarga.show', $genting->kartuKeluarga->id) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                            <i class="fas fa-id-card text-blue-400"></i>
                                            {{ $genting->kartuKeluarga->no_kk }} - {{ $genting->kartuKeluarga->kepala_keluarga }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 flex items-center gap-1">
                                            <i class="fas fa-times-circle text-gray-300"></i>
                                            Tidak terkait KK
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if ($genting->dokumentasi)
                                        <img src="{{ Storage::url($genting->dokumentasi) }}" 
                                             alt="Dokumentasi Kegiatan" 
                                             class="w-16 h-16 object-cover rounded cursor-pointer hover:opacity-80 transition"
                                             onclick="openModal('{{ Storage::url($genting->dokumentasi) }}')">
                                    @else
                                        <span class="text-gray-400 flex items-center gap-1">
                                            <i class="fas fa-image text-gray-300"></i>
                                            Tidak ada
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="font-medium text-gray-800">{{ $genting->nama_kegiatan }}</span>
                                </td>
                                <td class="p-4 text-sm text-gray-700">
                                    <div class="flex items-center gap-1">
                                        <i class="fas fa-calendar text-blue-400"></i>
                                        {{ \Carbon\Carbon::parse($genting->tanggal)->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $genting->lokasi }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $genting->sasaran }}</td>
                                <td class="p-4">
                                    <span class="badge badge-info">
                                        <i class="fas fa-tag mr-1"></i> {{ $genting->jenis_intervensi }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-700 max-w-xs">
                                    @if ($genting->narasi)
                                        <div class="truncate" title="{{ $genting->narasi }}">
                                            {{ Str::limit($genting->narasi, 50) }}
                                        </div>
                                        @if (strlen($genting->narasi) > 50)
                                            <button class="text-blue-500 text-xs mt-1 hover:underline" onclick="openNarasiModal('{{ $genting->narasi }}')">
                                                Baca selengkapnya
                                            </button>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="pihak-ketiga-list">
                                        @php
                                            $pihakKetigaCount = 0;
                                            if ($genting->dunia_usaha == 'ada') $pihakKetigaCount++;
                                            if ($genting->pemerintah == 'ada') $pihakKetigaCount++;
                                            if ($genting->bumn_bumd == 'ada') $pihakKetigaCount++;
                                            if ($genting->individu_perseorangan == 'ada') $pihakKetigaCount++;
                                            if ($genting->lsm_komunitas == 'ada') $pihakKetigaCount++;
                                            if ($genting->swasta == 'ada') $pihakKetigaCount++;
                                            if ($genting->perguruan_tinggi_akademisi == 'ada') $pihakKetigaCount++;
                                            if ($genting->media == 'ada') $pihakKetigaCount++;
                                            if ($genting->tim_pendamping_keluarga == 'ada') $pihakKetigaCount++;
                                            if ($genting->tokoh_masyarakat == 'ada') $pihakKetigaCount++;
                                        @endphp
                                        
                                        @if ($pihakKetigaCount > 0)
                                            <div class="text-xs text-gray-500 mb-1">{{ $pihakKetigaCount }} pihak terlibat</div>
                                            <div class="space-y-1">
                                                @if ($genting->dunia_usaha == 'ada')
                                                    <div class="pihak-ketiga-item">
                                                        <i class="fas fa-building"></i> Dunia Usaha
                                                    </div>
                                                @endif
                                                @if ($genting->pemerintah == 'ada')
                                                    <div class="pihak-ketiga-item">
                                                        <i class="fas fa-landmark"></i> Pemerintah
                                                    </div>
                                                @endif
                                                @if ($genting->bumn_bumd == 'ada')
                                                    <div class="pihak-ketiga-item">
                                                        <i class="fas fa-industry"></i> BUMN/BUMD
                                                    </div>
                                                @endif
                                                @if ($genting->individu_perseorangan == 'ada')
                                                    <div class="pihak-ketiga-item">
                                                        <i class="fas fa-user"></i> Individu
                                                    </div>
                                                @endif
                                            </div>
                                            @if ($pihakKetigaCount > 4)
                                                <button class="text-blue-500 text-xs mt-1 hover:underline" onclick="openPihakKetigaModal({{ $genting->id }})">
                                                    Lihat semua
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-sm">Tidak ada</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('genting.edit', $genting->id) }}" class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 delete-btn" 
                                                data-url="{{ route('genting.destroy', $genting->id) }}" 
                                                data-name="{{ $genting->nama_kegiatan }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data kegiatan genting yang sesuai dengan filter.</p>
                                        @if (request()->hasAny(['jenis_intervensi', 'bulan', 'tahun']))
                                            <a href="{{ route('genting.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 flex items-center">
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
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal untuk gambar dokumentasi -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <img id="modalImage" src="" alt="Dokumentasi Kegiatan" class="max-w-full max-h-full">
        </div>
    </div>

    <!-- Modal untuk narasi lengkap -->
    <div id="narasiModal" class="modal">
        <div class="modal-content max-w-2xl">
            <span class="close-modal" onclick="closeNarasiModal()">&times;</span>
            <h3 class="text-xl font-semibold mb-4">Narasi Kegiatan Lengkap</h3>
            <p id="modalNarasi" class="text-gray-700 whitespace-pre-line"></p>
        </div>
    </div>

    <!-- Modal untuk pihak ketiga lengkap -->
    <div id="pihakKetigaModal" class="modal">
        <div class="modal-content max-w-md">
            <span class="close-modal" onclick="closePihakKetigaModal()">&times;</span>
            <h3 class="text-xl font-semibold mb-4">Pihak Ketiga Terlibat</h3>
            <div id="modalPihakKetiga" class="space-y-2"></div>
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
                    text: `Apakah Anda yakin ingin menghapus kegiatan genting "${name}"? Tindakan ini tidak dapat dibatalkan.`,
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
                                    text: 'Kegiatan genting berhasil dihapus!',
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
                                    text: 'Gagal menghapus kegiatan genting. Silakan coba lagi.',
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
        });

        // Modal functions
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

        function openNarasiModal(narasi) {
            document.getElementById('modalNarasi').textContent = narasi;
            document.getElementById('narasiModal').style.display = 'flex';
        }

        function closeNarasiModal() {
            document.getElementById('narasiModal').style.display = 'none';
        }

        function openPihakKetigaModal(gentingId) {
            // In a real implementation, you might fetch this data via AJAX
            // For now, we'll just show a message
            document.getElementById('modalPihakKetiga').innerHTML = `
                <div class="pihak-ketiga-item">
                    <i class="fas fa-info-circle"></i> Detail pihak ketiga untuk kegiatan ID: ${gentingId}
                </div>
                <div class="text-sm text-gray-500 mt-2">
                    Informasi lengkap pihak ketiga akan ditampilkan di sini.
                </div>
            `;
            document.getElementById('pihakKetigaModal').style.display = 'flex';
        }

        function closePihakKetigaModal() {
            document.getElementById('pihakKetigaModal').style.display = 'none';
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>