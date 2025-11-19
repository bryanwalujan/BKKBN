<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kartu Keluarga - Master Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .status-active {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .status-inactive {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        .bg-gradient-sidebar {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        .section-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 500;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 4px;
        }
        .info-value {
            color: #111827;
            font-weight: 500;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
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
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
        }
        .table-header {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
        }
        .table-row {
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s;
        }
        .table-row:hover {
            background-color: #f9fafb;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .action-btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        .action-btn-primary:hover {
            background-color: #2563eb;
        }
        .action-btn-danger {
            background-color: #ef4444;
            color: white;
        }
        .action-btn-danger:hover {
            background-color: #dc2626;
        }
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            color: #9ca3af;
        }
        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 16px;
        }
        .section-header {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 8px;
        }
        .section-content {
            padding: 24px;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('master.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-address-card text-blue-600 mr-3"></i>
                            Detail Kartu Keluarga
                        </h1>
                        <p class="text-gray-600 mt-1">Informasi lengkap kartu keluarga dan data terkait</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('kartu_keluarga.index') }}" class="action-btn bg-gray-500 text-white hover:bg-gray-600">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Informasi Kartu Keluarga -->
            <div class="section-card mb-8">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        Informasi Kartu Keluarga
                    </h2>
                    <a href="{{ route('kartu_keluarga.edit', $kartuKeluarga->id) }}" class="action-btn action-btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-id-card mr-1 text-blue-500"></i>
                                No. Kartu Keluarga
                            </span>
                            <span class="info-value">{{ $kartuKeluarga->no_kk }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-user mr-1 text-green-500"></i>
                                Kepala Keluarga
                            </span>
                            <span class="info-value">{{ $kartuKeluarga->kepala_keluarga }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-map-marker-alt mr-1 text-red-500"></i>
                                Kecamatan
                            </span>
                            <span class="info-value">{{ $kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-map-pin mr-1 text-purple-500"></i>
                                Kelurahan
                            </span>
                            <span class="info-value">{{ $kartuKeluarga->kelurahan->nama_kelurahan ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-home mr-1 text-yellow-500"></i>
                                Alamat
                            </span>
                            <span class="info-value">{{ $kartuKeluarga->alamat ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-globe-americas mr-1 text-indigo-500"></i>
                                Koordinat
                            </span>
                            <span class="info-value">
                                {{ $kartuKeluarga->latitude ?? '-' }}, {{ $kartuKeluarga->longitude ?? '-' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-check-circle mr-1 text-emerald-500"></i>
                                Status
                            </span>
                            <span class="info-value">
                                <span class="badge {{ $kartuKeluarga->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                    <i class="fas fa-circle mr-1 text-xs"></i>
                                    {{ $kartuKeluarga->status }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">
                                <i class="fas fa-user-plus mr-1 text-cyan-500"></i>
                                Pengunggah
                            </span>
                            <span class="info-value">{{ $kartuKeluarga->createdBy->name ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pendamping Keluarga -->
            <div class="section-card mb-8">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-hands-helping text-green-500"></i>
                        Detail Pendamping Keluarga
                    </h2>
                    <a href="{{ route('pendamping_keluarga.create') }}" class="action-btn action-btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Pendamping
                    </a>
                </div>
                <div class="section-content">
                    @if ($kartuKeluarga->pendampingKeluargas->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-hands-helping empty-state-icon"></i>
                            <p class="text-lg font-medium">Tidak ada data pendamping keluarga</p>
                            <p class="text-sm mt-1">Tambahkan data pendamping keluarga untuk melengkapi informasi</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($kartuKeluarga->pendampingKeluargas as $index => $pendamping)
                                <div class="bg-gray-50 rounded-lg p-6 card-hover">
                                    <div class="flex justify-between items-start mb-4">
                                        <h4 class="text-lg font-semibold text-gray-800">
                                            <i class="fas fa-user-tie mr-2 text-blue-500"></i>
                                            Pendamping {{ $index + 1 }}: {{ $pendamping->nama }}
                                        </h4>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('pendamping_keluarga.edit', $pendamping->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('pendamping_keluarga.destroy', $pendamping->id) }}" method="POST" class="delete-form inline" data-name="{{ $pendamping->nama }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <span class="info-label">Nama</span>
                                            <span class="info-value">{{ $pendamping->nama }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Peran</span>
                                            <span class="info-value">{{ $pendamping->peran }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Kecamatan</span>
                                            <span class="info-value">{{ $pendamping->kecamatan->nama_kecamatan ?? '-' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Kelurahan</span>
                                            <span class="info-value">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Status</span>
                                            <span class="info-value">
                                                <span class="badge {{ $pendamping->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $pendamping->status }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Tahun Bergabung</span>
                                            <span class="info-value">{{ $pendamping->tahun_bergabung }}</span>
                                        </div>
                                        @if($pendamping->foto)
                                        <div class="info-item">
                                            <span class="info-label">Foto</span>
                                            <div class="info-value">
                                                <img src="{{ Storage::url($pendamping->foto) }}" alt="Foto Pendamping" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Aktivitas Pendamping -->
                                    <div class="mt-6 pt-4 border-t border-gray-200">
                                        <h5 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                            <i class="fas fa-tasks mr-2 text-purple-500"></i>
                                            Aktivitas Pendamping
                                        </h5>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @if($pendamping->penyuluhan)
                                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    <i class="fas fa-chalkboard-teacher text-green-500 mr-2"></i>
                                                    <span class="font-medium text-sm">Penyuluhan & Edukasi</span>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">Frekuensi: {{ $pendamping->penyuluhan_frekuensi ?? '-' }}</p>
                                            </div>
                                            @endif
                                            
                                            @if($pendamping->rujukan)
                                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    <i class="fas fa-ambulance text-red-500 mr-2"></i>
                                                    <span class="font-medium text-sm">Fasilitasi Rujukan</span>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">Frekuensi: {{ $pendamping->rujukan_frekuensi ?? '-' }}</p>
                                            </div>
                                            @endif
                                            
                                            @if($pendamping->kunjungan_krs)
                                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    <i class="fas fa-home text-blue-500 mr-2"></i>
                                                    <span class="font-medium text-sm">Kunjungan KRS</span>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">Frekuensi: {{ $pendamping->kunjungan_krs_frekuensi ?? '-' }}</p>
                                            </div>
                                            @endif
                                            
                                            @if($pendamping->pendataan_bansos)
                                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    <i class="fas fa-clipboard-list text-yellow-500 mr-2"></i>
                                                    <span class="font-medium text-sm">Pendataan Bansos</span>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">Frekuensi: {{ $pendamping->pendataan_bansos_frekuensi ?? '-' }}</p>
                                            </div>
                                            @endif
                                            
                                            @if($pendamping->pemantauan_kesehatan)
                                            <div class="bg-white p-3 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    <i class="fas fa-heartbeat text-pink-500 mr-2"></i>
                                                    <span class="font-medium text-sm">Pemantauan Kesehatan</span>
                                                </div>
                                                <p class="text-xs text-gray-600 mt-1">Frekuensi: {{ $pendamping->pemantauan_kesehatan_frekuensi ?? '-' }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Daftar Ibu -->
            <div class="section-card mb-8">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-female text-pink-500"></i>
                        Daftar Ibu
                    </h2>
                    <a href="{{ route('ibu.create') }}" class="action-btn action-btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Ibu
                    </a>
                </div>
                <div class="section-content">
                    @if ($kartuKeluarga->ibu->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-female empty-state-icon"></i>
                            <p class="text-lg font-medium">Tidak ada data ibu</p>
                            <p class="text-sm mt-1">Tambahkan data ibu untuk melengkapi informasi</p>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="w-full">
                                <thead class="table-header">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($kartuKeluarga->ibu as $index => $ibu)
                                        <tr class="table-row">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-female text-pink-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $ibu->nama }}</div>
                                                        <div class="text-sm text-gray-500">{{ $ibu->alamat ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $ibu->nik ?? '-' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $ibu->kecamatan->nama_kecamatan ?? '-' }}, {{ $ibu->kelurahan->nama_kelurahan ?? '-' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="badge {{ $ibu->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $ibu->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex flex-wrap gap-1">
                                                    @if($ibu->ibuHamil)
                                                        <span class="badge badge-warning">Hamil</span>
                                                    @endif
                                                    @if($ibu->ibuNifas)
                                                        <span class="badge badge-info">Nifas</span>
                                                    @endif
                                                    @if($ibu->ibuMenyusui)
                                                        <span class="badge badge-success">Menyusui</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if ($ibu->foto)
                                                    <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="w-12 h-12 object-cover rounded-lg">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-camera text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('ibu.edit', $ibu->id) }}" 
                                                       class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('ibu.destroy', $ibu->id) }}" method="POST" class="delete-form inline" data-name="{{ $ibu->nama }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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

            <!-- Daftar Balita -->
            <div class="section-card mb-8">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-baby text-green-500"></i>
                        Daftar Balita
                    </h2>
                    <a href="{{ route('balita.create') }}" class="action-btn action-btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Balita
                    </a>
                </div>
                <div class="section-content">
                    @if ($kartuKeluarga->balitas->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-baby empty-state-icon"></i>
                            <p class="text-lg font-medium">Tidak ada data balita</p>
                            <p class="text-sm mt-1">Tambahkan data balita untuk melengkapi informasi</p>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="w-full">
                                <thead class="table-header">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usia</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Gizi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Label</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($kartuKeluarga->balitas as $index => $balita)
                                        <tr class="table-row">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-baby text-green-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $balita->nama }}</div>
                                                        <div class="text-sm text-gray-500">{{ $balita->nik ?? '-' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    @if($balita->jenis_kelamin == 'Laki-laki')
                                                        <i class="fas fa-mars text-blue-500 mr-1"></i>
                                                    @else
                                                        <i class="fas fa-venus text-pink-500 mr-1"></i>
                                                    @endif
                                                    {{ $balita->jenis_kelamin }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <div>
                                                    <div>{{ $balita->usia !== null ? $balita->usia . ' bulan' : '-' }}</div>
                                                    <div class="text-xs text-gray-500">{{ $balita->kategoriUmur }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="badge 
                                                    {{ $balita->status_gizi === 'Gizi Baik' ? 'badge-success' : 
                                                       ($balita->status_gizi === 'Gizi Kurang' ? 'badge-warning' : 
                                                       ($balita->status_gizi === 'Gizi Buruk' ? 'badge-danger' : 'badge-info')) }}">
                                                    {{ $balita->status_gizi }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $balita->warna_label === 'Hijau' ? 'bg-green-100 text-green-800' : 
                                                       ($balita->warna_label === 'Kuning' ? 'bg-yellow-100 text-yellow-800' : 
                                                       ($balita->warna_label === 'Merah' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                                    {{ $balita->warna_label }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if ($balita->foto)
                                                    <img src="{{ Storage::url($balita->foto) }}" alt="Foto Balita" class="w-12 h-12 object-cover rounded-lg">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-camera text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('balita.edit', $balita->id) }}" 
                                                       class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('balita.destroy', $balita->id) }}" method="POST" class="delete-form inline" data-name="{{ $balita->nama }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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

            <!-- Daftar Aksi Konvergensi -->
            <div class="section-card mb-8">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-handshake text-purple-500"></i>
                        Daftar Aksi Konvergensi
                    </h2>
                    <a href="{{ route('aksi_konvergensi.create') }}" class="action-btn action-btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Aksi
                    </a>
                </div>
                <div class="section-content">
                    @if ($kartuKeluarga->aksiKonvergensis->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-handshake empty-state-icon"></i>
                            <p class="text-lg font-medium">Tidak ada data aksi konvergensi</p>
                            <p class="text-sm mt-1">Tambahkan data aksi konvergensi untuk melengkapi informasi</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach ($kartuKeluarga->aksiKonvergensis as $index => $aksi)
                                <div class="bg-gray-50 rounded-lg p-6 card-hover">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                                                <i class="fas fa-tasks mr-2 text-purple-500"></i>
                                                {{ $aksi->nama_aksi }}
                                            </h4>
                                            <div class="flex items-center mt-1 space-x-4">
                                                <span class="text-sm text-gray-600">
                                                    <i class="far fa-calendar mr-1"></i>
                                                    Tahun: {{ $aksi->tahun }}
                                                </span>
                                                <span class="text-sm text-gray-600">
                                                    <i class="far fa-clock mr-1"></i>
                                                    Waktu: {{ $aksi->waktu_pelaksanaan ? $aksi->waktu_pelaksanaan->format('d/m/Y H:i') : '-' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="badge {{ $aksi->selesai ? 'badge-success' : 'badge-warning' }}">
                                                <i class="fas fa-{{ $aksi->selesai ? 'check' : 'clock' }} mr-1"></i>
                                                {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                                            </span>
                                            <a href="{{ route('aksi_konvergensi.edit', $aksi->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('aksi_konvergensi.destroy', $aksi->id) }}" method="POST" class="delete-form inline" data-name="{{ $aksi->nama_aksi }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Intervensi Sensitif -->
                                        <div>
                                            <h5 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                                <i class="fas fa-heart text-red-500 mr-2"></i>
                                                Intervensi Sensitif
                                            </h5>
                                            <ul class="space-y-2 text-sm">
                                                @if($aksi->air_bersih_sanitasi)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Air Bersih & Sanitasi: {{ $aksi->air_bersih_sanitasi }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->akses_layanan_kesehatan_kb)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Akses Layanan Kesehatan & KB: {{ $aksi->akses_layanan_kesehatan_kb }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->pendidikan_pengasuhan_ortu)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Pendidikan Pengasuhan: {{ $aksi->pendidikan_pengasuhan_ortu }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->edukasi_kesehatan_remaja)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Edukasi Kesehatan Remaja: {{ $aksi->edukasi_kesehatan_remaja }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->kesadaran_pengasuhan_gizi)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Kesadaran Pengasuhan & Gizi: {{ $aksi->kesadaran_pengasuhan_gizi }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->akses_pangan_bergizi)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Akses Pangan Bergizi: {{ $aksi->akses_pangan_bergizi }}</span>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        
                                        <!-- Intervensi Spesifik -->
                                        <div>
                                            <h5 class="text-md font-medium text-gray-700 mb-3 flex items-center">
                                                <i class="fas fa-stethoscope text-blue-500 mr-2"></i>
                                                Intervensi Spesifik
                                            </h5>
                                            <ul class="space-y-2 text-sm">
                                                @if($aksi->makanan_ibu_hamil)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Makanan Ibu Hamil: {{ $aksi->makanan_ibu_hamil }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->tablet_tambah_darah)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Tablet Tambah Darah: {{ $aksi->tablet_tambah_darah }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->inisiasi_menyusui_dini)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Inisiasi Menyusui Dini: {{ $aksi->inisiasi_menyusui_dini }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->asi_eksklusif)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>ASI Eksklusif: {{ $aksi->asi_eksklusif }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->asi_mpasi)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>ASI & MPASI: {{ $aksi->asi_mpasi }}</span>
                                                </li>
                                                @endif
                                                @if($aksi->imunisasi_lengkap)
                                                <li class="flex items-start">
                                                    <i class="fas fa-check text-green-500 mt-0.5 mr-2"></i>
                                                    <span>Imunisasi Lengkap: {{ $aksi->imunisasi_lengkap }}</span>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    @if($aksi->narasi)
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <h5 class="text-md font-medium text-gray-700 mb-2 flex items-center">
                                            <i class="fas fa-file-alt text-gray-500 mr-2"></i>
                                            Narasi
                                        </h5>
                                        <p class="text-sm text-gray-600">{{ $aksi->narasi }}</p>
                                    </div>
                                    @endif
                                    
                                    @if($aksi->foto)
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <h5 class="text-md font-medium text-gray-700 mb-2 flex items-center">
                                            <i class="fas fa-camera text-gray-500 mr-2"></i>
                                            Dokumentasi
                                        </h5>
                                        <img src="{{ Storage::url($aksi->foto) }}" alt="Foto Aksi Konvergensi" class="w-32 h-32 object-cover rounded-lg shadow-sm">
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Daftar Kegiatan Genting -->
            <div class="section-card mb-8">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                        Daftar Kegiatan Genting
                    </h2>
                    <a href="{{ route('genting.create') }}" class="action-btn action-btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Kegiatan
                    </a>
                </div>
                <div class="section-content">
                    @if ($kartuKeluarga->gentings->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle empty-state-icon"></i>
                            <p class="text-lg font-medium">Tidak ada data kegiatan genting</p>
                            <p class="text-sm mt-1">Tambahkan data kegiatan genting untuk melengkapi informasi</p>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="w-full">
                                <thead class="table-header">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sasaran</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intervensi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumentasi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($kartuKeluarga->gentings as $index => $genting)
                                        <tr class="table-row">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $genting->nama_kegiatan }}</div>
                                                @if($genting->narasi)
                                                <div class="text-xs text-gray-500 mt-1">{{ Str::limit($genting->narasi, 50) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($genting->tanggal)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $genting->lokasi }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $genting->sasaran }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $genting->jenis_intervensi }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if ($genting->dokumentasi)
                                                    <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi Kegiatan" class="w-12 h-12 object-cover rounded-lg">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-camera text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('genting.edit', $genting->id) }}" 
                                                       class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('genting.destroy', $genting->id) }}" method="POST" class="delete-form inline" data-name="{{ $genting->nama_kegiatan }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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

            <!-- Riwayat Monitoring -->
            <div class="section-card mb-8">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-chart-line text-indigo-500"></i>
                        Riwayat Monitoring
                    </h2>
                    <a href="{{ route('data_monitoring.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="action-btn action-btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Monitoring
                    </a>
                </div>
                <div class="section-content">
                    @if ($kartuKeluarga->dataMonitorings->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-chart-line empty-state-icon"></i>
                            <p class="text-lg font-medium">Tidak ada data monitoring</p>
                            <p class="text-sm mt-1">Tambahkan data monitoring untuk melengkapi informasi</p>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="w-full">
                                <thead class="table-header">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Gizi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Badge</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intervensi</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($kartuKeluarga->dataMonitorings as $index => $monitoring)
                                        <tr class="table-row">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $index + 1 }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $monitoring->tanggal_monitoring ? \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $monitoring->target == 'Ibu' ? ($monitoring->ibu->nama ?? '-') : ($monitoring->balita->nama ?? '-') }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $monitoring->target ?? '-' }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">{{ $monitoring->kategori ?? '-' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="badge 
                                                    {{ $monitoring->status_gizi === 'Gizi Baik' ? 'badge-success' : 
                                                       ($monitoring->status_gizi === 'Gizi Kurang' ? 'badge-warning' : 
                                                       ($monitoring->status_gizi === 'Gizi Buruk' ? 'badge-danger' : 'badge-info')) }}">
                                                    {{ $monitoring->status_gizi ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $monitoring->warna_badge == 'Hijau' ? 'bg-green-100 text-green-800' : 
                                                       ($monitoring->warna_badge == 'Kuning' ? 'bg-yellow-100 text-yellow-800' : 
                                                       ($monitoring->warna_badge == 'Merah' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                                    {{ $monitoring->warna_badge ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex flex-wrap gap-1">
                                                    @if($monitoring->kunjungan_rumah)
                                                        <span class="badge badge-success text-xs">Kunjungan</span>
                                                    @endif
                                                    @if($monitoring->pemberian_pmt)
                                                        <span class="badge badge-warning text-xs">PMT</span>
                                                    @endif
                                                    @if($monitoring->suplemen_ttd)
                                                        <span class="badge badge-info text-xs">TTD</span>
                                                    @endif
                                                    @if($monitoring->rujukan)
                                                        <span class="badge badge-danger text-xs">Rujukan</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('data_monitoring.edit', $monitoring->id) }}" 
                                                       class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('data_monitoring.destroy', $monitoring->id) }}" method="POST" class="delete-form inline" data-name="Data Monitoring">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delete confirmation dengan SweetAlert2 yang lebih modern
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const name = form.data('name');
                
                Swal.fire({
                    title: 'Hapus Data?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Data: <strong>${name}</strong></p>
                             <p class="text-sm text-red-600 mt-2">Tindakan ini tidak dapat dibatalkan!</p>
                           </div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'px-4 py-2 rounded-lg',
                        cancelButton: 'px-4 py-2 rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Dihapus!',
                                    text: 'Data berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data.';
                                if (xhr.status === 419) {
                                    message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                } else if (xhr.status === 403) {
                                    message = 'Anda tidak memiliki izin untuk menghapus data ini.';
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: message,
                                    confirmButtonColor: '#3b82f6',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>