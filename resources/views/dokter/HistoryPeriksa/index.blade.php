<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History Pemeriksaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Pemeriksaan Pasien</h3>
                        <p class="mt-1 text-sm text-gray-600">Daftar pasien yang telah Anda periksa beserta detail diagnosa dan resep obat.</p>
                    </div>

                    @if($historyPeriksa->count() > 0)
                        <!-- Summary Statistics -->
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-blue-600">Total Pasien</p>
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
                                        <p class="text-sm font-medium text-green-600">Total Pendapatan</p>
                                        <p class="text-lg font-bold text-green-900">
                                            Rp {{ number_format($historyPeriksa->sum('biaya_periksa'), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-purple-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 7.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-purple-600">Obat Diresepkan</p>
                                        <p class="text-2xl font-bold text-purple-900">
                                            {{ $historyPeriksa->sum(function($periksa) { return $periksa->detailPeriksas->count(); }) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-orange-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a2 2 0 11-4 0 2 2 0 014 0zM8 11V7a4 4 0 118 0v4M3 15h18l-2 7H5l-2-7z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-orange-600">Hari Ini</p>
                                        <p class="text-2xl font-bold text-orange-900">
                                            {{ $historyPeriksa->where('tgl_periksa', '>=', now()->startOfDay())->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dari</label>
                                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sampai</label>
                                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pasien</label>
                                    <input type="text" placeholder="Nama pasien..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                                        Pasien
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keluhan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Diagnosa
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Obat
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
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-blue-600">
                                                                {{ substr($periksa->janjiPeriksa->pasien->name, 0, 1) }}
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $periksa->janjiPeriksa->pasien->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        No. Antrian: {{ $periksa->janjiPeriksa->no_antrian }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs">
                                                <div class="truncate">{{ $periksa->janjiPeriksa->keluhan }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs">
                                                <div class="truncate">{{ $periksa->catatan }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($periksa->detailPeriksas->take(2) as $detail)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ $detail->obat->nama_obat }}
                                                        </span>
                                                @endforeach
                                                @if($periksa->detailPeriksas->count() > 2)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            +{{ $periksa->detailPeriksas->count() - 2 }} lainnya
                                                        </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="font-medium">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="openModal({{ $periksa->id }})"
                                                    class="text-blue-600 hover:text-blue-900 inline-flex items-center mr-3">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </button>
                                            <button class="text-green-600 hover:text-green-900 inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                                </svg>
                                                Print
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination (if needed) -->
                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">{{ $historyPeriksa->count() }}</span> dari <span class="font-medium">{{ $historyPeriksa->count() }}</span> hasil
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-2 text-sm border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Sebelumnya
                                </button>
                                <button class="px-3 py-2 text-sm border border-gray-300 rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    1
                                </button>
                                <button class="px-3 py-2 text-sm border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Selanjutnya
                                </button>
                            </div>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat pemeriksaan</h3>
                            <p class="mt-1 text-sm text-gray-500">Riwayat pemeriksaan pasien akan muncul setelah Anda melakukan pemeriksaan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pemeriksaan -->
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Detail Pemeriksaan Pasien</h3>
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
        // Data pemeriksaan untuk modal
        const periksaData = {
            @foreach($historyPeriksa as $periksa)
                {{ $periksa->id }}: {
                id: {{ $periksa->id }},
                tanggal: '{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y') }}',
                waktu: '{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('H:i') }} WIB',
                pasien: '{{ $periksa->janjiPeriksa->pasien->name }}',
                alamat: '{{ $periksa->janjiPeriksa->pasien->alamat }}',
                noHp: '{{ $periksa->janjiPeriksa->pasien->no_hp }}',
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
                        <h5 class="text-sm font-medium text-gray-700 mb-3">Resep Obat yang Diberikan:</h5>
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
                <!-- Patient Info Header -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-xl font-bold text-blue-600">${data.pasien.charAt(0)}</span>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">${data.pasien}</h4>
                                <p class="text-sm text-gray-600">${data.alamat}</p>
                                <p class="text-sm text-gray-600">📞 ${data.noHp}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">${data.tanggal}</p>
                            <p class="text-sm text-gray-500">${data.waktu}</p>
                            <p class="text-xs text-blue-600 font-medium">No. Antrian: ${data.noAntrian}</p>
                        </div>
                    </div>
                </div>

                <!-- Examination Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Keluhan Pasien -->
                    <div class="bg-red-50 p-4 rounded-lg">
                        <h5 class="text-sm font-medium text-red-700 mb-2">Keluhan Pasien:</h5>
                        <p class="text-sm text-gray-700">${data.keluhan}</p>
                    </div>

                    <!-- Diagnosa & Catatan -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h5 class="text-sm font-medium text-blue-700 mb-2">Diagnosa & Catatan Dokter:</h5>
                        <p class="text-sm text-gray-700">${data.catatan}</p>
                    </div>
                </div>

                <!-- Resep Obat -->
                ${obatHtml}

                <!-- Summary -->
                <div class="bg-gray-50 p-4 rounded-lg border-t mt-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Jadwal Pemeriksaan:</p>
                            <p class="font-medium text-gray-900">${data.jadwal}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Total Biaya Pemeriksaan:</p>
                            <p class="text-lg font-bold text-gray-900">${data.biaya}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button onclick="printReceipt(${data.id})" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Resep
                    </button>
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Tutup
                    </button>
                </div>
            `;

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function printReceipt(periksaId) {
            // Implement print functionality
            alert('Fitur print akan diimplementasikan');
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
