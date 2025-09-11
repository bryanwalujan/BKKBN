<!DOCTYPE html>
<html>
<head>
    <title>Tambah Aksi Konvergensi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        /* Mengatur warna teks menjadi hitam untuk semua elemen dropdown */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #000 !important; /* Warna teks hitam */
        }
        
        /* Untuk opsi-opsi di dropdown */
        .select2-container--default .select2-results__option {
            color: #000; /* Warna teks hitam */
        }
        
        /* Untuk placeholder */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #000; /* Warna teks hitam */
        }
        
        /* Untuk dropdown yang sudah dipilih */
        .select2-container--default .select2-selection--single {
            color: #000; /* Warna teks hitam */
        }
        
        /* Style tambahan untuk memastikan konsistensi */
        select, option {
            color: #000 !important; /* Warna teks hitam */
        }
        
        /* Untuk browser tertentu yang mungkin override warna */
        select option:checked,
        select option:hover {
            color: #000 !important; /* Warna teks hitam */
        }
    </style>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Aksi Konvergensi</h2>
        <form action="{{ route('aksi_konvergensi.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kelurahan</option>
                </select>
                @error('kelurahan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                    <option value="">Pilih Kartu Keluarga</option>
                </select>
                @error('kartu_keluarga_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nama_aksi" class="block text-sm font-medium text-gray-700">Nama Aksi</label>
                <input type="text" name="nama_aksi" id="nama_aksi" value="{{ old('nama_aksi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('nama_aksi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="selesai" class="block text-sm font-medium text-gray-700">Selesai</label>
                <input type="checkbox" name="selesai" id="selesai" value="1" {{ old('selesai') ? 'checked' : '' }} class="mt-1">
                @error('selesai')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ old('tahun') }}" min="2020" max="2030" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                @error('tahun')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                <textarea name="narasi" id="narasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('narasi') }}</textarea>
                @error('narasi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pelaku_aksi" class="block text-sm font-medium text-gray-700">Pelaku Aksi</label>
                <input type="text" name="pelaku_aksi" id="pelaku_aksi" value="{{ old('pelaku_aksi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                @error('pelaku_aksi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700">Waktu Pelaksanaan</label>
                <input type="datetime-local" name="waktu_pelaksanaan" id="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                @error('waktu_pelaksanaan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto" class="mt-1 block w-full" accept="image/*">
                @error('foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Intervensi Sensitif</h3>
                <div class="mt-2">
                    <label for="air_bersih_sanitasi" class="block text-sm font-medium text-gray-700">Ketersediaan Air Bersih dan Sanitasi</label>
                    <select name="air_bersih_sanitasi" id="air_bersih_sanitasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada-baik" {{ old('air_bersih_sanitasi') == 'ada-baik' ? 'selected' : '' }}>Ada - Baik</option>
                        <option value="ada-buruk" {{ old('air_bersih_sanitasi') == 'ada-buruk' ? 'selected' : '' }}>Ada - Buruk</option>
                        <option value="tidak" {{ old('air_bersih_sanitasi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('air_bersih_sanitasi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="akses_layanan_kesehatan_kb" class="block text-sm font-medium text-gray-700">Ketersediaan Akses ke Layanan Kesehatan dan Keluarga Berencana (KB)</label>
                    <select name="akses_layanan_kesehatan_kb" id="akses_layanan_kesehatan_kb" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('akses_layanan_kesehatan_kb') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('akses_layanan_kesehatan_kb') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('akses_layanan_kesehatan_kb')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="pendidikan_pengasuhan_ortu" class="block text-sm font-medium text-gray-700">Pendidikan Pengasuhan pada Orang Tua</label>
                    <select name="pendidikan_pengasuhan_ortu" id="pendidikan_pengasuhan_ortu" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('pendidikan_pengasuhan_ortu') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('pendidikan_pengasuhan_ortu') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('pendidikan_pengasuhan_ortu')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="edukasi_kesehatan_remaja" class="block text-sm font-medium text-gray-700">Edukasi Kesehatan Seksual dan Reproduksi serta Gizi pada Remaja</label>
                    <select name="edukasi_kesehatan_remaja" id="edukasi_kesehatan_remaja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('edukasi_kesehatan_remaja') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('edukasi_kesehatan_remaja') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('edukasi_kesehatan_remaja')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="kesadaran_pengasuhan_gizi" class="block text-sm font-medium text-gray-700">Peningkatan Kesadaran Pengasuhan dan Gizi</label>
                    <select name="kesadaran_pengasuhan_gizi" id="kesadaran_pengasuhan_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('kesadaran_pengasuhan_gizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('kesadaran_pengasuhan_gizi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('kesadaran_pengasuhan_gizi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="akses_pangan_bergizi" class="block text-sm font-medium text-gray-700">Peningkatan Akses Pangan Bergizi</label>
                    <select name="akses_pangan_bergizi" id="akses_pangan_bergizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('akses_pangan_bergizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('akses_pangan_bergizi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('akses_pangan_bergizi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Intervensi Spesifik</h3>
                <div class="mt-2">
                    <label for="makanan_ibu_hamil" class="block text-sm font-medium text-gray-700">Pemberian Makanan pada Ibu Hamil</label>
                    <select name="makanan_ibu_hamil" id="makanan_ibu_hamil" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('makanan_ibu_hamil') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('makanan_ibu_hamil') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('makanan_ibu_hamil')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="tablet_tambah_darah" class="block text-sm font-medium text-gray-700">Konsumsi Tablet Tambah Darah bagi Ibu Hamil dan Remaja Putri</label>
                    <select name="tablet_tambah_darah" id="tablet_tambah_darah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('tablet_tambah_darah') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('tablet_tambah_darah') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('tablet_tambah_darah')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="inisiasi_menyusui_dini" class="block text-sm font-medium text-gray-700">Inisiasi Menyusui Dini (IMD)</label>
                    <select name="inisiasi_menyusui_dini" id="inisiasi_menyusui_dini" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('inisiasi_menyusui_dini') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('inisiasi_menyusui_dini') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('inisiasi_menyusui_dini')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="asi_eksklusif" class="block text-sm font-medium text-gray-700">Pemberian ASI Eksklusif</label>
                    <select name="asi_eksklusif" id="asi_eksklusif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('asi_eksklusif') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('asi_eksklusif') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('asi_eksklusif')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="asi_mpasi" class="block text-sm font-medium text-gray-700">Pemberian ASI Didampingi oleh Pemberian MPASI pada Usia 6-24 Bulan</label>
                    <select name="asi_mpasi" id="asi_mpasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('asi_mpasi') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('asi_mpasi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('asi_mpasi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="imunisasi_lengkap" class="block text-sm font-medium text-gray-700">Pemberian Imunisasi Lengkap pada Anak</label>
                    <select name="imunisasi_lengkap" id="imunisasi_lengkap" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('imunisasi_lengkap') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('imunisasi_lengkap') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('imunisasi_lengkap')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="pencegahan_infeksi" class="block text-sm font-medium text-gray-700">Pencegahan Infeksi</label>
                    <select name="pencegahan_infeksi" id="pencegahan_infeksi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="ada" {{ old('pencegahan_infeksi') == 'ada' ? 'selected' : '' }}>Ada</option>
                        <option value="tidak" {{ old('pencegahan_infeksi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('pencegahan_infeksi')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="status_gizi_ibu" class="block text-sm font-medium text-gray-700">Status Gizi Ibu</label>
                    <select name="status_gizi_ibu" id="status_gizi_ibu" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="baik" {{ old('status_gizi_ibu') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="buruk" {{ old('status_gizi_ibu') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                    </select>
                    @error('status_gizi_ibu')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="penyakit_menular" class="block text-sm font-medium text-gray-700">Penyakit Menular</label>
                    <select name="penyakit_menular" id="penyakit_menular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="tidak" {{ old('penyakit_menular') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                        <option value="ada" {{ old('penyakit_menular') == 'ada' ? 'selected' : '' }}>Ada</option>
                    </select>
                    @error('penyakit_menular')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2" id="jenis_penyakit_container" style="display: {{ old('penyakit_menular') == 'ada' ? 'block' : 'none' }};">
                    <label for="jenis_penyakit" class="block text-sm font-medium text-gray-700">Jenis Penyakit</label>
                    <input type="text" name="jenis_penyakit" id="jenis_penyakit" value="{{ old('jenis_penyakit') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('jenis_penyakit')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-2">
                    <label for="kesehatan_lingkungan" class="block text-sm font-medium text-gray-700">Kesehatan Lingkungan</label>
                    <select name="kesehatan_lingkungan" id="kesehatan_lingkungan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="baik" {{ old('kesehatan_lingkungan') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="buruk" {{ old('kesehatan_lingkungan') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                    </select>
                    @error('kesehatan_lingkungan')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
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

            $('#kartu_keluarga_id').select2({
                placeholder: 'Pilih Kartu Keluarga',
                allowClear: true
            });

            // Load kelurahans for old kecamatan_id on page load
            var initialKecamatanId = $('#kecamatan_id').val();
            if (initialKecamatanId) {
                $.ajax({
                    url: '{{ route("kelurahans.by-kecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', initialKecamatanId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#kelurahan_id').empty();
                        $('#kelurahan_id').append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(index, kelurahan) {
                            var selected = kelurahan.id == {{ old('kelurahan_id') ?? 'null' }} ? 'selected' : '';
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

            // Update kelurahans and kartu keluarga when kecamatan changes
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
                updateKartuKeluarga();
            });

            // Update kartu keluarga when kelurahan changes
            $('#kelurahan_id').on('change', function() {
                updateKartuKeluarga();
            });

            function updateKartuKeluarga() {
                var kecamatanId = $('#kecamatan_id').val();
                var kelurahanId = $('#kelurahan_id').val();
                var url = '{{ route("kartu_keluarga.by-kecamatan-kelurahan") }}';
                var data = {};
                if (kecamatanId) data.kecamatan_id = kecamatanId;
                if (kelurahanId) data.kelurahan_id = kelurahanId;

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        $('#kartu_keluarga_id').empty();
                        $('#kartu_keluarga_id').append('<option value="">Pilih Kartu Keluarga</option>');
                        $.each(data, function(index, kk) {
                            $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                        });
                        $('#kartu_keluarga_id').trigger('change');
                    },
                    error: function(xhr) {
                        console.error('Error fetching kartu keluarga:', xhr);
                        alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                    }
                });
            }

            // Handle penyakit_menular change
            $('#penyakit_menular').on('change', function() {
                $('#jenis_penyakit_container').css('display', this.value === 'ada' ? 'block' : 'none');
            });
        });
    </script>
</body>
</html>