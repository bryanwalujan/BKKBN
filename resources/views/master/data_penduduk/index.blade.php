<!DOCTYPE html>
<html>
<head>
    <title>Data Penduduk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Penduduk</h2>
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('data_penduduk.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Penduduk</a>
            <form action="{{ route('data_penduduk.refresh') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Refresh Data Realtime</button>
            </form>
            <form action="{{ route('data_penduduk.index') }}" method="GET" class="flex space-x-2">
                <input type="text" name="tahun" placeholder="Cari Tahun" value="{{ $tahun }}" class="border-gray-300 rounded-md shadow-sm">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Tampilkan</button>
            </form>
        </div>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-8">
            <canvas id="pendudukChart" height="100"></canvas>
        </div>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Tahun</th>
                    <th class="p-4 text-left">Jumlah Penduduk</th>
                    <th class="p-4 text-left">Statistik</th>
                    <th class="p-4 text-left">Urutan</th>
                    <th class="p-4 text-left">Status Aktif</th>
                    <th class="p-4 text-left">Tanggal Update</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPenduduks as $index => $dataPenduduk)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $dataPenduduks->firstItem() + $index }}</td>
                        <td class="p-4">{{ $dataPenduduk->tahun }}</td>
                        <td class="p-4">{{ $dataPenduduk->jumlah_penduduk }}</td>
                        <td class="p-4">
                            @if (isset($dataRiset['Jumlah Penduduk']) && $dataRiset['Jumlah Penduduk'] == $dataPenduduk->jumlah_penduduk)
                                {{ $dataRiset['Jumlah Penduduk'] }} (Realtime)
                            @else
                                Manual
                            @endif
                        </td>
                        <td class="p-4">{{ $dataPenduduk->urutan }}</td>
                        <td class="p-4">{{ $dataPenduduk->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td class="p-4">{{ $dataPenduduk->tanggal_update->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('data_penduduk.edit', $dataPenduduk->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('data_penduduk.destroy', $dataPenduduk->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data penduduk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $dataPenduduks->appends(['tahun' => $tahun])->links() }}
        </div>
    </div>
    <script>
        const ctx = document.getElementById('pendudukChart').getContext('2d');
        const chartData = @json($chartData);
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(data => data.tahun),
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: chartData.map(data => data.jumlah_penduduk),
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Tahun' } },
                    y: { title: { display: true, text: 'Jumlah Penduduk' }, beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>