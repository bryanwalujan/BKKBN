<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aksi Konvergensi - Perangkat Daerah</title>
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
        .status-selesai { background-color: #10b981; color: white; }
        .status-belum { background-color: #f59e0b; color: white; }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('perangkat_daerah.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-building text-green-600 mr-3"></i>
                            Aksi Konvergensi - Perangkat Daerah
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen data aksi konvergensi penanganan stunting</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-database mr-1"></i>
                            Total: {{ $aksiKonvergensis->total() }} Data
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center fade-in">
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
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center fade-in">
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
                            <p class="text-sm font-medium text-gray-600">Total Aksi</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $aksiKonvergensis->total() }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-handshake text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Aksi Selesai</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $aksiKonvergensis->where('selesai', true)->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Aksi Berjalan</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $aksiKonvergensis->where('selesai', false)->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <i class="fas fa-clock text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <a href="{{ route('perangkat_daerah.aksi_konvergensi.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm p-6 card-hover group cursor-pointer">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-medium opacity-90">Tambah Baru</p>
                            <p class="text-lg font-bold mt-1 group-hover:translate-x-1 transition-transform">Aksi Konvergensi</p>
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
                        <i class="fas fa-search text-blue-500 mr-2"></i>
                        Pencarian Data
                    </h3>
                    @if ($search)
                        <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Pencarian
                        </a>
                    @endif
                </div>

                <form action="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" method="GET" class="flex gap-4">
                    <div class="flex-grow">
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Cari nama aksi konvergensi..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </form>

                <!-- Search Info -->
                @if ($search)
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Pencarian Aktif:</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Kata kunci: "{{ $search }}"
                                <button onclick="removeSearch()" class="ml-1 hover:text-purple-600">
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
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-table mr-2 text-blue-500"></i>
                        Data Aksi Konvergensi
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
                                        <i class="fas fa-address-card mr-2"></i>
                                        Kartu Keluarga
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
                                        <i class="fas fa-handshake mr-2"></i>
                                        Nama Aksi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Status
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Tahun
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
                            @forelse ($aksiKonvergensis as $index => $aksi)
                                <tr class="hover:bg-gray-50 transition-colors fade-in">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $aksiKonvergensis->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($aksi->kartuKeluarga)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-home text-blue-600"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <a href="{{ route('kartu_keluarga.show', $aksi->kartuKeluarga->id) }}" 
                                                       class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                                        {{ $aksi->kartuKeluarga->no_kk }}
                                                    </a>
                                                    <div class="text-sm text-gray-500">{{ $aksi->kartuKeluarga->kepala_keluarga ?? '-' }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500">-</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $aksi->kecamatan->nama_kecamatan ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $aksi->kelurahan->nama_kelurahan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $aksi->nama_aksi }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $aksi->selesai ? 'status-selesai' : 'status-belum' }}">
                                                <i class="fas {{ $aksi->selesai ? 'fa-check' : 'fa-clock' }} mr-1 text-xs"></i>
                                                {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $aksi->tahun }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $aksi->createdBy->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $aksi->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $aksi->id) }}" 
                                               class="text-green-600 hover:text-green-900 transition-colors p-2 rounded-lg hover:bg-green-50"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('perangkat_daerah.aksi_konvergensi.edit', $aksi->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50 delete-btn"
                                                    data-id="{{ $aksi->id }}" 
                                                    data-name="{{ $aksi->nama_aksi }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-inbox text-4xl mb-3"></i>
                                            <p class="text-lg font-medium">Tidak ada data ditemukan</p>
                                            <p class="text-sm mt-1">Coba ubah pencarian atau tambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($aksiKonvergensis->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $aksiKonvergensis->links() }}
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
                const id = $(this).data('id');
                const name = $(this).data('name');
                const url = '{{ route("perangkat_daerah.aksi_konvergensi.destroy", ":id") }}'.replace(':id', id);
                
                Swal.fire({
                    title: 'Hapus Data Aksi Konvergensi?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Aksi Konvergensi: <strong>${name}</strong></p>
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
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Dihapus!',
                                    text: 'Data aksi konvergensi berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data aksi konvergensi.';
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