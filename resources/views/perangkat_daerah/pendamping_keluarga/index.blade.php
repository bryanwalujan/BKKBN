<!DOCTYPE html>
<html>
<head>
    <title>Data Pendamping Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Pendamping Keluarga</h2>
        <div class="mb-4">
            <a href="{{ route('perangkat_daerah.pendamping_keluarga.index', ['tab' => 'pending']) }}" class="inline-block px-4 py-2 {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Pending</a>
            <a href="{{ route('perangkat_daerah.pendamping_keluarga.index', ['tab' => 'verified']) }}" class="inline-block px-4 py-2 {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Terverifikasi</a>
        </div>
        <form method="GET" action="{{ route('perangkat_daerah.pendamping_keluarga.index') }}" class="mb-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama pendamping..." class="border-gray-300 rounded-md shadow-sm p-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
        </form>
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
        <a href="{{ route('perangkat_daerah.pendamping_keluarga.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Pendamping</a>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Peran</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tahun Bergabung</th>
                    <th class="p-4 text-left">Foto</th>
                    @if ($tab == 'pending')
                        <th class="p-4 text-left">Status Verifikasi</th>
                        <th class="p-4 text-left">Catatan</th>
                    @endif
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendampingKeluargas as $index => $pendamping)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-100' }}">
                        <td class="p-4">{{ $pendampingKeluargas->firstItem() + $index }}</td>
                        <td class="p-4">{{ $pendamping->nama }}</td>
                        <td class="p-4">{{ $pendamping->peran }}</td>
                        <td class="p-4">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $pendamping->status }}</td>
                        <td class="p-4">{{ $pendamping->tahun_bergabung }}</td>
                        <td class="p-4">
                            @if ($pendamping->foto)
                                <img src="{{ asset('storage/' . $pendamping->foto) }}" alt="Foto {{ $pendamping->nama }}" class="w-16 h-16 object-cover rounded">
                            @else
                                -
                            @endif
                        </td>
                        @if ($tab == 'pending')
                            <td class="p-4">{{ ucfirst($pendamping->status_verifikasi) }}</td>
                            <td class="p-4">{{ $pendamping->catatan ?? '-' }}</td>
                        @endif
                        <td class="p-4">
                            @if ($pendamping->kartuKeluargas->isNotEmpty())
                                <a href="{{ route('kartu_keluarga.show', $pendamping->kartuKeluargas->first()->id) }}" class="text-green-500 hover:underline">Detail KK</a>
                            @endif
                            @if ($tab == 'pending' && $pendamping->status_verifikasi == 'pending')
                                <a href="{{ route('perangkat_daerah.pendamping_keluarga.edit', [$pendamping->id, 'pending']) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('perangkat_daerah.pendamping_keluarga.destroy', $pendamping->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data Pendamping Keluarga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            @elseif ($tab == 'verified')
                                <a href="{{ route('perangkat_daerah.pendamping_keluarga.edit', [$pendamping->id, 'verified']) }}" class="text-blue-500 hover:underline">Edit</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $pendampingKeluargas->links() }}
        </div>
    </div>
</body>
</html>