<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun - CSSR</title>
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
        
        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
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
        
        .rejection-form {
            display: none;
            margin-top: 12px;
            padding: 12px;
            background-color: #fef3c7;
            border-radius: 6px;
            border-left: 3px solid #d97706;
        }
        
        .rejection-form.active {
            display: block;
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
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Verifikasi <span class="gradient-text">Akun Pengguna</span></h1>
            <p class="text-gray-600">Kelola verifikasi akun pengguna yang mendaftar ke sistem.</p>
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
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ $pendingUsers->count() }}</div>
                <div class="stat-label">Akun Menunggu Verifikasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $pendingUsers->where('role', 'kader')->count() }}</div>
                <div class="stat-label">Kader</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $pendingUsers->where('role', 'petugas_kesehatan')->count() }}</div>
                <div class="stat-label">Petugas Kesehatan</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $pendingUsers->where('role', 'admin')->count() }}</div>
                <div class="stat-label">Admin</div>
            </div>
        </div>
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-user-check text-blue-500"></i>
                        Daftar Akun Menunggu Verifikasi
                    </h3>
                    <span class="status-badge status-pending">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $pendingUsers->count() }} Menunggu
                    </span>
                </div>
            </div>
            
            @if($pendingUsers->count() > 0)
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
                                <th class="p-4 text-left font-medium text-gray-700">Surat Pengajuan</th>
                                <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingUsers as $user)
                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                                    <td class="p-4 text-gray-600">{{ $loop->iteration }}</td>
                                    <td class="p-4 font-medium text-gray-800">{{ $user->name }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->email }}</td>
                                    <td class="p-4">
                                        <span class="status-badge 
                                            @if($user->role == 'admin') bg-purple-100 text-purple-800
                                            @elseif($user->role == 'petugas_kesehatan') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-600">{{ $user->kecamatan->nama_kecamatan ?? 'Belum ditentukan' }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->kelurahan->nama_kelurahan ?? 'Belum ditentukan' }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->penanggung_jawab }}</td>
                                    <td class="p-4 text-gray-600">{{ $user->no_telepon }}</td>
                                    <td class="p-4">
                                        @if ($user->pas_foto)
                                            <a href="{{ Storage::url($user->pas_foto) }}" target="_blank" class="file-link">
                                                <i class="fas fa-eye"></i>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @if ($user->surat_pengajuan)
                                            <a href="{{ Storage::url($user->surat_pengajuan) }}" target="_blank" class="file-link">
                                                <i class="fas fa-file-pdf"></i>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="action-buttons">
                                            <form action="{{ route('verifikasi.approve', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="action-btn approve" onclick="return confirmApprove('{{ $user->name }}')">
                                                    <i class="fas fa-check"></i>
                                                    Setujui
                                                </button>
                                            </form>
                                            <button type="button" class="action-btn reject" onclick="toggleRejectionForm({{ $user->id }})">
                                                <i class="fas fa-times"></i>
                                                Tolak
                                            </button>
                                        </div>
                                        <div id="rejection-form-{{ $user->id }}" class="rejection-form">
                                            <form action="{{ route('verifikasi.reject', $user->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-2">
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                                                    <input type="text" name="catatan" placeholder="Masukkan alasan penolakan" class="w-full border border-gray-300 rounded-md p-2 text-sm" required>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
                                                        Konfirmasi Penolakan
                                                    </button>
                                                    <button type="button" class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600 transition" onclick="toggleRejectionForm({{ $user->id }})">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <p class="text-lg font-medium">Tidak ada akun yang menunggu verifikasi</p>
                    <p class="text-gray-500">Semua akun pengguna telah diverifikasi.</p>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        function toggleRejectionForm(userId) {
            const form = document.getElementById(`rejection-form-${userId}`);
            form.classList.toggle('active');
        }
        
        function confirmApprove(userName) {
            return Swal.fire({
                title: 'Konfirmasi Persetujuan',
                html: `Apakah Anda yakin ingin menyetujui akun <span class="font-bold text-green-600">${userName}</span>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-check mr-2"></i>Setujui',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal'
            }).then((result) => {
                return result.isConfirmed;
            });
        }
        
        // Auto-hide rejection forms when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.action-btn.reject, .rejection-form').length) {
                $('.rejection-form').removeClass('active');
            }
        });
    </script>
</body>
</html>