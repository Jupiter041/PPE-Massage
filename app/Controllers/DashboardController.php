<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogModel;

class DashboardController extends BaseController
{
    public function index()
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        // Préparer les données pour la vue
        $data = [
            'title' => 'Tableau de bord',
            'user' => [
                'name' => session()->get('name'),
                'email' => session()->get('email'),
                'role' => session()->get('role')
            ]
        ];

        // Charger la vue du tableau de bord avec le template admin
        echo view('TypesMassages/Templates/adminnav');
        return view('/dashboard', $data);
    }
}
