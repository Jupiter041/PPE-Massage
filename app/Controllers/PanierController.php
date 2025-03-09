<?php

namespace App\Controllers;

use App\Models\PanierModel;
use App\Models\TypeMassageModel;
use App\Models\ReservationsModel;
use App\Models\UserModel;
use App\Models\EmployeModel;
class PanierController extends BaseController
{
    protected $panierModel;
    protected $typeMassageModel;
    protected $reservationsModel;
    protected $userModel;
    protected $employeModel;

    public function __construct()
    {
        $this->panierModel = new PanierModel();
        $this->typeMassageModel = new TypeMassageModel();
        $this->reservationsModel = new ReservationsModel();
        $this->userModel = new UserModel();
        $this->employeModel = new EmployeModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        // Récupérer les articles du panier avec leurs détails
        $panier = $this->panierModel
            ->with('typeMassage')
            ->where('compte_id', $compteId)
            ->get();

        // Récupérer tous les employés
        $employes = $this->employeModel->findAll();

        $data = [
            'title' => 'Mon Panier',
            'panier' => $panier,
            'employes' => $employes
        ];
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/panier', $data);
        echo view('TypesMassages/Templates/footer');
    }

    public function ajouter($typeId)
    {
        $session = session();
        if (!$session->get('id')) {
            return redirect()->to('/connexion');
        }

        $data = [
            'compte_id' => $session->get('id'),
            'type_massage_id' => $typeId,
            'quantite' => 1,
            'date_ajout' => date('Y-m-d H:i:s')
        ];

        $this->panierModel->insertData($data);
        return redirect()->to('/panier')->with('success', 'Article ajouté au panier');
    }

    public function supprimer($typeId)
    {
        $session = session();
        if (!$session->get('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        $this->panierModel->where('compte_id', $compteId)
                         ->where('type_massage_id', $typeId)
                         ->delete();
                         
        return redirect()->to('/panier')->with('success', 'Article retiré du panier');
    }
    
    public function vider()
    {
        $session = session();
        if (!$session->get('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        $this->panierModel->where('compte_id', $compteId)->delete();
        
        return redirect()->to('/panier')->with('success', 'Panier vidé avec succès');
    }

    public function ajouterMultiple()
    {
        $session = session();
        if (!$session->get('id')) {
            return redirect()->to('/connexion')->with('error', 'Utilisateur non connecté');
        }

        $compteId = $session->get('id');
        $reservations = explode('||', $this->request->getPost('reservations'));

        if (empty($reservations)) {
            return redirect()->to('/panier')->with('error', 'Aucune réservation fournie');
        }

        try {
            foreach ($reservations as $reservation) {
                $reservationData = [];
                $fields = explode('&', $reservation);
                foreach ($fields as $field) {
                    $keyValue = explode('=', $field);
                    if (count($keyValue) == 2) {
                        $reservationData[urldecode($keyValue[0])] = urldecode($keyValue[1]);
                    }
                }

                $insertData = [
                    'compte_id' => $compteId,
                    'type_id' => $reservationData['type_massage_id'],
                    'heure_reservation' => $reservationData['heure_reservation'],
                    'duree' => $reservationData['duree'],
                    'salle_id' => $reservationData['salle_id'],
                    'employe_id' => $reservationData['employe_id'],
                    'preference_praticien' => $reservationData['preference_praticien'] ?? null,
                    'commentaires' => $reservationData['commentaires'] ?? null,
                    'date_creation' => date('Y-m-d H:i:s'),
                    'statut' => 'en_attente'
                ];
                
                $this->reservationsModel->insert($insertData);
            }

            // Vider le panier après création des réservations
            $this->panierModel->where('compte_id', $compteId)->delete();

            return redirect()->to('/panier')->with('success', 'Réservations enregistrées avec succès');
        } catch (\Exception $e) {
            return redirect()->to('/panier')->with('error', $e->getMessage());
        }
    }
}
