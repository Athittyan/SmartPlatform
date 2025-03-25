<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ObjetIntellectuelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Page d’accueil simple avec message de bienvenue
Route::get('/', function () {
    return view('acceuil');
})->name('home');

// Pages objets intellectuels (liste, ajout, enregistrement)
Route::get('/objets', [ObjetIntellectuelController::class, 'index'])->name('objets.index');
Route::get('/objets/create', [ObjetIntellectuelController::class, 'create'])->name('objets.create');
Route::post('/objets', [ObjetIntellectuelController::class, 'store'])->name('objets.store');

// Redirection après connexion (vers admin ou accueil)
Route::get('/dashboard', function () {
    return redirect('/redirect');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/redirect', function () {
    $user = Auth::user();
    return $user->role === 'admin' ? redirect('/admin') : redirect('/');
})->middleware(['auth']);

// Espace admin (accès restreint)
Route::get('/admin', [AdminController::class, 'index'])->middleware('admin');

// Authentification Breeze
require __DIR__.'/auth.php';
