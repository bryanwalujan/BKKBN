<aside class="w-64 bg-blue-600 text-white h-screen fixed top-0 left-0 overflow-y-auto transition-all duration-300 z-50 shadow-2xl">
    <!-- Header -->
    <div class="p-6 border-b border-white/20">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold">Master Panel</h1>
                <p class="text-white/70 text-xs">Admin Dashboard</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="py-4">
        <ul class="space-y-2 px-3">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::is('dashboard') ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>

            <!-- Perdataan -->
            <li>
                <button class="flex items-center justify-between w-full p-3 rounded-lg transition-all duration-200 group 
                              {{ Route::is('bayi_baru_lahir.*','catin.*','ibu.*', 'balita.*', 'stunting.*', 'ibu_hamil.*', 'ibu_nifas.*', 'ibu_menyusui.*', 'kartu_keluarga.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-white/90 hover:text-white' }}"
                        onclick="toggleDropdown('perdataan-dropdown')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="font-medium">Perdataan</span>
                    </div>
                    <svg id="perdataan-arrow" class="w-4 h-4 transition-transform duration-200 
                        {{ Route::is('bayi_baru_lahir.*','catin.*','ibu.*', 'balita.*', 'stunting.*', 'ibu_hamil.*', 'ibu_nifas.*', 'ibu_menyusui.*', 'kartu_keluarga.*') ? 'rotate-180' : '' }}" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul id="perdataan-dropdown" class="ml-8 mt-2 space-y-1 
                    {{ Route::is('bayi_baru_lahir.*','catin.*','ibu.*', 'balita.*', 'stunting.*', 'ibu_hamil.*', 'ibu_nifas.*', 'ibu_menyusui.*', 'kartu_keluarga.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('kartu_keluarga.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('kartu_keluarga.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-sm">Kelola Kartu Keluarga</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bayi_baru_lahir.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('bayi_baru_lahir.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span class="text-sm">Bayi Baru Lahir</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('balita.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('balita.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span class="text-sm">Informasi Balita</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stunting.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('stunting.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-sm">Data Stunting</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ibu.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('ibu.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm">Data Ibu</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ibu_hamil.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('ibu_hamil.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm">Data Ibu Hamil</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ibu_nifas.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('ibu_nifas.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="text-sm">Data Ibu Nifas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ibu_menyusui.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('ibu_menyusui.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Data Ibu Menyusui</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('catin.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('catin.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Calon Pengantin</span>
                        </a>
                    </li>
                    <li>
                    </li>
                </ul>
            </li>

            <!-- Kelola Kegiatan -->
            <li>
                <button class="flex items-center justify-between w-full p-3 rounded-lg transition-all duration-200 group 
                              {{ Route::is('genting.*', 'aksi_konvergensi.*', 'peta_geospasial.*', 'pendamping_keluarga.*', 'data_monitoring.*', 'audit_stunting.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-white/90 hover:text-white' }}"
                        onclick="toggleDropdown('kelola-kegiatan-dropdown')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span class="font-medium">Kelola Kegiatan</span>
                    </div>
                    <svg id="kelola-kegiatan-arrow" class="w-4 h-4 transition-transform duration-200 
                        {{ Route::is('genting.*', 'aksi_konvergensi.*', 'peta_geospasial.*', 'pendamping_keluarga.*', 'data_monitoring.*', 'audit_stunting.*') ? 'rotate-180' : '' }}" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul id="kelola-kegiatan-dropdown" class="ml-8 mt-2 space-y-1 
                    {{ Route::is('genting.*', 'aksi_konvergensi.*', 'peta_geospasial.*', 'pendamping_keluarga.*', 'data_monitoring.*', 'audit_stunting.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('genting.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('genting.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h-3m3 0h3"/>
                            </svg>
                            <span class="text-sm">Genting</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('aksi_konvergensi.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('aksi_konvergensi.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="text-sm">Aksi Konvergensi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('peta_geospasial.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('peta_geospasial.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <span class="text-sm">Peta Geospasial</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pendamping_keluarga.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('pendamping_keluarga.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="text-sm">Pendamping Keluarga</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data_monitoring.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('data_monitoring.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                            <span class="text-sm">Data Monitoring</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('audit_stunting.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('audit_stunting.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">Audit Stunting</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Kelola Beranda -->
            <li>
                <button class="flex items-center justify-between w-full p-3 rounded-lg transition-all duration-200 group 
                              {{ Route::is('carousel.*', 'data_riset.*', 'tentang_kami.*', 'layanan_kami.*', 'galeri_program.*', 'edukasi.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-white/90 hover:text-white' }}"
                        onclick="toggleDropdown('kelola-beranda-dropdown')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="font-medium">Kelola Beranda</span>
                    </div>
                    <svg id="kelola-beranda-arrow" class="w-4 h-4 transition-transform duration-200 
                        {{ Route::is('carousel.*', 'data_riset.*', 'tentang_kami.*', 'layanan_kami.*', 'galeri_program.*', 'edukasi.*') ? 'rotate-180' : '' }}" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul id="kelola-beranda-dropdown" class="ml-8 mt-2 space-y-1 
                    {{ Route::is('carousel.*', 'data_riset.*', 'tentang_kami.*', 'layanan_kami.*', 'galeri_program.*', 'edukasi.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('carousel.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('carousel.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Carousel</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data_riset.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('data_riset.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Data Riset</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tentang_kami.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('tentang_kami.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">Tentang Kami</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('layanan_kami.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('layanan_kami.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Layanan Kami</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('galeri_program.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('galeri_program.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm">Galeri Program</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('edukasi.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('edukasi.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm">Edukasi</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Kelola Akun -->
            <li>
                <button class="flex items-center justify-between w-full p-3 rounded-lg transition-all duration-200 group 
                              {{ Route::is('verifikasi.*', 'templates.*', 'users.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-white/90 hover:text-white' }}"
                        onclick="toggleDropdown('kelola-akun-dropdown')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="font-medium">Kelola Akun</span>
                    </div>
                    <svg id="kelola-akun-arrow" class="w-4 h-4 transition-transform duration-200 
                        {{ Route::is('verifikasi.*', 'templates.*', 'users.*') ? 'rotate-180' : '' }}" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul id="kelola-akun-dropdown" class="ml-8 mt-2 space-y-1 
                    {{ Route::is('verifikasi.*', 'templates.*', 'users.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('verifikasi.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('verifikasi.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">Verifikasi Akun</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('templates.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('templates.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8"/>
                            </svg>
                            <span class="text-sm">Kelola Template</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('users.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="text-sm">Kelola Pengguna</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Lainnya -->
            <li>
                <button class="flex items-center justify-between w-full p-3 rounded-lg transition-all duration-200 group 
                              {{ Route::is('publikasi.*', 'referensi.*', 'data_penduduk.*') ? 'bg-white/20 text-white' : 'hover:bg-white/10 text-white/90 hover:text-white' }}"
                        onclick="toggleDropdown('lainnya-dropdown')">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">Lainnya</span>
                    </div>
                    <svg id="lainnya-arrow" class="w-4 h-4 transition-transform duration-200 
                        {{ Route::is('publikasi.*', 'referensi.*', 'data_penduduk.*') ? 'rotate-180' : '' }}" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul id="lainnya-dropdown" class="ml-8 mt-2 space-y-1 
                    {{ Route::is('publikasi.*', 'referensi.*', 'data_penduduk.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('publikasi.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('publikasi.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span class="text-sm">Publikasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('referensi.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('referensi.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-sm">Referensi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data_penduduk.index') }}" 
                           class="flex items-center space-x-3 p-2 rounded-lg transition-all duration-200 group 
                                  {{ Route::is('data_penduduk.*') ? 'bg-green-500 text-white shadow-md' : 'hover:bg-white/5 text-white/80 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="text-sm">Data Penduduk</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Logout -->
            <li class="pt-4 mt-4 border-t border-white/20">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="flex items-center space-x-3 w-full p-3 rounded-lg transition-all duration-200 group hover:bg-red-500/20 text-white/90 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>

<!-- JavaScript untuk toggle dropdown -->
<script>
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const arrow = document.getElementById(dropdownId.replace('-dropdown', '-arrow'));
    
    dropdown.classList.toggle('hidden');
    arrow.classList.toggle('rotate-180');
}
</script>

<!-- Fallback styles -->
<style>
aside {
    background-color: #2563eb !important; /* blue-600 */
}
.bg-blue-600 {
    background-color: #2563eb !important;
}
.bg-green-500 {
    background-color: #10b981 !important;
}
.bg-white\/20 {
    background-color: rgba(255, 255, 255, 0.2) !important;
}
.bg-white\/10 {
    background-color: rgba(255, 255, 255, 0.1) !important;
}
.bg-white\/5 {
    background-color: rgba(255, 255, 255, 0.05) !important;
}
.bg-red-500\/20 {
    background-color: rgba(239, 68, 68, 0.2) !important;
}
</style>