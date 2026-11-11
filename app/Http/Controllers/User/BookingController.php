<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * 1. Menampilkan Halaman Katalog Tiket (Dashboard User).
     */
    public function index(): View
    {
        $tickets = Ticket::orderBy('harga', 'desc')->get();

        return view('user.dashboard', compact('tickets'));
    }

    /**
     * 2. Menampilkan Form Pembelian Tiket.
     */
    public function create(Ticket $ticket): View|RedirectResponse
    {
        if ($ticket->stok <= 0) {
            return redirect()
                ->route('user.dashboard')
                ->with('error', 'Maaf, stok untuk kategori tiket ini sudah habis.');
        }

        return view('user.checkout', compact('ticket'));
    }

    /**
     * 3. Proses Simpan Transaksi dengan DB::transaction & Pengurangan Stok.
     */
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'jumlah_tiket' => ['required', 'integer', 'min:1', 'max:' . $ticket->stok],
        ], [
            'jumlah_tiket.max' => 'Jumlah pembelian tidak boleh melebihi sisa stok yang tersedia (' . $ticket->stok . ' tiket).',
            'jumlah_tiket.min' => 'Minimal pembelian adalah 1 tiket.',
        ]);

        $jumlahBeli = (int) $validated['jumlah_tiket'];

        DB::transaction(function () use ($request, $ticket, $jumlahBeli) {
            // Mengunci baris tiket di database selama transaksi berlangsung untuk mencegah bentrok stok
            $lockedTicket = Ticket::where('id', $ticket->id)->lockForUpdate()->firstOrFail();

            if ($lockedTicket->stok < $jumlahBeli) {
                throw ValidationException::withMessages([
                    'jumlah_tiket' => 'Maaf, sisa stok tiket tidak mencukupi (Tersisa: ' . $lockedTicket->stok . ' tiket).',
                ]);
            }

            // Generate kode transaksi unik (Contoh: CRT-2026A8F2)
            do {
                $kodeTransaksi = 'CRT-2026' . strtoupper(Str::random(4));
            } while (Transaction::where('kode_transaksi', $kodeTransaksi)->exists());

            // Hitung total harga
            $totalHarga = $lockedTicket->harga * $jumlahBeli;

            // Kurangi stok tiket secara otomatis
            $lockedTicket->decrement('stok', $jumlahBeli);

            // Simpan data transaksi
            Transaction::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => $request->user()->id,
                'ticket_id' => $lockedTicket->id,
                'jumlah_tiket' => $jumlahBeli,
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);
        });

        return redirect()
            ->route('user.transactions.index')
            ->with('success', 'Pemesanan berhasil dibuat! Silakan cek detail kode transaksi dan status pembayaran Anda.');
    }

    /**
     * 4. Menampilkan Halaman Riwayat Tiket Saya.
     */
    public function history(Request $request): View
    {
        $transactions = Transaction::with('ticket')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('user.transactions', compact('transactions'));
    }
}