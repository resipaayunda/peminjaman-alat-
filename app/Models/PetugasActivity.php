<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // WAJIB ADA

class PetugasActivity extends Model
{
    protected $fillable = [
        'petugas_id',
        'action',
        'model',
        'description'
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
