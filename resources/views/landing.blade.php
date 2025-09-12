<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BKKBN') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/css/figma.css','resources/js/landing.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">
    <header class="bg-blue-700 text-white sticky top-0 z-40 shadow">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <img src="/logo.svg" alt="Logo" class="h-8 w-8 hidden sm:block" onerror="this.style.display='none'" />
                    <div class="text-sm leading-4">
                        <div class="font-semibold">CEGAH STUNTING</div>
                        <div class="font-semibold">SEHAT RAGA</div>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="#" class="hover:text-blue-300">Beranda</a>
                    <a href="#" class="hover:text-blue-300">Informasi</a>
                    <a href="#" class="hover:text-blue-300">Program</a>
                    <a href="#publications" class="hover:text-blue-300">Publikasi</a>
                    <a href="#" class="hover:text-blue-300">Referensi</a>
                    <a href="#stats" class="hover:text-blue-300">Monitoring</a>
                    <a href="#" class="hover:text-blue-300">Kontak</a>
                </nav>
                <div class="hidden lg:flex items-center gap-2 text-xs text-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79a15.07 15.07 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24 11.36 11.36 0 0 0 3.56.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 7a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.43.57 3.56a1 1 0 0 1-.24 1.01l-2.2 2.21z"/></svg>
                    <span class="leading-3">Have any questions? Call: + 0123 456 7890</span>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Carousel with Overlay -->
        <section id="hero" class="relative h-[70vh] min-h-[520px]">
            <div id="hero-slide" class="absolute inset-0 bg-center bg-cover" style="background-image: url('');"></div>
            <div class="absolute inset-0 bg-black/55"></div>

            <div class="relative z-10 h-full">
                <div class="max-w-7xl mx-auto h-full px-5 flex items-center">
                    <div class="max-w-3xl">
                        <div class="text-blue-400 font-semibold mb-2" id="hero-subheading">Program Prioritas Nasional</div>
                        <h1 id="hero-heading" class="text-white text-4xl md:text-6xl font-extrabold leading-tight drop-shadow">Cegah Stunting, Investasi Masa Depan Bangsa</h1>
                        <p id="hero-description" class="text-white/90 mt-5 text-lg leading-relaxed max-w-2xl">Kami hadir untuk memberikan informasi, edukasi, dan data penting dalam upaya pencegahan stunting demi generasi yang lebih sehat dan cerdas.</p>
                        <div class="mt-8 flex flex-col sm:flex-row gap-4">
                            <a id="hero-btn-1" href="#" class="inline-flex items-center justify-center rounded-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium">Pelajari Lebih Lanjut</a>
                            <a id="hero-btn-2" href="#" class="inline-flex items-center justify-center rounded-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium">Hubungi Kami</a>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button id="hero-prev" aria-label="Previous" class="absolute left-3 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white size-10 rounded-full grid place-items-center">&#x276E;</button>
                <button id="hero-next" aria-label="Next" class="absolute right-3 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white size-10 rounded-full grid place-items-center">&#x276F;</button>
            </div>
        </section>

        <!-- Layanan Kami -->
        <section id="services" class="max-w-7xl mx-auto px-5 py-16">
            <h2 class="text-2xl font-semibold mb-6">Layanan Kami</h2>
            <div id="services-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        </section>

        <!-- Publikasi -->
        <section id="publications" class="bg-white">
            <div class="max-w-7xl mx-auto px-5 py-16">
                <h2 class="text-2xl font-semibold mb-6">Publikasi Terbaru</h2>
                <div id="pub-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
            </div>
        </section>

        <!-- Realtime Stats -->
        <section id="stats" class="max-w-7xl mx-auto px-5 py-16">
            <h2 class="text-2xl font-semibold mb-6">Statistik Realtime</h2>
            <div id="stats-grid" class="grid md:grid-cols-4 gap-6"></div>
        </section>
    </main>

    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 py-6 text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('app.name', 'BKKBN') }}</div>
    </footer>
</body>
</html>

