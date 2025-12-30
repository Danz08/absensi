<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">

            {{-- LEFT HEADER --}}
            <div class="flex items-center gap-4">
                {{-- ICON --}}
                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-green-100 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.88 17.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-2xl font-extrabold tracking-wide text-green-600">
                        Profil Identitas
                    </h2>
                    <p class="text-sm text-gray-500">
                        Kelola dan perbarui data pribadi akun Anda
                    </p>
                </div>
            </div>

            {{-- BUTTON KEMBALI --}}
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                      bg-green-600 hover:bg-green-700 text-white font-semibold transition shadow">
                ← Kembali
            </a>

        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 space-y-6">

            {{-- ALERT SUCCESS --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- FORM CARD --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200">

                <div class="px-8 py-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Informasi Pribadi
                    </h3>
                    <p class="text-sm text-gray-500">
                        Data ini digunakan untuk identitas dan keperluan absensi
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}"
                    class="px-8 py-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PATCH')

                    {{-- NAMA --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                            required>
                    </div>

                    {{-- TEMPAT LAHIR --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    </div>

                    {{-- TANGGAL LAHIR --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    </div>

                    {{-- JENIS KELAMIN --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="P" {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>

                    {{-- NO HP --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">No HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">
                    </div>

                    {{-- ALAMAT --}}
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="alamat" rows="3"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    {{-- ACTION --}}
                    <div class="md:col-span-2 flex justify-end pt-4">
                        <button
                            class="px-8 py-3 bg-green-600 hover:bg-green-700 transition
                                   text-white font-semibold rounded-xl shadow">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
