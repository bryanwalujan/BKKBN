<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kartu Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Kelola Kartu Keluarga</h2>
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
        <a href="{{ route('kartu_keluarga.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Kartu Keluarga</a>
        <table class="w-full bg-white shadow-md rounded border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-4 text-left font-medium">No</th>
                    <th class="p-4 text-left font-medium">No KK</th>
                    <th class="p-4 text-left font-medium">Kepala Keluarga</th>
                    <th class="p-4 text-left font-medium">Kecamatan</th>
                    <th class="p-4 text-left font-medium">Kelurahan</th>
                    <th class="p-4 text-left font-medium">Alamat</th>
                    <th class="p-4 text-left font-medium">Latitude</th>
                    <th class="p-4 text-left font-medium">Longitude</th>
                    <th class="p-4 text-left font-medium">Jumlah Balita</th>
                    <th class="p-4 text-left font-medium">Status</th>
                    <th class="p-4 text-left font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kartuKeluargas as $index => $kk)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $kartuKeluargas->firstItem() + $index }}</td>
                        <td class="p-4">{{ $kk->no_kk }}</td>
                        <td class="p-4">{{ $kk->kepala_keluarga }}</td>
                        <td class="p-4">{{ $kk->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $kk->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $kk->alamat ?? '-' }}</td>
                        <td class="p-4">{{ $kk->latitude ?? '-' }}</td>
                        <td class="p-4">{{ $kk->longitude ?? '-' }}</td>
                        <td class="p-4">{{ $kk->balitas_count }}</td>
                        <td class="p-4">{{ $kk->status }}</td>
                        <td class="p-4 flex space-x-2">
                            <a href="{{ route('kartu_keluarga.edit', $kk->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('kartu_keluarga.destroy', $kk->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus Kartu Keluarga ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="p-4 text-center text-gray-500">Tidak ada data Kartu Keluarga ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kartuKeluargas->links() }}
        </div>
    </div>
</body>
</html>