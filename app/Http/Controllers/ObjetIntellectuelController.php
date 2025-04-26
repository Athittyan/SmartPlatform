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

        // Recherche mots-clés (nom)
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

        // Filtre par mode
        if ($request->filled('mode')) {
            $query->where('mode', $request->mode);
        }

        $objets = $query->paginate(10);

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

    public function show($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $user = auth()->user();

        $sessionKey = 'viewed_objets';
        $viewedObjets = session()->get($sessionKey, []);
        $now = now();

        $viewedObjets = collect($viewedObjets)
            ->filter(function ($timestamp) use ($now) {
                return \Carbon\Carbon::parse($timestamp)->diffInHours($now) < 24;
            })
            ->toArray();

        $lastViewed = isset($viewedObjets[$id]) ? \Carbon\Carbon::parse($viewedObjets[$id]) : null;

        if ($user && (!$lastViewed || $lastViewed->diffInMinutes($now) >= 60)) {
            $user->addPoints(0.5);
            $user->changeLevel();
            $viewedObjets[$id] = $now->toDateTimeString();
            session()->put($sessionKey, $viewedObjets);
        }

        $interactions = InteractionObjet::where('objet_intellectuel_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        // Calculer si c'est un visiteur
       // Calculer si c'est un visiteur ou un utilisateur simple
$isVisiteur = auth()->guest() || (auth()->check() && (auth()->user()->role === 'visiteur' || auth()->user()->role === 'simple'));


        return view('objets.show', compact('objet', 'interactions', 'isVisiteur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'etat_batterie' => 'nullable|integer',
        ]);

        ObjetIntellectuel::create($request->all());
        return redirect()->route('objets.index')->with('success', 'Objet ajouté avec succès.');
    }

    public function toggleEtat($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $objet->etat = $objet->etat === 'on' ? 'off' : 'on';
        $objet->save();

        return redirect()->route('objets.show', $objet->id)->with('success', 'État modifié !');
    }

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

    public function changePosition(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);

        if ($objet->type === 'Store électrique') {
            $request->validate(['position' => 'required|integer|min:0|max:100']);
            $objet->position = $request->position;
            $objet->save();
        }

        return redirect()->route('objets.show', $objet->id)->with('success', 'Position modifiée !');
    }
}
