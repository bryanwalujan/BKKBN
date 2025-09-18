<!DOCTYPE html>
<html>
<head>
    <title>Data Kartu Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kartu Keluarga</h2>
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
        <div class="mb-4 flex justify-between">
            <div>
                <a href="{{ route('kelurahan.kartu_keluarga.index', ['tab' => 'pending', 'search' => $search]) }}"
                   class="px-4 py-2 rounded {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Menunggu Verifikasi</a>
                <a href="{{ route('kelurahan.kartu_keluarga.index', ['tab' => 'verified', 'search' => $search]) }}"
                   class="px-4 py-2 rounded {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Terverifikasi</a>
            </div>
            @if ($tab == 'pending')
                <a href="{{ route('kelurahan.kartu_keluarga.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Kartu Keluarga</a>
            @endif
        </div>
        <div class="mb-4">
            <form method="GET" action="{{ route('kelurahan.kartu_keluarga.index') }}" class="flex space-x-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nomor KK atau kepala keluarga" class="border p-2 rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cari</button>
            </form>
        </div>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Nomor KK</th>
                    <th class="p-4 text-left">Kepala Keluarga</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Alamat</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Diupload Oleh</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kartuKeluargas as $kk)
                    <tr>
                        <td class="p-4">{{ $kk->no_kk }}</td>
                        <td class="p-4">{{ $kk->kepala_keluarga }}</td>
                        <td class="p-4">{{ $kk->kecamatan->nama_kecamatan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $kk->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $kk->alamat ?? 'Tidak ada' }}</td>
                        <td class="p-4">{{ $kk->source == 'verified' ? $kk->status : $kk->status_verifikasi }}</td>
                        <td class="p-4">{{ $kk->createdBy->name ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">
                            @if ($kk->source == 'pending')
                                <a href="{{ route('kelurahan.kartu_keluarga.edit', ['id' => $kk->id, 'source' => 'pending']) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                                <form action="{{ route('kelurahan.kartu_keluarga.destroy', $kk->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            @else
                                <a href="{{ route('kelurahan.kartu_keluarga.edit', ['id' => $kk->id, 'source' => 'verified']) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kartuKeluargas->links() }}
        </div>
    </div>
</body>
</html>