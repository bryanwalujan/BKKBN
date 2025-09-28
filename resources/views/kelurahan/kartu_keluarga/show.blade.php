<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kartu Keluarga - Admin Kelurahan</title>
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
        
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: scale(1.005);
            transition: all 0.2s ease;
        }
        
        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }
        
        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
        }
        
        .section-header {
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #374151;
        }
        
        .btn-outline:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
        }
        
        .btn-danger {
            background-color: #dc2626;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }
        
        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .data-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .data-item:last-child {
            border-bottom: none;
        }
        
        .data-label {
            font-weight: 500;
            color: #374151;
        }
        
        .data-value {
            color: #6b7280;
            text-align: right;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
            animation: fadeIn 0.5s ease-in;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        
        .tab {
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #6b7280;
        }
        
        .tab.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }
        
        .tab:hover {
            color: #3b82f6;
            background-color: #f8fafc;
        }
        
        .photo-thumbnail {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .status-dot.active {
            background-color: #10b981;
        }
        
        .status-dot.pending {
            background-color: #f59e0b;
        }
        
        .status-dot.inactive {
            background-color: #ef4444;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .alert i {
            font-size: 1.25rem;
        }
        
        .source-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }
        
        .source-badge.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .source-badge.verified {
            background-color: #d1fae5;
            color: #065f46;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail <span class="gradient-text">Kartu Keluarga</span></h1>
                    <p class="text-gray-600">Informasi lengkap kartu keluarga dan data terkait</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-id-card mr-2"></i>
                        <span>No. KK: {{ $kartuKeluarga->no_kk }}</span>
                        <span class="source-badge {{ $kartuKeluarga->source === 'pending' ? 'pending' : 'verified' }}">
                            {{ $kartuKeluarga->source === 'pending' ? 'Pending' : 'Terverifikasi' }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @if ($kartuKeluarga->source === 'pending')
                        <a href="{{ route('kelurahan.kartu_keluarga.edit', [$kartuKeluarga->id, 'pending']) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit KK
                        </a>
                        <button type="button" class="btn btn-danger" onclick="showDeleteModal('{{ route('kelurahan.kartu_keluarga.destroy', $kartuKeluarga->id) }}', '{{ $kartuKeluarga->kepala_keluarga }}')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    @else
                        <a href="{{ route('kelurahan.kartu_keluarga.edit', [$kartuKeluarga->id, 'verified']) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit KK
                        </a>
                    @endif
                    <a href="{{ route('kelurahan.kartu_keluarga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Informasi Kartu Keluarga -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover info-card">
            <div class="section-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-address-card text-blue-500 mr-3"></i>
                            Informasi Kartu Keluarga
                        </h3>
                        <p class="text-gray-600 text-sm mt-1">Data utama kartu keluarga</p>
                    </div>
                    <div class="flex items-center">
                        <span class="badge {{ $kartuKeluarga->status == 'Aktif' ? 'badge-success' : 'badge-warning' }}">
                            <i class="fas fa-circle mr-1 text-xs"></i> {{ $kartuKeluarga->status }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="data-grid">
                <div class="data-item">
                    <span class="data-label"><i class="fas fa-id-card mr-2 text-blue-500"></i> No KK</span>
                    <span class="data-value font-mono">{{ $kartuKeluarga->no_kk }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label"><i class="fas fa-user mr-2 text-blue-500"></i> Kepala Keluarga</span>
                    <span class="data-value">{{ $kartuKeluarga->kepala_keluarga ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label"><i class="fas fa-map-marker-alt mr-2 text-blue-500"></i> Kecamatan</span>
                    <span class="data-value">{{ $kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label"><i class="fas fa-map-marker mr-2 text-blue-500"></i> Kelurahan</span>
                    <span class="data-value">{{ $kartuKeluarga->kelurahan->nama_kelurahan ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label"><i class="fas fa-home mr-2 text-blue-500"></i> Alamat</span>
                    <span class="data-value">{{ $kartuKeluarga->alamat ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label"><i class="fas fa-globe-americas mr-2 text-blue-500"></i> Koordinat</span>
                    <span class="data-value">
                        @if($kartuKeluarga->latitude && $kartuKeluarga->longitude)
                            {{ number_format($kartuKeluarga->latitude, 6) }}, {{ number_format($kartuKeluarga->longitude, 6) }}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="data-item">
                    <span class="data-label"><i class="fas fa-toggle-on mr-2 text-blue-500"></i> Status</span>
                    <span class="data-value">{{ $kartuKeluarga->status ?? '-' }}</span>
                </div>
                @if ($kartuKeluarga->source === 'pending')
                    <div class="data-item">
                        <span class="data-label"><i class="fas fa-check-circle mr-2 text-blue-500"></i> Status Verifikasi</span>
                        <span class="data-value">{{ $kartuKeluarga->status_verifikasi ?? '-' }}</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label"><i class="fas fa-user mr-2 text-blue-500"></i> Diupload Oleh</span>
                        <span class="data-value">{{ $kartuKeluarga->createdBy->name ?? 'Tidak diketahui' }}</span>
                    </div>
                @endif
            </div>
        </div>

        @if ($kartuKeluarga->source === 'verified')
            <!-- Tabs Navigation -->
            <div class="bg-white rounded-xl shadow-sm mb-6">
                <div class="tabs">
                    <div class="tab active" data-tab="ibu">Data Ibu</div>
                    <div class="tab" data-tab="balita">Data Balita</div>
                    <div class="tab" data-tab="remaja">Remaja Putri</div>
                    
                </div>
            </div>

            <!-- Data Ibu Tab -->
            <div class="tab-content active" id="ibu-tab">
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="section-header">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-female text-pink-500 mr-3"></i>
                                    Daftar Ibu
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">Data ibu dalam kartu keluarga</p>
                            </div>
                            <a href="{{ route('kelurahan.ibu.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Ibu
                            </a>
                        </div>
                    </div>
                    
                    @if ($kartuKeluarga->ibu->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-user-times"></i>
                            <p class="text-lg font-medium mb-2">Tidak ada data ibu</p>
                            <p class="text-gray-500 mb-4">Belum ada data ibu yang terdaftar dalam kartu keluarga ini.</p>
                            <a href="{{ route('kelurahan.ibu.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Data Ibu
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Nama</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">NIK</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kecamatan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Alamat</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Status</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kehamilan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Nifas</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Menyusui</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Foto</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($kartuKeluarga->ibu as $index => $ibu)
                                        <tr class="table-row-hover">
                                            <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                            <td class="p-4 font-medium text-gray-800">{{ $ibu->nama ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $ibu->nik ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $ibu->alamat ?? '-' }}</td>
                                            <td class="p-4">
                                                <span class="badge {{ $ibu->status == 'Aktif' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $ibu->status ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                @if($ibu->ibuHamil)
                                                    <span class="badge badge-info">Hamil</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                @if($ibu->ibuNifas)
                                                    <span class="badge badge-info">Nifas</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                @if($ibu->ibuMenyusui)
                                                    <span class="badge badge-info">Menyusui</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                @if ($ibu->foto)
                                                    <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="photo-thumbnail">
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('kelurahan.ibu.edit', [$ibu->id, 'verified']) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                            onclick="showDeleteModal('{{ route('kelurahan.ibu.destroy', $ibu->id) }}', '{{ $ibu->nama ?? 'Ibu' }}')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Data Balita Tab -->
            <div class="tab-content" id="balita-tab">
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="section-header">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-baby text-yellow-500 mr-3"></i>
                                    Daftar Balita
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">Data balita dalam kartu keluarga</p>
                            </div>
                            <a href="{{ route('kelurahan.balita.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Balita
                            </a>
                        </div>
                    </div>
                    
                    @if ($kartuKeluarga->balitas->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-baby-carriage"></i>
                            <p class="text-lg font-medium mb-2">Tidak ada data balita</p>
                            <p class="text-gray-500 mb-4">Belum ada data balita yang terdaftar dalam kartu keluarga ini.</p>
                            <a href="{{ route('kelurahan.balita.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Data Balita
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Nama</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">NIK</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Jenis Kelamin</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Tanggal Lahir</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Usia</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kategori Umur</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kecamatan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Berat/Tinggi</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Lingkar Kepala</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Lingkar Lengan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Alamat</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Status Gizi</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Warna Label</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Status Pemantauan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Foto</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($kartuKeluarga->balitas as $index => $balita)
                                        <tr class="table-row-hover">
                                            <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                            <td class="p-4 font-medium text-gray-800">{{ $balita->nama ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->nik ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">
                                                <span class="badge {{ $balita->jenis_kelamin == 'Laki-laki' ? 'badge-info' : 'badge-warning' }}">
                                                    {{ $balita->jenis_kelamin ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="p-4 text-sm text-gray-700">
                                                {{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td class="p-4 text-sm text-gray-700">
                                                {{ $balita->usia !== null ? $balita->usia . ' bulan' : '-' }}
                                            </td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->kategoriUmur ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->kecamatan->nama_kecamatan ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->kelurahan->nama_kelurahan ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->berat_tinggi ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->lingkar_kepala ? $balita->lingkar_kepala . ' cm' : '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->lingkar_lengan ? $balita->lingkar_lengan . ' cm' : '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->alamat ?? '-' }}</td>
                                            <td class="p-4">
                                                <span class="badge 
                                                    {{ $balita->status_gizi == 'Normal' ? 'badge-success' : 
                                                       ($balita->status_gizi == 'Gizi Buruk' ? 'badge-danger' : 'badge-warning') }}">
                                                    {{ $balita->status_gizi ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                <span class="inline-block w-3 h-3 rounded-full mr-2 
                                                    {{ $balita->warna_label == 'Hijau' ? 'bg-green-500' : 
                                                       ($balita->warna_label == 'Kuning' ? 'bg-yellow-500' : 
                                                       ($balita->warna_label == 'Merah' ? 'bg-red-500' : 'bg-blue-500')) }}"></span>
                                                {{ $balita->warna_label ?? '-' }}
                                            </td>
                                            <td class="p-4 text-sm text-gray-700">{{ $balita->status_pemantauan ?? '-' }}</td>
                                            <td class="p-4">
                                                @if ($balita->foto)
                                                    <img src="{{ Storage::url($balita->foto) }}" alt="Foto Balita" class="photo-thumbnail">
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('kelurahan.balita.edit', [$balita->id, 'verified']) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                            onclick="showDeleteModal('{{ route('kelurahan.balita.destroy', $balita->id) }}', '{{ $balita->nama ?? 'Balita' }}')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Data Remaja Putri Tab -->
            <div class="tab-content" id="remaja-tab">
                <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                    <div class="section-header">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                    <i class="fas fa-female text-purple-500 mr-3"></i>
                                    Daftar Remaja Putri
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">Data remaja putri dalam kartu keluarga</p>
                            </div>
                            <a href="{{ route('kelurahan.remaja_putri.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Remaja Putri
                            </a>
                        </div>
                    </div>
                    
                    @if ($kartuKeluarga->remajaPutris->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-user-friends"></i>
                            <p class="text-lg font-medium mb-2">Tidak ada data remaja putri</p>
                            <p class="text-gray-500 mb-4">Belum ada data remaja putri yang terdaftar dalam kartu keluarga ini.</p>
                            <a href="{{ route('kelurahan.remaja_putri.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Data Remaja Putri
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Nama</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Sekolah</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kelas</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Umur</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kecamatan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Status Anemia</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Konsumsi TTD</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Foto</th>
                                        <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($kartuKeluarga->remajaPutris as $index => $remaja)
                                        <tr class="table-row-hover">
                                            <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                            <td class="p-4 font-medium text-gray-800">{{ $remaja->nama ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $remaja->sekolah ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $remaja->kelas ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $remaja->umur ? $remaja->umur . ' tahun' : '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $remaja->kecamatan->nama_kecamatan ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $remaja->kelurahan->nama_kelurahan ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $remaja->status_anemia ?? '-' }}</td>
                                            <td class="p-4 text-sm text-gray-700">{{ $remaja->konsumsi_ttd ?? '-' }}</td>
                                            <td class="p-4">
                                                @if ($remaja->foto)
                                                    <img src="{{ Storage::url($remaja->foto) }}" alt="Foto Remaja Putri" class="photo-thumbnail">
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="p-4">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('kelurahan.remaja_putri.edit', [$remaja->id, 'verified']) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                            onclick="showDeleteModal('{{ route('kelurahan.remaja_putri.destroy', $remaja->id) }}', '{{ $remaja->nama ?? 'Remaja Putri' }}')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
        // Tab functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
                
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId + '-tab').classList.add('active');
            });
        });

        // Delete modal functionality with SweetAlert2
        function showDeleteModal(url, name) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                html: `Apakah Anda yakin ingin menghapus data <span class="font-bold text-red-600">${name}</span>? Tindakan ini tidak dapat dibatalkan.`,
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
        }

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.tab[data-tab="ibu"]').classList.add('active');
            document.getElementById('ibu-tab').classList.add('active');
        });
    </script>
</body>
</html>