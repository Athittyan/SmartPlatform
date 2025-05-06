<?php

namespace App\Http\Controllers;
use App\Models\User; // Import correct du modèle User
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // DashboardController.php
    public function index()
    {
        if (auth()->check()) {
            $users = auth()->user(); #\App\Models\User::all();
            return view('acceuil', compact('users'));
        }

        return view('home');
    }


}
