<!DOCTYPE html>
<html>
<head>
    <title>Data Kegiatan Genting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kegiatan Genting</h2>
        <a href="{{ route('genting.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Kegiatan Genting</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Dokumentasi</th>
                    <th class="p-4 text-left">Nama Kegiatan</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-left">Lokasi</th>
                    <th class="p-4 text-left">Sasaran</th>
                    <th class="p-4 text-left">Jenis Intervensi</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gentings as $index => $genting)
                    <tr>
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">
                            @if ($genting->dokumentasi)
                                <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi Kegiatan" class="w-16 h-16 object-cover rounded">
                            @else
                                Tidak ada dokumentasi
                            @endif
                        </td>
                        <td class="p-4">{{ $genting->nama_kegiatan }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($genting->tanggal)->format('m/d/Y') }}</td>
                        <td class="p-4">{{ $genting->lokasi }}</td>
                        <td class="p-4">{{ $genting->sasaran }}</td>
                        <td class="p-4">{{ $genting->jenis_intervensi }}</td>
                        <td class="p-4">
                            <a href="{{ route('genting.edit', $genting->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('genting.destroy', $genting->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data kegiatan Genting ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>