<!DOCTYPE html>
<html>
<head>
    <title>Detail Kartu Keluarga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('kelurahan.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Detail Kartu Keluarga</h2>
        <a href="{{ route('kartu_keluarga.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>

        <!-- Informasi Kartu Keluarga -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Informasi Kartu Keluarga</h3>
            <table class="w-full">
                <tr class="border-b">
                    <td class="p-2 font-medium">No KK</td>
                    <td class="p-2">{{ $kartuKeluarga->no_kk }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Kepala Keluarga</td>
                    <td class="p-2">{{ $kartuKeluarga->kepala_keluarga }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Kecamatan</td>
                    <td class="p-2">{{ $kartuKeluarga->kecamatan->nama_kecamatan ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Kelurahan</td>
                    <td class="p-2">{{ $kartuKeluarga->kelurahan->nama_kelurahan ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Alamat</td>
                    <td class="p-2">{{ $kartuKeluarga->alamat ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Latitude</td>
                    <td class="p-2">{{ $kartuKeluarga->latitude ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Longitude</td>
                    <td class="p-2">{{ $kartuKeluarga->longitude ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Status</td>
                    <td class="p-2">{{ $kartuKeluarga->status }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-2 font-medium">Nama Pengunggah</td>
                    <td class="p-2">{{ $kartuKeluarga->createdBy->name ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Detail Pendamping Keluarga -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Detail Pendamping Keluarga</h3>
            @if ($kartuKeluarga->pendampingKeluargas->isEmpty())
                <p class="text-gray-500">Tidak ada data pendamping keluarga terkait.</p>
            @else
                @foreach ($kartuKeluarga->pendampingKeluargas as $index => $pendamping)
                    <div class="mb-6 p-4 bg-gray-50 rounded">
                        <h4 class="text-lg font-medium mb-2">Pendamping {{ $index + 1 }}: {{ $pendamping->nama }}</h4>
                        <table class="w-full">
                            <tr class="border-b">
                                <td class="p-2 font-medium">Nama</td>
                                <td class="p-2">{{ $pendamping->nama }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Peran</td>
                                <td class="p-2">{{ $pendamping->peran }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Kecamatan</td>
                                <td class="p-2">{{ $pendamping->kecamatan->nama_kecamatan ?? '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Kelurahan</td>
                                <td class="p-2">{{ $pendamping->kelurahan->nama_kelurahan ?? '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Status</td>
                                <td class="p-2">{{ $pendamping->status }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Tahun Bergabung</td>
                                <td class="p-2">{{ $pendamping->tahun_bergabung }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Penyuluhan dan Edukasi</td>
                                <td class="p-2">{{ $pendamping->penyuluhan ? ($pendamping->penyuluhan_frekuensi ?? '-') : '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Memfasilitasi Pelayanan Rujukan</td>
                                <td class="p-2">{{ $pendamping->rujukan ? ($pendamping->rujukan_frekuensi ?? '-') : '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Kunjungan Keluarga Berisiko Stunting (KRS)</td>
                                <td class="p-2">{{ $pendamping->kunjungan_krs ? ($pendamping->kunjungan_krs_frekuensi ?? '-') : '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Pendataan dan Rekomendasi Bantuan Sosial</td>
                                <td class="p-2">{{ $pendamping->pendataan_bansos ? ($pendamping->pendataan_bansos_frekuensi ?? '-') : '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Pemantauan Kesehatan dan Perkembangan Keluarga</td>
                                <td class="p-2">{{ $pendamping->pemantauan_kesehatan ? ($pendamping->pemantauan_kesehatan_frekuensi ?? '-') : '-' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="p-2 font-medium">Foto</td>
                                <td class="p-2">
                                    @if ($pendamping->foto)
                                        <img src="{{ Storage::url($pendamping->foto) }}" alt="Foto Pendamping" class="w-24 h-24 object-cover rounded">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="p-2 font-medium">Aksi</td>
                                <td class="p-2">
                                    <a href="{{ route('pendamping_keluarga.edit', $pendamping->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('pendamping_keluarga.destroy', $pendamping->id) }}" method="POST" class="delete-form inline" data-id="{{ $pendamping->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Daftar Ibu -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Ibu</h3>
            @if ($kartuKeluarga->ibu->isEmpty())
                <p class="text-gray-500">Tidak ada data ibu terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama</th>
                            <th class="p-4 text-left font-medium">NIK</th>
                            <th class="p-4 text-left font-medium">Kecamatan</th>
                            <th class="p-4 text-left font-medium">Kelurahan</th>
                            <th class="p-4 text-left font-medium">Alamat</th>
                            <th class="p-4 text-left font-medium">Status</th>
                            <th class="p-4 text-left font-medium">Status Kehamilan</th>
                            <th class="p-4 text-left font-medium">Status Nifas</th>
                            <th class="p-4 text-left font-medium">Status Menyusui</th>
                            <th class="p-4 text-left font-medium">Foto</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->ibu as $index => $ibu)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $ibu->nama }}</td>
                                <td class="p-4">{{ $ibu->nik ?? '-' }}</td>
                                <td class="p-4">{{ $ibu->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4">{{ $ibu->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4">{{ $ibu->alamat ?? '-' }}</td>
                                <td class="p-4">{{ $ibu->status }}</td>
                                <td class="p-4">{{ $ibu->ibuHamil ? 'Hamil' : '-' }}</td>
                                <td class="p-4">{{ $ibu->ibuNifas ? 'Nifas' : '-' }}</td>
                                <td class="p-4">{{ $ibu->ibuMenyusui ? 'Menyusui' : '-' }}</td>
                                <td class="p-4">
                                    @if ($ibu->foto)
                                        <img src="{{ Storage::url($ibu->foto) }}" alt="Foto Ibu" class="w-16 h-16 object-cover rounded">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('ibu.edit', $ibu->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('ibu.destroy', $ibu->id) }}" method="POST" class="delete-form inline" data-id="{{ $ibu->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Daftar Balita -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Balita</h3>
            @if ($kartuKeluarga->balitas->isEmpty())
                <p class="text-gray-500">Tidak ada data balita terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama</th>
                            <th class="p-4 text-left font-medium">NIK</th>
                            <th class="p-4 text-left font-medium">Jenis Kelamin</th>
                            <th class="p-4 text-left font-medium">Tanggal Lahir</th>
                            <th class="p-4 text-left font-medium">Usia</th>
                            <th class="p-4 text-left font-medium">Kategori Umur</th>
                            <th class="p-4 text-left font-medium">Kecamatan</th>
                            <th class="p-4 text-left font-medium">Kelurahan</th>
                            <th class="p-4 text-left font-medium">Berat/Tinggi</th>
                            <th class="p-4 text-left font-medium">Lingkar Kepala</th>
                            <th class="p-4 text-left font-medium">Lingkar Lengan</th>
                            <th class="p-4 text-left font-medium">Alamat</th>
                            <th class="p-4 text-left font-medium">Status Gizi</th>
                            <th class="p-4 text-left font-medium">Warna Label</th>
                            <th class="p-4 text-left font-medium">Status Pemantauan</th>
                            <th class="p-4 text-left font-medium">Foto</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->balitas as $index => $balita)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $balita->nama }}</td>
                                <td class="p-4">{{ $balita->nik ?? '-' }}</td>
                                <td class="p-4">{{ $balita->jenis_kelamin }}</td>
                                <td class="p-4">{{ $balita->tanggal_lahir ? $balita->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                                <td class="p-4">{{ $balita->usia !== null ? $balita->usia . ' bulan' : '-' }}</td>
                                <td class="p-4">{{ $balita->kategoriUmur }}</td>
                                <td class="p-4">{{ $balita->kecamatan->nama_kecamatan ?? '-' }}</td>
                                <td class="p-4">{{ $balita->kelurahan->nama_kelurahan ?? '-' }}</td>
                                <td class="p-4">{{ $balita->berat_tinggi ?? '-' }}</td>
                                <td class="p-4">{{ $balita->lingkar_kepala ? $balita->lingkar_kepala . ' cm' : '-' }}</td>
                                <td class="p-4">{{ $balita->lingkar_lengan ? $balita->lingkar_lengan . ' cm' : '-' }}</td>
                                <td class="p-4">{{ $balita->alamat ?? '-' }}</td>
                                <td class="p-4">{{ $balita->status_gizi }}</td>
                                <td class="p-4">{{ $balita->warna_label }}</td>
                                <td class="p-4">{{ $balita->status_pemantauan ?? '-' }}</td>
                                <td class="p-4">
                                    @if ($balita->foto)
                                        <img src="{{ Storage::url($balita->foto) }}" alt="Foto Balita" class="w-16 h-16 object-cover rounded">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('balita.edit', $balita->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('balita.destroy', $balita->id) }}" method="POST" class="delete-form inline" data-id="{{ $balita->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Daftar Aksi Konvergensi -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Aksi Konvergensi</h3>
            <a href="{{ route('aksi_konvergensi.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Aksi Konvergensi</a>
            @if ($kartuKeluarga->aksiKonvergensis->isEmpty())
                <p class="text-gray-500">Tidak ada data aksi konvergensi terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama Aksi</th>
                            <th class="p-4 text-left font-medium">Selesai</th>
                            <th class="p-4 text-left font-medium">Tahun</th>
                            <th class="p-4 text-left font-medium">Intervensi Sensitif</th>
                            <th class="p-4 text-left font-medium">Intervensi Spesifik</th>
                            <th class="p-4 text-left font-medium">Narasi</th>
                            <th class="p-4 text-left font-medium">Pelaku</th>
                            <th class="p-4 text-left font-medium">Waktu</th>
                            <th class="p-4 text-left font-medium">Foto</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->aksiKonvergensis as $index => $aksi)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $aksi->nama_aksi }}</td>
                                <td class="p-4">
                                    <span class="inline-block px-2 py-1 rounded text-white {{ $aksi->selesai ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ $aksi->selesai ? 'Selesai' : 'Belum Selesai' }}
                                    </span>
                                </td>
                                <td class="p-4">{{ $aksi->tahun }}</td>
                                <td class="p-4">
                                    <ul class="list-disc">
                                        <li>Ketersediaan Air Bersih dan Sanitasi: {{ $aksi->air_bersih_sanitasi ?? '-' }}</li>
                                        <li>Ketersediaan Akses ke Layanan Kesehatan dan KB: {{ $aksi->akses_layanan_kesehatan_kb ?? '-' }}</li>
                                        <li>Pendidikan Pengasuhan pada Orang Tua: {{ $aksi->pendidikan_pengasuhan_ortu ?? '-' }}</li>
                                        <li>Edukasi Kesehatan Seksual dan Reproduksi serta Gizi pada Remaja: {{ $aksi->edukasi_kesehatan_remaja ?? '-' }}</li>
                                        <li>Peningkatan Kesadaran Pengasuhan dan Gizi: {{ $aksi->kesadaran_pengasuhan_gizi ?? '-' }}</li>
                                        <li>Peningkatan Akses Pangan Bergizi: {{ $aksi->akses_pangan_bergizi ?? '-' }}</li>
                                    </ul>
                                </td>
                                <td class="p-4">
                                    <ul class="list-disc">
                                        <li>Pemberian Makanan pada Ibu Hamil: {{ $aksi->makanan_ibu_hamil ?? '-' }}</li>
                                        <li>Konsumsi Tablet Tambah Darah bagi Ibu Hamil dan Remaja Putri: {{ $aksi->tablet_tambah_darah ?? '-' }}</li>
                                        <li>Inisiasi Menyusui Dini (IMD): {{ $aksi->inisiasi_menyusui_dini ?? '-' }}</li>
                                        <li>Pemberian ASI Eksklusif: {{ $aksi->asi_eksklusif ?? '-' }}</li>
                                        <li>Pemberian ASI Didampingi oleh MPASI pada Usia 6-24 Bulan: {{ $aksi->asi_mpasi ?? '-' }}</li>
                                        <li>Pemberian Imunisasi Lengkap pada Anak: {{ $aksi->imunisasi_lengkap ?? '-' }}</li>
                                        <li>Pencegahan Infeksi: {{ $aksi->pencegahan_infeksi ?? '-' }}</li>
                                        <li>Status Gizi Ibu: {{ $aksi->status_gizi_ibu ?? '-' }}</li>
                                        <li>Penyakit Menular: {{ $aksi->penyakit_menular == 'ada' ? 'Ada ('.$aksi->jenis_penyakit.')' : ($aksi->penyakit_menular ?? '-') }}</li>
                                        <li>Kesehatan Lingkungan: {{ $aksi->kesehatan_lingkungan ?? '-' }}</li>
                                    </ul>
                                </td>
                                <td class="p-4">{{ Str::limit($aksi->narasi, 50) }}</td>
                                <td class="p-4">{{ $aksi->pelaku_aksi ?? '-' }}</td>
                                <td class="p-4">{{ $aksi->waktu_pelaksanaan ? $aksi->waktu_pelaksanaan->format('d-m-Y H:i') : '-' }}</td>
                                <td class="p-4">
                                    @if ($aksi->foto)
                                        <img src="{{ Storage::url($aksi->foto) }}" alt="Foto Aksi Konvergensi" class="w-16 h-16 object-cover rounded">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('aksi_konvergensi.edit', $aksi->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('aksi_konvergensi.destroy', $aksi->id) }}" method="POST" class="delete-form inline" data-id="{{ $aksi->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Daftar Kegiatan Genting -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Kegiatan Genting</h3>
            <a href="{{ route('genting.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Kegiatan Genting</a>
            @if ($kartuKeluarga->gentings->isEmpty())
                <p class="text-gray-500">Tidak ada data kegiatan Genting terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama Kegiatan</th>
                            <th class="p-4 text-left font-medium">Tanggal</th>
                            <th class="p-4 text-left font-medium">Lokasi</th>
                            <th class="p-4 text-left font-medium">Sasaran</th>
                            <th class="p-4 text-left font-medium">Jenis Intervensi</th>
                            <th class="p-4 text-left font-medium">Narasi</th>
                            <th class="p-4 text-left font-medium">Pihak Ketiga</th>
                            <th class="p-4 text-left font-medium">Dokumentasi</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->gentings as $index => $genting)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $genting->nama_kegiatan }}</td>
                                <td class="p-4">{{ \Carbon\Carbon::parse($genting->tanggal)->format('d-m-Y') }}</td>
                                <td class="p-4">{{ $genting->lokasi }}</td>
                                <td class="p-4">{{ $genting->sasaran }}</td>
                                <td class="p-4">{{ $genting->jenis_intervensi }}</td>
                                <td class="p-4">{{ $genting->narasi ? Str::limit($genting->narasi, 50) : '-' }}</td>
                                <td class="p-4">
                                    <ul class="list-disc">
                                        @if ($genting->dunia_usaha == 'ada')
                                            <li>Dunia Usaha: {{ $genting->dunia_usaha_frekuensi }}</li>
                                        @endif
                                        @if ($genting->pemerintah == 'ada')
                                            <li>Pemerintah: {{ $genting->pemerintah_frekuensi }}</li>
                                        @endif
                                        @if ($genting->bumn_bumd == 'ada')
                                            <li>BUMN dan BUMD: {{ $genting->bumn_bumd_frekuensi }}</li>
                                        @endif
                                        @if ($genting->individu_perseorangan == 'ada')
                                            <li>Individu dan Perseorangan: {{ $genting->individu_perseorangan_frekuensi }}</li>
                                        @endif
                                        @if ($genting->lsm_komunitas == 'ada')
                                            <li>LSM dan Komunitas: {{ $genting->lsm_komunitas_frekuensi }}</li>
                                        @endif
                                        @if ($genting->swasta == 'ada')
                                            <li>Swasta: {{ $genting->swasta_frekuensi }}</li>
                                        @endif
                                        @if ($genting->perguruan_tinggi_akademisi == 'ada')
                                            <li>Perguruan Tinggi dan Akademisi: {{ $genting->perguruan_tinggi_akademisi_frekuensi }}</li>
                                        @endif
                                        @if ($genting->media == 'ada')
                                            <li>Media: {{ $genting->media_frekuensi }}</li>
                                        @endif
                                        @if ($genting->tim_pendamping_keluarga == 'ada')
                                            <li>Tim Pendamping Keluarga: {{ $genting->tim_pendamping_keluarga_frekuensi }}</li>
                                        @endif
                                        @if ($genting->tokoh_masyarakat == 'ada')
                                            <li>Tokoh Masyarakat: {{ $genting->tokoh_masyarakat_frekuensi }}</li>
                                        @endif
                                        @if (!$genting->dunia_usaha && !$genting->pemerintah && !$genting->bumn_bumd && !$genting->individu_perseorangan && !$genting->lsm_komunitas && !$genting->swasta && !$genting->perguruan_tinggi_akademisi && !$genting->media && !$genting->tim_pendamping_keluarga && !$genting->tokoh_masyarakat)
                                            <li>Tidak ada pihak ketiga</li>
                                        @endif
                                    </ul>
                                </td>
                                <td class="p-4">
                                    @if ($genting->dokumentasi)
                                        <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi Kegiatan" class="w-16 h-16 object-cover rounded">
                                    @else
                                        Tidak ada dokumentasi
                                    @endif
                                </td>
                                <td class="p-4">
                                    <a href="{{ route('genting.edit', $genting->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('genting.destroy', $genting->id) }}" method="POST" class="delete-form inline" data-id="{{ $genting->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Riwayat Monitoring -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Riwayat Monitoring</h3>
            <a href="{{ route('data_monitoring.create') }}?kartu_keluarga_id={{ $kartuKeluarga->id }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Data Monitoring</a>
            @if ($kartuKeluarga->dataMonitorings->isEmpty())
                <p class="text-gray-500">Tidak ada data monitoring terkait.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="p-4 text-left font-medium">No</th>
                                <th class="p-4 text-left font-medium">Tanggal Monitoring</th>
                                <th class="p-4 text-left font-medium">Nama</th>
                                <th class="p-4 text-left font-medium">Target</th>
                                <th class="p-4 text-left font-medium">Kategori</th>
                                <th class="p-4 text-left font-medium">Berat Badan</th>
                                <th class="p-4 text-left font-medium">Tinggi Badan</th>
                                <th class="p-4 text-left font-medium">Lingkar Kepala</th>
                                <th class="p-4 text-left font-medium">Lingkar Lengan</th>
                                <th class="p-4 text-left font-medium">Status Gizi</th>
                                <th class="p-4 text-left font-medium">Warna Badge</th>
                                <th class="p-4 text-left font-medium">Kunjungan Rumah</th>
                                <th class="p-4 text-left font-medium">Frekuensi Kunjungan</th>
                                <th class="p-4 text-left font-medium">Pemberian PMT</th>
                                <th class="p-4 text-left font-medium">Frekuensi PMT</th>
                                <th class="p-4 text-left font-medium">Terpapar Rokok</th>
                                <th class="p-4 text-left font-medium">Suplemen TTD</th>
                                <th class="p-4 text-left font-medium">Rujukan</th>
                                <th class="p-4 text-left font-medium">Bantuan Sosial</th>
                                <th class="p-4 text-left font-medium">Posyandu/BKB</th>
                                <th class="p-4 text-left font-medium">KIE</th>
                                <th class="p-4 text-left font-medium">Diunggah Oleh</th>
                                <th class="p-4 text-left font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kartuKeluarga->dataMonitorings as $index => $monitoring)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4">{{ $index + 1 }}</td>
                                    <td class="p-4">{{ $monitoring->tanggal_monitoring ? \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d-m-Y') : '-' }}</td>
                                    <td class="p-4">{{ $monitoring->target == 'Ibu' ? ($monitoring->ibu->nama ?? '-') : ($monitoring->balita->nama ?? '-') }}</td>
                                    <td class="p-4">{{ $monitoring->target ?? '-' }}</td>
                                    <td class="p-4">{{ $monitoring->kategori ?? '-' }}</td>
                                    <td class="p-4">{{ $monitoring->berat_badan ? $monitoring->berat_badan . ' kg' : '-' }}</td>
                                    <td class="p-4">{{ $monitoring->tinggi_badan ? $monitoring->tinggi_badan . ' cm' : '-' }}</td>
                                    <td class="p-4">{{ $monitoring->lingkar_kepala ? $monitoring->lingkar_kepala . ' cm' : '-' }}</td>
                                    <td class="p-4">{{ $monitoring->lingkar_lengan ? $monitoring->lingkar_lengan . ' cm' : '-' }}</td>
                                    <td class="p-4">{{ $monitoring->status_gizi ?? '-' }}</td>
                                    <td class="p-4">
                                        <span class="inline-block px-2 py-1 rounded text-white {{ $monitoring->warna_badge == 'Hijau' ? 'bg-green-500' : ($monitoring->warna_badge == 'Kuning' ? 'bg-yellow-500' : ($monitoring->warna_badge == 'Merah' ? 'bg-red-500' : 'bg-blue-500')) }}">
                                            {{ $monitoring->warna_badge ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="p-4">{{ $monitoring->kunjungan_rumah ? 'Ada' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->frekuensi_kunjungan ?? '-' }}</td>
                                    <td class="p-4">{{ $monitoring->pemberian_pmt ? 'Ada' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->frekuensi_pmt ?? '-' }}</td>
                                    <td class="p-4">{{ $monitoring->terpapar_rokok ? 'Ya' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->suplemen_ttd ? 'Ya' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->rujukan ? 'Ya' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->bantuan_sosial ? 'Ya' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->posyandu_bkb ? 'Ya' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->kie ? 'Ya' : 'Tidak' }}</td>
                                    <td class="p-4">{{ $monitoring->user->name ?? '-' }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('data_monitoring.edit', $monitoring->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('data_monitoring.destroy', $monitoring->id) }}" method="POST" class="delete-form inline" data-id="{{ $monitoring->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline ml-2">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Delete confirmation with SweetAlert2
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