<!DOCTYPE html>
<html>
<head>
    <title>Data Riset</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Riset</h2>
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('data_riset.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Riset</a>
            <form action="{{ route('data_riset.refresh') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Refresh Data Realtime</button>
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
                    <th class="p-4 text-left">Judul</th>
                    <th class="p-4 text-left">Angka</th>
                    <th class="p-4 text-left">Sumber</th>
                    <th class="p-4 text-left">Tanggal Update</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataRisets as $index => $dataRiset)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">{{ $dataRiset->judul }}</td>
                        <td class="p-4">{{ $dataRiset->angka }}</td>
                        <td class="p-4">{{ $dataRiset->is_realtime ? 'Realtime' : 'Manual' }}</td>
                        <td class="p-4">{{ $dataRiset->tanggal_update->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('data_riset.edit', $dataRiset->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('data_riset.destroy', $dataRiset->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data riset ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>