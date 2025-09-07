<!DOCTYPE html>
<html>
<head>
    <title>Data Remaja Putri</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Remaja Putri</h2>
        <div class="mb-4 flex justify-between">
            <a href="{{ route('remaja_putri.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Remaja Putri</a>
            <form action="{{ route('remaja_putri.index') }}" method="GET" class="flex space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama remaja putri..." class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cari</button>
            </form>
        </div>
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
        <table class="w-full bg-white shadow-md rounded border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-4 text-left font-medium">No</th>
                    <th class="p-4 text-left font-medium">Foto</th>
                    <th class="p-4 text-left font-medium">Nama</th>
                    <th class="p-4 text-left font-medium">No KK</th>
                    <th class="p-4 text-left font-medium">Kecamatan</th>
                    <th class="p-4 text-left font-medium">Kelurahan</th>
                    <th class="p-4 text-left font-medium">Sekolah</th>
                    <th class="p-4 text-left font-medium">Kelas</th>
                    <th class="p-4 text-left font-medium">Umur</th>
                    <th class="p-4 text-left font-medium">Status Anemia</th>
                    <th class="p-4 text-left font-medium">Konsumsi TTD</th>
                    <th class="p-4 text-left font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($remajaPutris as $index => $remaja)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $remajaPutris->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($remaja->foto)
                                <img src="{{ Storage::url($remaja->foto) }}" alt="Foto Remaja Putri" class="w-16 h-16 object-cover rounded">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td class="p-4">{{ $remaja->nama }}</td>
                        <td class="p-4">{{ $remaja->kartuKeluarga->no_kk ?? '-' }}</td>
                        <td class="p-4">{{ $remaja->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $remaja->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $remaja->sekolah }}</td>
                        <td class="p-4">{{ $remaja->kelas }}</td>
                        <td class="p-4">{{ $remaja->umur }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white
                                {{ $remaja->status_anemia == 'Tidak Anemia' ? 'bg-green-500' : ($remaja->status_anemia == 'Anemia Ringan' ? 'bg-yellow-500' : ($remaja->status_anemia == 'Anemia Sedang' ? 'bg-orange-500' : 'bg-red-500')) }}">
                                {{ $remaja->status_anemia }}
                            </span>
                        </td>
                        <td class="p-4">{{ $remaja->konsumsi_ttd }}</td>
                        <td class="p-4 flex space-x-2">
                            <a href="{{ route('remaja_putri.edit', $remaja->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('remaja_putri.destroy', $remaja->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data remaja putri ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="p-4 text-center text-gray-500">Tidak ada data Remaja Putri ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $remajaPutris->links() }}
        </div>
    </div>
</body>
</html>