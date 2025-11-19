<!DOCTYPE html>
<html>
<head>
    <title>Galeri Program</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Galeri Program</h2>
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('galeri_program.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Program</a>
            <form action="{{ route('galeri_program.refresh') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Refresh Data Realtime</button>
            </form>
            <form action="{{ route('galeri_program.index') }}" method="GET" class="flex space-x-2">
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
                    <th class="p-4 text-left">Deskripsi</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Statistik</th>
                    <th class="p-4 text-left">Urutan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tanggal Update</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($galeriPrograms as $index => $program)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $galeriPrograms->firstItem() + $index }}</td>
                        <td class="p-4">
                            <img src="{{ asset('storage/' . $program->gambar) }}" alt="Gambar" class="w-8 h-8 object-cover rounded">
                        </td>
                        <td class="p-4">{{ $program->judul }}</td>
                        <td class="p-4">{{ Str::limit($program->deskripsi, 100) }}</td>
                        <td class="p-4">{{ $program->kategori }}</td>
                        <td class="p-4">
                            @if (isset($dataRiset[$program->judul]))
                                {{ $dataRiset[$program->judul] }} (Realtime)
                            @else
                                Manual
                            @endif
                        </td>
                        <td class="p-4">{{ $program->urutan }}</td>
                        <td class="p-4">{{ $program->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td class="p-4">{{ $program->tanggal_update->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('galeri_program.edit', $program->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('galeri_program.destroy', $program->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus program ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $galeriPrograms->appends(['kategori' => $kategori])->links() }}
        </div>
    </div>
</body>
</html>