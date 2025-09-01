<!DOCTYPE html>
<html>
<head>
    <title>Informasi Balita</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Informasi Balita</h2>
        <a href="{{ route('balita.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Balita</a>
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
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Tanggal Lahir</th>
                    <th class="p-4 text-left">Jenis Kelamin</th>
                    <th class="p-4 text-left">Berat/Tinggi</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Status Gizi</th>
                    <th class="p-4 text-left">Warna Label</th>
                    <th class="p-4 text-left">Status Pemantauan</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($balitas as $index => $balita)
                    <tr>
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">
                            @if ($balita->foto)
                                <img src="{{ Storage::url($balita->foto) }}" alt="Foto Balita" class="w-16 h-16 object-cover rounded">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td class="p-4">{{ $balita->nama }}</td>
                        <td class="p-4">
                            @if ($balita->tanggal_lahir)
                                {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('m/d/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">{{ $balita->jenis_kelamin }}</td>
                        <td class="p-4">{{ $balita->berat_tinggi }}</td>
                        <td class="p-4">{{ $balita->kelurahan }}</td>
                        <td class="p-4">{{ $balita->kecamatan }}</td>
                        <td class="p-4">{{ $balita->status_gizi }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white
                                {{ $balita->warna_label == 'Sehat' ? 'bg-green-500' : ($balita->warna_label == 'Waspada' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ $balita->warna_label }}
                            </span>
                        </td>
                        <td class="p-4">{{ $balita->status_pemantauan ?? '-' }}</td>
                        <td class="p-4">
                            <a href="{{ route('balita.edit', $balita->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('balita.destroy', $balita->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data balita ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>