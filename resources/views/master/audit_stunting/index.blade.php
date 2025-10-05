<!DOCTYPE html>
<html>
<head>
    <title>Data Audit Stunting</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Audit Stunting</h2>
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
        <form method="GET" action="{{ route('audit_stunting.index') }}" class="mb-6 bg-white p-4 rounded shadow">
            <div class="flex space-x-4">
                <div class="w-1/3">
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-1/3">
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ $kelurahan_id == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-1/3">
                    <label for="search" class="block text-sm font-medium text-gray-700">Cari Nama</label>
                    <input type="text" name="search" id="search" value="{{ $search }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Cari nama...">
                </div>
            </div>
            <div class="mt-4 flex space-x-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                <a href="{{ route('audit_stunting.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Data</a>
            </div>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diunggah Oleh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
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
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->laporan ? Str::limit($audit->laporan, 50) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->narasi ? Str::limit($audit->narasi, 50) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->createdBy ? $audit->createdBy->name : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $audit->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('audit_stunting.show', $audit->id) }}" class="text-green-600 hover:text-green-900">Detail</a>
                                <a href="{{ route('audit_stunting.edit', $audit->id) }}" class="text-blue-600 hover:text-blue-900 ml-2">Edit</a>
                                <button type="button" onclick="openDeleteModal({{ $audit->id }})" class="text-red-600 hover:text-red-900 ml-2">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $auditStuntings->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white p-6 rounded shadow-lg w-1/3">
                <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
                <p>Apakah Anda yakin ingin menghapus data audit stunting ini?</p>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Ketik "HAPUS" untuk konfirmasi:</label>
                    <input type="text" id="deleteConfirm" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" oninput="checkDeleteConfirm()">
                </div>
                <form id="deleteForm" method="POST" class="mt-4 flex justify-end space-x-2">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</button>
                    <button type="submit" id="deleteSubmit" disabled class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 disabled:bg-gray-300">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">Semua Kelurahan</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr.responseText);
                            alert('Gagal memuat kelurahan. Silakan coba lagi.');
                        }
                    });
                } else {
                    $('#kelurahan_id').empty().append('<option value="">Semua Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
            });

            function openDeleteModal(id) {
                const modal = document.getElementById('deleteModal');
                const form = document.getElementById('deleteForm');
                form.action = `{{ url('audit_stunting') }}/${id}`;
                modal.classList.remove('hidden');
                document.getElementById('deleteConfirm').value = '';
                document.getElementById('deleteSubmit').disabled = true;
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            function checkDeleteConfirm() {
                const input = document.getElementById('deleteConfirm').value;
                document.getElementById('deleteSubmit').disabled = input !== 'HAPUS';
            }
        });
    </script>
</body>
</html>