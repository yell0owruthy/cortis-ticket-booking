<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Form Pemesanan Tiket') }}
            </h2>
            <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300">
                &larr; Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Detail Tiket yang Dipilih -->
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                        Sisa Stok: {{ $ticket->stok }} Tiket
                    </span>
                    <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $ticket->nama_tiket }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $ticket->deskripsi }}</p>
                    <div class="mt-3 text-xs text-gray-500 space-y-1">
                        <div><strong>Waktu Konser:</strong> {{ $ticket->tanggal_konser->format('d M Y, H:i') }} WIB</div>
                        <div><strong>Lokasi Venue:</strong> {{ $ticket->lokasi }}</div>
                    </div>
                    <p class="text-xl font-bold text-indigo-600 mt-4">
                        Rp {{ number_format($ticket->harga, 0, ',', '.') }} <span class="text-xs font-normal text-gray-500">/ tiket</span>
                    </p>
                </div>

                <!-- Form Input Pembelian -->
                <form action="{{ route('user.tickets.store', $ticket) }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="jumlah_tiket" class="block text-sm font-medium text-gray-700">
                            Jumlah Tiket yang Dibeli (Maksimal {{ $ticket->stok }} tiket)
                        </label>
                        <input type="number" name="jumlah_tiket" id="jumlah_tiket"
                            value="{{ old('jumlah_tiket', 1) }}"
                            min="1" max="{{ $ticket->stok }}"
                            data-harga="{{ $ticket->harga }}"
                            required
                            oninput="hitungTotal()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('jumlah_tiket')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimasi Total Bayar -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Total Pembayaran:</span>
                        <span id="estimasi_total" class="text-xl font-bold text-emerald-600">
                            Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('user.dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            Konfirmasi & Pesan Sekarang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function hitungTotal() {
            const inputElemen = document.getElementById('jumlah_tiket');
            const hargaSatuan = parseInt(inputElemen.dataset.harga) || 0;
            const jumlah = parseInt(inputElemen.value) || 0;
            const total = hargaSatuan * jumlah;

            document.getElementById('estimasi_total').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</x-app-layout>