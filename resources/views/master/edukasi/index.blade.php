<!DOCTYPE html>
<html>
<head>
    <title>Kelola Edukasi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Kelola Edukasi</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('edukasi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Edukasi</a>
                @csrf
               
            </form>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Judul</th>
                        <th class="py-2 px-4 border-b">Status Aktif</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($edukasis as $edukasi)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $edukasi->judul }}</td>
                            <td class="py-2 px-4 border-b">{{ $edukasi->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('edukasi.edit', $edukasi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('edukasi.destroy', $edukasi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
    </div>
</body>
</html>