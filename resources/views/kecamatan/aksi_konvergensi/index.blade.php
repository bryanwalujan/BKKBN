<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Aksi Konvergensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kecamatan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Verifikasi Aksi Konvergensi</h2>
        <div class="mb-4">
            <a href="{{ route('kecamatan.aksi_konvergensi.index', ['tab' => 'pending']) }}" class="inline-block px-4 py-2 {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Pending</a>
            <a href="{{ route('kecamatan.aksi_konvergensi.index', ['tab' => 'verified']) }}" class="inline-block px-4 py-2 {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Terverifikasi</a>
        </div>
        <form method="GET" action="{{ route('kecamatan.aksi_konvergensi.index') }}" class="mb-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama aksi..." class="border-gray-300 rounded-md shadow-sm p-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
        </form>
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
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">No KK</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Nama Aksi</th>
                    <th class="p-4 text-left">Selesai</th>
                    <th class="p-4 text-left">Tahun</th>
                    @if ($tab == 'pending')
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Pembuat</th>
                    @endif
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aksiKonvergensis as $index => $aksi)
                    <tr>
                        <td class="p-4">{{ $aksiKonvergensis->firstItem() + $index }}</td>
                        <td class="p-4">
                            <a href="{{ route('kartu_keluarga.show', $aksi->kartuKeluarga->id) }}" class="text-blue-500 hover:underline">
                                {{ $aksi->kartuKeluarga->no_kk ?? '-' }}
                            </a>
                        </td>
                        <td class="p-4">{{ $aksi->kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $aksi->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $aksi->nama_aksi }}</td>
                        <td class="p-4">
                            <span class="inline-block px-2 py-1 rounded text-white {{ $aksi->selesai ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                            </span>
                        </td>
                        <td class="p-4">{{ $aksi->tahun }}</td>
                        @if ($tab == 'pending')
                            <td class="p-4">{{ ucfirst($aksi->status) }}</td>
                            <td class="p-4">{{ $aksi->createdBy->name ?? '-' }}</td>
                        @endif
                        <td class="p-4">
                            @if ($tab == 'pending')
                                <form action="{{ route('kecamatan.aksi_konvergensi.approve', $aksi->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:underline" onclick="return confirm('Setujui data Aksi Konvergensi ini?')">Setujui</button>
                                </form>
                                <button class="text-red-500 hover:underline" onclick="openRejectModal({{ $aksi->id }})">Tolak</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $aksiKonvergensis->links() }}
        </div>
    </div>

    <!-- Modal untuk Penolakan -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h3 class="text-lg font-semibold mb-4">Tolak Aksi Konvergensi</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Penolakan</label>
                    <textarea name="catatan" id="catatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeRejectModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            const form = document.getElementById('rejectForm');
            form.action = `{{ url('kecamatan/aksi-konvergensi') }}/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('catatan').value = '';
        }
    </script>
</body>
</html>