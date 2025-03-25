<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function showMessage()
    {
        return "Ceci est mon premier contrôleur Laravel 🎉";
    }
}
