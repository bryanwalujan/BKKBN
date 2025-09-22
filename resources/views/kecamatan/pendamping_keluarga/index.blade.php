<!DOCTYPE html>
<html>
<head>
    <title>Data Pendamping Keluarga - Admin Kecamatan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .tabs { display: flex; border-bottom: 1px solid #e5e7eb; margin-bottom: 1rem; }
        .tab { padding: 8px 16px; cursor: pointer; font-weight: bold; color: #4b5563; }
        .tab.active { color: #2563eb; border-bottom: 2px solid #2563eb; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; }
        .modal-content { background: white; margin: 15% auto; padding: 20px; border-radius: 8px; width: 90%; max-width: 500px; }
        .foto-preview { max-width: 100px; max-height: 100px; object-fit: cover; }
    </style>
</head>
<body class="bg-gray-100">
    @include('kecamatan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Pendamping Keluarga - {{ $kecamatan->nama_kecamatan ?? 'Kecamatan' }}</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error') || isset($errorMessage))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') ?? $errorMessage }}
            </div>
        @endif

        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => 'pending']) }}" class="tab {{ $tab === 'pending' ? 'active' : '' }}">Pending</a>
            <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => 'verified']) }}" class="tab {{ $tab === 'verified' ? 'active' : '' }}">Terverifikasi</a>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('kecamatan.pendamping_keluarga.index') }}" method="GET" class="flex flex-wrap gap-4 mb-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="w-full sm:w-auto">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                    <option value="">Semua Kelurahan</option>
                    @foreach ($kelurahans as $kelurahan)
                        <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="peran" class="block text-sm font-medium text-gray-700 mb-1">Peran</label>
                <select name="peran" id="peran" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                    <option value="">Semua Peran</option>
                    @foreach ($peranOptions as $p)
                        <option value="{{ $p }}" {{ $peran == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                    <option value="">Semua Status</option>
                    @foreach ($statusOptions as $s)
                        <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end w-full sm:w-auto">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                <a href="{{ route('kecamatan.pendamping_keluarga.index', ['tab' => $tab]) }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
            </div>
        </form>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelurahan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun Bergabung</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KK Ditangani</th>
                        @if ($tab === 'pending')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($pendampingKeluargas as $pendamping)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pendamping->nama ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pendamping->peran ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pendamping->status ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $pendamping->tahun_bergabung ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($pendamping->kartuKeluargas->isNotEmpty())
                                    {{ $pendamping->kartuKeluargas->count() }} KK
                                    <ul class="list-disc list-inside">
                                        @foreach ($pendamping->kartuKeluargas->take(3) as $kk)
                                            <li>{{ $kk->no_kk }} ({{ $kk->kepala_keluarga }})</li>
                                        @endforeach
                                        @if ($pendamping->kartuKeluargas->count() > 3)
                                            <li>...</li>
                                        @endif
                                    </ul>
                                @else
                                    Tidak ada
                                @endif
                            </td>
                            @if ($tab === 'pending')
                                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                    <button type="button" onclick="openRejectModal({{ $pendamping->id }})" class="text-red-500 hover:underline">Tolak</button>
                                    <form action="{{ route('kecamatan.pendamping_keluarga.approve', $pendamping->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui data ini?');">
                                        @csrf
                                        <button type="submit" class="text-green-500 hover:underline">Setujui</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $tab === 'pending' ? 7 : 6 }}" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data pendamping keluarga untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $pendampingKeluargas->appends(['tab' => $tab, 'kelurahan_id' => $kelurahan_id, 'peran' => $peran, 'status' => $status])->links() }}
        </div>

        <!-- Modal for Reject -->
        <div id="rejectModal" class="modal">
            <div class="modal-content">
                <h3 class="text-lg font-semibold mb-4">Tolak Data Pendamping Keluarga</h3>
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-4">
                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Penolakan</label>
                        <textarea id="catatan" name="catatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeRejectModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            const form = document.getElementById('rejectForm');
            form.action = `{{ url('kecamatan/pendamping-keluarga') }}/${id}/reject`;
            document.getElementById('rejectModal').style.display = 'block';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
            document.getElementById('catatan').value = '';
        }

        // Log data untuk debugging
        console.log('Pendamping Keluargas:', @json($pendampingKeluargas->items()));
        @foreach ($pendampingKeluargas as $pendamping)
            console.log(`ID: {{ $pendamping->id }}, Nama: {{ $pendamping->nama ?? '-' }}, Peran: {{ $pendamping->peran ?? '-' }}, Status: {{ $pendamping->status ?? '-' }}`);
        @endforeach
    </script>
</body>
</html>