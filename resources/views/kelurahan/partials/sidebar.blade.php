<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white p-4">
        <h2 class="text-xl font-semibold mb-4">Admin Kelurahan</h2>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('kelurahan.balita.index') }}" class="block p-2 hover:bg-gray-700 rounded">Data
                        Balita</a>
                </li>
                <li class="mb-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left p-2 hover:bg-gray-700 rounded">Logout</button>
                    </form>
                </li>
                <li>
                    <a href="{{ route('kelurahan.kartu_keluarga.index') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Kartu Keluarga</a>
                </li>
                <li>
                    <a href="{{ route('kelurahan.ibu.index') }}"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Data Ibu</a>
                </li>
                <li class="px-4 py-2 hover:bg-gray-700">
                    <a href="{{ route('kelurahan.ibu_hamil.index') }}">Data Ibu Hamil</a>
                </li>
            </ul>
        </nav>
    </div>
</body>

</html>