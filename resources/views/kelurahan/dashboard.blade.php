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
        
        .quick-action-card {
            transition: all 0.3s ease;
            border-top: 4px solid transparent;
        }
        
        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.1);
            border-top-color: #3b82f6;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-badge.pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-badge.verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-badge.rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('kelurahan.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, <span class="gradient-text">{{ auth()->user()->name }}!</span></h1>
            <p class="text-gray-600">Dashboard ini memberikan gambaran lengkap tentang data balita di wilayah {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Anda' }}.</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                <span class="mx-2">•</span>
                <i class="fas fa-map-marker-alt mr-2"></i>
                <span>{{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}</span>
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Balita</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-baby text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    <span>Update real-time</span>
                </div>
            </div>
            
          
            
            
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Data Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereMonth('created_at', now()->month)->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-check text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>Data {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
                </div>
            </div>
        </div>
        
      
        
        <!-- Informasi Kelurahan -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-blue-800">Informasi Kelurahan</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p><strong>Nama Kelurahan:</strong> {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Tidak Diketahui' }}</p>
                        <p class="mt-1"><strong>Kode Kelurahan:</strong> {{ auth()->user()->kelurahan->kode_kelurahan ?? 'Tidak Diketahui' }}</p>
                        <p class="mt-1"><strong>Alamat:</strong> {{ auth()->user()->kelurahan->alamat ?? 'Tidak Diketahui' }}</p>
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

        // Render grafik
        function renderCharts() {
                     
            // Bar Chart - Data Bulanan
            new Chart(document.getElementById('monthlyBarChart'), {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Jumlah Balita',
                        data: counts,
                        backgroundColor: '#3b82f6',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>