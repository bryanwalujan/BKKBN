<aside class="w-64 bg-blue-800 text-white h-screen fixed top-0 left-0">
    <div class="p-4">
        <h1 class="text-2xl font-bold">Master Panel</h1>
    </div>
    <nav class="mt-4">
        <ul>
            <li>
                <button class="block w-full text-left p-4 hover:bg-blue-700 {{ Route::is('balita.*', 'stunting.*', 'ibu_hamil.*', 'ibu_nifas.*', 'ibu_menyusui.*', 'remaja_putri.*') ? 'bg-blue-700' : '' }}"
                        onclick="document.getElementById('pendataan-dropdown').classList.toggle('hidden')">
                    Pendataan
                    <svg class="inline-block w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <ul id="pendataan-dropdown" class="ml-4 {{ Route::is('balita.*', 'stunting.*', 'ibu_hamil.*', 'ibu_nifas.*', 'ibu_menyusui.*', 'remaja_putri.*') ? '' : 'hidden' }}">
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
                <a href="{{ route('genting.index') }}" class="block p-4 hover:bg-blue-700 {{ Route::is('genting.*') ? 'bg-blue-700' : '' }}">Genting</a>
            </li>
            <li>
                <a href="{{ route('verifikasi.index') }}" class="block p-4 hover:bg-blue-700 {{ Route::is('verifikasi.*') ? 'bg-blue-700' : '' }}">Verifikasi Akun</a>
            </li>
            <li>
                <a href="{{ route('templates.index') }}" class="block p-4 hover:bg-blue-700 {{ Route::is('templates.*') ? 'bg-blue-700' : '' }}">Kelola Template</a>
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