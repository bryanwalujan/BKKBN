<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Anda</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo Area -->
        <div class="text-center mb-8">
            <!-- Template untuk logo - ganti dengan logo Anda -->
            <div class="logo-placeholder">
                Logo Anda<br>(80x80px)
            </div>
            <!-- <img src="/path/to/your/logo.png" alt="Logo" class="h-20 mx-auto mb-4"> -->
            <h1 class="text-3xl font-bold text-gray-800">Nama Aplikasi</h1>
            <p class="text-gray-600 mt-2">Silakan masuk ke akun Anda</p>
        </div>
        
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8">
                @if (session('error'))
                    <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-lg border border-red-200 flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
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
                                   placeholder="nama@contoh.com" required autofocus>
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
                    
                    <!-- CAPTCHA Field -->
                    <div class="mb-6">
                        <label for="captcha" class="block text-sm font-medium text-gray-700 mb-2">Kode Keamanan</label>
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="flex-1 bg-gray-100 p-2 rounded-lg flex justify-center">
                                <img src="{{ captcha_src() }}" alt="CAPTCHA" id="captcha-img" class="h-10">
                            </div>
                            <button type="button" onclick="document.getElementById('captcha-img').src='{{ captcha_src() }}'+'?'+Math.random()" 
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 p-2 rounded-lg transition duration-150 ease-in-out">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </button>
                        </div>
                        <input type="text" name="captcha" id="captcha" 
                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus-primary focus:outline-none transition duration-150 ease-in-out" 
                               placeholder="Masukkan kode di atas" required>
                        @error('captcha')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full btn-primary py-3 px-4 rounded-lg font-medium text-white transition duration-150 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Masuk
                    </button>
                </form>
                
                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-primary font-medium hover:underline transition duration-150 ease-in-out">
                            Daftar di sini
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
        // Animasi sederhana untuk form
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.classList.add('opacity-0');
            
            setTimeout(() => {
                form.classList.remove('opacity-0');
                form.classList.add('opacity-100');
            }, 100);
        });
    </script>
</body>
</html>