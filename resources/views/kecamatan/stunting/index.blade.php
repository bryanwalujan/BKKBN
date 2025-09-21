<!DOCTYPE html>
<html>
<head>
    <title>Data Stunting - Admin Kecamatan</title>
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
        <h2 class="text-2xl font-semibold mb-4">Data Stunting - Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan }}</h2>
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
            <a href="{{ route('kecamatan.stunting.index', ['tab' => 'pending', 'search' => $search, 'kategori_umur' => $kategoriUmur]) }}"
               class="tab {{ $tab === 'pending' ? 'active' : '' }}">Pending Verifikasi</a>
            <a href="{{ route('kecamatan.stunting.index', ['tab' => 'verified', 'search' => $search, 'kategori_umur' => $kategoriUmur]) }}"
               class="tab {{ $tab === 'verified' ? 'active' : '' }}">Terverifikasi</a>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('kecamatan.stunting.index') }}" class="mb-4 flex space-x-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama atau NIK" class="border p-2 rounded w-1/3">
            <select name="kategori_umur" class="border p-2 rounded">
                <option value="">Semua Kategori Umur</option>
                <option value="Baduata" {{ $kategoriUmur === 'Baduata' ? 'selected' : '' }}>Baduata</option>
                <option value="Balita" {{ $kategoriUmur === 'Balita' ? 'selected' : '' }}>Balita</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
        </form>

        <!-- Table -->
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">NIK</th>
                    <th class="p-4 text-left">No KK</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Tanggal Lahir</th>
                    <th class="p-4 text-left">Kategori Umur</th>
                    <th class="p-4 text-left">Jenis Kelamin</th>
                    <th class="p-4 text-left">Berat/Tinggi</th>
                    <th class="p-4 text-left">Status Gizi</th>
                    <th class="p-4 text-left">Warna Gizi</th>
                    <th class="p-4 text-left">Tindak Lanjut</th>
                    <th class="p-4 text-left">Warna Tindak Lanjut</th>
                    <th class="p-4 text-left">Foto</th>
                    @if ($tab === 'pending')
                        <th class="p-4 text-left">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($stuntings as $stunting)
                    <tr>
                        <td class="p-4">{{ $stunting->nama ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $stunting->nik ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $stunting->kartuKeluarga->no_kk ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $stunting->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $stunting->tanggal_lahir ? \Carbon\Carbon::parse($stunting->tanggal_lahir)->format('d-m-Y') : 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $stunting->kategori_umur ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $stunting->jenis_kelamin }}</td>
                        <td class="p-4">{{ $stunting->berat_tinggi }}</td>
                        <td class="p-4">{{ $stunting->status_gizi }}</td>
                        <td class="p-4">{{ $stunting->warna_gizi }}</td>
                        <td class="p-4">{{ $stunting->tindak_lanjut ?? 'Tidak ada' }}</td>
                        <td class="p-4">{{ $stunting->warna_tindak_lanjut }}</td>
                        <td class="p-4">
                            @if ($stunting->foto)
                                <a href="{{ Storage::url($stunting->foto) }}" target="_blank">
                                    <img src="{{ Storage::url($stunting->foto) }}" alt="Foto" class="w-16 h-16 object-cover rounded">
                                </a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                        @if ($tab === 'pending')
                            <td class="p-4">
                                <form action="{{ route('kecamatan.stunting.approve', $stunting->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Setujui</button>
                                </form>
                                <form action="{{ route('kecamatan.stunting.reject', $stunting->id) }}" method="POST" class="inline">
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
            {{ $stuntings->links() }}
        </div>
    </div>
</body>
</html>