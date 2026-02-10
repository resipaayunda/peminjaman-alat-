<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'admin_id',
        'action',
        'model',
        'description',
    ];

    // Relasi ke user/admin
    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'admin_id');
    }
}
