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
                                {{ __('Edit Jadwal Periksa') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan perbarui informasi jadwal periksa sesuai kebutuhan.') }}
                            </p>

                            @if($activeSchedule && $activeSchedule->id != $jadwal->id)
                                <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-amber-700">
                                                <strong>Jadwal Aktif Saat Ini:</strong> {{ $activeSchedule->hari }} ({{ date('H:i', strtotime($activeSchedule->jam_mulai)) }} - {{ date('H:i', strtotime($activeSchedule->jam_selesai)) }})
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
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

                        <form class="mt-6 space-y-6" action="{{ route('dokter.JadwalPeriksa.update', $jadwal->id) }}" method="POST">
                            @csrf
                            @method('PUT')

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
                                        <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                        <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                        <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                        <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                        <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                        <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                        <option value="Minggu" {{ old('hari', $jadwal->hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                                    </select>
                                    @error('hari')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Jam Mulai --}}
                            <div>
                                <label for="jam_mulai" class="block text-sm font-medium leading-6 text-gray-900">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="time"
                                        name="jam_mulai"
                                        id="jam_mulai"
                                        value="{{ old('jam_mulai', $jadwal->jam_mulai) }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('jam_mulai') ring-red-500 focus:ring-red-500 @enderror"
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
                                        name="jam_selesai"
                                        id="jam_selesai"
                                        value="{{ old('jam_selesai', $jadwal->jam_selesai) }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('jam_selesai') ring-red-500 focus:ring-red-500 @enderror"
                                    >
                                    @error('jam_selesai')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status Aktif --}}
                            <div>
                                <label for="status" class="block text-sm font-medium leading-6 text-gray-900">
                                    Status
                                </label>
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            name="status"
                                            id="status"
                                            value="1"
                                            {{ old('status', $jadwal->status) ? 'checked' : '' }}
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-600 border-gray-300 rounded"
                                        >
                                        <label for="status" class="ml-2 block text-sm text-gray-900">
                                            Aktifkan jadwal ini
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Centang untuk mengaktifkan jadwal. Hanya satu jadwal yang dapat aktif pada satu waktu.
                                    </p>
                                    @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="flex items-center gap-4">
                                <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Update Jadwal
                                </button>

                                <a
                                    href="{{ route('dokter.JadwalPeriksa.index') }}"
                                    class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                >
                                    Batal
                                </a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
