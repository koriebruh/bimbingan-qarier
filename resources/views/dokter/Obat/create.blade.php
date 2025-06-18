<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Tambah Data Obat') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan isi form di bawah ini untuk menambahkan data obat ke dalam sistem.') }}
                            </p>
                        </header>

                        <form class="mt-6 space-y-6" id="formObat" action="{{ route('dokter.obat.store') }}" method="POST">
                            @csrf

                            {{-- Nama Obat --}}
                            <div>
                                <label for="namaObat" class="block text-sm font-medium leading-6 text-gray-900">
                                    Nama Obat
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('nama_obat') ring-red-500 focus:ring-red-500 @enderror"
                                        id="namaObat"
                                        name="nama_obat"
                                        value="{{ old('nama_obat') }}"
                                        placeholder="Masukkan nama obat"
                                    >
                                    @error('nama_obat')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kemasan --}}
                            <div>
                                <label for="kemasan" class="block text-sm font-medium leading-6 text-gray-900">
                                    Kemasan
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('kemasan') ring-red-500 focus:ring-red-500 @enderror"
                                        id="kemasan"
                                        name="kemasan"
                                        value="{{ old('kemasan') }}"
                                        placeholder="Contoh: Tablet 500mg, Kapsul 250mg"
                                    >
                                    @error('kemasan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Harga --}}
                            <div>
                                <label for="harga" class="block text-sm font-medium leading-6 text-gray-900">
                                    Harga
                                </label>
                                <div class="mt-2">
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input
                                            type="number"
                                            class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('harga') ring-red-500 focus:ring-red-500 @enderror"
                                            id="harga"
                                            name="harga"
                                            value="{{ old('harga') }}"
                                            placeholder="0"
                                            min="0"
                                            step="100"
                                        >
                                    </div>
                                    @error('harga')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center justify-end gap-x-6">
                                <a href="{{ route('dokter.obat.index') }}"
                                   class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 transition-colors duration-150">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-150">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
