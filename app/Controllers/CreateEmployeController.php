<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployeModel;

class CreateEmployeController extends BaseController
{
    public function index()
    {
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/Templates/adminnav');
        echo view('TypesMassages/create_employe');
        echo view('TypesMassages/Templates/footer');
    }

    public function create()
    {
        // Créer le compte utilisateur avec Eloquent
        $user = UserModel::create([
            'nom_utilisateur' => $this->request->getPost('nom_utilisateur'),
            'mot_de_passe' => password_hash($this->request->getPost('mot_de_passe'), PASSWORD_DEFAULT),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        ]);

        // Créer l'employé associé
        EmployeModel::create([
            'type_employe' => $this->request->getPost('type_employe'),
            'compte_id' => $user->id
        ]);

        return redirect()->to('/admin/employes')->with('success', 'Compte employé créé avec succès');
    }
}
