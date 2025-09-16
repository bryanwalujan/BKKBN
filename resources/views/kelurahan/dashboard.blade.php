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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card: Data Balita Diunggah -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-md font-medium mb-2">Data Balita Diunggah</h4>
                <p class="text-2xl font-bold">{{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->where('created_by', auth()->user()->id)->count() }}</p>
                <a href="{{ route('kelurahan.balita.index', ['tab' => 'pending']) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat Data</a>
            </div>

            <!-- Card: Statistik Kategori Umur -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-md font-medium mb-2">Statistik Kategori Umur</h4>
                <ul class="text-gray-600">
                    <li>Baduata (0-24 bulan): 
                        {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() + 
                           \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 24')->count() }}
                    </li>
                    <li>Balita (25-60 bulan): 
                        {{ \App\Models\PendingBalita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() + 
                           \App\Models\Balita::where('kelurahan_id', auth()->user()->kelurahan_id)->whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) > 24 AND TIMESTAMPDIFF(MONTH, tanggal_lahir, CURDATE()) <= 60')->count() }}
                    </li>
                </ul>
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