<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FormulaireAjax extends Controller
{
    public function details($massageId)
    {
        $typeMassageModel = new \App\Models\TypeMassageModel();
        $typeMassage = $typeMassageModel->find($massageId);

        if (!$typeMassage) {
            return $this->response->setStatusCode(404, 'Massage non trouvé');
        }

        $data = [
            'typeMassage' => $typeMassage
        ];

        // Retourner uniquement le contenu du formulaire sans le layout
        return view('massage_details', $data);
    }

    public function updatePanier()
    {
        $panierModel = new \App\Models\PanierModel();
        $panier = $panierModel->getPanierItems();

        $data = [
            'panier' => $panier
        ];

        return view('TypesMassages/panier', $data);
    }
}
