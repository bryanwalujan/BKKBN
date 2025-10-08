<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kartu Keluarga - Admin Kelurahan</title>
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
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('kelurahan.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-address-card text-green-600 mr-3"></i>
                            Kelola Kartu Keluarga
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen data kartu keluarga di wilayah kelurahan Anda</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-database mr-1"></i>
                            Total: {{ $kartuKeluargas->total() }} Data
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
                            <p class="text-sm font-medium text-gray-600">Total Kartu Keluarga</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->total() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-address-card text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Aktif</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('status', 'Aktif')->count() }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-lg">
                            <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Non-Aktif</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('status', '!=', 'Aktif')->count() }}</p>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-lg">
                            <i class="fas fa-exclamation-circle text-amber-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <a href="{{ route('kelurahan.kartu_keluarga.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm p-6 card-hover group cursor-pointer">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-medium opacity-90">Tambah Baru</p>
                            <p class="text-lg font-bold mt-1 group-hover:translate-x-1 transition-transform">Kartu Keluarga</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Search Section -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-search text-green-500 mr-2"></i>
                        Pencarian Data
                    </h3>
                    @if ($search)
                        <a href="{{ route('kelurahan.kartu_keluarga.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Pencarian
                        </a>
                    @endif
                </div>

                <form action="{{ route('kelurahan.kartu_keluarga.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1 text-purple-500"></i>
                            Pencarian
                        </label>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Cari No KK atau Kepala Keluarga..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i>
                            Cari Data
                        </button>
                    </div>
                </form>

                <!-- Search Info -->
                @if ($search)
                    <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center text-green-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Pencarian Aktif:</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Kata kunci: "{{ $search }}"
                                <button onclick="removeSearch()" class="ml-1 hover:text-green-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-table mr-2 text-green-500"></i>
                            Data Kartu Keluarga
                        </h3>
                        <div class="text-sm text-gray-500">
                            Menampilkan {{ $kartuKeluargas->count() }} dari {{ $kartuKeluargas->total() }} data
                        </div>
                    </div>
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
                                        <i class="fas fa-id-card mr-2"></i>
                                        No KK & Kepala Keluarga
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marked-alt mr-2"></i>
                                        Lokasi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Status
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Pengunggah
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
                            @forelse ($kartuKeluargas as $index => $kk)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $kartuKeluargas->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-address-card text-green-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('kelurahan.kartu_keluarga.show', $kk->id) }}" 
                                                   class="text-sm font-medium text-gray-900 hover:text-green-600 transition-colors">
                                                    {{ $kk->no_kk }}
                                                </a>
                                                <p class="text-sm text-gray-500">{{ $kk->kepala_keluarga }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $kk->alamat ?? '-' }}</div>
                                        <div class="text-sm text-gray-500 flex items-center mt-1">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-1 text-xs"></i>
                                            {{ $kk->kecamatan->nama_kecamatan ?? '-' }}, 
                                            {{ $kk->kelurahan->nama_kelurahan ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $kk->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            {{ $kk->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $kk->createdBy->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $kk->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('kelurahan.kartu_keluarga.show', $kk->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('kelurahan.kartu_keluarga.edit', $kk->id) }}" 
                                               class="text-green-600 hover:text-green-900 transition-colors p-2 rounded-lg hover:bg-green-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('kelurahan.kartu_keluarga.destroy', $kk->id) }}" method="POST" class="delete-form inline" data-name="{{ $kk->kepala_keluarga }}">
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
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-inbox text-4xl mb-3"></i>
                                            <p class="text-lg font-medium">Tidak ada data ditemukan</p>
                                            <p class="text-sm mt-1">Coba ubah pencarian atau tambahkan data baru</p>
                                            <a href="{{ route('kelurahan.kartu_keluarga.create') }}" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                                                <i class="fas fa-plus mr-2"></i>
                                                Tambah Kartu Keluarga
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($kartuKeluargas->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $kartuKeluargas->links() }}
                    </div>
                @endif
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
                    title: 'Hapus Kartu Keluarga?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Kartu Keluarga: <strong>${name}</strong></p>
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
                                    text: 'Data kartu keluarga berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data kartu keluarga.';
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

        // Fungsi untuk menghapus pencarian
        function removeSearch() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }
    </script>
</body>
</html>