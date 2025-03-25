<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use Illuminate\Http\Request;

class ObjetIntellectuelController extends Controller
{
    public function index(Request $request)
    {
        $query = ObjetIntellectuel::query();

        if ($request->has('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        $objets = $query->get();

        return view('objets.index', compact('objets'));
    }

    public function create()
    {
        return view('objets.create');
    }

    public function home(Request $request)
    {
        $search = $request->input('search');

        $objets = ObjetIntellectuel::query()
            ->when($search, function ($query, $search) {
                return $query->where('nom', 'like', "%$search%");
            })
            ->get();

        return view('acceuil', compact('objets', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'etat_batterie' => 'nullable|integer',
            // ajoute ici les autres règles de validation si besoin
        ]);

        ObjetIntellectuel::create($request->all());

        return redirect()->route('objets.index')->with('success', 'L\'objet a bien été ajouté.');
    }
}
