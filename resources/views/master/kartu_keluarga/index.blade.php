<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kartu Keluarga - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
            transform: translateY(-3px);
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
            transform: scale(1.005);
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
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
        
        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            color: #4b5563;
            text-decoration: none;
        }
        
        .pagination .page-link:hover {
            background-color: #f3f4f6;
        }
        
        .pagination .active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola <span class="gradient-text">Kartu Keluarga</span></h1>
                    <p class="text-gray-600">Kelola data kartu keluarga dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('kartu_keluarga.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Kartu Keluarga
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Kartu Keluarga</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->total() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-address-card text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-database mr-1"></i>
                    <span>Data terbaru</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dengan Balita</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('balitas_count', '>', 0)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-baby text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-child mr-1"></i>
                    <span>Keluarga dengan balita</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kartuKeluargas->where('status', 'Aktif')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-user-check mr-1"></i>
                    <span>Kartu keluarga aktif</span>
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
        
        <!-- Filter dan Pencarian -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Filter Data</h3>
                    <p class="text-gray-600 text-sm mt-1">Saring data kartu keluarga berdasarkan kriteria tertentu</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-filter mr-2 text-blue-500"></i>
                    <span>Filter data</span>
                </div>
            </div>
            
            <form action="{{ route('kartu_keluarga.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                        <option value="">Semua Kelurahan</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari No KK atau Kepala Keluarga" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2 h-10">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    @if ($kecamatan_id || $kelurahan_id || $search)
                        <a href="{{ route('kartu_keluarga.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center gap-2 h-10">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
            
            @if ($kecamatan_id || $kelurahan_id || $search)
                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan data
                        @if ($kecamatan_id)
                            untuk kecamatan: <span class="font-semibold">{{ $kecamatans->find($kecamatan_id)->nama_kecamatan ?? '-' }}</span>
                        @endif
                        @if ($kelurahan_id)
                            dan kelurahan: <span class="font-semibold">{{ \App\Models\Kelurahan::find($kelurahan_id)->nama_kelurahan ?? '-' }}</span>
                        @endif
                        @if ($search)
                            dengan pencarian: <span class="font-semibold">"{{ $search }}"</span>
                        @endif
                        ({{ $kartuKeluargas->total() }} data ditemukan)
                    </p>
                </div>
            @else
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Menampilkan semua data kartu keluarga ({{ $kartuKeluargas->total() }} data)
                    </p>
                </div>
            @endif
        </div>
        
        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Kartu Keluarga</h3>
                        <p class="text-gray-600 text-sm mt-1">Daftar lengkap kartu keluarga dalam sistem</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Halaman {{ $kartuKeluargas->currentPage() }} dari {{ $kartuKeluargas->lastPage() }}
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No KK</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kepala Keluarga</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kecamatan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Alamat</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Jumlah Balita</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($kartuKeluargas as $index => $kartuKeluarga)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $kartuKeluargas->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <a href="{{ route('kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                        <i class="fas fa-id-card text-blue-400"></i>
                                        {{ $kartuKeluarga->no_kk }}
                                    </a>
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-gray-800 hover:text-blue-600 font-medium">
                                        {{ $kartuKeluarga->kepala_keluarga }}
                                    </a>
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $kartuKeluarga->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700 max-w-xs truncate">{{ $kartuKeluarga->alamat ?? '-' }}</td>
                                <td class="p-4">
                                    @if($kartuKeluarga->status == 'Aktif')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center">
                                        @if($kartuKeluarga->balitas_count > 0)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full flex items-center">
                                                <i class="fas fa-baby mr-1"></i> {{ $kartuKeluarga->balitas_count }}
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                -
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kartu_keluarga.edit', $kartuKeluarga->id) }}" class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 delete-btn" 
                                                data-url="{{ route('kartu_keluarga.destroy', $kartuKeluarga->id) }}" 
                                                data-name="{{ $kartuKeluarga->no_kk }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data kartu keluarga yang sesuai dengan filter.</p>
                                        @if ($kecamatan_id || $kelurahan_id || $search)
                                            <a href="{{ route('kartu_keluarga.index') }}" class="text-blue-500 hover:text-blue-700 mt-2 flex items-center">
                                                <i class="fas fa-undo mr-2"></i> Tampilkan semua data
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($kartuKeluargas->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $kartuKeluargas->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: 'Semua Kecamatan',
                allowClear: true
            });

            $('#kelurahan_id').select2({
                placeholder: 'Semua Kelurahan',
                allowClear: true
            });

            // Load kelurahans for selected kecamatan on page load
            var initialKecamatanId = '{{ $kecamatan_id ?? '' }}';
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty();
                        $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == '{{ $kelurahan_id ?? '' }}' ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6'
                        });
                    }
                });
            }

            // Update kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kelurahan_id').empty();
                            $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
            });

            // Handle delete button click with SweetAlert2
            $('.delete-btn').on('click', function() {
                var url = $(this).data('url');
                var name = $(this).data('name');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: `Apakah Anda yakin ingin menghapus kartu keluarga ${name}? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-trash mr-2"></i>Hapus',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Kartu keluarga berhasil dihapus!',
                                    confirmButtonColor: '#3b82f6'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.error('Error deleting data:', xhr);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menghapus kartu keluarga. Silakan coba lagi.',
                                    confirmButtonColor: '#3b82f6'
                                });
                            }
                        });
                    }
                });
            });

            // Handle session messages with SweetAlert2
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3b82f6'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3b82f6'
                });
            @endif
        });
    </script>
</body>
</html>