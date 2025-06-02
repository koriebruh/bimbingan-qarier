<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pemeriksaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Pemeriksaan Kesehatan</h3>
                        <p class="mt-1 text-sm text-gray-600">Catatan lengkap pemeriksaan dan resep obat yang pernah Anda terima.</p>
                    </div>

                    @if($historyPeriksa->count() > 0)
                        <!-- Summary Statistics -->
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-600">Total Pemeriksaan</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ $historyPeriksa->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-green-600">Total Biaya</p>
                                        <p class="text-lg font-bold text-green-900">
                                            Rp {{ number_format($historyPeriksa->sum('biaya_periksa'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto bg-white rounded-lg shadow">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dokter & Poli
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keluhan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Biaya
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($historyPeriksa as $periksa)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('H:i') }} WIB
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $periksa->janjiPeriksa->jadwalPeriksa->dokter->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $periksa->janjiPeriksa->jadwalPeriksa->dokter->poli }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                                {{ $periksa->janjiPeriksa->keluhan }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Selesai
                                                </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="openModal({{ $periksa->id }})"
                                                    class="text-blue-600 hover:text-blue-900 inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat pemeriksaan</h3>
                            <p class="mt-1 text-sm text-gray-500">Riwayat pemeriksaan akan muncul setelah Anda menjalani pemeriksaan dengan dokter.</p>
                            <div class="mt-6">
                                <a href="{{ route('pasien.JanjiPeriksa.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Buat Janji Periksa
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pemeriksaan -->
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Detail Pemeriksaan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div id="modalContent" class="mt-4">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Data pemeriksaan untuk modal (ini biasanya dari backend)
        const periksaData = {
            @foreach($historyPeriksa as $periksa)
                {{ $periksa->id }}: {
                id: {{ $periksa->id }},
                tanggal: '{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y') }}',
                waktu: '{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('H:i') }} WIB',
                dokter: '{{ $periksa->janjiPeriksa->jadwalPeriksa->dokter->name }}',
                poli: '{{ $periksa->janjiPeriksa->jadwalPeriksa->dokter->poli }}',
                noAntrian: '{{ $periksa->janjiPeriksa->no_antrian }}',
                jadwal: '{{ $periksa->janjiPeriksa->jadwalPeriksa->hari }}, {{ $periksa->janjiPeriksa->jadwalPeriksa->jam_mulai }} - {{ $periksa->janjiPeriksa->jadwalPeriksa->jam_selesai }}',
                keluhan: `{{ $periksa->janjiPeriksa->keluhan }}`,
                catatan: `{{ $periksa->catatan }}`,
                biaya: 'Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}',
                obat: [
                        @foreach($periksa->detailPeriksas as $detail)
                    {
                        nama: '{{ $detail->obat->nama_obat }}',
                        kemasan: '{{ $detail->obat->kemasan }}',
                        harga: 'Rp {{ number_format($detail->obat->harga, 0, ',', '.') }}'
                    },
                    @endforeach
                ]
            },
            @endforeach
        };

        function openModal(periksaId) {
            const data = periksaData[periksaId];
            if (!data) return;

            const modalContent = document.getElementById('modalContent');

            let obatHtml = '';
            if (data.obat.length > 0) {
                obatHtml = `
                    <div class="mb-6">
                        <h5 class="text-sm font-medium text-gray-700 mb-3">Resep Obat:</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            ${data.obat.map(obat => `
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 7.172V5L8 4z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">${obat.nama}</p>
                                            <p class="text-xs text-gray-600">${obat.kemasan}</p>
                                            <p class="text-xs text-green-600 font-medium mt-1">${obat.harga}</p>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }

            modalContent.innerHTML = `
                <!-- Header Info -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">${data.dokter}</h4>
                                <p class="text-sm text-gray-600">${data.poli}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">${data.tanggal}</p>
                            <p class="text-sm text-gray-500">${data.waktu}</p>
                        </div>
                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500">No. Antrian</p>
                        <p class="text-sm font-medium text-gray-900">${data.noAntrian}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-500">Jadwal Praktik</p>
                        <p class="text-sm font-medium text-gray-900">${data.jadwal}</p>
                    </div>
                </div>

                <!-- Keluhan Awal -->
                <div class="mb-4">
                    <h5 class="text-sm font-medium text-gray-700 mb-2">Keluhan Awal:</h5>
                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-md">${data.keluhan}</p>
                </div>

                <!-- Hasil Pemeriksaan -->
                <div class="mb-4">
                    <h5 class="text-sm font-medium text-gray-700 mb-2">Hasil Pemeriksaan & Diagnosa:</h5>
                    <p class="text-sm text-gray-600 bg-blue-50 p-3 rounded-md">${data.catatan}</p>
                </div>

                <!-- Obat -->
                ${obatHtml}

                <!-- Total Biaya -->
                <div class="bg-gray-50 p-4 rounded-lg border-t">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-900">Total Biaya Pemeriksaan:</span>
                        <span class="text-lg font-bold text-gray-900">${data.biaya}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Termasuk biaya konsultasi dan obat</p>
                </div>
            `;

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-app-layout>
