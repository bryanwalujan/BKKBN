<!DOCTYPE html>
<html>
<head>
    <title>Data Bayi Baru Lahir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Bayi Baru Lahir</h2>
        <div class="mb-4 flex space-x-4">
            <form action="{{ route('kelurahan.bayi_baru_lahir.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan nama ibu, NIK, atau umur dalam kandungan" class="border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
                @if ($search)
                    <a href="{{ route('kelurahan.bayi_baru_lahir.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>
            <a href="{{ route('kelurahan.bayi_baru_lahir.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Bayi Baru Lahir</a>
            <a href="{{ route('kelurahan.ibu_nifas.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Data Ibu Nifas</a>
        </div>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if ($search)
            <p class="mt-2 text-sm text-gray-600">Menampilkan data dengan pencarian: "{{ $search }}" ({{ $bayiBaruLahirs->total() }} data)</p>
        @else
            <p class="mt-2 text-sm text-gray-600">Menampilkan semua data bayi baru lahir ({{ $bayiBaruLahirs->total() }} data)</p>
        @endif
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded border border-gray-200">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Nama Ibu</th>
                        <th class="p-4 text-left">Kelurahan</th>
                        <th class="p-4 text-left">Kecamatan</th>
                        <th class="p-4 text-left">Umur Dalam Kandungan</th>
                        <th class="p-4 text-left">Berat Badan Lahir (kg)</th>
                        <th class="p-4 text-left">Panjang Badan Lahir (cm)</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bayiBaruLahirs as $index => $bayi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $bayiBaruLahirs->firstItem() + $index }}</td>
                            <td class="p-4">{{ $bayi->ibuNifas->ibu->nama ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->ibuNifas->ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->ibuNifas->ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->umur_dalam_kandungan ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->berat_badan_lahir ?? '-' }}</td>
                            <td class="p-4">{{ $bayi->panjang_badan_lahir ?? '-' }}</td>
                            <td class="p-4 flex space-x-2">
                                <a href="{{ route('kelurahan.bayi_baru_lahir.edit', $bayi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <button type="button" class="text-red-500 hover:underline" onclick="showDeleteModal('{{ route('kelurahan.bayi_baru_lahir.destroy', $bayi->id) }}', '{{ $bayi->ibuNifas->ibu->nama ?? 'Bayi' }}')">Hapus</button>
                                <button type="button" class="text-green-500 hover:underline" onclick="showMoveToBalitaModal('{{ route('kelurahan.bayi_baru_lahir.moveToBalita', $bayi->id) }}', '{{ $bayi->ibuNifas->ibu->nama ?? 'Bayi' }}')">Tambah ke Balita</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">Tidak ada data bayi baru lahir ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $bayiBaruLahirs->links() }}
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        function showDeleteModal(url, name) {
            Swal.fire({
                title: 'Hapus Data Bayi?',
                text: `Apakah Anda yakin ingin menghapus data bayi baru lahir untuk ibu ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Konfirmasi Ulang',
                        text: 'Data akan dihapus permanen. Lanjutkan?',
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
                                method: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data bayi baru lahir berhasil dihapus.',
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

        function showMoveToBalitaModal(url, name) {
            Swal.fire({
                title: 'Pindahkan ke Balita?',
                text: `Apakah Anda yakin ingin memindahkan data bayi untuk ibu ${name} ke tabel balita?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Pindahkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Konfirmasi Ulang',
                        text: 'Data akan dipindahkan ke tabel balita dan dihapus dari bayi baru lahir. Lanjutkan?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#22c55e',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Pindahkan Sekarang',
                        cancelButtonText: 'Batal'
                    }).then((secondResult) => {
                        if (secondResult.isConfirmed) {
                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data bayi berhasil dipindahkan ke tabel balita.',
                                        confirmButtonColor: '#3b82f6',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                },
                                error: function(xhr) {
                                    let message = 'Gagal memindahkan data.';
                                    if (xhr.status === 419) {
                                        message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                    } else if (xhr.status === 403) {
                                        message = 'Anda tidak memiliki izin untuk memindahkan data ini.';
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