<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ObjetIntellectuelController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ✅ Nouvelle page d’accueil : liste des objets visibles en "free tour"
Route::get('/', [ObjetIntellectuelController::class, 'index'])->name('home');

// ✅ Pages objets intellectuels (ajout/gestion)
Route::get('/objets', [ObjetIntellectuelController::class, 'index'])->name('objets.index');
Route::get('/objets/create', [ObjetIntellectuelController::class, 'create'])->name('objets.create');
Route::post('/objets', [ObjetIntellectuelController::class, 'store'])->name('objets.store');

// ✅ Redirection après connexion
Route::get('/dashboard', function () {
    return redirect('/redirect');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/redirect', function () {
    $user = Auth::user();
    return $user->role === 'admin' ? redirect('/admin') : redirect('/');
})->middleware(['auth']);

// ✅ Espace admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('admin');

// ✅ Auth Breeze
require __DIR__.'/auth.php';
