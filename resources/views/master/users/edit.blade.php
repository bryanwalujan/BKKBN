<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Master Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
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
        .role-admin { background-color: #dc2626; color: white; }
        .role-kader { background-color: #059669; color: white; }
        .role-puskesmas { background-color: #7c3aed; color: white; }
        .role-dinkes { background-color: #2563eb; color: white; }
        .role-pimpinan { background-color: #d97706; color: white; }
        .role-operator { background-color: #0891b2; color: white; }
        
        .form-input {
            transition: all 0.2s ease;
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .photo-preview {
            transition: all 0.3s ease;
        }
        .photo-preview:hover {
            transform: scale(1.05);
        }
        
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .file-input-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
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
                            Edit Pengguna
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui data pengguna dan akses sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 bg-gray-100 px-3 py-1 rounded-full transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle text-red-500 text-lg mr-3"></i>
                        <h3 class="text-red-800 font-medium">Terjadi Kesalahan</h3>
                    </div>
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden card-hover">
                    <div class="px-6 py-4 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                            Form Edit Pengguna
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Lengkapi form di bawah ini untuk memperbarui data pengguna</p>
                    </div>

                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom Kiri -->
                            <div class="space-y-6">
                                <!-- Informasi Dasar -->
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                    <h4 class="font-medium text-blue-800 mb-3 flex items-center">
                                        <i class="fas fa-id-card mr-2"></i>
                                        Informasi Dasar
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-user text-blue-500 mr-2 text-xs"></i>
                                                Nama Lengkap
                                            </label>
                                            <input type="text" 
                                                   name="name" 
                                                   id="name" 
                                                   value="{{ old('name', $user->name) }}" 
                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 form-input"
                                                   placeholder="Masukkan nama lengkap"
                                                   required>
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-envelope text-blue-500 mr-2 text-xs"></i>
                                                Alamat Email
                                            </label>
                                            <input type="email" 
                                                   name="email" 
                                                   id="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 form-input"
                                                   placeholder="Masukkan alamat email"
                                                   required>
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-lock text-blue-500 mr-2 text-xs"></i>
                                                Password Baru
                                            </label>
                                            <input type="password" 
                                                   name="password" 
                                                   id="password" 
                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 form-input"
                                                   placeholder="Kosongkan jika tidak ingin mengubah">
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            <p class="mt-1 text-xs text-gray-500 flex items-center">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Biarkan kosong jika tidak ingin mengubah password
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Informasi Kontak -->
                                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                                    <h4 class="font-medium text-green-800 mb-3 flex items-center">
                                        <i class="fas fa-address-book mr-2"></i>
                                        Informasi Kontak
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-phone text-green-500 mr-2 text-xs"></i>
                                                Nomor Telepon
                                            </label>
                                            <input type="text" 
                                                   name="no_telepon" 
                                                   id="no_telepon" 
                                                   value="{{ old('no_telepon', $user->no_telepon ?? '') }}" 
                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 form-input"
                                                   placeholder="Masukkan nomor telepon">
                                            @error('no_telepon')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-user-check text-green-500 mr-2 text-xs"></i>
                                                Penanggung Jawab
                                            </label>
                                            <input type="text" 
                                                   name="penanggung_jawab" 
                                                   id="penanggung_jawab" 
                                                   value="{{ old('penanggung_jawab', $user->penanggung_jawab ?? '') }}" 
                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500 p-3 form-input"
                                                   placeholder="Masukkan nama penanggung jawab">
                                            @error('penanggung_jawab')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kolom Kanan -->
                            <div class="space-y-6">
                                <!-- Role & Wilayah -->
                                <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                                    <h4 class="font-medium text-purple-800 mb-3 flex items-center">
                                        <i class="fas fa-user-tag mr-2"></i>
                                        Role & Wilayah
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-user-shield text-purple-500 mr-2 text-xs"></i>
                                                Role Pengguna
                                            </label>
                                            <select name="role" 
                                                    id="role" 
                                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-3 form-input"
                                                    required>
                                                <option value="">Pilih Role</option>
                                                @foreach ($roles as $r)
                                                    <option value="{{ $r }}" {{ old('role', $user->role) == $r ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('_', ' ', $r)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-map-marker-alt text-purple-500 mr-2 text-xs"></i>
                                                Kecamatan
                                            </label>
                                            <select name="kecamatan_id" 
                                                    id="kecamatan_id" 
                                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-3 form-input">
                                                <option value="">Pilih Kecamatan</option>
                                                @foreach ($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                                        {{ $kecamatan->nama_kecamatan }}
                                                    </option>
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
                                                <i class="fas fa-map-pin text-purple-500 mr-2 text-xs"></i>
                                                Kelurahan
                                            </label>
                                            <select name="kelurahan_id" 
                                                    id="kelurahan_id" 
                                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500 p-3 form-input">
                                                <option value="">Pilih Kelurahan</option>
                                                @foreach ($kelurahans as $kelurahan)
                                                    <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $user->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>
                                                        {{ $kelurahan->nama_kelurahan }}
                                                    </option>
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
                                
                                <!-- Foto Profil -->
                                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                                    <h4 class="font-medium text-yellow-800 mb-3 flex items-center">
                                        <i class="fas fa-camera mr-2"></i>
                                        Foto Profil
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="pas_foto" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                                <i class="fas fa-image text-yellow-500 mr-2 text-xs"></i>
                                                Unggah Foto Baru
                                            </label>
                                            <div class="file-input-wrapper">
                                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors cursor-pointer">
                                                    <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                                    <p class="text-sm text-gray-600">Klik untuk memilih file atau seret ke sini</p>
                                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (Maks. 2MB)</p>
                                                    <input type="file" 
                                                           name="pas_foto" 
                                                           id="pas_foto" 
                                                           class="mt-2"
                                                           accept="image/*">
                                                </div>
                                            </div>
                                            @error('pas_foto')
                                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Preview Foto Saat Ini -->
                                        <div>
                                            <p class="text-sm font-medium text-gray-700 mb-2">Foto Saat Ini:</p>
                                            <div class="flex items-center space-x-4">
                                                @if ($user->pas_foto && Storage::disk('public')->exists($user->pas_foto))
                                                    <img src="{{ Storage::url($user->pas_foto) }}" 
                                                         alt="Pas Foto {{ $user->name }}" 
                                                         class="w-20 h-20 object-cover photo-preview rounded-lg shadow-sm border border-gray-200">
                                                    <div class="text-sm text-gray-600">
                                                        <p class="font-medium">{{ $user->name }}</p>
                                                        <p class="text-xs text-gray-500">Foto saat ini</p>
                                                    </div>
                                                @else
                                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                                        <i class="fas fa-user text-xl"></i>
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        <p class="font-medium">{{ $user->name }}</p>
                                                        <p class="text-xs text-gray-500">Belum ada foto</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                            <a href="{{ route('users.index') }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors flex items-center shadow-sm">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Informasi Pengguna -->
                <div class="mt-6 bg-white rounded-xl shadow-sm border overflow-hidden">
                    <div class="px-6 py-4 border-b bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Informasi Pengguna
                        </h3>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('select').select2({
                placeholder: 'Pilih opsi',
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });
            
            // Preview image before upload
            $('#pas_foto').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Create preview if doesn't exist
                        if ($('#photoPreview').length === 0) {
                            $('.file-input-wrapper').after(`
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">Pratinjau Foto Baru:</p>
                                    <img id="photoPreview" src="${e.target.result}" 
                                         class="w-20 h-20 object-cover photo-preview rounded-lg shadow-sm border border-gray-200">
                                </div>
                            `);
                        } else {
                            $('#photoPreview').attr('src', e.target.result);
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</body>
</html>