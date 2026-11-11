<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar semua kategori tiket konser.
     */
    public function index(): View
    {
        $tickets = Ticket::orderBy('tanggal_konser', 'asc')->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Menampilkan form tambah tiket baru.
     */
    public function create(): View
    {
        return view('admin.tickets.create');
    }

    /**
     * Menyimpan data tiket baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_tiket' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'tanggal_konser' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
        ]);

        Ticket::create($validated);

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Kategori tiket baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit tiket.
     */
    public function edit(Ticket $ticket): View
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    /**
     * Memperbarui data tiket di database.
     */
    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'nama_tiket' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'tanggal_konser' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
        ]);

        $ticket->update($validated);

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Data tiket berhasil diperbarui.');
    }

    /**
     * Menghapus tiket dari database.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Kategori tiket berhasil dihapus.');
    }
}