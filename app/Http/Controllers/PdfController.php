<?php

namespace App\Http\Controllers;

use App\Models\ObjetIntellectuel;
use App\Models\InteractionObjet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generate(Request $request, $id)
    {
        $objet = ObjetIntellectuel::findOrFail($id);
        $interactions = InteractionObjet::where('objet_intellectuel_id', $id)->orderBy('created_at')->get();
        $chartImage = $request->input('chart_image'); 

        $pdf = Pdf::loadView('pdf.objet', compact('objet', 'interactions', 'chartImage'));
        return $pdf->stream("Rapport_{$objet->nom}.pdf");
    }
}
