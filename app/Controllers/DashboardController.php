<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        // Vérifier si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        // Récupérer les données utilisateur avec Eloquent
        $user = UserModel::find(session()->get('id'));

        // Préparer les données pour la vue
        $data = [
            'title' => 'Tableau de bord',
            'user' => [
                'name' => $user->nom_utilisateur,
                'email' => $user->email,
                'role' => $user->role
            ]
        ];

        // Charger la vue du tableau de bord avec le template admin
        echo view('TypesMassages/Templates/adminnav');
        return view('/dashboard', $data);
    }
}
