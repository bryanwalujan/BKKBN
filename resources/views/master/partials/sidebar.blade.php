<aside class="w-64 bg-blue-800 text-white h-screen fixed top-0 left-0">
    <div class="p-4">
        <h1 class="text-2xl font-bold">Master Panel</h1>
    </div>
    <nav class="mt-4">
        <ul>
            <li>
                <button class="block w-full text-left p-4 hover:bg-blue-700 {{ Route::is('balita.*', 'stunting.*', 'ibu_hamil.*', 'ibu_nifas.*', 'ibu_menyusui.*', 'remaja_putri.*') ? 'bg-blue-700' : '' }}"
                        onclick="document.getElementById('perdataan-dropdown').classList.toggle('hidden')">
                    Perdataan
                    <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul id="perdataan-dropdown" class="ml-4 {{ Route::is('balita.*', 'stunting.*', 'ibu_hamil.*', 'ibu_nifas.*', 'ibu_menyusui.*', 'remaja_putri.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('balita.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('balita.*') ? 'bg-blue-600' : '' }}">Informasi Balita</a>
                    </li>
                    <li>
                        <a href="{{ route('stunting.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('stunting.*') ? 'bg-blue-600' : '' }}">Data Stunting</a>
                    </li>
                    <li>
                        <a href="{{ route('ibu_hamil.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('ibu_hamil.*') ? 'bg-blue-600' : '' }}">Data Ibu Hamil</a>
                    </li>
                    <li>
                        <a href="{{ route('ibu_nifas.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('ibu_nifas.*') ? 'bg-blue-600' : '' }}">Data Ibu Nifas</a>
                    </li>
                    <li>
                        <a href="{{ route('ibu_menyusui.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('ibu_menyusui.*') ? 'bg-blue-600' : '' }}">Data Ibu Menyusui</a>
                    </li>
                    <li>
                        <a href="{{ route('remaja_putri.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('remaja_putri.*') ? 'bg-blue-600' : '' }}">Data Remaja Putri</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="block w-full text-left p-4 hover:bg-blue-700 {{ Route::is('genting.*', 'aksi_konvergensi.*', 'peta_geospasial.*', 'pendamping_keluarga.*') ? 'bg-blue-700' : '' }}"
                        onclick="document.getElementById('kelola-kegiatan-dropdown').classList.toggle('hidden')">
                    Kelola Kegiatan
                    <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul id="kelola-kegiatan-dropdown" class="ml-4 {{ Route::is('genting.*', 'aksi_konvergensi.*', 'peta_geospasial.*', 'pendamping_keluarga.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('genting.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('genting.*') ? 'bg-blue-600' : '' }}">Genting</a>
                    </li>
                    <li>
                        <a href="{{ route('aksi_konvergensi.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('aksi_konvergensi.*') ? 'bg-blue-600' : '' }}">Aksi Konvergensi</a>
                    </li>
                    <li>
                        <a href="{{ route('peta_geospasial.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('peta_geospasial.*') ? 'bg-blue-600' : '' }}">Peta Geospasial</a>
                    </li>
                    <li>
                        <a href="{{ route('pendamping_keluarga.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('pendamping_keluarga.*') ? 'bg-blue-600' : '' }}">Pendamping Keluarga</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="block w-full text-left p-4 hover:bg-blue-700 {{ Route::is('carousel.*', 'data_riset.*', 'tentang_kami.*', 'layanan_kami.*', 'galeri_program.*') ? 'bg-blue-700' : '' }}"
                        onclick="document.getElementById('kelola-beranda-dropdown').classList.toggle('hidden')">
                    Kelola Beranda
                    <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul id="kelola-beranda-dropdown" class="ml-4 {{ Route::is('carousel.*', 'data_riset.*', 'tentang_kami.*', 'layanan_kami.*', 'galeri_program.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('carousel.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('carousel.*') ? 'bg-blue-600' : '' }}">Carousel</a>
                    </li>
                    <li>
                        <a href="{{ route('data_riset.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('data_riset.*') ? 'bg-blue-600' : '' }}">Data Riset</a>
                    </li>
                    <li>
                        <a href="{{ route('tentang_kami.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('tentang_kami.*') ? 'bg-blue-600' : '' }}">Tentang Kami</a>
                    </li>
                    <li>
                        <a href="{{ route('layanan_kami.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('layanan_kami.*') ? 'bg-blue-600' : '' }}">Layanan Kami</a>
                    </li>
                    <li>
                        <a href="{{ route('galeri_program.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('galeri_program.*') ? 'bg-blue-600' : '' }}">Galeri Program</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="block w-full text-left p-4 hover:bg-blue-700 {{ Route::is('verifikasi.*', 'templates.*', 'users.*') ? 'bg-blue-700' : '' }}"
                        onclick="document.getElementById('kelola-akun-dropdown').classList.toggle('hidden')">
                    Kelola Akun
                    <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul id="kelola-akun-dropdown" class="ml-4 {{ Route::is('verifikasi.*', 'templates.*', 'users.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('verifikasi.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('verifikasi.*') ? 'bg-blue-600' : '' }}">Verifikasi Akun</a>
                    </li>
                    <li>
                        <a href="{{ route('templates.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('templates.*') ? 'bg-blue-600' : '' }}">Kelola Template</a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('users.*') ? 'bg-blue-600' : '' }}">Kelola Pengguna</a>
                    </li>
                </ul>
            </li>
            <li>
                <button class="block w-full text-left p-4 hover:bg-blue-700 {{ Route::is('publikasi.*', 'referensi.*', 'data_monitoring.*', 'data_penduduk.*') ? 'bg-blue-700' : '' }}"
                        onclick="document.getElementById('lainnya-dropdown').classList.toggle('hidden')">
                    Lainnya
                    <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul id="lainnya-dropdown" class="ml-4 {{ Route::is('publikasi.*', 'referensi.*', 'data_monitoring.*', 'data_penduduk.*') ? '' : 'hidden' }}">
                    <li>
                        <a href="{{ route('publikasi.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('publikasi.*') ? 'bg-blue-600' : '' }}">Publikasi</a>
                    </li>
                    <li>
                        <a href="{{ route('referensi.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('referensi.*') ? 'bg-blue-600' : '' }}">Referensi</a>
                    </li>
                    <li>
                        <a href="{{ route('data_monitoring.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('data_monitoring.*') ? 'bg-blue-600' : '' }}">Data Monitoring</a>
                    </li>
                    <li>
                        <a href="{{ route('data_penduduk.index') }}" class="block p-4 hover:bg-blue-600 {{ Route::is('data_penduduk.*') ? 'bg-blue-600' : '' }}">Data Penduduk</a>
                    </li>
                </ul>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left p-4 hover:bg-blue-700">Logout</button>
                </form>
            </li>
        </ul>
    </nav>
</aside>