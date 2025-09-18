<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Data Balita</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kecamatan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Verifikasi Data Balita</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">NIK</th>
                    <th class="p-4 text-left">Usia</th>
                    <th class="p-4 text-left">Jenis Kelamin</th>
                    <th class="p-4 text-left">Status Gizi</th>
                    <th class="p-4 text-left">Warna Label</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Foto</th>
                    <th class="p-4 text-left">Diupload Oleh</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($balitas as $balita)
                    <tr>
                        <td class="p-4">{{ $balita->nama }}</td>
                        <td class="p-4">{{ $balita->nik ?? 'Tidak ada' }}</td>
                        <td class="p-4">{{ $balita->usia }} bulan ({{ $balita->kategoriUmur }})</td>
                        <td class="p-4">{{ $balita->jenis_kelamin }}</td>
                        <td class="p-4">{{ $balita->status_gizi }}</td>
                        <td class="p-4">{{ $balita->warna_label }}</td>
                        <td class="p-4">{{ $balita->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">
                            @if ($balita->foto)
                                <a href="{{ Storage::url($balita->foto) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td class="p-4">{{ $balita->createdBy->name ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">
                            <form action="{{ route('kecamatan.balita.approve', $balita->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Setujui</button>
                            </form>
                            <form action="{{ route('kecamatan.balita.reject', $balita->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="text" name="catatan" placeholder="Alasan penolakan" class="border p-1 rounded" required>
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $balitas->links() }}
        </div>
    </div>
</body>
</html>