<!DOCTYPE html>
<html>
<head>
    <title>Publikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Publikasi</h2>
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('publikasi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Publikasi</a>
            <form action="{{ route('publikasi.refresh') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Refresh Data Realtime</button>
            </form>
            <form action="{{ route('publikasi.index') }}" method="GET" class="flex space-x-2">
                <select name="kategori" class="border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriOptions as $option)
                        <option value="{{ $option }}" {{ $kategori == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Tampilkan</button>
            </form>
        </div>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Gambar</th>
                    <th class="p-4 text-left">Judul</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Deskripsi</th>
                    <th class="p-4 text-left">Statistik</th>
                    <th class="p-4 text-left">Teks Tombol</th>
                    <th class="p-4 text-left">Urutan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tanggal Update</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($publikasis as $index => $publikasi)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $publikasis->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($publikasi->gambar)
                                <img src="{{ asset('storage/' . $publikasi->gambar) }}" alt="Gambar" class="w-8 h-8 object-cover rounded">
                            @else
                                Tidak ada gambar
                            @endif
                        </td>
                        <td class="p-4">{{ $publikasi->judul }}</td>
                        <td class="p-4">{{ $publikasi->kategori }}</td>
                        <td class="p-4">{{ Str::limit($publikasi->deskripsi, 100) }}</td>
                        <td class="p-4">
                            @if (isset($dataRiset[$publikasi->judul]))
                                {{ $dataRiset[$publikasi->judul] }} (Realtime)
                            @else
                                Manual
                            @endif
                        </td>
                        <td class="p-4">{{ $publikasi->teks_tombol }}</td>
                        <td class="p-4">{{ $publikasi->urutan }}</td>
                        <td class="p-4">{{ $publikasi->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td class="p-4">{{ $publikasi->tanggal_update->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('publikasi.edit', $publikasi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('publikasi.destroy', $publikasi->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus publikasi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $publikasis->appends(['kategori' => $kategori])->links() }}
        </div>
    </div>
</body>
</html>