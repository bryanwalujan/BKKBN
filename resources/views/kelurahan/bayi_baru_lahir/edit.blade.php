<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Bayi Baru Lahir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Bayi Baru Lahir</h2>
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
        @if ($ibuNifas->isEmpty())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                Tidak ada data ibu nifas. Silakan tambahkan <a href="{{ route('kelurahan.ibu_nifas.create') }}" class="text-blue-600 hover:underline">data ibu nifas</a> terlebih dahulu.
            </div>
        @else
            <form id="editBayiBaruLahirForm" action="{{ route('kelurahan.bayi_baru_lahir.update', $bayiBaruLahir->id) }}" method="POST" class="bg-white p-6 rounded shadow">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="ibu_nifas_id" class="block text-sm font-medium text-gray-700">Nama Ibu Nifas</label>
                    <select name="ibu_nifas_id" id="ibu_nifas_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Ibu Nifas --</option>
                        @foreach ($ibuNifas as $ibu)
                            <option value="{{ $ibu->id }}" {{ old('ibu_nifas_id', $bayiBaruLahir->ibu_nifas_id) == $ibu->id ? 'selected' : '' }}>{{ $ibu->ibu->nama }} ({{ $ibu->ibu->nik ?? '-' }})</option>
                        @endforeach
                    </select>
                    @error('ibu_nifas_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="umur_dalam_kandungan" class="block text-sm font-medium text-gray-700">Umur Dalam Kandungan</label>
                    <input type="text" name="umur_dalam_kandungan" id="umur_dalam_kandungan" value="{{ old('umur_dalam_kandungan', $bayiBaruLahir->umur_dalam_kandungan) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('umur_dalam_kandungan')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="berat_badan_lahir" class="block text-sm font-medium text-gray-700">Berat Badan Lahir (kg)</label>
                    <input type="text" name="berat_badan_lahir" id="berat_badan_lahir" value="{{ old('berat_badan_lahir', $bayiBaruLahir->berat_badan_lahir) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('berat_badan_lahir')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="panjang_badan_lahir" class="block text-sm font-medium text-gray-700">Panjang Badan Lahir (cm)</label>
                    <input type="text" name="panjang_badan_lahir" id="panjang_badan_lahir" value="{{ old('panjang_badan_lahir', $bayiBaruLahir->panjang_badan_lahir) }}" maxlength="255" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('panjang_badan_lahir')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    <a href="{{ route('kelurahan.bayi_baru_lahir.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                </div>
            </form>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ibu_nifas_id').select2({
                placeholder: '-- Pilih Ibu Nifas --',
                allowClear: true
            });

            $('#editBayiBaruLahirForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan data bayi baru lahir ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3b82f6',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            method: 'POST',
                            data: new FormData(form[0]),
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data bayi baru lahir berhasil diperbarui.',
                                    confirmButtonColor: '#3b82f6',
                                }).then(() => {
                                    window.location.href = '{{ route("kelurahan.bayi_baru_lahir.index") }}';
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal memperbarui data.';
                                if (xhr.status === 419) {
                                    message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                } else if (xhr.status === 403) {
                                    message = 'Anda tidak memiliki izin untuk memperbarui data ini.';
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