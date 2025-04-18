<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use Illuminate\Http\Request;

class ObjetIntellectuelController extends Controller
{
    // 🔍 Méthode pour afficher la liste des objets avec recherche et filtres
    public function index(Request $request)
    {
        $query = ObjetIntellectuel::query();

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par état
        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        $objets = $query->get();

        return view('objets.index', [
            'objets' => $objets,
            'search' => $request->search,
            'type' => $request->type,
            'etat' => $request->etat,
        ]);
    }

    // ➕ Formulaire de création d'objet
    public function create()
    {
        return view('objets.create');
    }

    // 💾 Enregistrer un nouvel objet
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'etat_batterie' => 'nullable|integer',
            // Ajoute d'autres règles de validation si besoin
        ]);

        ObjetIntellectuel::create($request->all());

        return redirect()->route('objets.index')->with('success', 'L\'objet a bien été ajouté.');
    }

    // 👁️ Voir un objet en détail
    public function show($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        return view('objets.show', compact('objet'));
    }

    // 🏠 Page d’accueil avec recherche (facultatif si tu veux filtrer aussi là-bas)
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
}
