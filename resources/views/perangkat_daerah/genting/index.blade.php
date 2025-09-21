<!DOCTYPE html>
<html>
<head>
    <title>Data Kegiatan Genting - Perangkat Daerah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        .tabs { display: flex; border-bottom: 1px solid #e5e7eb; margin-bottom: 20px; }
        .tab { padding: 10px 20px; cursor: pointer; font-weight: bold; color: #4b5563; }
        .tab.active { color: #15803d; border-bottom: 2px solid #15803d; }
    </style>
</head>
<body class="bg-gray-100">
    @include('perangkat_daerah.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Kegiatan Genting - Kecamatan {{ auth()->user()->kecamatan->nama_kecamatan }}</h2>
        <a href="{{ route('perangkat_daerah.genting.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Kegiatan Genting</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('perangkat_daerah.genting.index', ['tab' => 'pending', 'search' => $search]) }}"
               class="tab {{ $tab === 'pending' ? 'active' : '' }}">Pending Verifikasi</a>
            <a href="{{ route('perangkat_daerah.genting.index', ['tab' => 'verified', 'search' => $search]) }}"
               class="tab {{ $tab === 'verified' ? 'active' : '' }}">Terverifikasi</a>
        </div>

        <!-- Filter -->
        <form method="GET" action="{{ route('perangkat_daerah.genting.index') }}" class="mb-4 flex space-x-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama Kegiatan" class="border p-2 rounded w-1/3">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
        </form>

        <!-- Table -->
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
                        <td class="p-4">{{ $gentings->firstItem() + $index }}</td>
                        <td class="p-4">
                            @if ($genting->kartuKeluarga)
                                <a href="{{ route('perangkat_daerah.kartu_keluarga.show', $genting->kartuKeluarga->id) }}" class="text-blue-500 hover:underline">
                                    {{ $genting->kartuKeluarga->no_kk }} - {{ $genting->kartuKeluarga->kepala_keluarga }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($genting->dokumentasi)
                                <a href="{{ Storage::url($genting->dokumentasi) }}" target="_blank">
                                    <img src="{{ Storage::url($genting->dokumentasi) }}" alt="Dokumentasi" class="w-16 h-16 object-cover rounded">
                                </a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td class="p-4">{{ $genting->nama_kegiatan }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($genting->tanggal)->format('d-m-Y') }}</td>
                        <td class="p-4">{{ $genting->lokasi }}</td>
                        <td class="p-4">{{ $genting->sasaran }}</td>
                        <td class="p-4">{{ $genting->jenis_intervensi }}</td>
                        <td class="p-4">{{ $genting->narasi ? Str::limit($genting->narasi, 50) : '-' }}</td>
                        <td class="p-4">
                            <ul class="list-disc pl-5">
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
                            <a href="{{ route('perangkat_daerah.genting.edit', ['id' => $genting->id, 'source' => $genting->source]) }}" class="text-blue-500 hover:underline">Edit</a>
                            @if ($genting->source === 'pending')
                                <form action="{{ route('perangkat_daerah.genting.destroy', ['id' => $genting->id, 'source' => 'pending']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data kegiatan genting ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $gentings->links() }}
        </div>
    </div>
</body>
</html>