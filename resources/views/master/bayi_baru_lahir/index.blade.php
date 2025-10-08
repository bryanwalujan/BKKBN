<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bayi Baru Lahir - Master Panel</title>
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
        .bg-gradient-sidebar {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
                            <i class="fas fa-baby text-pink-500 mr-3"></i>
                            Data Bayi Baru Lahir
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen data bayi baru lahir dan informasi terkait</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-database mr-1"></i>
                            Total: {{ $bayiBaruLahirs->total() }} Data
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button class="ml-auto text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Action Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Bayi Baru Lahir</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $bayiBaruLahirs->total() }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-baby text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rata-rata Berat Badan</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">
                                {{ number_format($bayiBaruLahirs->avg('berat_badan_lahir') ?? 0, 2) }} kg
                            </p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-weight text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Rata-rata Panjang Badan</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">
                                {{ number_format($bayiBaruLahirs->avg('panjang_badan_lahir') ?? 0, 2) }} cm
                            </p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <i class="fas fa-ruler-vertical text-purple-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3">
                   
                    <a href="{{ route('ibu_nifas.index') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm p-4 card-hover group cursor-pointer">
                        <div class="flex items-center justify-between text-white">
                            <div>
                                <p class="text-sm font-medium opacity-90">Lihat Data</p>
                                <p class="text-sm font-bold mt-1 group-hover:translate-x-1 transition-transform">Ibu Nifas</p>
                            </div>
                            <div class="p-2 bg-white bg-opacity-20 rounded-lg group-hover:scale-110 transition-transform">
                                <i class="fas fa-arrow-right text-sm"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-filter text-blue-500 mr-2"></i>
                        Pencarian Data
                    </h3>
                    @if ($search)
                        <a href="{{ route('bayi_baru_lahir.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Pencarian
                        </a>
                    @endif
                </div>

                <form action="{{ route('bayi_baru_lahir.index') }}" method="GET" class="flex gap-4">
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1 text-purple-500"></i>
                            Pencarian
                        </label>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Cari berdasarkan nama ibu, NIK, atau umur dalam kandungan..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center h-11">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                    </div>
                </form>

                <!-- Search Info -->
                @if ($search)
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Pencarian Aktif:</span>
                        </div>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Kata kunci: "{{ $search }}"
                                <button onclick="removeSearch()" class="ml-1 hover:text-purple-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Results Info -->
                <div class="mt-4 text-sm text-gray-600">
                    @if ($search)
                        <p>Menampilkan data dengan pencarian: "{{ $search }}" ({{ $bayiBaruLahirs->total() }} data)</p>
                    @else
                        <p>Menampilkan semua data bayi baru lahir ({{ $bayiBaruLahirs->total() }} data)</p>
                    @endif
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-table mr-2 text-blue-500"></i>
                        Data Bayi Baru Lahir
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-hashtag mr-2"></i>
                                        No
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-2"></i>
                                        Nama Ibu & Lokasi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Kehamilan
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-weight mr-2"></i>
                                        Berat Badan
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-ruler-vertical mr-2"></i>
                                        Panjang Badan
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-cogs mr-2"></i>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($bayiBaruLahirs as $index => $bayi)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $bayiBaruLahirs->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-female text-pink-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $bayi->ibuNifas->ibu->nama ?? '-' }}
                                                </div>
                                                <div class="text-sm text-gray-500 flex items-center mt-1">
                                                    <i class="fas fa-map-marker-alt text-red-500 mr-1 text-xs"></i>
                                                    {{ $bayi->ibuNifas->ibu->kelurahan->nama_kelurahan ?? '-' }}, 
                                                    {{ $bayi->ibuNifas->ibu->kecamatan->nama_kecamatan ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-baby text-blue-600 text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <span class="text-sm font-medium text-gray-900">{{ $bayi->umur_dalam_kandungan ?? '-' }} minggu</span>
                                                <p class="text-xs text-gray-500">Umur Kandungan</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-weight text-green-600 text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <span class="text-sm font-medium text-gray-900">{{ $bayi->berat_badan_lahir ?? '-' }} kg</span>
                                                <p class="text-xs text-gray-500">Berat Lahir</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-ruler-vertical text-purple-600 text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <span class="text-sm font-medium text-gray-900">{{ $bayi->panjang_badan_lahir ?? '-' }} cm</span>
                                                <p class="text-xs text-gray-500">Panjang Lahir</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('bayi_baru_lahir.edit', $bayi->id) }}" 
                                               class="text-green-600 hover:text-green-900 transition-colors p-2 rounded-lg hover:bg-green-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50 delete-btn"
                                                    title="Hapus"
                                                    data-url="{{ route('bayi_baru_lahir.destroy', $bayi->id) }}"
                                                    data-name="{{ $bayi->ibuNifas->ibu->nama ?? 'Bayi' }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button type="button" 
                                                    class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50 move-to-balita-btn"
                                                    title="Tambah ke Balita"
                                                    data-url="{{ route('bayi_baru_lahir.moveToBalita', $bayi->id) }}"
                                                    data-name="{{ $bayi->ibuNifas->ibu->nama ?? 'Bayi' }}">
                                                <i class="fas fa-baby-carriage"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-baby text-4xl mb-3"></i>
                                            <p class="text-lg font-medium">Tidak ada data bayi baru lahir ditemukan</p>
                                            <p class="text-sm mt-1">Coba ubah pencarian atau tambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($bayiBaruLahirs->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $bayiBaruLahirs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delete confirmation dengan SweetAlert2
            $('.delete-btn').on('click', function() {
                const url = $(this).data('url');
                const name = $(this).data('name');
                
                Swal.fire({
                    title: 'Hapus Data Bayi Baru Lahir?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Data bayi untuk ibu: <strong>${name}</strong></p>
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
                            url: url,
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                _method: 'DELETE'
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Dihapus!',
                                    text: 'Data bayi baru lahir berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data bayi baru lahir.';
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

            // Move to balita confirmation dengan SweetAlert2
            $('.move-to-balita-btn').on('click', function() {
                const url = $(this).data('url');
                const name = $(this).data('name');
                
                Swal.fire({
                    title: 'Pindahkan ke Data Balita?',
                    html: `<div class="text-center">
                             <i class="fas fa-baby-carriage text-blue-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin memindahkan?</p>
                             <p class="text-gray-600 mt-2">Data bayi untuk ibu: <strong>${name}</strong></p>
                             <p class="text-sm text-blue-600 mt-2">Data akan dipindahkan ke tabel balita</p>
                           </div>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-baby-carriage mr-2"></i>Ya, Pindahkan!',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'px-4 py-2 rounded-lg',
                        cancelButton: 'px-4 py-2 rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Dipindahkan!',
                                    text: 'Data bayi berhasil dipindahkan ke tabel balita.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal memindahkan data bayi.';
                                if (xhr.status === 419) {
                                    message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                } else if (xhr.status === 403) {
                                    message = 'Anda tidak memiliki izin untuk memindahkan data ini.';
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

        // Fungsi untuk menghapus pencarian
        function removeSearch() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }
    </script>
</body>
</html>