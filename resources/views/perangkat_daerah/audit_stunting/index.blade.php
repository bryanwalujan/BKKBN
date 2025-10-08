<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Audit Stunting - Perangkat Daerah</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .badge-audit { 
            background-color: #059669; 
            color: white; 
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
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
                            <i class="fas fa-clipboard-check text-green-600 mr-3"></i>
                            Data Audit Stunting - Perangkat Daerah
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen dan monitoring data audit stunting wilayah Anda</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-database mr-1"></i>
                            Total: {{ $auditStuntings->total() }} Data
                        </span>
                        <span class="text-sm text-green-600 bg-green-50 px-3 py-1 rounded-full">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            Kecamatan: {{ $kecamatan->nama_kecamatan ?? '-' }}
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
                            <p class="text-sm font-medium text-gray-600">Total Audit</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $auditStuntings->total() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-clipboard-check text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Wilayah Anda</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $kecamatan->nama_kecamatan ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-map-marker-alt text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <a href="{{ route('perangkat_daerah.audit_stunting.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm p-6 card-hover group cursor-pointer">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-medium opacity-90">Tambah Baru</p>
                            <p class="text-lg font-bold mt-1 group-hover:translate-x-1 transition-transform">Data Audit</p>
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
                        <i class="fas fa-filter text-green-500 mr-2"></i>
                        Filter Data
                    </h3>
                    @if ($kelurahan_id)
                        <a href="{{ route('perangkat_daerah.audit_stunting.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form action="{{ route('perangkat_daerah.audit_stunting.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i>
                            Kecamatan
                        </label>
                        <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50 p-3" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-pin mr-1 text-green-500"></i>
                            Kelurahan
                        </label>
                        <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3">
                            <option value="">Semua Kelurahan</option>
                            @foreach ($kelurahans as $kelurahan)
                                <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>
                                    {{ $kelurahan->nama_kelurahan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>

                <!-- Filter Info -->
                @if ($kelurahan_id)
                    <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="flex items-center text-green-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Filter Aktif:</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Kelurahan: {{ $kelurahans->find($kelurahan_id)->nama_kelurahan ?? '-' }}
                                <button onclick="removeFilter('kelurahan_id')" class="ml-1 hover:text-green-600">
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
                            Data Audit Stunting
                        </h3>
                        <div class="text-sm text-gray-500">
                            Menampilkan {{ $auditStuntings->count() }} dari {{ $auditStuntings->total() }} data
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-2"></i>
                                        Subjek Audit
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-bullseye mr-2"></i>
                                        Target
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
                                        <i class="fas fa-user-tie mr-2"></i>
                                        Pihak Pengaudit
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        Ringkasan
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-check mr-2"></i>
                                        Pengaudit
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Tanggal
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
                            @forelse ($auditStuntings as $index => $audit)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-user-injured text-green-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $audit->dataMonitoring->nama ?? '-' }}</div>
                                                <div class="text-xs text-gray-500 mt-1">ID: {{ $audit->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $audit->dataMonitoring->target ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $audit->dataMonitoring->kecamatan->nama_kecamatan ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $audit->dataMonitoring->kelurahan->nama_kelurahan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $audit->pihak_pengaudit ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div class="mb-1">
                                                <span class="font-medium">Laporan:</span>
                                                <span class="text-gray-600">{{ $audit->laporan ? Str::limit($audit->laporan, 30) : '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium">Narasi:</span>
                                                <span class="text-gray-600">{{ $audit->narasi ? Str::limit($audit->narasi, 30) : '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $audit->user->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $audit->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $audit->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('perangkat_daerah.audit_stunting.edit', $audit->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50 delete-btn"
                                                    data-id="{{ $audit->id }}" 
                                                    data-name="{{ $audit->dataMonitoring->nama ?? 'Data Audit' }}"
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
                                            <p class="text-sm mt-1">Coba ubah filter atau tambahkan data baru</p>
                                            <a href="{{ route('perangkat_daerah.audit_stunting.create') }}" class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                                                <i class="fas fa-plus mr-2"></i>
                                                Tambah Data Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($auditStuntings->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $auditStuntings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 dengan styling yang lebih baik
            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });

            // Delete confirmation dengan SweetAlert2 yang lebih modern
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const url = '{{ route("perangkat_daerah.audit_stunting.destroy", ":id") }}'.replace(':id', id);
                
                Swal.fire({
                    title: 'Hapus Data Audit?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Data Audit: <strong>${name}</strong></p>
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
                                    text: 'Data audit berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data audit.';
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

        // Fungsi untuk menghapus filter individual
        function removeFilter(filterName) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filterName);
            window.location.href = url.toString();
        }
    </script>
</body>
</html>