<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function index()
    {
        return view('peminjam.peminjaman');
    }
}
