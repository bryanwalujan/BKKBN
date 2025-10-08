<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Edukasi - Master Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        .file-input-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .file-input-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            background-color: #f9fafb;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .file-input-custom:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .file-input-custom i {
            font-size: 1.5rem;
            margin-right: 0.5rem;
        }
        .current-file {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background-color: #f0f9ff;
            border-radius: 0.5rem;
            border: 1px solid #e0f2fe;
        }
        .current-file i {
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
                            <i class="fas fa-edit text-purple-600 mr-3"></i>
                            Edit Edukasi
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui materi edukasi untuk stunting</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('edukasi.index') }}" 
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

            <form method="POST" action="{{ route('edukasi.update', $edukasi->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informasi Dasar Edukasi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Informasi Dasar Edukasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui judul dan kategori materi edukasi</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-heading text-blue-500 mr-2 text-xs"></i>
                                    Judul Edukasi
                                </label>
                                <div class="relative">
                                    <input type="text" name="judul" id="judul" value="{{ old('judul', $edukasi->judul) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan judul edukasi" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-pen text-gray-400"></i>
                                    </div>
                                </div>
                                @error('judul')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-tags text-purple-500 mr-2 text-xs"></i>
                                    Kategori
                                </label>
                                <div class="relative">
                                    <select name="kategori" id="kategori" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="" {{ old('kategori', $edukasi->kategori) ? '' : 'selected' }} disabled>Pilih Kategori</option>
                                        @foreach (\App\Models\Edukasi::KATEGORI as $key => $label)
                                            <option value="{{ $key }}" {{ old('kategori', $edukasi->kategori) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('kategori')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Edukasi -->
                <div class="form-section card-hover {{ $edukasi->kategori ? '' : 'hidden' }}" id="additional-fields">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-file-alt text-green-500 mr-2"></i>
                            Konten Edukasi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui deskripsi, tautan, dan file pendukung</p>
                    </div>
                    <div class="form-section-body">
                        <div class="space-y-6">
                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-align-left text-blue-500 mr-2 text-xs"></i>
                                    Deskripsi Edukasi
                                </label>
                                <textarea name="deskripsi" id="deskripsi" rows="4" 
                                          class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                          placeholder="Masukkan deskripsi lengkap tentang materi edukasi">{{ old('deskripsi', $edukasi->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="tautan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-link text-purple-500 mr-2 text-xs"></i>
                                    Tautan Eksternal
                                </label>
                                <div class="relative">
                                    <input type="url" name="tautan" id="tautan" value="{{ old('tautan', $edukasi->tautan) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="https://example.com">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-globe text-gray-400"></i>
                                    </div>
                                </div>
                                @error('tautan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 mr-2 text-xs"></i>
                                    File Pendukung (PDF/Word)
                                </label>
                                <div class="file-input-wrapper">
                                    <div class="file-input-custom">
                                        <i class="fas fa-cloud-upload-alt text-blue-500"></i>
                                        <span class="text-gray-700" id="file-name">Pilih file PDF atau Word baru</span>
                                    </div>
                                    <input type="file" name="file" id="file" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                           accept=".pdf,.doc,.docx">
                                </div>
                                @if ($edukasi->file)
                                    <div class="current-file">
                                        <i class="fas fa-file-alt"></i>
                                        <div>
                                            <p class="text-sm text-gray-700">File saat ini:</p>
                                            <a href="{{ Storage::url($edukasi->file) }}" target="_blank" 
                                               class="text-blue-500 hover:text-blue-700 text-sm font-medium flex items-center">
                                                <i class="fas fa-external-link-alt mr-1 text-xs"></i>
                                                Lihat file
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <p class="mt-1 text-sm text-gray-500">Format yang didukung: PDF, DOC, DOCX</p>
                                @error('file')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media dan Status -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-image text-yellow-500 mr-2"></i>
                            Media dan Status
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui gambar dan atur status publikasi</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-image text-green-500 mr-2 text-xs"></i>
                                    Gambar Utama
                                </label>
                                <div class="file-input-wrapper">
                                    <div class="file-input-custom">
                                        <i class="fas fa-cloud-upload-alt text-blue-500"></i>
                                        <span class="text-gray-700" id="gambar-name">Pilih gambar baru (JPG, JPEG, PNG)</span>
                                    </div>
                                    <input type="file" name="gambar" id="gambar" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                           accept=".jpg,.jpeg,.png">
                                </div>
                                @if ($edukasi->gambar)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-700 mb-2">Gambar saat ini:</p>
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                            <img src="{{ Storage::url($edukasi->gambar) }}" alt="Gambar Edukasi" 
                                                 class="w-32 h-32 object-cover rounded-lg shadow-sm">
                                        </div>
                                    </div>
                                @endif
                                <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, JPEG, PNG</p>
                                @error('gambar')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="status_aktif" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-toggle-on text-purple-500 mr-2 text-xs"></i>
                                    Status Publikasi
                                </label>
                                <div class="relative">
                                    <select name="status_aktif" id="status_aktif" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 appearance-none"
                                            required>
                                        <option value="1" {{ old('status_aktif', $edukasi->status_aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('status_aktif', $edukasi->status_aktif) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                @error('status_aktif')
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
                    <a href="{{ route('edukasi.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <button type="submit" 
                            class="flex items-center px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition-colors card-hover">
                        <i class="fas fa-save mr-2"></i>
                        Perbarui Edukasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tampilkan/sembunyikan bagian konten edukasi berdasarkan kategori
            $('#kategori').on('change', function() {
                const additionalFields = $('#additional-fields');
                if (this.value === '') {
                    additionalFields.hide();
                } else {
                    additionalFields.show();
                }
            });

            // Tampilkan nama file yang dipilih
            $('#file').on('change', function() {
                const fileName = $(this).val().split('\\').pop();
                $('#file-name').text(fileName || 'Pilih file PDF atau Word baru');
            });

            $('#gambar').on('change', function() {
                const fileName = $(this).val().split('\\').pop();
                $('#gambar-name').text(fileName || 'Pilih gambar baru (JPG, JPEG, PNG)');
            });
        });
    </script>
</body>
</html>