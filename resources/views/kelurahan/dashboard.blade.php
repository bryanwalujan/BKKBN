<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Kelurahan - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, <span class="gradient-text">{{ auth()->user()->name }}</span>!</h1>
            <p class="text-gray-600">Dashboard Admin Kelurahan untuk {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</p>
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
            <!-- Card: Data Balita Diunggah -->
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Data Balita Diunggah</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->where('created_by', auth()->user()->id)->count() }}</h3>
                        <div class="mt-2">
                            <div class="flex justify-between text-xs text-gray-500 mb-1">
                                <span>Progress Verifikasi</span>
                                <span>
                                    @php
                                        $totalPending = \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->where('created_by', auth()->user()->id)->count();
                                        $totalVerified = \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count();
                                        $totalAll = $totalPending + $totalVerified;
                                        $percentage = $totalAll > 0 ? round(($totalVerified / $totalAll) * 100) : 0;
                                    @endphp
                                    {{ $percentage }}%
                                </span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill bg-green-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-cloud-upload-alt text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('kelurahan.balita.index', ['tab' => 'pending']) }}" class="text-blue-500 text-sm font-medium hover:text-blue-700 transition flex items-center">
                        Lihat Data <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Card: Total Balita Terverifikasi -->
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Balita Terverifikasi</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }}</h3>
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                            <span>Data telah divalidasi oleh sistem</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-double text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('kelurahan.balita.index', ['tab' => 'verified']) }}" class="text-blue-500 text-sm font-medium hover:text-blue-700 transition flex items-center">
                        Lihat Data <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <!-- Card: Statistik Kategori Umur -->
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Statistik Kategori Umur</p>
                        <div class="mt-3 space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="age-badge baduata-badge">Baduata</span>
                                    <span class="text-xs text-gray-500 ml-2">(0-24 bulan)</span>
                                </div>
                                <span class="font-bold text-gray-800">
                                    {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() + 
                                       \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="age-badge balita-badge">Balita</span>
                                    <span class="text-xs text-gray-500 ml-2">(25-60 bulan)</span>
                                </div>
                                <span class="font-bold text-gray-800">
                                    {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() + 
                                       \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-child text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    <span>Data real-time</span>
                </div>
            </div>
        </div>
        
        <!-- Grafik Distribusi Umur Balita -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Distribusi Umur Balita</h3>
                    <p class="text-gray-600 text-sm mt-1">Visualisasi data berdasarkan kategori umur</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-pie mr-2 text-blue-500"></i>
                    <span>Total: {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() + \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }} balita</span>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pie Chart -->
                <div class="chart-container">
                    <canvas id="ageDistributionChart"></canvas>
                </div>
                <!-- Bar Chart -->
                <div class="chart-container">
                    <canvas id="ageBarChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Aksi Cepat -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="{{ route('kelurahan.balita.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition flex flex-col items-center justify-center text-center shadow-md">
                    <i class="fas fa-plus-circle text-3xl mb-3"></i>
                    <h4 class="font-semibold text-lg">Tambah Data Balita</h4>
                    <p class="text-blue-100 text-sm mt-2">Unggah data balita baru</p>
                </a>
                
                
                
                <a href="{{ route('kelurahan.balita.index', ['tab' => 'verified']) }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white p-5 rounded-lg hover:from-green-600 hover:to-green-700 transition flex flex-col items-center justify-center text-center shadow-md">
                    <i class="fas fa-check-double text-3xl mb-3"></i>
                    <h4 class="font-semibold text-lg">Data Terverifikasi</h4>
                    <p class="text-green-100 text-sm mt-2">Lihat data yang sudah divalidasi</p>
                </a>
            </div>
        </div>
        
        <!-- Informasi Kelurahan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-map-marker-alt text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Kelurahan</h3>
                        <p class="text-gray-600 text-sm mt-1">Detail wilayah administrasi</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Nama Kelurahan</span>
                        <span class="font-medium">{{ auth()->user()->kelurahan->nama_kelurahan ?? 'Tidak Diketahui' }}</span>
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
                        <p class="text-gray-600 text-sm mt-1">Ringkasan data balita kelurahan</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Total Data Balita</span>
                            <span>
                                @php
                                    $totalBalita = \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() + 
                                                  \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count();
                                @endphp
                                {{ $totalBalita }}
                            </span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-blue-500" style="width: 100%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Data Terverifikasi</span>
                            <span>{{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-green-500" 
                                 style="width: {{ $totalBalita > 0 ? round((\App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() / $totalBalita) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Data Menunggu Verifikasi</span>
                            <span>{{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-amber-500" 
                                 style="width: {{ $totalBalita > 0 ? round((\App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() / $totalBalita) * 100) : 0 }}%">
                            </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            renderCharts();
        });

        function renderCharts() {
            // Data untuk grafik
            const baduataCount = {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() + 
                                   \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }};
            
            const balitaCount = {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() + 
                                  \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }};
            
            const verifiedCount = {{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }};
            const pendingCount = {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }};

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
                                {{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }},
                                {{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }}
                            ],
                            backgroundColor: '#10b981',
                            borderRadius: 4,
                        },
                        {
                            label: 'Menunggu Verifikasi',
                            data: [
                                {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }},
                                {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }}
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