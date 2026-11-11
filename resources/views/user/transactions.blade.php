<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Tiket Saya') }}
            </h2>
            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                &larr; Beli Tiket Lainnya
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                <th class="py-3 px-4">Kode Transaksi</th>
                                <th class="py-3 px-4">Kategori Tiket</th>
                                <th class="py-3 px-4">Jadwal & Lokasi</th>
                                <th class="py-3 px-4">Jumlah</th>
                                <th class="py-3 px-4">Total Bayar</th>
                                <th class="py-3 px-4 text-center">Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse ($transactions as $trx)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 font-mono font-bold text-indigo-600">
                                        {{ $trx->kode_transaksi }}
                                        <div class="text-xs font-sans text-gray-400 font-normal">
                                            Dipesan: {{ $trx->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">
                                        {{ $trx->ticket->nama_tiket }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-gray-800">{{ $trx->ticket->tanggal_konser->format('d M Y, H:i') }} WIB</div>
                                        <div class="text-xs text-gray-500">{{ $trx->ticket->lokasi }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $trx->jumlah_tiket }} Tiket
                                    </td>
                                    <td class="py-3 px-4 font-bold text-gray-900">
                                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if ($trx->status === 'paid')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                LUNAS (PAID)
                                            </span>
                                        @elseif ($trx->status === 'pending')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                MENUNGGU PEMBAYARAN
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                DIBATALKAN
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        Anda belum memiliki riwayat pemesanan tiket konser.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>