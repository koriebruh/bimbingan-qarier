<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Janji Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Formulir Janji Periksa</h3>
                        <p class="mt-1 text-sm text-gray-600">Pilih jadwal dokter dan ceritakan keluhan Anda.</p>
                    </div>

                    <!-- Alert Messages -->
                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('pasien.JanjiPeriksa.store') }}">
                        @csrf

                        <!-- Pilih Jadwal Dokter -->
                        <div class="mb-6">
                            <x-input-label for="id_jadwal" :value="__('Pilih Jadwal Dokter')" />
                            <select id="id_jadwal" name="id_jadwal" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Jadwal Dokter --</option>
                                @foreach($jadwalPeriksa as $jadwal)
                                    <option value="{{ $jadwal->id }}" {{ old('id_jadwal') == $jadwal->id ? 'selected' : '' }}>
                                        Dr. {{ $jadwal->dokter->name }} - {{ optional($jadwal->dokter->poli)->name ?? 'Poli Unknown' }}
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
                                      required>{{ old('keluhan') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter</p>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        <!-- Info Box -->
                        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Nomor antrian akan diberikan otomatis setelah pendaftaran</li>
                                            <li>Datang 15 menit sebelum jadwal praktik dimulai</li>
                                            <li>Pastikan membawa kartu identitas saat pemeriksaan</li>
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
                                {{ __('Buat Janji Periksa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
