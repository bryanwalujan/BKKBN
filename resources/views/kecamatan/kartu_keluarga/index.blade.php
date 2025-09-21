<!DOCTYPE html>
<html>
<head>
    <title>Data Kartu Keluarga - Admin Kecamatan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .tabs { display: flex; border-bottom: 1px solid #e5e7eb; margin-bottom: 20px; }
        .tab { padding: 10px 20px; cursor: pointer; font-weight: bold; color: #4b5563; }
        .tab.active { color: #15803d; border-bottom: 2px solid #15803d; }
    </style>
</head>
<body class="bg-gray-100">
    @include('kecamatan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kartu Keluarga - Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan }}</h2>
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

        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('kecamatan.kartu_keluarga.index', ['tab' => 'pending', 'search' => $search]) }}"
               class="tab {{ $tab === 'pending' ? 'active' : '' }}">Pending Verifikasi</a>
            <a href="{{ route('kecamatan.kartu_keluarga.index', ['tab' => 'verified', 'search' => $search]) }}"
               class="tab {{ $tab === 'verified' ? 'active' : '' }}">Terverifikasi</a>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('kecamatan.kartu_keluarga.index') }}" class="mb-4 flex space-x-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari No KK atau Kepala Keluarga" class="border p-2 rounded w-1/3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
        </form>

        <!-- Table -->
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No KK</th>
                    <th class="p-4 text-left">Kepala Keluarga</th>
                    <th class="p-4 text-left">Alamat</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Koordinat</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Diupload Oleh</th>
                    @if ($tab === 'pending')
                        <th class="p-4 text-left">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($kartuKeluargas as $kk)
                    <tr>
                        <td class="p-4">{{ $kk->no_kk }}</td>
                        <td class="p-4">{{ $kk->kepala_keluarga }}</td>
                        <td class="p-4">{{ $kk->alamat ?? 'Tidak ada' }}</td>
                        <td class="p-4">{{ $kk->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $kk->latitude ? ($kk->latitude . ', ' . $kk->longitude) : 'Tidak ada' }}</td>
                        <td class="p-4">{{ $kk->status }}</td>
                        <td class="p-4">{{ $kk->createdBy->name ?? 'Tidak diketahui' }}</td>
                        @if ($tab === 'pending')
                            <td class="p-4">
                                <form action="{{ route('kecamatan.kartu_keluarga.approve', $kk->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Setujui</button>
                                </form>
                                <form action="{{ route('kecamatan.kartu_keluarga.reject', $kk->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="text" name="catatan" placeholder="Alasan penolakan" class="border p-1 rounded w-40" required>
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Tolak</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kartuKeluargas->links() }}
        </div>
    </div>
</body>
</html>