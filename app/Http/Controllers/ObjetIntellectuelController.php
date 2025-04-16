<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use Illuminate\Http\Request;

class ObjetIntellectuelController extends Controller
{

    // Méthode pour afficher la liste des objets
    public function index(Request $request)
    {
        // Initialiser la requête pour récupérer les objets
        $query = ObjetIntellectuel::query();

        // Si une recherche est effectuée, filtrer par nom

        if ($request->has('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }


        // Récupérer les objets selon la requête
        $objets = $query->get();

        // Retourner la vue avec les objets récupérés
        return view('objets.index', compact('objets'));
    }

    // Méthode pour afficher un formulaire de création d'objet

    public function create()
    {
        return view('objets.create');
    }


    // Méthode pour afficher la page d'accueil avec des objets filtrés

    public function home(Request $request)
    {
        $search = $request->input('search');


        // Filtrer les objets par nom si une recherche est faite

        $objets = ObjetIntellectuel::query()
            ->when($search, function ($query, $search) {
                return $query->where('nom', 'like', "%$search%");
            })
            ->get();

        // Retourner la vue d'accueil avec les objets filtrés
        return view('acceuil', compact('objets', 'search'));
    }

    // Méthode pour afficher les détails d'un objet
    public function show($id)
    {
        // Trouver l'objet par son ID
        $objet = ObjetIntellectuel::findOrFail($id);

        // Retourner la vue des détails de l'objet
        return view('objets.show', compact('objet'));
    }

    // Méthode pour enregistrer un objet dans la base de données
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required',
            'etat_batterie' => 'nullable|integer',
            // Ajoute d'autres règles de validation ici si nécessaire
        ]);

        // Créer un nouvel objet dans la base de données
        ObjetIntellectuel::create($request->all());

        // Rediriger vers la liste des objets avec un message de succès

        return redirect()->route('objets.index')->with('success', 'L\'objet a bien été ajouté.');
    }
}
