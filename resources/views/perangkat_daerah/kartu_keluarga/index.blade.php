<!DOCTYPE html>
<html>
<head>
    <title>Data Kartu Keluarga</title>
    <link rel="icon" sizes="50x50" type="image/png" href="{{ asset('storage/images/logo1.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kartu Keluarga</h2>
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
        <div class="mb-4 flex space-x-4">
            <form action="{{ route('perangkat_daerah.kartu_keluarga.index') }}" method="GET" class="flex space-x-2">
                <div class="w-1/2">
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
                </div>
                <div class="w-1/2">
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan No KK atau Kepala Keluarga" class="border-gray-300 rounded-md shadow-sm p-2 w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                @if ($kelurahan_id || $search)
                    <a href="{{ route('perangkat_daerah.kartu_keluarga.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
        </div>
        @if ($kelurahan_id || $search)
            <p class="mt-2 text-sm text-gray-600">
                Menampilkan data
                @if ($kelurahan_id)
                    untuk kelurahan: {{ \App\Models\Kelurahan::find($kelurahan_id)->nama_kelurahan ?? '-' }}
                @endif
                @if ($search)
                    dengan pencarian: "{{ $search }}"
                @endif
                ({{ $kartuKeluargas->total() }} data)
            </p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data kartu keluarga di kecamatan {{ $kecamatan->nama_kecamatan ?? '-' }} ({{ $kartuKeluargas->total() }} data)</p>
        @endif
        <div class="bg-white p-6 rounded shadow">
            <table class="w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">No KK</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Kepala Keluarga</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Kecamatan</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Kelurahan</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Balita</th>
                        <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($kartuKeluargas as $index => $kartuKeluarga)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="p-4">{{ $kartuKeluargas->firstItem() + $index }}</td>
                            <td class="p-4">
                                <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-500 hover:underline">{{ $kartuKeluarga->no_kk }}</a>
                            </td>
                            <td class="p-4">
                                <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-500 hover:underline">{{ $kartuKeluarga->kepala_keluarga }}</a>
                            </td>
                            <td class="p-4">{{ $kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="p-4">{{ $kartuKeluarga->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="p-4">{{ $kartuKeluarga->alamat ?? '-' }}</td>
                            <td class="p-4">{{ $kartuKeluarga->status }}</td>
                            <td class="p-4">{{ $kartuKeluarga->balitas_count }}</td>
                            <td class="p-4">
                                <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-500 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center">Tidak ada data kartu keluarga yang sesuai dengan filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $kartuKeluargas->links() }}
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kelurahan_id').select2({
                placeholder: 'Semua Kelurahan',
                allowClear: true
            });
        });
    </script>
</body>
</html>