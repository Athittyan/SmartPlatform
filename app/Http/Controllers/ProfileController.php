<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class ProfileController extends Controller
{   
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
    // Affiche le formulaire de profil
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Met à jour les infos du profil
    public function update(Request $request)
    {
        // Validation des données
        $request->validate([
            'pseudo' => 'required|string|max:255',
            'age' => 'required|integer',
            'sexe' => 'required|string',
            'type_membre' => 'required|string',
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        $user = Auth::user();

        // Mise à jour des informations de l'utilisateur
        $user->pseudo = $request->pseudo;
        $user->age = $request->age;
        $user->sexe = $request->sexe;
        $user->type_membre = $request->type_membre;
        $user->name = $request->name;
        $user->prenom = $request->prenom;

        // Mise à jour du mot de passe si fourni
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // Gestion de la photo de profil
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Sauvegarder la nouvelle photo
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
        }
        $user->profile_completed = true;
        $user->save();
        
        ActivityLog::create([
            'user_id' => auth()->id(),  // L'ID de l'utilisateur connecté
            'action' => 'Modification du profil',  // Action
            'details' => 'L\'utilisateur a mis à jour son profil',  // Détails de l'action
        ]);
        // Redirection vers le tableau de bord avec message de succès
        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');

    }

}
