<x-app-layout>
<x-slot name="header">Profil Identitas</x-slot>

@if(session('success'))
<div class="bg-green-500 text-white p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('profile.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
@csrf
@method('PATCH')

<input name="name" value="{{ $user->name }}" placeholder="Nama Lengkap" class="input" />
<input name="tempat_lahir" value="{{ $user->tempat_lahir }}" placeholder="Tempat Lahir" class="input" />
<input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" class="input" />

<select name="jenis_kelamin" class="input">
    <option value="L">Laki-laki</option>
    <option value="P">Perempuan</option>
</select>

<input name="no_hp" value="{{ $user->no_hp }}" placeholder="No HP" class="input" />
<textarea name="alamat" class="input col-span-2">{{ $user->alamat }}</textarea>

<button class="bg-blue-600 text-white py-2 rounded col-span-2">
    Simpan
</button>
</form>
</x-app-layout>
