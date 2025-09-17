<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu Nifas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu Nifas</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-4 flex justify-between items-center">
            <div>
                <a href="{{ route('kelurahan.ibu_nifas.index', ['tab' => 'pending']) }}" class="px-4 py-2 {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Pending</a>
                <a href="{{ route('kelurahan.ibu_nifas.index', ['tab' => 'verified']) }}" class="px-4 py-2 {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Terverifikasi</a>
            </div>
            <div class="flex items-center space-x-4">
                <form action="{{ route('kelurahan.ibu_nifas.index') }}" method="GET" class="flex space-x-2">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK" class="border-gray-300 rounded-md px-4 py-2">
                    <select name="category" class="border-gray-300 rounded-md px-4 py-2">
                        <option value="">Semua Kondisi Kesehatan</option>
                        <option value="Normal" {{ $category == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Butuh Perhatian" {{ $category == 'Butuh Perhatian' ? 'selected' : '' }}>Butuh Perhatian</option>
                        <option value="Kritis" {{ $category == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                </form>
                @if ($tab == 'pending')
                    <a href="{{ route('kelurahan.ibu_nifas.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Data</a>
                @endif
            </div>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hari ke-Nifas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kondisi Kesehatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Warna Kondisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berat (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tinggi (cm)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($ibuNifas as $index => $ibu)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->pendingIbu->nama ?? $ibu->ibu->nama ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->pendingIbu->nik ?? $ibu->ibu->nik ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->hari_nifas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->kondisi_kesehatan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 rounded text-white
                                    {{ $ibu->warna_kondisi == 'Hijau (success)' ? 'bg-green-500' : ($ibu->warna_kondisi == 'Kuning (warning)' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ $ibu->warna_kondisi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->berat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->tinggi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($ibu->status_verifikasi == 'pending')
                                    <a href="{{ route('kelurahan.ibu_nifas.edit', ['id' => $ibu->id, 'source' => 'pending']) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('kelurahan.ibu_nifas.destroy', $ibu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @else
                                    <a href="{{ route('kelurahan.ibu_nifas.edit', ['id' => $ibu->id, 'source' => 'verified']) }}" class="text-blue-600 hover:underline">Edit</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data ibu nifas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $ibuNifas->links() }}
            </div>
        </div>
    </div>
</body>
</html>