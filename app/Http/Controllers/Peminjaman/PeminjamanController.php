<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        // sementara dummy dulu
        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan!');
    }
}
