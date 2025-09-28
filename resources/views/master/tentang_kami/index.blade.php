<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .image-container img {
            transition: transform 0.3s ease;
        }
        
        .image-container:hover img {
            transform: scale(1.05);
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.3));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .image-container:hover .image-overlay {
            opacity: 1;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #3b82f6, #10b981);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(90deg, #6b7280, #9ca3af);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(107, 114, 128, 0.4);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tentang Kami <span class="gradient-text">CSSR</span></h1>
            <p class="text-gray-600">Kelola informasi tentang sistem CSSR dan organisasi Anda.</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
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
        
        @if ($tentangKami)
            <!-- Konten Tentang Kami -->
            <div class="bg-white p-8 rounded-xl shadow-sm card-hover mb-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $tentangKami->judul_utama }}</h2>
                        <p class="text-lg text-blue-600 font-medium">{{ $tentangKami->sub_judul }}</p>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        <i class="fas fa-clock mr-1"></i>
                        <span>Terakhir diperbarui: {{ $tentangKami->tanggal_update->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Teks Konten -->
                    <div class="space-y-6">
                        <div class="bg-blue-50 p-5 rounded-lg border-l-4 border-blue-500">
                            <p class="text-gray-700 leading-relaxed">{{ $tentangKami->paragraf_1 }}</p>
                        </div>
                        
                        @if ($tentangKami->paragraf_2)
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="text-gray-700 leading-relaxed">{{ $tentangKami->paragraf_2 }}</p>
                            </div>
                        @endif
                        
                        @if ($tentangKami->teks_tombol && $tentangKami->link_tombol)
                            <div class="mt-4">
                                <a href="{{ $tentangKami->link_tombol }}" 
                                   class="btn-primary text-white px-6 py-3 rounded-lg inline-flex items-center gap-2 font-medium">
                                    <i class="fas fa-external-link-alt"></i>
                                    {{ $tentangKami->teks_tombol }}
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Gambar -->
                    <div class="space-y-6">
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $tentangKami->gambar_utama) }}" 
                                 alt="Gambar Utama" 
                                 class="w-full h-64 object-cover">
                            <div class="image-overlay">
                                <span>Gambar Utama</span>
                            </div>
                        </div>
                        
                        @if ($tentangKami->gambar_overlay)
                            <div class="image-container">
                                <img src="{{ asset('storage/' . $tentangKami->gambar_overlay) }}" 
                                     alt="Gambar Overlay" 
                                     class="w-full h-64 object-cover">
                                <div class="image-overlay">
                                    <span>Gambar Tambahan</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('tentang_kami.create') }}" 
                       class="btn-primary text-white px-6 py-3 rounded-lg inline-flex items-center gap-2 font-medium">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Tentang Kami
                    </a>
                    <a href="{{ route('tentang_kami.edit') }}" 
                       class="btn-primary text-white px-6 py-3 rounded-lg inline-flex items-center gap-2 font-medium">
                        <i class="fas fa-edit"></i>
                        Edit Tentang Kami
                    </a>
                </div>
            </div>
        @else
            <!-- State Kosong -->
            <div class="bg-white p-8 rounded-xl shadow-sm text-center card-hover">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-info-circle text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-3">Belum Ada Data Tentang Kami</h3>
                    <p class="text-gray-600 mb-6">Anda belum menambahkan informasi tentang CSSR. Mulai dengan membuat konten tentang kami untuk memberikan informasi kepada pengguna.</p>
                    <a href="{{ route('tentang_kami.create') }}" 
                       class="btn-primary text-white px-6 py-3 rounded-lg inline-flex items-center gap-2 font-medium">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Tentang Kami
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>
</body>
</html>