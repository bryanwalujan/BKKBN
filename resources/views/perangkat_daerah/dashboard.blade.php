<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perangkat Daerah - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .chart-container {
            max-height: 300px;
            overflow-x: auto;
            position: relative;
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
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
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
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            background-color: #e5e7eb;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }
        
        .age-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .baduata-badge {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .balita-badge {
            background-color: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('perangkat_daerah.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, <span class="gradient-text">{{ auth()->user()->name }}</span>!</h1>
            <p class="text-gray-600">Dashboard Perangkat Daerah untuk {{ auth()->user()->kecamatan->nama_kecamatan ?? 'Kecamatan Tidak Diketahui' }}</p>
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
        
        <!-- Aksi Cepat -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" 
                   class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex flex-col items-center justify-center text-center shadow-md pulse-animation">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <h4 class="font-semibold text-lg">Data Aksi Konvergensi</h4>
                    <p class="text-blue-100 text-sm mt-2">Kelola data aksi konvergensi</p>
                </a>
                <a href="{{ route('perangkat_daerah.genting.index') }}" 
                   class="bg-gradient-to-r from-red-500 to-red-600 text-white p-5 rounded-lg hover:from-red-600 hover:to-red-700 transition flex flex-col items-center justify-center text-center shadow-md">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h-3m3 0h3"/>
                    </svg>
                    <h4 class="font-semibold text-lg">Data Genting</h4>
                    <p class="text-red-100 text-sm mt-2">Lihat data genting</p>
                </a>
                <a href="{{ route('perangkat_daerah.pendamping_keluarga.index') }}" 
                   class="bg-gradient-to-r from-green-500 to-green-600 text-white p-5 rounded-lg hover:from-green-600 hover:to-green-700 transition flex flex-col items-center justify-center text-center shadow-md">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <h4 class="font-semibold text-lg">Data Pendamping Keluarga</h4>
                    <p class="text-green-100 text-sm mt-2">Kelola data pendamping keluarga</p>
                </a>
                <a href="{{ route('perangkat_daerah.data_monitoring.index') }}" 
                   class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-5 rounded-lg hover:from-purple-600 hover:to-purple-700 transition flex flex-col items-center justify-center text-center shadow-md">
                    <svg class="w-8 h-8 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    <h4 class="font-semibold text-lg">Data Monitoring</h4>
                    <p class="text-purple-100 text-sm mt-2">Lihat data monitoring</p>
                </a>
            </div>
        </div>
        
        <!-- Informasi Kecamatan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-map-marker-alt text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Kecamatan</h3>
                        <p class="text-gray-600 text-sm mt-1">Detail wilayah administrasi</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Nama Kecamatan</span>
                        <span class="font-medium">{{ auth()->user()->kecamatan->nama_kecamatan ?? 'Tidak Diketahui' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Jumlah Kelurahan</span>
                        <span class="font-medium">
                            {{ \App\Models\Kelurahan::where('kecamatan_id', auth()->user()->kecamatan_id)->count() }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line text-green-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Statistik Ringkas</h3>
                        <p class="text-gray-600 text-sm mt-1">Ringkasan data balita kecamatan</p>
                    </div>
                </div>
                <div class="space-y-4">
                    
                        <div class="progress-bar">
                            <div class="progress-fill bg-blue-500" style="width: 100%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Data Terverifikasi</span>
                            <span>{{ \App\Models\Balita::whereHas('kelurahan', function($q) {
                                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
                            })->count() }}</span>
                        </div>
                        
                    </div>
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Data Menunggu Verifikasi</span>
                            <span>{{ \App\Models\PendingBalita::whereHas('kelurahan', function($q) {
                                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
                            })->count() }}</span>
                        </div>
                        
                    </div>
                </div>
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
            renderCharts();
            
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
        });

        function renderCharts() {
            // Data untuk grafik
            const baduataCount = {{ \App\Models\PendingBalita::whereHas('kelurahan', function($q) {
                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
            })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() + 
                                   \App\Models\Balita::whereHas('kelurahan', function($q) {
                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
            })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }};
            
            const balitaCount = {{ \App\Models\PendingBalita::whereHas('kelurahan', function($q) {
                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
            })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() + 
                                   \App\Models\Balita::whereHas('kelurahan', function($q) {
                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
            })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }};
            
            const verifiedCount = {{ \App\Models\Balita::whereHas('kelurahan', function($q) {
                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
            })->count() }};
            const pendingCount = {{ \App\Models\PendingBalita::whereHas('kelurahan', function($q) {
                $q->where('kecamatan_id', auth()->user()->kecamatan_id);
            })->count() }};

            // Pie Chart untuk distribusi umur
            new Chart(document.getElementById('ageDistributionChart'), {
                type: 'pie',
                data: {
                    labels: ['Baduata (0-24 bln)', 'Balita (25-60 bln)'],
                    datasets: [{
                        data: [baduataCount, balitaCount],
                        backgroundColor: ['#3b82f6', '#10b981'],
                        borderColor: '#ffffff',
                        borderWidth: 2
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
                                padding: 15
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
                    }
                }
            });

            // Bar Chart untuk status verifikasi
            new Chart(document.getElementById('ageBarChart'), {
                type: 'bar',
                data: {
                    labels: ['Baduata', 'Balita'],
                    datasets: [
                        {
                            label: 'Terverifikasi',
                            data: [
                                {{ \App\Models\Balita::whereHas('kelurahan', function($q) {
                                    $q->where('kecamatan_id', auth()->user()->kecamatan_id);
                                })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }},
                                {{ \App\Models\Balita::whereHas('kelurahan', function($q) {
                                    $q->where('kecamatan_id', auth()->user()->kecamatan_id);
                                })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }}
                            ],
                            backgroundColor: '#10b981',
                            borderRadius: 4,
                        },
                        {
                            label: 'Menunggu Verifikasi',
                            data: [
                                {{ \App\Models\PendingBalita::whereHas('kelurahan', function($q) {
                                    $q->where('kecamatan_id', auth()->user()->kecamatan_id);
                                })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }},
                                {{ \App\Models\PendingBalita::whereHas('kelurahan', function($q) {
                                    $q->where('kecamatan_id', auth()->user()->kecamatan_id);
                                })->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }}
                            ],
                            backgroundColor: '#f59e0b',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>