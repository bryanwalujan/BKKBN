<!DOCTYPE html>
<html>
<head>
    <title>Data Bayi Baru Lahir</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Bayi Baru Lahir</h2>
        <div class="mb-4 flex space-x-4">
            <form action="{{ route('bayi_baru_lahir.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama ibu, NIK, atau umur dalam kandungan" class="border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search)
                    <a href="{{ route('bayi_baru_lahir.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('bayi_baru_lahir.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Bayi Baru Lahir</a>
            <a href="{{ route('ibu_nifas.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Data Ibu Nifas</a>
        </div>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if ($search)
            <p class="mt-2 text-sm text-gray-600">Menampilkan data dengan pencarian: "{{ $search }}" ({{ $bayiBaruLahirs->total() }} data)</p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data bayi baru lahir ({{ $bayiBaruLahirs->total() }} data)</p>
        @endif
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Nama Ibu</th>
                        <th class="p-4 text-left">Kelurahan</th>
                        <th class="p-4 text-left">Kecamatan</th>
                        <th class="p-4 text-left">Umur Dalam Kandungan</th>
                        <th class="p-4 text-left">Berat Badan Lahir (kg)</th>
                        <th class="p-4 text-left">Panjang Badan Lahir (cm)</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bayiBaruLahirs as $index => $bayi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $bayiBaruLahirs->firstItem() + $index }}</td>
                            <td class="p-4">{{ $bayi->ibuNifas->ibu->nama ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->ibuNifas->ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->ibuNifas->ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->umur_dalam_kandungan ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->berat_badan_lahir ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->panjang_badan_lahir ?? '-' }}</td>
                            <td class="p-4 flex space-x-2">
                                <a href="{{ route('bayi_baru_lahir.edit', $bayi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('bayi_baru_lahir.destroy', $bayi->id) }}', '{{ $bayi->ibuNifas->ibu->nama ?? 'Bayi' }}')">Hapus</button>
                                <button type="button" class="text-green-500 hover:underline" onclick="showMoveToBalitaModal('{{ route('bayi_baru_lahir.moveToBalita', $bayi->id) }}', '{{ $bayi->ibuNifas->ibu->nama ?? 'Bayi' }}')">Tambah ke Balita</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">Tidak ada data bayi baru lahir ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $bayiBaruLahirs->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data bayi baru lahir untuk ibu <span id="deleteName" class="font-bold"></span>?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                <button id="confirmDelete" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ya, Lanjutkan</button>
            </div>
            <div id="secondConfirmDelete" class="hidden mt-4">
                <p class="mb-4 text-red-600">Konfirmasi sekali lagi: Data akan dihapus permanen. Lanjutkan?</p>
                <div class="flex justify-end space-x-4">
                    <button id="cancelSecondConfirmDelete" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Tambah ke Balita -->
    <div id="moveToBalitaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Pemindahan ke Balita</h3>
            <p class="mb-4">Apakah Anda yakin ingin memindahkan data bayi untuk ibu <span id="moveToBalitaName" class="font-bold"></span> ke tabel balita?</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelMoveToBalita" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                <button id="confirmMoveToBalita" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ya, Lanjutkan</button>
            </div>
            <div id="secondConfirmMoveToBalita" class="hidden mt-4">
                <p class="mb-4 text-red-600">Konfirmasi sekali lagi: Data akan dipindahkan ke tabel balita dan dihapus dari bayi baru lahir. Lanjutkan?</p>
                <div class="flex justify-end space-x-4">
                    <button id="cancelSecondConfirmMoveToBalita" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <form id="moveToBalitaForm" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Pindahkan Sekarang</button>
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
            document.getElementById('secondConfirmDelete').classList.add('hidden');
            document.getElementById('confirmDelete').classList.remove('hidden');
        }

        function showMoveToBalitaModal(url, name) {
            document.getElementById('moveToBalitaModal').classList.remove('hidden');
            document.getElementById('moveToBalitaName').textContent = name;
            document.getElementById('moveToBalitaForm').action = url;
            document.getElementById('secondConfirmMoveToBalita').classList.add('hidden');
            document.getElementById('confirmMoveToBalita').classList.remove('hidden');
        }

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });

        document.getElementById('cancelSecondConfirmDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });

        document.getElementById('confirmDelete').addEventListener('click', function() {
            document.getElementById('secondConfirmDelete').classList.remove('hidden');
            document.getElementById('confirmDelete').classList.add('hidden');
        });

        document.getElementById('cancelMoveToBalita').addEventListener('click', function() {
            document.getElementById('moveToBalitaModal').classList.add('hidden');
        });

        document.getElementById('cancelSecondConfirmMoveToBalita').addEventListener('click', function() {
            document.getElementById('moveToBalitaModal').classList.add('hidden');
        });

        document.getElementById('confirmMoveToBalita').addEventListener('click', function() {
            document.getElementById('secondConfirmMoveToBalita').classList.remove('hidden');
            document.getElementById('confirmMoveToBalita').classList.add('hidden');
        });
    </script>
</body>
</html>