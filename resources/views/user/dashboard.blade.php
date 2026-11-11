<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Katalog Tiket Konser Cortis') }}
            </h2>
            <a href="{{ route('user.transactions.index') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                Riwayat Tiket Saya &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Banner Informasi Konser -->
            <div class="bg-gray-900 text-white rounded-lg p-6 shadow-sm">
                <h3 class="text-2xl font-bold">CORTIS LIVE IN JAKARTA</h3>
                <p class="text-gray-300 text-sm mt-1">Pilih kategori tiket pilihan Anda di bawah ini sebelum kuota habis.</p>
            </div>

            <!-- Daftar Kartu Kategori Tiket -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($tickets as $ticket)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 flex flex-col justify-between p-6">
                        <div>
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="text-lg font-bold text-gray-900">{{ $ticket->nama_tiket }}</h4>
                                @if ($ticket->stok > 0)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 shrink-0">
                                        Sisa: {{ $ticket->stok }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 shrink-0">
                                        Habis (0)
                                    </span>
                                @endif
                            </div>

                            <p class="text-2xl font-bold text-indigo-600 mt-3">
                                Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                                <span class="text-xs font-normal text-gray-500">/ tiket</span>
                            </p>

                            <p class="text-sm text-gray-600 mt-4 leading-relaxed">
                                {{ $ticket->deskripsi }}
                            </p>

                            <div class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500 space-y-1">
                                <div><strong>Jadwal:</strong> {{ $ticket->tanggal_konser->format('d M Y, H:i') }} WIB</div>
                                <div><strong>Lokasi:</strong> {{ $ticket->lokasi }}</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            @if ($ticket->stok > 0)
                                <a href="{{ route('user.tickets.checkout', $ticket) }}"
                                    class="block w-full text-center px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                                    Beli Tiket
                                </a>
                            @else
                                <button type="button" disabled
                                    class="block w-full text-center px-4 py-2.5 bg-gray-200 text-gray-500 text-sm font-semibold rounded-md cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-8 rounded-lg shadow-sm text-center text-gray-500">
                        Belum ada kategori tiket konser yang tersedia saat ini.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>