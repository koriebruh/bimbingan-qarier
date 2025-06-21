<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Tambah Dokter
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.dokter.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900">Nama</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="Nama lengkap"
                        >
                        @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="Email aktif"
                        >
                        @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-900">Alamat</label>
                        <input
                            type="text"
                            id="alamat"
                            name="alamat"
                            value="{{ old('alamat') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="Alamat lengkap"
                        >
                        @error('alamat')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No. KTP --}}
                    <div>
                        <label for="no_ktp" class="block text-sm font-medium text-gray-900">No. KTP</label>
                        <input
                            type="text"
                            id="no_ktp"
                            name="no_ktp"
                            value="{{ old('no_ktp') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="16 digit KTP"
                        >
                        @error('no_ktp')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No. HP --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-900">No. HP</label>
                        <input
                            type="text"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="08xxxxxxxx"
                        >
                        @error('no_hp')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="Minimal 8 karakter"
                        >
                        @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Konfirmasi Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="Ulangi password"
                        >
                    </div>

                    {{-- Pilih Poli (Opsional, hanya untuk role 'dokter') --}}
                    <div>
                        <label for="poli_id" class="block text-sm font-medium text-gray-900">Poli (Opsional)</label>
                        <select
                            id="poli_id"
                            name="poli_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 sm:text-sm"
                        >
                            <option value="">-- Pilih Poli --</option>
                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" {{ old('poli_id') == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('poli_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('admin.dokter.index') }}"
                           class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
