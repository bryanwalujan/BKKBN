<!DOCTYPE html>
<html>
<head>
    <title>Data Kegiatan Genting</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kegiatan Genting</h2>
        <a href="{{ route('genting.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Kegiatan Genting</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Kartu Keluarga</th>
                    <th class="p-4 text-left">Dokumentasi</th>
                    <th class="p-4 text-left">Nama Kegiatan</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-left">Lokasi</th>
                    <th class="p-4 text-left">Sasaran</th>
                    <th class="p-4 text-left">Jenis Intervensi</th>
                    <th class="p-4 text-left">Narasi</th>
                    <th class="p-4 text-left">Pihak Ketiga</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gentings as $index => $genting)
                    <tr>
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">
                            @if ($genting->kartuKeluarga)
                                <a href="{{ route('kartu_keluarga.show', $genting->kartuKeluarga->id) }}" class="text-blue-500 hover:underline">
                                    {{ $genting->kartuKeluarga->no_kk }} - {{ $genting->kartuKeluarga->kepala_keluarga }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($genting->dokumentasi)
                                <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi Kegiatan" class="w-16 h-16 object-cover rounded">
                            @else
                                Tidak ada dokumentasi
                            @endif
                        </td>
                        <td class="p-4">{{ $genting->nama_kegiatan }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($genting->tanggal)->format('m/d/Y') }}</td>
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
                            <a href="{{ route('genting.edit', $genting->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('genting.destroy', $genting->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data kegiatan Genting ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>