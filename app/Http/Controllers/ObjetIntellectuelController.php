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
    public function toggleEtat($id)
{
    $objet = ObjetIntellectuel::findOrFail($id);
    $objet->etat = $objet->etat === 'on' ? 'off' : 'on';
    $objet->save();

    return redirect()->back()->with('success', 'État modifié !');
}

public function changeVolume(Request $request, $id)
{
    $objet = ObjetIntellectuel::findOrFail($id);

    if ($objet->type === 'TV') {
        $request->validate([
            'volume' => 'required|integer|min:0|max:100',
        ]);
        $objet->volume = $request->volume;
        $objet->save();
    }

    return redirect()->back()->with('success', 'Volume modifié !');
}
public function changeChaine(Request $request, $id)
{
    $objet = ObjetIntellectuel::findOrFail($id);

    if ($objet->type === 'TV') {
        $request->validate([
            'chaine' => 'required|string|max:100',
        ]);
        $objet->chaine_actuelle = $request->chaine;
        $objet->save();
    }

    return redirect()->back()->with('success', 'Chaîne modifiée !');
}

}
