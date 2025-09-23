<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Anda</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .bg-primary { background-color: #1447e6; }
        .text-primary { color: #1447e6; }
        .border-primary { border-color: #1447e6; }
        .bg-secondary { background-color: #26d48c; }
        .text-secondary { color: #26d48c; }
        .border-secondary { border-color: #26d48c; }
        
        .btn-primary {
            background-color: #1447e6;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0f38c4;
        }
        
        .btn-secondary {
            background-color: #26d48c;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #20b878;
        }
        
        .focus-primary:focus {
            border-color: #1447e6;
            box-shadow: 0 0 0 3px rgba(20, 71, 230, 0.2);
        }
        
        .logo-placeholder {
            width: 80px;
            height: 80px;
            background-color: #f3f4f6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 2px dashed #d1d5db;
            color: #9ca3af;
            font-size: 0.75rem;
            text-align: center;
        }
        
        .select2-container--default .select2-selection--single {
            height: 48px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        
        .select2-container--default .select2-selection--single:focus {
            outline: none;
            border-color: #1447e6;
            box-shadow: 0 0 0 3px rgba(20, 71, 230, 0.2);
        }
        
        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            height: 100%;
            width: 100%;
        }
        
        .file-upload-label {
            display: block;
            padding: 12px 16px;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            border-radius: 0.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-upload-label:hover {
            border-color: #1447e6;
            background: #f0f4ff;
        }
        
        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4 py-8">
    <div class="max-w-2xl w-full">
        <!-- Logo Area -->
        <div class="text-center mb-8">
            <!-- Template untuk logo - ganti dengan logo Anda -->
            <div class="logo-placeholder">
                Logo Anda<br>(80x80px)
            </div>
            <!-- <img src="/path/to/your/logo.png" alt="Logo" class="h-20 mx-auto mb-4"> -->
            <h1 class="text-3xl font-bold text-gray-800">Buat Akun Baru</h1>
            <p class="text-gray-600 mt-2">Isi formulir di bawah untuk mendaftar</p>
        </div>
        
        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="bg-green-50 text-green-700 p-4 mb-6 rounded-lg border border-green-200 flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-lg border border-red-200 flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-lg border border-red-200">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <strong class="font-medium">Terjadi kesalahan:</strong>
                                <ul class="mt-1 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                    @csrf
                    
                    <!-- Nama Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" 
                                   placeholder="Masukkan nama lengkap" required autofocus>
                        </div>
                        @error('name')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Email Field -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" 
                                   placeholder="nama@contoh.com" required>
                        </div>
                        @error('email')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" 
                                   placeholder="Masukkan kata sandi" required>
                        </div>
                        @error('password')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Confirm Password Field -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" 
                                   placeholder="Konfirmasi kata sandi" required>
                        </div>
                    </div>
                    
                    <!-- Role Field -->
                    <div class="mb-6">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                            <select name="role" id="role" class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" required>
                                <option value="">-- Pilih Peran --</option>
                                <option value="admin_kelurahan" {{ old('role') == 'admin_kelurahan' ? 'selected' : '' }}>Admin Kelurahan</option>
                                <option value="perangkat_daerah" {{ old('role') == 'perangkat_daerah' ? 'selected' : '' }}>Perangkat Daerah</option>
                            </select>
                        </div>
                        @error('role')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Kecamatan Field -->
                    <div class="mb-6">
                        <label for="kecamatan_id" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                        <select name="kecamatan_id" id="kecamatan_id" class="w-full" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                        @error('kecamatan_id')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Kelurahan Field -->
                    <div class="mb-6">
                        <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-2" id="kelurahan_label">Kelurahan/Desa</label>
                        <select name="kelurahan_id" id="kelurahan_id" class="w-full" required>
                            <option value="">-- Pilih Kelurahan/Desa --</option>
                            @if (old('kecamatan_id'))
                                @foreach (\App\Models\Kelurahan::where('kecamatan_id', old('kecamatan_id'))->get() as $kelurahan)
                                    <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('kelurahan_id')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Penanggung Jawab Field -->
                    <div class="mb-6">
                        <label for="penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-2">Penanggung Jawab</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" name="penanggung_jawab" id="penanggung_jawab" value="{{ old('penanggung_jawab') }}" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" 
                                   placeholder="Nama penanggung jawab" required>
                        </div>
                        @error('penanggung_jawab')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- No Telepon Field -->
                    <div class="mb-6">
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                            </div>
                            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" 
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" 
                                   placeholder="Contoh: 081234567890" required>
                        </div>
                        @error('no_telepon')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Pas Foto Field -->
                    <div class="mb-6">
                        <label for="pas_foto" class="block text-sm font-medium text-gray-700 mb-2">Pas Foto</label>
                        <div class="file-upload">
                            <input type="file" name="pas_foto" id="pas_foto" class="file-upload-input" accept="image/jpeg,image/png" required>
                            <label for="pas_foto" class="file-upload-label">
                                <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-primary font-medium">Unggah Pas Foto</span>
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                            </label>
                            <div id="pas-foto-name" class="file-name"></div>
                        </div>
                        @error('pas_foto')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Surat Pengajuan Field -->
                    <div class="mb-6">
                        <label for="surat_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">Surat Pengajuan</label>
                        <div class="file-upload">
                            <input type="file" name="surat_pengajuan" id="surat_pengajuan" class="file-upload-input" accept="application/pdf" required>
                            <label for="surat_pengajuan" class="file-upload-label">
                                <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-primary font-medium">Unggah Surat Pengajuan</span>
                                <p class="text-xs text-gray-500 mt-1">Format: PDF (Maks. 5MB)</p>
                            </label>
                            <div id="surat-pengajuan-name" class="file-name"></div>
                        </div>
                        @error('surat_pengajuan')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full btn-primary py-3 px-4 rounded-lg font-medium text-white transition duration-150 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mb-4">
                        Daftar
                    </button>
                </form>
                
                <!-- Download Template Link -->
                <div class="text-center mb-4">
                    <a href="{{ route('download.template') }}" class="text-primary font-medium hover:underline transition duration-150 ease-in-out inline-flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Template Surat Pengajuan
                    </a>
                </div>
                
                <!-- Login Link -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:underline transition duration-150 ease-in-out">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-6 text-gray-500 text-sm">
            &copy; {{ date('Y') }} Nama Perusahaan. Semua hak dilindungi.
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: '-- Pilih Kecamatan --',
                allowClear: true,
                width: '100%'
            });
            
            $('#kelurahan_id').select2({
                placeholder: '-- Pilih Kelurahan/Desa --',
                allowClear: true,
                width: '100%'
            });

            // Kecamatan change event
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>').trigger('change');

                if (kecamatanId) {
                    $.ajax({
                        url: '/kelurahans/by-kecamatan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kelurahan:', xhr);
                            alert('Gagal memuat kelurahan. Silakan coba lagi.');
                        }
                    });
                }
            });

            // Role change event
            $('#role').on('change', function() {
                const kelurahanLabel = $('#kelurahan_label');
                kelurahanLabel.text(kelurahanLabel.text().replace(/Kelurahan|Desa/g, this.value === 'perangkat_daerah' ? 'Desa' : 'Kelurahan'));
            }).trigger('change');

            // File upload name display
            $('#pas_foto').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $('#pas-foto-name').text(fileName || 'Tidak ada file dipilih');
            });
            
            $('#surat_pengajuan').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $('#surat-pengajuan-name').text(fileName || 'Tidak ada file dipilih');
            });

            // Trigger change untuk memuat kelurahan jika ada old('kecamatan_id')
            @if (old('kecamatan_id'))
                $('#kecamatan_id').val('{{ old('kecamatan_id') }}').trigger('change');
            @endif
            
            // Form animation
            const form = document.getElementById('registerForm');
            form.classList.add('opacity-0');
            
            setTimeout(() => {
                form.classList.remove('opacity-0');
                form.classList.add('opacity-100');
            }, 100);
        });
    </script>
</body>
</html>