<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class NavBarControlleur extends Controller
{
    /**
     * Méthode pour afficher la barre de navigation
     * - Démarre la session
     * - Vérifie si l'utilisateur est connecté
     * - Récupère les données de l'utilisateur si connecté
     * - Retourne la vue de la barre de navigation
     */
    public function index()
    {
        // Démarrer la session
        $session = session();
        
        // Créer une instance du modèle User
        $userModel = new UserModel();
        
        // Initialiser la variable user à null
        $data['user'] = null;
        $data['isAdmin'] = false;
        $data['showDashboard'] = false;
        
        // Vérifier si l'utilisateur est connecté
        if ($session->get('isLoggedIn')) {
            // Récupérer l'ID de l'utilisateur depuis la session
            $userId = $session->get('id');
            
            // Rechercher l'utilisateur dans la base de données
            $user = $userModel->find($userId);
            
            // Lever une exception si l'utilisateur n'est pas trouvé
            if (!$user) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
            }
            
            // Vérifier si l'utilisateur est admin (role = 1)
            $data['isAdmin'] = ($user->role == 1);
            $data['showDashboard'] = $data['isAdmin'];
            
            // Stocker les données de l'utilisateur
            $data['user'] = $user;
        }

        // Retourner la vue avec les données
        return view('TypesMassages/Templates/navbar', $data);
        
        if ($data['isAdmin']) {
            return view('TypesMassages/Templates/adminnav', $data);
        }
    }
}
