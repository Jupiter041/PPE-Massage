<?php

namespace App\Controllers;
use App\Models\UserModel;

class ConnexionController extends BaseController {
    public function index() {
        helper(['form']);
        echo view('connexion');
    }

    public function traiteConnexion() {
        $session = session();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user['mot_de_passe'])) {
                $session->set([
                    'id' => $user['compte_id'],
                    'name' => $user['nom_utilisateur'],
                    'email' => $user['email'],
                    'role' => $user['role'],
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

}