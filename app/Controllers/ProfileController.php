<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userId = $session->get('id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'user' => $user
        ];
test
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('profile', $data);
        echo view('TypesMassages/Templates/footer');
    }

    public function edit()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userId = $session->get('id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('profile_edit', $data);
        echo view('TypesMassages/Templates/footer');
    }

    public function update()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        $userId = $session->get('id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Utilisateur non trouvé');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'nom_utilisateur' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'label' => 'Nom'
                ],
                'email' => [
                    'rules' => 'required|valid_email|max_length[100]',
                    'label' => 'Email'
                ]
            ];

            $data = [
                'nom_utilisateur' => $this->request->getPost('nom_utilisateur'),
                'email' => $this->request->getPost('email')
            ];

            if ($this->request->getPost('mot_de_passe')) {
                $rules['mot_de_passe'] = [
                    'rules' => 'min_length[6]|max_length[50]',
                    'label' => 'Nouveau mot de passe'
                ];
                $rules['confirmpassword'] = [
                    'rules' => 'matches[mot_de_passe]',
                    'label' => 'Confirmer le nouveau mot de passe'
                ];
                $data['mot_de_passe'] = password_hash($this->request->getPost('mot_de_passe'), PASSWORD_DEFAULT);
            }

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            if ($userModel->where('compte_id', $userId)->update($data)) {
                return redirect()->to('/profile')->with('success', 'Profil mis à jour avec succès');
            } else {
                return redirect()->back()->withInput()->with('error', 'Échec de la mise à jour du profil');
            }
        }

        return redirect()->back()->with('error', 'Méthode de requête invalide');
    }
}
