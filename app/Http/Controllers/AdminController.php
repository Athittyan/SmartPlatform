<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin'); // ➜ renvoie vers la vue admin.blade.php
    }
}

