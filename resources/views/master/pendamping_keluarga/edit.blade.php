<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendamping Keluarga - Master Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
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
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            min-height: 48px;
            padding: 0.25rem 0.75rem;
        }
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            height: 48px;
            padding: 0.5rem 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 32px;
        }
        .activity-checkbox {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .activity-checkbox:hover {
            background-color: #f8fafc;
        }
        .activity-checkbox input[type="checkbox"] {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.25rem;
            border: 1px solid #d1d5db;
            margin-right: 0.75rem;
        }
        .activity-checkbox input[type="checkbox"]:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        .current-photo {
            max-width: 150px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
                            <i class="fas fa-user-edit text-blue-600 mr-3"></i>
                            Edit Pendamping Keluarga
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui data pendamping keluarga dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('pendamping_keluarga.index') }}" 
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

            <form action="{{ route('pendamping_keluarga.update', $pendamping->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informasi Pribadi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user text-blue-500 mr-2"></i>
                            Informasi Pribadi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data pribadi pendamping keluarga</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-signature text-green-500 mr-2 text-xs"></i>
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <input type="text" name="nama" id="nama" value="{{ old('nama', $pendamping->nama) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan nama lengkap pendamping" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                </div>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="peran" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-user-tag text-purple-500 mr-2 text-xs"></i>
                                    Peran
                                </label>
                                <div class="relative">
                                    <select name="peran" id="peran" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="" disabled>-- Pilih Peran --</option>
                                        <option value="Bidan" {{ old('peran', $pendamping->peran) == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                                        <option value="Kader Posyandu" {{ old('peran', $pendamping->peran) == 'Kader Posyandu' ? 'selected' : '' }}>Kader Posyandu</option>
                                        <option value="Kader Kesehatan" {{ old('peran', $pendamping->peran) == 'Kader Kesehatan' ? 'selected' : '' }}>Kader Kesehatan</option>
                                        <option value="Tim Penggerak PKK" {{ old('peran', $pendamping->peran) == 'Tim Penggerak PKK' ? 'selected' : '' }}>Tim Penggerak PKK</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('peran')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Lokasi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                            Informasi Lokasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui lokasi penugasan pendamping</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map text-blue-500 mr-2 text-xs"></i>
                                    Kecamatan
                                </label>
                                <select name="kecamatan_id" id="kecamatan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $pendamping->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-map-pin text-green-500 mr-2 text-xs"></i>
                                    Kelurahan
                                </label>
                                <select name="kelurahan_id" id="kelurahan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                    <option value="">-- Pilih Kelurahan --</option>
                                    @foreach ($kelurahans as $kelurahan)
                                        <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $pendamping->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                                    @endforeach
                                </select>
                                @error('kelurahan_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keluarga yang Didampingi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-users text-yellow-500 mr-2"></i>
                            Keluarga yang Didampingi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui keluarga yang akan didampingi (bisa lebih dari satu)</p>
                    </div>
                    <div class="form-section-body">
                        <div>
                            <label for="kartu_keluarga_ids" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-hashtag text-purple-500 mr-2 text-xs"></i>
                                Kartu Keluarga
                            </label>
                            <select name="kartu_keluarga_ids[]" id="kartu_keluarga_ids" multiple class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                                <option value="">-- Pilih Kartu Keluarga --</option>
                                @foreach ($kartuKeluargas as $kk)
                                    <option value="{{ $kk->id }}" {{ in_array($kk->id, old('kartu_keluarga_ids', $pendamping->kartuKeluargas->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Tahan tombol Ctrl untuk memilih lebih dari satu</p>
                            @error('kartu_keluarga_ids')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status dan Informasi Tambahan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                            Status dan Informasi Tambahan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui informasi status dan tambahan pendamping</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-circle-check text-green-500 mr-2 text-xs"></i>
                                    Status
                                </label>
                                <div class="relative">
                                    <select name="status" id="status" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="" disabled>-- Pilih Status --</option>
                                        <option value="Aktif" {{ old('status', $pendamping->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Non-Aktif" {{ old('status', $pendamping->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tahun_bergabung" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-blue-500 mr-2 text-xs"></i>
                                    Tahun Bergabung
                                </label>
                                <div class="relative">
                                    <input type="number" name="tahun_bergabung" id="tahun_bergabung" value="{{ old('tahun_bergabung', $pendamping->tahun_bergabung) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           min="2000" max="2030" placeholder="Tahun bergabung" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tahun_bergabung')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-camera text-purple-500 mr-2 text-xs"></i>
                                    Foto Pendamping
                                </label>
                                @if ($pendamping->foto)
                                    <div class="mb-3 flex items-center space-x-4">
                                        <img src="{{ Storage::url($pendamping->foto) }}" alt="Foto Pendamping" class="current-photo">
                                        <div>
                                            <p class="text-sm text-gray-600 font-medium">Foto saat ini</p>
                                            <a href="{{ Storage::url($pendamping->foto) }}" target="_blank" 
                                               class="text-blue-500 hover:text-blue-700 text-sm flex items-center">
                                                <i class="fas fa-external-link-alt mr-1"></i>
                                                Lihat Foto
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="foto" id="foto" 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                       accept="image/jpeg,image/jpg,image/png">
                                <p class="mt-1 text-sm text-gray-500">Maksimal ukuran file: 7MB</p>
                                @error('foto')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Pendampingan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-tasks text-orange-500 mr-2"></i>
                            Aktivitas Pendampingan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui aktivitas yang dilakukan oleh pendamping</p>
                    </div>
                    <div class="form-section-body">
                        <div class="space-y-4">
                            <div class="activity-checkbox">
                                <input type="checkbox" name="penyuluhan" id="penyuluhan" value="1" {{ old('penyuluhan', $pendamping->penyuluhan) ? 'checked' : '' }}>
                                <label for="penyuluhan" class="flex-1 font-medium text-gray-700">Penyuluhan dan Edukasi</label>
                                <div class="w-1/2 ml-4">
                                    <input type="text" name="penyuluhan_frekuensi" id="penyuluhan_frekuensi" value="{{ old('penyuluhan_frekuensi', $pendamping->penyuluhan_frekuensi) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                           placeholder="Frekuensi (misal: 2 kali/minggu)">
                                    @error('penyuluhan_frekuensi')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="activity-checkbox">
                                <input type="checkbox" name="rujukan" id="rujukan" value="1" {{ old('rujukan', $pendamping->rujukan) ? 'checked' : '' }}>
                                <label for="rujukan" class="flex-1 font-medium text-gray-700">Memfasilitasi Pelayanan Rujukan</label>
                                <div class="w-1/2 ml-4">
                                    <input type="text" name="rujukan_frekuensi" id="rujukan_frekuensi" value="{{ old('rujukan_frekuensi', $pendamping->rujukan_frekuensi) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                           placeholder="Frekuensi (misal: 1 kali/bulan)">
                                    @error('rujukan_frekuensi')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="activity-checkbox">
                                <input type="checkbox" name="kunjungan_krs" id="kunjungan_krs" value="1" {{ old('kunjungan_krs', $pendamping->kunjungan_krs) ? 'checked' : '' }}>
                                <label for="kunjungan_krs" class="flex-1 font-medium text-gray-700">Kunjungan Keluarga Berisiko Stunting (KRS)</label>
                                <div class="w-1/2 ml-4">
                                    <input type="text" name="kunjungan_krs_frekuensi" id="kunjungan_krs_frekuensi" value="{{ old('kunjungan_krs_frekuensi', $pendamping->kunjungan_krs_frekuensi) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                           placeholder="Frekuensi (misal: 3 kali/minggu)">
                                    @error('kunjungan_krs_frekuensi')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="activity-checkbox">
                                <input type="checkbox" name="pendataan_bansos" id="pendataan_bansos" value="1" {{ old('pendataan_bansos', $pendamping->pendataan_bansos) ? 'checked' : '' }}>
                                <label for="pendataan_bansos" class="flex-1 font-medium text-gray-700">Pendataan dan Rekomendasi Bantuan Sosial</label>
                                <div class="w-1/2 ml-4">
                                    <input type="text" name="pendataan_bansos_frekuensi" id="pendataan_bansos_frekuensi" value="{{ old('pendataan_bansos_frekuensi', $pendamping->pendataan_bansos_frekuensi) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                           placeholder="Frekuensi (misal: 1 kali/bulan)">
                                    @error('pendataan_bansos_frekuensi')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="activity-checkbox">
                                <input type="checkbox" name="pemantauan_kesehatan" id="pemantauan_kesehatan" value="1" {{ old('pemantauan_kesehatan', $pendamping->pemantauan_kesehatan) ? 'checked' : '' }}>
                                <label for="pemantauan_kesehatan" class="flex-1 font-medium text-gray-700">Pemantauan Kesehatan dan Perkembangan Keluarga</label>
                                <div class="w-1/2 ml-4">
                                    <input type="text" name="pemantauan_kesehatan_frekuensi" id="pemantauan_kesehatan_frekuensi" value="{{ old('pemantauan_kesehatan_frekuensi', $pendamping->pemantauan_kesehatan_frekuensi) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2"
                                           placeholder="Frekuensi (misal: 2 kali/minggu)">
                                    @error('pemantauan_kesehatan_frekuensi')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('pendamping_keluarga.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Data Pendamping
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: 'Pilih Kecamatan',
                allowClear: true
            });

            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true
            });

            $('#kartu_keluarga_ids').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true,
                closeOnSelect: false
            });

            // Load kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $('#kelurahan_id').empty();
                            $('#kelurahan_id').append('<option value="">-- Pilih Kelurahan --</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memuat kelurahan. Silakan coba lagi.',
                                confirmButtonColor: '#3b82f6',
                            });
                        }
                    });
                } else {
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">-- Pilih Kelurahan --</option>');
                    $('#kelurahan_id').trigger('change');
                }
                updateKartuKeluarga();
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            function updateKartuKeluarga() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $('#kelurahan_id').val();
                var data = {};
                if (kecamatanId) data.kecamatan_id = kecamatanId;
                if (kelurahanId) data.kelurahan_id = kelurahanId;

                $.ajax({
                    url: '{{ route("pendamping_keluarga.by-kecamatan-kelurahan") }}',
                    type: 'GET',
                    data: data,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#kartu_keluarga_ids').empty();
                        $('#kartu_keluarga_ids').append('<option value="">-- Pilih Kartu Keluarga --</option>');
                        $.each(data, function(index, kk) {
                            var selected = @json($pendamping->kartuKeluargas->pluck('id')->toArray()).includes(kk.id) ? 'selected' : '';
                            $('#kartu_keluarga_ids').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat kartu keluarga. Silakan coba lagi.',
                            confirmButtonColor: '#3b82f6',
                        });
                    }
                });
            }

            // Inisialisasi kelurahan jika ada data lama
            const initialKecamatanId = '{{ old("kecamatan_id", $pendamping->kecamatan_id) }}';
            if (initialKecamatanId) {
                $('#kecamatan_id').val(initialKecamatanId).trigger('change');
            }
        });
    </script>
</body>
</html>