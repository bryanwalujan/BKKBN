<!DOCTYPE html>
<html>
<head>
    <title>Data Balita</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Balita</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <div class="mb-4 flex justify-between">
            <a href="{{ route('kelurahan.balita.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Balita</a>
            <form method="GET" action="{{ route('kelurahan.balita.index') }}" class="flex space-x-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIK" class="border p-2 rounded">
                <select name="kategori_umur" class="border p-2 rounded">
                    <option value="">Semua Kategori Umur</option>
                    <option value="Baduata" {{ $kategoriUmur == 'Baduata' ? 'selected' : '' }}>Baduata</option>
                    <option value="Balita" {{ $kategoriUmur == 'Balita' ? 'selected' : '' }}>Balita</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-4 text-left">No KK</th>
                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">NIK</th>
                        <th class="p-4 text-left">Usia</th>
                        <th class="p-4 text-left">Tanggal Lahir</th>
                        <th class="p-4 text-left">Jenis Kelamin</th>
                        <th class="p-4 text-left">Berat (kg)</th>
                        <th class="p-4 text-left">Tinggi (cm)</th>
                        <th class="p-4 text-left">Lingkar Kepala (cm)</th>
                        <th class="p-4 text-left">Lingkar Lengan (cm)</th>
                        <th class="p-4 text-left">Alamat</th>
                        <th class="p-4 text-left">Kecamatan</th>
                        <th class="p-4 text-left">Kelurahan</th>
                        <th class="p-4 text-left">Status Gizi</th>
                        <th class="p-4 text-left">Warna Label</th>
                        <th class="p-4 text-left">Status Pemantauan</th>
                        <th class="p-4 text-left">Foto</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($balitas as $balita)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $balita->kartuKeluarga->no_kk ?? 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->nama }}</td>
                            <td class="p-4">{{ $balita->nik ?? 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->usia ? $balita->usia . ' bulan (' . $balita->kategoriUmur . ')' : 'Tidak Diketahui' }}</td>
                            <td class="p-4">{{ $balita->tanggal_lahir ? \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d/m/Y') : 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->jenis_kelamin }}</td>
                            <td class="p-4">
                                @php
                                    $beratTinggi = explode('/', $balita->berat_tinggi ?? '0/0');
                                    $berat = $beratTinggi[0];
                                    $tinggi = $beratTinggi[1] ?? '0';
                                @endphp
                                {{ $berat }}
                            </td>
                            <td class="p-4">{{ $tinggi }}</td>
                            <td class="p-4">{{ $balita->lingkar_kepala ?? 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->lingkar_lengan ?? 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->alamat ?? 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->kecamatan->nama_kecamatan ?? 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->kelurahan->nama_kelurahan ?? 'Tidak ada' }}</td>
                            <td class="p-4">{{ $balita->status_gizi }}</td>
                            <td class="p-4">{{ $balita->warna_label }}</td>
                            <td class="p-4">{{ $balita->status_pemantauan ?? 'Tidak ada' }}</td>
                            <td class="p-4">
                                @if ($balita->foto)
                                    <a href="{{ Storage::url($balita->foto) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                                @else
                                    Tidak ada
                                @endif
                            </td>
                            <td class="p-4">
                                <a href="{{ route('kelurahan.balita.edit', $balita->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Edit</a>
                                <form action="{{ route('kelurahan.balita.destroy', $balita->id) }}" method="POST" class="delete-form inline" data-id="{{ $balita->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $balitas->links() }}
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