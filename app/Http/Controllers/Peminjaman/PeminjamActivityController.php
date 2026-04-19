<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use App\Models\PeminjamActivity;

class PeminjamActivityController extends Controller
{
    public function index()
    {
        $activities = PeminjamActivity::with('peminjam')->latest()->paginate(20);

        return view('peminjam.activities', compact('activities'));
    }
}