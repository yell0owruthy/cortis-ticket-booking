<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Kategori Tiket Konser') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">
                    Dashboard
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700">
                    Rekap Transaksi
                </a>
                <a href="{{ route('admin.tickets.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                    + Tambah Tiket Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Nama Tiket</th>
                                <th class="py-3 px-4">Harga</th>
                                <th class="py-3 px-4">Stok</th>
                                <th class="py-3 px-4">Jadwal & Lokasi</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse ($tickets as $index => $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4">
                                        <div class="font-semibold text-gray-900">{{ $ticket->nama_tiket }}</div>
                                        <div class="text-xs text-gray-500 line-clamp-1">{{ $ticket->deskripsi }}</div>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-900">
                                        Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $ticket->stok > 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ticket->stok }} Tiket
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-gray-800">{{ $ticket->tanggal_konser->format('d M Y, H:i') }} WIB</div>
                                        <div class="text-xs text-gray-500">{{ $ticket->lokasi }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="px-3 py-1.5 bg-amber-500 text-white text-xs font-medium rounded hover:bg-amber-600">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket {{ $ticket->nama_tiket }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        Belum ada data kategori tiket konser.
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