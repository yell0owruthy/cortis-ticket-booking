<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Admin - Konser Cortis') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    Kelola Tiket
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700">
                    Rekap Transaksi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium">Kategori Tiket</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalKategori }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium">Tiket Terjual (Paid)</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ number_format($totalTiketTerjual, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">Tiket</span></p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium">Total Pendapatan (Paid)</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 font-medium">Menunggu Konfirmasi</p>
                    <p class="text-3xl font-bold text-amber-500 mt-2">{{ $transaksiPending }} <span class="text-sm font-normal text-gray-500">Transaksi</span></p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Selamat Datang di Panel Administrator Konser Cortis</h3>
                <p class="text-gray-600 text-sm mb-4">Gunakan tombol navigasi di bawah ini untuk mengelola ketersediaan tiket konser dan memverifikasi pembayaran penonton.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                        Buka Manajemen Tiket &rarr;
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 text-sm font-medium rounded-md hover:bg-gray-200 border border-gray-300">
                        Lihat Rekap Pembelian &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>