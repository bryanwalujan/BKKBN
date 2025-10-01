<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Template - CSSR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .file-upload-area:hover, .file-upload-area.dragover {
            border-color: #3b82f6;
            background-color: #f0f9ff;
        }
        
        .template-card {
            transition: all 0.3s ease;
            border-left: 4px solid #3b82f6;
        }
        
        .template-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }
        
        .btn-delete {
            transition: all 0.3s ease;
        }
        
        .btn-delete:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.2);
        }
        
        .empty-state {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('master.partials.sidebar')
    
    <div class="ml-64 p-6 fade-in">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola <span class="gradient-text">Template</span></h1>
            <p class="text-gray-600">Upload dan kelola template surat pengajuan akun untuk Admin Kelurahan dan Perangkat Desa.</p>
            <div class="flex items-center mt-2 text-sm text-gray-500">
                <i class="fas fa-file-contract mr-2"></i>
                <span>Total Template: {{ count($templates) }}</span>
            </div>
        </div>
        
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Upload Template Card -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 card-hover">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-upload text-blue-500"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Upload Template Baru</h2>
                    <p class="text-gray-600 text-sm">Format file yang didukung: .docx</p>
                </div>
            </div>
            
            <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-blue-500"></i>Nama Template
                        </label>
                        <input type="text" name="name" id="name" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                               placeholder="Contoh: Template Pengajuan Akun Kelurahan" required>
                        @error('name')
                            <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-file-word mr-1 text-blue-500"></i>File Template
                        </label>
                        <div class="file-upload-area p-4 text-center cursor-pointer" id="fileUploadArea">
                            <input type="file" name="file" id="file" class="hidden" accept=".docx" required>
                            <div id="fileUploadContent">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Klik untuk memilih file atau drag & drop di sini</p>
                                <p class="text-sm text-gray-500 mt-1">Format .docx (maks. 10MB)</p>
                            </div>
                            <div id="fileSelected" class="hidden">
                                <i class="fas fa-file-word text-3xl text-blue-500 mb-2"></i>
                                <p class="text-gray-800 font-medium" id="fileName">File terpilih</p>
                                <p class="text-sm text-gray-500 mt-1">Klik untuk mengganti file</p>
                            </div>
                        </div>
                        @error('file')
                            <span class="text-red-600 text-sm mt-1 block"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 font-medium flex items-center gap-2 shadow-md">
                        <i class="fas fa-upload"></i>
                        Upload Template
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Daftar Template -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Template Tersedia</h2>
                    <p class="text-gray-600 text-sm">Template yang dapat digunakan untuk pengajuan akun</p>
                </div>
                <div class="text-sm text-gray-500 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    <span>{{ count($templates) }} template tersedia</span>
                </div>
            </div>
            
            @if(count($templates) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($templates as $template)
                        <div class="template-card bg-white border border-gray-200 rounded-lg p-5">
                            <div class="flex justify-between items-start mb-4">
                                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-word text-blue-500 text-xl"></i>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ Storage::url($template->file_path) }}" target="_blank" 
                                       class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center hover:bg-green-200 transition"
                                       title="Lihat Template">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <form action="{{ route('templates.destroy', $template->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center hover:bg-red-200 transition btn-delete"
                                                title="Hapus Template"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus template ini?')">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <h3 class="font-semibold text-gray-800 mb-2 truncate">{{ $template->name }}</h3>
                            
                            <div class="flex items-center text-sm text-gray-500 mt-4">
                                <i class="far fa-calendar mr-2"></i>
                                <span>Diupload: {{ \Carbon\Carbon::parse($template->created_at)->format('d/m/Y') }}</span>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ Storage::url($template->file_path) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-2 transition">
                                    <i class="fas fa-download"></i>
                                    Download Template
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state rounded-lg p-8 text-center">
                    <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">Belum ada template</h3>
                    <p class="text-gray-500">Upload template pertama Anda untuk memulai</p>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>© {{ date('Y') }} CSSR - Sistem Informasi Stunting. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileUploadContent = document.getElementById('fileUploadContent');
            const fileSelected = document.getElementById('fileSelected');
            const fileName = document.getElementById('fileName');
            
            // Handle file selection
            fileUploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    fileName.textContent = file.name;
                    fileUploadContent.classList.add('hidden');
                    fileSelected.classList.remove('hidden');
                }
            });
            
            // Drag and drop functionality
            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });
            
            fileUploadArea.addEventListener('dragleave', function() {
                this.classList.remove('dragover');
            });
            
            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    fileInput.files = e.dataTransfer.files;
                    const file = e.dataTransfer.files[0];
                    fileName.textContent = file.name;
                    fileUploadContent.classList.add('hidden');
                    fileSelected.classList.remove('hidden');
                }
            });
            
            // Form submission feedback
            const form = document.getElementById('uploadForm');
            form.addEventListener('submit', function() {
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
                submitButton.disabled = true;
            });
        });
    </script>
</body>
</html>