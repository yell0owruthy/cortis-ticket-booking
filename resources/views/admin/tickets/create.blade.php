<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Kategori Tiket Baru') }}
            </h2>
            <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.tickets.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="nama_tiket" class="block text-sm font-medium text-gray-700">Nama Kategori Tiket</label>
                        <input type="text" name="nama_tiket" id="nama_tiket" value="{{ old('nama_tiket') }}" required
                            placeholder="Contoh: VIP Cortis Front Row"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('nama_tiket')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Fasilitas</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" required
                            placeholder="Jelaskan posisi area dan keuntungan tiket ini..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga Tiket (Rp)</label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga') }}" min="0" required
                                placeholder="Contoh: 1500000"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('harga')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stok" class="block text-sm font-medium text-gray-700">Jumlah Stok Kuota</label>
                            <input type="number" name="stok" id="stok" value="{{ old('stok') }}" min="0" required
                                placeholder="Contoh: 100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('stok')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_konser" class="block text-sm font-medium text-gray-700">Tanggal & Jam Konser</label>
                            <input type="datetime-local" name="tanggal_konser" id="tanggal_konser" value="{{ old('tanggal_konser') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('tanggal_konser')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Venue</label>
                            <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required
                                placeholder="Contoh: Indonesia Arena, Senayan, Jakarta"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('lokasi')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            Simpan Tiket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>