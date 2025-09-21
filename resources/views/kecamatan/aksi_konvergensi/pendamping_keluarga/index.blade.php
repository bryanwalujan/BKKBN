<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Data Pendamping Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kecamatan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Verifikasi Data Pendamping Keluarga</h2>
        <div class="mb-4">
            <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending']) }}" class="inline-block px-4 py-2 {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Pending</a>
            <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => 'verified']) }}" class="inline-block px-4 py-2 {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Terverifikasi</a>
        </div>
        <form method="GET" action="{{ route('kecamatan.pendamping_keluarga.index') }}" class="mb-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama pendamping..." class="border-gray-300 rounded-md shadow-sm p-2">
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
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Peran</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tahun Bergabung</th>
                    <th class="p-4 text-left">Foto</th>
                    @if ($tab == 'pending')
                        <th class="p-4 text-left">Status Verifikasi</th>
                        <th class="p-4 text-left">Catatan</th>
                        <th class="p-4 text-left">Dibuat Oleh</th>
                    @endif
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
                        <td class="p-4">{{ $pendamping->status }}</td>
                        <td class="p-4">{{ $pendamping->tahun_bergabung }}</td>
                        <td class="p-4">
                            @if ($pendamping->foto)
                                <img src="{{ asset('storage/' . $pendamping->foto) }}" alt="Foto {{ $pendamping->nama }}" class="w-16 h-16 object-cover rounded">
                            @else
                                -
                            @endif
                        </td>
                        @if ($tab == 'pending')
                            <td class="p-4">{{ ucfirst($pendamping->status_verifikasi) }}</td>
                            <td class="p-4">{{ $pendamping->catatan ?? '-' }}</td>
                            <td class="p-4">{{ $pendamping->createdBy->name ?? '-' }}</td>
                        @endif
                        <td class="p-4">
                            @if ($pendamping->kartuKeluargas->isNotEmpty())
                                <a href="{{ route('kartu_keluarga.show', $pendamping->kartuKeluargas->first()->id) }}" class="text-green-500 hover:underline">Detail KK</a>
                            @endif
                            @if ($tab == 'pending' && $pendamping->status_verifikasi == 'pending')
                                <form action="{{ route('kecamatan.pendamping_keluarga.approve', $pendamping->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui data Pendamping Keluarga ini?')">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:underline">Setujui</button>
                                </form>
                                <button onclick="openRejectModal({{ $pendamping->id }})" class="text-red-500 hover:underline">Tolak</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $pendampingKeluargas->links() }}
        </div>
    </div>
    <!-- Modal for Reject -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h3 class="text-lg font-semibold mb-4">Tolak Data Pendamping Keluarga</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Penolakan</label>
                    <textarea name="catatan" id="catatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
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
            document.getElementById('rejectForm').action = '{{ route("kecamatan.pendamping_keluarga.reject", ":id") }}'.replace(':id', id);
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('catatan').value = '';
        }
    </script>
</body>
</html>