<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row flex flex-row justify-between items-center">
                        <div class="flex justify-center">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ __('Kelola Kode Rak Buku') }}
                            </h2>
                        </div>
                        <div class="flex justify-center">
                            <x-primary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'add-bookshelves')">
                                {{ __('Tambah Kode Rak') }}
                            </x-primary-button>
                            <x-primary-button tag="a" target="_blank" href="{{ route('book.manage-bookshelves.print') }}">Print Data
                                Kode
                                Rak</x-primary-button>
                        </div>
                    </div>
                    <x-table>
                        <x-slot name="header">
                            <tr class="py-10">
                                <th scope="col">#</th>
                                <th scope="col">Kode Rak</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Action</th>
                            </tr>
                        </x-slot>
                        @foreach ($bookshelves as $bs)
                            <tr>
                                <th>{{ __($loop->iteration) }}</th>
                                <th>{{ __($bs->code) }}</th>
                                <th>{{ __($bs->name) }}</th>
                                <th>
                                    <x-primary-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'bookshelves-edit-{{ $bs->id }}')">
                                        {{ __('Edit') }}
                                    </x-primary-button>
                                    <x-danger-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-book-deletion-{{ $bs->id }}')"
                                        x-on:click="$dispatch('set-action', '{{ route('book.manage-bookshelves.delete', $bs->id) }}')">
                                        {{ __('Delete') }}
                                    </x-danger-button>
                                </th>
                            </tr>
                            <x-modal name="bookshelves-edit-{{ $bs->id }}" focusable maxWidth="xl">
                                <form method="post" x-bind:action="action" class="p-4 gap-4">
                                    @method('PATCH')
                                    @csrf
                                    <div class="flex flex-col text-center gap-4 p-4">
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Ubah kode rak buku perpustakaan.') }}
                                        </h2>
                                        <div class="flex flex-col p-5 text-start gap-2">
                                            <label for="code">Kode Rak</label>
                                            <input type="text" name="code" placeholder="Masukan kode rak"
                                                value="{{ $bs->code }}">
                                            <label for="name">Nama Rak</label>
                                            <input type="text" name="name" placeholder="Masukan nama rak"
                                                value="{{ $bs->name }}">
                                        </div>
                                        <div class="justify-end">
                                            <x-danger-button
                                                x-on:click="$dispatch('set-action', '{{ route('book.manage-bookshelves.edit', $bs->id) }}')">
                                                {{ __('Edit') }}
                                            </x-danger-button>
                                            <x-primary-button x-on:click.prevent="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-primary-button>
                                        </div>
                                    </div>
                                </form>
                            </x-modal>
                            <x-modal name="confirm-book-deletion-{{ $bs->id }}" focusable maxWidth="xl">
                                <form method="post" x-bind:action="action">
                                    @method('delete')
                                    @csrf
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Apakah anda yakin akan menghapus data?') }}
                                        </h2>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Setelah proses dilaksanakan. Data akan dihilangkan secara permanen.') }}
                                        </p>
                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Cancel') }}
                                            </x-secondary-button>
                                            <x-danger-button class="ml-3">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </div>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach
                        <x-modal name="add-bookshelves" focusable maxWidth="xl">
                            <form method="post" x-bind:action="action" class="p-4 gap-4">
                                @method('POST')
                                @csrf
                                <div class="flex flex-col text-center gap-4 p-4">
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Tambahkan kode rak buku perpustakaan baru.') }}
                                    </h2>
                                    <div class="flex flex-col p-5 text-start gap-2">
                                        <label for="code">Kode Rak</label>
                                        <input type="text" name="code" placeholder="Masukan kode rak">
                                        <label for="name">Nama Rak</label>
                                        <input type="text" name="name" placeholder="Masukan nama rak">
                                    </div>
                                    <div class="justify-end">
                                        <x-danger-button
                                            x-on:click="$dispatch('set-action', '{{ route('book.manage-bookshelves.add', $bs->id) }}')">
                                            {{ __('Tambah') }}
                                        </x-danger-button>
                                        <x-primary-button x-on:click.prevent="$dispatch('close')">
                                            {{ __('Batalkan') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </x-modal>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
