<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-4xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-2xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Perbarui Informasi Pasien') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan perbarui informasi nama, email, alamat, no KTP, dan no HP dokter.') }}
                            </p>
                        </header>

                        <form class="mt-6 space-y-6" action="{{ route('admin.pasien.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nama --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-900">
                                    Nama
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Nama lengkap"
                                    >
                                    @error('name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-900">
                                    Email
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Email aktif"
                                    >
                                    @error('email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-900">
                                    Alamat
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        id="alamat"
                                        name="alamat"
                                        value="{{ old('alamat', $user->alamat) }}"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Alamat lengkap"
                                    >
                                    @error('alamat')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- No KTP --}}
                            <div>
                                <label for="no_ktp" class="block text-sm font-medium text-gray-900">
                                    No. KTP
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        id="no_ktp"
                                        name="no_ktp"
                                        value="{{ old('no_ktp', $user->no_ktp) }}"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="16 digit KTP"
                                    >
                                    @error('no_ktp')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div>
                                <label for="no_hp" class="block text-sm font-medium text-gray-900">
                                    No. HP
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        id="no_hp"
                                        name="no_hp"
                                        value="{{ old('no_hp', $user->no_hp) }}"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="08xxxxxxxxxx"
                                    >
                                    @error('no_hp')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            {{-- (Opsional) Ubah Password --}}
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-900">
                                    Password Baru (Opsional)
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        placeholder="Biarkan kosong jika tidak diubah"
                                    >
                                    @error('password')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="flex items-center justify-end gap-x-4">
                                <a href="{{ route('admin.pasien.index') }}"
                                   class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500 transition">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
