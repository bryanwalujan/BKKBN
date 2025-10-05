<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="fixed top-0 left-0 h-full w-64 bg-blue-900 text-white p-4 shadow-lg">
        <h2 class="text-2xl font-bold mb-6">Admin Kelurahan</h2>
        <nav>
            <ul>
                <li class="mb-3">
                    <a href="{{ route('dashboard') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'dashboard' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-home mr-2"></i> Dashboard
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.kartu_keluarga.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.kartu_keluarga.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-id-card mr-2"></i> Kartu Keluarga
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.bayi_baru_lahir.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.balita.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-child mr-2"></i> Bayi Baru Lahir
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.balita.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.balita.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-child mr-2"></i> Data Balita
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.ibu.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.ibu.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-user-friends mr-2"></i> Data Ibu
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.ibu_hamil.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.ibu_hamil.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-female mr-2"></i> Data Ibu Hamil
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.ibu_nifas.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.ibu_nifas.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-female mr-2"></i> Data Ibu Nifas
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.ibu_menyusui.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.ibu_menyusui.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-female mr-2"></i> Data Ibu Menyusui
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.stunting.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.stunting.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i> Data Stunting
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.catin.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.stunting.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i> Calon Pengantin
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kelurahan.peta_geospasial.index') }}"
                       class="block p-3 hover:bg-blue-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kelurahan.peta_geospasial.index' ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-map-marked-alt mr-2"></i> Peta Geospasial
                    </a>
                </li>
                <li class="mb-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left p-3 hover:bg-blue-800 rounded transition-colors duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html>