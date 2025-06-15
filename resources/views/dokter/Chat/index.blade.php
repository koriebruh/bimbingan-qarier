{{-- resources/views/dokter/Chat/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Chat Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if($daftarChat->isEmpty())
                        <div class="text-center py-12">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700">
                                <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Tidak ada chat</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada pasien yang memulai chat dengan Anda.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($daftarChat as $janji)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 hover:bg-gray-100 dark:hover:bg-gray-600 transition duration-150 ease-in-out">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                                    <span class="text-indigo-600 dark:text-indigo-300 font-medium text-lg">
                                                        {{ strtoupper(substr($janji->pasien->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-2 mb-1">
                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 truncate">
                                                        {{ $janji->pasien->name }}
                                                    </h3>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                        Belum Diperiksa
                                                    </span>
                                                </div>

                                                <div class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                                                    <p><span class="font-medium">Email:</span> {{ $janji->pasien->email }}</p>
                                                    <p><span class="font-medium">Tanggal Janji:</span> {{ $janji->jadwalPeriksa->hari }}</p>
                                                    <p><span class="font-medium">Jam:</span> {{ $janji->jadwalPeriksa->jam_mulai }} - {{ $janji->jadwalPeriksa->jam_selesai }}</p>
                                                    @if($janji->keluhan)
                                                        <p><span class="font-medium">Keluhan:</span> {{ Str::limit($janji->keluhan, 100) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('dokter.Chat.detail', $janji->pasien->id) }}"
                                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out">
                                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                </svg>
                                                Mulai Chat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
