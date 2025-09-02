<!DOCTYPE html>
<html>
<head>
    <title>Data Aksi Konvergensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Aksi Konvergensi</h2>
        <a href="{{ route('aksi_konvergensi.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Aksi Konvergensi</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Foto</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Nama Aksi</th>
                    <th class="p-4 text-left">Selesai</th>
                    <th class="p-4 text-left">Tahun</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aksiKonvergensis as $index => $aksi)
                    <tr>
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">
                            @if ($aksi->foto)
                                <img src="{{ Storage::url($aksi->foto) }}" alt="Foto Aksi Konvergensi" class="w-16 h-16 object-cover rounded">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td class="p-4">{{ $aksi->kecamatan }}</td>
                        <td class="p-4">{{ $aksi->kelurahan }}</td>
                        <td class="p-4">{{ $aksi->nama_aksi }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white {{ $aksi->selesai ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                            </span>
                        </td>
                        <td class="p-4">{{ $aksi->tahun }}</td>
                        <td class="p-4">
                            <a href="{{ route('aksi_konvergensi.edit', $aksi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('aksi_konvergensi.destroy', $aksi->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data Aksi Konvergensi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>