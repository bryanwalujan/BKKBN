<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Master</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Selamat Datang, Master!</h2>
        
        <!-- Pesan Reminder Backup Bulanan -->
        <div class="bg-yellow-50 border border-yellow-200 p-4 mb-6 rounded-lg">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Pengingat Backup Database</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p><strong>Penting!</strong> Lakukan backup database secara rutin setiap bulan untuk menjaga keamanan data sistem.</p>
                        <p class="mt-1">Backup terakhir otomatis dijadwalkan tanggal 1 setiap bulan. Anda juga dapat melakukan backup manual kapan saja.</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-lg font-medium mb-4">Backup Database</h3>
            <p class="text-gray-600 mb-4">
                Jadwal backup otomatis berikutnya: 
                <span class="font-semibold text-blue-600">
                    {{ \Carbon\Carbon::createFromDate(null, date('n') + 1, 1)->startOfDay()->format('d F Y, H:i') }} WITA
                </span>
            </p>
            
            <!-- Tombol Backup Utama -->
            <div class="mb-4">
                <form action="{{ route('backup.laravel') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition duration-200 font-medium text-lg shadow-md">
                        📁 Unduh Database Sekarang
                    </button>
                </form>
                <p class="text-sm text-gray-500 mt-2">File akan diunduh dengan nama: dataBackupCSDSR_{{ date('Y-m-d') }}.sql</p>
            </div>
            
            <!-- Opsi Backup Alternatif (Collapsed) -->
            <details class="mb-4">
                <summary class="cursor-pointer text-gray-600 hover:text-gray-800 font-medium">Opsi Backup Alternatif</summary>
                <div class="mt-3 p-4 bg-gray-50 rounded border flex flex-wrap gap-2">
                    <!-- Backup menggunakan Spatie -->
                    <form action="{{ route('backup.manual') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600 transition text-sm">
                            Backup (Spatie)
                        </button>
                    </form>
                    
                    <!-- Backup langsung dari database -->
                    <form action="{{ route('backup.direct') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-indigo-500 text-white px-3 py-2 rounded hover:bg-indigo-600 transition text-sm">
                            Backup (mysqldump)
                        </button>
                    </form>
                    
                    <!-- Debug info -->
                    <a href="{{ route('backup.debug.html') }}" target="_blank" class="bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600 transition inline-block text-sm">
                        Debug Info
                    </a>
                </div>
            </details>
            
            <!-- List backup files -->
            <div class="mt-6">
                <h4 class="text-md font-medium mb-2">Riwayat File Backup</h4>
                <div id="backup-list" class="max-h-60 overflow-y-auto border rounded p-3 bg-gray-50">
                    <p class="text-gray-500 text-center">Memuat daftar backup...</p>
                </div>
                <button onclick="loadBackupList()" class="mt-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 text-sm">
                    🔄 Refresh List
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
                <h3 class="text-lg font-medium mb-2">👥 Kelola Akun</h3>
                <p class="text-gray-600 mb-4">Verifikasi atau kelola akun Admin Kelurahan dan Perangkat Desa.</p>
                <a href="{{ route('verifikasi.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Lihat Antrian</a>
            </div>
            <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
                <h3 class="text-lg font-medium mb-2">📄 Kelola Template</h3>
                <p class="text-gray-600 mb-4">Upload atau hapus template surat pengajuan akun.</p>
                <a href="{{ route('templates.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Kelola Template</a>
            </div>
            <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
                <h3 class="text-lg font-medium mb-2">👶 Informasi Balita</h3>
                <p class="text-gray-600 mb-4">Lihat dan kelola data balita (stunting/sehat).</p>
                <a href="{{ route('balita.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Kelola Data</a>
            </div>
        </div>
    </div>

    <script>
        // Load backup list saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            loadBackupList();
        });

        function loadBackupList() {
            const backupListElement = document.getElementById('backup-list');
            backupListElement.innerHTML = '<p class="text-gray-500 text-center">⏳ Memuat daftar backup...</p>';
            
            fetch('{{ route("backup.list") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        backupListElement.innerHTML = '<p class="text-gray-500 text-center">📄 Tidak ada file backup ditemukan.</p>';
                        return;
                    }
                    
                    let html = '<div class="space-y-2">';
                    data.forEach(backup => {
                        // Tentukan warna berdasarkan ukuran file
                        const sizeColor = backup.size_bytes > 1024 * 1024 ? 'text-green-600' : 'text-blue-600'; // > 1MB = hijau
                        
                        html += `
                            <div class="flex justify-between items-center bg-white p-3 rounded border hover:bg-gray-50 transition">
                                <div class="flex-1">
                                    <div class="font-medium text-sm text-gray-800">📁 ${backup.name}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <span class="${sizeColor} font-medium">${backup.size}</span> • 
                                        <span>📅 ${backup.date}</span>
                                    </div>
                                </div>
                                <a href="/storage/private/${backup.path}" 
                                   class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600 transition flex items-center gap-1"
                                   download="${backup.name}">
                                    ⬇️ Download
                                </a>
                            </div>
                        `;
                    });
                    html += '</div>';
                    
                    backupListElement.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading backup list:', error);
                    backupListElement.innerHTML = 
                        '<p class="text-red-500 text-center">❌ Error memuat daftar backup. Silakan refresh halaman.</p>';
                });
        }

        // Auto refresh backup list setiap 30 detik
        setInterval(loadBackupList, 30000);
    </script>
</body>
</html>