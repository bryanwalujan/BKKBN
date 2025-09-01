<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu Nifas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu Nifas</h2>
        <a href="{{ route('ibu_nifas.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Ibu Nifas</a>
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
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Hari ke-Nifas</th>
                    <th class="p-4 text-left">Kondisi Kesehatan</th>
                    <th class="p-4 text-left">Warna Kondisi</th>
                    <th class="p-4 text-left">Berat (kg)</th>
                    <th class="p-4 text-left">Tinggi (cm)</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ibuNifas as $index => $ibu)
                    <tr>
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">
                            @if ($ibu->foto)
                                <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu Nifas" class="w-16 h-16 object-cover rounded">
                            @else
                                Tidak ada foto
                            @endif
                        </td>
                        <td class="p-4">{{ $ibu->nama }}</td>
                        <td class="p-4">{{ $ibu->kelurahan }}</td>
                        <td class="p-4">{{ $ibu->kecamatan }}</td>
                        <td class="p-4">{{ $ibu->hari_nifas }}</td>
                        <td class="p-4">{{ $ibu->kondisi_kesehatan }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white
                                {{ $ibu->warna_kondisi == 'Hijau (success)' ? 'bg-green-500' : ($ibu->warna_kondisi == 'Kuning (warning)' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ $ibu->warna_kondisi }}
                            </span>
                        </td>
                        <td class="p-4">{{ $ibu->berat }}</td>
                        <td class="p-4">{{ $ibu->tinggi }}</td>
                        <td class="p-4">
                            <a href="{{ route('ibu_nifas.edit', $ibu->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('ibu_nifas.destroy', $ibu->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data ibu nifas ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>