<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Carousel - Master Panel</title>
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
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }
        .input-with-icon {
            padding-left: 40px;
        }
        .preview-image {
            max-height: 200px;
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
                            <i class="fas fa-edit text-purple-600 mr-3"></i>
                            Edit Carousel
                        </h1>
                        <p class="text-gray-600 mt-1">Edit konten carousel untuk halaman utama</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('carousel.index') }}" 
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

            <form action="{{ route('carousel.update', $carousel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Informasi Konten Utama -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-edit text-blue-500 mr-2"></i>
                            Informasi Konten Utama
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Edit konten teks untuk carousel</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="sub_heading" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-heading text-purple-500 mr-2 text-xs"></i>
                                    Sub Heading
                                </label>
                                <div class="relative">
                                    <input type="text" name="sub_heading" id="sub_heading" value="{{ old('sub_heading', $carousel->sub_heading) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 input-with-icon"
                                           placeholder="Masukkan sub heading carousel" required>
                                    <div class="input-icon">
                                        <i class="fas fa-text-height"></i>
                                    </div>
                                </div>
                                @error('sub_heading')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="heading" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-heading text-green-500 mr-2 text-xs"></i>
                                    Heading Utama
                                </label>
                                <div class="relative">
                                    <input type="text" name="heading" id="heading" value="{{ old('heading', $carousel->heading) }}" 
                                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 input-with-icon"
                                           placeholder="Masukkan heading utama carousel" required>
                                    <div class="input-icon">
                                        <i class="fas fa-heading"></i>
                                    </div>
                                </div>
                                @error('heading')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-align-left text-yellow-500 mr-2 text-xs"></i>
                                    Deskripsi
                                </label>
                                <div class="relative">
                                    <textarea name="deskripsi" id="deskripsi" rows="4"
                                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 input-with-icon"
                                              placeholder="Masukkan deskripsi carousel" required>{{ old('deskripsi', $carousel->deskripsi) }}</textarea>
                                    <div class="input-icon" style="top: 20px;">
                                        <i class="fas fa-paragraph"></i>
                                    </div>
                                </div>
                                @error('deskripsi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-mouse-pointer text-indigo-500 mr-2"></i>
                            Tombol Aksi
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Konfigurasi tombol aksi pada carousel (opsional)</p>
                    </div>
                    <div class="form-section-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h3 class="text-md font-medium text-gray-700 flex items-center">
                                    <i class="fas fa-button text-blue-500 mr-2 text-xs"></i>
                                    Tombol 1
                                </h3>
                                
                                <div>
                                    <label for="button_1_text" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-font text-gray-500 mr-2 text-xs"></i>
                                        Teks Tombol
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="button_1_text" id="button_1_text" value="{{ old('button_1_text', $carousel->button_1_text) }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 input-with-icon"
                                               placeholder="Teks untuk tombol pertama">
                                        <div class="input-icon">
                                            <i class="fas fa-i-cursor"></i>
                                        </div>
                                    </div>
                                    @error('button_1_text')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button_1_link" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-link text-gray-500 mr-2 text-xs"></i>
                                        Link Tujuan
                                    </label>
                                    <div class="relative">
                                        <input type="url" name="button_1_link" id="button_1_link" value="{{ old('button_1_link', $carousel->button_1_link) }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 input-with-icon"
                                               placeholder="https://example.com">
                                        <div class="input-icon">
                                            <i class="fas fa-external-link-alt"></i>
                                        </div>
                                    </div>
                                    @error('button_1_link')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-md font-medium text-gray-700 flex items-center">
                                    <i class="fas fa-button text-green-500 mr-2 text-xs"></i>
                                    Tombol 2
                                </h3>
                                
                                <div>
                                    <label for="button_2_text" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-font text-gray-500 mr-2 text-xs"></i>
                                        Teks Tombol
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="button_2_text" id="button_2_text" value="{{ old('button_2_text', $carousel->button_2_text) }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 input-with-icon"
                                               placeholder="Teks untuk tombol kedua">
                                        <div class="input-icon">
                                            <i class="fas fa-i-cursor"></i>
                                        </div>
                                    </div>
                                    @error('button_2_text')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button_2_link" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-link text-gray-500 mr-2 text-xs"></i>
                                        Link Tujuan
                                    </label>
                                    <div class="relative">
                                        <input type="url" name="button_2_link" id="button_2_link" value="{{ old('button_2_link', $carousel->button_2_link) }}" 
                                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 input-with-icon"
                                               placeholder="https://example.com">
                                        <div class="input-icon">
                                            <i class="fas fa-external-link-alt"></i>
                                        </div>
                                    </div>
                                    @error('button_2_link')
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

                <!-- Gambar Carousel -->
                <div class="form-section card-hover">
                    <div class="form-section-header">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-image text-red-500 mr-2"></i>
                            Gambar Carousel
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Unggah gambar baru untuk carousel (opsional)</p>
                    </div>
                    <div class="form-section-body">
                        <!-- Gambar Saat Ini -->
                        @if ($carousel->gambar)
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-image text-blue-500 mr-2 text-xs"></i>
                                Gambar Saat Ini:
                            </p>
                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <img src="{{ asset('storage/' . $carousel->gambar) }}" alt="Gambar {{ $carousel->heading }}" class="preview-image mx-auto">
                            </div>
                        </div>
                        @endif
                        
                        <!-- Unggah Gambar Baru -->
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-upload text-blue-500 mr-2 text-xs"></i>
                                {{ $carousel->gambar ? 'Ganti Gambar' : 'Unggah Gambar' }}
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="gambar" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                                        <p class="mb-1 text-sm text-gray-500">Klik untuk mengunggah atau seret dan lepas</p>
                                        <p class="text-xs text-gray-500">JPEG, JPG, atau PNG (Maks. 5MB)</p>
                                    </div>
                                    <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/jpg,image/png" class="hidden" />
                                </label>
                            </div>
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Preview Gambar Baru -->
                        <div id="image-preview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Pratinjau Gambar Baru:</p>
                            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                <img id="preview" class="preview-image mx-auto" alt="Preview gambar carousel">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6">
                    <a href="{{ route('carousel.index') }}" 
                       class="flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    <div class="flex space-x-3">
                        <a href="{{ route('carousel.show', $carousel->id) }}" 
                           class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors card-hover">
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Detail
                        </a>
                        <button type="submit" 
                                class="flex items-center px-6 py-3 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-lg transition-colors card-hover">
                            <i class="fas fa-save mr-2"></i>
                            Perbarui Carousel
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
            // Preview gambar saat dipilih
            $('#gambar').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result);
                        $('#image-preview').removeClass('hidden');
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    $('#image-preview').addClass('hidden');
                }
            });

            // Validasi form sebelum submit
            $('form').on('submit', function(e) {
                const subHeading = $('#sub_heading').val().trim();
                const heading = $('#heading').val().trim();
                const deskripsi = $('#deskripsi').val().trim();
                
                if (!subHeading || !heading || !deskripsi) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Form Tidak Lengkap',
                        text: 'Harap lengkapi semua field yang wajib diisi',
                        confirmButtonColor: '#3b82f6',
                    });
                }
            });
        });
    </script>
</body>
</html>