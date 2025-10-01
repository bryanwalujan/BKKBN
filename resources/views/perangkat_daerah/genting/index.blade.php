<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kegiatan Genting - Perangkat Daerah</title>
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
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6;
        }
        
        .tab-hover {
            transition: all 0.2s ease;
        }
        
        .tab-hover:hover {
            background-color: #f8fafc;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .status-verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .table-row-hover {
            transition: background-color 0.2s ease;
        }
        
        .table-row-hover:hover {
            background-color: #f8fafc;
        }
        
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 12px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('perangkat_daerah.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Kegiatan Genting</h1>
                    <p class="text-gray-600">Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan }}</p>
                </div>
                <a href="{{ route('perangkat_daerah.genting.create') }}" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex items-center shadow-md">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Tambah Kegiatan Genting
                </a>
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
        
        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-sm mb-8 card-hover">
            <!-- Tabs -->
            <div class="flex border-b border-gray-200">
                <a href="{{ route('perangkat_daerah.genting.index', ['tab' => 'pending', 'search' => $search]) }}"
                   class="flex-1 py-4 px-6 text-center tab-hover {{ $tab === 'pending' ? 'border-b-2 border-red-500 text-red-600 font-semibold' : 'text-gray-500' }}">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-clock mr-2"></i>
                        <span>Pending Verifikasi</span>
                        @if($tab === 'pending')
                            <span class="ml-2 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">{{ $gentings->total() }}</span>
                        @endif
                    </div>
                </a>
                <a href="{{ route('perangkat_daerah.genting.index', ['tab' => 'verified', 'search' => $search]) }}"
                   class="flex-1 py-4 px-6 text-center tab-hover {{ $tab === 'verified' ? 'border-b-2 border-green-500 text-green-600 font-semibold' : 'text-gray-500' }}">
                    <div class="flex items-center justify-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Terverifikasi</span>
                        @if($tab === 'verified')
                            <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ $gentings->total() }}</span>
                        @endif
                    </div>
                </a>
            </div>
            
            <!-- Filter Section -->
            <div class="p-6 border-b border-gray-100">
                <form method="GET" action="{{ route('perangkat_daerah.genting.index') }}" class="flex items-center space-x-4">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" 
                               placeholder="Cari nama kegiatan, lokasi, atau sasaran..." 
                               class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                    @if($search)
                        <a href="{{ route('perangkat_daerah.genting.index', ['tab' => $tab]) }}" 
                           class="text-gray-500 hover:text-gray-700 flex items-center">
                            <i class="fas fa-times mr-1"></i> Reset
                        </a>
                    @endif
                </form>
            </div>
            
            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">No</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Kegiatan</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Tanggal & Lokasi</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Sasaran & Intervensi</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Dokumentasi</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($gentings as $index => $genting)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $gentings->firstItem() + $index }}</td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-900">{{ $genting->nama_kegiatan }}</span>
                                        @if ($genting->kartuKeluarga)
                                            <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $genting->kartuKeluarga->id) }}" 
                                               class="text-blue-500 hover:underline text-sm mt-1 flex items-center">
                                                <i class="fas fa-link mr-1 text-xs"></i>
                                                {{ $genting->kartuKeluarga->no_kk }} - {{ $genting->kartuKeluarga->kepala_keluarga }}
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <div class="flex items-center text-sm text-gray-600 mb-1">
                                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                            <span>{{ \Carbon\Carbon::parse($genting->tanggal)->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                                            <span>{{ $genting->lokasi }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm text-gray-700 mb-1">{{ $genting->sasaran }}</span>
                                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full inline-block">{{ $genting->jenis_intervensi }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    @if ($genting->dokumentasi)
                                        <button onclick="openModal('{{ Storage::url($genting->dokumentasi) }}')" 
                                                class="text-blue-500 hover:text-blue-700 flex items-center text-sm">
                                            <i class="fas fa-image mr-1"></i>
                                            Lihat Gambar
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm flex items-center">
                                            <i class="fas fa-ban mr-1"></i>
                                            Tidak ada
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="status-badge {{ $genting->source === 'pending' ? 'status-pending' : 'status-verified' }}">
                                        <i class="fas {{ $genting->source === 'pending' ? 'fa-clock' : 'fa-check-circle' }} mr-1"></i>
                                        {{ $genting->source === 'pending' ? 'Pending' : 'Terverifikasi' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('perangkat_daerah.genting.edit', ['id' => $genting->id, 'source' => $genting->source]) }}" 
                                           class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50 transition" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if ($genting->source === 'pending')
                                            <form action="{{ route('perangkat_daerah.genting.destroy', ['id' => $genting->id, 'source' => 'pending']) }}" 
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition" 
                                                        title="Hapus"
                                                        onclick="return confirmDelete()">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <button onclick="showDetails({{ json_encode($genting) }})" 
                                                class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50 transition" 
                                                title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                        <p class="text-lg">Tidak ada data kegiatan genting</p>
                                        <p class="text-sm mt-2">Silakan tambah data kegiatan genting baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($gentings->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $gentings->links() }}
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <!-- Modal for Image -->
    <div id="imageModal" class="modal-overlay">
        <div class="modal-content">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Dokumentasi Kegiatan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 flex justify-center">
                <img id="modalImage" src="" alt="Dokumentasi Kegiatan" class="max-w-full max-h-96 object-contain">
            </div>
        </div>
    </div>

    <!-- Modal for Details -->
    <div id="detailsModal" class="modal-overlay">
        <div class="modal-content w-full max-w-4xl">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Detail Kegiatan Genting</h3>
                <button onclick="closeDetailsModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <div id="detailsContent"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        function openModal(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        
        function showDetails(genting) {
            let pihakKetigaHtml = '';
            if (genting.dunia_usaha === 'ada' || genting.pemerintah === 'ada' || 
                genting.bumn_bumd === 'ada' || genting.individu_perseorangan === 'ada' || 
                genting.lsm_komunitas === 'ada' || genting.swasta === 'ada' || 
                genting.perguruan_tinggi_akademisi === 'ada' || genting.media === 'ada' || 
                genting.tim_pendamping_keluarga === 'ada' || genting.tokoh_masyarakat === 'ada') {
                
                pihakKetigaHtml = '<div class="mb-4"><h4 class="font-semibold text-gray-700 mb-2">Pihak Ketiga Terlibat:</h4><ul class="list-disc pl-5 space-y-1">';
                
                if (genting.dunia_usaha === 'ada') {
                    pihakKetigaHtml += `<li>Dunia Usaha: ${genting.dunia_usaha_frekuensi}</li>`;
                }
                if (genting.pemerintah === 'ada') {
                    pihakKetigaHtml += `<li>Pemerintah: ${genting.pemerintah_frekuensi}</li>`;
                }
                if (genting.bumn_bumd === 'ada') {
                    pihakKetigaHtml += `<li>BUMN dan BUMD: ${genting.bumn_bumd_frekuensi}</li>`;
                }
                if (genting.individu_perseorangan === 'ada') {
                    pihakKetigaHtml += `<li>Individu dan Perseorangan: ${genting.individu_perseorangan_frekuensi}</li>`;
                }
                if (genting.lsm_komunitas === 'ada') {
                    pihakKetigaHtml += `<li>LSM dan Komunitas: ${genting.lsm_komunitas_frekuensi}</li>`;
                }
                if (genting.swasta === 'ada') {
                    pihakKetigaHtml += `<li>Swasta: ${genting.swasta_frekuensi}</li>`;
                }
                if (genting.perguruan_tinggi_akademisi === 'ada') {
                    pihakKetigaHtml += `<li>Perguruan Tinggi dan Akademisi: ${genting.perguruan_tinggi_akademisi_frekuensi}</li>`;
                }
                if (genting.media === 'ada') {
                    pihakKetigaHtml += `<li>Media: ${genting.media_frekuensi}</li>`;
                }
                if (genting.tim_pendamping_keluarga === 'ada') {
                    pihakKetigaHtml += `<li>Tim Pendamping Keluarga: ${genting.tim_pendamping_keluarga_frekuensi}</li>`;
                }
                if (genting.tokoh_masyarakat === 'ada') {
                    pihakKetigaHtml += `<li>Tokoh Masyarakat: ${genting.tokoh_masyarakat_frekuensi}</li>`;
                }
                
                pihakKetigaHtml += '</ul></div>';
            } else {
                pihakKetigaHtml = '<p class="text-gray-500 mb-4">Tidak ada pihak ketiga yang terlibat.</p>';
            }
            
            const detailsHtml = `
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700">Nama Kegiatan</h4>
                            <p class="text-gray-900">${genting.nama_kegiatan}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700">Tanggal</h4>
                            <p class="text-gray-900">${new Date(genting.tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700">Lokasi</h4>
                        <p class="text-gray-900">${genting.lokasi}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-700">Sasaran</h4>
                            <p class="text-gray-900">${genting.sasaran}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-700">Jenis Intervensi</h4>
                            <p class="text-gray-900">${genting.jenis_intervensi}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700">Narasi Kegiatan</h4>
                        <p class="text-gray-900">${genting.narasi || '-'}</p>
                    </div>
                    ${pihakKetigaHtml}
                    <div>
                        <h4 class="font-semibold text-gray-700">Status</h4>
                        <span class="status-badge ${genting.source === 'pending' ? 'status-pending' : 'status-verified'}">
                            <i class="fas ${genting.source === 'pending' ? 'fa-clock' : 'fa-check-circle'} mr-1"></i>
                            ${genting.source === 'pending' ? 'Pending Verifikasi' : 'Terverifikasi'}
                        </span>
                    </div>
                </div>
            `;
            
            document.getElementById('detailsContent').innerHTML = detailsHtml;
            document.getElementById('detailsModal').style.display = 'flex';
        }
        
        function closeDetailsModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }
        
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data kegiatan genting ini?');
        }
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            const imageModal = document.getElementById('imageModal');
            const detailsModal = document.getElementById('detailsModal');
            
            if (event.target === imageModal) {
                closeModal();
            }
            
            if (event.target === detailsModal) {
                closeDetailsModal();
            }
        }
        
        // Handle session messages with SweetAlert2
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3b82f6',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#3b82f6',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
</body>
</html>