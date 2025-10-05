<!DOCTYPE html>
<html>
<head>
    <title>Data Calon Pengantin - Admin Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Calon Pengantin</h2>
        <div class="mb-4 flex space-x-4">
            <form action="{{ route('kelurahan.catin.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama" class="border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search)
                    <a href="{{ route('kelurahan.catin.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('kelurahan.catin.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Catin</a>
        </div>
        @if ($search)
            <p class="mt-2 text-sm text-gray-600">Menampilkan data dengan pencarian: "{{ $search }}" ({{ $catins->total() }} data)</p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data calon pengantin ({{ $catins->total() }} data)</p>
        @endif
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Hari/Tanggal</th>
                        <th class="p-4 text-left">Nama Wanita</th>
                        <th class="p-4 text-left">NIK Wanita</th>
                        <th class="p-4 text-left">Tempat Lahir Wanita</th>
                        <th class="p-4 text-left">Tgl Lahir Wanita</th>
                        <th class="p-4 text-left">No HP Wanita</th>
                        <th class="p-4 text-left">Alamat Wanita</th>
                        <th class="p-4 text-left">Nama Pria</th>
                        <th class="p-4 text-left">NIK Pria</th>
                        <th class="p-4 text-left">Tempat Lahir Pria</th>
                        <th class="p-4 text-left">Tgl Lahir Pria</th>
                        <th class="p-4 text-left">No HP Pria</th>
                        <th class="p-4 text-left">Alamat Pria</th>
                        <th class="p-4 text-left">Tgl Pernikahan</th>
                        <th class="p-4 text-left">Berat Badan (kg)</th>
                        <th class="p-4 text-left">Tinggi Badan (cm)</th>
                        <th class="p-4 text-left">IMT</th>
                        <th class="p-4 text-left">Kadar HB (g/dL)</th>
                        <th class="p-4 text-left">Merokok</th>
                        <th class="p-4 text-left">Diunggah Oleh</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($catins as $index => $catin)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $catins->firstItem() + $index }}</td>
                            <td class="p-4">{{ $catin->hari_tanggal ? $catin->hari_tanggal->format('d-m-Y') : '-' }}</td>
                            <td class="p-4">{{ $catin->catin_wanita_nama ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_wanita_nik ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_wanita_tempat_lahir ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_wanita_tgl_lahir ? $catin->catin_wanita_tgl_lahir->format('d-m-Y') : '-' }}</td>
                            <td class="p-4">{{ $catin->catin_wanita_no_hp ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_wanita_alamat ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_pria_nama ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_pria_nik ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_pria_tempat_lahir ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_pria_tgl_lahir ? $catin->catin_pria_tgl_lahir->format('d-m-Y') : '-' }}</td>
                            <td class="p-4">{{ $catin->catin_pria_no_hp ?? '-' }}</td>
                            <td class="p-4">{{ $catin->catin_pria_alamat ?? '-' }}</td>
                            <td class="p-4">{{ $catin->tanggal_pernikahan ? $catin->tanggal_pernikahan->format('d-m-Y') : '-' }}</td>
                            <td class="p-4">{{ $catin->berat_badan ?? '-' }}</td>
                            <td class="p-4">{{ $catin->tinggi_badan ?? '-' }}</td>
                            <td class="p-4">{{ $catin->imt ?? '-' }}</td>
                            <td class="p-4">{{ $catin->kadar_hb ?? '-' }}</td>
                            <td class="p-4">{{ $catin->merokok ?? '-' }}</td>
                            <td class="p-4">{{ $catin->user ? $catin->user->name : '-' }}</td>
                            <td class="p-4 flex space-x-2">
                                <a href="{{ route('kelurahan.catin.edit', $catin->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('kelurahan.catin.destroy', $catin->id) }}', '{{ $catin->catin_wanita_nama ?? 'Catin' }}')">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="21" class="p-4 text-center text-gray-500">Tidak ada data calon pengantin ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $catins->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data calon pengantin <span id="deleteName" class="font-bold"></span>?</p>
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