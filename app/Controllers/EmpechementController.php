<?php

namespace App\Controllers;

use App\Models\EmpechementModel;

class EmpechementController extends BaseController
{
    public function index()
    {
        $empechements = EmpechementModel::with(['employe.compte', 'reservation'])->get()->map(function($empechement) {
            return [
                'id' => $empechement->empechement_id,
                'employe_id' => $empechement->employe_id,
                'motif' => $empechement->motif,
                'created_at' => $empechement->created_at,
                'reservation_id' => $empechement->reservation_id,
                'nom' => $empechement->employe->compte->nom ?? 'N/A',
                'heure_reservation' => $empechement->reservation->heure_reservation ?? 'N/A',
                'duree' => $empechement->reservation->duree ?? 'N/A'
            ];
        });

        return view('TypesMassages/Templates/header')
            . view('TypesMassages/Templates/adminnav')
            . view('TypesMassages/Templates/navbar')
            . view('empechements', ['empechements' => $empechements])
            . view('TypesMassages/Templates/footer');
    }

    public function delete($id)
    {
        $empechement = EmpechementModel::find($id);
        
        if ($empechement) {
            $empechement->delete();
            return redirect()->to('/empechements')->with('success', 'Empêchement supprimé avec succès');
        }
        
        return redirect()->to('/empechements')->with('error', 'Empêchement non trouvé');
    }
}
