<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\PetugasActivity;

class PetugasActivityController extends Controller
{
     public function index()
    {
        $activities = PetugasActivity::with('petugas')->latest()->paginate(20);

        return view('petugas.activities', compact('activities'));
    }
}
