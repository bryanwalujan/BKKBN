<!DOCTYPE html>
<html>
<head>
    <title>Data Pendamping Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Pendamping Keluarga</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('pendamping_keluarga.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Pendamping</a>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Peran</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tahun Bergabung</th>
                    <th class="p-4 text-left">Foto</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendampingKeluargas as $index => $pendamping)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-100' }}">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">{{ $pendamping->nama }}</td>
                        <td class="p-4">{{ $pendamping->peran }}</td>
                        <td class="p-4">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $pendamping->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $pendamping->status }}</td>
                        <td class="p-4">{{ $pendamping->tahun_bergabung }}</td>
                        <td class="p-4">
                            @if ($pendamping->foto)
                                <img src="{{ asset('storage/' . $pendamping->foto) }}" alt="Foto {{ $pendamping->nama }}" class="w-16 h-16 object-cover rounded">
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($pendamping->kartuKeluargas->isNotEmpty())
                                <a href="{{ route('kartu_keluarga.show', $pendamping->kartuKeluargas->first()->id) }}" class="text-green-500 hover:underline">Detail</a>
                            @else
                                <span class="text-gray-500">Tidak ada KK</span>
                            @endif
                            <a href="{{ route('pendamping_keluarga.edit', $pendamping->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('pendamping_keluarga.destroy', $pendamping->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data Pendamping Keluarga ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>