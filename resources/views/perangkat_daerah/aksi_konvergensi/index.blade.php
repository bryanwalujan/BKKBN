<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Aksi Konvergensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        
        .table-container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        
        .table-header {
            background-color: #e5e7eb;
            color: #374151;
        }
        
        .table-row:hover {
            background-color: #f9fafb;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background-color: #dc2626;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #b91c1c;
            transform: translateY(-2px);
        }
        
        .tab {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .tab-active {
            background-color: #3b82f6;
            color: white;
        }
        
        .tab-inactive {
            background-color: #e5e7eb;
            color: #374151;
        }
        
        .tab-inactive:hover {
            background-color: #d1d5db;
        }
        
        .search-input {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem;
            width: 100%;
            max-width: 300px;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-selesai {
            background-color: #10b981;
            color: white;
        }
        
        .status-belum-selesai {
            background-color: #ef4444;
            color: white;
        }
        
        .status-pending {
            background-color: #f59e0b;
            color: white;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .pagination a, .pagination span {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            background-color: #e5e7eb;
            color: #374151;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .pagination a:hover {
            background-color: #3b82f6;
            color: white;
        }
        
        .pagination .current {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body>
    @include('perangkat_daerah.partials.sidebar')
    
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">
            <i class="fas fa-tasks mr-2 text-blue-500"></i> Data Aksi Konvergensi
        </h2>
        
        <!-- Tabs -->
        <div class="mb-4 flex gap-2">
            <a href="{{ route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'pending']) }}" class="tab {{ $tab == 'pending' ? 'tab-active' : 'tab-inactive' }}">
                <i class="fas fa-hourglass-half mr-1"></i> Pending
            </a>
            <a href="{{ route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'verified']) }}" class="tab {{ $tab == 'verified' ? 'tab-active' : 'tab-inactive' }}">
                <i class="fas fa-check-circle mr-1"></i> Terverifikasi
            </a>
        </div>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="mb-4 flex gap-2">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama aksi..." class="search-input">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>
        
        <!-- Session Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        
        <!-- Create Button for Pending Tab -->
        @if ($tab == 'pending')
            <a href="{{ route('perangkat_daerah.aksi_konvergensi.create') }}" class="mb-4 inline-block btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Aksi Konvergensi
            </a>
        @endif
        
        <!-- Table -->
        <div class="table-container">
            <table class="w-full">
                <thead class="table-header">
                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">No KK</th>
                        <th class="p-4 text-left">Kecamatan</th>
                        <th class="p-4 text-left">Kelurahan</th>
                        <th class="p-4 text-left">Nama Aksi</th>
                        <th class="p-4 text-left">Selesai</th>
                        <th class="p-4 text-left">Tahun</th>
                        @if ($tab == 'pending')
                            <th class="p-4 text-left">Status</th>
                        @endif
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aksiKonvergensis as $index => $aksi)
                        <tr class="table-row">
                            <td class="p-4">{{ $aksiKonvergensis->firstItem() + $index }}</td>
                            <td class="p-4">
                                <a href="{{ route('kartu_keluarga.show', $aksi->kartuKeluarga->id) }}" class="text-blue-500 hover:underline">
                                    {{ $aksi->kartuKeluarga->no_kk ?? '-' }}
                                </a>
                            </td>
                            <td class="p-4">{{ $aksi->kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="p-4">{{ $aksi->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="p-4">{{ $aksi->nama_aksi }}</td>
                            <td class="p-4">
                                <span class="status-badge {{ $aksi->selesai ? 'status-selesai' : 'status-belum-selesai' }}">
                                    {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                                </span>
                            </td>
                            <td class="p-4">{{ $aksi->tahun }}</td>
                            @if ($tab == 'pending')
                                <td class="p-4">
                                    <span class="status-badge status-pending">
                                        {{ ucfirst($aksi->status) }}
                                    </span>
                                </td>
                            @endif
                            <td class="p-4 flex gap-2">
                                <a href="{{ route('perangkat_daerah.aksi_konvergensi.edit', [$aksi->id, $tab]) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if ($tab == 'pending')
                                    <form action="{{ route('perangkat_daerah.aksi_konvergensi.destroy', $aksi->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data Aksi Konvergensi ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $tab == 'pending' ? 9 : 8 }}" class="p-4 text-center text-gray-500">
                                Tidak ada data aksi konvergensi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="pagination">
            {{ $aksiKonvergensis->links() }}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
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
        });
    </script>
</body>
</html>