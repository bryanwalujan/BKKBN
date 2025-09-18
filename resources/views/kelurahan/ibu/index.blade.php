<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu</h2>
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
        <div class="mb-4 flex space-x-4">
            <div class="flex items-center space-x-2">
                <button onclick="switchTab('pending')" class="px-4 py-2 rounded {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Pending</button>
                <button onclick="switchTab('verified')" class="px-4 py-2 rounded {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Terverifikasi</button>
            </div>
            <form action="{{ route('kelurahan.ibu.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama atau NIK" class="border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search)
                    <a href="{{ route('kelurahan.ibu.index', ['tab' => $tab]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('kelurahan.ibu.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Ibu</a>
        </div>
        @if ($search)
            <p class="mt-2 text-sm text-gray-600">
                Menampilkan data dengan pencarian: "{{ $search }}" ({{ $ibus->total() }} data)
            @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan {{ $tab == 'pending' ? 'data pending' : 'data terverifikasi' }} ({{ $ibus->total() }} data)</p>
        @endif
        <table class="w-full bg-white shadow-md rounded border border-gray-200">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-4 text-left font-medium">No</th>
                    <th class="p-4 text-left font-medium">Foto</th>
                    <th class="p-4 text-left font-medium">NIK</th>
                    <th class="p-4 text-left font-medium">Nama</th>
                    <th class="p-4 text-left font-medium">Kecamatan</th>
                    <th class="p-4 text-left font-medium">Kelurahan</th>
                    <th class="p-4 text-left font-medium">Kartu Keluarga</th>
                    <th class="p-4 text-left font-medium">Alamat</th>
                    <th class="p-4 text-left font-medium">Status</th>
                    <th class="p-4 text-left font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ibus as $index => $ibu)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $ibus->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($ibu->foto)
                                <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="w-16 h-16 object-cover rounded">
                            @else
                                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                            @endif
                        </td>
                        <td class="p-4">{{ $ibu->nik ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->nama }}</td>
                        <td class="p-4">{{ $ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->kartuKeluarga->no_kk . ' - ' . $ibu->kartuKeluarga->kepala_keluarga ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->alamat ?? '-' }}</td>
                        <td class="p-4">{{ $ibu->status }}</td>
                        <td class="p-4 flex space-x-2">
                            <a href="{{ route('kelurahan.ibu.edit', ['id' => $ibu->id, 'source' => $ibu->source]) }}" class="text-blue-500 hover:underline">Edit</a>
                            @if ($ibu->source == 'pending')
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('kelurahan.ibu.destroy', $ibu->id) }}', '{{ $ibu->nama }}')">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-4 text-center text-gray-500">Tidak ada data ibu ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $ibus->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data ibu <span id="deleteName" class="font-bold"></span>?</p>
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

        function switchTab(tab) {
            window.location.href = '{{ route("kelurahan.ibu.index") }}?tab=' + tab;
        }
    </script>
</body>
</html>