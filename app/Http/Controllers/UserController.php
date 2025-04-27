<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';

        return view('users.show', compact('user', 'isAdmin'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'pseudo' => 'required|string|max:255',
        'role' => 'required|string|in:simple,complexe,admin',
    ]);

    $user->update($validated);

    return redirect()->route('admin.emails.index')->with('success', 'Membre modifié avec succès.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.emails.index')->with('success', 'Membre supprimé avec succès.');
    }

}

