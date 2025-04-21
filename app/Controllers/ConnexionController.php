<?php

namespace App\Controllers;
use App\Models\UserModel;

class ConnexionController extends BaseController {
    public function index() {
        helper(['form']);
        echo view('TypesMassages/Templates/header');
        echo view('connexion');
        echo view('TypesMassages/Templates/footer');
    }

    public function traiteConnexion() {
        $session = session();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = UserModel::where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user->mot_de_passe)) {
                $session->set([
                    'id' => $user->compte_id,
                    'name' => $user->nom_utilisateur,
                    'email' => $user->email,
                    'role' => $user->role,
                    'isLoggedIn' => true
                ]);
                return redirect()->to('/profile');
            } else {
                $session->setFlashdata('msg', 'Mot de passe incorrect.');
                return redirect()->to('/connexion');
            }
        } else {
            $session->setFlashdata('msg', 'Email introuvable.');
            return redirect()->to('/connexion');
        }
    }

    public function deconnexion() {
        $session = session();
        $session->destroy();
        return redirect()->to('/connexion');
    }

    public function show404() {
        echo view('TypesMassages/Templates/header');
        echo view('errors/html/error_404');
        echo view('TypesMassages/Templates/footer');
    }
}