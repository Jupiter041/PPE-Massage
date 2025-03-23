<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TypeMassageModel;
use App\Models\PanierModel;

class TypesMassagesController extends BaseController
{
    protected $session;
    protected $typeMassageModel;
    protected $userModel;
    protected $panierModel;

    public function __construct()
    {
        helper('form');
        $this->session = \Config\Services::session();
        $this->typeMassageModel = new TypeMassageModel();
        $this->userModel = new UserModel();
        $this->panierModel = new PanierModel();
    }

    public function index()
    {
        // Démarrer la session
        $session = session();

        // Initialiser la variable user à null
        $data['user'] = null;

        // Vérifier si l'utilisateur est connecté
        if ($session->get('isLoggedIn')) {
            // Récupérer l'ID de l'utilisateur depuis la session
            $userId = $session->get('id');

            // Rechercher l'utilisateur dans la base de données
            $user = $this->userModel->find($userId);

            // Lever une exception si l'utilisateur n'est pas trouvé
            if (!$user) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
            }

            // Stocker les données de l'utilisateur
            $data['user'] = $user;
        }

        $typesMassages = $this->typeMassageModel->findAllAsObjects();
        $data['typesMassages'] = $typesMassages;

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/index', $data);
        echo view('TypesMassages/Templates/footer');
    }

    public function details($id = null)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour ajouter au panier');
        }

        if ($id === null) {
            return redirect()->to('/TypesMassages')->with('error', 'Massage non trouvé');
        }

        $typeMassage = $this->typeMassageModel->find($id);
        if (!$typeMassage) {
            return redirect()->to('/TypesMassages')->with('error', 'Massage non trouvé');
        }

        $panierData = [
            'compte_id' => $session->get('id'),
            'type_massage_id' => $id,
            'quantite' => 1,
            'date_ajout' => date('Y-m-d H:i:s')
        ];

        if ($this->panierModel->insert($panierData)) {
            return redirect()->to('/panier')->with('success', 'Massage ajouté au panier avec succès');
        } else {
            return redirect()->to('/TypesMassages')->with('error', "Erreur lors de l'ajout au panier");
        }
    }
    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') != 1) {
            return redirect()->to('/TypesMassages')->with('error', 'Accès réservé aux administrateurs');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = $this->sanitizeInput([
                'nom_type' => $this->request->getPost('nom_type'),
                'description' => $this->request->getPost('description'),
                'prix' => $this->request->getPost('prix'),
            ]);

            $rules = [
                'nom_type' => 'required|min_length[3]',
                'description' => 'required',
                'prix' => 'required|decimal',
            ];

            $validator = \Config\Services::validation();
            if (!$validator->setRules($rules)->run($data)) {
                return redirect()->back()->withInput()->with('errors', $validator->getErrors());
            }

            if ($this->typeMassageModel->insert($data)) {
                return redirect()->to('/TypesMassages')->with('success', 'Type de massage ajouté avec succès');
            } else {
                return redirect()->back()->withInput()->with('errors', ['Erreur lors de la création du type de massage']);
            }
        }

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/create');
        echo view('TypesMassages/Templates/footer');
    }
    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') != 1) {
            return redirect()->to('/TypesMassages')->with('error', 'Accès réservé aux administrateurs');
        }

        $typeMassage = $this->typeMassageModel->find($id);

        if (!$typeMassage) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Le type de massage avec l'ID $id n'existe pas.");
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'nom_type' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]',
                'prix' => 'required|decimal',
            ];

            $data = $this->sanitizeInput([
                'nom_type' => $this->request->getPost('nom_type'),
                'description' => $this->request->getPost('description'),
                'prix' => $this->request->getPost('prix'),
            ]);

            if ($this->validate($rules)) {
                $typeMassage = $this->typeMassageModel->find($id);
                $typeMassage->fill($data);
                if ($typeMassage->save()) {
                    return redirect()->to('/TypesMassages')->with('success', 'Type de massage modifié avec succès');
                }
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/edit', ['typeMassage' => $typeMassage]);
        echo view('TypesMassages/Templates/footer');
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') != 1) {
            return redirect()->to('/TypesMassages')->with('error', 'Accès réservé aux administrateurs');
        }

        $rules = [
            'nom_type' => 'required|min_length[3]|max_length[255]',
            'description' => 'required|min_length[10]',
            'prix' => 'required|decimal',
        ];

        $data = $this->sanitizeInput([
            'nom_type' => $this->request->getPost('nom_type'),
            'description' => $this->request->getPost('description'),
            'prix' => $this->request->getPost('prix'),
        ]);

        if ($this->validate($rules)) {
            $typeMassage = $this->typeMassageModel->find($id);
            $typeMassage->fill($data);
            if ($typeMassage->save()) {
                return redirect()->to('/TypesMassages')->with('success', 'Type de massage modifié avec succès');
            }
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la modification');
        }

        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') != 1) {
            return redirect()->to('/TypesMassages')->with('error', 'Accès réservé aux administrateurs');
        }

        $typeMassage = $this->typeMassageModel->find($id);
        if ($typeMassage) {
            $typeMassage->delete();
            return redirect()->to(base_url('TypesMassages'))->with('message', 'Type de massage supprimé avec succès');
        }
        return redirect()->to('/TypesMassages')->with('error', 'Erreur lors de la suppression');
    }
    public function success()
    {
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/success');
        echo view('TypesMassages/Templates/footer');
    }

    public function store()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') != 1) {
            return redirect()->to('/TypesMassages')->with('error', 'Accès réservé aux administrateurs');
        }

        $validation = \Config\Services::validation();

        $rules = [
            'nom_type' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'prix' => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = $this->sanitizeInput([
            'nom_type' => $this->request->getPost('nom_type'),
            'description' => $this->request->getPost('description'),
            'prix' => $this->request->getPost('prix'),
        ]);

        if ($this->typeMassageModel->insert($data)) {
            return redirect()->to('/TypesMassages')->with('success', 'Type de massage ajouté avec succès');
        }
        return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout');
    }

    private function sanitizeInput(array $data): array
    {
        $sanitized = [];
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'nom_type':
                case 'description':
                    $sanitized[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                    break;
                case 'prix':
                    $sanitized[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    break;
                default:
                    $sanitized[$key] = $value;
            }
        }
        return $sanitized;
    }
}