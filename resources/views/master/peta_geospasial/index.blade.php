<!DOCTYPE html>
<html>
<head>
    <title>Data Peta Geospasial</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Peta Geospasial</h2>
        <a href="{{ route('peta_geospasial.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Lokasi</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama Lokasi</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Latitude</th>
                    <th class="p-4 text-left">Longitude</th>
                    <th class="p-4 text-left">Jenis</th>
                    <th class="p-4 text-left">Warna Marker</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($petaGeospasials as $index => $peta)
                    <tr>
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">{{ $peta->nama_lokasi }}</td>
                        <td class="p-4">{{ $peta->kecamatan }}</td>
                        <td class="p-4">{{ $peta->kelurahan }}</td>
                        <td class="p-4">{{ $peta->status }}</td>
                        <td class="p-4">{{ $peta->latitude }}</td>
                        <td class="p-4">{{ $peta->longitude }}</td>
                        <td class="p-4">{{ $peta->jenis ?? '-' }}</td>
                        <td class="p-4">
                            <span class="inline-block w-4 h-4 rounded-full" style="background-color: {{ $peta->warna_marker == 'Merah' ? 'red' : ($peta->warna_marker == 'Biru' ? 'blue' : 'green') }}"></span>
                            {{ $peta->warna_marker }}
                        </td>
                        <td class="p-4">
                            <a href="{{ route('peta_geospasial.edit', $peta->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('peta_geospasial.destroy', $peta->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data Peta Geospasial ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>