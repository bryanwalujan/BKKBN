<!DOCTYPE html>
<html>
<head>
    <title>Data Aksi Konvergensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Aksi Konvergensi</h2>
        <div class="mb-4 flex space-x-4">
            <form method="GET" action="{{ route('aksi_konvergensi.index') }}" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama Aksi" class="border p-2 rounded w-1/3">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search)
                    <a href="{{ route('aksi_konvergensi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('aksi_konvergensi.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Aksi Konvergensi</a>
        </div>
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
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">No KK</th>
                        <th class="p-4 text-left">Kecamatan</th>
                        <th class="p-4 text-left">Kelurahan</th>
                        <th class="p-4 text-left">Nama Aksi</th>
                        <th class="p-4 text-left">Selesai</th>
                        <th class="p-4 text-left">Tahun</th>
                        <th class="p-4 text-left">Diunggah Oleh</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aksiKonvergensis as $index => $aksi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $aksiKonvergensis->firstItem() + $index }}</td>
                            <td class="p-4">
                                @if ($aksi->kartuKeluarga)
                                    <a href="{{ route('kartu_keluarga.show', $aksi->kartuKeluarga->id) }}" class="text-blue-500 hover:underline">
                                        {{ $aksi->kartuKeluarga->no_kk }} - {{ $aksi->kartuKeluarga->kepala_keluarga }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-4">{{ $aksi->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="p-4">{{ $aksi->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="p-4">{{ $aksi->nama_aksi }}</td>
                            <td class="p-4">
                                <span class="inline-block px-2 py-1 rounded text-white {{ $aksi->selesai ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                                </span>
                            </td>
                            <td class="p-4">{{ $aksi->tahun }}</td>
                            <td class="p-4">{{ $aksi->createdBy ? $aksi->createdBy->name : '-' }}</td>
                            <td class="p-4 flex space-x-2">
                                <a href="{{ route('aksi_konvergensi.edit', $aksi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('aksi_konvergensi.destroy', $aksi->id) }}', '{{ $aksi->nama_aksi }}')">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">Tidak ada data aksi konvergensi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $aksiKonvergensis->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data aksi konvergensi <span id="deleteName" class="font-bold"></span>?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                <button id="confirmDelete" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ya, Lanjutkan</button>
            </div>
            <div id="secondConfirm" class="hidden mt-4">
                <p class="mb-4 text-red-600">Konfirmasi sekali lagi: Data akan dihapus permanen. Lanjutkan?</p>
                <div class="flex justify-end space-x-4">
                    <button id="cancelSecondConfirm" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(url, name) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = url;
            document.getElementById('secondConfirm').classList.add('hidden');
            document.getElementById('confirmDelete').classList.remove('hidden');
        }

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });

        document.getElementById('cancelSecondConfirm').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });

        document.getElementById('confirmDelete').addEventListener('click', function() {
            document.getElementById('secondConfirm').classList.remove('hidden');
            document.getElementById('confirmDelete').classList.add('hidden');
        });
    </script>
</body>
</html>