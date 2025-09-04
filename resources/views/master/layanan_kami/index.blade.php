<!DOCTYPE html>
<html>
<head>
    <title>Layanan Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Layanan Kami</h2>
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('layanan_kami.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Layanan Kami</a>
            <form action="{{ route('layanan_kami.refresh') }}" method="POST">
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
                    <th class="p-4 text-left">Ikon</th>
                    <th class="p-4 text-left">Judul Layanan</th>
                    <th class="p-4 text-left">Deskripsi Singkat</th>
                    <th class="p-4 text-left">Statistik</th>
                    <th class="p-4 text-left">Urutan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tanggal Update</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layananKamis as $index => $layanan)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">
                            <img src="{{ asset('storage/' . $layanan->ikon) }}" alt="Ikon" class="w-6 h-6 object-cover rounded">
                        </td>
                        <td class="p-4">{{ $layanan->judul_layanan }}</td>
                        <td class="p-4">{{ Str::limit($layanan->deskripsi_singkat, 100) }}</td>
                        <td class="p-4">
                            @if (isset($dataRiset[$layanan->judul_layanan]))
                                {{ $dataRiset[$layanan->judul_layanan] }} (Realtime)
                            @else
                                Manual
                            @endif
                        </td>
                        <td class="p-4">{{ $layanan->urutan }}</td>
                        <td class="p-4">{{ $layanan->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td class="p-4">{{ $layanan->tanggal_update->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('layanan_kami.edit', $layanan->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('layanan_kami.destroy', $layanan->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus layanan ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>