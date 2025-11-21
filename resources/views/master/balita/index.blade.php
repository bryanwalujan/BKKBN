<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Balita - Master Panel</title>
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
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        .status-gizi-baik { background-color: #10b981; color: white; }
        .status-gizi-kurang { background-color: #f59e0b; color: white; }
        .status-gizi-buruk { background-color: #ef4444; color: white; }
        .status-gizi-lebih { background-color: #8b5cf6; color: white; }
        .baduata-label { background-color: #3b82f6; color: white; }
        .balita-label { background-color: #8b5cf6; color: white; }
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
                            <i class="fas fa-baby text-blue-600 mr-3"></i>
                            Kelola Balita
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen data balita dan status gizi</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-database mr-1"></i>
                            Total: {{ $balitas->total() }} Data
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
                            <p class="text-sm font-medium text-gray-600">Total Balita</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $balitas->total() }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-baby text-blue-500 text-xl"></i>
                        </div>
                    </div>
                </div>

          <!-- Baduata (0-24 bulan) -->
<div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">Baduata (0-24 bln)</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBaduata }}</p>
        </div>
        <div class="p-3 bg-indigo-50 rounded-lg">
            <i class="fas fa-child text-indigo-500 text-xl"></i>
        </div>
    </div>
</div>

<!-- Balita (25-60 bulan) -->
<div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600">Balita (25-60 bln)</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBalita }}</p>
        </div>
        <div class="p-3 bg-purple-50 rounded-lg">
            <i class="fas fa-child text-purple-500 text-xl"></i>
        </div>
    </div>
</div>

                <a href="{{ route('balita.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 card-hover group cursor-pointer">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <p class="text-sm font-medium opacity-90">Tambah Baru</p>
                            <p class="text-lg font-bold mt-1 group-hover:translate-x-1 transition-transform">Data Balita</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-lg group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus text-xl"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                    Aksi Cepat
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('balita.downloadTemplate') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Download Template Excel
                    </a>
                    <form action="{{ route('balita.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                        @csrf
                        <label class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center cursor-pointer">
                            <i class="fas fa-upload mr-2"></i>
                            Import Excel
                            <input type="file" name="file" accept=".xlsx,.xls" class="hidden" id="fileInput" onchange="this.form.submit()">
                        </label>
                    </form>
                    <a href="{{ route('peta_geospasial.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-map-marked-alt mr-2"></i>
                        Lihat Peta Geospasial
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-filter text-blue-500 mr-2"></i>
                        Filter Data
                    </h3>
                    @if ($kecamatan_id || $kelurahan_id || $kategoriUmur || $search)
                        <a href="{{ route('balita.index') }}" class="text-sm text-gray-600 hover:text-gray-800 flex items-center">
                            <i class="fas fa-refresh mr-1"></i>
                            Reset Filter
                        </a>
                    @endif
                </div>

                <form action="{{ route('balita.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i>
                            Kecamatan
                        </label>
                        <select name="kecamatan_id" id="kecamatan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                            <option value="">Semua Kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                    {{ $kecamatan->nama_kecamatan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-pin mr-1 text-green-500"></i>
                            Kelurahan
                        </label>
                        <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                            <option value="">Semua Kelurahan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-child mr-1 text-purple-500"></i>
                            Kategori Umur
                        </label>
                        <select name="kategori_umur" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                            <option value="" {{ $kategoriUmur == '' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="Baduata" {{ $kategoriUmur == 'Baduata' ? 'selected' : '' }}>Baduata (0-24 bulan)</option>
                            <option value="Balita" {{ $kategoriUmur == 'Balita' ? 'selected' : '' }}>Balita (25-60 bulan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1 text-purple-500"></i>
                            Pencarian
                        </label>
                        <input type="text" name="search" value="{{ $search ?? '' }}" 
                               placeholder="Cari Nama atau NIK..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                    </div>

                    <div class="lg:col-span-4 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-filter mr-2"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>

                <!-- Filter Info -->
                @if ($kecamatan_id || $kelurahan_id || $kategoriUmur || $search)
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center text-blue-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span class="font-medium">Filter Aktif:</span>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @if ($kecamatan_id)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Kecamatan: {{ $kecamatans->find($kecamatan_id)->nama_kecamatan ?? '-' }}
                                    <button onclick="removeFilter('kecamatan_id')" class="ml-1 hover:text-blue-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            @endif
                            @if ($kelurahan_id)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Kelurahan: {{ \App\Models\Kelurahan::find($kelurahan_id)->nama_kelurahan ?? '-' }}
                                    <button onclick="removeFilter('kelurahan_id')" class="ml-1 hover:text-green-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            @endif
                            @if ($kategoriUmur)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Kategori: {{ $kategoriUmur }}
                                    <button onclick="removeFilter('kategori_umur')" class="ml-1 hover:text-purple-600">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </span>
                            @endif
                            @if ($search)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Pencarian: "{{ $search }}"
                                    <button onclick="removeFilter('search')" class="ml-1 hover:text-purple-600">
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
                        Data Balita
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
                                        <i class="fas fa-child mr-2"></i>
                                        Usia & Kategori
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-weight mr-2"></i>
                                        Pengukuran
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-chart-pie mr-2"></i>
                                        Status Gizi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-image mr-2"></i>
                                        Foto
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
                            @forelse ($balitas as $index => $balita)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $balitas->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-baby text-blue-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $balita->nama }}</div>
                                                <div class="text-sm text-gray-500">{{ $balita->nik ?? '-' }}</div>
                                                <div class="text-xs text-gray-400 mt-1">KK: {{ $balita->kartuKeluarga->no_kk ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $balita->kecamatan->nama_kecamatan ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $balita->kelurahan->nama_kelurahan ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $balita->usia !== null ? $balita->usia . ' bulan' : '-' }}
                                        </div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $balita->kategoriUmur === 'Baduata' ? 'baduata-label' : 'balita-label' }}">
                                                <i class="fas fa-tag mr-1 text-xs"></i>
                                                {{ $balita->kategoriUmur }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="flex items-center text-gray-600 mb-1">
                                                <i class="fas fa-weight text-blue-500 mr-2 text-xs"></i>
                                                {{ $balita->berat_tinggi ?? '-' }}
                                            </div>
                                            <div class="flex items-center text-gray-600 mb-1">
                                                <i class="fas fa-ruler text-green-500 mr-2 text-xs"></i>
                                                {{ $balita->lingkar_kepala ? $balita->lingkar_kepala . ' cm' : '-' }}
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-ruler-vertical text-purple-500 mr-2 text-xs"></i>
                                                {{ $balita->lingkar_lengan ? $balita->lingkar_lengan . ' cm' : '-' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $balita->status_gizi }}</div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $balita->status_gizi === 'Gizi Baik' ? 'status-gizi-baik' : 
                                                   ($balita->status_gizi === 'Gizi Kurang' ? 'status-gizi-kurang' : 
                                                   ($balita->status_gizi === 'Gizi Buruk' ? 'status-gizi-buruk' : 'status-gizi-lebih')) }}">
                                                <i class="fas fa-chart-bar mr-1 text-xs"></i>
                                                {{ $balita->warna_label }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($balita->foto)
                                            <img src="{{ Storage::url($balita->foto) }}" alt="Foto {{ $balita->nama }}" 
                                                 class="w-16 h-16 object-cover rounded-lg shadow-sm cursor-pointer" 
                                                 onclick="showImageModal('{{ Storage::url($balita->foto) }}', '{{ $balita->nama }}')">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                                <i class="fas fa-camera text-xl"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $balita->createdBy->name ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ $balita->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            @if ($balita->kartu_keluarga_id)
                                                <a href="{{ route('kartu_keluarga.show', $balita->kartu_keluarga_id) }}" 
                                                   class="text-green-600 hover:text-green-900 transition-colors p-2 rounded-lg hover:bg-green-50"
                                                   title="Detail Kartu Keluarga">
                                                    <i class="fas fa-address-card"></i>
                                                </a>
                                            @else
                                                <span class="text-gray-400 p-2" title="Tidak ada KK">
                                                    <i class="fas fa-address-card"></i>
                                                </span>
                                            @endif
                                            <a href="{{ route('balita.edit', $balita->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-lg hover:bg-blue-50"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-lg hover:bg-red-50 delete-btn"
                                                    data-id="{{ $balita->id }}" 
                                                    data-name="{{ $balita->nama }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
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
                @if ($balitas->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">
                        {{ $balitas->links() }}
                    </div>
                @endif
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 dengan styling yang lebih baik
            $('#kecamatan_id').select2({
                placeholder: 'Pilih Kecamatan',
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });

            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });

            // Load kelurahans for selected kecamatan on page load
            var initialKecamatanId = '{{ $kecamatan_id ?? '' }}';
            if (initialKecamatanId) {
                loadKelurahans(initialKecamatanId);
            }

            // Update kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    loadKelurahans(kecamatanId);
                } else {
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">Semua Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
            });

            function loadKelurahans(kecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
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
                            confirmButtonColor: '#3b82f6',
                        });
                    }
                });
            }

            // Delete confirmation dengan SweetAlert2 yang lebih modern
            $('.delete-btn').on('click', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const url = '{{ route("balita.destroy", ":id") }}'.replace(':id', id);
                
                Swal.fire({
                    title: 'Hapus Data Balita?',
                    html: `<div class="text-center">
                             <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menghapus?</p>
                             <p class="text-gray-600 mt-2">Balita: <strong>${name}</strong></p>
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
                                    text: 'Data balita berhasil dihapus.',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Oke',
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menghapus data balita.';
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