<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Dashboard Admin Kelurahan</h2>
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-medium">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p class="text-gray-600">Anda login sebagai Admin Kelurahan untuk {{ auth()->user()->kelurahan->nama_kelurahan ?? 'Kelurahan Tidak Diketahui' }}.</p>
        </div>

       

            <!-- Card: Total Balita Terverifikasi -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-md font-medium mb-2">Total Balita Terverifikasi</h4>
                <p class="text-2xl font-bold">{{ \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->count() }}</p>
                <a href="{{ route('kelurahan.balita.index', ['tab' => 'verified']) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat Data</a>
            </div>
        </div>
    </div>
</body>
</html>