<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function editMeja()
    {
        return view('admin.edit-meja');
    }

    public function editMenu()
    {
        return view('admin.edit-menu');
    }
}
