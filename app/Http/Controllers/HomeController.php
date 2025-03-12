<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
class HomeController extends Controller
{
    public function index()
    {
        $announcement = Announcement::latest('created_at')->first();
        return view('dashboard.index', compact('announcement'));
    }
}
