<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan Genting - Master Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .form-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .form-section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1.5rem;
        }
        .form-section-body {
            padding: 1.5rem;
        }
        .pihak-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        .pihak-card {
            background: #f8fafc;
            border-radius: 8px;
            padding: 1rem;
            border-left: 4px solid #3b82f6;
        }
        .pihak-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }
        .pihak-card-header i {
            margin-right: 0.5rem;
            color: #3b82f6;
        }
        .pihak-card-title {
            font-weight: 600;
            color: #374151;
        }
        .file-preview {
            display: flex;
            align-items: center;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 0.75rem;
            margin-top: 0.5rem;
        }
        .file-preview i {
            color: #0ea5e9;
            margin-right: 0.5rem;
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
                            <i class="fas fa-edit text-blue-600 mr-3"></i>
                            Edit Kegiatan Genting
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui informasi kegiatan genting yang sudah ada</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('genting.index') }}" 
                           class="text-sm text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
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

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                    <div>
                        <p class="text-red-800 font-medium">Terdapat kesalahan dalam pengisian form:</p>
                        <ul class="mt-1 list-disc list-inside text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <form action="{{ route('genting.update', $genting->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informasi Dasar Kegiatan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Informasi Dasar Kegiatan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui informasi dasar tentang kegiatan genting</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-id-card text-purple-500 mr-2 text-xs"></i>
                                    Kartu Keluarga
                                </label>
                                <div class="relative">
                                    <select name="kartu_keluarga_id" id="kartu_keluarga_id" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Kartu Keluarga --</option>
                                        @foreach ($kartuKeluargas as $kk)
                                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $genting->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>
                                                {{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kartu_keluarga_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama_kegiatan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-tasks text-green-500 mr-2 text-xs"></i>
                                    Nama Kegiatan
                                </label>
                                <div class="relative">
                                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan', $genting->nama_kegiatan) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan nama kegiatan" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-pen text-gray-400"></i>
                                    </div>
                                </div>
                                @error('nama_kegiatan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-red-500 mr-2 text-xs"></i>
                                    Tanggal
                                </label>
                                <div class="relative">
                                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $genting->tanggal ? \Carbon\Carbon::make($genting->tanggal)?->format('Y-m-d') : '') }}"" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tanggal')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map-marker-alt text-yellow-500 mr-2 text-xs"></i>
                                    Lokasi
                                </label>
                                <div class="relative">
                                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $genting->lokasi) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan lokasi kegiatan" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-location-dot text-gray-400"></i>
                                    </div>
                                </div>
                                @error('lokasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="sasaran" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-bullseye text-indigo-500 mr-2 text-xs"></i>
                                    Sasaran
                                </label>
                                <div class="relative">
                                    <input type="text" name="sasaran" id="sasaran" value="{{ old('sasaran', $genting->sasaran) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan sasaran kegiatan" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-users text-gray-400"></i>
                                    </div>
                                </div>
                                @error('sasaran')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_intervensi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-hand-holding-heart text-pink-500 mr-2 text-xs"></i>
                                    Jenis Intervensi
                                </label>
                                <div class="relative">
                                    <input type="text" name="jenis_intervensi" id="jenis_intervensi" value="{{ old('jenis_intervensi', $genting->jenis_intervensi) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan jenis intervensi" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-hands-helping text-gray-400"></i>
                                    </div>
                                </div>
                                @error('jenis_intervensi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Kegiatan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-align-left text-green-500 mr-2"></i>
                            Deskripsi Kegiatan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui narasi dan dokumentasi kegiatan</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="narasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-file-text text-blue-500 mr-2 text-xs"></i>
                                    Narasi Kegiatan
                                </label>
                                <textarea name="narasi" id="narasi" rows="5"
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                          placeholder="Masukkan narasi lengkap tentang kegiatan">{{ old('narasi', $genting->narasi) }}</textarea>
                                @error('narasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="dokumentasi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-camera text-purple-500 mr-2 text-xs"></i>
                                    Dokumentasi (Maks. 7MB)
                                </label>
                                <div class="relative">
                                    <input type="file" name="dokumentasi" id="dokumentasi" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                           accept="image/*">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                </div>
                                
                                @if ($genting->dokumentasi)
                                    <div class="file-preview">
                                        <i class="fas fa-file-image"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">Dokumentasi saat ini:</p>
                                            <a href="{{ Storage::url($genting->dokumentasi) }}" target="_blank" 
                                               class="text-blue-500 hover:text-blue-700 text-sm flex items-center">
                                                <i class="fas fa-external-link-alt mr-1"></i>
                                                Lihat file
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, PNG, GIF. Maksimal 7MB.</p>
                                @error('dokumentasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pihak Terlibat -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-users text-orange-500 mr-2"></i>
                            Pihak Terlibat
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui pihak-pihak yang terlibat dalam kegiatan</p>
                    </div>
                    <div class="form-section-body">
                        <div class="pihak-grid">
                            @php
                                $pihakIcons = [
                                    'dunia_usaha' => 'fas fa-building',
                                    'pemerintah' => 'fas fa-landmark',
                                    'bumn_bumd' => 'fas fa-industry',
                                    'individu_perseorangan' => 'fas fa-user',
                                    'lsm_komunitas' => 'fas fa-hands-helping',
                                    'swasta' => 'fas fa-briefcase',
                                    'perguruan_tinggi_akademisi' => 'fas fa-graduation-cap',
                                    'media' => 'fas fa-newspaper',
                                    'tim_pendamping_keluarga' => 'fas fa-user-friends',
                                    'tokoh_masyarakat' => 'fas fa-user-tie'
                                ];
                            @endphp
                            @foreach (['dunia_usaha', 'pemerintah', 'bumn_bumd', 'individu_perseorangan', 'lsm_komunitas', 'swasta', 'perguruan_tinggi_akademisi', 'media', 'tim_pendamping_keluarga', 'tokoh_masyarakat'] as $pihak)
                                <div class="pihak-card">
                                    <div class="pihak-card-header">
                                        <i class="{{ $pihakIcons[$pihak] }}"></i>
                                        <span class="pihak-card-title">{{ ucwords(str_replace('_', ' ', $pihak)) }}</span>
                                    </div>
                                    <div>
                                        <select name="{{ $pihak }}" id="{{ $pihak }}" 
                                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 pihak-select">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="ada" {{ old($pihak, $genting->$pihak) == 'ada' ? 'selected' : '' }}>Ada</option>
                                            <option value="tidak" {{ old($pihak, $genting->$pihak) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                        @error($pihak)
                                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                        <div class="mt-2 {{ old($pihak, $genting->$pihak) == 'ada' ? '' : 'hidden' }}" id="{{ $pihak }}_frekuensi_container">
                                            <label for="{{ $pihak }}_frekuensi" class="block text-sm font-medium text-gray-700 mb-1">Frekuensi</label>
                                            <input type="text" name="{{ $pihak }}_frekuensi" id="{{ $pihak }}_frekuensi" 
                                                   value="{{ old($pihak . '_frekuensi', $genting->{$pihak . '_frekuensi'}) }}" 
                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                                   placeholder="kali per minggu/bulan">
                                            @error($pihak . '_frekuensi')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('genting.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle frekuensi input berdasarkan pilihan pihak
            document.querySelectorAll('.pihak-select').forEach(select => {
                select.addEventListener('change', function() {
                    const container = document.getElementById(this.id + '_frekuensi_container');
                    if (this.value === 'ada') {
                        container.classList.remove('hidden');
                    } else {
                        container.classList.add('hidden');
                    }
                });
            });

            // Inisialisasi status frekuensi berdasarkan data lama
            document.querySelectorAll('.pihak-select').forEach(select => {
                const container = document.getElementById(select.id + '_frekuensi_container');
                if (select.value === 'ada') {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>