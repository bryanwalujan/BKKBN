<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu Menyusui</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu Menyusui</h2>
        <div class="mb-4 flex space-x-4">
            <div class="flex space-x-2">
                <a href="{{ route('kelurahan.ibu_menyusui.index', ['tab' => 'pending']) }}" class="px-4 py-2 rounded {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">Pending</a>
                <a href="{{ route('kelurahan.ibu_menyusui.index', ['tab' => 'verified']) }}" class="px-4 py-2 rounded {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">Terverifikasi</a>
            </div>
            <form action="{{ route('kelurahan.ibu_menyusui.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <select name="category" class="border-gray-300 rounded-md shadow-sm p-2">
                    <option value="" {{ $category == '' ? 'selected' : '' }}>Semua Status Menyusui</option>
                    <option value="Eksklusif" {{ $category == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                    <option value="Non-Eksklusif" {{ $category == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
            </form>
            <form action="{{ route('kelurahan.ibu_menyusui.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama atau NIK" class="border-gray-300 rounded-md shadow-sm p-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search || $category)
                    <a href="{{ route('kelurahan.ibu_menyusui.index', ['tab' => $tab]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            @if ($tab == 'pending')
                <a href="{{ route('kelurahan.ibu_menyusui.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Ibu Menyusui</a>
            @endif
        </div>
        @if ($category || $search)
            <p class="mt-2 text-sm text-gray-600">
                Menampilkan data
                @if ($category)
                    untuk status menyusui: {{ $category }}
                @endif
                @if ($search)
                    dengan pencarian: "{{ $search }}"
                @endif
                ({{ $ibuMenyusuis->total() }} data)
            </p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data ibu menyusui ({{ $ibuMenyusuis->total() }} data)</p>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Foto</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Status Menyusui</th>
                    <th class="p-4 text-left">Frekuensi Menyusui</th>
                    <th class="p-4 text-left">Kondisi Ibu</th>
                    <th class="p-4 text-left">Warna Kondisi</th>
                    <th class="p-4 text-left">Berat (kg)</th>
                    <th class="p-4 text-left">Tinggi (cm)</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ibuMenyusuis as $index => $ibu)
                    <tr>
                        <td class="p-4">{{ $ibuMenyusuis->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($tab == 'verified' && $ibu->ibu->foto)
                                <img src="{{ Storage::url($ibu->ibu->foto) }}" alt="Foto Ibu Menyusui" class="w-16 h-16 object-cover rounded">
                            @elseif ($tab == 'pending' && $ibu->pendingIbu->foto)
                                <img src="{{ Storage::url($ibu->pendingIbu->foto) }}" alt="Foto Ibu Menyusui" class="w-16 h-16 object-cover rounded">
                            @else
                                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                            @endif
                        </td>
                        <td class="p-4">{{ $tab == 'verified' ? $ibu->ibu->nama : $ibu->pendingIbu->nama }}</td>
                        <td class="p-4">{{ $tab == 'verified' ? ($ibu->ibu->kelurahan->nama_kelurahan ?? '-') : ($ibu->pendingIbu->kelurahan->nama_kelurahan ?? '-') }}</td>
                        <td class="p-4">{{ $tab == 'verified' ? ($ibu->ibu->kecamatan->nama_kecamatan ?? '-') : ($ibu->pendingIbu->kecamatan->nama_kecamatan ?? '-') }}</td>
                        <td class="p-4">{{ $ibu->status_menyusui }}</td>
                        <td class="p-4">{{ $ibu->frekuensi_menyusui }}</td>
                        <td class="p-4">{{ $ibu->kondisi_ibu }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white
                                {{ $ibu->warna_kondisi == 'Hijau (success)' ? 'bg-green-500' : ($ibu->warna_kondisi == 'Kuning (warning)' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ $ibu->warna_kondisi }}
                            </span>
                        </td>
                        <td class="p-4">{{ $ibu->berat }}</td>
                        <td class="p-4">{{ $ibu->tinggi }}</td>
                        <td class="p-4">
                            <a href="{{ route('kelurahan.ibu_menyusui.edit', [$ibu->id, $tab]) }}" class="text-blue-500 hover:underline">Edit</a>
                            @if ($tab == 'pending')
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('kelurahan.ibu_menyusui.destroy', $ibu->id) }}', '{{ $ibu->pendingIbu->nama }}')">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $ibuMenyusuis->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data ibu menyusui <span id="deleteName" class="font-bold"></span>?</p>
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