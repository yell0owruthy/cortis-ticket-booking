<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Default
        User::updateOrCreate(
            ['email' => 'admin@cortis.com'],
            [
                'name' => 'Administrator Cortis',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Akun User Contoh
        User::updateOrCreate(
            ['email' => 'user@cortis.com'],
            [
                'name' => 'Penonton Cortis',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]
        );

        // 3. Data Awal Kategori Tiket Konser Cortis
        $tickets = [
            [
                'nama_tiket' => 'VIP Cortis Front Row',
                'deskripsi' => 'Akses barisan terdepan dekat panggung, jalur masuk prioritas, dan paket merchandise resmi Cortis.',
                'harga' => 1500000,
                'stok' => 50,
                'tanggal_konser' => '2026-12-20 19:00:00',
                'lokasi' => 'Indonesia Arena, Senayan, Jakarta',
            ],
            [
                'nama_tiket' => 'Festival Standing',
                'deskripsi' => 'Area berdiri tepat di depan panggung utama dengan pengalaman konser paling meriah.',
                'harga' => 850000,
                'stok' => 200,
                'tanggal_konser' => '2026-12-20 19:00:00',
                'lokasi' => 'Indonesia Arena, Senayan, Jakarta',
            ],
            [
                'nama_tiket' => 'Tribune Seated',
                'deskripsi' => 'Tempat duduk bernomor di area tribun dengan pandangan panggung menyeluruh.',
                'harga' => 500000,
                'stok' => 300,
                'tanggal_konser' => '2026-12-20 19:00:00',
                'lokasi' => 'Indonesia Arena, Senayan, Jakarta',
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}