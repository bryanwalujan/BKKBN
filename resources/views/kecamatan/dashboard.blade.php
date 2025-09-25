<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Kecamatan - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
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
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-sehat {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .status-stunting {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .status-kurang-gizi {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-obesitas {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            overflow-x: auto;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }
        
        .table-container {
            max-height: 400px;
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
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('kecamatan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, <span class="gradient-text">{{ auth()->user()->name }}!</span></h1>
            <p class="text-gray-600">Dashboard ini memberikan gambaran lengkap tentang data stunting di wilayah {{ auth()->user()->kecamatan->nama_kecamatan ?? 'Kecamatan Anda' }}.</p>
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
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Data Balita Menunggu Verifikasi -->
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Data Balita Menunggu Verifikasi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\PendingBalita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status', 'pending')->count() }}
                        </h3>
                        <div class="mt-2">
                            <div class="progress-bar">
                                @php
                                    $pendingCount = \App\Models\PendingBalita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status', 'pending')->count();
                                    $totalCount = \App\Models\PendingBalita::where('kecamatan_id', auth()->user()->kecamatan_id)->count();
                                    $percentage = $totalCount > 0 ? ($pendingCount / $totalCount) * 100 : 0;
                                @endphp
                                <div class="progress-fill bg-yellow-500" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Pending: {{ $pendingCount }}</span>
                                <span>Total: {{ $totalCount }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-clock text-yellow-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('kecamatan.balita.index') }}" class="text-blue-500 text-sm font-medium hover:text-blue-700 transition flex items-center">
                        Lihat Data <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Total Balita Terverifikasi -->
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Balita Terverifikasi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->count() }}
                        </h3>
                        <div class="mt-2">
                            @php
                                $balitaCount = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->count();
                                $lastMonthCount = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)
                                    ->where('created_at', '>=', \Carbon\Carbon::now()->subMonth())
                                    ->count();
                                $growth = $lastMonthCount > 0 ? (($balitaCount - $lastMonthCount) / $lastMonthCount) * 100 : 0;
                            @endphp
                            <div class="flex items-center text-sm {{ $growth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                <i class="fas {{ $growth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                <span>{{ abs($growth) }}% dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-baby text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('kecamatan.balita.index') }}" class="text-blue-500 text-sm font-medium hover:text-blue-700 transition flex items-center">
                        Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Persentase Stunting -->
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Persentase Stunting</p>
                        @php
                            $totalBalita = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->count();
                            $stuntingCount = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Stunting')->count();
                            $stuntingPercentage = $totalBalita > 0 ? ($stuntingCount / $totalBalita) * 100 : 0;
                        @endphp
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stuntingPercentage, 1) }}%</h3>
                        <div class="mt-2">
                            <div class="progress-bar">
                                <div class="progress-fill bg-red-500" style="width: {{ $stuntingPercentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Stunting: {{ $stuntingCount }}</span>
                                <span>Total: {{ $totalBalita }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm {{ $stuntingPercentage > 10 ? 'text-red-600' : 'text-green-600' }} font-medium">
                        <i class="fas {{ $stuntingPercentage > 10 ? 'fa-exclamation-circle' : 'fa-check-circle' }} mr-1"></i>
                        {{ $stuntingPercentage > 10 ? 'Perlu Perhatian' : 'Kondisi Baik' }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Grafik Distribusi Status Gizi -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Distribusi Status Gizi Balita</h3>
                    <p class="text-gray-600 text-sm mt-1">Data terverifikasi di wilayah {{ auth()->user()->kecamatan->nama_kecamatan ?? 'Kecamatan Anda' }}</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-pie mr-2 text-blue-500"></i>
                    <span>Update real-time</span>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pie Chart -->
                <div class="chart-container">
                    <canvas id="statusGiziChart"></canvas>
                </div>
                
                <!-- Statistik Detail -->
                <div class="space-y-4">
                    @php
                        $sehatCount = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Sehat')->count();
                        $stuntingCount = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Stunting')->count();
                        $kurangGiziCount = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Kurang Gizi')->count();
                        $obesitasCount = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Obesitas')->count();
                        $totalBalita = $sehatCount + $stuntingCount + $kurangGiziCount + $obesitasCount;
                    @endphp
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium">Sehat</span>
                            <span class="font-bold">{{ $sehatCount }} <span class="text-gray-500 font-normal">({{ $totalBalita > 0 ? number_format(($sehatCount/$totalBalita)*100, 1) : 0 }}%)</span></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-green-500" style="width: {{ $totalBalita > 0 ? ($sehatCount/$totalBalita)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium">Stunting</span>
                            <span class="font-bold">{{ $stuntingCount }} <span class="text-gray-500 font-normal">({{ $totalBalita > 0 ? number_format(($stuntingCount/$totalBalita)*100, 1) : 0 }}%)</span></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-red-500" style="width: {{ $totalBalita > 0 ? ($stuntingCount/$totalBalita)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium">Kurang Gizi</span>
                            <span class="font-bold">{{ $kurangGiziCount }} <span class="text-gray-500 font-normal">({{ $totalBalita > 0 ? number_format(($kurangGiziCount/$totalBalita)*100, 1) : 0 }}%)</span></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-yellow-500" style="width: {{ $totalBalita > 0 ? ($kurangGiziCount/$totalBalita)*100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium">Obesitas</span>
                            <span class="font-bold">{{ $obesitasCount }} <span class="text-gray-500 font-normal">({{ $totalBalita > 0 ? number_format(($obesitasCount/$totalBalita)*100, 1) : 0 }}%)</span></span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-purple-500" style="width: {{ $totalBalita > 0 ? ($obesitasCount/$totalBalita)*100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Data Balita Terbaru -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Data Balita Terbaru</h3>
                    <p class="text-gray-600 text-sm mt-1">5 data balita terbaru yang telah diverifikasi</p>
                </div>
                <a href="{{ route('kecamatan.balita.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2">
                    <i class="fas fa-list"></i>
                    Lihat Semua Data
                </a>
            </div>
            
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Balita</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat/Tinggi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Gizi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $recentBalitas = \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        
                        @forelse($recentBalitas as $balita)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-baby text-blue-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $balita->nama_balita }}</div>
                                            <div class="text-sm text-gray-500">{{ $balita->kelurahan->nama_kelurahan ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $balita->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        {{ $balita->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $balita->berat_badan }} kg / {{ $balita->tinggi_badan }} cm
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        if($balita->status_gizi == 'Sehat') $statusClass = 'status-sehat';
                                        elseif($balita->status_gizi == 'Stunting') $statusClass = 'status-stunting';
                                        elseif($balita->status_gizi == 'Kurang Gizi') $statusClass = 'status-kurang-gizi';
                                        elseif($balita->status_gizi == 'Obesitas') $statusClass = 'status-obesitas';
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        <i class="fas 
                                            {{ $balita->status_gizi == 'Sehat' ? 'fa-heart' : '' }}
                                            {{ $balita->status_gizi == 'Stunting' ? 'fa-exclamation-triangle' : '' }}
                                            {{ $balita->status_gizi == 'Kurang Gizi' ? 'fa-utensils' : '' }}
                                            {{ $balita->status_gizi == 'Obesitas' ? 'fa-weight' : '' }}
                                            mr-1"></i>
                                        {{ $balita->status_gizi }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($balita->created_at)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    <i class="fas fa-inbox text-2xl text-gray-300 mb-2 block"></i>
                                    Tidak ada data balita terverifikasi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Kartu Tindakan Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-clipboard-check text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Verifikasi Data Balita</h3>
                        <p class="text-gray-600 text-sm mt-1">Tinjau dan verifikasi data balita yang diajukan oleh kelurahan.</p>
                    </div>
                </div>
                <a href="{{ route('kecamatan.balita.index') }}" class="inline-flex items-center text-blue-500 font-medium hover:text-blue-700 transition">
                    Mulai Verifikasi <i class="fas fa-arrow-right ml-2"></i>
                </a>
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
            // Session messages with SweetAlert2
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

            // Table row animation
            $('tbody tr').each(function(index) {
                $(this).css({
                    opacity: 0,
                    transform: 'translateY(10px)'
                }).delay(index * 100).animate({
                    opacity: 1,
                    transform: 'translateY(0)'
                }, 300);
            });

            // Render grafik distribusi status gizi
            const ctx = document.getElementById('statusGiziChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Sehat', 'Stunting', 'Kurang Gizi', 'Obesitas'],
                    datasets: [{
                        data: [{{ $sehatCount }}, {{ $stuntingCount }}, {{ $kurangGiziCount }}, {{ $obesitasCount }}],
                        backgroundColor: [
                            '#10b981', // hijau untuk sehat
                            '#ef4444', // merah untuk stunting
                            '#f59e0b', // kuning untuk kurang gizi
                            '#8b5cf6'  // ungu untuk obesitas
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((context.raw / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        });
    </script>
</body>
</html>