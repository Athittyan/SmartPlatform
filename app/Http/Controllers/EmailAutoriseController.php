<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailAutorise;

class EmailAutoriseController extends Controller
{
    public function index()
    {
        $emails = EmailAutorise::all();
        return view('admin.emails.index', compact('emails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:emails_autorises,email',
        ]);

        EmailAutorise::create([
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Email autorisé ajouté avec succès.');
    }

    public function destroy($id)
    {
        EmailAutorise::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Email supprimé.');
    }
}

