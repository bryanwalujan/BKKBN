<!DOCTYPE html>
<html>
<head>
    <title>Edit Pendamping Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Pendamping Keluarga</h2>
        <a href="{{ route('pendamping_keluarga.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('pendamping_keluarga.update', $pendamping->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $pendamping->nama) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    @error('nama')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="peran" class="block text-sm font-medium text-gray-700">Peran</label>
                    <select name="peran" id="peran" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="" disabled>-- Pilih Peran --</option>
                        <option value="Bidan" {{ old('peran', $pendamping->peran) == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                        <option value="Kader Posyandu" {{ old('peran', $pendamping->peran) == 'Kader Posyandu' ? 'selected' : '' }}>Kader Posyandu</option>
                        <option value="Kader Kesehatan" {{ old('peran', $pendamping->peran) == 'Kader Kesehatan' ? 'selected' : '' }}>Kader Kesehatan</option>
                        <option value="Tim Penggerak PKK" {{ old('peran', $pendamping->peran) == 'Tim Penggerak PKK' ? 'selected' : '' }}>Tim Penggerak PKK</option>
                    </select>
                    @error('peran')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $pendamping->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                    @error('kelurahan_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                    <select name="kartu_keluarga_ids[]" id="kartu_keluarga_id" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih Kartu Keluarga</option>
                    </select>
                    @error('kartu_keluarga_ids')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="" disabled>-- Pilih Status --</option>
                        <option value="Aktif" {{ old('status', $pendamping->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status', $pendamping->status) == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="tahun_bergabung" class="block text-sm font-medium text-gray-700">Tahun Bergabung</label>
                    <input type="number" name="tahun_bergabung" id="tahun_bergabung" value="{{ old('tahun_bergabung', $pendamping->tahun_bergabung) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    @error('tahun_bergabung')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto (opsional)</label>
                    @if ($pendamping->foto)
                        <img src="{{ asset('storage/' . $pendamping->foto) }}" alt="Foto {{ $pendamping->nama }}" class="w-16 h-16 object-cover rounded mb-2">
                    @endif
                    <input type="file" name="foto" id="foto" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('foto')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Aktivitas</label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="penyuluhan" id="penyuluhan" value="1" {{ old('penyuluhan', $pendamping->penyuluhan) ? 'checked' : '' }} class="mr-2">
                            <label for="penyuluhan">Penyuluhan dan Edukasi</label>
                            <input type="text" name="penyuluhan_frekuensi" id="penyuluhan_frekuensi" value="{{ old('penyuluhan_frekuensi', $pendamping->penyuluhan_frekuensi) }}" class="ml-4 block w-1/2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" placeholder="Frekuensi (misal: 2 kali/minggu)">
                            @error('penyuluhan_frekuensi')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="rujukan" id="rujukan" value="1" {{ old('rujukan', $pendamping->rujukan) ? 'checked' : '' }} class="mr-2">
                            <label for="rujukan">Memfasilitasi Pelayanan Rujukan</label>
                            <input type="text" name="rujukan_frekuensi" id="rujukan_frekuensi" value="{{ old('rujukan_frekuensi', $pendamping->rujukan_frekuensi) }}" class="ml-4 block w-1/2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" placeholder="Frekuensi (misal: 1 kali/bulan)">
                            @error('rujukan_frekuensi')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="kunjungan_krs" id="kunjungan_krs" value="1" {{ old('kunjungan_krs', $pendamping->kunjungan_krs) ? 'checked' : '' }} class="mr-2">
                            <label for="kunjungan_krs">Kunjungan Keluarga Berisiko Stunting (KRS)</label>
                            <input type="text" name="kunjungan_krs_frekuensi" id="kunjungan_krs_frekuensi" value="{{ old('kunjungan_krs_frekuensi', $pendamping->kunjungan_krs_frekuensi) }}" class="ml-4 block w-1/2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" placeholder="Frekuensi (misal: 3 kali/minggu)">
                            @error('kunjungan_krs_frekuensi')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="pendataan_bansos" id="pendataan_bansos" value="1" {{ old('pendataan_bansos', $pendamping->pendataan_bansos) ? 'checked' : '' }} class="mr-2">
                            <label for="pendataan_bansos">Pendataan dan Rekomendasi Bantuan Sosial</label>
                            <input type="text" name="pendataan_bansos_frekuensi" id="pendataan_bansos_frekuensi" value="{{ old('pendataan_bansos_frekuensi', $pendamping->pendataan_bansos_frekuensi) }}" class="ml-4 block w-1/2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" placeholder="Frekuensi (misal: 1 kali/bulan)">
                            @error('pendataan_bansos_frekuensi')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="pemantauan_kesehatan" id="pemantauan_kesehatan" value="1" {{ old('pemantauan_kesehatan', $pendamping->pemantauan_kesehatan) ? 'checked' : '' }} class="mr-2">
                            <label for="pemantauan_kesehatan">Pemantauan Kesehatan dan Perkembangan Keluarga</label>
                            <input type="text" name="pemantauan_kesehatan_frekuensi" id="pemantauan_kesehatan_frekuensi" value="{{ old('pemantauan_kesehatan_frekuensi', $pendamping->pemantauan_kesehatan_frekuensi) }}" class="ml-4 block w-1/2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" placeholder="Frekuensi (misal: 2 kali/minggu)">
                            @error('pemantauan_kesehatan_frekuensi')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for kecamatan
            $('#kecamatan_id').select2({
                placeholder: 'Pilih Kecamatan',
                allowClear: true,
                templateResult: function(data) {
                    return data.text;
                },
                templateSelection: function(data) {
                    return data.text || data.nama_kecamatan || 'Pilih Kecamatan';
                }
            });

            // Initialize Select2 for kelurahan
            $('#kelurahan_id').select2({
                placeholder: 'Pilih Kelurahan',
                allowClear: true
            });

            // Initialize Select2 for kartu keluarga
            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            // Log initial kecamatan data for debugging
            console.log('Initial kecamatan_id:', $('#kecamatan_id').val());
            console.log('Kecamatans data:', @json($kecamatans));

            // Load kelurahans for old kecamatan_id on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                loadKelurahans(initialKecamatanId, {{ old('kelurahan_id', $pendamping->kelurahan_id) ?? 'null' }});
            }

            // Update kelurahans and kartu keluarga when kecamatan changes
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                console.log('Kecamatan changed to:', kecamatanId);
                if (kecamatanId) {
                    loadKelurahans(kecamatanId, null);
                } else {
                    $('#kelurahan_id').empty();
                    $('#kelurahan_id').append('<option value="">Pilih Kelurahan</option>');
                    $('#kelurahan_id').trigger('change');
                }
                updateKartuKeluarga();
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                console.log('Kelurahan changed to:', $('#kelurahan_id').val());
                updateKartuKeluarga();
            });

            // Function to load kelurahans
            function loadKelurahans(kecamatanId, selectedKelurahanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Kelurahan loaded:', data);
                        $('#kelurahan_id').empty();
                        $('#kelurahan_id').append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == selectedKelurahanId ? 'selected' : '';
                            $('#kelurahan_id').append('<option value="' + kelurahan.id + '" ' + selected + '>' + kelurahan.nama_kelurahan + '</option>');
                        });
                        $('#kelurahan_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kelurahans:', xhr.responseText);
                        alert('Gagal memuat kelurahan: ' + (xhr.responseJSON?.error || 'Silakan coba lagi.'));
                    }
                });
            }

            // Function to update kartu keluarga
            function updateKartuKeluarga() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $('#kelurahan_id').val();
                var data = {};
                if (kecamatanId) data.kecamatan_id = kecamatanId;
                if (kelurahanId) data.kelurahan_id = kelurahanId;

                $.ajax({
                    url: '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}',
                    type: 'GET',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        console.log('Kartu keluarga loaded:', data);
                        $('#kartu_keluarga_id').empty();
                        $('#kartu_keluarga_id').append('<option value="">Pilih Kartu Keluarga</option>');
                        $.each(data, function(index, kk) {
                            var selected = {{ json_encode($pendamping->kartuKeluargas->pluck('id')->toArray()) }}.includes(kk.id) ? 'selected' : '';
                            $('#kartu_keluarga_id').append('<option value="' + kk.id + '" ' + selected + '>' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                        });
                        $('#kartu_keluarga_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr.responseText);
                        alert('Gagal memuat kartu keluarga: ' + (xhr.responseJSON?.error || 'Silakan coba lagi.'));
                    }
                });
            }

            // Load initial kartu keluarga
            updateKartuKeluarga();
        });
    </script>
</body>
</html>