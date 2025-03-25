<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        // On récupère tous les contacts de la base et on les passe à la vue
        $contacts = Contact::all();
        return view('index', ['contacts' => $contacts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'telephone' => 'required|digits:10',
        ]);

        Contact::create([
            'nom' => $request->nom,
            'telephone' => $request->telephone,
        ]);

        return redirect('/')->with('success', 'Contact ajouté avec succès !');
    }
}
