<!DOCTYPE html>
<html>
<head>
    <title>Data Remaja Putri - Admin Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Remaja Putri</h2>
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
        <div class="mb-4 flex justify-between">
            <div>
                <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => 'pending', 'search' => $search]) }}"
                   class="px-4 py-2 rounded {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Menunggu Verifikasi</a>
                <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => 'verified', 'search' => $search]) }}"
                   class="px-4 py-2 rounded {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Terverifikasi</a>
            </div>
            @if ($tab == 'pending')
                <a href="{{ route('kelurahan.remaja_putri.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Data Remaja Putri</a>
            @endif
        </div>
        <div class="mb-4">
            <form action="{{ route('kelurahan.remaja_putri.index') }}" method="GET" class="flex space-x-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan Nama" class="border-gray-300 rounded-md shadow-sm p-2 w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search)
                    <a href="{{ route('kelurahan.remaja_putri.index', ['tab' => $tab]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
        </div>
        <p class="mt-2 text-sm text-gray-600">
            Menampilkan {{ $tab == 'verified' ? 'data terverifikasi' : 'data menunggu verifikasi' }}
            @if ($search)
                dengan pencarian: "{{ $search }}"
            @endif
            ({{ $remajaPutris->total() }} data)
        </p>
        <table class="w-full bg-white shadow-md rounded border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-4 text-left font-medium">No</th>
                    <th class="p-4 text-left font-medium">Foto</th>
                    <th class="p-4 text-left font-medium">Nama</th>
                    <th class="p-4 text-left font-medium">No KK</th>
                    <th class="p-4 text-left font-medium">Kecamatan</th>
                    <th class="p-4 text-left font-medium">Kelurahan</th>
                    <th class="p-4 text-left font-medium">Sekolah</th>
                    <th class="p-4 text-left font-medium">Kelas</th>
                    <th class="p-4 text-left font-medium">Umur</th>
                    <th class="p-4 text-left font-medium">Status Anemia</th>
                    <th class="p-4 text-left font-medium">Konsumsi TTD</th>
                    <th class="p-4 text-left font-medium">Status</th>
                    <th class="p-4 text-left font-medium">Diupload Oleh</th>
                    <th class="p-4 text-left font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($remajaPutris as $index => $remaja)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $remajaPutris->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($remaja->foto)
                                <img src="{{ Storage::url($remaja->foto) }}" alt="Foto Remaja Putri" class="w-16 h-16 object-cover rounded">
                            @else
                                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                            @endif
                        </td>
                        <td class="p-4">{{ $remaja->nama }}</td>
                        <td class="p-4">{{ $remaja->kartuKeluarga->no_kk ?? '-' }}</td>
                        <td class="p-4">{{ $remaja->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $remaja->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $remaja->sekolah }}</td>
                        <td class="p-4">{{ $remaja->kelas }}</td>
                        <td class="p-4">{{ $remaja->umur }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white
                                {{ $remaja->status_anemia == 'Tidak Anemia' ? 'bg-green-500' : ($remaja->status_anemia == 'Anemia Ringan' ? 'bg-yellow-500' : ($remaja->status_anemia == 'Anemia Sedang' ? 'bg-orange-500' : 'bg-red-500')) }}">
                                {{ $remaja->status_anemia }}
                            </span>
                        </td>
                        <td class="p-4">{{ $remaja->konsumsi_ttd }}</td>
                        <td class="p-4">{{ $remaja->source == 'verified' ? 'Terverifikasi' : ucfirst($remaja->status) }}</td>
                        <td class="p-4">{{ $remaja->createdBy->name ?? 'Tidak diketahui' }}</td>
                        <td class="p-4 flex space-x-2">
                            <a href="{{ route('kelurahan.remaja_putri.edit', [$remaja->id, $remaja->source]) }}" class="text-blue-500 hover:underline">Edit</a>
                            @if ($remaja->source == 'pending')
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('kelurahan.remaja_putri.destroy', $remaja->id) }}', '{{ $remaja->nama }}')">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="p-4 text-center text-gray-500">Tidak ada data Remaja Putri ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $remajaPutris->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data remaja putri <span id="deleteName" class="font-bold"></span>?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(url, name) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = url;
        }

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });
    </script>
</body>
</html>