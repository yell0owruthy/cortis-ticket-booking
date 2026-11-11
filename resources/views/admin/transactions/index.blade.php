<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rekap Pembelian & Transaksi Tiket') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">
                    Dashboard
                </a>
                <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    Kelola Tiket
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Ringkasan Statistik (Khusus Status PAID) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-indigo-600">
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Tiket Terjual (Status: PAID)</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ number_format($totalTiketTerjual, 0, ',', '.') }} <span class="text-base font-normal text-gray-500">Tiket</span>
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-emerald-600">
                    <p class="text-sm font-medium text-gray-500 uppercase">Total Pendapatan Resmi (Status: PAID)</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Tabel Riwayat Transaksi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                <th class="py-3 px-4">Kode Transaksi</th>
                                <th class="py-3 px-4">Nama Pembeli</th>
                                <th class="py-3 px-4">Kategori Tiket</th>
                                <th class="py-3 px-4">Jumlah</th>
                                <th class="py-3 px-4">Total Bayar</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse ($transactions as $trx)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 font-mono font-semibold text-indigo-600">
                                        {{ $trx->kode_transaksi }}
                                        <div class="text-xs font-sans text-gray-400 font-normal">
                                            {{ $trx->created_at->format('d M Y, H:i') }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-900">{{ $trx->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $trx->user->email }}</div>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-800">
                                        {{ $trx->ticket->nama_tiket }}
                                    </td>
                                    <td class="py-3 px-4">
                                        {{ $trx->jumlah_tiket }} Tiket
                                    </td>
                                    <td class="py-3 px-4 font-semibold text-gray-900">
                                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($trx->status === 'paid')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                PAID
                                            </span>
                                        @elseif ($trx->status === 'pending')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                PENDING
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                CANCELLED
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('admin.transactions.updateStatus', $trx) }}" method="POST" class="inline-flex items-center gap-1.5">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="rounded border-gray-300 text-xs py-1 pl-2 pr-6 focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="pending" {{ $trx->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $trx->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="cancelled" {{ $trx->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                            <button type="submit" class="px-3 py-1 bg-gray-800 text-white text-xs font-medium rounded hover:bg-gray-700">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-500">
                                        Belum ada riwayat transaksi pembelian tiket.
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