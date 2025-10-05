<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu Hamil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu Hamil</h2>
        <div class="mb-4 flex space-x-4">
            <form action="{{ route('ibu_hamil.index') }}" method="GET" class="flex items-center space-x-2">
                <select name="category" class="border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" {{ $category == '' ? 'selected' : '' }}>Semua Trimester</option>
                    <option value="Trimester 1" {{ $category == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                    <option value="Trimester 2" {{ $category == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                    <option value="Trimester 3" {{ $category == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
            </form>
            <form action="{{ route('ibu_hamil.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama, NIK, atau riwayat penyakit" class="border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search || $category)
                    <a href="{{ route('ibu_hamil.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('ibu_hamil.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Ibu Hamil</a>
        </div>
        @if ($category || $search)
            <p class="mt-2 text-sm text-gray-600">
                Menampilkan data
                @if ($category)
                    untuk trimester: {{ $category }}
                @endif
                @if ($search)
                    dengan pencarian: "{{ $search }}"
                @endif
                ({{ $totalData }} data)
            </p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data ibu hamil ({{ $totalData }} data)</p>
        @endif
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Foto</th>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Kelurahan</th>
                        <th class="p-4 text-left">Kecamatan</th>
                        <th class="p-4 text-left">Trimester</th>
                        <th class="p-4 text-left">Intervensi</th>
                        <th class="p-4 text-left">Status Gizi</th>
                        <th class="p-4 text-left">Warna Status Gizi</th>
                        <th class="p-4 text-left">Usia Kehamilan (minggu)</th>
                        <th class="p-4 text-left">Tinggi Fundus Uteri (cm)</th>
                        <th class="p-4 text-left">IMT</th>
                        <th class="p-4 text-left">Riwayat Penyakit</th>
                        <th class="p-4 text-left">Kadar HB</th>
                        <th class="p-4 text-left">Lingkar Kepala (cm)</th>
                        <th class="p-4 text-left">Taksiran Berat Janin (gr)</th>
                        <th class="p-4 text-left">Berat (kg)</th>
                        <th class="p-4 text-left">Tinggi (cm)</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ibuHamils as $index => $ibuHamil)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $index + 1 }}</td>
                            <td class="p-4">
                                @if ($ibuHamil->ibu->foto)
                                    <img src="{{ Storage::url($ibuHamil->ibu->foto) }}" alt="Foto Ibu Hamil" class="w-16 h-16 object-cover rounded">
                                @else
                                    <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                                @endif
                            </td>
                            <td class="p-4">{{ $ibuHamil->ibu->nama }}</td>
                            <td class="p-4">{{ $ibuHamil->ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->trimester }}</td>
                            <td class="p-4">{{ $ibuHamil->intervensi }}</td>
                            <td class="p-4">{{ $ibuHamil->status_gizi }}</td>
                            <td class="p-4">
                                <span class="inline-block px-2 py-1 rounded text-white
                                    {{ $ibuHamil->warna_status_gizi == 'Sehat' ? 'bg-green-500' : ($ibuHamil->warna_status_gizi == 'Waspada' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ $ibuHamil->warna_status_gizi }}
                                </span>
                            </td>
                            <td class="p-4">{{ $ibuHamil->usia_kehamilan }}</td>
                            <td class="p-4">{{ $ibuHamil->tinggi_fundus_uteri ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->imt ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->riwayat_penyakit ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->kadar_hb ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->lingkar_kepala ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->taksiran_berat_janin ?? '-' }}</td>
                            <td class="p-4">{{ $ibuHamil->berat }}</td>
                            <td class="p-4">{{ $ibuHamil->tinggi }}</td>
                            <td class="p-4 flex space-x-2">
                                <a href="{{ route('ibu_hamil.edit', $ibuHamil->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('ibu_hamil.destroy', $ibuHamil->id) }}', '{{ $ibuHamil->ibu->nama }}')">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="19" class="p-4 text-center text-gray-500">Tidak ada data ibu hamil ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data ibu hamil <span id="deleteName" class="font-bold"></span>?</p>
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