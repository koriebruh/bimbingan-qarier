<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Jadwal Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <section>
                    <header class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Daftar Jadwal Periksa') }}
                            </h2>
                            @if($activeSchedule)
                                <p class="mt-1 text-sm text-green-600">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                        Jadwal Aktif: {{ $activeSchedule->hari }} ({{ date('H:i', strtotime($activeSchedule->jam_mulai)) }} - {{ date('H:i', strtotime($activeSchedule->jam_selesai)) }})
                                    </span>
                                </p>
                            @else
                                <p class="mt-1 text-sm text-red-600">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                        Tidak ada jadwal aktif
                                    </span>
                                </p>
                            @endif
                        </div>
                        <div class="flex-col items-center justify-center text-center">
                            <a href="{{ route('dokter.JadwalPeriksa.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Tambah Jadwal
                            </a>

                            @if (session('success'))
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 4000)"
                                    class="text-sm text-green-600 mt-2"
                                >
                                    {{ session('success') }}
                                </p>
                            @endif

                            @if (session('error'))
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 4000)"
                                    class="text-sm text-red-600 mt-2"
                                >
                                    {{ session('error') }}
                                </p>
                            @endif
                        </div>
                    </header>

                    @if($jadwalPeriksa->count() > 0)
                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Mulai</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Selesai</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($jadwalPeriksa as $jadwal)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $jadwal->hari }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ date('H:i', strtotime($jadwal->jam_mulai)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($jadwal->status == 1)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Aktif
                                                    </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Tidak Aktif
                                                    </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                {{-- Toggle Status Button --}}
                                                <form action="{{ route('dokter.JadwalPeriksa.toggleStatus', $jadwal->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150
                                                                {{ $jadwal->status == 1 ? 'bg-gray-500 text-white hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:ring-gray-500' : 'bg-green-500 text-white hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:ring-green-500' }}
                                                                focus:outline-none focus:ring-2 focus:ring-offset-2">
                                                        {{ $jadwal->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>

                                                {{-- Edit Button --}}
                                                <a href="{{ route('dokter.JadwalPeriksa.edit', $jadwal->id) }}"
                                                   class="inline-flex items-center px-3 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Edit
                                                </a>

                                                {{-- Delete Button --}}
                                                <form action="{{ route('dokter.JadwalPeriksa.delete', $jadwal->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')"
                                                            class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="mt-6 text-center py-12">
                            <div class="mx-auto h-24 w-24 text-gray-400">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada jadwal periksa</h3>
                            <p class="mt-2 text-sm text-gray-500">Mulai dengan menambahkan jadwal periksa pertama Anda.</p>
                            <div class="mt-6">
                                <a href="{{ route('dokter.JadwalPeriksa.create') }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Tambah Jadwal Periksa
                                </a>
                            </div>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
