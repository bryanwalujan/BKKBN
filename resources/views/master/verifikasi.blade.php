<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Verifikasi Akun</h2>
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
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Role</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Kelurahan</th>
                    <th class="p-4 text-left">Penanggung Jawab</th>
                    <th class="p-4 text-left">No Telepon</th>
                    <th class="p-4 text-left">Pas Foto</th>
                    <th class="p-4 text-left">Surat Pengajuan</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingUsers as $user)
                    <tr>
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">{{ $user->role }}</td>
                        <td class="p-4">{{ $user->kecamatan->nama_kecamatan ?? 'Belum ditentukan' }}</td>
                        <td class="p-4">{{ $user->kelurahan->nama_kelurahan ?? 'Belum ditentukan' }}</td>
                        <td class="p-4">{{ $user->penanggung_jawab }}</td>
                        <td class="p-4">{{ $user->no_telepon }}</td>
                        <td class="p-4">
                            @if ($user->pas_foto)
                                <a href="{{ Storage::url($user->pas_foto) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($user->surat_pengajuan)
                                <a href="{{ Storage::url($user->surat_pengajuan) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                            @else
                                Tidak ada
                            @endif
                        </td>
                        <td class="p-4">
                            <form action="{{ route('verifikasi.approve', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Setujui</button>
                            </form>
                            <form action="{{ route('verifikasi.reject', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="text" name="catatan" placeholder="Alasan penolakan" class="border p-1 rounded" required>
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>