<!DOCTYPE html>
<html>
<head>
    <title>Data Kartu Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kartu Keluarga</h2>
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
        <div class="mb-4 flex justify-between">
            <div>
                <a href="{{ route('kelurahan.kartu_keluarga.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Kartu Keluarga</a>
            </div>
            <form method="GET" action="{{ route('kelurahan.kartu_keluarga.index') }}" class="flex space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nomor KK atau kepala keluarga" class="border p-2 rounded">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
            </form>
        </div>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Nomor KK</th>
                    <th class="p-4 text-left">Kepala Keluarga</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Alamat</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Diupload Oleh</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kartuKeluargas as $kk)
                    <tr>
                        <td class="p-4">{{ $kk->no_kk }}</td>
                        <td class="p-4">{{ $kk->kepala_keluarga }}</td>
                        <td class="p-4">{{ $kk->kecamatan->nama_kecamatan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $kk->kelurahan->nama_kelurahan ?? 'Tidak diketahui' }}</td>
                        <td class="p-4">{{ $kk->alamat ?? 'Tidak ada' }}</td>
                        <td class="p-4">{{ $kk->status }}</td>
                        <td class="p-4">{{ $kk->createdBy->name ?? 'Tidak diketahui' }}</td>
                        <td class="p-4 flex space-x-2">
                            <a href="{{ route('kelurahan.kartu_keluarga.show', $kk->id) }}" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Detail</a>
                            <a href="{{ route('kelurahan.kartu_keluarga.edit', $kk->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Edit</a>
                            <form action="{{ route('kelurahan.kartu_keluarga.destroy', $kk->id) }}" method="POST" class="delete-form inline" data-id="{{ $kk->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-4 text-center text-gray-500">Tidak ada data kartu keluarga.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $kartuKeluargas->links() }}
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const id = form.data('id');
                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Data ini akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: form.serialize(),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus.',
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
            });
        });
    </script>
</body>
</html>