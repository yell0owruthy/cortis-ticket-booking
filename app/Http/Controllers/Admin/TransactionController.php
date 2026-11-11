<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Menampilkan seluruh riwayat transaksi dan ringkasan statistik.
     */
    public function index(): View
    {
        // Mengambil semua transaksi beserta relasi user dan ticket (Eager Loading)
        $transactions = Transaction::with(['user', 'ticket'])->latest()->get();

        // Menghitung statistik khusus transaksi berstatus 'paid'
        $totalTiketTerjual = Transaction::where('status', 'paid')->sum('jumlah_tiket');
        $totalPendapatan = Transaction::where('status', 'paid')->sum('total_harga');

        return view('admin.transactions.index', compact(
            'transactions',
            'totalTiketTerjual',
            'totalPendapatan'
        ));
    }

    /**
     * Mengubah status transaksi (pending / paid / cancelled).
     */
    public function updateStatus(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,cancelled'],
        ]);

        $statusLama = $transaction->status;
        $statusBaru = $validated['status'];

        // Jika transaksi dibatalkan, kembalikan stok tiket
        if ($statusLama !== 'cancelled' && $statusBaru === 'cancelled') {
            $transaction->ticket->increment('stok', $transaction->jumlah_tiket);
        }

        // Jika transaksi yang tadinya cancelled diaktifkan kembali, kurangi stok tiket
        if ($statusLama === 'cancelled' && $statusBaru !== 'cancelled') {
            if ($transaction->ticket->stok < $transaction->jumlah_tiket) {
                return back()->with('error', 'Stok tiket tidak mencukupi untuk mengaktifkan kembali transaksi ini.');
            }
            $transaction->ticket->decrement('stok', $transaction->jumlah_tiket);
        }

        $transaction->update([
            'status' => $statusBaru,
        ]);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Status transaksi ' . $transaction->kode_transaksi . ' berhasil diubah menjadi ' . strtoupper($statusBaru) . '.');
    }
}