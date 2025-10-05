<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BKKBN') }} - Cegah Stunting Sehat Raga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/landing.js'])
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Enhanced animations and effects */
        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .soft-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .soft-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Enhanced hero section */
        .hero-overlay {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.555) 0%, rgba(0, 0, 0, 0.596) 100%);
        }
        
        /* Social pill styling */
        .social-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        
        .social-pill svg {
            width: 1rem;
            height: 1rem;
        }
        
        /* Navigation enhancements */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 50%;
            background: #26d48c;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Button enhancements */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #26d48c 0%, #16a34a 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(38, 212, 140, 0.4);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid #3b82f6;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            color: #3b82f6;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        /* Footer enhancements */
        .footer-heading {
            color: #f1f5f9;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer-list {
            space-y: 0.5rem;
        }
        
        .footer-link {
            color: #cbd5e1;
            transition: color 0.2s ease;
            text-decoration: none;
        }
        
        .footer-link:hover {
            color: #26d48c;
        }
        
        .footer-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.5rem;
            height: 1.5rem;
            color: #3b82f6;
        }
        
        .footer-icon svg {
            width: 1rem;
            height: 1rem;
        }
        
        .footer-contact-meta {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }
        
        .footer-contact-title {
            font-weight: 600;
            color: #e2e8f0;
        }
        
        .footer-contact-link {
            color: #3b82f6;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .footer-contact-link:hover {
            color: #26d48c;
        }
        
        /* Reveal animations */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(var(--reveal-transform, 20px));
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .reveal-on-scroll.in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }
        
        .fade-up.in {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Mobile menu animation */
        #mobile-menu[data-open="true"] {
            max-height: 400px;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        /* Service card icons */
        .service-icon {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1d4ed8;
            border-radius: 50%;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        /* Responsive utilities */
        @media (max-width: 768px) {
            .hero-overlay {
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.85) 0%, rgba(37, 99, 235, 0.95) 100%);
            }
        }
        
        /* Loading states */
        .loading-shimmer {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive media queries for mobile */
        @media (max-width: 480px) {
            body {
                font-size: 14px;
            }
            
            .hero-overlay {
                padding: 1rem;
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.363) 0%, rgba(3, 3, 3, 0.349) 100%);
            }
            
            .btn-primary,
            .btn-secondary {
                padding: 0.5rem 1.5rem;
                font-size: 0.875rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .service-icon {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 1.25rem;
            }
            
            .footer-heading {
                font-size: 1rem;
                margin-bottom: 0.75rem;
            }
            
            .social-pill {
                width: 1.75rem;
                height: 1.75rem;
            }
            
            .social-pill svg {
                width: 0.875rem;
                height: 0.875rem;
            }
            
            .nav-link {
                display: block;
                padding: 0.75rem 0;
                border-bottom: 1px solid #e5e7eb;
            }
            
            .nav-link::after {
                display: none;
            }
            
            #mobile-menu {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border-radius: 0 0 12px 12px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                max-height: 0;
                opacity: 0;
                overflow: hidden;
                transform: translateY(-10px);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                pointer-events: none;
            }
            
            .soft-lift:hover {
                transform: none;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            
            .btn-primary:hover,
            .btn-secondary:hover {
                transform: none;
            }
        }
        
        @media (min-width: 481px) and (max-width: 767px) {
            .btn-primary,
            .btn-secondary {
                padding: 0.625rem 1.75rem;
                font-size: 0.9rem;
            }
            
            .service-icon {
                width: 2.75rem;
                height: 2.75rem;
                font-size: 1.375rem;
            }
        }
        
        @media (min-width: 768px) and (max-width: 1023px) {
            .nav-link {
                padding: 0.5rem 1rem;
            }
        }
        
        @media (min-width: 1024px) {
            .soft-lift:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
        }
        
        .mobile-only { display: none; }
        .desktop-only { display: block; }
        
        @media (max-width: 767px) {
            .mobile-only { display: block; }
            .desktop-only { display: none; }
            
            h1 { font-size: 1.75rem !important; }
            h2 { font-size: 1.5rem !important; }
            h3 { font-size: 1.25rem !important; }
            h4 { font-size: 1.125rem !important; }
            h5 { font-size: 1rem !important; }
            h6 { font-size: 0.875rem !important; }
            
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .mb-mobile { margin-bottom: 1rem; }
            .mt-mobile { margin-top: 1rem; }
            .px-mobile { padding-left: 1rem; padding-right: 1rem; }
            .py-mobile { padding-top: 1rem; padding-bottom: 1rem; }
        }
        
        @media (max-width: 767px) {
            .fade-in { animation-duration: 0.3s; }
            
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(15px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .gradient-bg { background: #667eea; }
            
            .stats-card,
            .riset-card {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 overflow-x-hidden">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-800 text-white sticky top-0 z-40 shadow-xl">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex justify-between items-center h-16">
                <!-- Logo section -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <img src="{{ asset('storage/images/logo3.png') }}" alt="Logo CSSR" class="w-8 h-8 object-contain" style="width: 45px; height: auto;">
                        <img src="{{ asset('storage/images/logo1.png') }}" alt="Logo CSSR" class="w-8 h-8 object-contain" style="width: 45px; height: auto;">
                    </div>
                    <div class="text-sm leading-tight">
                        <div class="font-bold text-lg bg-gradient-to-r from-white to-blue-100 bg-clip-text">CEGAH STUNTING</div>
                        <div class="font-semibold text-blue-100">SEHAT RAGA</div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex items-center gap-8 text-sm">
                    <div class="flex items-center gap-4 pr-6 border-r border-white/20">
                        <a href="https://facebook.com" class="social-pill text-white/80 hover:bg-white/20 hover:text-white hover:scale-110 focus-visible:ring-offset-blue-700" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://instagram.com" class="social-pill text-white/80 hover:bg-white/20 hover:text-white hover:scale-110 focus-visible:ring-offset-blue-700" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://bkkbn.go.id" class="social-pill text-white/80 hover:bg-white/20 hover:text-white hover:scale-110 focus-visible:ring-offset-blue-700" aria-label="Portal BKKBN">
                            <i class="fas fa-globe"></i>
                        </a>
                    </div>
                    <a href="#hero" class="nav-link hover:text-blue-200">
                        <i class="fas fa-home mr-1"></i>Beranda
                    </a>
                    <a href="#services" class="nav-link hover:text-blue-200">
                        <i class="fas fa-hands-helping mr-1"></i>Layanan
                    </a>
                    <a href="#edukasi" class="nav-link hover:text-blue-200">
                        <i class="fas fa-graduation-cap mr-1"></i>Edukasi
                    </a>
                </nav>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-toggle" class="md:hidden inline-flex items-center justify-center rounded-lg p-2 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors" aria-controls="mobile-menu" aria-expanded="false">
                    <i class="fas fa-bars text-xl"></i>
                    <span class="sr-only">Open menu</span>
                </button>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden bg-blue-800/95 backdrop-blur-sm border-t border-blue-600/40 overflow-hidden max-h-0 opacity-0 -translate-y-1 pointer-events-none transition-all duration-300 ease-out" data-open="false">
            <div class="px-5 py-4 space-y-1">
                <div class="flex items-center gap-4 pb-4 border-b border-blue-600/40">
                    <a href="https://facebook.com" class="social-pill text-white/80 hover:bg-white/20 hover:text-white" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://instagram.com" class="social-pill text-white/80 hover:bg-white/20 hover:text-white" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://bkkbn.go.id" class="social-pill text-white/80 hover:bg-white/20 hover:text-white" aria-label="Portal BKKBN">
                        <i class="fas fa-globe"></i>
                    </a>
                </div>
                <div class="space-y-1 pt-2">
                    <a href="#hero" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-home mr-3 w-4"></i>Beranda
                    </a>
                    <a href="#services" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-hands-helping mr-3 w-4"></i>Layanan
                    </a>
                    <a href="#edukasi" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-graduation-cap mr-3 w-4"></i>Edukasi
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="hero" class="relative h-[70vh] min-h-[500px] md:h-[80vh] md:min-h-[600px] overflow-hidden">
            <!-- Background slides -->
            <div id="hero-slides" class="absolute inset-0">
                <div id="hero-slide-a" class="absolute inset-0 bg-center bg-cover opacity-0 transition-opacity duration-700 ease-out"></div>
                <div id="hero-slide-b" class="absolute inset-0 bg-center bg-cover opacity-0 transition-opacity duration-700 ease-out"></div>
            </div>
            
            <!-- Overlay -->
            <div class="absolute inset-0 hero-overlay"></div>

            <div class="relative z-10 h-full">
                <div class="max-w-7xl w-full mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-center">
                    <div class="max-w-4xl w-full mx-auto text-center">
                        <!-- Hero badge -->
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 fade-up">
                            <i class="fas fa-star text-yellow-300"></i>
                            <span id="hero-subheading" class="text-blue-100 font-semibold text-sm">Program Prioritas Nasional</span>
                        </div>
                        
                        <!-- Main heading -->
                        <h1 id="hero-heading" class="text-white text-4xl sm:text-5xl md:text-7xl font-extrabold leading-tight mb-6 fade-up"></h1>
                        
                        <!-- Description -->
                        <p id="hero-description" class="text-white/90 mt-6 text-lg sm:text-xl leading-relaxed max-w-3xl mx-auto mb-8 fade-up"></p>
                        
                        <!-- CTA buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center fade-up">
                            <a id="hero-btn-1" href="#" class="btn-primary inline-flex items-center gap-3 hidden">
                                <i class="fas fa-chart-line"></i>
                                <span></span>
                            </a>
                            <a id="hero-btn-2" href="#" class="btn-secondary inline-flex items-center gap-3 hidden">
                                <i class="fas fa-phone"></i>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carousel controls -->
                <button id="hero-prev" aria-label="Previous" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all hover:scale-110">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="hero-next" aria-label="Next" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white w-12 h-12 rounded-full flex items-center justify-center transition-all hover:scale-110">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <!-- Scroll indicator -->
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
                    <i class="fas fa-chevron-down text-white/60 text-xl"></i>
                </div>
            </div>
        </section>

        <!-- Layanan Kami Section -->
        <section id="services" class="max-w-7xl mx-auto px-5 py-20 scroll-mt-16">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 bg-green-100 rounded-full px-4 py-2 mb-4">
                    <i class="fas fa-hands-helping text-green-600"></i>
                    <span class="text-green-800 font-semibold text-sm uppercase tracking-wide">Layanan Kami</span>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Program & Layanan Unggulan</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Berbagai layanan terintegrasi untuk mendukung keluarga berkualitas dan pencegahan stunting</p>
            </div>
            
            <div id="services-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Loading placeholders -->
                <div class="loading-shimmer h-48 rounded-2xl"></div>
                <div class="loading-shimmer h-48 rounded-2xl"></div>
                <div class="loading-shimmer h-48 rounded-2xl"></div>
            </div>
        </section>

        <!-- Edukasi Section -->
        <section id="edukasi" class="py-20 scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-12">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 bg-orange-100 rounded-full px-4 py-2">
                            <i class="fas fa-graduation-cap text-orange-600"></i>
                            <span class="text-orange-800 font-semibold text-sm uppercase tracking-wide">Edukasi</span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Materi Edukasi Pilihan</h2>
                        <p class="text-gray-600 text-lg max-w-2xl">Kumpulan materi konseling, modul, dan sumber belajar untuk mendukung pencegahan stunting di Kota Tomohon</p>
                    </div>
                    <p id="edukasi-empty" class="text-sm text-gray-500 md:text-right flex items-center gap-2" hidden>
                        <i class="fas fa-info-circle"></i>
                        Materi edukasi sedang disiapkan
                    </p>
                </div>
                
                <div id="edukasi-grid" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Loading placeholders -->
                    <div class="loading-shimmer h-80 rounded-2xl"></div>
                    <div class="loading-shimmer h-80 rounded-2xl"></div>
                    <div class="loading-shimmer h-80 rounded-2xl"></div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-slate-900 to-slate-800 text-slate-100">
        <div class="max-w-7xl mx-auto px-5 py-16">
            <div class="grid gap-12 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">
                <!-- Brand section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center">
                            <img src="{{ asset('storage/images/logo1.png') }}" alt="Logo CSSR" class="w-10 h-10 object-contain">
                        </div>
                        <div>
                            <p class="text-xl font-bold text-white">Cegah Stunting Tomohon</p>
                            <p class="text-sm text-blue-400 font-semibold uppercase tracking-wider">Bergerak Bersama Keluarga</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-300">Portal edukasi dan layanan terpadu DPPKBD Tomohon untuk memutus rantai stunting, menguatkan keluarga, dan memastikan tumbuh kembang balita yang optimal di Kota Tomohon, Sulawesi Utara.</p>
                    
                    <!-- Social media -->
                    <div class="flex items-center gap-4">
                        <a href="https://facebook.com" class="w-10 h-10 bg-blue-600/20 hover:bg-blue-600 rounded-full flex items-center justify-center transition-colors group" aria-label="Facebook">
                            <i class="fab fa-facebook-f text-blue-400 group-hover:text-white"></i>
                        </a>
                        <a href="https://instagram.com" class="w-10 h-10 bg-pink-600/20 hover:bg-pink-600 rounded-full flex items-center justify-center transition-colors group" aria-label="Instagram">
                            <i class="fab fa-instagram text-pink-400 group-hover:text-white"></i>
                        </a>
                        <a href="https://bkkbn.go.id" class="w-10 h-10 bg-green-600/20 hover:bg-green-600 rounded-full flex items-center justify-center transition-colors group" aria-label="Portal BKKBN">
                            <i class="fas fa-globe text-green-400 group-hover:text-white"></i>
                        </a>
                        <a href="https://youtube.com" class="w-10 h-10 bg-red-600/20 hover:bg-red-600 rounded-full flex items-center justify-center transition-colors group" aria-label="YouTube">
                            <i class="fab fa-youtube text-red-400 group-hover:text-white"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="footer-links">
                    <h3 class="footer-heading">Navigasi</h3>
                    <ul class="footer-list space-y-3">
                        <li><a href="#hero" class="footer-link flex items-center gap-2"><i class="fas fa-home text-xs"></i>Beranda</a></li>
                        <li><a href="#services" class="footer-link flex items-center gap-2"><i class="fas fa-hands-helping text-xs"></i>Layanan Kami</a></li>
                        <li><a href="#edukasi" class="footer-link flex items-center gap-2"><i class="fas fa-graduation-cap text-xs"></i>Edukasi</a></li>
                    </ul>
                </div>

                <!-- Programs -->
                <div class="footer-links">
                    <h3 class="footer-heading">Program Utama</h3>
                    <ul class="footer-list space-y-3">
                        <li><span class="text-slate-300 text-sm flex items-center gap-2"><i class="fas fa-baby text-xs text-blue-400"></i>Pencegahan Stunting</span></li>
                        <li><span class="text-slate-300 text-sm flex items-center gap-2"><i class="fas fa-heart text-xs text-red-400"></i>Keluarga Berencana</span></li>
                        <li><span class="text-slate-300 text-sm flex items-center gap-2"><i class="fas fa-users text-xs text-green-400"></i>Pemberdayaan Keluarga</span></li>
                        <li><span class="text-slate-300 text-sm flex items-center gap-2"><i class="fas fa-user-md text-xs text-purple-400"></i>Konseling Kesehatan</span></li>
                        <li><span class="text-slate-300 text-sm flex items-center gap-2"><i class="fas fa-chart-bar text-xs text-yellow-400"></i>Monitoring & Evaluasi</span></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-6">
                    <h3 class="footer-heading">Kontak Kami</h3>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex gap-3">
                            <span class="footer-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>
                            <div class="space-y-1">
                                <div class="footer-contact-meta">Alamat Kantor</div>
                                <p class="footer-contact-title">DPPKBD Kota Tomohon</p>
                                <p class="leading-relaxed">Jl. Terminal Beriman, Tomohon Timur, Kota Tomohon, Sulawesi Utara</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="footer-icon">
                                <i class="fas fa-phone"></i>
                            </span>
                            <div class="space-y-1">
                                <div class="footer-contact-meta">Telepon</div>
                                <p class="footer-contact-title">+62 812 3456 7890</p>
                                <a href="tel:+6281234567890" class="footer-contact-link">Hubungi langsung</a>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="footer-icon">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <div class="space-y-1">
                                <div class="footer-contact-meta">Email</div>
                                <p class="footer-contact-title break-all">info@bkkbntomohon.go.id</p>
                                <a href="mailto:info@bkkbntomohon.go.id" class="footer-contact-link">Kirim email</a>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-700">
                            <div class="flex items-center gap-2 text-xs text-slate-400">
                                <i class="fas fa-clock"></i>
                                <span>Jam Kerja: Senin - Jumat, 08:00 - 16:00 WITA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer bottom -->
            <div class="mt-12 pt-8 border-t border-slate-700 flex flex-col gap-4 text-xs text-slate-400 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'BKKBN') }} - DPPKBD Kota Tomohon. Seluruh hak cipta dilindungi.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <a href="https://tomohon.go.id" class="hover:text-blue-400 transition-colors flex items-center gap-1">
                        <i class="fas fa-external-link-alt"></i>
                        Pemkot Tomohon
                    </a>
                    <a href="https://bkkbn.go.id" class="hover:text-blue-400 transition-colors flex items-center gap-1">
                        <i class="fas fa-external-link-alt"></i>
                        BKKBN Pusat
                    </a>
                </div>
                
                <!-- Back to top button -->
                <a href="#hero" class="inline-flex items-center justify-center gap-2 self-start rounded-full bg-blue-600 px-6 py-3 font-semibold text-white shadow-lg shadow-blue-600/30 transition-all hover:bg-blue-500 hover:shadow-xl hover:-translate-y-1 md:self-auto">
                    <i class="fas fa-arrow-up"></i>
                    Kembali ke atas
                </a>
            </div>
        </div>
    </footer>
</body>
</html>