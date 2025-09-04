<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Riset</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function toggleJudulKustom() {
            const judulSelect = document.getElementById('judul');
            const judulKustomDiv = document.getElementById('judul_kustom_div');
            const angkaInput = document.getElementById('angka');
            if (judulSelect.value === 'Lainnya') {
                judulKustomDiv.classList.remove('hidden');
                angkaInput.disabled = false;
            } else {
                judulKustomDiv.classList.add('hidden');
                angkaInput.disabled = judulSelect.value !== '';
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Riset</h2>
        <form action="{{ route('data_riset.update', $dataRiset->id) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <select name="judul" id="judul" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" onchange="toggleJudulKustom()" required>
                    <option value="" disabled>-- Pilih Judul --</option>
                    @foreach ($realtimeJudul as $judul)
                        <option value="{{ $judul }}" {{ old('judul', $dataRiset->judul) == $judul ? 'selected' : '' }}>{{ $judul }}</option>
                    @endforeach
                    <option value="Lainnya" {{ old('judul', in_array($dataRiset->judul, $realtimeJudul) ? '' : 'Lainnya') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('judul')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div id="judul_kustom_div" class="mb-4 {{ in_array($dataRiset->judul, $realtimeJudul) ? 'hidden' : '' }}">
                <label for="judul_kustom" class="block text-sm font-medium text-gray-700">Judul Kustom</label>
                <input type="text" name="judul_kustom" id="judul_kustom" value="{{ old('judul_kustom', in_array($dataRiset->judul, $realtimeJudul) ? '' : $dataRiset->judul) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('judul_kustom')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="angka" class="block text-sm font-medium text-gray-700">Angka</label>
                <input type="number" name="angka" id="angka" value="{{ old('angka', $dataRiset->angka) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="0" required {{ in_array($dataRiset->judul, $realtimeJudul) ? 'disabled' : '' }}>
                @error('angka')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Angka akan diisi otomatis untuk judul realtime.</p>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
</body>
</html>