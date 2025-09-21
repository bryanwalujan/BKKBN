<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Data Audit Stunting</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kecamatan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Verifikasi Data Audit Stunting</h2>
        <div class="mb-4">
            <a href="{{ route('kecamatan.audit_stunting.index', ['tab' => 'pending']) }}" class="inline-block px-4 py-2 {{ $tab == 'pending' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Pending</a>
            <a href="{{ route('kecamatan.audit_stunting.index', ['tab' => 'verified']) }}" class="inline-block px-4 py-2 {{ $tab == 'verified' ? 'bg-blue-500 text-white' : 'bg-gray-200' }} rounded">Terverifikasi</a>
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
        <form method="GET" action="{{ route('kecamatan.audit_stunting.index') }}" class="mb-6 bg-white p-4 rounded shadow">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <input type="text" value="{{ $kecamatan->nama_kecamatan ?? '-' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" readonly>
                </div>
                <div class="w-1/2">
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
        </form>
        <div class="bg-white p-6 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Target</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kecamatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelurahan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pihak Pengaudit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Narasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengaudit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        @if ($tab == 'pending')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Verifikasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diajukan Oleh</th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($auditStuntings as $audit)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->dataMonitoring->nama ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->dataMonitoring->target ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->dataMonitoring->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->dataMonitoring->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->pihak_pengaudit ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->laporan ? \Illuminate\Support\Str::limit($audit->laporan, 50) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->narasi ? \Illuminate\Support\Str::limit($audit->narasi, 50) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->created_at->format('d/m/Y') }}</td>
                            @if ($tab == 'pending')
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($audit->status_verifikasi) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $audit->catatan ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $audit->createdBy->name ?? '-' }}</td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($tab == 'pending' && $audit->status_verifikasi == 'pending')
                                    <form action="{{ route('kecamatan.audit_stunting.approve', $audit->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-2" onclick="return confirm('Apakah Anda yakin ingin menyetujui data ini?')">Setujui</button>
                                    </form>
                                    <button class="text-red-600 hover:text-red-900" onclick="openRejectModal({{ $audit->id }})">Tolak</button>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $auditStuntings->links() }}
            </div>
        </div>
    </div>

    <!-- Modal untuk Penolakan -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-lg w-1/3">
            <h3 class="text-lg font-semibold mb-4">Tolak Data Audit Stunting</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Penolakan</label>
                    <textarea name="catatan" id="catatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeRejectModal()" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Batal</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kelurahan_id').select2({ placeholder: 'Semua Kelurahan', allowClear: true });
        });

        function openRejectModal(id) {
            $('#rejectForm').attr('action', '{{ url("kecamatan/audit_stunting") }}/' + id + '/reject');
            $('#rejectModal').removeClass('hidden');
        }

        function closeRejectModal() {
            $('#rejectModal').addClass('hidden');
            $('#catatan').val('');
        }
    </script>
</body>
</html>