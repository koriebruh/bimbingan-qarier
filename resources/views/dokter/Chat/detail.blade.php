{{-- resources/views/dokter/Chat/detail.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Chat dengan ') }}
                @if($chats->isNotEmpty())
                    {{ $chats->first()->pasien->name }}
                @else
                    Pasien
                @endif
            </h2>
            <a href="{{ route('dokter.Chat.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Chat Container -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <!-- Chat Messages -->
                <div class="h-96 overflow-y-auto p-6 space-y-4" id="chatMessages">
                    @if($chats->isEmpty())
                        <div class="text-center py-12">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700">
                                <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada pesan</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai percakapan dengan mengirim pesan pertama.</p>
                        </div>
                    @else
                        @foreach($chats->reverse() as $chat)
                            @php
                                $isDokter = $chat->sender_role === 'dokter';
                                $isCurrentUser = ($isDokter && auth()->user()->id === $chat->dokter_id) || (!$isDokter && auth()->user()->id === $chat->pasien_id);
                            @endphp

                            <div class="flex {{ $isCurrentUser ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $isCurrentUser ? 'bg-indigo-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100' }}">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs {{ $isCurrentUser ? 'text-indigo-100' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $isDokter ? 'Dr. ' . $chat->dokter->name : $chat->pasien->name }}
                                        </span>
                                        @if($chat->is_edited)
                                            <span class="text-xs {{ $isCurrentUser ? 'text-indigo-200' : 'text-gray-400 dark:text-gray-500' }}">
                                                (diedit)
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-sm break-words">{{ $chat->message }}</p>

                                    <div class="flex items-center justify-between mt-2">
                                        <span class="text-xs {{ $isCurrentUser ? 'text-indigo-200' : 'text-gray-400 dark:text-gray-500' }}">
                                            {{ $chat->created_at->format('H:i') }}
                                        </span>

                                        @if($isCurrentUser && $isDokter)
                                            <div class="flex space-x-1">
                                                <button onclick="editMessage({{ $chat->id }}, '{{ addslashes($chat->message) }}')"
                                                        class="text-xs {{ $isCurrentUser ? 'text-indigo-200 hover:text-indigo-100' : 'text-gray-400 hover:text-gray-600' }}">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('dokter.Chat.destroy', $chat->id) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin menghapus pesan ini?')"
                                                            class="text-xs {{ $isCurrentUser ? 'text-indigo-200 hover:text-indigo-100' : 'text-gray-400 hover:text-gray-600' }}">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Message Input Form -->
                <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4">
                    <form method="POST" action="{{ route('dokter.Chat.store') }}" class="flex space-x-4">
                        @csrf
                        <input type="hidden" name="dokter_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="pasien_id" value="{{ $id_pasien ?? request()->route('id_pasien') }}">
                        <input type="hidden" name="sender_role" value="dokter">

                        <div class="flex-1">
                            <textarea name="message"
                                      id="messageInput"
                                      rows="3"
                                      placeholder="Ketik pesan Anda..."
                                      class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm resize-none"
                                      required></textarea>
                            @error('message')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex-shrink-0">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Message Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Edit Pesan</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <textarea id="editMessage"
                                  name="message"
                                  rows="3"
                                  class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm resize-none"
                                  required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                                onclick="closeEditModal()"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editMessage(chatId, currentMessage) {
            // Perbaikan: Gunakan route yang benar sesuai dengan definisi di web.php
            document.getElementById('editForm').action = `{{ route('dokter.Chat.update', ':id') }}`.replace(':id', chatId);
            document.getElementById('editMessage').value = currentMessage;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Auto scroll to bottom on page load
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        // Auto resize textarea
        document.getElementById('messageInput').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    </script>
</x-app-layout>
