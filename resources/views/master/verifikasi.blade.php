<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun - Master Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
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
        .status-pending { background-color: #f59e0b; color: white; }
        .status-approved { background-color: #10b981; color: white; }
        .status-rejected { background-color: #ef4444; color: white; }
        .role-admin { background-color: #8b5cf6; color: white; }
        .role-operator { background-color: #3b82f6; color: white; }
        .role-kader { background-color: #10b981; color: white; }
        
        /* Animasi untuk reminder */
        @keyframes gentle-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        
        .reminder-pulse {
            animation: gentle-pulse 3s ease-in-out infinite;
        }
        
        /* Animasi untuk icon */
        @keyframes bounce-gentle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        
        .icon-bounce {
            animation: bounce-gentle 2s ease-in-out infinite;
        }
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
                            <i class="fas fa-user-check text-blue-600 mr-3"></i>
                            Verifikasi Akun
                        </h1>
                        <p class="text-gray-600 mt-1">Manajemen verifikasi akun pengguna baru</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            <i class="fas fa-users mr-1"></i>
                            Total: {{ $pendingUsers->count() }} Akun Menunggu
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

            <!-- REMINDER SECTION -->
            <div class="mb-8 reminder-pulse">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg shadow-sm p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 icon-bounce">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-download text-blue-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-blue-800 flex items-center">
                                    <i class="fas fa-bell mr-2"></i>
                                    Pengingat Penting
                                </h3>
                                <button onclick="dismissReminder()" class="text-blue-400 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <p class="text-blue-700 mt-1 font-medium">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                Harap untuk selalu mengunduh terlebih dahulu surat pengajuan akun yang akan disetujui dan disimpan dengan baik di file Dinas
                            </p>
                            <div class="mt-3 flex items-center text-sm text-blue-600">
                                <i class="fas fa-lightbulb mr-2"></i>
                                <span class="font-medium">Tips:</span> 
                                <span class="ml-1">Pastikan dokumen tersimpan rapi untuk keperluan audit dan dokumentasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Menunggu</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingUsers->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <i class="fas fa-clock text-yellow-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Admin kelurahan</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingUsers->where('role', 'admin_kelurahan')->count() }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <i class="fas fa-user-shield text-purple-500 text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Perangkat Daerah</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingUsers->where('role', 'perangkat_daerah')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-building text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-table mr-2 text-blue-500"></i>
                            Data Akun Menunggu Verifikasi
                        </h3>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                            Klik ikon PDF untuk mengunduh surat pengajuan
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-user mr-2"></i>
                                        Pengguna
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        Role
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marked-alt mr-2"></i>
                                        Wilayah
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-tie mr-2"></i>
                                        Penanggung Jawab
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-2"></i>
                                        Kontak
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-alt mr-2"></i>
                                        Dokumen
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
                            @forelse ($pendingUsers as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                <div class="text-xs text-gray-400 mt-1">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $user->role === 'admin' ? 'role-admin' : 
                                                   ($user->role === 'operator' ? 'role-operator' : 'role-kader') }}">
                                                <i class="fas fa-tag mr-1 text-xs"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $user->kecamatan->nama_kecamatan ?? 'Belum ditentukan' }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->kelurahan->nama_kelurahan ?? 'Belum ditentukan' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->penanggung_jawab }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <i class="fas fa-phone text-green-500 mr-2"></i>
                                            {{ $user->no_telepon }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col space-y-2">
                                            @if ($user->pas_foto)
                                                <button onclick="showImageModal('{{ Storage::url($user->pas_foto) }}', 'Pas Foto - {{ $user->name }}')" 
                                                        class="text-blue-600 hover:text-blue-800 transition-colors flex items-center text-sm">
                                                    <i class="fas fa-id-card mr-2"></i>
                                                    Pas Foto
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-sm flex items-center">
                                                    <i class="fas fa-id-card mr-2"></i>
                                                    Tidak ada
                                                </span>
                                            @endif
                                            
                                            @if ($user->surat_pengajuan)
                                                <a href="{{ Storage::url($user->surat_pengajuan) }}" target="_blank" 
                                                   class="text-blue-600 hover:text-blue-800 transition-colors flex items-center text-sm group relative">
                                                    <i class="fas fa-file-pdf mr-2 group-hover:text-red-500 transition-colors"></i>
                                                    Surat Pengajuan
                                                    <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <i class="fas fa-download text-xs"></i>
                                                    </span>
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-sm flex items-center">
                                                    <i class="fas fa-file-pdf mr-2"></i>
                                                    Tidak ada
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-col space-y-2">
                                            <form action="{{ route('verifikasi.approve', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg transition-colors flex items-center justify-center text-sm">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Setujui
                                                </button>
                                            </form>
                                            
                                            <button type="button" 
                                                    onclick="showRejectionForm('{{ $user->id }}', '{{ $user->name }}')"
                                                    class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors flex items-center justify-center text-sm">
                                                <i class="fas fa-times mr-2"></i>
                                                Tolak
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="fas fa-user-check text-4xl mb-3"></i>
                                            <p class="text-lg font-medium">Tidak ada akun menunggu verifikasi</p>
                                            <p class="text-sm mt-1">Semua akun telah diverifikasi</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

    <!-- Rejection Modal -->
    <div id="rejectionModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="max-w-md w-full p-4">
            <div class="bg-white rounded-lg overflow-hidden">
                <div class="p-4 bg-gray-100 flex justify-between items-center">
                    <h3 id="rejectionModalTitle" class="text-lg font-semibold">Tolak Akun</h3>
                    <button onclick="closeRejectionModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form id="rejectionForm" method="POST" class="p-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-1 text-red-500"></i>
                            Alasan Penolakan
                        </label>
                        <textarea name="catatan" rows="4" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 p-3"
                                  placeholder="Masukkan alasan penolakan akun..."
                                  required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeRejectionModal()"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Tolak Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Image modal functionality
            window.showImageModal = function(src, name) {
                document.getElementById('modalImage').src = src;
                document.getElementById('modalTitle').textContent = name;
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

            // SweetAlert untuk konfirmasi persetujuan
            $('form[action*="approve"]').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const userName = $(this).closest('tr').find('.text-gray-900').first().text();
                
                Swal.fire({
                    title: 'Setujui Akun?',
                    html: `<div class="text-center">
                             <i class="fas fa-user-check text-green-500 text-4xl mb-4"></i>
                             <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menyetujui akun ini?</p>
                             <p class="text-gray-600 mt-2">Pengguna: <strong>${userName}</strong></p>
                             <div class="mt-4 p-3 bg-blue-50 rounded-lg text-sm text-blue-700">
                                <i class="fas fa-info-circle mr-2"></i>
                                Jangan lupa unduh dan simpan surat pengajuan di file Dinas
                             </div>
                           </div>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Ya, Setujui!',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Fungsi untuk menyembunyikan reminder
        function dismissReminder() {
            const reminder = document.querySelector('.reminder-pulse');
            reminder.style.opacity = '0';
            reminder.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                reminder.style.display = 'none';
            }, 300);
            
            // Simpan status di localStorage
            localStorage.setItem('reminderDismissed', 'true');
        }

        // Cek apakah reminder sudah di dismiss sebelumnya
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('reminderDismissed') === 'true') {
                document.querySelector('.reminder-pulse').style.display = 'none';
            }
        });

        // Fungsi untuk menampilkan form penolakan
        function showRejectionForm(userId, userName) {
            document.getElementById('rejectionModalTitle').textContent = `Tolak Akun - ${userName}`;
            document.getElementById('rejectionForm').action = '{{ route("verifikasi.reject", ":id") }}'.replace(':id', userId);
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        // Fungsi untuk menutup modal penolakan
        function closeRejectionModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
            document.getElementById('rejectionForm').reset();
        }

        // SweetAlert untuk konfirmasi penolakan
        document.getElementById('rejectionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const catatan = form.catatan.value;
            
            if (!catatan.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Alasan Diperlukan',
                    text: 'Silakan masukkan alasan penolakan.',
                    confirmButtonColor: '#3b82f6',
                });
                return;
            }
            
            Swal.fire({
                title: 'Tolak Akun?',
                html: `<div class="text-center">
                         <i class="fas fa-user-times text-red-500 text-4xl mb-4"></i>
                         <p class="text-lg font-semibold text-gray-800">Apakah Anda yakin ingin menolak akun ini?</p>
                         <p class="text-gray-600 mt-2">Alasan: <strong>${catatan}</strong></p>
                         <p class="text-sm text-red-600 mt-2">Tindakan ini tidak dapat dibatalkan!</p>
                       </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-times mr-2"></i>Ya, Tolak!',
                cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>