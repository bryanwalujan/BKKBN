<!DOCTYPE html>
<html>
<head>
    <title>Data Kegiatan Genting - Perangkat Daerah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kegiatan Genting - Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan }}</h2>
        <div class="mb-4 flex space-x-4">
            <form method="GET" action="{{ route('perangkat_daerah.genting.index') }}" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama Kegiatan" class="border p-2 rounded w-1/3">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search)
                    <a href="{{ route('perangkat_daerah.genting.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('perangkat_daerah.genting.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Kegiatan Genting</a>
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
                        <th class="p-4 text-left">Kartu Keluarga</th>
                        <th class="p-4 text-left">Dokumentasi</th>
                        <th class="p-4 text-left">Nama Kegiatan</th>
                        <th class="p-4 text-left">Tanggal</th>
                        <th class="p-4 text-left">Lokasi</th>
                        <th class="p-4 text-left">Sasaran</th>
                        <th class="p-4 text-left">Jenis Intervensi</th>
                        <th class="p-4 text-left">Narasi</th>
                        <th class="p-4 text-left">Pihak Ketiga</th>
                        <th class="p-4 text-left">Diunggah Oleh</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gentings as $index => $genting)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $gentings->firstItem() + $index }}</td>
                            <td class="p-4">
                                @if ($genting->kartuKeluarga)
                                    <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $genting->kartuKeluarga->id) }}" class="text-blue-500 hover:underline">
                                        {{ $genting->kartuKeluarga->no_kk }} - {{ $genting->kartuKeluarga->kepala_keluarga }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-4">
                                @if ($genting->dokumentasi)
                                    <a href="{{ Storage::url($genting->dokumentasi) }}" target="_blank">
                                        <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi" class="w-16 h-16 object-cover rounded">
                                    </a>
                                @else
                                    Tidak ada
                                @endif
                            </td>
                            <td class="p-4">{{ $genting->nama_kegiatan }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($genting->tanggal)->format('d-m-Y') }}</td>
                            <td class="p-4">{{ $genting->lokasi }}</td>
                            <td class="p-4">{{ $genting->sasaran }}</td>
                            <td class="p-4">{{ $genting->jenis_intervensi }}</td>
                            <td class="p-4">{{ $genting->narasi ? \Illuminate\Support\Str::limit($genting->narasi, 50) : '-' }}</td>
                            <td class="p-4">
                                <ul class="list-disc pl-5">
                                    @if ($genting->dunia_usaha == 'ada')
                                        <li>Dunia Usaha: {{ $genting->dunia_usaha_frekuensi }}</li>
                                    @endif
                                    @if ($genting->pemerintah == 'ada')
                                        <li>Pemerintah: {{ $genting->pemerintah_frekuensi }}</li>
                                    @endif
                                    @if ($genting->bumn_bumd == 'ada')
                                        <li>BUMN dan BUMD: {{ $genting->bumn_bumd_frekuensi }}</li>
                                    @endif
                                    @if ($genting->individu_perseorangan == 'ada')
                                        <li>Individu dan Perseorangan: {{ $genting->individu_perseorangan_frekuensi }}</li>
                                    @endif
                                    @if ($genting->lsm_komunitas == 'ada')
                                        <li>LSM dan Komunitas: {{ $genting->lsm_komunitas_frekuensi }}</li>
                                    @endif
                                    @if ($genting->swasta == 'ada')
                                        <li>Swasta: {{ $genting->swasta_frekuensi }}</li>
                                    @endif
                                    @if ($genting->perguruan_tinggi_akademisi == 'ada')
                                        <li>Perguruan Tinggi dan Akademisi: {{ $genting->perguruan_tinggi_akademisi_frekuensi }}</li>
                                    @endif
                                    @if ($genting->media == 'ada')
                                        <li>Media: {{ $genting->media_frekuensi }}</li>
                                    @endif
                                    @if ($genting->tim_pendamping_keluarga == 'ada')
                                        <li>Tim Pendamping Keluarga: {{ $genting->tim_pendamping_keluarga_frekuensi }}</li>
                                    @endif
                                    @if ($genting->tokoh_masyarakat == 'ada')
                                        <li>Tokoh Masyarakat: {{ $genting->tokoh_masyarakat_frekuensi }}</li>
                                    @endif
                                    @if (!$genting->dunia_usaha && !$genting->pemerintah && !$genting->bumn_bumd && !$genting->individu_perseorangan && !$genting->lsm_komunitas && !$genting->swasta && !$genting->perguruan_tinggi_akademisi && !$genting->media && !$genting->tim_pendamping_keluarga && !$genting->tokoh_masyarakat)
                                        <li>Tidak ada pihak ketiga</li>
                                    @endif
                                </ul>
                            </td>
                            <td class="p-4">{{ $genting->createdBy ? $genting->createdBy->name : '-' }}</td>
                            <td class="p-4 flex space-x-2">
                                <a href="{{ route('perangkat_daerah.genting.edit', $genting->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('perangkat_daerah.genting.destroy', $genting->id) }}', '{{ $genting->nama_kegiatan }}')">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="p-4 text-center text-gray-500">Tidak ada data kegiatan genting ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $gentings->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus data kegiatan genting <span id="deleteName" class="font-bold"></span>?</p>
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