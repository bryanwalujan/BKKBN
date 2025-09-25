<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Carousel - CSSR</title>
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
        
        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #f8fafc;
            z-index: 10;
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
        
        .carousel-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            transition: transform 0.2s;
        }
        
        .carousel-image:hover {
            transform: scale(1.05);
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
        
        .text-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-primary {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .badge-secondary {
            background-color: #f3f4f6;
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Data <span class="gradient-text">Carousel</span></h1>
            <p class="text-gray-600">Kelola konten carousel untuk halaman utama website.</p>
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
        
        <!-- Action Button -->
        <div class="mb-6">
            <a href="{{ route('carousel.create') }}" class="bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition flex items-center justify-center gap-2 card-hover inline-block">
                <i class="fas fa-plus-circle"></i>
                Tambah Carousel
            </a>
        </div>
        
        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-images text-blue-500"></i>
                        Data Carousel
                    </h3>
                    <div class="text-sm text-gray-500">
                        Total: {{ $carousels->count() }} item
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="p-4 text-left font-medium text-gray-700">No</th>
                            <th class="p-4 text-left font-medium text-gray-700">Gambar</th>
                            <th class="p-4 text-left font-medium text-gray-700">Sub Heading</th>
                            <th class="p-4 text-left font-medium text-gray-700">Heading</th>
                            <th class="p-4 text-left font-medium text-gray-700">Deskripsi</th>
                            <th class="p-4 text-left font-medium text-gray-700">Button 1</th>
                            <th class="p-4 text-left font-medium text-gray-700">Button 2</th>
                            <th class="p-4 text-left font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carousels as $index => $carousel)
                            <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                                <td class="p-4 text-gray-600">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    @if ($carousel->gambar)
                                        <img src="{{ asset('storage/' . $carousel->gambar) }}" 
                                             alt="Gambar {{ $carousel->heading }}" 
                                             class="carousel-image" 
                                             onclick="showImageModal('{{ asset('storage/' . $carousel->gambar) }}', '{{ $carousel->heading }}')">
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="p-4 font-medium text-gray-800">
                                    {{ $carousel->sub_heading ?: '-' }}
                                </td>
                                <td class="p-4 font-medium text-gray-800">
                                    {{ $carousel->heading ?: '-' }}
                                </td>
                                <td class="p-4 text-gray-600 text-truncate" title="{{ $carousel->deskripsi }}">
                                    {{ $carousel->deskripsi ? Str::limit($carousel->deskripsi, 50) : '-' }}
                                </td>
                                <td class="p-4">
                                    @if ($carousel->button_1_text && $carousel->button_1_link)
                                        <div class="flex flex-col">
                                            <span class="badge badge-primary mb-1">{{ $carousel->button_1_text }}</span>
                                            <span class="text-xs text-gray-500 truncate">{{ $carousel->button_1_link }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if ($carousel->button_2_text && $carousel->button_2_link)
                                        <div class="flex flex-col">
                                            <span class="badge badge-secondary mb-1">{{ $carousel->button_2_text }}</span>
                                            <span class="text-xs text-gray-500 truncate">{{ $carousel->button_2_link }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="action-buttons">
                                        <a href="{{ route('carousel.edit', $carousel->id) }}" class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <button type="button" class="action-btn delete" onclick="showDeleteModal('{{ route('carousel.destroy', $carousel->id) }}', '{{ $carousel->heading ?: 'Carousel' }}')">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-images text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Belum ada data carousel.</p>
                                        <a href="{{ route('carousel.create') }}" class="text-blue-500 hover:text-blue-700 mt-2 flex items-center gap-1">
                                            <i class="fas fa-plus-circle"></i>
                                            Tambah Carousel Pertama
                                        </a>
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

    <!-- Modal Gambar -->
    <div id="imageModal" class="modal-overlay">
        <div class="modal-content">
            <span class="modal-close"><i class="fas fa-times"></i></span>
            <img id="modalImage" src="" alt="Gambar Carousel" class="mx-auto">
            <p id="modalCaption" class="text-center text-gray-600 mt-4"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delete modal with SweetAlert2
            window.showDeleteModal = function(url, name) {
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    html: `Apakah Anda yakin ingin menghapus carousel <span class="font-bold text-red-600">${name}</span>? Tindakan ini tidak dapat dibatalkan.`,
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

            // Image modal
            window.showImageModal = function(src, name) {
                $('#modalImage').attr('src', src);
                $('#modalCaption').text('Gambar Carousel: ' + name);
                $('#imageModal').addClass('active');
            };

            $('.modal-close').on('click', function() {
                $('#imageModal').removeClass('active');
            });

            $(document).on('click', function(e) {
                if ($(e.target).hasClass('modal-overlay')) {
                    $('#imageModal').removeClass('active');
                }
            });
        });
    </script>
</body>
</html>