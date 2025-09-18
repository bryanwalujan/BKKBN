<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Ibu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Data Ibu</h2>
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if ($kartuKeluargas->isEmpty() || !$kecamatan || !$kelurahan)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $kartuKeluargas->isEmpty() ? 'Tidak ada data Kartu Keluarga yang terverifikasi. ' : '' }}
                {{ !$kecamatan || !$kelurahan ? 'Data kecamatan atau kelurahan tidak ditemukan. ' : '' }}
                Silakan tambahkan data terlebih dahulu.
            </div>
        @else
            <form action="{{ route('kelurahan.ibu.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
                @csrf
                <div class="mb-4">
                    <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <input type="text" value="{{ $kecamatan->nama_kecamatan }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                    <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->id }}">
                    @error('kecamatan_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kelurahan_id" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <input type="text" value="{{ $kelurahan->nama_kelurahan }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly>
                    <input type="hidden" name="kelurahan_id" value="{{ $kelurahan->id }}">
                    @error('kelurahan_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="kartu_keluarga_id" class="block text-sm font-medium text-gray-700">Kartu Keluarga</label>
                    <select name="kartu_keluarga_id" id="kartu_keluarga_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">-- Pilih Kartu Keluarga --</option>
                        @foreach ($kartuKeluargas as $kk)
                            <option value="{{ $kk->id }}" {{ old('kartu_keluarga_id') == $kk->id ? 'selected' : '' }}>{{ $kk->nomor_kk }} - {{ $kk->kepala_keluarga }}</option>
                        @endforeach
                    </select>
                    @error('kartu_keluarga_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" maxlength="16">
                    @error('nik')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('nama')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="" {{ old('status') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                        <option value="Hamil" {{ old('status') == 'Hamil' ? 'selected' : '' }}>Hamil</option>
                        <option value="Nifas" {{ old('status') == 'Nifas' ? 'selected' : '' }}>Nifas</option>
                        <option value="Menyusui" {{ old('status') == 'Menyusui' ? 'selected' : '' }}>Menyusui</option>
                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                    <input type="file" name="foto" id="foto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('foto')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Fields untuk status Hamil -->
                <div id="hamil_fields" class="hidden">
                    <div class="mb-4">
                        <label for="trimester" class="block text-sm font-medium text-gray-700">Trimester</label>
                        <select name="trimester" id="trimester" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                        <select name="intervensi" id="intervensi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                        <select name="status_gizi" id="status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                        <select name="warna_status_gizi" id="warna_status_gizi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                        <input type="number" name="usia_kehamilan" id="usia_kehamilan" value="{{ old('usia_kehamilan') }}" min="0" max="40" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('usia_kehamilan')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="berat_hamil" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                        <input type="number" name="berat_hamil" id="berat_hamil" value="{{ old('berat_hamil') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('berat_hamil')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tinggi_hamil" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                        <input type="number" name="tinggi_hamil" id="tinggi_hamil" value="{{ old('tinggi_hamil') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tinggi_hamil')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Fields untuk status Nifas -->
                <div id="nifas_fields" class="hidden">
                    <div class="mb-4">
                        <label for="hari_nifas" class="block text-sm font-medium text-gray-700">Hari Nifas</label>
                        <input type="number" name="hari_nifas" id="hari_nifas" value="{{ old('hari_nifas') }}" min="0" max="42" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('hari_nifas')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="kondisi_kesehatan" class="block text-sm font-medium text-gray-700">Kondisi Kesehatan</label>
                        <select name="kondisi_kesehatan" id="kondisi_kesehatan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" {{ old('kondisi_kesehatan') == '' ? 'selected' : '' }}>-- Pilih Kondisi --</option>
                            <option value="Normal" {{ old('kondisi_kesehatan') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Butuh Perhatian" {{ old('kondisi_kesehatan') == 'Butuh Perhatian' ? 'selected' : '' }}>Butuh Perhatian</option>
                            <option value="Kritis" {{ old('kondisi_kesehatan') == 'Kritis' ? 'selected' : '' }}>Kritis</option>
                        </select>
                        @error('kondisi_kesehatan')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="warna_kondisi_nifas" class="block text-sm font-medium text-gray-700">Warna Kondisi</label>
                        <select name="warna_kondisi_nifas" id="warna_kondisi_nifas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" {{ old('warna_kondisi_nifas') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                            <option value="Hijau (success)" {{ old('warna_kondisi_nifas') == 'Hijau (success)' ? 'selected' : '' }}>Hijau (success)</option>
                            <option value="Kuning (warning)" {{ old('warna_kondisi_nifas') == 'Kuning (warning)' ? 'selected' : '' }}>Kuning (warning)</option>
                            <option value="Merah (danger)" {{ old('warna_kondisi_nifas') == 'Merah (danger)' ? 'selected' : '' }}>Merah (danger)</option>
                        </select>
                        @error('warna_kondisi_nifas')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="berat_nifas" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                        <input type="number" name="berat_nifas" id="berat_nifas" value="{{ old('berat_nifas') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('berat_nifas')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tinggi_nifas" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                        <input type="number" name="tinggi_nifas" id="tinggi_nifas" value="{{ old('tinggi_nifas') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tinggi_nifas')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Fields untuk status Menyusui -->
                <div id="menyusui_fields" class="hidden">
                    <div class="mb-4">
                        <label for="status_menyusui" class="block text-sm font-medium text-gray-700">Status Menyusui</label>
                        <select name="status_menyusui" id="status_menyusui" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" {{ old('status_menyusui') == '' ? 'selected' : '' }}>-- Pilih Status --</option>
                            <option value="Eksklusif" {{ old('status_menyusui') == 'Eksklusif' ? 'selected' : '' }}>Eksklusif</option>
                            <option value="Non-Eksklusif" {{ old('status_menyusui') == 'Non-Eksklusif' ? 'selected' : '' }}>Non-Eksklusif</option>
                        </select>
                        @error('status_menyusui')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="frekuensi_menyusui" class="block text-sm font-medium text-gray-700">Frekuensi Menyusui (kali/hari)</label>
                        <input type="number" name="frekuensi_menyusui" id="frekuensi_menyusui" value="{{ old('frekuensi_menyusui') }}" min="0" max="24" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('frekuensi_menyusui')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="kondisi_ibu" class="block text-sm font-medium text-gray-700">Kondisi Ibu</label>
                        <input type="text" name="kondisi_ibu" id="kondisi_ibu" value="{{ old('kondisi_ibu') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('kondisi_ibu')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="warna_kondisi_menyusui" class="block text-sm font-medium text-gray-700">Warna Kondisi</label>
                        <select name="warna_kondisi_menyusui" id="warna_kondisi_menyusui" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="" {{ old('warna_kondisi_menyusui') == '' ? 'selected' : '' }}>-- Pilih Warna --</option>
                            <option value="Hijau (success)" {{ old('warna_kondisi_menyusui') == 'Hijau (success)' ? 'selected' : '' }}>Hijau (success)</option>
                            <option value="Kuning (warning)" {{ old('warna_kondisi_menyusui') == 'Kuning (warning)' ? 'selected' : '' }}>Kuning (warning)</option>
                            <option value="Merah (danger)" {{ old('warna_kondisi_menyusui') == 'Merah (danger)' ? 'selected' : '' }}>Merah (danger)</option>
                        </select>
                        @error('warna_kondisi_menyusui')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="berat_menyusui" class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                        <input type="number" name="berat_menyusui" id="berat_menyusui" value="{{ old('berat_menyusui') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('berat_menyusui')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="tinggi_menyusui" class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                        <input type="number" name="tinggi_menyusui" id="tinggi_menyusui" value="{{ old('tinggi_menyusui') }}" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tinggi_menyusui')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    <a href="{{ route('kelurahan.ibu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                </div>
            </form>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#kartu_keluarga_id').select2({
                placeholder: "-- Pilih Kartu Keluarga --",
                allowClear: true
            });

            $('#status').on('change', function () {
                $('#hamil_fields').addClass('hidden');
                $('#nifas_fields').addClass('hidden');
                $('#menyusui_fields').addClass('hidden');

                if ($(this).val() === 'Hamil') {
                    $('#hamil_fields').removeClass('hidden');
                } else if ($(this).val() === 'Nifas') {
                    $('#nifas_fields').removeClass('hidden');
                } else if ($(this).val() === 'Menyusui') {
                    $('#menyusui_fields').removeClass('hidden');
                }
            });

            // Trigger change on page load to set initial state
            $('#status').trigger('change');
        });
    </script>
</body>
</html>