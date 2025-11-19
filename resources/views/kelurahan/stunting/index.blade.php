<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Stunting - Admin Kelurahan</title>
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
        .status-gizi-sehat {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .status-gizi-waspada {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .status-gizi-buruk {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        .table-row-hover:hover {
            background-color: #f9fafb;
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
                            <i class="fas fa-child text-red-500 mr-3"></i>
                            Data Stunting - Kelurahan
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen data stunting di wilayah kelurahan Anda</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-database mr-1"></i>
                            Total: {{ $totalData }} Data
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Data Stunting</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalData }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-child text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Gizi Sehat</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stuntings->where('warna_gizi', 'Sehat')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-heart text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <a href="{{ route('kelurahan.stunting.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm p-6 card-hover group cursor-pointer">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-medium opacity-90">Tambah Baru</p>
                            <p class="text-lg font-bold mt-1 group-hover:translate-x-1 transition-transform">Data Stunting</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-filter text-blue-500 mr-2"></i>
                        Filter Data
                    </h3>
                    @if ($search)
                        <a href="{{ route('kelurahan.stunting.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form action="{{ route('kelurahan.stunting.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1 text-purple-500"></i>
                            Pencarian
                        </label>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Cari berdasarkan Nama atau NIK..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full lg:w-auto bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>

                <!-- Filter Info -->
                @if ($search)
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Filter Aktif:</span>
                        </div>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Pencarian: "{{ $search }}"
                                <button onclick="removeFilter('search')" class="ml-1 hover:text-purple-600">
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
                            <i class="fas fa-table mr-2 text-blue-500"></i>
                            Data Stunting Kelurahan
                        </h3>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Menampilkan {{ $stuntings->count() }} dari {{ $totalData }} data
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
                                        <i class="fas fa-user mr-2"></i>
                                        Identitas
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-home mr-2"></i>
                                        Keluarga & Lokasi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Informasi Umur & Jenis Kelamin
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-chart-line mr-2"></i>
                                        Status Gizi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        Diupload Oleh
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
                            @forelse ($stuntings as $index => $stunting)
                                <tr class="table-row-hover transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $stuntings->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-red-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-child text-red-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $stunting->nama }}</div>
                                                <div class="text-sm text-gray-500">{{ $stunting->nik ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <i class="fas fa-id-card text-blue-500 mr-1"></i>
                                            {{ $stunting->kartuKeluarga->no_kk ?? '-' }}
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-user-tie text-green-500 mr-1"></i>
                                            {{ $stunting->kartuKeluarga->kepala_keluarga ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-1"></i>
                                            {{ $stunting->kecamatan->nama_kecamatan ?? '-' }}, 
                                            {{ $stunting->kelurahan->nama_kelurahan ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <i class="far fa-calendar-alt text-purple-500 mr-1"></i>
                                            {{ $stunting->tanggal_lahir ? \Carbon\Carbon::parse($stunting->tanggal_lahir)->format('d/m/Y') : '-' }}
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-child text-orange-500 mr-1"></i>
                                            {{ $stunting->kategori_umur }}
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-venus-mars text-pink-500 mr-1"></i>
                                            {{ $stunting->jenis_kelamin }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-700">Berat/Tinggi:</span>
                                                <span class="ml-1 text-gray-900">{{ $stunting->berat_tinggi }}</span>
                                            </div>
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-700">Status:</span>
                                                <span class="ml-1 text-gray-900">{{ $stunting->status_gizi }}</span>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white 
                                                    {{ $stunting->warna_gizi == 'Sehat' ? 'status-gizi-sehat' : ($stunting->warna_gizi == 'Waspada' ? 'status-gizi-waspada' : 'status-gizi-buruk') }}">
                                                    <i class="fas fa-circle mr-1 text-xs opacity-75"></i>
                                                    {{ $stunting->warna_gizi }}
                                                </span>
                                            </div>
                                            @if($stunting->tindak_lanjut)
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-700">Tindak Lanjut:</span>
                                                    <span class="ml-1 text-gray-900">{{ $stunting->tindak_lanjut }}</span>
                                                </div>
                                                <div>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white 
                                                        {{ $stunting->warna_tindak_lanjut == 'Sehat' ? 'status-gizi-sehat' : ($stunting->warna_tindak_lanjut == 'Waspada' ? 'status-gizi-waspada' : 'status-gizi-buruk') }}">
                                                        <i class="fas fa-arrow-right mr-1 text-xs opacity-75"></i>
                                                        {{ $stunting->warna_tindak_lanjut }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600 text-xs"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $stunting->createdBy->name ?? 'Tidak diketahui' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('kelurahan.stunting.edit', $stunting->id) }}" 
                                               class="text-green-600 hover:text-green-900 transition-colors p-2 rounded-lg hover:bg-green-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    onclick="showDeleteModal('{{ route('kelurahan.stunting.destroy', $stunting->id) }}', '{{ $stunting->nama }}')"
                                                    class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-inbox text-4xl mb-3"></i>
                                            <p class="text-lg font-medium">Tidak ada data ditemukan</p>
                                            <p class="text-sm mt-1">Coba ubah filter pencarian atau tambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($stuntings->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $stuntings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        // Fungsi untuk menghapus filter individual
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }

        // Delete confirmation dengan SweetAlert2
        function showDeleteModal(url, name) {
            Swal.fire({
                title: 'Hapus Data Stunting?',
                html: `<div class="text-center">
                         <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                         <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                         <p class="text-gray-600 mt-2">Data Stunting: <strong>${name}</strong></p>
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
                                text: 'Data stunting berhasil dihapus.',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                timer: 2000
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            let message = 'Gagal menghapus data stunting.';
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
        }
    </script>
</body>
</html>