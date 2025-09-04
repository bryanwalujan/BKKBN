<!DOCTYPE html>
<html>
<head>
    <title>Tambah Carousel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Tambah Carousel</h2>
        <form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="sub_heading" class="block text-sm font-medium text-gray-700">Sub Heading</label>
                <input type="text" name="sub_heading" id="sub_heading" value="{{ old('sub_heading') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('sub_heading')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="heading" class="block text-sm font-medium text-gray-700">Heading</label>
                <input type="text" name="heading" id="heading" value="{{ old('heading') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('heading')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="button_1_text" class="block text-sm font-medium text-gray-700">Button 1 Text (opsional)</label>
                <input type="text" name="button_1_text" id="button_1_text" value="{{ old('button_1_text') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('button_1_text')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="button_1_link" class="block text-sm font-medium text-gray-700">Button 1 Link (opsional)</label>
                <input type="url" name="button_1_link" id="button_1_link" value="{{ old('button_1_link') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('button_1_link')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="button_2_text" class="block text-sm font-medium text-gray-700">Button 2 Text (opsional)</label>
                <input type="text" name="button_2_text" id="button_2_text" value="{{ old('button_2_text') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('button_2_text')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="button_2_link" class="block text-sm font-medium text-gray-700">Button 2 Link (opsional)</label>
                <input type="url" name="button_2_link" id="button_2_link" value="{{ old('button_2_link') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('button_2_link')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar (opsional)</label>
                <input type="file" name="gambar" id="gambar" accept="image/jpeg,image/jpg,image/png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('gambar')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>