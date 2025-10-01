<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Program - CSSR</title>
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
            transform: scale(1.01);
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
        
        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .image-preview {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        
        .image-preview:hover {
            transform: scale(1.8);
            z-index: 10;
            position: relative;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            margin: 0 2px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .pagination .page-link:hover {
            background-color: #3b82f6;
            color: white;
        }
        
        .pagination .active .page-link {
            background-color: #3b82f6;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .image-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .image-overlay img {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .image-overlay .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #3b82f6;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .image-overlay .close-btn:hover {
            background: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Galeri Program <span class="gradient-text">CSSR</span></h1>
            <p class="text-gray-600">Kelola program-program CSSR yang ditampilkan di halaman publik.</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                <span class="mx-2">•</span>
                <i class="fas fa-database mr-2"></i>
                <span>Total: {{ $galeriPrograms->total() }} Program</span>
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
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('galeri_program.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 font-medium">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Program Baru
                    </a>
                    
                    <form action="{{ route('galeri_program.refresh') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700 transition flex items-center gap-2 font-medium">
                            <i class="fas fa-sync-alt"></i>
                            Refresh Data Realtime
                        </button>
                    </form>
                </div>
                
                <form action="{{ route('galeri_program.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <select name="kategori" class="border-gray-300 rounded-lg shadow-sm pl-10 pr-4 py-3 w-full sm:w-auto focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoriOptions as $option)
                                <option value="{{ $option }}" {{ $kategori == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-filter text-gray-400"></i>
                        </div>
                    </div>
                    <button type="submit" class="bg-gray-600 text-white px-5 py-3 rounded-lg hover:bg-gray-700 transition flex items-center gap-2 font-medium">
                        <i class="fas fa-search"></i>
                        Tampilkan
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Tabel Program -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left font-semibold text-gray-700">No</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Gambar</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Judul</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Deskripsi</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Kategori</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Statistik</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Urutan</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Status</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Update Terakhir</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($galeriPrograms as $index => $program)
                            <tr class="table-row-hover">
                                <td class="p-4 text-gray-600 font-medium">{{ $galeriPrograms->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <img src="{{ asset('storage/' . $program->gambar) }}" alt="Gambar Program" class="image-preview">
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-800">{{ $program->judul }}</div>
                                </td>
                                <td class="p-4 text-gray-600 max-w-xs">
                                    <div class="line-clamp-2">{{ $program->deskripsi }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="badge badge-info">
                                        <i class="fas fa-tag mr-1"></i>
                                        {{ $program->kategori }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if (isset($dataRiset[$program->judul]))
                                        <div class="flex items-center">
                                            <span class="font-medium text-green-600">{{ $dataRiset[$program->judul] }}</span>
                                            <span class="badge badge-success ml-2">
                                                <i class="fas fa-bolt mr-1"></i>
                                                Realtime
                                            </span>
                                        </div>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-edit mr-1"></i>
                                            Manual
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-800 rounded-full font-semibold">
                                        {{ $program->urutan }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if ($program->status_aktif)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-pause-circle mr-1"></i>
                                            Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="far fa-clock mr-2"></i>
                                        {{ $program->tanggal_update->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('galeri_program.edit', $program->id) }}" 
                                           class="text-blue-500 hover:text-blue-700 transition p-2 rounded-lg bg-blue-50 hover:bg-blue-100"
                                           title="Edit Program">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('galeri_program.destroy', $program->id) }}" method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-500 hover:text-red-700 transition p-2 rounded-lg bg-red-50 hover:bg-red-100"
                                                    title="Hapus Program">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="p-8">
                                    <div class="empty-state">
                                        <i class="fas fa-images"></i>
                                        <h3 class="text-xl font-medium text-gray-500 mb-2">Belum Ada Program</h3>
                                        <p class="mb-4">Mulai dengan menambahkan program baru untuk ditampilkan di galeri.</p>
                                        <a href="{{ route('galeri_program.create') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition inline-flex items-center gap-2">
                                            <i class="fas fa-plus-circle"></i>
                                            Tambah Program Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($galeriPrograms->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ $galeriPrograms->firstItem() }} hingga {{ $galeriPrograms->lastItem() }} dari {{ $galeriPrograms->total() }} program
                        </div>
                        <div class="pagination flex space-x-1">
                            {{ $galeriPrograms->appends(['kategori' => $kategori])->links('pagination::tailwind') }}
                        </div>
                    </div>
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

            // Enhanced image preview with overlay and close button
            $('.image-preview').on('click', function() {
                const src = $(this).attr('src');
                const overlay = $('<div class="image-overlay"></div>');
                const img = $('<img>').attr('src', src);
                const closeBtn = $('<div class="close-btn"><i class="fas fa-times"></i></div>');

                overlay.append(img).append(closeBtn);
                $('body').append(overlay);

                closeBtn.on('click', function() {
                    overlay.remove();
                });

                overlay.on('click', function(e) {
                    if (e.target === this) {
                        overlay.remove();
                    }
                });
            });

            // Delete confirmation with SweetAlert2
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                Swal.fire({
                    title: 'Hapus Program?',
                    text: 'Program ini akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.',
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
            $('.table-row-hover').each(function(index) {
                $(this).css({
                    opacity: 0,
                    transform: 'translateY(10px)'
                }).delay(index * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 300);
            });

            // Category filter change handler (for future AJAX enhancement)
            $('select[name="kategori"]').on('change', function() {
                const kategori = $(this).val();
                const form = $(this).closest('form');
                // For now, submit the form normally
                form.submit();
                // Future AJAX implementation:
                /*
                $.ajax({
                    url: '{{ route('galeri_program.index') }}',
                    method: 'GET',
                    data: { kategori: kategori },
                    success: function(data) {
                        // Update table content dynamically
                        // Example: Update tbody with new rows
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat data. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
                */
            });

            // Refresh button loading state
            $('form[action="{{ route('galeri_program.refresh') }}"] button').on('click', function() {
                const button = $(this);
                const originalText = button.html();
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Memuat...');
                setTimeout(function() {
                    button.prop('disabled', false).html(originalText);
                }, 2000); // Simulate loading
            });
        });
    </script>
</body>
</html>