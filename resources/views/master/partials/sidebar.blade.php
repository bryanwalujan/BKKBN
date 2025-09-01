<aside class="w-64 bg-blue-800 text-white h-screen fixed top-0 left-0">
    <div class="p-4">
        <h1 class="text-2xl font-bold">Master Panel</h1>
    </div>
    <nav class="mt-4">
        <ul>
            <li>
                <a href="{{ route('balita.index') }}" class="block p-4 hover:bg-blue-700 {{ Route::is('balita.*') ? 'bg-blue-700' : '' }}">Informasi Balita</a>
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