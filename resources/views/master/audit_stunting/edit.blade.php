<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Audit Stunting</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('master.partials.sidebar')
    <div class="ml-64 p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Data Audit Stunting</h2>
        <a href="{{ route('audit_stunting.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-gray-600">Kembali</a>
        <form method="POST" action="{{ route('audit_stunting.update', $auditStunting->id) }}" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="data_monitoring_id" class="block text-sm font-medium text-gray-700">Data Monitoring</label>
                    <select name="data_monitoring_id" id="data_monitoring_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="">Pilih Data Monitoring</option>
                        @foreach (App\Models\DataMonitoring::all() as $monitoring)
                            <option value="{{ $monitoring->id }}" {{ old('data_monitoring_id', $auditStunting->data_monitoring_id) == $monitoring->id ? 'selected' : '' }}>
                                {{ $monitoring->nama }} ({{ $monitoring->target }} - {{ $monitoring->kategori }})
                            </option>
                        @endforeach
                    </select>
                    @error('data_monitoring_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pengaudit</label>
                    <input type="hidden" name="user_id" value="{{ old('user_id', $auditStunting->user_id) }}">
                    <p class="mt-1 text-sm text-gray-600">{{ $auditStunting->user ? $auditStunting->user->name : 'Pengaudit tidak ditemukan' }}</p>
                </div>
                <div>
                    <label for="pihak_pengaudit" class="block text-sm font-medium text-gray-700">Pihak Pengaudit</label>
                    <input type="text" name="pihak_pengaudit" id="pihak_pengaudit" value="{{ old('pihak_pengaudit', $auditStunting->pihak_pengaudit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                    @error('pihak_pengaudit')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="foto_dokumentasi" class="block text-sm font-medium text-gray-700">Foto Dokumentasi</label>
                    <input type="file" name="foto_dokumentasi" id="foto_dokumentasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @if ($auditStunting->foto_dokumentasi)
                        <img src="{{ Storage::url($auditStunting->foto_dokumentasi) }}" alt="Foto Dokumentasi" class="w-16 h-16 object-cover rounded mt-2">
                    @endif
                    @error('foto_dokumentasi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="laporan" class="block text-sm font-medium text-gray-700">Laporan</label>
                    <textarea name="laporan" id="laporan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('laporan', $auditStunting->laporan) }}</textarea>
                    @error('laporan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2">
                    <label for="narasi" class="block text-sm font-medium text-gray-700">Narasi</label>
                    <textarea name="narasi" id="narasi" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('narasi', $auditStunting->narasi) }}</textarea>
                    @error('narasi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data_monitoring_id').select2({ placeholder: 'Pilih Data Monitoring', allowClear: true });
        });
    </script>
</body>
</html>