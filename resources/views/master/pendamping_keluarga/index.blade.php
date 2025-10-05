<!DOCTYPE html>
<html>
<head>
    <title>Data Pendamping Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Pendamping Keluarga</h2>
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
            <a href="{{ route('pendamping_keluarga.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Pendamping</a>
            <form action="{{ route('pendamping_keluarga.index') }}" method="GET" class="flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pendamping..." class="border-gray-300 rounded-md shadow-sm p-2">
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
            </form>
        </div>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Peran</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tahun Bergabung</th>
                    <th class="p-4 text-left">Diunggah Oleh</th>
                    <th class="p-4 text-left">Foto</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendampingKeluargas as $index => $pendamping)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-100' }}">
                        <td class="p-4">{{ $pendampingKeluargas->firstItem() + $index }}</td>
                        <td class="p-4">{{ $pendamping->nama }}</td>
                        <td class="p-4">{{ $pendamping->peran }}</td>
                        <td class="p-4">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $pendamping->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $pendamping->status }}</td>
                        <td class="p-4">{{ $pendamping->tahun_bergabung }}</td>
                        <td class="p-4">{{ $pendamping->createdBy ? $pendamping->createdBy->name : '-' }}</td>
                        <td class="p-4">
                            @if ($pendamping->foto)
                                <a href="{{ Storage::url($pendamping->foto) }}" target="_blank">
                                    <img src="{{ Storage::url($pendamping->foto) }}" alt="Foto {{ $pendamping->nama }}" class="w-16 h-16 object-cover rounded">
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($pendamping->kartuKeluargas->isNotEmpty())
                                <a href="{{ route('kartu_keluarga.show', $pendamping->id) }}" class="text-green-500 hover:underline">Detail</a>
                            @else
                                <span class="text-gray-500">Tidak ada KK</span>
                            @endif
                            <a href="{{ route('pendamping_keluarga.edit', $pendamping->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <button type="button" onclick="openDeleteModal({{ $pendamping->id }})" class="text-red-500 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $pendampingKeluargas->links('pagination::tailwind') }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p>Apakah Anda yakin ingin menghapus data pendamping ini?</p>
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

    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `{{ url('pendamping_keluarga') }}/${id}`;
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