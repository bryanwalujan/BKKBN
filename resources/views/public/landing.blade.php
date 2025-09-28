<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BKKBN') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/landing.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 overflow-x-hidden">
    <header class="bg-blue-700 text-white sticky top-0 z-40 shadow">
        <div class="max-w-7xl mx-auto px-5">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <img src="{{ Vite::asset('resources/views/logo-bkkbn.png') }}" alt="BKKBN" decoding="async" class="h-8 w-auto hidden sm:block" onerror="this.style.display='none'" />
                    <div class="text-sm leading-4">
                        <div class="font-semibold">CEGAH STUNTING</div>
                        <div class="font-semibold">SEHAT RAGA</div>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <div class="flex items-center gap-3 pr-6 border-r border-white/20">
                        <a href="https://facebook.com" class="social-pill text-white/90 hover:bg-white/20 hover:text-white focus-visible:ring-offset-blue-700" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 9H16l.5-3h-3V4.5c0-.9.3-1.5 1.5-1.5H16V0h-2.4C10.9 0 10 1.9 10 4.1V6H7v3h3v9h3V9Z"/></svg>
                        </a>
                        <a href="https://instagram.com" class="social-pill text-white/90 hover:bg-white/20 hover:text-white focus-visible:ring-offset-blue-700" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5Zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5Zm5.75-3.75a1.25 1.25 0 1 1-1.25 1.25 1.25 1.25 0 0 1 1.25-1.25Z"/></svg>
                        </a>
                        <a href="https://bkkbn.go.id" class="social-pill text-white/90 hover:bg-white/20 hover:text-white focus-visible:ring-offset-blue-700" aria-label="Portal BKKBN">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v4.59l-8 4.44-8-4.44Zm8 9.82 8-4.44V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-9.62Z"/></svg>
                        </a>
                    </div>
                    <a href="#hero" class="hover:text-blue-300">Beranda</a>
                    <a href="#tentang" class="hover:text-blue-300">Tentang Kami</a>
                    <a href="#services" class="hover:text-blue-300">Layanan Kami</a>
                    <a href="#data-riset" class="hover:text-blue-300">Data Riset</a>
                    <a href="#galeri" class="hover:text-blue-300">Galeri Program</a>
                    <a href="#edukasi" class="hover:text-blue-300">Edukasi</a>
                    <a href="#contact" class="hover:text-blue-300">Kontak</a>
                </nav>
                <!-- Mobile menu button -->
                <button id="mobile-menu-toggle" class="md:hidden inline-flex items-center justify-center rounded-md p-2 hover:bg-[#26d48c] focus:outline-none focus:ring-2 focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    <span class="sr-only">Open menu</span>
                </button>
            </div>
        </div>
        <!-- Mobile menu (animated slide) -->
        <div id="mobile-menu" class="md:hidden bg-blue-700/95 border-t border-blue-600 overflow-hidden max-h-0 opacity-0 -translate-y-1 pointer-events-none transition-all duration-200 ease-out" data-open="false">
            <div class="px-5 py-3 space-y-4 text-sm">
                <div class="flex items-center gap-3 pb-3 border-b border-blue-500/40">
                    <a href="https://facebook.com" class="social-pill text-white/90 hover:bg-white/20 hover:text-white focus-visible:ring-offset-blue-700" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 9H16l.5-3h-3V4.5c0-.9.3-1.5 1.5-1.5H16V0h-2.4C10.9 0 10 1.9 10 4.1V6H7v3h3v9h3V9Z"/></svg>
                    </a>
                    <a href="https://instagram.com" class="social-pill text-white/90 hover:bg-white/20 hover:text-white focus-visible:ring-offset-blue-700" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5Zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5Zm5.75-3.75a1.25 1.25 0 1 1-1.25 1.25 1.25 1.25 0 0 1 1.25-1.25Z"/></svg>
                    </a>
                    <a href="https://bkkbn.go.id" class="social-pill text-white/90 hover:bg-white/20 hover:text-white focus-visible:ring-offset-blue-700" aria-label="Portal BKKBN">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v4.59l-8 4.44-8-4.44Zm8 9.82 8-4.44V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-9.62Z"/></svg>
                    </a>
                </div>
                <div class="space-y-2">
                    <a href="#hero" class="block hover:text-blue-200">Beranda</a>
                    <a href="#tentang" class="block hover:text-blue-200">Tentang Kami</a>
                    <a href="#services" class="block hover:text-blue-200">Layanan Kami</a>
                    <a href="#data-riset" class="block hover:text-blue-200">Data Riset</a>
                    <a href="#galeri" class="block hover:text-blue-200">Galeri Program</a>
                    <a href="#edukasi" class="block hover:text-blue-200">Edukasi</a>
                    <a href="#contact" class="block hover:text-blue-200">Kontak</a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Carousel with Overlay -->
        <section id="hero" class="relative h-[60vh] min-h-[420px] md:h-[70vh] md:min-h-[520px]">
            <div id="hero-slides" class="absolute inset-0">
                <div id="hero-slide-a" class="absolute inset-0 bg-center bg-cover opacity-0 transition-opacity duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]"></div>
                <div id="hero-slide-b" class="absolute inset-0 bg-center bg-cover opacity-0 transition-opacity duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]"></div>
            </div>
            <div class="absolute inset-0 bg-black/55"></div>

            <div class="relative z-10 h-full">
                <div class="max-w-7xl w-full mx-auto h-full px-4 sm:px-5 md:px-8 flex items-center justify-center">
                    <div class="max-w-3xl w-full mx-auto text-center px-1 sm:px-0">
                        <div class="text-blue-400 font-semibold mb-2 break-words" id="hero-subheading">Program Prioritas Nasional</div>
                        <h1 id="hero-heading" class="text-white text-3xl sm:text-4xl md:text-6xl font-extrabold leading-tight drop-shadow break-words">Cegah Stunting, Investasi Masa Depan Bangsa</h1>
                        <p id="hero-description" class="text-white/90 mt-4 sm:mt-5 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto break-words">Kami hadir untuk memberikan informasi, edukasi, dan data penting dalam upaya pencegahan stunting demi generasi yang lebih sehat dan cerdas.</p>
                        <div class="mt-8 flex flex-col items-center sm:flex-row gap-4 justify-center">
                            <a id="hero-btn-1" href="#" class="inline-flex flex-wrap items-center justify-center text-center break-words rounded-full px-6 py-3 bg-blue-600 hover:bg-[#26d48c] text-white font-medium transition-transform duration-200 ease-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/70 shadow-sm">Pelajari Lebih Lanjut</a>
                            <a id="hero-btn-2" href="#contact" class="inline-flex flex-wrap items-center justify-center text-center break-words rounded-full px-6 py-3 bg-blue-600 hover:bg-[#26d48c] text-white font-medium transition-transform duration-200 ease-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/70 shadow-sm">Hubungi Kami</a>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button id="hero-prev" aria-label="Previous" class="absolute left-4 bottom-5 top-auto translate-y-0 bg-blue-600/90 hover:bg-[#26d48c] text-white w-9 h-9 md:w-10 md:h-10 rounded-full grid place-items-center md:left-3 md:top-1/2 md:bottom-auto md:-translate-y-1/2">&#x276E;</button>
                <button id="hero-next" aria-label="Next" class="absolute right-4 bottom-5 top-auto translate-y-0 bg-blue-600/90 hover:bg-[#26d48c] text-white w-9 h-9 md:w-10 md:h-10 rounded-full grid place-items-center md:right-3 md:top-1/2 md:bottom-auto md:-translate-y-1/2">&#x276F;</button>
            </div>
        </section>

        <!-- Tentang Kami -->
        <section id="tentang" class="max-w-7xl mx-auto px-5 py-16 scroll-mt-16">
            <div class="grid gap-12 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] items-center">
                <div class="order-1 lg:order-2 space-y-6">
                    <p class="text-blue-600 font-semibold uppercase tracking-[0.32em]">Tentang Kami</p>
                    <h2 id="about-title" class="text-3xl md:text-4xl font-bold leading-tight break-words">BKKBN</h2>
                    <div class="space-y-4 text-gray-700">
                        <p id="about-p1" class="leading-relaxed break-words"></p>
                        <p id="about-p2" class="leading-relaxed break-words hidden"></p>
                    </div>
                    <div>
                        <a id="about-cta" href="#" class="inline-flex flex-wrap items-center justify-center text-center break-words rounded-full px-8 py-3 text-sm font-semibold text-white bg-blue-600 shadow-sm hover:bg-[#26d48c] focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-offset-2 hidden"></a>
                    </div>
                </div>
                <div class="order-2 lg:order-1 flex justify-center lg:justify-start">
                    <div class="relative w-full max-w-xl xl:max-w-2xl pb-12 lg:pb-20">
                        <div class="relative aspect-[4/3] w-full rounded-[32px] bg-gradient-to-br from-blue-100 via-white to-blue-50 shadow-xl overflow-hidden">
                            <img id="about-main" data-src="" alt="Tentang Kami" loading="lazy" decoding="async" class="absolute inset-0 h-full w-full object-cover" hidden>
                        </div>
                        <div id="about-overlay-frame" class="absolute left-1/2 bottom-[-12%] w-[72%] max-w-lg -translate-x-1/2 rounded-[28px] shadow-2xl overflow-hidden border-8 border-white bg-white hidden md:block">
                            <img id="about-overlay" data-src="" alt="Overlay" loading="lazy" decoding="async" class="h-full w-full object-cover" hidden>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Layanan Kami -->
        <section id="services" class="max-w-7xl mx-auto px-5 py-16 scroll-mt-16">
            <h2 class="text-2xl font-semibold mb-6">Layanan Kami</h2>
            <div id="services-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
        </section>

        <!-- Data Riset -->
        <section id="data-riset" class="max-w-7xl mx-auto px-5 py-16 scroll-mt-16">
            <div class="flex flex-col lg:flex-row lg:items-start gap-10">
                <div class="flex-1 w-full">
                    <h2 class="text-2xl font-semibold mb-4 sm:mb-6">Data Riset</h2>
                    <p class="text-sm text-gray-500 mb-6 max-w-2xl">Visualisasi indikator utama untuk mendukung pengambilan keputusan.</p>
                    <div id="riset-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>
                </div>
                <aside class="w-full max-w-md">
                    <div id="riset-chart-card" class="reveal-on-scroll bg-white border border-blue-100 rounded-3xl shadow-lg p-6 soft-lift" data-reveal-delay="120" data-reveal-distance="24">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">Distribusi Data</h3>
                                <p class="text-sm text-gray-500">Persentase kontribusi setiap indikator.</p>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-center">
                            <div class="relative w-48 h-48">
                                <div id="riset-chart-visual" class="w-full h-full rounded-full bg-slate-200 transition-[background] duration-500 ease-out"></div>
                                <div class="absolute inset-9 rounded-full bg-white flex flex-col items-center justify-center text-center shadow-inner">
                                    <span id="riset-chart-total" class="text-2xl font-bold text-blue-600">0</span>
                                    <span class="text-xs font-semibold tracking-wide text-gray-400 uppercase">Total</span>
                                </div>
                            </div>
                        </div>
                        <ul id="riset-chart-legend" class="mt-6 space-y-3 text-sm text-gray-600"></ul>
                        <p id="riset-chart-empty" class="mt-4 text-sm text-gray-400 text-center hidden">Data riset belum tersedia.</p>
                    </div>
                </aside>
            </div>
        </section>

        <!-- Galeri Program -->
        <section id="galeri" class="bg-white scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5 py-16">
                <h2 class="text-2xl font-semibold mb-6">Galeri Program</h2>
                <div id="galeri-grid" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6"></div>
            </div>
        </section>
        <!-- Edukasi -->
        <section id="edukasi" class="scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5 py-16">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10">
                    <div class="space-y-3">
                        <p class="text-sm font-semibold uppercase tracking-[0.32em] text-blue-400">Edukasi</p>
                        <h2 class="text-3xl font-bold text-gray-900">Materi Edukasi Pilihan</h2>
                        <p class="text-gray-600 max-w-2xl">Kumpulan materi konseling, modul, dan sumber belajar untuk mendukung pencegahan stunting di Kota Tomohon.</p>
                    </div>
                    <p id="edukasi-empty" class="text-sm text-gray-500 md:text-right" hidden>Materi edukasi sedang disiapkan.</p>
                </div>
                <div id="edukasi-grid" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"></div>
            </div>
        </section>

        <!-- Kontak -->
        <section id="contact" class="bg-gradient-to-b from-blue-50 via-white to-white scroll-mt-16">
            <div class="max-w-7xl mx-auto px-5 py-16">
                <div class="max-w-3xl w-full mx-auto text-center px-1 sm:px-0 reveal-on-scroll" data-reveal-delay="0" data-reveal-distance="28" data-reveal-duration="450">
                    <div class="text-blue-600 font-semibold uppercase tracking-wide mb-2">Hubungi Kami</div>
                    <h2 class="text-3xl font-bold text-gray-900">Layanan Informasi & Konsultasi Program Keluarga Berkualitas</h2>
                    <p class="mt-4 text-base text-gray-600">Tim DPPKBD Kota Tomohon siap membantu Anda mendapatkan informasi dan dukungan terkait pencegahan stunting serta pelayanan keluarga berkualitas. Silakan hubungi kami melalui detail kontak atau formulir di bawah ini.</p>
                </div>

                <div class="mt-12 space-y-10">
                    <div class="grid gap-5 md:grid-cols-3 items-start">
                        <div class="reveal-on-scroll bg-white border border-blue-100 rounded-2xl shadow-md p-6 soft-lift self-start" data-reveal-delay="0" data-reveal-distance="24">
                            <div class="flex items-start gap-3">
                                <span class="flex size-10 items-center justify-center rounded-full bg-blue-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M6.62 10.79a15.07 15.07 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24 11.36 11.36 0 0 0 3.56.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 7a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.43.57 3.56a1 1 0 0 1-.24 1.01l-2.21 2.22Z"/></svg>
                                </span>
                                <div class="space-y-1">
                                    <div class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Telepon</div>
                                    <p class="text-base font-semibold text-gray-900">+62 812 3456 7890</p>
                                </div>
                            </div>
                        </div>
                        <div class="reveal-on-scroll bg-white border border-blue-100 rounded-2xl shadow-md p-6 soft-lift self-start" data-reveal-delay="0" data-reveal-distance="24">
                            <div class="flex items-start gap-3">
                                <span class="flex size-10 items-center justify-center rounded-full bg-blue-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 5.54 11.19 6.1 11.77a1.25 1.25 0 0 0 1.8 0C13.46 20.19 19 14.25 19 9a7 7 0 0 0-7-7Zm0 9.75A2.75 2.75 0 1 1 14.75 9 2.75 2.75 0 0 1 12 11.75Z"/></svg>
                                </span>
                                <div>
                                    <div class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Alamat Kantor</div>
                                    <p class="mt-1 text-base font-semibold text-gray-900">DPPKBD Kota Tomohon</p>
                                    <p class="mt-1 text-sm leading-relaxed text-gray-600">Jl. Terminal Beriman, Tomohon Timur, Kota Tomohon, Sulawesi Utara</p>
                                    <a href="https://maps.app.goo.gl/fgaeUK9bJzSJEVeX8" target="_blank" rel="noopener" class="mt-3 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700">Lihat di Google Maps</a>
                                </div>
                            </div>
                        </div>
                        <div class="reveal-on-scroll bg-white border border-blue-100 rounded-2xl shadow-md p-6 soft-lift self-start" data-reveal-delay="0" data-reveal-distance="24">
                            <div class="flex items-start gap-3">
                                <span class="flex size-10 items-center justify-center rounded-full bg-blue-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M4 5a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3Zm3-1a1 1 0 0 0-1 1v.52l6 4.8 6-4.8V5a1 1 0 0 0-1-1Z"/></svg>
                                </span>
                                <div class="space-y-1">
                                    <div class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Email</div>
                                    <p class="text-base font-semibold text-gray-900 break-all">info@bkkbntomohon.go.id</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-8 justify-items-center">
                        <div class="reveal-on-scroll bg-white border border-blue-100 rounded-3xl shadow-lg p-4 sm:p-6 soft-lift max-w-xl w-full mx-auto" data-reveal-direction="left" data-reveal-distance="32" data-reveal-delay="0" data-reveal-duration="500">
                            <div id="contact-map" class="relative overflow-hidden rounded-2xl bg-blue-100 aspect-[16/9] max-h-[320px]" data-map-src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d400.7362813471956!2d124.84545321272765!3d1.3278442313099665!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32876cbf563f23cd%3A0xb6bed2f0f750445!2sDinas%20Pengendalian%20Penduduk%20%26%20KB%20Daerah%20Kota%20Tomohon!5e0!3m2!1sen!2sid!4v1758160730812!5m2!1sen!2sid" data-map-title="Lokasi DPPKBD Tomohon" data-map-referrerpolicy="no-referrer-when-downgrade">
                                <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 px-6 text-center text-blue-900/70" data-map-placeholder>
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-9 w-9 text-blue-700/60" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 3 3 6v15l6-3 6 3 6-3V6l-6-3-6 3v15" />
                                        <path d="M15 7.75a2.25 2.25 0 1 1-2.25 2.25A2.25 2.25 0 0 1 15 7.75Z" />
                                    </svg>
                                    <p class="text-sm font-semibold break-words" data-map-message>Aktifkan peta interaktif untuk petunjuk arah.</p>
                                    <button type="button" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-[#26d48c] focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2 focus-visible:ring-offset-blue-100" data-map-trigger>
                                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true" class="h-4 w-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 5v14" />
                                            <path d="m5 12 7-7 7 7" />
                                        </svg>
                                        <span>Muat Peta</span>
                                    </button>
                                </div>
                            </div>
                            <noscript>
                                <div class="overflow-hidden rounded-2xl bg-blue-100 aspect-[16/9] max-h-[320px]">
                                    <iframe title="Lokasi DPPKBD Tomohon" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d400.7362813471956!2d124.84545321272765!3d1.3278442313099665!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32876cbf563f23cd%3A0xb6bed2f0f750445!2sDinas%20Pengendalian%20Penduduk%20%26%20KB%20Daerah%20Kota%20Tomohon!5e0!3m2!1sen!2sid!4v1758160730812!5m2!1sen!2sid" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full h-full border-0"></iframe>
                                </div>
                            </noscript>
                            <p class="mt-3 text-sm text-gray-500">Gunakan peta untuk menemukan lokasi kantor kami dengan mudah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-slate-950 text-slate-100">
        <div class="max-w-7xl mx-auto px-5 py-16">
            <div class="grid gap-16 lg:grid-cols-[1.3fr_minmax(0,1fr)_minmax(0,1fr)]">
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-600/20 ring-1 ring-blue-500/40">
                            <img src="{{ Vite::asset('resources/views/logo-bkkbn.png') }}" alt="Logo BKKBN" loading="lazy" decoding="async" class="h-9 w-9 object-contain" onerror="this.style.display='none'" />
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-white">Cegah Stunting Tomohon</p>
                            <p class="text-xs uppercase tracking-[0.22em] text-blue-400">Bergerak Bersama Keluarga</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-300">Portal edukasi dan layanan terpadu DPPKBD Tomohon untuk memutus rantai stunting, menguatkan keluarga, dan memastikan tumbuh kembang balita yang optimal.</p>
                    <div class="flex items-center gap-3">
                        <a href="https://facebook.com" class="social-pill" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 9H16l.5-3h-3V4.5c0-.9.3-1.5 1.5-1.5H16V0h-2.4C10.9 0 10 1.9 10 4.1V6H7v3h3v9h3V9Z"/></svg>
                        </a>
                        <a href="https://instagram.com" class="social-pill" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5Zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5Zm5.75-3.75a1.25 1.25 0 1 1-1.25 1.25 1.25 1.25 0 0 1 1.25-1.25Z"/></svg>
                        </a>
                        <a href="https://bkkbn.go.id" class="social-pill" aria-label="Portal BKKBN">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v4.59l-8 4.44-8-4.44Zm8 9.82 8-4.44V20a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-9.62Z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="footer-links">
                    <h3 class="footer-heading">Navigasi</h3>
                    <ul class="footer-list">
                        <li><a href="#hero" class="footer-link">Beranda</a></li>
                        <li><a href="#tentang" class="footer-link">Tentang Kami</a></li>
                        <li><a href="#services" class="footer-link">Layanan Kami</a></li>
                        <li><a href="#data-riset" class="footer-link">Basis Data</a></li>
                        <li><a href="#galeri" class="footer-link">Galeri Program</a></li>
                        <li><a href="#edukasi" class="footer-link">Edukasi</a></li>
                    </ul>
                </div>

                <div class="space-y-6">
                    <h3 class="footer-heading">Kontak Kami</h3>
                    <div class="space-y-6 text-sm text-slate-300">
                        <div class="flex gap-3">
                            <span class="footer-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/></svg>
                            </span>
                            <div class="space-y-2">
                                <div class="footer-contact-meta">Alamat Kantor</div>
                                <p class="footer-contact-title">DPPKBD Tomohon</p>
                                <p class="leading-relaxed">Jl. Terminal Beriman, Tomohon Timur, Kota Tomohon, Sulawesi Utara</p>
                                <a href="https://maps.app.goo.gl/fgaeUK9bJzSJEVeX8" target="_blank" rel="noopener" class="footer-contact-link">Lihat di Google Maps</a>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <span class="footer-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5.27 3.52A3 3 0 0 1 8.1 2h.46a1.5 1.5 0 0 1 1.43 1.05l1 3a1.5 1.5 0 0 1-.38 1.52l-1.2 1.17a10.94 10.94 0 0 0 4.8 4.8l1.17-1.2a1.5 1.5 0 0 1 1.52-.38l3 1a1.5 1.5 0 0 1 1.05 1.43v.46a3 3 0 0 1-1.52 2.83l-.52.26a4.5 4.5 0 0 1-4.13-.08 22.52 22.52 0 0 1-9.68-9.68 4.5 4.5 0 0 1-.08-4.13Z"/></svg>
                            </span>
                            <div class="space-y-2">
                                <div class="footer-contact-meta">Telepon</div>
                                <p class="footer-contact-title">+62 812 3456 7890</p>
                                <a href="tel:+6281234567890" class="footer-contact-link">Hubungi langsung</a>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <span class="footer-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 5a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3Zm3-1a1 1 0 0 0-1 1v.52l6 4.8 6-4.8V5a1 1 0 0 0-1-1Z"/></svg>
                            </span>
                            <div class="space-y-2">
                                <div class="footer-contact-meta">Email</div>
                                <p class="footer-contact-title">info@bkkbntomohon.go.id</p>
                                <a href="mailto:info@bkkbntomohon.go.id" class="footer-contact-link">Kirim Email</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-16 flex flex-col gap-4 border-t border-slate-800 pt-6 text-xs text-slate-400 md:flex-row md:items-center md:justify-between">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'BKKBN') }}. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-4">
                    <a href="https://tomohon.go.id" class="hover:text-blue-300 transition-colors">DPPKBD Tomohon</a>
                </div>
                <a href="#hero" class="inline-flex items-center justify-center gap-2 self-start rounded-full bg-blue-600 px-4 py-2 font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:bg-blue-500 md:self-auto">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="h-4 w-4"><path d="m12 5 7 7H5z"/></svg>
                    Kembali ke atas
                </a>
            </div>
        </div>
    </footer>
</body>
</html>







