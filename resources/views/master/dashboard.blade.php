<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Master</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Selamat Datang, Master!</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-medium">Kelola Akun</h3>
                <p class="text-gray-600">Verifikasi atau kelola akun Admin Kelurahan dan Perangkat Desa.</p>
                <a href="{{ route('verifikasi.index') }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat Antrian</a>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-medium">Kelola Template</h3>
                <p class="text-gray-600">Upload atau hapus template surat pengajuan akun.</p>
                <a href="{{ route('templates.index') }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola Template</a>
            </div>
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-medium">Informasi Balita</h3>
                <p class="text-gray-600">Lihat dan kelola data balita (stunting/sehat).</p>
                <a href="{{ route('balita.index') }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kelola Data</a>
            </div>
        </div>
    </div>
</body>
</html>