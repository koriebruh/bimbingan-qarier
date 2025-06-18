<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Tambah Jadwal Periksa') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan isi form di bawah ini untuk menambahkan jadwal periksa baru.') }}
                            </p>
                        </header>

                        @if ($errors->any())
                            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Terdapat beberapa kesalahan:</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul role="list" class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form class="mt-6 space-y-6" action="{{ route('dokter.JadwalPeriksa.store') }}" method="POST">
                            @csrf

                            {{-- Hari --}}
                            <div>
                                <label for="hari" class="block text-sm font-medium leading-6 text-gray-900">
                                    Hari <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-2">
                                    <select
                                        name="hari"
                                        id="hari"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('hari') ring-red-500 focus:ring-red-500 @enderror"
                                    >
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                        <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                        <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                    </select>
                                    @error('hari')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                {{-- Jam Mulai --}}
                                <div>
                                    <label for="jam_mulai" class="block text-sm font-medium leading-6 text-gray-900">
                                        Jam Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input
                                            type="time"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('jam_mulai') ring-red-500 focus:ring-red-500 @enderror"
                                            id="jam_mulai"
                                            name="jam_mulai"
                                            value="{{ old('jam_mulai') }}"
                                        >
                                        @error('jam_mulai')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Jam Selesai --}}
                                <div>
                                    <label for="jam_selesai" class="block text-sm font-medium leading-6 text-gray-900">
                                        Jam Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input
                                            type="time"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('jam_selesai') ring-red-500 focus:ring-red-500 @enderror"
                                            id="jam_selesai"
                                            name="jam_selesai"
                                            value="{{ old('jam_selesai') }}"
                                        >
                                        @error('jam_selesai')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-medium leading-6 text-gray-900">
                                    Status Jadwal <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-3 space-y-3">
                                    <div class="flex items-center">
                                        <input
                                            id="status_aktif"
                                            name="status"
                                            type="radio"
                                            value="1"
                                            {{ old('status') == '1' ? 'checked' : '' }}
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        >
                                        <label for="status_aktif" class="ml-3 block text-sm font-medium leading-6 text-gray-900">
                                            Aktif
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input
                                            id="status_tidak_aktif"
                                            name="status"
                                            type="radio"
                                            value="0"
                                            {{ old('status') == '0' || old('status') === null ? 'checked' : '' }}
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                        >
                                        <label for="status_tidak_aktif" class="ml-3 block text-sm font-medium leading-6 text-gray-900">
                                            Tidak Aktif
                                        </label>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Jika status diatur sebagai "Aktif", jadwal lain yang sebelumnya aktif akan dinonaktifkan secara otomatis.
                                </p>
                                @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center justify-end gap-x-6">
                                <a href="{{ route('dokter.JadwalPeriksa.index') }}"
                                   class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 transition-colors duration-150">
                                    Batal
                                </a>
                                <button type="submit"
                                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-150">
                                    Simpan Jadwal
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
