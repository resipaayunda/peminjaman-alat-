<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        // sementara data dummy dulu
        $alats = [
            [
                'nama' => 'Laptop',
                'stok' => 5,
                'kondisi' => 'Baik'
            ],
            [
                'nama' => 'Proyektor',
                'stok' => 2,
                'kondisi' => 'Baik'
            ],
        ];

        return view('peminjam.alat', compact('alats'));
    }
}
