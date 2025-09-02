<!DOCTYPE html>
<html>
<head>
    <title>Data Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Monitoring</h2>
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('data_monitoring.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Monitoring</a>
            <form action="{{ route('data_monitoring.refresh') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Refresh Data Realtime</button>
            </form>
            <form action="{{ route('data_monitoring.index') }}" method="GET" class="flex space-x-2">
                <input type="text" name="kelurahan" placeholder="Cari Kelurahan" value="{{ $kelurahan }}" class="border-gray-300 rounded-md shadow-sm">
                <select name="kategori" class="border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriOptions as $option)
                        <option value="{{ $option }}" {{ $kategori == $option ? 'selected' : '' }}>{{ $option }}</option>
                    @endforeach
                </select>
                <select name="warna_badge" class="border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Warna Badge</option>
                    @foreach ($warnaBadgeOptions as $option)
                        <option value="{{ $option }}" {{ $warna_badge == $option ? 'selected' : '' }}>{{ $option }}</option>
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
                    <th class="p-4 text-left">Nama Ibu</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Nama Balita</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Warna Badge</th>
                    <th class="p-4 text-left">Statistik</th>
                    <th class="p-4 text-left">Tanggal Monitoring</th>
                    <th class="p-4 text-left">Urutan</th>
                    <th class="p-4 text-left">Status Aktif</th>
                    <th class="p-4 text-left">Tanggal Update</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataMonitorings as $index => $dataMonitoring)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $dataMonitorings->firstItem() + $index }}</td>
                        <td class="p-4">{{ $dataMonitoring->nama }}</td>
                        <td class="p-4">{{ $dataMonitoring->kelurahan }}</td>
                        <td class="p-4">{{ $dataMonitoring->kategori }}</td>
                        <td class="p-4">{{ $dataMonitoring->balita }}</td>
                        <td class="p-4">{{ $dataMonitoring->status }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded {{ $dataMonitoring->warna_badge == 'Hijau' ? 'bg-green-500 text-white' : ($dataMonitoring->warna_badge == 'Kuning' ? 'bg-yellow-500 text-white' : ($dataMonitoring->warna_badge == 'Merah' ? 'bg-red-500 text-white' : 'bg-blue-500 text-white')) }}">
                                {{ $dataMonitoring->warna_badge }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if (isset($dataRiset[$dataMonitoring->kategori]))
                                {{ $dataRiset[$dataMonitoring->kategori] }} (Realtime)
                            @else
                                Manual
                            @endif
                        </td>
                        <td class="p-4">{{ $dataMonitoring->tanggal_monitoring->format('d/m/Y') }}</td>
                        <td class="p-4">{{ $dataMonitoring->urutan }}</td>
                        <td class="p-4">{{ $dataMonitoring->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
                        <td class="p-4">{{ $dataMonitoring->tanggal_update->format('d/m/Y H:i') }}</td>
                        <td class="p-4">
                            <a href="{{ route('data_monitoring.edit', $dataMonitoring->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('data_monitoring.destroy', $dataMonitoring->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data monitoring ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $dataMonitorings->appends(['kelurahan' => $kelurahan, 'kategori' => $kategori, 'warna_badge' => $warna_badge])->links() }}
        </div>
    </div>
</body>
</html>