<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EmailAutoriseController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->get(); // utilisateurs en attente
        $allUsers = User::where('is_approved', true)->get();      // membres approuvés

        return view('admin.emails.index', compact('pendingUsers', 'allUsers'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Utilisateur supprimé.');
    }

    public function approve($id)
{
    $user = User::findOrFail($id);
    $user->is_approved = true;
    $user->save();

    $user->sendEmailVerificationNotification();

    return redirect()->back()->with('success', 'Utilisateur validé et mail envoyé ✅');
}

public function reject($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'Demande refusée et utilisateur supprimé ❌');
}
}
