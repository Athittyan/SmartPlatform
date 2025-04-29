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

    /**
     * 💾 Stocke le nouvel objet en base
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'         => 'required|string|max:255',
            'identifiant' => 'nullable|string|unique:objets_intellectuels,identifiant',
            'type'        => 'required|string',
            // … ajoute ici tes autres règles de validation …
        ]);

        if (empty($data['identifiant'])) {
            $data['identifiant'] = strtolower($data['type']) . '-' . now()->format('YmdHis');
        }

        ObjetIntellectuel::create($data);

        return redirect()
            ->route('objets.index')
            ->with('success', 'Objet ajouté avec succès ✔️');
    }

    /**
     * 📋 Affiche un objet en détail, gère le scoring et les interactions
     */
    public function show($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $user  = Auth::user();

        // Gestion du scoring utilisateur
        $sessionKey   = 'viewed_objets';
        $viewedObjets = session()->get($sessionKey, []);
        $now          = now();

        // On nettoie les vues vieilles de plus de 24h
        $viewedObjets = collect($viewedObjets)
            ->filter(fn($timestamp) => Carbon::parse($timestamp)->diffInHours($now) < 24)
            ->toArray();

        $lastViewed = isset($viewedObjets[$id])
            ? Carbon::parse($viewedObjets[$id])
            : null;

        if ($user && (!$lastViewed || $lastViewed->diffInMinutes($now) >= 60)) {
            $user->addPoints(0.5);
            $user->changeLevel();
            $viewedObjets[$id] = $now->toDateTimeString();
            session()->put($sessionKey, $viewedObjets);
        }

        // Dernières interactions
        $interactions = InteractionObjet::where('objet_intellectuel_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        // Détection visiteur
        $isVisiteur = Auth::guest()
            || (Auth::check() && in_array(Auth::user()->role, ['visiteur', 'simple']));

        return view('objets.show', compact('objet', 'interactions', 'isVisiteur'));
    }

    /**
     * 🔁 Basculer l’état de l’objet
     */
    public function toggleEtat($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $objet->etat = $objet->etat === 'on' ? 'off' : 'on';
        $objet->save();

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'État modifié ✔️');
    }

    /**
     * 📺 Changer le volume (TV)
     */
    public function changeVolume(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'TV') {
            $request->validate(['volume' => 'required|integer|min:0|max:100']);
            $objet->volume = $request->volume;
            $objet->save();
        }

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'Volume modifié ✔️');
    }

    /**
     * 📺 Changer la chaîne (TV)
     */
    public function changeChaine(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'TV') {
            $request->validate(['chaine' => 'required|string|max:100']);
            $objet->chaine_actuelle = $request->chaine;
            $objet->save();
        }

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'Chaîne modifiée ✔️');
    }

    /**
     * 💡 Changer la luminosité (Lampe)
     */
    public function changeLuminosite(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Lampe') {
            $request->validate(['luminosite' => 'required|integer|min:0|max:100']);
            $objet->luminosite = $request->luminosite;
            $objet->save();
        }

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'Luminosité modifiée ✔️');
    }

    /**
     * 💡 Changer la couleur (Lampe)
     */
    public function changeCouleur(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Lampe') {
            $request->validate(['couleur' => 'required|string|max:20']);
            $objet->couleur = $request->couleur;
            $objet->save();
        }

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'Couleur modifiée ✔️');
    }

    /**
     * 🌡️ Changer la température (Thermostat)
     */
    public function changeTemperature(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Thermostat') {
            $request->validate(['temperature' => 'required|numeric|min:5|max:35']);
            $objet->temperature_cible = $request->temperature;
            $objet->save();
        }

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'Température modifiée ✔️');
    }

    /**
     * 🌡️ Changer le mode (Thermostat)
     */
    public function changeMode(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Thermostat') {
            $request->validate(['mode' => 'required|string|in:off,eco,comfort']);
            $objet->mode = $request->mode;
            $objet->save();
        }

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'Mode modifié ✔️');
    }

    /**
     * 🪟 Changer la position (Store électrique)
     */
    public function changePosition(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Store électrique') {
            $request->validate(['position' => 'required|integer|min:0|max:100']);
            $objet->position = $request->position;
            $objet->save();
        }

        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'Position modifiée ✔️');
    }

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
     * ❌ Suppression de l’objet
     */
    public function destroy($id)
    {
        ObjetIntellectuel::findOrFail($id)->delete();

        return redirect()
            ->route('objets.deleteList')
            ->with('success', 'Objet supprimé avec succès ❌');
    }
}
