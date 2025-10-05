<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Aksi Konvergensi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Aksi Konvergensi</h2>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('perangkat_daerah.aksi_konvergensi.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                    @error('kecamatan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Kelurahan</option>
                        @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                    @error('kelurahan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                    <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Kartu Keluarga</option>
                        @foreach ($kartuKeluargas as $kk)
                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga }}</option>
                        @endforeach
                    </select>
                    @error('kartu_keluarga_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="nama_aksi" class="block text-sm font-medium text-gray-700">Nama Aksi</label>
                    <input type="text" name="nama_aksi" id="nama_aksi" value="{{ old('nama_aksi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('nama_aksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="selesai" class="block text-sm font-medium text-gray-700">Selesai</label>
                    <input type="checkbox" name="selesai" id="selesai" value="1" {{ old('selesai') ? 'checked' : '' }} class="mt-1">
                    @error('selesai')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <input type="number" name="tahun" id="tahun" value="{{ old('tahun') }}" min="2000" max="2050" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @error('tahun')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="pelaku_aksi" class="block text-sm font-medium text-gray-700">Pelaku Aksi</label>
                    <input type="text" name="pelaku_aksi" id="pelaku_aksi" value="{{ old('pelaku_aksi') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('pelaku_aksi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700">Waktu Pelaksanaan</label>
                    <input type="datetime-local" name="waktu_pelaksanaan" id="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('waktu_pelaksanaan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto (Maks. 7MB)</label>
                    <input type="file" name="foto" id="foto" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('foto')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                    <textarea name="narasi" id="narasi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('narasi') }}</textarea>
                    @error('narasi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <h3 class="text-lg font-semibold mb-2">Intervensi Sensitif</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="air_bersih_sanitasi" class="block text-sm font-medium text-gray-700">Ketersediaan Air Bersih dan Sanitasi</label>
                            <select name="air_bersih_sanitasi" id="air_bersih_sanitasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada-baik" {{ old('air_bersih_sanitasi') == 'ada-baik' ? 'selected' : '' }}>Ada - Baik</option>
                                <option value="ada-buruk" {{ old('air_bersih_sanitasi') == 'ada-buruk' ? 'selected' : '' }}>Ada - Buruk</option>
                                <option value="tidak" {{ old('air_bersih_sanitasi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('air_bersih_sanitasi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="akses_layanan_kesehatan_kb" class="block text-sm font-medium text-gray-700">Akses Layanan Kesehatan dan KB</label>
                            <select name="akses_layanan_kesehatan_kb" id="akses_layanan_kesehatan_kb" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('akses_layanan_kesehatan_kb') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('akses_layanan_kesehatan_kb') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('akses_layanan_kesehatan_kb')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="pendidikan_pengasuhan_ortu" class="block text-sm font-medium text-gray-700">Pendidikan Pengasuhan Orang Tua</label>
                            <select name="pendidikan_pengasuhan_ortu" id="pendidikan_pengasuhan_ortu" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('pendidikan_pengasuhan_ortu') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('pendidikan_pengasuhan_ortu') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('pendidikan_pengasuhan_ortu')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="edukasi_kesehatan_remaja" class="block text-sm font-medium text-gray-700">Edukasi Kesehatan Remaja</label>
                            <select name="edukasi_kesehatan_remaja" id="edukasi_kesehatan_remaja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('edukasi_kesehatan_remaja') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('edukasi_kesehatan_remaja') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('edukasi_kesehatan_remaja')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="kesadaran_pengasuhan_gizi" class="block text-sm font-medium text-gray-700">Kesadaran Pengasuhan dan Gizi</label>
                            <select name="kesadaran_pengasuhan_gizi" id="kesadaran_pengasuhan_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('kesadaran_pengasuhan_gizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('kesadaran_pengasuhan_gizi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('kesadaran_pengasuhan_gizi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="akses_pangan_bergizi" class="block text-sm font-medium text-gray-700">Akses Pangan Bergizi</label>
                            <select name="akses_pangan_bergizi" id="akses_pangan_bergizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('akses_pangan_bergizi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('akses_pangan_bergizi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('akses_pangan_bergizi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <h3 class="text-lg font-semibold mb-2">Intervensi Spesifik</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="makanan_ibu_hamil" class="block text-sm font-medium text-gray-700">Makanan Ibu Hamil</label>
                            <select name="makanan_ibu_hamil" id="makanan_ibu_hamil" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('makanan_ibu_hamil') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('makanan_ibu_hamil') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('makanan_ibu_hamil')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="tablet_tambah_darah" class="block text-sm font-medium text-gray-700">Tablet Tambah Darah</label>
                            <select name="tablet_tambah_darah" id="tablet_tambah_darah" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('tablet_tambah_darah') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('tablet_tambah_darah') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('tablet_tambah_darah')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="inisiasi_menyusui_dini" class="block text-sm font-medium text-gray-700">Inisiasi Menyusui Dini</label>
                            <select name="inisiasi_menyusui_dini" id="inisiasi_menyusui_dini" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('inisiasi_menyusui_dini') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('inisiasi_menyusui_dini') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('inisiasi_menyusui_dini')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="asi_eksklusif" class="block text-sm font-medium text-gray-700">ASI Eksklusif</label>
                            <select name="asi_eksklusif" id="asi_eksklusif" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('asi_eksklusif') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('asi_eksklusif') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('asi_eksklusif')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="asi_mpasi" class="block text-sm font-medium text-gray-700">ASI dan MPASI</label>
                            <select name="asi_mpasi" id="asi_mpasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('asi_mpasi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('asi_mpasi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('asi_mpasi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="imunisasi_lengkap" class="block text-sm font-medium text-gray-700">Imunisasi Lengkap</label>
                            <select name="imunisasi_lengkap" id="imunisasi_lengkap" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('imunisasi_lengkap') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('imunisasi_lengkap') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('imunisasi_lengkap')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="pencegahan_infeksi" class="block text-sm font-medium text-gray-700">Pencegahan Infeksi</label>
                            <select name="pencegahan_infeksi" id="pencegahan_infeksi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="ada" {{ old('pencegahan_infeksi') == 'ada' ? 'selected' : '' }}>Ada</option>
                                <option value="tidak" {{ old('pencegahan_infeksi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                            </select>
                            @error('pencegahan_infeksi')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="status_gizi_ibu" class="block text-sm font-medium text-gray-700">Status Gizi Ibu</label>
                            <select name="status_gizi_ibu" id="status_gizi_ibu" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="baik" {{ old('status_gizi_ibu') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="buruk" {{ old('status_gizi_ibu') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                            </select>
                            @error('status_gizi_ibu')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="penyakit_menular" class="block text-sm font-medium text-gray-700">Penyakit Menular</label>
                            <select name="penyakit_menular" id="penyakit_menular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="tidak" {{ old('penyakit_menular') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                <option value="ada" {{ old('penyakit_menular') == 'ada' ? 'selected' : '' }}>Ada</option>
                            </select>
                            @error('penyakit_menular')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div id="jenis_penyakit_container" style="display: {{ old('penyakit_menular') == 'ada' ? 'block' : 'none' }};">
                            <label for="jenis_penyakit" class="block text-sm font-medium text-gray-700">Jenis Penyakit</label>
                            <input type="text" name="jenis_penyakit" id="jenis_penyakit" value="{{ old('jenis_penyakit') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" {{ old('penyakit_menular') == 'ada' ? 'required' : '' }}>
                            @error('jenis_penyakit')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="kesehatan_lingkungan" class="block text-sm font-medium text-gray-700">Kesehatan Lingkungan</label>
                            <select name="kesehatan_lingkungan" id="kesehatan_lingkungan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih</option>
                                <option value="baik" {{ old('kesehatan_lingkungan') == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="buruk" {{ old('kesehatan_lingkungan') == 'buruk' ? 'selected' : '' }}>Buruk</option>
                            </select>
                            @error('kesehatan_lingkungan')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex space-x-4 mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                <a href="{{ route('perangkat_daerah.aksi_konvergensi.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.aksi_konvergensi.getKelurahansByKecamatan", ":kecamatan_id") }}'.replace(':kecamatan_id', kecamatanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
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
                    $('#kelurahan_id').empty().append('<option value="">Pilih Kelurahan</option>');
                    $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                }
            });

            $('#kelurahan_id').on('change', function() {
                var kelurahanId = $(this).val();
                if (kelurahanId) {
                    $.ajax({
                        url: '{{ route("perangkat_daerah.aksi_konvergensi.getKartuKeluargaByKelurahan", ":kelurahan_id") }}'.replace(':kelurahan_id', kelurahanId),
                        type: 'GET',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(data) {
                            $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                            $.each(data, function(index, kk) {
                                $('#kartu_keluarga_id').append('<option value="' + kk.id + '">' + kk.no_kk + ' - ' + kk.kepala_keluarga + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.error('Error fetching kartu keluarga:', xhr.responseText);
                            alert('Gagal memuat kartu keluarga. Silakan coba lagi.');
                        }
                    });
                } else {
                    $('#kartu_keluarga_id').empty().append('<option value="">Pilih Kartu Keluarga</option>');
                }
            });

            $('#penyakit_menular').on('change', function() {
                var jenisPenyakitContainer = $('#jenis_penyakit_container');
                var jenisPenyakitInput = $('#jenis_penyakit');
                if (this.value === 'ada') {
                    jenisPenyakitContainer.css('display', 'block');
                    jenisPenyakitInput.prop('required', true);
                } else {
                    jenisPenyakitContainer.css('display', 'none');
                    jenisPenyakitInput.prop('required', false);
                    jenisPenyakitInput.val('');
                }
            });
        });
    </script>
</body>
</html>