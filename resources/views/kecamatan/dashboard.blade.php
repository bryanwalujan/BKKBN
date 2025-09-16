<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin Kecamatan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kecamatan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Dashboard Admin Kecamatan</h2>
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-lg font-medium">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p class="text-gray-600">Anda login sebagai Admin Kecamatan untuk {{ auth()->user()->kecamatan->nama_kecamatan ?? 'Kecamatan Tidak Diketahui' }}.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card: Data Balita Menunggu Verifikasi -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-md font-medium mb-2">Data Balita Menunggu Verifikasi</h4>
                <p class="text-2xl font-bold">{{ \App\Models\PendingBalita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status', 'pending')->count() }}</p>
                <a href="{{ route('kecamatan.balita.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat Data</a>
            </div>

            <!-- Card: Statistik Status Gizi -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-md font-medium mb-2">Statistik Status Gizi</h4>
                <ul class="text-gray-600">
                    <li>Sehat: {{ \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Sehat')->count() }}</li>
                    <li>Stunting: {{ \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Stunting')->count() }}</li>
                    <li>Kurang Gizi: {{ \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Kurang Gizi')->count() }}</li>
                    <li>Obesitas: {{ \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->where('status_gizi', 'Obesitas')->count() }}</li>
                </ul>
            </div>

            <!-- Card: Total Balita Terverifikasi -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-md font-medium mb-2">Total Balita Terverifikasi</h4>
                <p class="text-2xl font-bold">{{ \App\Models\Balita::where('kecamatan_id', auth()->user()->kecamatan_id)->count() }}</p>
            </div>
        </div>
    </div>
</body>
</html>