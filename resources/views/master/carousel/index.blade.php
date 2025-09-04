<!DOCTYPE html>
<html>
<head>
    <title>Data Carousel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Data Carousel</h2>
        <a href="{{ route('carousel.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Carousel</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Sub Heading</th>
                    <th class="p-4 text-left">Heading</th>
                    <th class="p-4 text-left">Deskripsi</th>
                    <th class="p-4 text-left">Button 1</th>
                    <th class="p-4 text-left">Button 2</th>
                    <th class="p-4 text-left">Gambar</th>
                    <th class="p-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carousels as $index => $carousel)
                    <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-gray-200' }}">
                        <td class="p-4">{{ $index + 1 }}</td>
                        <td class="p-4">{{ $carousel->sub_heading }}</td>
                        <td class="p-4">{{ $carousel->heading }}</td>
                        <td class="p-4">{{ Str::limit($carousel->deskripsi, 50) }}</td>
                        <td class="p-4">
                            @if ($carousel->button_1_text && $carousel->button_1_link)
                                {{ $carousel->button_1_text }} ({{ $carousel->button_1_link }})
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($carousel->button_2_text && $carousel->button_2_link)
                                {{ $carousel->button_2_text }} ({{ $carousel->button_2_link }})
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            @if ($carousel->gambar)
                                <img src="{{ asset('storage/' . $carousel->gambar) }}" alt="Gambar {{ $carousel->heading }}" class="w-16 h-16 object-cover rounded">
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('carousel.edit', $carousel->id) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('carousel.destroy', $carousel->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus data Carousel ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>