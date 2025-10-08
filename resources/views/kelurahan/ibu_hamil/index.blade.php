<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ibu Hamil - Admin Kelurahan</title>
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
        .status-sehat { background-color: #10b981; color: white; }
        .status-waspada { background-color: #f59e0b; color: white; }
        .status-berisiko { background-color: #ef4444; color: white; }
        .trimester-1 { background-color: #3b82f6; color: white; }
        .trimester-2 { background-color: #8b5cf6; color: white; }
        .trimester-3 { background-color: #ec4899; color: white; }
        .table-container {
            max-height: 70vh;
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
            background: #c5c5c5;
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
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
                            <i class="fas fa-person-pregnant text-yellow-600 mr-3"></i>
                            Data Ibu Hamil - Kelurahan
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen data ibu hamil di wilayah kelurahan Anda</p>
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
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Ibu Hamil</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalData }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <i class="fas fa-person-pregnant text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Sehat</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $ibuHamils->where('warna_status_gizi', 'Sehat')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-heart text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Perlu Perhatian</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $ibuHamils->where('warna_status_gizi', 'Waspada')->count() + $ibuHamils->where('warna_status_gizi', 'Berisiko')->count() }}</p>
                        </div>
                        <div class="p-3 bg-orange-50 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-orange-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <a href="{{ route('kelurahan.ibu_hamil.create') }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl shadow-sm p-6 card-hover group cursor-pointer">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-medium opacity-90">Tambah Baru</p>
                            <p class="text-lg font-bold mt-1 group-hover:translate-x-1 transition-transform">Data Ibu Hamil</p>
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
                        <i class="fas fa-filter text-yellow-500 mr-2"></i>
                        Filter Data
                    </h3>
                    @if ($search)
                        <a href="{{ route('kelurahan.ibu_hamil.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form action="{{ route('kelurahan.ibu_hamil.index') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1 text-purple-500"></i>
                            Pencarian
                        </label>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Cari Nama, NIK, atau riwayat penyakit..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 p-3">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center w-full lg:w-auto">
                            <i class="fas fa-filter mr-2"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>

                <!-- Filter Info -->
                @if ($search)
                    <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="flex items-center text-yellow-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Filter Aktif:</span>
                        </div>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pencarian: "{{ $search }}"
                                <button onclick="removeFilter('search')" class="ml-1 hover:text-yellow-600">
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
                            <i class="fas fa-table text-yellow-500 mr-2"></i>
                            Data Ibu Hamil
                        </h3>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-list mr-1"></i>
                            Menampilkan {{ $ibuHamils->count() }} dari {{ $totalData }} data
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="w-full">
                        <thead class="bg-gray-50 sticky top-0">
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
                                        <i class="fas fa-map-marked-alt mr-2"></i>
                                        Lokasi
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
                                        <i class="fas fa-heartbeat mr-2"></i>
                                        Status & Intervensi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-chart-line mr-2"></i>
                                        Pengukuran
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
                            @forelse ($ibuHamils as $index => $ibuHamil)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $ibuHamils->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12 bg-yellow-100 rounded-lg flex items-center justify-center overflow-hidden">
                                                @if ($ibuHamil->ibu->foto)
                                                    <img src="{{ Storage::url($ibuHamil->ibu->foto) }}" 
                                                         alt="Foto {{ $ibuHamil->ibu->nama }}" 
                                                         class="w-full h-full object-cover cursor-pointer"
                                                         onclick="showImageModal('{{ Storage::url($ibuHamil->ibu->foto) }}', '{{ $ibuHamil->ibu->nama }}')">
                                                @else
                                                    <i class="fas fa-user-circle text-yellow-500 text-xl"></i>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $ibuHamil->ibu->nama }}</div>
                                                <div class="text-sm text-gray-500">{{ $ibuHamil->ibu->nik ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $ibuHamil->ibu->kelurahan->nama_kelurahan ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $ibuHamil->ibu->kecamatan->nama_kecamatan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $ibuHamil->usia_kehamilan }} minggu
                                        </div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $ibuHamil->trimester === 'Trimester 1' ? 'trimester-1' : 
                                                   ($ibuHamil->trimester === 'Trimester 2' ? 'trimester-2' : 'trimester-3') }}">
                                                <i class="fas fa-baby mr-1 text-xs"></i>
                                                {{ $ibuHamil->trimester }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $ibuHamil->warna_status_gizi == 'Sehat' ? 'status-sehat' : 
                                                   ($ibuHamil->warna_status_gizi == 'Waspada' ? 'status-waspada' : 'status-berisiko') }}">
                                                <i class="fas fa-heartbeat mr-1 text-xs"></i>
                                                {{ $ibuHamil->status_gizi }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            <i class="fas fa-stethoscope mr-1 text-xs"></i>
                                            {{ $ibuHamil->intervensi }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="flex items-center text-gray-600 mb-1">
                                                <i class="fas fa-weight text-blue-500 mr-2 text-xs"></i>
                                                {{ $ibuHamil->berat }} kg
                                            </div>
                                            <div class="flex items-center text-gray-600 mb-1">
                                                <i class="fas fa-ruler text-green-500 mr-2 text-xs"></i>
                                                {{ $ibuHamil->tinggi }} cm
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-calculator text-purple-500 mr-2 text-xs"></i>
                                                IMT: {{ $ibuHamil->imt ?? '-' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('kelurahan.ibu_hamil.edit', $ibuHamil->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50 delete-btn"
                                                    data-id="{{ $ibuHamil->id }}" 
                                                    data-name="{{ $ibuHamil->ibu->nama }}"
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
                <div class="px-6 py-4 border-t bg-gray-50">
                    {{ $ibuHamils->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="max-w-4xl max-h-full p-4">
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="p-4 bg-gray-100 flex justify-between items-center">
                    <h3 id="modalTitle" class="text-lg font-semibold"></h3>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-4 flex justify-center">
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-96 object-contain">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delete confirmation dengan SweetAlert2 yang lebih modern
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const url = '{{ route("kelurahan.ibu_hamil.destroy", ":id") }}'.replace(':id', id);
                
                Swal.fire({
                    title: 'Hapus Data Ibu Hamil?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Ibu Hamil: <strong>${name}</strong></p>
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
                                    text: 'Data ibu hamil berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data ibu hamil.';
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

            // Image modal functionality
            window.showImageModal = function(src, name) {
                document.getElementById('modalImage').src = src;
                document.getElementById('modalTitle').textContent = 'Foto: ' + name;
                document.getElementById('imageModal').classList.remove('hidden');
            };

            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('imageModal').classList.add('hidden');
            });

            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });

        // Fungsi untuk menghapus filter individual
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }
    </script>
</body>
</html>