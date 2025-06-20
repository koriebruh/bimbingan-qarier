<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200 leading-tight">
                {{ __('Pemeriksaan Pasien') }}
            </h2>
            <a href="{{ route('dokter.Memeriksa.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Pasien Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                            <p class="mt-1 text-sm text-gray-900 font-semibold">{{ $janjiPeriksa->pasien->nama ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. HP</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $janjiPeriksa->pasien->no_hp ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Keluhan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $janjiPeriksa->keluhan ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jadwal</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $janjiPeriksa->jadwalPeriksa->hari ?? 'N/A' }},
                                {{ $janjiPeriksa->jadwalPeriksa->jam_mulai ?? 'N/A' }} - {{ $janjiPeriksa->jadwalPeriksa->jam_selesai ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pemeriksaan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Form Pemeriksaan</h3>

                    <form method="POST" action="{{ route('dokter.Memeriksa.store', $janjiPeriksa->id) }}" class="space-y-6">
                        @csrf

                        <!-- Tanggal Periksa -->
                        <div>
                            <x-input-label for="tgl_periksa" :value="__('Tanggal Periksa')" />
                            <x-text-input id="tgl_periksa"
                                          class="block mt-1 w-full"
                                          type="date"
                                          name="tgl_periksa"
                                          :value="old('tgl_periksa', date('Y-m-d'))"
                                          required />
                            <x-input-error :messages="$errors->get('tgl_periksa')" class="mt-2" />
                        </div>

                        <!-- Catatan Pemeriksaan -->
                        <div>
                            <x-input-label for="catatan" :value="__('Catatan Pemeriksaan')" />
                            <textarea id="catatan"
                                      name="catatan"
                                      rows="4"
                                      class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                      placeholder="Masukkan hasil pemeriksaan, diagnosis, atau catatan penting lainnya...">{{ old('catatan') }}</textarea>
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <!-- Pilih Obat -->
                        <div>
                            <x-input-label for="obat" :value="__('Pilih Obat')" />
                            <p class="text-sm text-gray-600 mb-3">Pilih obat yang akan diberikan kepada pasien (dapat memilih lebih dari satu)</p>

                            <div class="space-y-3 max-h-60 overflow-y-auto border border-gray-300 rounded-md p-4">
                                @forelse($obatList as $obat)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-150">
                                        <div class="flex items-center">
                                            <input id="obat_{{ $obat->id }}"
                                                   name="obat[]"
                                                   type="checkbox"
                                                   value="{{ $obat->id }}"
                                                   data-harga="{{ $obat->harga }}"
                                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded obat-checkbox"
                                                {{ in_array($obat->id, old('obat', [])) ? 'checked' : '' }}>
                                            <label for="obat_{{ $obat->id }}" class="ml-3 block text-sm font-medium text-gray-700 cursor-pointer">
                                                {{ $obat->nama_obat }}
                                            </label>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-semibold text-green-600">
                                                Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                            </span>
                                            @if($obat->kemasan)
                                                <p class="text-xs text-gray-500">{{ $obat->kemasan }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <p class="text-gray-500">Tidak ada obat tersedia</p>
                                    </div>
                                @endforelse
                            </div>
                            <x-input-error :messages="$errors->get('obat')" class="mt-2" />
                            <x-input-error :messages="$errors->get('obat.*')" class="mt-2" />
                        </div>

                        <!-- Informasi Biaya dengan Kalkulasi Real-time -->
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 w-full">
                                    <h3 class="text-sm font-medium text-blue-800">Informasi Biaya</h3>
                                    <div class="mt-2 text-sm text-blue-700 space-y-1">
                                        <div class="flex justify-between">
                                            <span>Biaya konsultasi dokter:</span>
                                            <strong>Rp 150.000</strong>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Biaya obat:</span>
                                            <strong id="biaya-obat">Rp 0</strong>
                                        </div>
                                        <hr class="border-blue-300 my-2">
                                        <div class="flex justify-between text-base font-semibold">
                                            <span>Total biaya:</span>
                                            <strong id="total-biaya" class="text-blue-900">Rp 150.000</strong>
                                        </div>
                                    </div>
                                    <div id="obat-terpilih" class="mt-3 text-xs text-blue-600">
                                        <p class="font-medium mb-1">Obat yang dipilih:</p>
                                        <ul id="list-obat-terpilih" class="list-disc list-inside space-y-1">
                                            <li class="text-gray-500 italic">Belum ada obat yang dipilih</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('dokter.Memeriksa.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <x-primary-button>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Selesaikan Pemeriksaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk kalkulasi biaya real-time -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.obat-checkbox');
            const biayaKonsultasi = 150000;

            // Object untuk menyimpan data obat
            const obatData = {};

            // Inisialisasi data obat dari checkbox
            checkboxes.forEach(checkbox => {
                const label = document.querySelector(`label[for="${checkbox.id}"]`);
                obatData[checkbox.value] = {
                    nama: label.textContent.trim(),
                    harga: parseInt(checkbox.dataset.harga)
                };
            });

            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            function updateBiaya() {
                let totalBiayaObat = 0;
                const obatTerpilih = [];

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const harga = parseInt(checkbox.dataset.harga);
                        totalBiayaObat += harga;
                        obatTerpilih.push({
                            nama: obatData[checkbox.value].nama,
                            harga: harga
                        });
                    }
                });

                // Update tampilan biaya
                document.getElementById('biaya-obat').textContent = formatRupiah(totalBiayaObat);
                document.getElementById('total-biaya').textContent = formatRupiah(biayaKonsultasi + totalBiayaObat);

                // Update daftar obat terpilih
                const listObatTerpilih = document.getElementById('list-obat-terpilih');

                if (obatTerpilih.length === 0) {
                    listObatTerpilih.innerHTML = '<li class="text-gray-500 italic">Belum ada obat yang dipilih</li>';
                } else {
                    listObatTerpilih.innerHTML = obatTerpilih.map(obat =>
                        `<li>${obat.nama} - ${formatRupiah(obat.harga)}</li>`
                    ).join('');
                }
            }

            // Event listener untuk setiap checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateBiaya();

                    // Animasi visual feedback
                    const parentDiv = this.closest('.flex');
                    if (this.checked) {
                        parentDiv.classList.add('bg-blue-50', 'border-blue-200');
                        parentDiv.classList.remove('bg-gray-50');
                    } else {
                        parentDiv.classList.remove('bg-blue-50', 'border-blue-200');
                        parentDiv.classList.add('bg-gray-50');
                    }
                });
            });

            // Inisialisasi tampilan biaya saat halaman dimuat
            updateBiaya();
        });
    </script>

    <style>
        /* Styling tambahan untuk feedback visual */
        .obat-checkbox:checked + label {
            color: #1e40af;
            font-weight: 600;
        }

        /* Smooth transition untuk perubahan background */
        .flex.items-center.justify-between {
            transition: all 0.2s ease-in-out;
        }

        /* Highlight untuk total biaya */
        #total-biaya {
            font-size: 1.1rem;
            transition: all 0.3s ease-in-out;
        }

        /* Animation untuk perubahan nilai */
        @keyframes highlight {
            0% { background-color: #fef3c7; }
            100% { background-color: transparent; }
        }

        .biaya-update {
            animation: highlight 0.5s ease-in-out;
        }
    </style>
</x-app-layout>
