<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendamping Keluarga - CSSR</title>
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
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border-left-color: #10b981;
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
            background: linear-gradient(90deg, #10b981, #3b82f6);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-text {
            background: linear-gradient(90deg, #10b981, #3b82f6);
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
        
        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 18px;
            border: 2px solid #d1d5db;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .avatar-placeholder:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .swal2-image {
            max-width: 100%;
            max-height: 500px;
            object-fit: contain;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .swal2-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 48px;
            border: 4px solid #d1d5db;
            margin: 0 auto;
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
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola <span class="gradient-text">Pendamping Keluarga</span></h1>
                    <p class="text-gray-600">Kelola data pendamping keluarga dalam sistem CSSR</p>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 mr-4 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                    </a>
                    <a href="{{ route('pendamping_keluarga.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition flex items-center gap-2 shadow-md">
                        <i class="fas fa-user-plus"></i>
                        Tambah Pendamping
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pendamping</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendampingKeluargas->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-green-500 text-xl"></i>
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
                        <p class="text-sm font-medium text-gray-500">Status Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendampingKeluargas->where('status', 'Aktif')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-user-check mr-1"></i>
                    <span>Pendamping aktif</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Berpengalaman</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            @php
                                $currentYear = date('Y');
                                $experiencedCount = $pendampingKeluargas->filter(function($pendamping) use ($currentYear) {
                                    return ($currentYear - $pendamping->tahun_bergabung) >= 3;
                                })->count();
                            @endphp
                            {{ $experiencedCount }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-award text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-star mr-1"></i>
                    <span>Lebih dari 3 tahun</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Peran Utama</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendampingKeluargas->where('peran', 'Pendamping Utama')->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-yellow-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-crown mr-1"></i>
                    <span>Pendamping utama</span>
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
        
        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden card-hover">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Data Pendamping Keluarga</h3>
                        <p class="text-gray-600 text-sm mt-1">Daftar lengkap pendamping keluarga dalam sistem</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Total {{ $pendampingKeluargas->count() }} data
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">No</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Foto</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Nama Pendamping</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Peran</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kecamatan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Kelurahan</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Tahun Bergabung</th>
                            <th class="p-4 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pendampingKeluargas as $index => $pendamping)
                            <tr class="table-row-hover">
                                <td class="p-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    @if ($pendamping->foto)
                                        <img src="{{ asset('storage/' . $pendamping->foto) }}" alt="Foto {{ $pendamping->nama }}" class="avatar view-photo" data-photo="{{ asset('storage/' . $pendamping->foto) }}" data-name="{{ $pendamping->nama }}">
                                    @else
                                        <div class="avatar-placeholder view-photo" data-photo="placeholder" data-name="{{ $pendamping->nama }}">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div>
                                        <a href="#" class="text-gray-800 hover:text-green-600 font-medium text-lg">
                                            {{ $pendamping->nama }}
                                        </a>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-id-card mr-1"></i>
                                            ID: {{ $pendamping->id }}
                                        </p>
                                    </div>
                                </td>
                                <td class="p-4">
                                    @if($pendamping->peran == 'Pendamping Utama')
                                        <span class="badge badge-info">
                                            <i class="fas fa-user-shield mr-1"></i> {{ $pendamping->peran }}
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-user mr-1"></i> {{ $pendamping->peran }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-700">{{ $pendamping->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4 text-sm text-gray-700">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4">
                                    @if($pendamping->status == 'Aktif')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle mr-1"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full flex items-center">
                                            <i class="fas fa-calendar-alt mr-1"></i> {{ $pendamping->tahun_bergabung }}
                                        </span>
                                        @php
                                            $yearsExperience = date('Y') - $pendamping->tahun_bergabung;
                                        @endphp
                                        @if($yearsExperience >= 3)
                                            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full flex items-center">
                                                <i class="fas fa-award mr-1"></i> {{ $yearsExperience }} tahun
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex space-x-2">
                                        @if ($pendamping->kartuKeluargas->isNotEmpty())
                                            <a href="{{ route('kartu_keluarga.show', $pendamping->kartuKeluargas->first()->id) }}" class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50" title="Detail Keluarga">
                                                <i class="fas fa-home"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-300 p-2" title="Tidak ada keluarga terdaftar">
                                                <i class="fas fa-home"></i>
                                            </span>
                                        @endif
                                        <a href="{{ route('pendamping_keluarga.edit', $pendamping->id) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 delete-btn" 
                                                data-url="{{ route('pendamping_keluarga.destroy', $pendamping->id) }}" 
                                                data-name="{{ $pendamping->nama }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-8 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-user-slash text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 text-lg">Tidak ada data pendamping keluarga.</p>
                                        <a href="{{ route('pendamping_keluarga.create') }}" class="text-green-500 hover:text-green-700 mt-2 flex items-center">
                                            <i class="fas fa-user-plus mr-2"></i> Tambah pendamping pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle photo click
            $('.view-photo').on('click', function() {
                var photo = $(this).data('photo');
                var name = $(this).data('name');

                if (photo === 'placeholder') {
                    Swal.fire({
                        title: `Foto ${name}`,
                        html: '<div class="swal2-placeholder"><i class="fas fa-user"></i></div><p class="mt-4 text-gray-600">Tidak ada foto tersedia</p>',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Tutup',
                        customClass: {
                            popup: 'swal2-image-popup'
                        }
                    });
                } else {
                    Swal.fire({
                        title: `Foto ${name}`,
                        imageUrl: photo,
                        imageAlt: `Foto ${name}`,
                        imageClass: 'swal2-image',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Tutup',
                        customClass: {
                            popup: 'swal2-image-popup'
                        }
                    });
                }
            });

            // Handle delete button click with SweetAlert2
            $('.delete-btn').on('click', function() {
                var url = $(this).data('url');
                var name = $(this).data('name');

                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: `Apakah Anda yakin ingin menghapus pendamping ${name}? Tindakan ini tidak dapat dibatalkan.`,
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
                                    text: 'Pendamping berhasil dihapus!',
                                    confirmButtonColor: '#10b981'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                console.error('Error deleting data:', xhr);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menghapus pendamping. Silakan coba lagi.',
                                    confirmButtonColor: '#10b981'
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
                    confirmButtonColor: '#10b981'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#10b981'
                });
            @endif
        });
    </script>
</body>
</html>