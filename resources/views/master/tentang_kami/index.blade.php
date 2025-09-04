<!DOCTYPE html>
<html>
<head>
    <title>Tentang Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tentang Kami</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if ($tentangKami)
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold mb-2">{{ $tentangKami->judul_utama }}</h3>
                <p class="text-gray-600 mb-2">{{ $tentangKami->sub_judul }}</p>
                <p class="mb-4">{{ $tentangKami->paragraf_1 }}</p>
                @if ($tentangKami->paragraf_2)
                    <p class="mb-4">{{ $tentangKami->paragraf_2 }}</p>
                @endif
                @if ($tentangKami->teks_tombol && $tentangKami->link_tombol)
                    <a href="{{ $tentangKami->link_tombol }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ $tentangKami->teks_tombol }}</a>
                @endif
                <div class="mt-4">
                    <img src="{{ asset('storage/' . $tentangKami->gambar_utama) }}" alt="Gambar Utama" class="w-32 h-32 object-cover rounded">
                    @if ($tentangKami->gambar_overlay)
                        <img src="{{ asset('storage/' . $tentangKami->gambar_overlay) }}" alt="Gambar Overlay" class="w-32 h-32 object-cover rounded mt-2">
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-4">Terakhir diperbarui: {{ $tentangKami->tanggal_update->format('d/m/Y H:i') }}</p>
                <a href="{{ route('tentang_kami.edit') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit Tentang Kami</a>
            </div>
        @else
            <p class="text-gray-600 mb-4">Belum ada data Tentang Kami.</p>
            <a href="{{ route('tentang_kami.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Tentang Kami</a>
        @endif
    </div>
</body>
</html>