<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu Hamil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu Hamil</h2>
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
                <a href="{{ route('kelurahan.ibu_hamil.index', ['tab' => 'pending']) }}" class="px-4 py-2 {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Pending</a>
                <a href="{{ route('kelurahan.ibu_hamil.index', ['tab' => 'verified']) }}" class="px-4 py-2 {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Terverifikasi</a>
            </div>
            <div class="flex items-center space-x-4">
                <form action="{{ route('kelurahan.ibu_hamil.index') }}" method="GET" class="flex space-x-2">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK" class="border-gray-300 rounded-md px-4 py-2">
                    <select name="category" class="border-gray-300 rounded-md px-4 py-2">
                        <option value="">Semua Trimester</option>
                        <option value="Trimester 1" {{ $category == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                        <option value="Trimester 2" {{ $category == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                        <option value="Trimester 3" {{ $category == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                    </select>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                </form>
                @if ($tab == 'pending')
                    <a href="{{ route('kelurahan.ibu_hamil.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Data</a>
                @endif
            </div>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trimester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Gizi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usia Kehamilan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($ibuHamils as $ibuHamil)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibuHamil->pendingIbu->nama ?? $ibuHamil->ibu->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibuHamil->pendingIbu->nik ?? $ibuHamil->ibu->nik ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibuHamil->trimester }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibuHamil->status_gizi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibuHamil->usia_kehamilan }} minggu</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($ibuHamil->source == 'pending')
                                    <a href="{{ route('kelurahan.ibu_hamil.edit', ['id' => $ibuHamil->id, 'source' => 'pending']) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('kelurahan.ibu_hamil.destroy', $ibuHamil->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @else
                                    <a href="{{ route('kelurahan.ibu_hamil.edit', ['id' => $ibuHamil->id, 'source' => 'verified']) }}" class="text-blue-600 hover:underline">Edit</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data ibu hamil.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $ibuHamils->links() }}
            </div>
        </div>
    </div>
</body>
</html>