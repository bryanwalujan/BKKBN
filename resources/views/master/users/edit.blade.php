<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
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
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6;
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
        
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
            position: relative;
        }
        
        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
        }
        
        .form-content {
            padding: 24px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .form-input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s;
            background-color: #f9fafb;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background-color: white;
        }
        
        .form-select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s;
            background-color: #f9fafb;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 8px center;
            background-repeat: no-repeat;
            background-size: 16px;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background-color: white;
        }
        
        .error-message {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
        }
        
        .photo-preview {
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .photo-preview img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .photo-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .photo-info span {
            font-size: 12px;
            color: #6b7280;
        }
        
        .file-input-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px dashed #d1d5db;
            border-radius: 6px;
            background-color: #f9fafb;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .file-input:hover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .file-input::file-selector-button {
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            margin-right: 12px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .file-input::file-selector-button:hover {
            background-color: #2563eb;
        }
        
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
        }
        
        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
        }
        
        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .btn-secondary:hover {
            background-color: #e5e7eb;
        }
        
        .current-photo-label {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
        
        .role-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .role-admin {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .role-petugas_kesehatan {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .role-kader {
            background-color: #dcfce7;
            color: #16a34a;
        }
        
        .role-other {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .user-info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
        }
        
        .user-info-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }
        
        .user-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }
        
        .user-detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .user-detail-label {
            font-size: 12px;
            color: #6b7280;
        }
        
        .user-detail-value {
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .user-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit <span class="gradient-text">Pengguna</span></h1>
            <p class="text-gray-600">Perbarui informasi akun pengguna yang dipilih.</p>
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
        
        <!-- User Info Card -->
        <div class="user-info-card card-hover">
            <div class="user-info-header">
                @if ($user->pas_foto && Storage::disk('public')->exists($user->pas_foto))
                    <img src="{{ Storage::url($user->pas_foto) }}" alt="Foto {{ $user->name }}" class="user-avatar">
                @else
                    <div class="user-avatar bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                    <span class="role-badge 
                        @if($user->role == 'admin') role-admin
                        @elseif($user->role == 'petugas_kesehatan') role-petugas_kesehatan
                        @elseif($user->role == 'kader') role-kader
                        @else role-other @endif">
                        <i class="fas 
                            @if($user->role == 'admin') fa-user-shield
                            @elseif($user->role == 'petugas_kesehatan') fa-user-md
                            @elseif($user->role == 'kader') fa-user-nurse
                            @else fa-user @endif"></i>
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
            </div>
            <div class="user-details">
                <div class="user-detail-item">
                    <span class="user-detail-label">Email</span>
                    <span class="user-detail-value">{{ $user->email }}</span>
                </div>
                <div class="user-detail-item">
                    <span class="user-detail-label">Kecamatan</span>
                    <span class="user-detail-value">{{ $user->kecamatan->nama_kecamatan ?? '-' }}</span>
                </div>
                <div class="user-detail-item">
                    <span class="user-detail-label">Kelurahan</span>
                    <span class="user-detail-value">{{ $user->kelurahan->nama_kelurahan ?? '-' }}</span>
                </div>
                <div class="user-detail-item">
                    <span class="user-detail-label">Penanggung Jawab</span>
                    <span class="user-detail-value">{{ $user->penanggung_jawab ?? '-' }}</span>
                </div>
            </div>
        </div>
        
        <!-- Form Container -->
        <div class="form-container card-hover">
            <div class="form-header">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-user-edit text-blue-500"></i>
                    Form Edit Pengguna
                </h2>
                <p class="text-sm text-gray-600 mt-1">Lengkapi formulir di bawah ini untuk memperbarui data pengguna.</p>
            </div>
            
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="form-content">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <!-- Kolom Kiri -->
                    <div>
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user text-blue-500"></i>
                                Nama Lengkap
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                            @error('name')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope text-blue-500"></i>
                                Alamat Email
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                            @error('email')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-key text-blue-500"></i>
                                Kata Sandi Baru
                            </label>
                            <input type="password" name="password" id="password" class="form-input" placeholder="Kosongkan jika tidak ingin mengubah">
                            @error('password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Minimal 8 karakter dengan kombinasi huruf dan angka
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="role" class="form-label">
                                <i class="fas fa-user-tag text-blue-500"></i>
                                Peran Pengguna
                            </label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Pilih Peran</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r }}" {{ old('role', $user->role) == $r ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $r)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div>
                        <div class="form-group">
                            <label for="kecamatan_id" class="form-label">
                                <i class="fas fa-map-marker-alt text-blue-500"></i>
                                Kecamatan
                            </label>
                            <select name="kecamatan_id" id="kecamatan_id" class="form-select">
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $user->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                        {{ $kecamatan->nama_kecamatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kecamatan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="kelurahan_id" class="form-label">
                                <i class="fas fa-map-pin text-blue-500"></i>
                                Kelurahan
                            </label>
                            <select name="kelurahan_id" id="kelurahan_id" class="form-select">
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id', $user->kelurahan_id) == $kelurahan->id ? 'selected' : '' }}>
                                        {{ $kelurahan->nama_kelurahan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelurahan_id')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="penanggung_jawab" class="form-label">
                                <i class="fas fa-user-check text-blue-500"></i>
                                Penanggung Jawab
                            </label>
                            <input type="text" name="penanggung_jawab" id="penanggung_jawab" value="{{ old('penanggung_jawab', $user->penanggung_jawab ?? '') }}" class="form-input">
                            @error('penanggung_jawab')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="no_telepon" class="form-label">
                                <i class="fas fa-phone text-blue-500"></i>
                                Nomor Telepon
                            </label>
                            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $user->no_telepon ?? '') }}" class="form-input">
                            @error('no_telepon')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="pas_foto" class="form-label">
                                <i class="fas fa-camera text-blue-500"></i>
                                Pas Foto
                            </label>
                            <div class="file-input-container">
                                <input type="file" name="pas_foto" id="pas_foto" class="file-input" accept="image/*">
                            </div>
                            @error('pas_foto')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            
                            @if ($user->pas_foto && Storage::disk('public')->exists($user->pas_foto))
                                <div class="photo-preview">
                                    <img src="{{ Storage::url($user->pas_foto) }}" alt="Foto saat ini">
                                    <div class="photo-info">
                                        <span class="current-photo-label">Foto saat ini:</span>
                                        <span>{{ basename($user->pas_foto) }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="current-photo-label">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Tidak ada foto yang diunggah
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Daftar
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        // Preview image sebelum upload
        document.getElementById('pas_foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Hapus preview lama jika ada
                    const existingPreview = document.querySelector('.photo-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    // Buat elemen preview baru
                    const previewContainer = document.createElement('div');
                    previewContainer.className = 'photo-preview';
                    previewContainer.innerHTML = `
                        <img src="${e.target.result}" alt="Preview foto">
                        <div class="photo-info">
                            <span class="current-photo-label">Preview foto baru:</span>
                            <span>${file.name}</span>
                        </div>
                    `;
                    
                    // Sisipkan setelah input file
                    document.querySelector('.file-input-container').after(previewContainer);
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const role = document.getElementById('role').value;
            
            if (!name || !email || !role) {
                e.preventDefault();
                Swal.fire({
                    title: 'Form Tidak Lengkap',
                    text: 'Harap lengkapi semua field yang wajib diisi.',
                    icon: 'warning',
                    confirmButtonColor: '#3b82f6',
                });
            }
        });
        
        // Menampilkan konfirmasi jika ada perubahan
        let formChanged = false;
        const formInputs = document.querySelectorAll('input, select');
        
        formInputs.forEach(input => {
            input.addEventListener('change', () => {
                formChanged = true;
            });
        });
        
        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
        
        // Update kelurahan berdasarkan kecamatan yang dipilih
        document.getElementById('kecamatan_id').addEventListener('change', function() {
            const kecamatanId = this.value;
            const kelurahanSelect = document.getElementById('kelurahan_id');
            
            // Reset kelurahan options
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            
            if (kecamatanId) {
                // Simulasi pengambilan data kelurahan berdasarkan kecamatan
                // Dalam implementasi nyata, Anda akan menggunakan AJAX untuk mengambil data
                console.log('Kecamatan dipilih:', kecamatanId);
                // Di sini Anda akan menambahkan AJAX call untuk mengambil kelurahan
            }
        });
    </script>
</body>
</html>