<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use App\Models\InteractionObjet;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generate($id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $interactions = InteractionObjet::where('objet_intellectuel_id', $id)->get();

        $pdf = Pdf::loadView('pdf.objet', compact('objet', 'interactions'));
        return $pdf->stream("Rapport_{$objet->nom}.pdf"); // ou ->download(...) pour forcer le téléchargement
    }
}
