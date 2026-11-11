<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_tiket',
        'deskripsi',
        'harga',
        'stok',
        'tanggal_konser',
        'lokasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_konser' => 'datetime',
            'harga' => 'integer',
            'stok' => 'integer',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}