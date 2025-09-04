<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Kelola Pengguna</h2>
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
        <div class="flex space-x-4 mb-4">
            <form action="{{ route('users.index') }}" method="GET" class="flex space-x-2">
                <select name="role" class="border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Role</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r }}" {{ $role == $r ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $r)) }}</option>
                    @endforeach
                </select>
                <select name="kecamatan_id" class="border-gray-300 rounded-md shadow-sm">
                    <option value="">Semua Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ $kecamatan_id == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Filter</button>
            </form>
        </div>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Role</th>
                    <th class="p-4 text-left">Kecamatan</th>
                    <th class="p-4 text-left">Penanggung Jawab</th>
                    <th class="p-4 text-left">No Telepon</th>
                    <th class="p-4 text-left">Pas Foto</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $users->firstItem() + $index }}</td>
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                        <td class="p-4">{{ $user->kecamatan_nama ?? '-' }}</td>
                        <td class="p-4">{{ $user->penanggung_jawab ?? '-' }}</td>
                        <td class="p-4">{{ $user->no_telepon ?? '-' }}</td>
                        <td class="p-4">
                            @if ($user->pas_foto)
                                <img src="{{ Storage::url('pas_foto/' . $user->pas_foto) }}" alt="Pas Foto" class="w-16 h-16 object-cover">
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus akun ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->appends(['role' => $role, 'kecamatan_id' => $kecamatan_id])->links() }}
        </div>
    </div>
</body>
</html>