<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserValidationController extends Controller
{
    public function index()
    {
        $users = User::where('is_approved', false)->get();
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        $user->sendEmailVerificationNotification(); // envoie le mail Laravel

        return back()->with('success', 'Utilisateur validé et mail envoyé ✅');
    }
}
