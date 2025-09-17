<!DOCTYPE html>
<html>
<head>
    <title>Data Stunting - Admin Kelurahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Stunting</h2>
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
                <a href="{{ route('kelurahan.stunting.index', ['tab' => 'pending', 'search' => $search, 'kategori_umur' => $kategoriUmur]) }}"
                   class="px-4 py-2 rounded {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Menunggu Verifikasi</a>
                <a href="{{ route('kelurahan.stunting.index', ['tab' => 'verified', 'search' => $search, 'kategori_umur' => $kategoriUmur]) }}"
                   class="px-4 py-2 rounded {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">Terverifikasi</a>
            </div>
            @if ($tab == 'pending')
                <a href="{{ route('kelurahan.stunting.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Tambah Data Stunting</a>
            @endif
        </div>
        <div class="mb-4 flex space-x-4">
            <form action="{{ route('kelurahan.stunting.index') }}" method="GET" class="flex space-x-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <select name="kategori_umur" class="border-gray-300 rounded-md shadow-sm p-2">
                    <option value="" {{ $kategoriUmur == '' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="Baduata" {{ $kategoriUmur == 'Baduata' ? 'selected' : '' }}>Baduata (0-2 tahun)</option>
                    <option value="Balita" {{ $kategoriUmur == 'Balita' ? 'selected' : '' }}>Balita (2-6 tahun)</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
            </form>
            <form action="{{ route('kelurahan.stunting.index') }}" method="GET" class="flex space-x-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan Nama atau NIK" class="border-gray-300 rounded-md shadow-sm p-2 w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search || $kategoriUmur)
                    <a href="{{ route('kelurahan.stunting.index', ['tab' => $tab]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
        </div>
        @if ($kategoriUmur || $search)
            <p class="mt-2 text-sm text-gray-600">
                Menampilkan data
                @if ($kategoriUmur)
                    untuk kategori: {{ $kategoriUmur }}
                @endif
                @if ($search)
                    dengan pencarian: "{{ $search }}"
                @endif
                ({{ $stuntings->total() }} data)
            </p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data stunting ({{ $stuntings->total() }} data)</p>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">NIK</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">No KK</th>
                    <th class="p-4 text-left">Kepala Keluarga</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Tanggal Lahir</th>
                    <th class="p-4 text-left">Kategori Umur</th>
                    <th class="p-4 text-left">Jenis Kelamin</th>
                    <th class="p-4 text-left">Berat/Tinggi</th>
                    <th class="p-4 text-left">Status Gizi</th>
                    <th class="p-4 text-left">Warna Gizi</th>
                    <th class="p-4 text-left">Tindak Lanjut</th>
                    <th class="p-4 text-left">Warna Tindak Lanjut</th>
                    <th class="p-4 text-left">Foto</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Diupload Oleh</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stuntings as $index => $stunting)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $stuntings->firstItem() + $index }}</td>
                        <td class="p-4">{{ $stunting->nik ?? '-' }}</td>
                        <td class="p-4">{{ $stunting->nama }}</td>
                        <td class="p-4">{{ $stunting->kartuKeluarga->no_kk ?? '-' }}</td>
                        <td class="p-4">{{ $stunting->kartuKeluarga->kepala_keluarga ?? '-' }}</td>
                        <td class="p-4">{{ $stunting->kecamatan_id ? ($stunting->kecamatan ? $stunting->kecamatan->nama_kecamatan : '-') : ($stunting->kecamatan ?? '-') }}</td>
                        <td class="p-4">{{ $stunting->kelurahan_id ? ($stunting->kelurahan ? $stunting->kelurahan->nama_kelurahan : '-') : ($stunting->kelurahan ?? '-') }}</td>
                        <td class="p-4">{{ $stunting->tanggal_lahir ? $stunting->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                        <td class="p-4">{{ $stunting->kategori_umur }}</td>
                        <td class="p-4">{{ $stunting->jenis_kelamin }}</td>
                        <td class="p-4">{{ $stunting->berat_tinggi }}</td>
                        <td class="p-4">{{ $stunting->status_gizi }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white
                                {{ $stunting->warna_gizi == 'Sehat' ? 'bg-green-500' : ($stunting->warna_gizi == 'Waspada' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ $stunting->warna_gizi }}
                            </span>
                        </td>
                        <td class="p-4">{{ $stunting->tindak_lanjut ?? '-' }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white
                                {{ $stunting->warna_tindak_lanjut == 'Sehat' ? 'bg-green-500' : ($stunting->warna_tindak_lanjut == 'Waspada' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ $stunting->warna_tindak_lanjut }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if ($stunting->foto)
                                <img src="{{ Storage::url($stunting->foto) }}" alt="Foto Stunting" class="w-16 h-16 object-cover rounded">
                            @else
                                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                            @endif
                        </td>
                        <td class="p-4">{{ $stunting->source == 'verified' ? 'Terverifikasi' : ucfirst($stunting->status) }}</td>
                        <td class="p-4">{{ $stunting->createdBy->name ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">
                            <a href="{{ route('kelurahan.stunting.edit', [$stunting->id, $stunting->source]) }}" class="text-blue-500 hover:underline">Edit</a>
                            @if ($stunting->source == 'pending')
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('kelurahan.stunting.destroy', $stunting->id) }}', '{{ $stunting->nama }}')">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="19" class="p-4 text-center">Tidak ada data stunting yang sesuai dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $stuntings->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data stunting <span id="deleteName" class="font-bold"></span>?</p>
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