<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-4 flex items-center justify-between">
            <form action="{{ route('ibu.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama atau NIK" class="border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
            </form>
            <a href="{{ route('ibu.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Ibu</a>
        </div>
        <table class="w-full bg-white shadow-md rounded border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-4 text-left font-medium">No</th>
                    <th class="p-4 text-left font-medium">Foto</th>
                    <th class="p-4 text-left font-medium">NIK</th>
                    <th class="p-4 text-left font-medium">Nama</th>
                    <th class="p-4 text-left font-medium">Kecamatan</th>
                    <th class="p-4 text-left font-medium">Kelurahan</th>
                    <th class="p-4 text-left font-medium">Kartu Keluarga</th>
                    <th class="p-4 text-left font-medium">Alamat</th>
                    <th class="p-4 text-left font-medium">Status</th>
                    <th class="p-4 text-left font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ibus as $index => $ibu)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $ibus->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($ibu->foto)
                                <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-500">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="p-4">{{ $ibu->nik ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->nama }}</td>
                        <td class="p-4">{{ $ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->kartuKeluarga->no_kk . ' - ' . $ibu->kartuKeluarga->kepala_keluarga ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->alamat ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->status }}</td>
                        <td class="p-4 flex space-x-2">
                            <a href="{{ route('ibu.edit', $ibu->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('ibu.destroy', $ibu->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data ibu ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-4 text-center text-gray-500">Tidak ada data ibu ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $ibus->links() }}
        </div>
    </div>
</body>
</html>