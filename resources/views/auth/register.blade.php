<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>
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
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin_kelurahan" {{ old('role') == 'admin_kelurahan' ? 'selected' : '' }}>Admin Kelurahan</option>
                    <option value="perangkat_daerah" {{ old('role') == 'perangkat_daerah' ? 'selected' : '' }}>Perangkat Daerah</option>
                </select>
                @error('role')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                    @endforeach
                </select>
                @error('kecamatan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="kelurahan_id" class="block text-sm font-medium text-gray-700" id="kelurahan_label">Kelurahan/Desa</label>
                <select name="kelurahan_id" id="kelurahan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Pilih Kelurahan/Desa --</option>
                    @if (old('kecamatan_id'))
                        @foreach (\App\Models\Kelurahan::where('kecamatan_id', old('kecamatan_id'))->get() as $kelurahan)
                            <option value="{{ $kelurahan->id }}" {{ old('kelurahan_id') == $kelurahan->id ? 'selected' : '' }}>{{ $kelurahan->nama_kelurahan }}</option>
                        @endforeach
                    @endif
                </select>
                @error('kelurahan_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="penanggung_jawab" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" id="penanggung_jawab" value="{{ old('penanggung_jawab') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('penanggung_jawab')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('no_telepon')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pas_foto" class="block text-sm font-medium text-gray-700">Pas Foto</label>
                <input type="file" name="pas_foto" id="pas_foto" class="mt-1 block w-full" accept="image/jpeg,image/png" required>
                @error('pas_foto')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="surat_pengajuan" class="block text-sm font-medium text-gray-700">Surat Pengajuan</label>
                <input type="file" name="surat_pengajuan" id="surat_pengajuan" class="mt-1 block w-full" accept="application/pdf" required>
                @error('surat_pengajuan')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            {{-- <div class="mb-4">
                <label for="captcha" class="block text-sm font-medium text-gray-700">CAPTCHA</label>
                <div class="flex items-center space-x-2">
                    <img src="{{ captcha_src() }}" alt="CAPTCHA" class="h-10" id="captcha-img">
                    <a href="#" onclick="document.getElementById('captcha-img').src='{{ captcha_src() }}'+'?'+Math.random()" class="text-blue-500 hover:underline">Refresh</a>
                </div>
                <input type="text" name="captcha" id="captcha" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('captcha')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div> --}}
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Daftar</button>
        </form>
        <p class="mt-4 text-center">
            <a href="{{ route('download.template') }}" class="text-blue-500 hover:underline">Download Template Surat Pengajuan</a>
        </p>
        <p class="mt-2 text-center">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>
    <script>
        $(document).ready(function() {
            $('#kecamatan_id').select2({
                placeholder: '-- Pilih Kecamatan --',
                allowClear: true
            });
            $('#kelurahan_id').select2({
                placeholder: '-- Pilih Kelurahan/Desa --',
                allowClear: true
            });

            $('#kecamatan_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#kelurahan_id').empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>').trigger('change');

                if (kecamatanId) {
                    $.ajax({
                        url: '/kelurahans/by-kecamatan/' + kecamatanId,
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }
                            $.each(data, function(index, kelurahan) {
                                $('#kelurahan_id').append('<option value="' + kelurahan.id + '">' + kelurahan.nama_kelurahan + '</option>');
                            });
                            $('#kelurahan_id').trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Gagal mengambil data kelurahan:', xhr);
                            alert('Gagal memuat kelurahan. Silakan coba lagi.');
                        }
                    });
                }
            });

            $('#role').on('change', function() {
                const kelurahanLabel = $('#kelurahan_label');
                kelurahanLabel.text(kelurahanLabel.text().replace(/Kelurahan|Desa/g, this.value === 'perangkat_daerah' ? 'Desa' : 'Kelurahan'));
            }).trigger('change');

            // Trigger change untuk memuat kelurahan jika ada old('kecamatan_id')
            @if (old('kecamatan_id'))
                $('#kecamatan_id').val('{{ old('kecamatan_id') }}').trigger('change');
            @endif
        });
    </script>
</body>
</html>
