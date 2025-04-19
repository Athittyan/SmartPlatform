<?php

use App\Models\User;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ObjetIntellectuelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailAutoriseController;

// Page d’accueil
Route::get('/', function () {
    return view('acceuil');
})->name('home');

// Objets intellectuels
Route::resource('objets', ObjetIntellectuelController::class);
Route::get('/objets', [ObjetIntellectuelController::class, 'index'])->name('objets.index');
Route::get('/objets/create', [ObjetIntellectuelController::class, 'create'])->name('objets.create');
Route::post('/objets', [ObjetIntellectuelController::class, 'store'])->name('objets.store');
Route::get('/objets/{id}', [ObjetIntellectuelController::class, 'show'])->name('objets.show');

// Redirection après login
Route::get('/redirect', function () {
    $user = Auth::user();
    return $user->role === 'admin' ? redirect('/admin') : redirect('/');
})->middleware(['auth']);

// Espace admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('admin');

// Authentification + vérification d’email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Espace utilisateur
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Espace admin (emails autorisés)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/emails', [EmailAutoriseController::class, 'index'])->name('emails.index');
    Route::post('/emails', [EmailAutoriseController::class, 'store'])->name('emails.store');
    Route::delete('/emails/{id}', [EmailAutoriseController::class, 'destroy'])->name('emails.destroy');
});

// Actions spécifiques par objet
Route::post('/objets/{id}/toggle-etat', [ObjetIntellectuelController::class, 'toggleEtat'])->name('objets.toggleEtat');

// TV
Route::post('/objets/{id}/change-volume', [ObjetIntellectuelController::class, 'changeVolume'])->name('objets.changeVolume');
Route::post('/objets/{id}/change-chaine', [ObjetIntellectuelController::class, 'changeChaine'])->name('objets.changeChaine');

// Lampe
Route::post('/objets/{id}/change-luminosite', [ObjetIntellectuelController::class, 'changeLuminosite'])->name('objets.changeLuminosite');
Route::post('/objets/{id}/change-couleur', [ObjetIntellectuelController::class, 'changeCouleur'])->name('objets.changeCouleur');

// Thermostat
Route::post('/objets/{id}/change-temperature', [ObjetIntellectuelController::class, 'changeTemperature'])->name('objets.changeTemperature');
Route::post('/objets/{id}/change-mode', [ObjetIntellectuelController::class, 'changeMode'])->name('objets.changeMode');

// Store
Route::post('/objets/{id}/change-position', [ObjetIntellectuelController::class, 'changePosition'])->name('objets.changePosition');

// Auth routes (register, login...)
require __DIR__.'/auth.php';

