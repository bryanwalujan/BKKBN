<!DOCTYPE html>
<html>
<head>
    <title>Data Aksi Konvergensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Aksi Konvergensi</h2>
        <div class="mb-4">
            <a href="{{ route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'pending']) }}" class="inline-block px-4 py-2 {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Pending</a>
            <a href="{{ route('perangkat_daerah.aksi_konvergensi.index', ['tab' => 'verified']) }}" class="inline-block px-4 py-2 {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Terverifikasi</a>
        </div>
        <form method="GET" action="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="mb-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama aksi..." class="border-gray-300 rounded-md shadow-sm p-2">
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
        @if ($tab == 'pending')
            <a href="{{ route('perangkat_daerah.aksi_konvergensi.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Aksi Konvergensi</a>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">No KK</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Nama Aksi</th>
                    <th class="p-4 text-left">Selesai</th>
                    <th class="p-4 text-left">Tahun</th>
                    @if ($tab == 'pending')
                        <th class="p-4 text-left">Status</th>
                    @endif
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aksiKonvergensis as $index => $aksi)
                    <tr>
                        <td class="p-4">{{ $aksiKonvergensis->firstItem() + $index }}</td>
                        <td class="p-4">
                            <a href="{{ route('kartu_keluarga.show', $aksi->kartuKeluarga->id) }}" class="text-blue-500 hover:underline">
                                {{ $aksi->kartuKeluarga->no_kk ?? '-' }}
                            </a>
                        </td>
                        <td class="p-4">{{ $aksi->kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $aksi->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $aksi->nama_aksi }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white {{ $aksi->selesai ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                            </span>
                        </td>
                        <td class="p-4">{{ $aksi->tahun }}</td>
                        @if ($tab == 'pending')
                            <td class="p-4">{{ ucfirst($aksi->status) }}</td>
                        @endif
                        <td class="p-4">
                            @if ($tab == 'pending')
                                <a href="{{ route('perangkat_daerah.aksi_konvergensi.edit', [$aksi->id, 'pending']) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('perangkat_daerah.aksi_konvergensi.destroy', $aksi->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data Aksi Konvergensi ini?')">Hapus</button>
                                </form>
                            @else
                                <a href="{{ route('perangkat_daerah.aksi_konvergensi.edit', [$aksi->id, 'verified']) }}" class="text-blue-500 hover:underline">Edit</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $aksiKonvergensis->links() }}
        </div>
    </div>
</body>
</html>