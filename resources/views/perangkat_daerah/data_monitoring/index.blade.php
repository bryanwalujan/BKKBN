<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring - Perangkat Daerah</title>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
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
        .badge-hijau { background-color: #10b981; color: white; }
        .badge-kuning { background-color: #f59e0b; color: white; }
        .badge-merah { background-color: #ef4444; color: white; }
        .badge-biru { background-color: #3b82f6; color: white; }
        .status-ya { background-color: #10b981; color: white; }
        .status-tidak { background-color: #6b7280; color: white; }
        .bg-gradient-header {
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    @include('perangkat_daerah.partials.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-header shadow-sm">
            <div class="px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-red flex items-center">
                            <i class="fas fa-chart-line text-black-200 mr-3"></i>
                            Data Monitoring - Perangkat Daerah
                        </h1>
                        <p class="text-black-100 mt-1">Monitoring dan evaluasi data balita di wilayah Anda</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-blue-100 bg-blue-700 bg-opacity-50 px-3 py-1 rounded-full">
                            <i class="fas fa-database mr-1"></i>
                            Total: {{ $dataMonitorings->total() }} Data
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

            <!-- Info Kecamatan -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg mr-4">
                        <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Wilayah Kerja</h3>
                        <p class="text-gray-600">Kecamatan: <span class="font-medium text-blue-600">{{ $kecamatan->nama_kecamatan ?? '-' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Action Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Monitoring</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $dataMonitorings->total() }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-chart-line text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Hijau</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $dataMonitorings->where('warna_badge', 'Hijau')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Kuning</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $dataMonitorings->where('warna_badge', 'Kuning')->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <a href="{{ route('perangkat_daerah.data_monitoring.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm p-6 card-hover group cursor-pointer">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-medium opacity-90">Tambah Baru</p>
                            <p class="text-lg font-bold mt-1 group-hover:translate-x-1 transition-transform">Data Monitoring</p>
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
                    @if ($kelurahan_id || $kategori || $warna_badge)
                        <a href="{{ route('perangkat_daerah.data_monitoring.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form action="{{ route('perangkat_daerah.data_monitoring.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-pin mr-1 text-green-500"></i>
                            Kelurahan
                        </label>
                        <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                            <option value="">Semua Kelurahan</option>
                            @foreach ($kelurahans as $kelurahan)
                                <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>
                                    {{ $kelurahan->nama_kelurahan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-purple-500"></i>
                            Kategori
                        </label>
                        <select name="kategori" id="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoriOptions as $kategoriOption)
                                <option value="{{ $kategoriOption }}" {{ $kategori == $kategoriOption ? 'selected' : '' }}>
                                    {{ $kategoriOption }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-palette mr-1 text-yellow-500"></i>
                            Warna Badge
                        </label>
                        <select name="warna_badge" id="warna_badge" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                            <option value="">Semua Warna</option>
                            @foreach ($warnaBadgeOptions as $warna)
                                <option value="{{ $warna }}" {{ $warna_badge == $warna ? 'selected' : '' }}>
                                    {{ $warna }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="lg:col-span-4 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>

                <!-- Filter Info -->
                @if ($kelurahan_id || $kategori || $warna_badge)
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Filter Aktif:</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @if ($kelurahan_id)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Kelurahan: {{ \App\Models\Kelurahan::find($kelurahan_id)->nama_kelurahan ?? '-' }}
                                    <button onclick="removeFilter('kelurahan_id')" class="ml-1 hover:text-green-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            @endif
                            @if ($kategori)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Kategori: {{ $kategori }}
                                    <button onclick="removeFilter('kategori')" class="ml-1 hover:text-purple-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            @endif
                            @if ($warna_badge)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Warna: {{ $warna_badge }}
                                    <button onclick="removeFilter('warna_badge')" class="ml-1 hover:text-yellow-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-table mr-2 text-blue-500"></i>
                        Data Monitoring
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
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
                                        <i class="fas fa-tag mr-2"></i>
                                        Kategori & Status
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Tanggal Monitoring
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-clipboard-check mr-2"></i>
                                        Intervensi
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
                                        <i class="fas fa-cogs mr-2"></i>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($dataMonitorings as $index => $dataMonitoring)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $dataMonitoring->nama }}</div>
                                                <div class="text-sm text-gray-500">{{ $dataMonitoring->target }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $dataMonitoring->kecamatan->nama_kecamatan ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $dataMonitoring->kelurahan->nama_kelurahan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $dataMonitoring->kategori }}</div>
                                        <div class="text-sm text-gray-500">{{ $dataMonitoring->status }}</div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $dataMonitoring->warna_badge == 'Hijau' ? 'badge-hijau' : 
                                                   ($dataMonitoring->warna_badge == 'Kuning' ? 'badge-kuning' : 
                                                   ($dataMonitoring->warna_badge == 'Merah' ? 'badge-merah' : 'badge-biru')) }}">
                                                <i class="fas fa-tag mr-1 text-xs"></i>
                                                {{ $dataMonitoring->warna_badge }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @if ($dataMonitoring->tanggal_monitoring)
                                                {{ $dataMonitoring->tanggal_monitoring->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="grid grid-cols-2 gap-1 text-xs">
                                            <div class="flex items-center">
                                                <i class="fas fa-smoking mr-1 text-gray-500"></i>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full font-medium 
                                                    {{ $dataMonitoring->terpapar_rokok ? 'status-ya' : 'status-tidak' }}">
                                                    {{ $dataMonitoring->terpapar_rokok ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-pills mr-1 text-gray-500"></i>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full font-medium 
                                                    {{ $dataMonitoring->suplemen_ttd ? 'status-ya' : 'status-tidak' }}">
                                                    {{ $dataMonitoring->suplemen_ttd ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-hospital mr-1 text-gray-500"></i>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full font-medium 
                                                    {{ $dataMonitoring->rujukan ? 'status-ya' : 'status-tidak' }}">
                                                    {{ $dataMonitoring->rujukan ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-hand-holding-heart mr-1 text-gray-500"></i>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full font-medium 
                                                    {{ $dataMonitoring->bantuan_sosial ? 'status-ya' : 'status-tidak' }}">
                                                    {{ $dataMonitoring->bantuan_sosial ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-home mr-1 text-gray-500"></i>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full font-medium 
                                                    {{ $dataMonitoring->posyandu_bkb ? 'status-ya' : 'status-tidak' }}">
                                                    {{ $dataMonitoring->posyandu_bkb ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-comments mr-1 text-gray-500"></i>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full font-medium 
                                                    {{ $dataMonitoring->kie ? 'status-ya' : 'status-tidak' }}">
                                                    {{ $dataMonitoring->kie ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($dataMonitoring->kartuKeluarga)
                                            <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $dataMonitoring->kartuKeluarga->id) }}" 
                                               class="inline-flex items-center text-blue-600 hover:text-blue-900 transition-colors px-3 py-1 rounded-lg hover:bg-blue-50"
                                               title="Detail Kartu Keluarga">
                                                <i class="fas fa-address-card mr-2"></i>
                                                Lihat KK
                                            </a>
                                        @else
                                            <span class="inline-flex items-center text-gray-400 px-3 py-1" title="Tidak ada KK">
                                                <i class="fas fa-address-card mr-2"></i>
                                                Tidak Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('perangkat_daerah.data_monitoring.edit', $dataMonitoring->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50 delete-btn"
                                                    data-id="{{ $dataMonitoring->id }}" 
                                                    data-name="{{ $dataMonitoring->nama }}"
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
                @if ($dataMonitorings->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $dataMonitorings->links() }}
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

            $('#kategori').select2({
                placeholder: 'Pilih Kategori',
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });

            $('#warna_badge').select2({
                placeholder: 'Pilih Warna Badge',
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });

            // Delete confirmation dengan SweetAlert2 yang lebih modern
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const url = '{{ route("perangkat_daerah.data_monitoring.destroy", ":id") }}'.replace(':id', id);
                
                Swal.fire({
                    title: 'Hapus Data Monitoring?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Monitoring: <strong>${name}</strong></p>
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
                                    text: 'Data monitoring berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data monitoring.';
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