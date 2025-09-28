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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
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
        
        /* Card enhancements */
        .stats-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #06b6d4, #10b981);
        }
        
        .riset-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .riset-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(16, 185, 129, 0.1));
            border-radius: 50%;
            transform: translate(30%, -30%);
        }
        
        /* Social pill styling */
        .social-pill {
            display: inline-flex;
            align-items: center;
            justify-center: center;
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
        
        /* Chart container */
        .chart-container {
            position: relative;
            height: 200px;
            background: #ffffff;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
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
        
        /* Count up pulse effect */
        .pulse-update {
            animation: pulseCount 0.8s ease-out;
        }
        
        @keyframes pulseCount {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); color: #3b82f6; }
            100% { transform: scale(1); }
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

        /* ===== RESPONSIVE MEDIA QUERIES FOR MOBILE ===== */
        
        /* Extra Small devices (phones, 320px and up) */
        @media (max-width: 480px) {
            body {
                font-size: 14px;
            }
            
            /* Hero section mobile adjustments */
            .hero-overlay {
                padding: 1rem;
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.363) 0%, rgba(3, 3, 3, 0.349) 100%);
            }
            
            /* Button adjustments for mobile */
            .btn-primary,
            .btn-secondary {
                padding: 0.5rem 1.5rem;
                font-size: 0.875rem;
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            /* Card adjustments */
            .stats-card,
            .riset-card {
                margin-bottom: 1rem;
                padding: 1rem;
                border-radius: 12px;
            }
            
            .riset-card {
                padding: 1rem;
            }
            
            /* Chart container mobile */
            .chart-container {
                height: 160px;
                padding: 0.75rem;
            }
            
            /* Service icon mobile */
            .service-icon {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 1.25rem;
            }
            
            /* Footer mobile adjustments */
            .footer-heading {
                font-size: 1rem;
                margin-bottom: 0.75rem;
            }
            
            /* Social pills mobile */
            .social-pill {
                width: 1.75rem;
                height: 1.75rem;
            }
            
            .social-pill svg {
                width: 0.875rem;
                height: 0.875rem;
            }
            
            /* Navigation mobile */
            .nav-link {
                display: block;
                padding: 0.75rem 0;
                border-bottom: 1px solid #e5e7eb;
            }
            
            .nav-link::after {
                display: none;
            }
            
            /* Mobile menu adjustments */
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
            
            /* Hover effects disabled on mobile */
            .soft-lift:hover {
                transform: none;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            
            .btn-primary:hover,
            .btn-secondary:hover {
                transform: none;
            }
        }
        
        /* Small devices (phones, 481px to 767px) */
        @media (min-width: 481px) and (max-width: 767px) {
            /* Button adjustments */
            .btn-primary,
            .btn-secondary {
                padding: 0.625rem 1.75rem;
                font-size: 0.9rem;
            }
            
            /* Card adjustments */
            .stats-card,
            .riset-card {
                padding: 1.25rem;
            }
            
            /* Chart container */
            .chart-container {
                height: 180px;
            }
            
            /* Service icon */
            .service-icon {
                width: 2.75rem;
                height: 2.75rem;
                font-size: 1.375rem;
            }
        }
        
        /* Medium devices (tablets, 768px to 1023px) */
        @media (min-width: 768px) and (max-width: 1023px) {
            /* Card grid adjustments */
            .stats-card,
            .riset-card {
                margin-bottom: 1.5rem;
            }
            
            /* Chart container */
            .chart-container {
                height: 190px;
            }
            
            /* Navigation tablet */
            .nav-link {
                padding: 0.5rem 1rem;
            }
        }
        
        /* Large devices (desktops, 1024px and up) - existing styles apply */
        @media (min-width: 1024px) {
            /* Enhanced hover effects for desktop */
            .soft-lift:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
        }
        
        /* Utility classes for responsive behavior */
        .mobile-only {
            display: none;
        }
        
        .desktop-only {
            display: block;
        }
        
        @media (max-width: 767px) {
            .mobile-only {
                display: block;
            }
            
            .desktop-only {
                display: none;
            }
            
            /* Text size adjustments */
            h1 { font-size: 1.75rem !important; }
            h2 { font-size: 1.5rem !important; }
            h3 { font-size: 1.25rem !important; }
            h4 { font-size: 1.125rem !important; }
            h5 { font-size: 1rem !important; }
            h6 { font-size: 0.875rem !important; }
            
            /* Padding and margin adjustments */
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            /* Spacing utilities for mobile */
            .mb-mobile { margin-bottom: 1rem; }
            .mt-mobile { margin-top: 1rem; }
            .px-mobile { padding-left: 1rem; padding-right: 1rem; }
            .py-mobile { padding-top: 1rem; padding-bottom: 1rem; }
        }
        
        /* Performance optimizations for mobile */
        @media (max-width: 767px) {
            /* Reduce animation complexity on mobile */
            .fade-in {
                animation-duration: 0.3s;
            }
            
            @keyframes fadeInUp {
                from { 
                    opacity: 0; 
                    transform: translateY(15px); 
                }
                to { 
                    opacity: 1; 
                    transform: translateY(0); 
                }
            }
            
            /* Simplified gradients for better performance */
            .gradient-bg {
                background: #667eea;
            }
            
            /* Remove complex box shadows on mobile */
            .stats-card,
            .riset-card {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 overflow-x-hidden">
    <!-- Enhanced Header with better visual hierarchy -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-800 text-white sticky top-0 z-40 shadow-xl">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex justify-between items-center h-16">
                <!-- Logo section with better spacing -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <img src="{{ asset('storage/images/logo3.png') }}" alt="Logo CSSR" class="w-8 h-8 object-contain" style="width: 45px; height: auto;">
                        <img src="{{ asset('storage/images/logo1.png') }}" alt="Logo CSSR" class="w-8 h-8 object-contain" style="width: 45px; height: auto;">
                    </div>
                    <div class="text-sm leading-tight">
                        <div class="font-bold text-lg  bg-gradient-to-r from-white to-blue-100 bg-clip-text">CEGAH STUNTING</div>
                        <div class="font-semibold text-blue-100">SEHAT RAGA</div>
                    </div>
                </div>
                
                <!-- Enhanced Navigation -->
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
                    <a href="#tentang" class="nav-link hover:text-blue-200">
                        <i class="fas fa-info-circle mr-1"></i>Tentang Kami
                    </a>
                    <a href="#services" class="nav-link hover:text-blue-200">
                        <i class="fas fa-hands-helping mr-1"></i>Layanan
                    </a>
                    <a href="#data-riset" class="nav-link hover:text-blue-200">
                        <i class="fas fa-chart-line mr-1"></i>Data Riset
                    </a>
                    <a href="#galeri" class="nav-link hover:text-blue-200">
                        <i class="fas fa-images mr-1"></i>Galeri
                    </a>
                    <a href="#edukasi" class="nav-link hover:text-blue-200">
                        <i class="fas fa-graduation-cap mr-1"></i>Edukasi
                    </a>
                    <a href="#contact" class="nav-link hover:text-blue-200">
                        <i class="fas fa-envelope mr-1"></i>Kontak
                    </a>
                </nav>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-toggle" class="md:hidden inline-flex items-center justify-center rounded-lg p-2 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors" aria-controls="mobile-menu" aria-expanded="false">
                    <i class="fas fa-bars text-xl"></i>
                    <span class="sr-only">Open menu</span>
                </button>
            </div>
        </div>
        
        <!-- Enhanced Mobile menu -->
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
                    <a href="#tentang" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-info-circle mr-3 w-4"></i>Tentang Kami
                    </a>
                    <a href="#services" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-hands-helping mr-3 w-4"></i>Layanan
                    </a>
                    <a href="#data-riset" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-chart-line mr-3 w-4"></i>Data Riset
                    </a>
                    <a href="#galeri" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-images mr-3 w-4"></i>Galeri
                    </a>
                    <a href="#edukasi" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-graduation-cap mr-3 w-4"></i>Edukasi
                    </a>
                    <a href="#contact" class="flex items-center px-3 py-2 text-white/90 hover:bg-white/10 hover:text-white rounded-lg transition-colors">
                        <i class="fas fa-envelope mr-3 w-4"></i>Kontak
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Enhanced Hero Section -->
        <section id="hero" class="relative h-[70vh] min-h-[500px] md:h-[80vh] md:min-h-[600px] overflow-hidden">
            <!-- Background slides -->
            <div id="hero-slides" class="absolute inset-0">
                <div id="hero-slide-a" class="absolute inset-0 bg-center bg-cover opacity-0 transition-opacity duration-700 ease-out"></div>
                <div id="hero-slide-b" class="absolute inset-0 bg-center bg-cover opacity-0 transition-opacity duration-700 ease-out"></div>
            </div>
            
            <!-- Enhanced overlay with gradient -->
            <div class="absolute inset-0 hero-overlay"></div>
            
            <!-- Animated background elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-20 -right-20 w-80 h-80 bg-white/5 rounded-full animate-pulse"></div>
                <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-blue-300/10 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
            </div>

            <div class="relative z-10 h-full">
                <div class="max-w-7xl w-full mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-center">
                    <div class="max-w-4xl w-full mx-auto text-center">
                        <!-- Hero badge -->
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 fade-up">
                            <i class="fas fa-star text-yellow-300"></i>
                            <span id="hero-subheading" class="text-blue-100 font-semibold text-sm">Program Prioritas Nasional</span>
                        </div>
                        
                        <!-- Main heading with enhanced typography -->
                        <h1 id="hero-heading" class="text-white text-4xl sm:text-5xl md:text-7xl font-extrabold leading-tight mb-6 fade-up">
                            Cegah Stunting, Investasi Masa Depan Bangsa
                        </h1>
                        
                        <!-- Description with better readability -->
                        <p id="hero-description" class="text-white/90 mt-6 text-lg sm:text-xl leading-relaxed max-w-3xl mx-auto mb-8 fade-up">
                            Kami hadir untuk memberikan informasi, edukasi, dan data penting dalam upaya pencegahan stunting demi generasi yang lebih sehat dan cerdas.
                        </p>
                        
                        <!-- Enhanced CTA buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center fade-up">
                            <a id="hero-btn-1" href="#data-riset" class="btn-primary inline-flex items-center gap-3">
                                <i class="fas fa-chart-line"></i>
                                Pelajari Lebih Lanjut
                            </a>
                            <a id="hero-btn-2" href="#contact" class="btn-secondary inline-flex items-center gap-3">
                                <i class="fas fa-phone"></i>
                                Hubungi Kami
                            </a>
                        </div>
                        
                        <!-- Hero stats preview -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-12 max-w-2xl mx-auto fade-up" style="animation-delay: 0.8s;">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-white" data-count-target="150">0</div>
                                <div class="text-white/80 text-sm">Program Aktif</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-white" data-count-target="50">0</div>
                                <div class="text-white/80 text-sm">Kelurahan</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-white" data-count-target="5000">0</div>
                                <div class="text-white/80 text-sm">Keluarga Terlayani</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced carousel controls -->
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

        <!-- Enhanced Data Riset Section -->
        <section id="data-riset" class="max-w-7xl mx-auto px-5 py-20 scroll-mt-16">
            <div class="flex flex-col lg:flex-row lg:items-start gap-12">
                <div class="flex-1 w-full">
                    <!-- Section header with icon -->
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-bar text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800">Data Riset Realtime</h2>
                            <p class="text-gray-600">Visualisasi indikator utama untuk mendukung pengambilan keputusan</p>
                        </div>
                    </div>
                    
                    <!-- Enhanced grid with loading state -->
                    <div id="riset-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <!-- Loading placeholder -->
                        <div class="loading-shimmer h-32 rounded-xl"></div>
                        <div class="loading-shimmer h-32 rounded-xl"></div>
                        <div class="loading-shimmer h-32 rounded-xl"></div>
                        <div class="loading-shimmer h-32 rounded-xl"></div>
                    </div>
                </div>
                
                <!-- Enhanced sidebar chart -->
                <aside class="w-full max-w-md">
                    <div id="riset-chart-card" class="reveal-on-scroll bg-gradient-to-br from-white to-blue-50 border border-blue-100 rounded-3xl shadow-xl p-6 soft-lift" data-reveal-delay="120" data-reveal-distance="24">
                        <div class="flex items-center justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-pie-chart text-blue-600"></i>
                                    Distribusi Data
                                </h3>
                                <p class="text-sm text-gray-600">Persentase kontribusi setiap indikator</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-center mb-6">
                            <div class="relative w-48 h-48">
                                <div id="riset-chart-visual" class="w-full h-full rounded-full bg-slate-200 transition-all duration-500 ease-out shadow-inner"></div>
                                <div class="absolute inset-8 rounded-full bg-white flex flex-col items-center justify-center text-center shadow-lg">
                                    <span id="riset-chart-total" class="text-3xl font-bold text-blue-600">0</span>
                                    <span class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Total Data</span>
                                </div>
                            </div>
                        </div>
                        
                        <ul id="riset-chart-legend" class="space-y-3 text-sm"></ul>
                        <p id="riset-chart-empty" class="mt-4 text-sm text-gray-500 text-center hidden flex items-center justify-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Data riset belum tersedia
                        </p>
                        
                        <!-- Last updated info -->
                        <div class="mt-6 pt-4 border-t border-blue-100 flex items-center justify-between text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-sync-alt"></i>
                                Update realtime
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-clock"></i>
                                {{ date('H:i') }} WITA
                            </span>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <!-- Enhanced Tentang Kami Section -->
        <section id="tentang" class="bg-gradient-to-br from-blue-50 to-white py-20 scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5">
                <div class="grid gap-16 lg:grid-cols-2 items-center">
                    <!-- Content side -->
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 bg-blue-100 rounded-full px-4 py-2">
                            <i class="fas fa-info-circle text-blue-600"></i>
                            <span class="text-blue-800 font-semibold text-sm uppercase tracking-wide">Tentang Kami</span>
                        </div>
                        
                        <h2 id="about-title" class="text-4xl md:text-5xl font-bold leading-tight text-gray-900">BKKBN Tomohon</h2>
                        
                        <div class="space-y-6 text-gray-700 text-lg leading-relaxed">
                            <p id="about-p1" class="text-gray-600 leading-relaxed">Dinas Pengendalian Penduduk dan Keluarga Berencana Daerah (DPPKBD) Kota Tomohon berkomitmen dalam upaya pencegahan stunting dan pemberdayaan keluarga berkualitas di Sulawesi Utara.</p>
                            <p id="about-p2" class="text-gray-600 leading-relaxed hidden">Melalui berbagai program inovatif dan pendekatan terpadu, kami bekerja sama dengan berbagai stakeholder untuk menciptakan generasi masa depan yang sehat, cerdas, dan berkualitas.</p>
                        </div>
                        
                        <!-- Key features -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Program Terintegrasi</div>
                                    <div class="text-sm text-gray-600">Layanan terpadu & berkelanjutan</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-4 bg-white rounded-xl shadow-sm">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Pemberdayaan Masyarakat</div>
                                    <div class="text-sm text-gray-600">Edukasi & konseling keluarga</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hidden">
                            <a id="about-cta" href="#" class="btn-primary inline-flex items-center gap-2">
                                <i class="fas fa-arrow-right"></i>
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    
                    <!-- Image side with enhanced layout -->
                    <div class="flex justify-center lg:justify-end">
                        <div class="relative w-full max-w-xl pb-16 lg:pb-20">
                            <div class="relative aspect-[4/3] w-full rounded-3xl bg-gradient-to-br from-blue-100 via-white to-blue-50 shadow-2xl overflow-hidden">
                                <img id="about-main" data-src="" alt="Tentang BKKBN Tomohon" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover" hidden>
                                <!-- Placeholder when no image -->
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
                                    <div class="text-center text-blue-700">
                                        <i class="fas fa-building text-6xl mb-4 opacity-50"></i>
                                        <div class="text-2xl font-bold">DPPKBD</div>
                                        <div class="text-lg">Kota Tomohon</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Floating card -->
                            <div id="about-overlay-frame" class="absolute left-1/2 bottom-0 w-[80%] max-w-sm -translate-x-1/2 rounded-2xl shadow-2xl overflow-hidden border-4 border-white bg-white hidden md:block">
                                <img id="about-overlay" data-src="" alt="Overlay" loading="lazy" decoding="async" class="h-full w-full object-cover aspect-[3/2]" hidden>
                                <!-- Overlay placeholder -->
                                <div class="aspect-[3/2] bg-gradient-to-r from-green-100 to-blue-100 flex items-center justify-center">
                                    <div class="text-center text-blue-700">
                                        <i class="fas fa-heart text-3xl mb-2"></i>
                                        <div class="font-bold">Keluarga Sehat</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Layanan Kami Section -->
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

        <!-- Enhanced Galeri Program Section -->
        <section id="galeri" class="bg-gradient-to-br from-gray-50 to-white py-20 scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5">
                <div class="text-center mb-12">
                    <div class="inline-flex items-center gap-2 bg-purple-100 rounded-full px-4 py-2 mb-4">
                        <i class="fas fa-images text-purple-600"></i>
                        <span class="text-purple-800 font-semibold text-sm uppercase tracking-wide">Galeri Program</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Dokumentasi Kegiatan</h2>
                    <p class="text-gray-600 text-lg max-w-2xl mx-auto">Momen-momen penting dari berbagai program pencegahan stunting dan pemberdayaan keluarga</p>
                </div>
                
                <div id="galeri-grid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Loading placeholders -->
                    <div class="loading-shimmer h-64 rounded-2xl"></div>
                    <div class="loading-shimmer h-64 rounded-2xl"></div>
                    <div class="loading-shimmer h-64 rounded-2xl"></div>
                    <div class="loading-shimmer h-64 rounded-2xl"></div>
                </div>
            </div>
        </section>

        <!-- Enhanced Edukasi Section -->
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

        <!-- Enhanced Kontak Section -->
        <section id="contact" class="bg-gradient-to-br from-blue-50 via-white to-blue-50 py-20 scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5">
                <!-- Header -->
                <div class="max-w-3xl w-full mx-auto text-center mb-16 reveal-on-scroll" data-reveal-delay="0" data-reveal-distance="28" data-reveal-duration="450">
                    <div class="inline-flex items-center gap-2 bg-blue-100 rounded-full px-4 py-2 mb-4">
                        <i class="fas fa-envelope text-blue-600"></i>
                        <span class="text-blue-800 font-semibold text-sm uppercase tracking-wide">Hubungi Kami</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Layanan Informasi & Konsultasi</h2>
                    <p class="text-gray-600 text-lg">Tim DPPKBD Kota Tomohon siap membantu Anda mendapatkan informasi dan dukungan terkait pencegahan stunting serta pelayanan keluarga berkualitas</p>
                </div>

                <!-- Contact Cards -->
                <div class="grid gap-6 md:grid-cols-3 items-start mb-12">
                    <div class="reveal-on-scroll bg-white border border-blue-100 rounded-2xl shadow-lg p-6 soft-lift" data-reveal-delay="0" data-reveal-distance="24">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-blue-600 text-xl"></i>
                            </div>
                            <div class="space-y-2">
                                <div class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Telepon</div>
                                <p class="text-xl font-bold text-gray-900">+62 812 3456 7890</p>
                                <a href="tel:+6281234567890" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    <i class="fas fa-phone"></i>
                                    Hubungi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="reveal-on-scroll bg-white border border-blue-100 rounded-2xl shadow-lg p-6 soft-lift" data-reveal-delay="100" data-reveal-distance="24">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-green-600 uppercase tracking-wide mb-2">Alamat Kantor</div>
                                <p class="text-lg font-bold text-gray-900 mb-1">DPPKBD Kota Tomohon</p>
                                <p class="text-gray-600 leading-relaxed mb-3">Jl. Terminal Beriman, Tomohon Timur, Kota Tomohon, Sulawesi Utara</p>
                                <a href="https://maps.app.goo.gl/fgaeUK9bJzSJEVeX8" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium text-sm">
                                    <i class="fas fa-external-link-alt"></i>
                                    Lihat di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="reveal-on-scroll bg-white border border-blue-100 rounded-2xl shadow-lg p-6 soft-lift" data-reveal-delay="200" data-reveal-distance="24">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-purple-600 text-xl"></i>
                            </div>
                            <div class="space-y-2">
                                <div class="text-sm font-semibold text-purple-600 uppercase tracking-wide">Email</div>
                                <p class="text-lg font-bold text-gray-900 break-all">info@bkkbntomohon.go.id</p>
                                <a href="mailto:info@bkkbntomohon.go.id" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-medium text-sm">
                                    <i class="fas fa-paper-plane"></i>
                                    Kirim Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Map Section -->
                <div class="grid gap-8 justify-items-center">
                    <div class="reveal-on-scroll bg-white border border-blue-100 rounded-3xl shadow-xl p-6 soft-lift max-w-4xl w-full mx-auto" data-reveal-direction="up" data-reveal-distance="32" data-reveal-delay="0" data-reveal-duration="500">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-map-marked-alt text-blue-600"></i>
                                Lokasi Kantor Kami
                            </h3>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-clock"></i>
                                <span>Buka: Senin - Jumat, 08:00 - 16:00 WITA</span>
                            </div>
                        </div>
                        
                        <div id="contact-map" class="relative overflow-hidden rounded-2xl bg-blue-100 aspect-[16/9] max-h-[400px]" data-map-src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d400.7362813471956!2d124.84545321272765!3d1.3278442313099665!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32876cbf563f23cd%3A0xb6bed2f0f750445!2sDinas%20Pengendalian%20Penduduk%20%26%20KB%20Daerah%20Kota%20Tomohon!5e0!3m2!1sen!2sid!4v1758160730812!5m2!1sen!2sid" data-map-title="Lokasi DPPKBD Tomohon" data-map-referrerpolicy="no-referrer-when-downgrade">
                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 px-6 text-center text-blue-900/80" data-map-placeholder>
                                <div class="w-16 h-16 bg-blue-200 rounded-full flex items-center justify-center">
                                    <i class="fas fa-map text-2xl text-blue-700"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-gray-800 mb-2" data-map-message>Peta Interaktif Lokasi Kantor</p>
                                    <p class="text-sm text-gray-600 mb-4">Klik tombol untuk memuat peta dan mendapatkan petunjuk arah</p>
                                </div>
                                <button type="button" class="btn-primary inline-flex items-center gap-2" data-map-trigger>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Muat Peta Interaktif</span>
                                </button>
                            </div>
                        </div>
                        
                        <noscript>
                            <div class="overflow-hidden rounded-2xl bg-blue-100 aspect-[16/9] max-h-[400px]">
                                <iframe title="Lokasi DPPKBD Tomohon" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d400.7362813471956!2d124.84545321272765!3d1.3278442313099665!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32876cbf563f23cd%3A0xb6bed2f0f750445!2sDinas%20Pengendalian%20Penduduk%20%26%20KB%20Daerah%20Kota%20Tomohon!5e0!3m2!1sen!2sid!4v1758160730812!5m2!1sen!2sid" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full h-full border-0"></iframe>
                            </div>
                        </noscript>
                        
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
                            <p class="flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-600"></i>
                                Gunakan peta untuk mendapatkan petunjuk arah yang akurat
                            </p>
                            <div class="flex items-center gap-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-car text-gray-400"></i>
                                    Parking available
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-wheelchair text-gray-400"></i>
                                    Accessible
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Enhanced Footer -->
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
                        <li><a href="#tentang" class="footer-link flex items-center gap-2"><i class="fas fa-info-circle text-xs"></i>Tentang Kami</a></li>
                        <li><a href="#services" class="footer-link flex items-center gap-2"><i class="fas fa-hands-helping text-xs"></i>Layanan Kami</a></li>
                        <li><a href="#data-riset" class="footer-link flex items-center gap-2"><i class="fas fa-chart-line text-xs"></i>Data Riset</a></li>
                        <li><a href="#galeri" class="footer-link flex items-center gap-2"><i class="fas fa-images text-xs"></i>Galeri Program</a></li>
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

    <!-- Enhanced JavaScript Integration -->
    
    </script>
</body>
</html>