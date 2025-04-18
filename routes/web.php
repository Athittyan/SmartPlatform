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


Route::get('/', function () {
    return view('acceuil');  // Retourne uniquement la vue sans récupérer les utilisateurs ici
})->name('home');


// Objets intellectuels
Route::get('/objets', [ObjetIntellectuelController::class, 'index'])->name('objets.index');
Route::get('/objets/create', [ObjetIntellectuelController::class, 'create'])->name('objets.create');
Route::post('/objets', [ObjetIntellectuelController::class, 'store'])->name('objets.store');
Route::get('/objets/{id}', [ObjetIntellectuelController::class, 'show'])->name('objets.show');

// Redirection connexion (admin ou accueil)

Route::get('/redirect', function () {
    $user = Auth::user();
    return $user->role === 'admin' ? redirect('/admin') : redirect('/');
})->middleware(['auth']);


// Espace admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('admin');

// Auth + vérification d'email uniquement
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Édition du profil (accessible une fois connecté et email vérifié)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/emails', [EmailAutoriseController::class, 'index'])->name('emails.index');
    Route::post('/emails', [EmailAutoriseController::class, 'store'])->name('emails.store');
    Route::delete('/emails/{id}', [EmailAutoriseController::class, 'destroy'])->name('emails.destroy');
});
Route::resource('objets', ObjetIntellectuelController::class);
Route::post('/objets/{id}/toggle-etat', [ObjetIntellectuelController::class, 'toggleEtat'])->name('objets.toggleEtat');
Route::post('/objets/{id}/change-volume', [ObjetIntellectuelController::class, 'changeVolume'])->name('objets.changeVolume');
Route::post('/objets/{id}/change-chaine', [ObjetIntellectuelController::class, 'changeChaine'])->name('objets.changeChaine');



require __DIR__.'/auth.php';
