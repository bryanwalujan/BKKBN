<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Balita - Master Panel</title>
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
        .photo-preview {
            transition: all 0.3s ease;
        }
        .photo-preview:hover {
            transform: scale(1.05);
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
                            Edit Data Balita
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui data balita {{ $balita->nama }} dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('balita.index') }}" 
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

            <form action="{{ route('balita.update', $balita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informasi Lokasi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                            Informasi Lokasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui lokasi tempat tinggal balita</p>
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
                                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $balita->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
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
                                        <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $balita->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
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

                <!-- Informasi Kartu Keluarga -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-id-card text-blue-500 mr-2"></i>
                            Informasi Kartu Keluarga
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui kartu keluarga yang sesuai</p>
                    </div>
                    <div class="form-section-body">
                        <div>
                            <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-hashtag text-purple-500 mr-2 text-xs"></i>
                                Nomor Kartu Keluarga
                            </label>
                            <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3" required>
                                <option value="">-- Pilih Kartu Keluarga --</option>
                                @foreach (\App\Models\KartuKeluarga::where('kecamatan_id', $balita->kecamatan_id)->where('kelurahan_id', $balita->kelurahan_id)->get() as $kk)
                                    <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id', $balita->kartu_keluarga_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                                @endforeach
                            </select>
                            @error('kartu_keluarga_id')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Pribadi Balita -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user text-yellow-500 mr-2"></i>
                            Informasi Pribadi Balita
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data pribadi balita</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-address-card text-blue-500 mr-2 text-xs"></i>
                                    NIK
                                </label>
                                <div class="relative">
                                    <input type="text" name="nik" id="nik" value="{{ old('nik', $balita->nik) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           pattern="[0-9]{16}" inputmode="numeric" maxlength="16" placeholder="Masukkan 16 digit NIK">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                </div>
                                @error('nik')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-signature text-green-500 mr-2 text-xs"></i>
                                    Nama Lengkap
                                </label>
                                <div class="relative">
                                    <input type="text" name="nama" id="nama" value="{{ old('nama', $balita->nama) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan nama lengkap balita" required>
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
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt text-purple-500 mr-2 text-xs"></i>
                                    Tanggal Lahir
                                </label>
                                <div class="relative">
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $balita->tanggal_lahir ? $balita->tanggal_lahir->format('Y-m-d') : '') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-birthday-cake text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-venus-mars text-pink-500 mr-2 text-xs"></i>
                                    Jenis Kelamin
                                </label>
                                <div class="relative">
                                    <select name="jenis_kelamin" id="jenis_kelamin" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin', $balita->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Pengukuran -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-ruler-combined text-red-500 mr-2"></i>
                            Data Pengukuran
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui data pengukuran fisik balita</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="berat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-weight-scale text-blue-500 mr-2 text-xs"></i>
                                    Berat (kg)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" name="berat" id="berat" value="{{ old('berat', explode('/', $balita->berat_tinggi)[0] ?? '') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="0.0" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-weight text-gray-400"></i>
                                    </div>
                                </div>
                                @error('berat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tinggi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-ruler-vertical text-green-500 mr-2 text-xs"></i>
                                    Tinggi (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" name="tinggi" id="tinggi" value="{{ old('tinggi', explode('/', $balita->berat_tinggi)[1] ?? '') }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="0.0" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-arrows-up-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tinggi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="lingkar_kepala" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-circle text-purple-500 mr-2 text-xs"></i>
                                    Lingkar Kepala (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" name="lingkar_kepala" id="lingkar_kepala" value="{{ old('lingkar_kepala', $balita->lingkar_kepala) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="0.0">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-circle-nodes text-gray-400"></i>
                                    </div>
                                </div>
                                @error('lingkar_kepala')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="lingkar_lengan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-circle text-yellow-500 mr-2 text-xs"></i>
                                    Lingkar Lengan (cm)
                                </label>
                                <div class="relative">
                                    <input type="number" step="0.1" name="lingkar_lengan" id="lingkar_lengan" value="{{ old('lingkar_lengan', $balita->lingkar_lengan) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="0.0">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-circle-nodes text-gray-400"></i>
                                    </div>
                                </div>
                                @error('lingkar_lengan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                            Informasi Tambahan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui informasi tambahan tentang balita</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-home text-blue-500 mr-2 text-xs"></i>
                                    Alamat Lengkap
                                </label>
                                <textarea name="alamat" id="alamat" rows="3"
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                          placeholder="Masukkan alamat lengkap balita">{{ old('alamat', $balita->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-camera text-green-500 mr-2 text-xs"></i>
                                    Foto Balita
                                </label>
                                @if ($balita->foto)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-2 flex items-center">
                                            <i class="fas fa-image mr-2 text-blue-500"></i>
                                            Foto saat ini:
                                        </p>
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ Storage::url($balita->foto) }}" alt="Foto Balita" 
                                                 class="w-24 h-24 object-cover rounded-lg shadow-md photo-preview">
                                            <div class="text-sm text-gray-600">
                                                <p class="font-medium">Upload foto baru</p>
                                                <p class="text-xs">untuk mengganti foto saat ini</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="foto" id="foto" 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                       accept="image/*">
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

                <!-- Status dan Pemantauan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                            Status dan Pemantauan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui status gizi dan pemantauan balita</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="status_gizi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-apple-whole text-green-500 mr-2 text-xs"></i>
                                    Status Gizi
                                </label>
                                <div class="relative">
                                    <select name="status_gizi" id="status_gizi" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="Sehat" {{ old('status_gizi', $balita->status_gizi) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                        <option value="Stunting" {{ old('status_gizi', $balita->status_gizi) == 'Stunting' ? 'selected' : '' }}>Stunting</option>
                                        <option value="Kurang Gizi" {{ old('status_gizi', $balita->status_gizi) == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                                        <option value="Obesitas" {{ old('status_gizi', $balita->status_gizi) == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status_gizi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="warna_label" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-palette text-purple-500 mr-2 text-xs"></i>
                                    Warna Label
                                </label>
                                <div class="relative">
                                    <select name="warna_label" id="warna_label" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="Sehat" {{ old('warna_label', $balita->warna_label) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                                        <option value="Waspada" {{ old('warna_label', $balita->warna_label) == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                                        <option value="Bahaya" {{ old('warna_label', $balita->warna_label) == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('warna_label')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="status_pemantauan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-eye text-blue-500 mr-2 text-xs"></i>
                                    Status Pemantauan
                                </label>
                                <div class="relative">
                                    <input type="text" name="status_pemantauan" id="status_pemantauan" value="{{ old('status_pemantauan', $balita->status_pemantauan) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Status pemantauan">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-clipboard-list text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status_pemantauan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('balita.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Data Balita
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

            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            // Load kelurahans and kartu keluarga for initial kecamatan_id on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#kelurahan_id').empty();
                        $('#kelurahan_id').append('<option value="">-- Pilih Kelurahan --</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == {{ old('kelurahan_id', $balita->kelurahan_id) ?? 'null' }} ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
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
                updateKartuKeluarga();
            }

            // Update kelurahans and kartu keluarga when kecamatan changes
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
                if (!kecamatanId || !kelurahanId) {
                    $('#kartu_keluarga_id').empty();
                    $('#kartu_keluarga_id').append('<option value="">-- Pilih Kartu Keluarga --</option>');
                    $('#kartu_keluarga_id').trigger('change');
                    return;
                }

                $.ajax({
                    url: '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}',
                    type: 'GET',
                    data: {
                        kecamatan_id: kecamatanId,
                        kelurahan_id: kelurahanId
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#kartu_keluarga_id').empty();
                        $('#kartu_keluarga_id').append('<option value="">-- Pilih Kartu Keluarga --</option>');
                        $.each(data, function(index, kk) {
                            var selected = kk.id == {{ old('kartu_keluarga_id', $balita->kartu_keluarga_id) ?? 'null' }} ? 'selected' : '';
                            $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                        });
                        $('#kartu_keluarga_id').trigger('change');
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

            // Validasi sisi klien untuk NIK
            $('#nik').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Hanya izinkan angka
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16); // Batasi 16 digit
                }
            });
        });
    </script>
</body>
</html>