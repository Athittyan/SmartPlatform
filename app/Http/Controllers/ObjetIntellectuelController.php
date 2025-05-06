<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use App\Models\InteractionObjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ActivityLog;

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

    // Méthode pour afficher les détails d'un objet
    public function show($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $user = auth()->user();

        $sessionKey = 'viewed_objets';
        $viewedObjets = session()->get($sessionKey, []);
        $now = now();

        #Nettoyer les anciennes consulataions de plus de 24 heures
        $viewedObjets = collect($viewedObjets)
            ->filter(function($timestamp) use ($now) {
                return \Carbon\Carbon::parse($timestamp)->diffInHours($now) < 24;
            })
            ->toArray();

        //Vérifie si l'objet a déjà été consulté il y a moins d'une heure
        $lastViewed = isset($viewedObjets[$id]) ? \Carbon\Carbon::parse($viewedObjets[$id]) : null;

        if ($user && (!$lastViewed || $lastViewed->diffInMinutes($now) >= 60)) {
            if (!isset($viewedObjets[$id])) {
            $user->addPoints(0.5);         // ajoute 0.5 point
            $user->changeLevel();          // vérifie si changement de niveau
            $viewedObjets[$id] = $now->toDateTimeString(); // met à jour la session
            session()->put($sessionKey, $viewedObjets);
            }
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
    
        // 🔁 Harmonisation du type
        switch (strtolower($validated['type'])) {
            case 'tv': $validated['type'] = 'TV'; break;
            case 'lampe': $validated['type'] = 'Lampe'; break;
            case 'thermostat': $validated['type'] = 'Thermostat'; break;
            case 'store':
            case 'store électrique': $validated['type'] = 'Store électrique'; break;
            case 'capteur':
            case 'capteur de présence': $validated['type'] = 'Capteur de présence'; break;
        }
    
        // ✅ Identifiant généré si vide
        if (empty($validated['identifiant'])) {
            $validated['identifiant'] = strtolower($validated['type']) . '-' . now()->format('YmdHis');
        }
    
        // 🔧 Création de l'objet
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

        // Enregistrer l'action dans le log
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Modification de l\'état de l\'objet',
            'details' => 'L\'état de l\'objet "' . $objet->name . '" a été modifié.',
        ]);
        
        return redirect()
            ->route('objets.show', $id)
            ->with('success', 'État modifié ✔️');
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

    // 🔧 On récupère l'objet
        $objet = ObjetIntellectuel::findOrFail($id);

    // 🔁 On met à jour l'objet
    $objet->update($data);

    // 📝 Historique
    ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'Modification de l\'objet',
        'details' => 'L\'objet "' . $objet->nom . '" a été modifié.', // Attention ici c’est ->nom, pas ->name
    ]);

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
