<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - CSSR</title>
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
            max-width: 500px;
            width: 90%;
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
        
        .file-link {
            color: #3b82f6;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
        }
        
        .file-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }
        
        .empty-state i {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 16px;
        }
        
        .empty-state p {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 8px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .stat-item {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }
        
        .stat-label {
            font-size: 14px;
            color: #6b7280;
        }
        
        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }
        
        .filter-form {
            display: flex;
            gap: 12px;
            align-items: end;
            flex-wrap: wrap;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-width: 180px;
        }
        
        .filter-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }
        
        .filter-select {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .filter-button {
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .filter-button:hover {
            background-color: #2563eb;
        }
        
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 24px;
        }
        
        .pagination {
            display: flex;
            gap: 8px;
        }
        
        .pagination-link {
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .pagination-link:not(.disabled):not(.active) {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .pagination-link:not(.disabled):not(.active):hover {
            background-color: #e5e7eb;
        }
        
        .pagination-link.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .pagination-link.disabled {
            background-color: #f9fafb;
            color: #9ca3af;
            cursor: not-allowed;
        }
        
        .photo-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }
        
        .photo-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .photo-modal-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            animation: zoomIn 0.3s;
        }
        
        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .photo-modal-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        .photo-modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: #fff;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .photo-modal-close:hover {
            background: rgba(0, 0, 0, 0.7);
        }
        
        .role-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .role-admin {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .role-petugas_kesehatan {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .role-kader {
            background-color: #dcfce7;
            color: #16a34a;
        }
        
        .role-other {
            background-color: #fef3c7;
            color: #d97706;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola <span class="gradient-text">Pengguna</span></h1>
            <p class="text-gray-600">Kelola semua akun pengguna yang terdaftar dalam sistem.</p>
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
        
       
        
        <!-- Filter Card -->
        <div class="filter-card card-hover">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-filter text-blue-500"></i>
                Filter Data Pengguna
            </h3>
            <form action="{{ route('users.index') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <label class="filter-label">Role</label>
                    <select name="role" class="filter-select">
                        <option value="">Semua Role</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r }}" {{ $role == $r ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $r)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Kecamatan</label>
                    <select name="kecamatan_id" class="filter-select">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                {{ $kecamatan->nama_kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Kelurahan</label>
                    <select name="kelurahan_id" class="filter-select">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>
                                {{ $kelurahan->nama_kelurahan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="filter-button">
                    <i class="fas fa-search"></i>
                    Terapkan Filter
                </button>
            </form>
        </div>
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-users text-blue-500"></i>
                        Daftar Pengguna
                    </h3>
                    <span class="text-sm text-gray-500">
                        Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna
                    </span>
                </div>
            </div>
            
            @if($users->count() > 0)
                <div class="table-container">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="p-4 text-left font-medium text-gray-700">No</th>
                                <th class="p-4 text-left font-medium text-gray-700">Nama</th>
                                <th class="p-4 text-left font-medium text-gray-700">Email</th>
                                <th class="p-4 text-left font-medium text-gray-700">Role</th>
                                <th class="p-4 text-left font-medium text-gray-700">Kecamatan</th>
                                <th class="p-4 text-left font-medium text-gray-700">Kelurahan</th>
                                <th class="p-4 text-left font-medium text-gray-700">Penanggung Jawab</th>
                                <th class="p-4 text-left font-medium text-gray-700">No Telepon</th>
                                <th class="p-4 text-left font-medium text-gray-700">Pas Foto</th>
                                <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                                    <td class="p-4 text-gray-600">{{ $users->firstItem() + $index }}</td>
                                    <td class="p-4 font-medium text-gray-800">{{ $user->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="p-4">
                                        <span class="role-badge 
                                            @if($user->role == 'admin') role-admin
                                            @elseif($user->role == 'petugas_kesehatan') role-petugas_kesehatan
                                            @elseif($user->role == 'kader') role-kader
                                            @else role-other @endif">
                                            <i class="fas 
                                                @if($user->role == 'admin') fa-user-shield
                                                @elseif($user->role == 'petugas_kesehatan') fa-user-md
                                                @elseif($user->role == 'kader') fa-user-nurse
                                                @else fa-user @endif mr-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-600">{{ $user->kecamatan->nama_kecamatan ?? '-' }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->kelurahan->nama_kelurahan ?? '-' }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->penanggung_jawab ?? '-' }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->no_telepon ?? '-' }}</td>
                                    <td class="p-4">
                                        @if ($user->pas_foto && Storage::disk('public')->exists($user->pas_foto))
                                            <img src="{{ Storage::url($user->pas_foto) }}" 
                                                 alt="Pas Foto {{ $user->name }}" 
                                                 class="thumbnail"
                                                 onclick="openPhotoModal('{{ Storage::url($user->pas_foto) }}', '{{ $user->name }}')"
                                                 title="Klik untuk melihat foto lebih besar">
                                        @else
                                            <span class="text-gray-400">
                                                <i class="fas fa-image"></i>
                                                Tidak ada foto
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="action-buttons">
                                            <a href="{{ route('users.edit', $user->id) }}" class="action-btn edit">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete" onclick="return confirmDelete('{{ $user->name }}')">
                                                        <i class="fas fa-trash"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination">
                        {{ $users->appends(['role' => $role, 'kecamatan_id' => $kecamatan_id, 'kelurahan_id' => $kelurahan_id])->links('pagination::simple-tailwind') }}
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <p class="text-lg font-medium">Tidak ada pengguna yang ditemukan</p>
                    <p class="text-gray-500">Coba ubah filter pencarian Anda.</p>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal untuk menampilkan foto besar -->
    <div id="photoModal" class="photo-modal">
        <div class="photo-modal-content">
            <span class="photo-modal-close" onclick="closePhotoModal()">&times;</span>
            <img id="modalImage" class="photo-modal-image" src="" alt="">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        function openPhotoModal(imageSrc, userName) {
            const modal = document.getElementById('photoModal');
            const modalImage = document.getElementById('modalImage');
            
            modal.classList.add('active');
            modalImage.src = imageSrc;
            modalImage.alt = 'Pas Foto ' + userName;
            
            // Prevent scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.remove('active');
            
            // Restore scrolling when modal is closed
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        document.getElementById('photoModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closePhotoModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePhotoModal();
            }
        });
        
        function confirmDelete(userName) {
            return Swal.fire({
                title: 'Konfirmasi Penghapusan',
                html: `Apakah Anda yakin ingin menghapus akun <span class="font-bold text-red-600">${userName}</span>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-trash mr-2"></i>Hapus',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal'
            }).then((result) => {
                return result.isConfirmed;
            });
        }
    </script>
</body>
</html>