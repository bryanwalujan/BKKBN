<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu Hamil - Admin Kecamatan</title>
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
        <h2 class="text-2xl font-semibold mb-4">Data Ibu Hamil - Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan }}</h2>
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
            <a href="{{ route('kecamatan.ibu_hamil.index', ['tab' => 'pending', 'search' => $search, 'category' => $category]) }}"
               class="tab {{ $tab === 'pending' ? 'active' : '' }}">Pending Verifikasi</a>
            <a href="{{ route('kecamatan.ibu_hamil.index', ['tab' => 'verified', 'search' => $search, 'category' => $category]) }}"
               class="tab {{ $tab === 'verified' ? 'active' : '' }}">Terverifikasi</a>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('kecamatan.ibu_hamil.index') }}" class="mb-4 flex space-x-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama atau NIK" class="border p-2 rounded w-1/3">
            <select name="category" class="border p-2 rounded">
                <option value="">Semua Trimester</option>
                <option value="Trimester 1" {{ $category === 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                <option value="Trimester 2" {{ $category === 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                <option value="Trimester 3" {{ $category === 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
        </form>

        <!-- Table -->
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">NIK</th>
                    <th class="p-4 text-left">No KK</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Trimester</th>
                    <th class="p-4 text-left">Status Gizi</th>
                    <th class="p-4 text-left">Usia Kehamilan</th>
                    <th class="p-4 text-left">Berat/Tinggi</th>
                    @if ($tab === 'pending')
                        <th class="p-4 text-left">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($ibuHamils as $ibuHamil)
                    <tr>
                        <td class="p-4">{{ $ibuHamil->pendingIbu->nama ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $ibuHamil->pendingIbu->nik ?? 'Tidak ada' }}</td>
                        <td class="p-4">{{ $ibuHamil->pendingIbu->kartuKeluarga->no_kk ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $ibuHamil->pendingIbu->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $ibuHamil->trimester }}</td>
                        <td class="p-4">{{ $ibuHamil->status_gizi }} ({{ $ibuHamil->warna_status_gizi }})</td>
                        <td class="p-4">{{ $ibuHamil->usia_kehamilan }} minggu</td>
                        <td class="p-4">{{ $ibuHamil->berat }} kg / {{ $ibuHamil->tinggi }} cm</td>
                        @if ($tab === 'pending')
                            <td class="p-4">
                                <form action="{{ route('kecamatan.ibu_hamil.approve', $ibuHamil->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Setujui</button>
                                </form>
                                <form action="{{ route('kecamatan.ibu_hamil.reject', $ibuHamil->id) }}" method="POST" class="inline">
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
            {{ $ibuHamils->links() }}
        </div>
    </div>
</body>
</html>