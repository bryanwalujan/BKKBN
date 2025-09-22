<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="fixed top-0 left-0 h-full w-64 bg-green-900 text-white p-4 shadow-lg">
        <h2 class="text-2xl font-bold mb-6">Admin Kecamatan</h2>
        <nav>
            <ul>
                <li class="mb-3">
                    <a href="{{ route('dashboard') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'dashboard' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-home mr-2"></i> Dashboard
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.balita.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.balita.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-child mr-2"></i> Data Balita
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.kartu_keluarga.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.kartu_keluarga.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-id-card mr-2"></i> Kartu Keluarga
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.remaja_putri.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.remaja_putri.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-female mr-2"></i> Data Remaja Putri
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.ibu.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.ibu.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-user-friends mr-2"></i> Data Ibu
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.ibu_hamil.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.ibu_hamil.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-female mr-2"></i> Data Ibu Hamil
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.ibu_nifas.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.ibu_nifas.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-female mr-2"></i> Data Ibu Nifas
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.ibu_menyusui.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.ibu_menyusui.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-female mr-2"></i> Data Ibu Menyusui
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('kecamatan.stunting.index') }}"
                       class="block p-3 hover:bg-green-800 rounded transition-colors duration-200 {{ Route::currentRouteName() === 'kecamatan.stunting.index' ? 'bg-green-800' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i> Data Stunting
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('kecamatan.genting.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Data Genting</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('kecamatan.audit_stunting.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Audit Stunting</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('kecamatan.pendamping_keluarga.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Pendamping Keluarga</span>
                    </a>
                </li>
                <li>
                <a href="{{ route('kecamatan.data_monitoring.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ Route::is('kecamatan.data_monitoring.*') ? 'bg-gray-700' : '' }}">Verifikasi Data Monitoring</a>
            </li>
                <li class="mb-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left p-3 hover:bg-green-800 rounded transition-colors duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html>