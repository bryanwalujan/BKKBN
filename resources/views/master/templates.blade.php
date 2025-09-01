<!DOCTYPE html>
<html>
<head>
    <title>Kelola Template</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Upload Template Surat Pengajuan</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow mb-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Template</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700">File Template (.docx)</label>
                <input type="file" name="file" id="file" class="mt-1 block w-full" accept=".docx" required>
                @error('file')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Upload</button>
        </form>

        <h2 class="text-2xl font-semibold mb-4">Daftar Template</h2>
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">Nama Template</th>
                    <th class="p-4 text-left">File</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($templates as $template)
                    <tr>
                        <td class="p-4">{{ $template->name }}</td>
                        <td class="p-4">
                            <a href="{{ Storage::url($template->file_path) }}" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                        </td>
                        <td class="p-4">
                            <form action="{{ route('templates.destroy', $template->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>