<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="fixed top-0 left-0 h-full w-64 bg-gray-800 text-white p-4">
        <h2 class="text-xl font-semibold mb-4">Admin Kecamatan</h2>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('dashboard') }}" class="block p-2 hover:bg-gray-700 rounded">Dashboard</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('kecamatan.balita.index') }}" class="block p-2 hover:bg-gray-700 rounded">Verifikasi Data Balita</a>
                </li>
                <li class="mb-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left p-2 hover:bg-gray-700 rounded">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html>