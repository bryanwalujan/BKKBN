<!DOCTYPE html>
<html>
<head>
    <title>Data Ibu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Ibu</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-4 flex justify-between items-center">
            <form method="GET" action="{{ route('kelurahan.ibu.index') }}" class="flex space-x-4">
                <div>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau NIK..." class="border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <div>
                    <select name="status" id="status" class="border-gray-300 rounded-md shadow-sm p-2">
                        <option value="">-- Pilih Status --</option>
                        <option value="Hamil" {{ $status == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                        <option value="Nifas" {{ $status == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                        <option value="Menyusui" {{ $status == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                        <option value="Tidak Aktif" {{ $status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search || $status)
                    <a href="{{ route('kelurahan.ibu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('kelurahan.ibu.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Data Ibu</a>
        </div>

        <p class="mt-2 text-sm text-gray-600">
            Menampilkan data ibu
            @if ($search || $status)
                ({{ $ibus->total() }} data ditemukan)
            @else
                ({{ $ibus->total() }} data)
            @endif
        </p>

        <div class="bg-white p-6 rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelurahan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kartu Keluarga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($ibus as $index => $ibu)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibus->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($ibu->foto)
                                    <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="w-16 h-16 object-cover rounded">
                                @else
                                    <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->nik ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->kartuKeluarga->no_kk ?? '-' }} - {{ $ibu->kartuKeluarga->kepala_keluarga ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->alamat ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ibu->status }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                <a href="{{ route('kelurahan.ibu.edit', $ibu->id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="showDeleteModal('{{ route('kelurahan.ibu.destroy', $ibu->id) }}', '{{ $ibu->nama }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-gray-500">Tidak ada data ibu ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $ibus->links() }}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#status').select2({
                placeholder: "-- Pilih Status --",
                allowClear: true
            });
        });

        function showDeleteModal(url, name) {
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                html: `Apakah Anda yakin ingin menghapus data ibu <strong>${name}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#facc15',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Konfirmasi Sekali Lagi',
                        html: `Data <strong>${name}</strong> akan dihapus permanen. Lanjutkan?`,
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Hapus Sekarang',
                        cancelButtonText: 'Batal'
                    }).then((secondResult) => {
                        if (secondResult.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    _method: 'DELETE'
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data ibu berhasil dihapus.',
                                        confirmButtonColor: '#3b82f6',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    let message = 'Gagal menghapus data.';
                                    if (xhr.status === 419) {
                                        message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                    } else if (xhr.status === 403) {
                                        message = 'Anda tidak memiliki izin untuk menghapus data ini.';
                                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                        message = xhr.responseJSON.message;
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: message,
                                        confirmButtonColor: '#3b82f6',
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>