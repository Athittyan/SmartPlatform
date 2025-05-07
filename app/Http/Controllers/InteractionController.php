<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InteractionController extends Controller
{
    use App\Models\InteractionObjet;
use Illuminate\Http\Request;

public function store(Request $request, $id)
{
    InteractionObjet::create([
        'objet_intellectuel_id' => $id,
        'action' => $request->action,
        'valeurs_avant' => $request->valeurs_avant,
        'valeurs_apres' => $request->valeurs_apres,
        'consommation_energie' => $request->consommation_energie ?? null,
        'created_at' => now()
    ]);

    return response()->json(['message' => 'Interaction enregistrée']);
}

public function getHistorique($id)
{
    $interactions = InteractionObjet::where('objet_intellectuel_id', $id)
        ->orderBy('created_at', 'desc')
        ->take(7)
        ->get();

    // On retourne uniquement le HTML du tableau
    return view('objets.fragments.tv_tableau', compact('interactions'));
}
}
