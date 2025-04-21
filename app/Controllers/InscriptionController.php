<?php

namespace App\Controllers;
use App\Models\UserModel;

class InscriptionController extends BaseController {
    public function index() {
        helper(['form']);
        echo view('inscription');
    }

    public function traiteInscription() {
        helper(['form']);
        $session = session();

        // Définir les règles de validation
        $rules = [
            'nom_utilisateur' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[comptes_utilisateurs.email]',
            'mot_de_passe' => 'required|min_length[6]|max_length[50]',
            'confirmpassword' => 'matches[mot_de_passe]'
        ];

        if ($this->validate($rules)) {
            try {
                // Utilisation d'Eloquent pour créer l'utilisateur
                $user = UserModel::create([
                    'nom_utilisateur' => $this->request->getPost('nom_utilisateur'),
                    'email' => $this->request->getPost('email'),
                    'mot_de_passe' => password_hash($this->request->getPost('mot_de_passe'), PASSWORD_DEFAULT),
                    'role' => '3' // Par défaut, nouveau utilisateur avec rôle 3 (utilisateur standard)
                ]);
                
                $session->setFlashdata('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
                return redirect()->to('/connexion');
            } catch (\Exception $e) {
                $session->setFlashdata('msg', 'Une erreur est survenue lors de l\'inscription.');
                return redirect()->back()->withInput();
            }
        } else {
            // Renvoi des erreurs de validation
            $data['validation'] = $this->validator;
            echo view('inscription', $data);
        }
    }
}
