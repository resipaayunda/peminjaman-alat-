<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    // Tampilkan semua log aktivitas admin
    public function index()
    {
        // Ambil log terbaru dulu, 20 per halaman
       $activities = AdminActivity::with('admin')->latest()->paginate(20);
       return view('admin.activities', compact('activities'));
    }
}
