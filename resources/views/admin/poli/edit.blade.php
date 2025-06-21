<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Edit Poli
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.poli.update', $poli->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama Poli --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900">Nama Poli</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $poli->name) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm"
                            placeholder="Contoh: Poli Umum, Poli Anak"
                        >
                        @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('admin.poli.index') }}"
                           class="text-sm font-semibold text-gray-700 hover:text-gray-900">
                            Batal
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-500 transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
