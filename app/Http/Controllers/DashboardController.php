<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        flash()->success('Welcome to the admin dashboard!');
        return view('dashboard.admin');
    }
    public function users()
    {
        flash()->success('Welcome to the user dashboard!');
        return view('dashboard.users');
    }
}
