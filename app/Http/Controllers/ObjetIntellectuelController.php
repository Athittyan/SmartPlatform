<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use App\Models\InteractionObjet;
use Illuminate\Http\Request;

class ObjetIntellectuelController extends Controller
{
    public function index(Request $request)
{
    $query = ObjetIntellectuel::query();

    // 🔍 Recherche mots-clés (nom + description)
    if ($request->filled('search')) {
        $query->where('nom', 'like', '%' . $request->search . '%');
    }

    // 🎛️ Filtre par type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // ⚡ Filtre par état
    if ($request->filled('etat')) {
        $query->where('etat', $request->etat);
    }

    // 🧠 Filtre par mode
    if ($request->filled('mode')) {
        $query->where('mode', $request->mode);
    }

    // Récupération avec pagination (ou ->get() si tu préfères)
    $objets = $query->paginate(10);

    return view('objets.index', compact('objets'));
}


    // Formulaire de création
    public function create()
    {
        return view('objets.create');
    }

    // Accueil filtré
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
        $objet = ObjetIntellectuel::findOrFail($id);
        $user = auth()->user();

        $sessionKey = 'viewed_objets';
        $viewedObjets = session()->get($sessionKey, []);
        $now = now();

        $viewedObjets = collect($viewedObjets)
            ->filter(function($timestamp) use ($now) {
                return \Carbon\Carbon::parse($timestamp)->diffInHours($now) < 24;
            })
            ->toArray();
        
        //Vérifie si l'objet a déjà été consulté il y a moins d'une heure
        $lastViewed = isset($viewedObjts[$id]) ? \Carbon\Carbon::parse($viewedObjets[$id]) : null;

        if ($user && (!$lastViewed || $lastViewed->diffInMinutes($now) >= 60)) {
            $user->addPoints(0.5);         // ajoute 0.5 point
            $user->changeLevel();          // vérifie si changement de niveau
            $viewedObjets[$id] = $now->toDateTimeString(); // met à jour la session
            session()->put($sessionKey, $viewedObjets);
        }

        // Récupérer les interactions associées à cet objet
        $interactions = InteractionObjet::where('objet_intellectuel_id', $id)
        ->orderBy('created_at', 'desc')
        ->take(7)
        ->get();


        // Passer les données à la vue
        return view('objets.show', compact('objet', 'interactions'));
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

        return redirect()->route('objets.show', $objet->id)->with('success', 'État modifié !');
    }

    // 📺 TV
    public function changeVolume(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'TV') {
            $request->validate(['volume' => 'required|integer|min:0|max:100']);
            $objet->volume = $request->volume;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Volume modifié !');
    }

    public function changeChaine(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'TV') {
            $request->validate(['chaine' => 'required|string|max:100']);
            $objet->chaine_actuelle = $request->chaine;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Chaîne modifiée !');
    }

    // 💡 Lampe
    public function changeLuminosite(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Lampe') {
            $request->validate(['luminosite' => 'required|integer|min:0|max:100']);
            $objet->luminosite = $request->luminosite;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Luminosité modifiée !');
    }

    public function changeCouleur(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Lampe') {
            $request->validate(['couleur' => 'required|string|max:20']);
            $objet->couleur = $request->couleur;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Couleur modifiée !');
    }

    // 🌡️ Thermostat
    public function changeTemperature(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Thermostat') {
            $request->validate(['temperature' => 'required|numeric|min:5|max:35']);
            $objet->temperature_cible = $request->temperature;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Température modifiée !');
    }

    public function changeMode(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Thermostat') {
            $request->validate(['mode' => 'required|string|in:off,eco,comfort']);
            $objet->mode = $request->mode;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Mode modifié !');
    }

    // 🪟 Store
    public function changePosition(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Store électrique') {
            $request->validate([
                'position' => 'required|integer|min:0|max:100',
            ]);

            $objet->position = $request->position;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Position modifiée !');
    }
}
