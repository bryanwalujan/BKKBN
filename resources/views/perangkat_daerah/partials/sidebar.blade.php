<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <div class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white p-4">
        <h1 class="text-2xl font-bold mb-6">Perangkat Daerah</h1>
        <nav>
            <ul>
                <li class="mb-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('perangkat_daerah.genting.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Data Genting</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Data Aksi Konvergensi</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('perangkat_daerah.pendamping_keluarga.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Data Pendamping Keluarga</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('perangkat_daerah.data_monitoring.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ Route::is('perangkat_daerah.data_monitoring.*') ? 'bg-gray-700' : '' }}">Data Monitoring</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('perangkat_daerah.audit_stunting.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Audit Stunting</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('perangkat_daerah.kartu_keluarga.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ Route::is('perangkat_daerah.data_monitoring.*') ? 'bg-gray-700' : '' }}">Kartu Keluarga</a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('perangkat_daerah.peta_geospasial.index') }}" class="flex items-center space-x-2 hover:text-gray-300">
                        <i class="fas fa-tasks"></i>
                        <span>Peta Geospasial</span>
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