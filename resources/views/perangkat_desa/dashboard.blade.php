<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Perangkat Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-white text-xl font-bold">Dashboard Perangkat Desa</h1>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white hover:underline">Logout</button>
            </form>
        </div>
    </nav>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <h2 class="text-2xl font-semibold mb-4">Selamat Datang, Perangkat Desa!</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-medium">Input Data Desa</h3>
                <p class="text-gray-600">Tambahkan data keluarga di desa Anda.</p>
                <a href="#" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data</a>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-medium">Lihat Data</h3>
                <p class="text-gray-600">Lihat data anak stunting, sehat, dan ibu hamil/menyusui.</p>
                <a href="#" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat Data</a>
            </div>
        </div>
    </div>
</body>
</html>