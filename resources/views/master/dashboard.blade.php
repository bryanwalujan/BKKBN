<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Master - CSSR</title>
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
        
        .backup-indicator {
            position: relative;
            overflow: hidden;
        }
        
        .backup-indicator::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
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
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, <span class="gradient-text">Master!</span></h1>
            <p class="text-gray-600">Dashboard ini memberikan gambaran lengkap tentang sistem CSSR Anda.</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
        
        <!-- Pesan Reminder Backup Bulanan -->
        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-400 p-5 mb-8 rounded-lg shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0 pt-1">
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-yellow-800">Pengingat Backup Database</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p><strong>Penting!</strong> Lakukan backup database secara rutin setiap bulan untuk menjaga keamanan data sistem.</p>
                        <p class="mt-1">Backup terakhir otomatis dijadwalkan tanggal 1 setiap bulan. Anda juga dapat melakukan backup manual kapan saja.</p>
                    </div>
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
        
        <!-- Statistik Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Data Riset</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ count($dataRisets) }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-bar text-blue-500 text-xl"></i>
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
                        <p class="text-sm font-medium text-gray-500">Backup Tersedia</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1" id="backup-count">0</h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-database text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-sync-alt mr-1"></i>
                    <span>Auto-refresh setiap 30 detik</span>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Akun Menunggu</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">-</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-clock text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('verifikasi.index') }}" class="text-blue-500 text-sm font-medium hover:text-blue-700 transition">
                        Lihat antrian <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="stat-card p-5 shadow-sm card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Template Tersedia</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">-</h3>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt text-indigo-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('templates.index') }}" class="text-blue-500 text-sm font-medium hover:text-blue-700 transition">
                        Kelola template <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Data Riset Statistik -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Statistik Data Riset Realtime</h3>
                    <p class="text-gray-600 text-sm mt-1">Data terkini dari sistem monitoring CSSR</p>
                </div>
                <a href="{{ route('data_riset.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2">
                    <i class="fas fa-external-link-alt"></i>
                    Lihat Semua Data
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse ($dataRisets as $data)
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 rounded-lg border border-gray-200 hover:border-blue-300 transition">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-sm font-medium text-gray-700 truncate">{{ $data->judul }}</h4>
                            <i class="fas fa-chart-line text-blue-400"></i>
                        </div>
                        <p class="text-2xl font-bold text-blue-600">{{ $data->angka }}</p>
                        <div class="flex items-center mt-2 text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            <span>Update: {{ \Carbon\Carbon::parse($data->tanggal_update)->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Tidak ada data riset realtime untuk ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Grafik -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <h3 class="text-xl font-semibold text-gray-800 mb-6">Visualisasi Data Riset</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Horizontal Bar Chart -->
                <div class="chart-container">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-medium text-gray-700">Jumlah Data per Kategori</h4>
                        <i class="fas fa-chart-bar text-blue-500"></i>
                    </div>
                    <canvas id="barChart"></canvas>
                </div>
                <!-- Pie Chart -->
                <div class="chart-container">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-medium text-gray-700">Distribusi Data Riset</h4>
                        <i class="fas fa-chart-pie text-green-500"></i>
                    </div>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Backup Database -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Backup Database</h3>
                    <p class="text-gray-600 text-sm mt-1">Kelola backup data sistem CSSR</p>
                </div>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    <span>Jadwal backup otomatis: tgl 1 setiap bulan</span>
                </div>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-blue-800">Backup Selanjutnya</h4>
                        <p class="text-blue-600 mt-1">
                            <i class="far fa-clock mr-2"></i>
                            {{ \Carbon\Carbon::createFromDate(null, date('n') + 1, 1)->startOfDay()->format('d F Y, H:i') }} WITA
                        </p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-database text-blue-500"></i>
                    </div>
                </div>
            </div>
            
            <!-- Tombol Backup Utama -->
            <div class="mb-6 text-center">
                <form action="{{ route('backup.laravel') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg transition duration-200 font-medium text-lg shadow-md pulse-animation flex items-center justify-center gap-3">
                        <i class="fas fa-download"></i>
                        Unduh Database Sekarang
                    </button>
                </form>
                <p class="text-sm text-gray-500 mt-3">
                    <i class="fas fa-file-export mr-1"></i>
                    File akan diunduh dengan nama: dataBackupCSSR_{{ date('Y-m-d') }}.sql
                </p>
            </div>
            
            <!-- Opsi Backup Alternatif (Collapsed) -->
            <details class="mb-6">
                <summary class="cursor-pointer text-gray-700 hover:text-gray-900 font-medium flex items-center gap-2">
                    <i class="fas fa-cog"></i>
                    Opsi Backup Alternatif
                </summary>
                <div class="mt-4 p-4 bg-gray-50 rounded-lg border flex flex-wrap gap-3">
                    <form action="{{ route('backup.manual') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition flex items-center gap-2">
                            <i class="fas fa-copy"></i>
                            Backup (Spatie)
                        </button>
                    </form>
                    <form action="{{ route('backup.direct') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition flex items-center gap-2">
                            <i class="fas fa-server"></i>
                            Backup (mysqldump)
                        </button>
                    </form>
                    <a href="{{ route('backup.debug.html') }}" target="_blank" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition inline-flex items-center gap-2">
                        <i class="fas fa-bug"></i>
                        Debug Info
                    </a>
                </div>
            </details>
            
            <!-- List backup files -->
            <div>
                <h4 class="text-md font-medium mb-3 flex items-center gap-2">
                    <i class="fas fa-history"></i>
                    Riwayat File Backup
                </h4>
                <div id="backup-list" class="max-h-60 overflow-y-auto border rounded-lg p-4 bg-gray-50">
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin text-blue-500 text-xl mb-2"></i>
                        <p class="text-gray-500">Memuat daftar backup...</p>
                    </div>
                </div>
                <button onclick="loadBackupList()" class="mt-3 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center gap-2">
                    <i class="fas fa-sync-alt"></i>
                    Refresh List
                </button>
            </div>
        </div>
        
        <!-- Kartu Navigasi Cepat -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-users text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Kelola Akun</h3>
                        <p class="text-gray-600 text-sm mt-1">Verifikasi atau kelola akun Admin Kelurahan dan Perangkat Desa.</p>
                    </div>
                </div>
                <a href="{{ route('verifikasi.index') }}" class="inline-flex items-center text-blue-500 font-medium hover:text-blue-700 transition">
                    Lihat Antrian <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-file-contract text-green-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Kelola Template</h3>
                        <p class="text-gray-600 text-sm mt-1">Upload atau hapus template surat pengajuan akun.</p>
                    </div>
                </div>
                <a href="{{ route('templates.index') }}" class="inline-flex items-center text-blue-500 font-medium hover:text-blue-700 transition">
                    Kelola Template <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm card-hover">
                <div class="flex items-start mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-baby text-purple-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Informasi Balita</h3>
                        <p class="text-gray-600 text-sm mt-1">Lihat dan kelola data balita (stunting/sehat).</p>
                    </div>
                </div>
                <a href="{{ route('balita.index') }}" class="inline-flex items-center text-blue-500 font-medium hover:text-blue-700 transition">
                    Kelola Data <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Load backup list saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            loadBackupList();
            renderCharts();
        });

        function loadBackupList() {
            const backupListElement = document.getElementById('backup-list');
            backupListElement.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-spinner fa-spin text-blue-500 text-xl mb-2"></i>
                    <p class="text-gray-500">Memuat daftar backup...</p>
                </div>
            `;
            
            fetch('{{ route("backup.list") }}')
                .then(response => response.json())
                .then(data => {
                    // Update backup count in stat card
                    document.getElementById('backup-count').textContent = data.length;
                    
                    if (data.length === 0) {
                        backupListElement.innerHTML = `
                            <div class="text-center py-6">
                                <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">Tidak ada file backup ditemukan.</p>
                            </div>
                        `;
                        return;
                    }
                    
                    let html = '<div class="space-y-3">';
                    data.forEach(backup => {
                        const sizeColor = backup.size_bytes > 1024 * 1024 ? 'text-green-600' : 'text-blue-600';
                        html += `
                            <div class="flex justify-between items-center bg-white p-4 rounded-lg border hover:shadow-md transition">
                                <div class="flex items-center">
                                    <i class="fas fa-file-archive text-blue-400 text-xl mr-3"></i>
                                    <div>
                                        <div class="font-medium text-gray-800">${backup.name}</div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                            <span class="${sizeColor} font-medium"><i class="fas fa-hdd mr-1"></i>${backup.size}</span>
                                            <span><i class="far fa-calendar-alt mr-1"></i>${backup.date}</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="/storage/private/${backup.path}" 
                                   class="bg-green-500 text-white px-3 py-2 rounded text-sm hover:bg-green-600 transition flex items-center gap-2"
                                   download="${backup.name}">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        `;
                    });
                    html += '</div>';
                    backupListElement.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading backup list:', error);
                    backupListElement.innerHTML = `
                        <div class="text-center py-4 text-red-500">
                            <i class="fas fa-exclamation-triangle text-xl mb-2"></i>
                            <p>Error memuat daftar backup. Silakan refresh halaman.</p>
                        </div>
                    `;
                });
        }

        // Auto refresh backup list setiap 30 detik
        setInterval(loadBackupList, 30000);

        // Render grafik
        function renderCharts() {
            const dataRisets = @json($dataRisets);
            const labels = dataRisets.map(item => item.judul);
            const values = dataRisets.map(item => item.angka);
            const colors = ['#3b82f6', '#22c55e', '#eab308', '#dc2626', '#8b5cf6', '#06b6d4'];

            // Horizontal Bar Chart
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: values,
                        backgroundColor: colors,
                        borderColor: colors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        y: {
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

            // Pie Chart
            new Chart(document.getElementById('pieChart'), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
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
                                    const percentage = ((context.raw / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>