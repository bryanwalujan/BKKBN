<!DOCTYPE html>
<html>
<head>
    <title>Referensi</title>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Referensi</h2>
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('referensi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Referensi</a>
            <form action="{{ route('referensi.refresh') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Refresh Data Realtime</button>
            </form>
            <form action="{{ route('referensi.index') }}" method="GET" class="flex space-x-2">
                <select name="warna_icon" class="border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Warna Ikon</option>
                    @foreach ($warnaIconOptions as $option)
                        <option value="{{ $option }}" {{ $warna_icon == $option ? 'selected' : '' }}>{{ $option }}</option>
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
                    <th class="p-4 text-left">Ikon</th>
                    <th class="p-4 text-left">Judul</th>
                    <th class="p-4 text-left">Deskripsi</th>
                    <th class="p-4 text-left">PDF</th>
                    <th class="p-4 text-left">Warna Ikon</th>
                    <th class="p-4 text-left">Statistik</th>
                    <th class="p-4 text-left">Teks Tombol</th>
                    <th class="p-4 text-left">Urutan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tanggal Update</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($referensis as $index => $referensi)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $referensis->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($referensi->icon)
                                <img src="{{ asset('storage/' . $referensi->icon) }}" alt="Ikon" class="w-8 h-8 object-cover rounded {{ $referensi->warna_icon == 'Biru' ? 'text-blue-500' : ($referensi->warna_icon == 'Merah' ? 'text-red-500' : ($referensi->warna_icon == 'Hijau' ? 'text-green-500' : 'text-yellow-500')) }}">
                            @else
                                Tidak ada ikon
                            @endif
                        </td>
                        <td class="p-4">{{ $referensi->judul }}</td>
                        <td class="p-4">{{ Str::limit($referensi->deskripsi, 100) }}</td>
                        <td class="p-4">
                            @if ($referensi->pdf)
                                <a href="{{ asset('storage/' . $referensi->pdf) }}" target="_blank" class="text-blue-500 hover:underline">Lihat PDF</a>
                            @else
                                Tidak ada PDF
                            @endif
                        </td>
                        <td class="p-4">{{ $referensi->warna_icon }}</td>
                        <td class="p-4">
                            @if (isset($dataRiset[$referensi->judul]))
                                {{ $dataRiset[$referensi->judul] }} (Realtime)
                            @else
                                Manual
                            @endif
                        </td>
                        <td class="p-4">{{ $referensi->teks_tombol }}</td>
                        <td class="p-4">{{ $referensi->urutan }}</td>
                        <td class="p-4">{{ $referensi->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td class="p-4">{{ $referensi->tanggal_update->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('referensi.edit', $referensi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('referensi.destroy', $referensi->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus referensi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $referensis->appends(['warna_icon' => $warna_icon])->links() }}
        </div>
    </div>
</body>
</html>