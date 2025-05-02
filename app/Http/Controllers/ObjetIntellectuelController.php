<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use App\Models\InteractionObjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ObjetIntellectuelController extends Controller
{
    /**
     * 📄 Affiche la liste standard des objets, avec filtres et pagination
     */
    public function index(Request $request)
    {
        $query = ObjetIntellectuel::query();

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }
        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        $objets = $query->paginate(10);
        return view('objets.index', compact('objets'));
    }

    /**
     * ➕ Formulaire de création d’un nouvel objet
     */
    public function create()
    {
        return view('objets.create');
    }

    public function show($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $user  = Auth::user();

        // (scoring + interactions…)

        return view('objets.show', compact('objet', 'interactions', 'isVisiteur'));
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'identifiant' => 'nullable|string|unique:objets_intellectuels,identifiant',
        'nom' => 'required|string|max:255',
        'type' => 'required|string',
    ]);

    // SI identifiant vide, on en génère un automatique
    if (empty($validated['identifiant'])) {
        $validated['identifiant'] = strtolower($validated['type']) . '-' . now()->format('YmdHis');
    }

    ObjetIntellectuel::create([
        'identifiant' => $validated['identifiant'],
        'nom' => $validated['nom'],
        'type' => $validated['type'],
        'temperature_actuelle' => $request->temperature_actuelle,
        'temperature_cible' => $request->temperature_cible,
        'mode' => $request->mode,
        'etat' => $request->etat,
        'luminosite' => $request->luminosite,
        'couleur' => $request->couleur,
        'chaine_actuelle' => $request->chaine_actuelle,
        'volume' => $request->volume,
        'presence' => $request->presence,
        'duree_presence' => $request->duree_presence,
        'position' => $request->position,
        'derniere_interaction' => $request->derniere_interaction,
    ]);

    return redirect()->route('objets.index')->with('success', 'Objet ajouté avec succès.');
    }


    // 🔁 Bouton Allumer / Éteindre (tous types)
    public function toggleEtat($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $objet->etat = $objet->etat === 'on' ? 'off' : 'on';
        $objet->save();

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'État modifié ✔️');
    }

    // … autres méthodes de changeVolume, changeChaine, etc. …

    /**
     * 🌐 Liste pour choisir un objet à modifier
     */
    public function editList()
    {
        $objets = ObjetIntellectuel::all();
        return view('objets.edit-list', compact('objets'));
    }

    /**
     * ✏️ Formulaire d’édition
     */
    public function edit($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        return view('objets.edit', compact('objet'));
    }

    /**
     * 💾 Enregistrement de la modification
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'identifiant' => 'required|string|max:255|unique:objets_intellectuels,identifiant,' . $id,
        ]);

        ObjetIntellectuel::findOrFail($id)->update($data);

        return redirect()
            ->route('objets.editList')
            ->with('success', 'Objet modifié avec succès ✔️');
    }

    /**
     * 🔴 Liste pour choisir un objet à supprimer
     */
    public function deleteList()
    {
        $objets = ObjetIntellectuel::all();
        return view('objets.delete-list', compact('objets'));
    }

    /**
     * 📨 Demande de suppression (pour rôle complexe)
     */
    public function requestDelete($id)
    {
        // Logique de notification à l’admin…
        return redirect()
            ->route('objets.deleteList')
            ->with('success', "Demande de suppression envoyée à l'admin ✔️");
    }

    /**
     * ❌ Suppression de l’objet (admin uniquement)
     */
    public function destroy($id)
    {
        ObjetIntellectuel::findOrFail($id)->delete();

        return redirect()
            ->route('objets.deleteList')
            ->with('success', 'Objet supprimé avec succès ❌');
    }
    

}
