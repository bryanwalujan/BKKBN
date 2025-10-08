<aside class="w-64 bg-gray-600 text-white h-screen fixed top-0 left-0 overflow-y-auto transition-all duration-300 z-50 shadow-2xl">
    <!-- Header -->
    <div class="p-6 border-b border-white/20">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold">Perangkat Daerah</h1>
                <p class="text-white/70 text-xs">Dashboard Daerah</p>
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
                          {{ Route::currentRouteName() === 'dashboard' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
            </li>

            <!-- Data Genting -->
            <li>
                <a href="{{ route('perangkat_daerah.genting.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::currentRouteName() === 'perangkat_daerah.genting.index' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h-3m3 0h3"/>
                    </svg>
                    <span class="font-medium">Data Genting</span>
                </a>
            </li>

            <!-- Data Aksi Konvergensi -->
            <li>
                <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::currentRouteName() === 'perangkat_daerah.aksi_konvergensi.index' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span class="font-medium">Data Aksi Konvergensi</span>
                </a>
            </li>

            <!-- Data Pendamping Keluarga -->
            <li>
                <a href="{{ route('perangkat_daerah.pendamping_keluarga.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::currentRouteName() === 'perangkat_daerah.pendamping_keluarga.index' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="font-medium">Data Pendamping Keluarga</span>
                </a>
            </li>

            <!-- Data Monitoring -->
            <li>
                <a href="{{ route('perangkat_daerah.data_monitoring.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::currentRouteName() === 'perangkat_daerah.data_monitoring.index' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    <span class="font-medium">Data Monitoring</span>
                </a>
            </li>

            <!-- Audit Stunting -->
            <li>
                <a href="{{ route('perangkat_daerah.audit_stunting.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::currentRouteName() === 'perangkat_daerah.audit_stunting.index' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">Audit Stunting</span>
                </a>
            </li>

            <!-- Kartu Keluarga -->
            <li>
                <a href="{{ route('perangkat_daerah.kartu_keluarga.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::currentRouteName() === 'perangkat_daerah.kartu_keluarga.index' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="font-medium">Kartu Keluarga</span>
                </a>
            </li>

            <!-- Peta Geospasial -->
            <li>
                <a href="{{ route('perangkat_daerah.peta_geospasial.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200 group 
                          {{ Route::currentRouteName() === 'perangkat_daerah.peta_geospasial.index' ? 'bg-green-500 text-white shadow-lg' : 'hover:bg-white/10 text-white/90 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <span class="font-medium">Peta Geospasial</span>
                </a>
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

<!-- Fallback styles -->
<style>
aside {
    background-color: #4b5563 !important; /* gray-600 */
}
.bg-gray-600 {
    background-color: #059669 !important;
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
.bg-red-500\/20 {
    background-color: rgba(239, 68, 68, 0.2) !important;
}
</style>