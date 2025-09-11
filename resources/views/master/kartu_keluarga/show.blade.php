<!DOCTYPE html>
<html>
<head>
    <title>Detail Kartu Keluarga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
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
            </table>
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
                            <th class="p-4 text-left font-medium">Status</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->ibu as $index => $ibu)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $ibu->nama }}</td>
                                <td class="p-4">{{ $ibu->nik ?? '-' }}</td>
                                <td class="p-4">{{ $ibu->status }}</td>
                                <td class="p-4">
                                    <a href="{{ route('ibu.edit', $ibu->id) }}" class="text-blue-500 hover:underline">Edit</a>
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
                            <th class="p-4 text-left font-medium">Jenis Kelamin</th>
                            <th class="p-4 text-left font-medium">Tanggal Lahir</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->balitas as $index => $balita)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $balita->nama }}</td>
                                <td class="p-4">{{ $balita->jenis_kelamin }}</td>
                                <td class="p-4">{{ $balita->tanggal_lahir }}</td>
                                <td class="p-4">
                                    <a href="{{ route('balita.edit', $balita->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Daftar Remaja Putri -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Daftar Remaja Putri</h3>
            @if ($kartuKeluarga->remajaPutris->isEmpty())
                <p class="text-gray-500">Tidak ada data remaja putri terkait.</p>
            @else
                <table class="w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="p-4 text-left font-medium">No</th>
                            <th class="p-4 text-left font-medium">Nama</th>
                            <th class="p-4 text-left font-medium">NIK</th>
                            <th class="p-4 text-left font-medium">Tanggal Lahir</th>
                            <th class="p-4 text-left font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kartuKeluarga->remajaPutris as $index => $remaja)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $index + 1 }}</td>
                                <td class="p-4">{{ $remaja->nama }}</td>
                                <td class="p-4">{{ $remaja->nik ?? '-' }}</td>
                                <td class="p-4">{{ $remaja->tanggal_lahir }}</td>
                                <td class="p-4">
                                    <a href="{{ route('remaja_putri.edit', $remaja->id) }}" class="text-blue-500 hover:underline">Edit</a>
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
                                    <form action="{{ route('aksi_konvergensi.destroy', $aksi->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data Aksi Konvergensi ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>