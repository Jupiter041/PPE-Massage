<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployeModel;

class GereEmployeController extends BaseController
{
    public function index()
    {
        $employes = EmployeModel::with('compte')->get();
        $users = UserModel::with('employe')->get();
        
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/adminnav');
        echo view('TypesMassages/Templates/navbar');
        echo view('gestion/Employe/gere_employe', ['employes' => $employes, 'users' => $users]);
        echo view('TypesMassages/Templates/footer');
    }

    public function showCreate()
    {
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/adminnav');
        echo view('TypesMassages/Templates/navbar');
        echo view('gestion/Employe/create_employe');
        echo view('TypesMassages/Templates/footer');
    }

    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nom_utilisateur' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[comptes_utilisateurs.email]',
            'mot_de_passe' => 'required|min_length[6]',
            'type_employe' => 'required|in_list[masseur,admin]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $user = new UserModel();
        $user->nom_utilisateur = $this->request->getPost('nom_utilisateur');
        $user->mot_de_passe = password_hash($this->request->getPost('mot_de_passe'), PASSWORD_DEFAULT);
        $user->email = $this->request->getPost('email');
        $user->role = 2; // Rôle employé
        $user->save();

        $employe = new EmployeModel();
        $employe->compte_id = $user->compte_id;
        $employe->type_employe = $this->request->getPost('type_employe');
        $employe->save();

        return redirect()->to('/admin/gestion/employes')->with('success', 'Compte employé créé avec succès');
    }

    public function edit($id)
    {
        $employe = EmployeModel::with('compte')->find($id);
        
        if (!$employe) {
            return redirect()->to('/admin/gestion/employes')->with('error', 'Employé non trouvé');
        }

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/adminnav');
        echo view('TypesMassages/Templates/navbar');
        echo view('gestion/Employe/modif_employe', ['employe' => $employe]);
        echo view('TypesMassages/Templates/footer');
    }

    public function update($id)
    {
        $employe = EmployeModel::find($id);
        if (!$employe) {
            return redirect()->to('/admin/gestion/employes')->with('error', 'Employé non trouvé');
        }

        $user = UserModel::find($employe->compte_id);
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nom_utilisateur' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[comptes_utilisateurs.email,compte_id,'.$user->compte_id.']',
            'type_employe' => 'required|in_list[masseur,admin]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $user->nom_utilisateur = $this->request->getPost('nom_utilisateur');
        $user->email = $this->request->getPost('email');

        if ($this->request->getPost('mot_de_passe')) {
            $user->mot_de_passe = password_hash($this->request->getPost('mot_de_passe'), PASSWORD_DEFAULT);
        }
        $user->save();

        $employe->type_employe = $this->request->getPost('type_employe');
        $employe->save();

        return redirect()->to('/admin/gestion/employes')->with('success', 'Employé modifié avec succès');
    }

    public function delete($id)
    {
        $employe = EmployeModel::find($id);
        if (!$employe) {
            return redirect()->to('/admin/gestion/employes')->with('error', 'Employé non trouvé');
        }

        $user = UserModel::find($employe->compte_id);

        try {
            $employe->delete();
            $user->delete();
            return redirect()->to('/admin/gestion/employes')->with('success', 'Employé supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->to('/admin/gestion/employes')->with('error', 'Impossible de supprimer cet employé car il est lié à des réservations');
        }
    }
}