<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PeminjamActivity extends Model
{
    protected $fillable = [
        'peminjam_id',
        'action',
        'model',
        'description'
    ];

    public function peminjam()
    {
        return $this->belongsTo(User::class, 'peminjam_id');
    }
}