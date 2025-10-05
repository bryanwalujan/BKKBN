<!DOCTYPE html>
<html>
<head>
    <title>Data Aksi Konvergensi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Aksi Konvergensi</h2>
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
        <form method="GET" action="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="mb-6 bg-white p-4 rounded shadow">
            <div class="flex space-x-4">
                <div class="w-1/3">
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Nama Aksi</label>
                    <input type="text" name="search" id="search" value="{{ $search }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Cari nama aksi...">
                </div>
                <div class="w-1/3 flex items-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                    <a href="{{ route('perangkat_daerah.aksi_konvergensi.create') }}" class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Data</a>
                </div>
            </div>
        </form>
        <div class="bg-white p-6 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No KK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kecamatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelurahan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Selesai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diunggah Oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($aksiKonvergensis as $index => $aksi)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $aksiKonvergensis->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('kartu_keluarga.show', $aksi->kartu_keluarga_id) }}" class="text-blue-500 hover:underline">
                                    {{ $aksi->kartuKeluarga->no_kk ?? '-' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $aksi->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $aksi->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $aksi->nama_aksi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-block px-2 py-1 rounded text-white {{ $aksi->selesai ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $aksi->tahun }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $aksi->createdBy ? $aksi->createdBy->name : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $aksi->id) }}" class="text-green-600 hover:text-green-900">Detail</a>
                                <a href="{{ route('perangkat_daerah.aksi_konvergensi.edit', $aksi->id) }}" class="text-blue-600 hover:text-blue-900 ml-2">Edit</a>
                                <button type="button" onclick="openDeleteModal({{ $aksi->id }})" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $aksiKonvergensis->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
                <p>Apakah Anda yakin ingin menghapus data Aksi Konvergensi ini?</p>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Ketik "HAPUS" untuk konfirmasi:</label>
                    <input type="text" id="deleteConfirm" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" oninput="checkDeleteConfirm()">
                </div>
                <form id="deleteForm" method="POST" class="mt-4 flex justify-end space-x-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <button type="submit" id="deleteSubmit" disabled class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 disabled:bg-gray-300">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `{{ url('perangkat_daerah/aksi_konvergensi') }}/${id}`;
            modal.classList.remove('hidden');
            document.getElementById('deleteConfirm').value = '';
            document.getElementById('deleteSubmit').disabled = true;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function checkDeleteConfirm() {
            const input = document.getElementById('deleteConfirm').value;
            document.getElementById('deleteSubmit').disabled = input !== 'HAPUS';
        }
    </script>
</body>
</html>