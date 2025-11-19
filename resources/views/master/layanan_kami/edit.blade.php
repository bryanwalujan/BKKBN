<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Layanan Kami - Master Panel</title>
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
        .character-counter {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: right;
            margin-top: 0.25rem;
        }
        .character-counter.warning {
            color: #f59e0b;
        }
        .character-counter.danger {
            color: #ef4444;
        }
        .image-preview-container {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            border: 2px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f9fafb;
        }
        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
                            <i class="fas fa-edit text-indigo-600 mr-3"></i>
                            Edit Layanan Kami
                        </h1>
                        <p class="text-gray-600 mt-1">Perbarui informasi layanan yang sudah ada</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('layanan_kami.index') }}" 
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

            <form action="{{ route('layanan_kami.update', $layananKami->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informasi Layanan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                            Informasi Layanan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui informasi dasar tentang layanan</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="judul_layanan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-heading text-purple-500 mr-2 text-xs"></i>
                                    Judul Layanan
                                </label>
                                <div class="relative">
                                    <input type="text" name="judul_layanan" id="judul_layanan" value="{{ old('judul_layanan', $layananKami->judul_layanan) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                           placeholder="Masukkan judul layanan" required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-gray-400"></i>
                                    </div>
                                </div>
                                @error('judul_layanan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-align-left text-green-500 mr-2 text-xs"></i>
                                    Deskripsi Singkat
                                    <span class="ml-1 text-xs text-gray-500">(maks. 500 karakter)</span>
                                </label>
                                <div class="relative">
                                    <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="3"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                              maxlength="500" placeholder="Masukkan deskripsi singkat layanan" required>{{ old('deskripsi_singkat', $layananKami->deskripsi_singkat) }}</textarea>
                                </div>
                                <div id="counter-singkat" class="character-counter">
                                    <span id="count-singkat">{{ strlen(old('deskripsi_singkat', $layananKami->deskripsi_singkat)) }}</span>/500 karakter
                                </div>
                                @error('deskripsi_singkat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi_lengkap" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-align-justify text-blue-500 mr-2 text-xs"></i>
                                    Deskripsi Lengkap
                                    <span class="ml-1 text-xs text-gray-500">(opsional)</span>
                                </label>
                                <div class="relative">
                                    <textarea name="deskripsi_lengkap" id="deskripsi_lengkap" rows="5"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                              placeholder="Masukkan deskripsi lengkap layanan">{{ old('deskripsi_lengkap', $layananKami->deskripsi_lengkap) }}</textarea>
                                </div>
                                @error('deskripsi_lengkap')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media dan Pengaturan -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-cog text-yellow-500 mr-2"></i>
                            Media dan Pengaturan
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui ikon dan pengaturan layanan</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="ikon" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-image text-indigo-500 mr-2 text-xs"></i>
                                    Ikon Layanan
                                </label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <input type="file" name="ikon" id="ikon" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                                               accept="image/jpeg,image/jpg,image/png" onchange="previewImage(this, 'preview_ikon')">
                                        <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG</p>
                                        <p class="mt-1 text-xs text-blue-500">Biarkan kosong jika tidak ingin mengubah ikon</p>
                                    </div>
                                    <div class="flex flex-col items-center space-y-2">
                                        <div class="image-preview-container">
                                            @if($layananKami->ikon)
                                                <img id="preview_ikon" src="{{ asset('storage/' . $layananKami->ikon) }}" alt="Preview Ikon" class="image-preview">
                                            @else
                                                <img id="preview_ikon" src="" alt="Preview Ikon" class="image-preview hidden">
                                                <i class="fas fa-image text-gray-400 text-xl" id="placeholder_ikon"></i>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-500">Preview</span>
                                    </div>
                                </div>
                                @error('ikon')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-sort-numeric-down text-red-500 mr-2 text-xs"></i>
                                        Urutan Tampilan
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $layananKami->urutan) }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 pl-10"
                                               min="1" required>
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-list-ol text-gray-400"></i>
                                        </div>
                                    </div>
                                    @error('urutan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <div class="relative flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="status_aktif" id="status_aktif" 
                                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                                                   {{ old('status_aktif', $layananKami->status_aktif) ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="status_aktif" class="font-medium text-gray-700 flex items-center">
                                                <i class="fas fa-toggle-on text-green-500 mr-2"></i>
                                                Status Aktif
                                            </label>
                                            <p class="text-gray-500">Layanan akan ditampilkan di halaman depan</p>
                                        </div>
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
                    <a href="{{ route('layanan_kami.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <div class="flex space-x-3">
                        <button type="button" 
                                onclick="window.location.href='{{ route('layanan_kami.index') }}'"
                                class="flex items-center px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </button>
                        <button type="submit" 
                                class="flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-medium rounded-lg transition-colors card-hover">
                            <i class="fas fa-save mr-2"></i>
                            Perbarui Layanan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Character counter for deskripsi_singkat
            $('#deskripsi_singkat').on('input', function() {
                const count = $(this).val().length;
                const max = 500;
                $('#count-singkat').text(count);
                
                const counter = $('#counter-singkat');
                counter.removeClass('warning danger');
                
                if (count > max * 0.8) {
                    counter.addClass('warning');
                }
                
                if (count > max) {
                    counter.addClass('danger');
                }
            });
            
            // Trigger initial count
            $('#deskripsi_singkat').trigger('input');
        });

        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById('placeholder_ikon');
            
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            } else {
                // If no file selected, show the existing image
                const existingImage = "{{ $layananKami->ikon ? asset('storage/' . $layananKami->ikon) : '' }}";
                if (existingImage) {
                    preview.src = existingImage;
                    preview.classList.remove('hidden');
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                } else {
                    preview.src = '';
                    preview.classList.add('hidden');
                    if (placeholder) {
                        placeholder.classList.remove('hidden');
                    }
                }
            }
        }
    </script>
</body>
</html>