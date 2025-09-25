<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Edukasi - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            transform: translateY(-5px);
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
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .table-container {
            max-height: 600px;
            overflow-y: auto;
        }
        
        .table-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .table-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        .thumbnail {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
        }
        
        .btn-edit {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .btn-edit:hover {
            background-color: #bfdbfe;
        }
        
        .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .btn-delete:hover {
            background-color: #fecaca;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #d1d5db;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-left: 40px;
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola <span class="gradient-text">Edukasi</span></h1>
                    <p class="text-gray-600">Kelola konten edukasi untuk sistem CSSR</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
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
        
        <!-- Toolbar -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6 card-hover">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="w-full md:w-auto">
                    <a href="{{ route('edukasi.create') }}" class="bg-blue-500 text-white px-5 py-3 rounded-lg hover:bg-blue-600 transition flex items-center gap-2 font-medium">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Edukasi Baru
                    </a>
                </div>
                
                <div class="w-full md:w-64 search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Cari edukasi..." class="w-full border border-gray-300 rounded-lg py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ request()->search }}">
                </div>
            </div>
        </div>
        
        <!-- Tabel Edukasi -->
        <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Daftar Konten Edukasi</h3>
                    <p class="text-gray-600 text-sm mt-1">Total {{ count($edukasis) }} konten edukasi</p>
                </div>
                
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-filter mr-2 text-blue-500"></i>
                    <span>Filter: </span>
                    <select name="status" class="ml-2 border border-gray-300 rounded-lg py-1 px-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="all" {{ request()->status == 'all' || !request()->status ? 'selected' : '' }}>Semua</option>
                        <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
            </div>
            
            @if(count($edukasis) > 0)
            <div class="table-container">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Media</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($edukasis as $edukasi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-4">
                                <div class="font-medium text-gray-900">{{ $edukasi->judul }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ \App\Models\Edukasi::KATEGORI[$edukasi->kategori] ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm text-gray-700 max-w-xs truncate">
                                    {{ $edukasi->deskripsi ? \Illuminate\Support\Str::limit($edukasi->deskripsi, 50) : '-' }}
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-2">
                                    @if ($edukasi->gambar)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($edukasi->gambar) }}" alt="Gambar Edukasi" class="thumbnail">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 flex items-center justify-center rounded opacity-0 group-hover:opacity-100 transition">
                                            <a href="{{ Storage::url($edukasi->gambar) }}" target="_blank" class="text-white text-sm">
                                                <i class="fas fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                    @endif
                                    
                                    <div class="flex flex-col space-y-1">
                                        @if ($edukasi->tautan)
                                        <a href="{{ $edukasi->tautan }}" target="_blank" class="text-blue-500 hover:text-blue-700 text-sm flex items-center gap-1">
                                            <i class="fas fa-link text-xs"></i>
                                            Tautan
                                        </a>
                                        @endif
                                        
                                        @if ($edukasi->file)
                                        <a href="{{ Storage::url($edukasi->file) }}" target="_blank" class="text-green-500 hover:text-green-700 text-sm flex items-center gap-1">
                                            <i class="fas fa-file text-xs"></i>
                                            File
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="status-badge {{ $edukasi->status_aktif ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-{{ $edukasi->status_aktif ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                    {{ $edukasi->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('edukasi.edit', $edukasi->id) }}" class="action-btn btn-edit flex items-center gap-1">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('edukasi.destroy', $edukasi->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete flex items-center gap-1">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
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
                <i class="fas fa-book-open"></i>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Belum ada konten edukasi</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan konten edukasi pertama Anda</p>
                <a href="{{ route('edukasi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition inline-flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Edukasi Baru
                </a>
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
        $(document).ready(function() {
            // Session messages with SweetAlert2
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

            // Delete confirmation with SweetAlert2
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                Swal.fire({
                    title: 'Hapus Edukasi?',
                    text: 'Konten edukasi ini akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.off('submit').submit();
                    }
                });
            });

            // Dynamic table row animation on load
            $('tbody tr').each(function(index) {
                $(this).css({
                    opacity: 0,
                    transform: 'translateY(10px)'
                }).delay(index * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 300);
            });

            // Search and filter form submission
            const searchInput = $('.search-box input');
            const statusFilter = $('select[name="status"]');
            const form = $('<form>').attr({
                action: '{{ route('edukasi.index') }}',
                method: 'GET'
            });

            // Wrap search and status inputs in a form for submission
            searchInput.add(statusFilter).on('change input', function() {
                const search = searchInput.val();
                const status = statusFilter.val();
                
                form.empty().append(
                    $('<input>').attr({ type: 'hidden', name: 'search', value: search }),
                    $('<input>').attr({ type: 'hidden', name: 'status', value: status })
                );
                
                // Submit form to update results
                $('body').append(form);
                form.submit();
            });

            // Image thumbnail preview
            $('.thumbnail').on('click', function() {
                const src = $(this).attr('src');
                Swal.fire({
                    imageUrl: src,
                    imageAlt: 'Gambar Edukasi',
                    showConfirmButton: false,
                    showCloseButton: true,
                    padding: '1rem',
                    background: 'rgba(0,0,0,0.75)',
                    imageWidth: '90%',
                    imageHeight: 'auto'
                });
            });
        });
    </script>
</body>
</html>