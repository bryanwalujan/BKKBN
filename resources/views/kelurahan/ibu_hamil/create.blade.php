<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Ibu Hamil</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Ibu Hamil</h2>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ session('warning') }}
            </div>
        @endif
        @if ($ibus->isEmpty())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                Tidak ada data ibu dengan status Hamil. Silakan tambahkan <a href="{{ route('kelurahan.ibu.create') }}" class="text-blue-600 hover:underline">data ibu</a> terlebih dahulu.
            </div>
        @else
            <form id="createIbuHamilForm" action="{{ route('kelurahan.ibu_hamil.store') }}" method="POST" class="bg-white p-6 rounded shadow">
                @csrf
                <div class="mb-4">
                    <label for="ibu_id" class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                    <select name="ibu_id" id="ibu_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Ibu --</option>
                        @foreach ($ibus as $ibu)
                            <option value="{{ $ibu->id }}" {{ old('ibu_id') == $ibu->id ? 'selected' : '' }}>{{ $ibu->nama }} ({{ $ibu->nik ?? '-' }})</option>
                        @endforeach
                    </select>
                    @error('ibu_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="trimester" class="block text-sm font-medium text-gray-700">Trimester</label>
                    <select name="trimester" id="trimester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('trimester') == '' ? 'selected' : '' }}>-- Pilih Trimester --</option>
                        <option value="Trimester 1" {{ old('trimester') == 'Trimester 1' ? 'selected' : '' }}>Trimester 1</option>
                        <option value="Trimester 2" {{ old('trimester') == 'Trimester 2' ? 'selected' : '' }}>Trimester 2</option>
                        <option value="Trimester 3" {{ old('trimester') == 'Trimester 3' ? 'selected' : '' }}>Trimester 3</option>
                    </select>
                    @error('trimester')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="intervensi" class="block text-sm font-medium text-gray-700">Intervensi</label>
                    <select name="intervensi" id="intervensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('intervensi') == '' ? 'selected' : '' }}>-- Pilih Intervensi --</option>
                        <option value="Tidak Ada" {{ old('intervensi') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                        <option value="Gizi" {{ old('intervensi') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                        <option value="Konsultasi Medis" {{ old('intervensi') == 'Konsultasi Medis' ? 'selected' : '' }}>Konsultasi Medis</option>
                        <option value="Lainnya" {{ old('intervensi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('intervensi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="status_gizi" class="block text-sm font-medium text-gray-700">Status Gizi</label>
                    <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('status_gizi') == '' ? 'selected' : '' }}>-- Pilih Status Gizi --</option>
                        <option value="Normal" {{ old('status_gizi') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Kurang Gizi" {{ old('status_gizi') == 'Kurang Gizi' ? 'selected' : '' }}>Kurang Gizi</option>
                        <option value="Berisiko" {{ old('status_gizi') == 'Berisiko' ? 'selected' : '' }}>Berisiko</option>
                    </select>
                    @error('status_gizi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="warna_status_gizi" class="block text-sm font-medium text-gray-700">Warna Status Gizi</label>
                    <select name="warna_status_gizi" id="warna_status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="" {{ old('warna_status_gizi') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                        <option value="Sehat" {{ old('warna_status_gizi') == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Waspada" {{ old('warna_status_gizi') == 'Waspada' ? 'selected' : '' }}>Waspada</option>
                        <option value="Bahaya" {{ old('warna_status_gizi') == 'Bahaya' ? 'selected' : '' }}>Bahaya</option>
                    </select>
                    @error('warna_status_gizi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="usia_kehamilan" class="block text-sm font-medium text-gray-700">Usia Kehamilan (minggu)</label>
                    <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ old('usia_kehamilan') }}" min="0" max="40" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('usia_kehamilan')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="berat" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                    <input type="number" name="berat" id="berat" value="{{ old('berat') }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('berat')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tinggi" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                    <input type="number" name="tinggi" id="tinggi" value="{{ old('tinggi') }}" step="0.1" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('tinggi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    <a href="{{ route('kelurahan.ibu_hamil.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                </div>
            </form>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#ibu_id, #trimester, #intervensi, #status_gizi, #warna_status_gizi').select2({
                placeholder: function() {
                    return $(this).attr('data-placeholder') || $(this).find('option:first').text();
                },
                allowClear: true
            });

            // SweetAlert2 confirmation for form submission
            $('#createIbuHamilForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                Swal.fire({
                    title: 'Simpan Data?',
                    text: 'Apakah Anda yakin ingin menyimpan data ibu hamil ini?',
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
                                    text: 'Data ibu hamil berhasil ditambahkan.',
                                    confirmButtonColor: '#3b82f6',
                                }).then(() => {
                                    window.location.href = '{{ route("kelurahan.ibu_hamil.index") }}';
                                });
                            },
                            error: function(xhr) {
                                let message = 'Gagal menambahkan data.';
                                if (xhr.status === 419) {
                                    message = 'Sesi Anda telah kedaluwarsa. Silakan muat ulang halaman.';
                                } else if (xhr.status === 403) {
                                    message = 'Anda tidak memiliki izin untuk menambahkan data ini.';
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