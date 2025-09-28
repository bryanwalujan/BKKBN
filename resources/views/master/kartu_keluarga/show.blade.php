<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kartu Keluarga - CSSR</title>
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
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
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
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('kartu_keluarga.edit', $kartuKeluarga->id) }}" class="btn btn-outline">
                        <i class="fas fa-edit"></i> Edit KK
                    </a>
                    <a href="{{ route('kartu_keluarga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

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
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-xl shadow-sm mb-6">
            <div class="tabs">
                <div class="tab active" data-tab="ibu">Data Ibu</div>
                <div class="tab" data-tab="balita">Data Balita</div>
                <div class="tab" data-tab="remaja">Remaja Putri</div>
                <div class="tab" data-tab="aksi">Aksi Konvergensi</div>
                <div class="tab" data-tab="genting">Kegiatan Genting</div>
                <div class="tab" data-tab="monitoring">Monitoring</div>
                <div class="tab" data-tab="pendamping">Pendamping Keluarga</div>
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
                        <a href="{{ route('ibu.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Ibu
                        </a>
                    </div>
                </div>
                
                @if ($kartuKeluarga->ibu->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-user-times"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data ibu</p>
                        <p class="text-gray-500 mb-4">Belum ada data ibu yang terdaftar dalam kartu keluarga ini.</p>
                        <a href="{{ route('ibu.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
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
                                                <a href="{{ route('ibu.edit', $ibu->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                        onclick="showDeleteModal('{{ route('ibu.destroy', $ibu->id) }}', '{{ $ibu->nama ?? 'Ibu' }}')" title="Hapus">
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
                        <a href="{{ route('balita.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Balita
                        </a>
                    </div>
                </div>
                
                @if ($kartuKeluarga->balitas->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-baby-carriage"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data balita</p>
                        <p class="text-gray-500 mb-4">Belum ada data balita yang terdaftar dalam kartu keluarga ini.</p>
                        <a href="{{ route('balita.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
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
                                                <a href="{{ route('balita.edit', $balita->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                        onclick="showDeleteModal('{{ route('balita.destroy', $balita->id) }}', '{{ $balita->nama ?? 'Balita' }}')" title="Hapus">
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
                        <a href="{{ route('remaja_putri.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Remaja Putri
                        </a>
                    </div>
                </div>
                
                @if ($kartuKeluarga->remajaPutris->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-user-friends"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data remaja putri</p>
                        <p class="text-gray-500 mb-4">Belum ada data remaja putri yang terdaftar dalam kartu keluarga ini.</p>
                        <a href="{{ route('remaja_putri.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
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
                                                <a href="{{ route('remaja_putri.edit', $remaja->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                        onclick="showDeleteModal('{{ route('remaja_putri.destroy', $remaja->id) }}', '{{ $remaja->nama ?? 'Remaja Putri' }}')" title="Hapus">
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

        <!-- Aksi Konvergensi Tab -->
        <div class="tab-content" id="aksi-tab">
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="section-header">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-project-diagram text-teal-500 mr-3"></i>
                                Daftar Aksi Konvergensi
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Data aksi konvergensi terkait kartu keluarga</p>
                        </div>
                        <a href="{{ route('aksi_konvergensi.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Aksi Konvergensi
                        </a>
                    </div>
                </div>
                
                @if ($kartuKeluarga->aksiKonvergensis->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-project-diagram"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data aksi konvergensi</p>
                        <p class="text-gray-500 mb-4">Belum ada data aksi konvergensi yang terdaftar dalam kartu keluarga ini.</p>
                        <a href="{{ route('aksi_konvergensi.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Aksi Konvergensi
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Nama Aksi</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Selesai</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Tahun</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Intervensi Sensitif</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Intervensi Spesifik</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Narasi</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Pelaku</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Waktu</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Foto</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($kartuKeluarga->aksiKonvergensis as $index => $aksi)
                                    <tr class="table-row-hover">
                                        <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                        <td class="p-4 font-medium text-gray-800">{{ $aksi->nama_aksi ?? '-' }}</td>
                                        <td class="p-4">
                                            <span class="badge {{ $aksi->selesai ? 'badge-success' : 'badge-danger' }}">
                                                {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-sm text-gray-700">{{ $aksi->tahun ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">
                                            <ul class="list-disc pl-4">
                                                <li>Ketersediaan Air Bersih dan Sanitasi: {{ $aksi->air_bersih_sanitasi ?? '-' }}</li>
                                                <li>Akses Layanan Kesehatan dan KB: {{ $aksi->akses_layanan_kesehatan_kb ?? '-' }}</li>
                                                <li>Pendidikan Pengasuhan: {{ $aksi->pendidikan_pengasuhan_ortu ?? '-' }}</li>
                                                <li>Edukasi Kesehatan Remaja: {{ $aksi->edukasi_kesehatan_remaja ?? '-' }}</li>
                                                <li>Kesadaran Pengasuhan dan Gizi: {{ $aksi->kesadaran_pengasuhan_gizi ?? '-' }}</li>
                                                <li>Akses Pangan Bergizi: {{ $aksi->akses_pangan_bergizi ?? '-' }}</li>
                                            </ul>
                                        </td>
                                        <td class="p-4 text-sm text-gray-700">
                                            <ul class="list-disc pl-4">
                                                <li>Makanan Ibu Hamil: {{ $aksi->makanan_ibu_hamil ?? '-' }}</li>
                                                <li>Tablet Tambah Darah: {{ $aksi->tablet_tambah_darah ?? '-' }}</li>
                                                <li>Inisiasi Menyusui Dini: {{ $aksi->inisiasi_menyusui_dini ?? '-' }}</li>
                                                <li>ASI Eksklusif: {{ $aksi->asi_eksklusif ?? '-' }}</li>
                                                <li>ASI dan MPASI: {{ $aksi->asi_mpasi ?? '-' }}</li>
                                                <li>Imunisasi Lengkap: {{ $aksi->imunisasi_lengkap ?? '-' }}</li>
                                                <li>Pencegahan Infeksi: {{ $aksi->pencegahan_infeksi ?? '-' }}</li>
                                                <li>Status Gizi Ibu: {{ $aksi->status_gizi_ibu ?? '-' }}</li>
                                                <li>Penyakit Menular: {{ $aksi->penyakit_menular == 'ada' ? 'Ada ('.($aksi->jenis_penyakit ?? '-').')' : ($aksi->penyakit_menular ?? '-') }}</li>
                                                <li>Kesehatan Lingkungan: {{ $aksi->kesehatan_lingkungan ?? '-' }}</li>
                                            </ul>
                                        </td>
                                        <td class="p-4 text-sm text-gray-700">{{ $aksi->narasi ? \Illuminate\Support\Str::limit($aksi->narasi, 50) : '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $aksi->pelaku_aksi ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">
                                            {{ $aksi->waktu_pelaksanaan ? \Carbon\Carbon::parse($aksi->waktu_pelaksanaan)->format('d-m-Y H:i') : '-' }}
                                        </td>
                                        <td class="p-4">
                                            @if ($aksi->foto)
                                                <img src="{{ Storage::url($aksi->foto) }}" alt="Foto Aksi Konvergensi" class="photo-thumbnail">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('aksi_konvergensi.edit', $aksi->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                        onclick="showDeleteModal('{{ route('aksi_konvergensi.destroy', $aksi->id) }}', '{{ $aksi->nama_aksi ?? 'Aksi Konvergensi' }}')" title="Hapus">
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

        <!-- Kegiatan Genting Tab -->
        <div class="tab-content" id="genting-tab">
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="section-header">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                Daftar Kegiatan Genting
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Data kegiatan genting terkait kartu keluarga</p>
                        </div>
                        <a href="{{ route('genting.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kegiatan Genting
                        </a>
                    </div>
                </div>
                
                @if ($kartuKeluarga->gentings->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data kegiatan genting</p>
                        <p class="text-gray-500 mb-4">Belum ada data kegiatan genting yang terdaftar dalam kartu keluarga ini.</p>
                        <a href="{{ route('genting.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kegiatan Genting
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Nama Kegiatan</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Tanggal</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Lokasi</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Sasaran</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Jenis Intervensi</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Narasi</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Pihak Ketiga</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Dokumentasi</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($kartuKeluarga->gentings as $index => $genting)
                                    <tr class="table-row-hover">
                                        <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                        <td class="p-4 font-medium text-gray-800">{{ $genting->nama_kegiatan ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">
                                            {{ $genting->tanggal ? \Carbon\Carbon::parse($genting->tanggal)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="p-4 text-sm text-gray-700">{{ $genting->lokasi ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $genting->sasaran ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $genting->jenis_intervensi ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $genting->narasi ? \Illuminate\Support\Str::limit($genting->narasi, 50) : '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">
                                            <ul class="list-disc pl-4">
                                                @if ($genting->dunia_usaha == 'ada')
                                                    <li>Dunia Usaha: {{ $genting->dunia_usaha_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->pemerintah == 'ada')
                                                    <li>Pemerintah: {{ $genting->pemerintah_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->bumn_bumd == 'ada')
                                                    <li>BUMN dan BUMD: {{ $genting->bumn_bumd_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->individu_perseorangan == 'ada')
                                                    <li>Individu dan Perseorangan: {{ $genting->individu_perseorangan_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->lsm_komunitas == 'ada')
                                                    <li>LSM dan Komunitas: {{ $genting->lsm_komunitas_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->swasta == 'ada')
                                                    <li>Swasta: {{ $genting->swasta_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->perguruan_tinggi_akademisi == 'ada')
                                                    <li>Perguruan Tinggi dan Akademisi: {{ $genting->perguruan_tinggi_akademisi_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->media == 'ada')
                                                    <li>Media: {{ $genting->media_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->tim_pendamping_keluarga == 'ada')
                                                    <li>Tim Pendamping Keluarga: {{ $genting->tim_pendamping_keluarga_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if ($genting->tokoh_masyarakat == 'ada')
                                                    <li>Tokoh Masyarakat: {{ $genting->tokoh_masyarakat_frekuensi ?? '-' }}</li>
                                                @endif
                                                @if (!$genting->dunia_usaha && !$genting->pemerintah && !$genting->bumn_bumd && !$genting->individu_perseorangan && !$genting->lsm_komunitas && !$genting->swasta && !$genting->perguruan_tinggi_akademisi && !$genting->media && !$genting->tim_pendamping_keluarga && !$genting->tokoh_masyarakat)
                                                    <li>Tidak ada pihak ketiga</li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td class="p-4">
                                            @if ($genting->dokumentasi)
                                                <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi Kegiatan" class="photo-thumbnail">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('genting.edit', $genting->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                        onclick="showDeleteModal('{{ route('genting.destroy', $genting->id) }}', '{{ $genting->nama_kegiatan ?? 'Kegiatan Genting' }}')" title="Hapus">
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

        <!-- Monitoring Tab -->
        <div class="tab-content" id="monitoring-tab">
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="section-header">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-chart-line text-indigo-500 mr-3"></i>
                                Riwayat Monitoring
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Data monitoring terkait kartu keluarga</p>
                        </div>
                        <a href="{{ route('data_monitoring.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Data Monitoring
                        </a>
                    </div>
                </div>
                
                @if (empty($kartuKeluarga->dataMonitorings) || $kartuKeluarga->dataMonitorings->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-chart-bar"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data monitoring</p>
                        <p class="text-gray-500 mb-4">Belum ada data monitoring yang terdaftar dalam kartu keluarga ini.</p>
                        <a href="{{ route('data_monitoring.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Data Monitoring
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Nama</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Target</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Kategori</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Perkembangan Anak</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Kunjungan Rumah</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Pemberian PMT</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Hasil Audit Stunting</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Status</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Warna Badge</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Tanggal Monitoring</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Status Aktif</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Tanggal Update</th>
                                    <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($kartuKeluarga->dataMonitorings as $index => $monitoring)
                                    <tr class="table-row-hover">
                                        <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                        <td class="p-4 font-medium text-gray-800">{{ $monitoring->nama ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->target ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->kategori ?? '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->perkembangan_anak ? \Illuminate\Support\Str::limit($monitoring->perkembangan_anak, 50) : '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->kunjungan_rumah ? 'Ada (' . ($monitoring->frekuensi_kunjungan ?? '-') . ')' : 'Tidak Ada' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->pemberian_pmt ? 'Ada (' . ($monitoring->frekuensi_pmt ?? '-') . ')' : 'Tidak Ada' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->hasil_audit_stunting ? \Illuminate\Support\Str::limit($monitoring->hasil_audit_stunting, 50) : '-' }}</td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->status ?? '-' }}</td>
                                        <td class="p-4">
                                            <span class="badge {{ $monitoring->warna_badge == 'Hijau' ? 'badge-success' : ($monitoring->warna_badge == 'Kuning' ? 'badge-warning' : ($monitoring->warna_badge == 'Merah' ? 'badge-danger' : 'badge-info')) }}">
                                                {{ $monitoring->warna_badge ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-sm text-gray-700">
                                            @if ($monitoring->tanggal_monitoring)
                                                {{ is_string($monitoring->tanggal_monitoring) ? \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d-m-Y') : $monitoring->tanggal_monitoring->format('d-m-Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-4 text-sm text-gray-700">{{ $monitoring->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                                        <td class="p-4 text-sm text-gray-700">
                                            @if ($monitoring->tanggal_update)
                                                {{ is_string($monitoring->tanggal_update) ? \Carbon\Carbon::parse($monitoring->tanggal_update)->format('d-m-Y H:i') : $monitoring->tanggal_update->format('d-m-Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('data_monitoring.edit', $monitoring->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50" 
                                                        onclick="showDeleteModal('{{ route('data_monitoring.destroy', $monitoring->id) }}', '{{ $monitoring->nama ?? 'Monitoring' }}')" title="Hapus">
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

        <!-- Pendamping Keluarga Tab -->
        <div class="tab-content" id="pendamping-tab">
            <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
                <div class="section-header">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-users text-green-500 mr-3"></i>
                                Detail Pendamping Keluarga
                            </h3>
                            <p class="text-gray-600 text-sm mt-1">Data pendamping yang mendampingi keluarga</p>
                        </div>
                        <a href="{{ route('pendamping_keluarga.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Pendamping
                        </a>
                    </div>
                </div>
                
                @if ($kartuKeluarga->pendampingKeluargas->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <p class="text-lg font-medium mb-2">Tidak ada data pendamping keluarga</p>
                        <p class="text-gray-500 mb-4">Belum ada pendamping yang terdaftar untuk kartu keluarga ini.</p>
                        <a href="{{ route('pendamping_keluarga.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Pendamping Pertama
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach ($kartuKeluarga->pendampingKeluargas as $index => $pendamping)
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-user-tie text-green-500 mr-2"></i>
                                        Pendamping {{ $index + 1 }}: {{ $pendamping->nama ?? '-' }}
                                    </h4>
                                    <span class="badge {{ $pendamping->status == 'Aktif' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $pendamping->status ?? '-' }}
                                    </span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-3">
                                        <div class="data-item">
                                            <span class="data-label">Nama</span>
                                            <span class="data-value">{{ $pendamping->nama ?? '-' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Peran</span>
                                            <span class="data-value">{{ $pendamping->peran ?? '-' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Kecamatan</span>
                                            <span class="data-value">{{ $pendamping->kecamatan->nama_kecamatan ?? '-' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Kelurahan</span>
                                            <span class="data-value">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Tahun Bergabung</span>
                                            <span class="data-value">{{ $pendamping->tahun_bergabung ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        <div class="data-item">
                                            <span class="data-label">Penyuluhan dan Edukasi</span>
                                            <span class="data-value">{{ $pendamping->penyuluhan ? ($pendamping->penyuluhan_frekuensi ?? 'Ada') : 'Tidak' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Memfasilitasi Pelayanan Rujukan</span>
                                            <span class="data-value">{{ $pendamping->rujukan ? ($pendamping->rujukan_frekuensi ?? 'Ada') : 'Tidak' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Kunjungan KRS</span>
                                            <span class="data-value">{{ $pendamping->kunjungan_krs ? ($pendamping->kunjungan_krs_frekuensi ?? 'Ada') : 'Tidak' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Pendataan Bansos</span>
                                            <span class="data-value">{{ $pendamping->pendataan_bansos ? ($pendamping->pendataan_bansos_frekuensi ?? 'Ada') : 'Tidak' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Pemantauan Kesehatan</span>
                                            <span class="data-value">{{ $pendamping->pemantauan_kesehatan ? ($pendamping->pemantauan_kesehatan_frekuensi ?? 'Ada') : 'Tidak' }}</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="data-label">Foto</span>
                                            <span class="data-value">
                                                @if ($pendamping->foto)
                                                    <img src="{{ Storage::url($pendamping->foto) }}" alt="Foto Pendamping" class="photo-thumbnail">
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-end mt-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('pendamping_keluarga.edit', $pendamping->id) }}" class="btn btn-outline mr-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-secondary" onclick="showDeleteModal('{{ route('pendamping_keluarga.destroy', $pendamping->id) }}', '{{ $pendamping->nama ?? 'Pendamping' }}')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg max-w-md w-full mx-4 fade-in">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Konfirmasi Penghapusan</h3>
                        <p class="text-gray-600 text-sm mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
                <p class="mb-4 text-gray-700">Apakah Anda yakin ingin menghapus data <span id="deleteName" class="font-bold text-red-600"></span>?</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelDelete" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-primary" style="background-color: #dc2626; border-color: #dc2626;">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

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