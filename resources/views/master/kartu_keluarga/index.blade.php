<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kartu Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Kelola Kartu Keluarga</h2>
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
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('kartu_keluarga.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Kartu Keluarga</a>
        </div>
        <div class="mb-4 flex space-x-4">
            <form action="{{ route('kartu_keluarga.index') }}" method="GET" class="flex space-x-2">
                <select name="kecamatan_id" id="kecamatan_id" class="border-gray-300 rounded-md shadow-sm p-2">
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                <select name="kelurahan_id" id="kelurahan_id" class="border-gray-300 rounded-md shadow-sm p-2">
                    <option value="">Pilih Kelurahan</option>
                </select>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan No KK atau Kepala Keluarga" class="border-gray-300 rounded-md shadow-sm p-2 w-64">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Filter</button>
                @if ($kecamatan_id || $kelurahan_id || $search)
                    <a href="{{ route('kartu_keluarga.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
        </div>
        @if ($kecamatan_id || $kelurahan_id || $search)
            <p class="mt-2 text-sm text-gray-600">
                Menampilkan data
                @if ($kecamatan_id)
                    untuk kecamatan: {{ $kecamatans->find($kecamatan_id)->nama_kecamatan ?? '-' }}
                @endif
                @if ($kelurahan_id)
                    dan kelurahan: {{ \App\Models\Kelurahan::find($kelurahan_id)->nama_kelurahan ?? '-' }}
                @endif
                @if ($search)
                    dengan pencarian: "{{ $search }}"
                @endif
                ({{ $kartuKeluargas->total() }} data)
            </p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data kartu keluarga ({{ $kartuKeluargas->total() }} data)</p>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">No KK</th>
                    <th class="p-4 text-left">Kepala Keluarga</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Alamat</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Jumlah Balita</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kartuKeluargas as $index => $kartuKeluarga)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $kartuKeluargas->firstItem() + $index }}</td>
                        <td class="p-4">
                            <a href="{{ route('kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-500 hover:underline">{{ $kartuKeluarga->no_kk }}</a>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-500 hover:underline">{{ $kartuKeluarga->kepala_keluarga }}</a>
                        </td>
                        <td class="p-4">{{ $kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                        <td class="p-4">{{ $kartuKeluarga->kelurahan->nama_kelurahan ?? '-' }}</td>
                        <td class="p-4">{{ $kartuKeluarga->alamat ?? '-' }}</td>
                        <td class="p-4">{{ $kartuKeluarga->status }}</td>
                        <td class="p-4">{{ $kartuKeluarga->balitas_count }}</td>
                        <td class="p-4">
                            <a href="{{ route('kartu_keluarga.show', $kartuKeluarga->id) }}" class="text-blue-500 hover:underline">Detail</a>
                            <a href="{{ route('kartu_keluarga.edit', $kartuKeluarga->id) }}" class="text-blue-500 hover:underline ml-2">Edit</a>
                            <button type="button" class="text-red-500 hover:underline ml-2" onclick="showDeleteModal('{{ route('kartu_keluarga.destroy', $kartuKeluarga->id) }}', '{{ $kartuKeluarga->no_kk }}')">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-4 text-center">Tidak ada data kartu keluarga yang sesuai dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kartuKeluargas->links() }}
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-semibold mb-4">Konfirmasi Penghapusan</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus kartu keluarga <span id="deleteName" class="font-bold"></span>?</p>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kecamatan_id').select2({
                placeholder: 'Pilih Kecamatan',
                allowClear: true
            });

            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true
            });

            // Load kelurahans for selected kecamatan on page load
            var initialKecamatanId = '{{ $kecamatan_id ?? '' }}';
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty();
                        $('#kelurahan_id').append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == '{{ $kelurahan_id ?? '' }}' ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr);
                        alert('Gagal memuat kelurahan. Silakan coba lagi.');
                    }
                });
            }

            // Update kelurahans when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#kelurahan_id').empty();
                            $('#kelurahan_id').append('<option value="">Pilih Kelurahan</option>');
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahans:', xhr);
                            alert('Gagal memuat kelurahan. Silakan coba lagi.');
                        }
                    });
                } else {
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">Pilih Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
            });

            // Delete modal
            function showDeleteModal(url, name) {
                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteName').textContent = name;
                document.getElementById('deleteForm').action = url;
            }

            document.getElementById('cancelDelete').addEventListener('click', function() {
                document.getElementById('deleteModal').classList.add('hidden');
            });
        });
    </script>
</body>
</html> 