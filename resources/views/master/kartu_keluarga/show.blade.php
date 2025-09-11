<!DOCTYPE html>
<html>
<head>
    <title>Detail Kartu Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Detail Kartu Keluarga</h2>
        <a href="{{ route('kartu_keluarga.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>

        <!-- Informasi Kartu Keluarga -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Informasi Kartu Keluarga</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="p-2 font-medium">No KK</td>
                    <td class="p-2">{{ $kartuKeluarga->no_kk }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Kepala Keluarga</td>
                    <td class="p-2">{{ $kartuKeluarga->kepala_keluarga }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Kecamatan</td>
                    <td class="p-2">{{ $kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Kelurahan</td>
                    <td class="p-2">{{ $kartuKeluarga->kelurahan->nama_kelurahan ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Alamat</td>
                    <td class="p-2">{{ $kartuKeluarga->alamat ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Latitude</td>
                    <td class="p-2">{{ $kartuKeluarga->latitude ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Longitude</td>
                    <td class="p-2">{{ $kartuKeluarga->longitude ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Status</td>
                    <td class="p-2">{{ $kartuKeluarga->status }}</td>
                </tr>
            </table>
        </div>

        <!-- Daftar Ibu -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Ibu</h3>
            @if ($kartuKeluarga->ibu->isEmpty())
                <p class="text-gray-500">Tidak ada data ibu terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama</th>
                            <th class="p-4 text-left font-medium">NIK</th>
                            <th class="p-4 text-left font-medium">Status</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->ibu as $index => $ibu)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $ibu->nama }}</td>
                                <td class="p-4">{{ $ibu->nik ?? '-' }}</td>
                                <td class="p-4">{{ $ibu->status }}</td>
                                <td class="p-4">
                                    <a href="{{ route('ibu.edit', $ibu->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Daftar Balita -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Balita</h3>
            @if ($kartuKeluarga->balitas->isEmpty())
                <p class="text-gray-500">Tidak ada data balita terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama</th>
                            <th class="p-4 text-left font-medium">Jenis Kelamin</th>
                            <th class="p-4 text-left font-medium">Tanggal Lahir</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->balitas as $index => $balita)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $balita->nama }}</td>
                                <td class="p-4">{{ $balita->jenis_kelamin }}</td>
                                <td class="p-4">{{ $balita->tanggal_lahir }}</td>
                                <td class="p-4">
                                    <a href="{{ route('balita.edit', $balita->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Daftar Remaja Putri -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Remaja Putri</h3>
            @if ($kartuKeluarga->remajaPutris->isEmpty())
                <p class="text-gray-500">Tidak ada data remaja putri terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama</th>
                            <th class="p-4 text-left font-medium">NIK</th>
                            <th class="p-4 text-left font-medium">Tanggal Lahir</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->remajaPutris as $index => $remaja)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $remaja->nama }}</td>
                                <td class="p-4">{{ $remaja->nik ?? '-' }}</td>
                                <td class="p-4">{{ $remaja->tanggal_lahir }}</td>
                                <td class="p-4">
                                    <a href="{{ route('remaja_putri.edit', $remaja->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>