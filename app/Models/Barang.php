<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi mass assignment
    protected $fillable = ['nama_barang'];

    // Relasi ke peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
