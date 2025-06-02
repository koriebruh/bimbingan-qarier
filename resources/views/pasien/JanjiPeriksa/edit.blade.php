<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Janji Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Edit Janji Periksa</h3>
                        <p class="mt-1 text-sm text-gray-600">Ubah jadwal dokter atau keluhan Anda.</p>
                    </div>

                    <!-- Current Appointment Info -->
                    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-md p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-800">{{ $janjiPeriksa->no_antrian }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-gray-900">Janji Periksa Saat Ini</h4>
                                <p class="text-sm text-gray-600">
                                    Dr. {{ $janjiPeriksa->jadwalPeriksa->dokter->name }} - {{ $janjiPeriksa->jadwalPeriksa->dokter->poli }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $janjiPeriksa->jadwalPeriksa->hari }}, {{ $janjiPeriksa->jadwalPeriksa->jam_mulai }} - {{ $janjiPeriksa->jadwalPeriksa->jam_selesai }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Dibuat: {{ $janjiPeriksa->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('pasien.JanjiPeriksa.update', $janjiPeriksa) }}">
                        @csrf
                        @method('PUT')

                        <!-- Pilih Jadwal Dokter -->
                        <div class="mb-6">
                            <x-input-label for="id_jadwal" :value="__('Pilih Jadwal Dokter')" />
                            <select id="id_jadwal" name="id_jadwal" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Jadwal Dokter --</option>
                                @foreach($jadwalPeriksa as $jadwal)
                                    <option value="{{ $jadwal->id }}"
                                        {{ (old('id_jadwal', $janjiPeriksa->id_jadwal) == $jadwal->id) ? 'selected' : '' }}>
                                        Dr. {{ $jadwal->dokter->name }} - {{ $jadwal->dokter->poli }}
                                        ({{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_jadwal')" class="mt-2" />
                        </div>

                        <!-- Keluhan -->
                        <div class="mb-6">
                            <x-input-label for="keluhan" :value="__('Keluhan')" />
                            <textarea id="keluhan"
                                      name="keluhan"
                                      rows="4"
                                      class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      placeholder="Ceritakan keluhan atau gejala yang Anda alami..."
                                      maxlength="500"
                                      required>{{ old('keluhan', $janjiPeriksa->keluhan) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter</p>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        <!-- Warning Box -->
                        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Jika Anda mengubah jadwal dokter, nomor antrian akan berubah</li>
                                            <li>Pastikan perubahan sudah sesuai sebelum menyimpan</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('pasien.JanjiPeriksa.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
