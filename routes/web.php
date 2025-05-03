<?php

use App\Models\User;
use App\Http\Controllers\ObjetIntellectuelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailAutoriseController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Admin\UserValidationController;
use App\Http\Controllers\Admin\ActivityLogController;


use App\Http\Controllers\UserLevelController;

// Page d’accueil
Route::get('/', function () {
    $users = User::all();
    return view('acceuil', compact('users'));
})->name('home');

// —————————————————————————————
// Pages personnalisées pour édition & suppression en liste
Route::get('/objets/edit-list',   [ObjetIntellectuelController::class, 'editList'])->name('objets.editList');
Route::get('/objets/delete-list', [ObjetIntellectuelController::class, 'deleteList'])->name('objets.deleteList');

// Route pour la “demande” de suppression (rôle complexe)
Route::post('/objets/{id}/request-delete', [ObjetIntellectuelController::class, 'requestDelete'])
     ->name('objets.requestDelete');

// CRUD standard pour les objets
Route::resource('objets', ObjetIntellectuelController::class);

// Redirection après login
Route::get('/redirect', function () {
    $user = Auth::user();
    return $user->role === 'admin'
         ? redirect('/admin')
         : redirect('/');
})->middleware(['auth']);


// Espace admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('admin')->name('admin');

// Authentification + vérification d’email
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile',  [ProfileController::class, 'update'])->name('profile.update');
});

// Espace utilisateur
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Espace admin (emails autorisés)
Route::middleware(['auth', 'admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         Route::get('/emails',         [EmailAutoriseController::class, 'index'])->name('emails.index');
         Route::post('/emails',        [EmailAutoriseController::class, 'store'])->name('emails.store');
         Route::delete('/emails/{id}', [EmailAutoriseController::class, 'destroy'])->name('emails.destroy');
     });

// Actions spécifiques par objet
Route::post('/objets/{id}/toggle-etat',       [ObjetIntellectuelController::class, 'toggleEtat'])->name('objets.toggleEtat');
Route::post('/objets/{id}/change-volume',     [ObjetIntellectuelController::class, 'changeVolume'])->name('objets.changeVolume');
Route::post('/objets/{id}/change-chaine',     [ObjetIntellectuelController::class, 'changeChaine'])->name('objets.changeChaine');
Route::post('/objets/{id}/change-luminosite', [ObjetIntellectuelController::class, 'changeLuminosite'])->name('objets.changeLuminosite');
Route::post('/objets/{id}/change-couleur',    [ObjetIntellectuelController::class, 'changeCouleur'])->name('objets.changeCouleur');
Route::post('/objets/{id}/change-temperature',[ObjetIntellectuelController::class, 'changeTemperature'])->name('objets.changeTemperature');
Route::post('/objets/{id}/change-mode',       [ObjetIntellectuelController::class, 'changeMode'])->name('objets.changeMode');
Route::post('/objets/{id}/change-position',   [ObjetIntellectuelController::class, 'changePosition'])->name('objets.changePosition');

// Génération de PDF
Route::post('/objets/{id}/pdf', [PdfController::class, 'generate'])->name('objets.pdf');

// Route pour afficher l'historique des actions
Route::get('/admin/activity-logs', [ActivityLogController::class, 'index'])->middleware('admin')->name('admin.activityLogs');

// Routes pour l'admin uniquement
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');


Route::post('/level-upgrade', [UserLevelController::class, 'upgrade'])->name('level.upgrade');

Route::get('/profil', [ProfileController::class, 'show'])->middleware('auth')->name('profil.show');

// 🔒 Zone protégée réservée à l'admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/utilisateurs-en-attente', [UserValidationController::class, 'index'])->name('admin.validation');
    Route::post('/utilisateurs/{id}/valider', [UserValidationController::class, 'approve'])->name('admin.validate');
});


// Auth routes (register, login...)
require __DIR__.'/auth.php';
