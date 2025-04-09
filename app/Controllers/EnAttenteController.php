<?php

namespace App\Controllers;

use App\Models\EnAttenteModel;
use App\Models\UserModel;
use App\Models\EmployeModel;
use App\Models\SalleModel;
use App\Models\PanierModel;
use App\Models\TypeMassageModel;

class EnAttenteController extends BaseController
{
    public function index($type_id = null)
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        if (empty($compteId)) {
            return redirect()->to('/connexion')->with('error', 'Session invalide');
        }

        $typeMassage = TypeMassageModel::find($type_id);
        if (!$typeMassage) {
            return redirect()->to('/TypesMassages')->with('error', 'Type de massage non trouvé');
        }

        $panierModel = new PanierModel();
        $panier = $panierModel->where('compte_id', $compteId)->first();



        $data = [
            'employes' => EmployeModel::findAll(),
            'salles' => SalleModel::all(),
            'type_id' => $type_id,
            'panier' => $panier
        ];

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/en_attente', $data);
        echo view('TypesMassages/Templates/footer');
    }    

    public function create()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour faire une réservation');
        }

        $compteId = $session->get('id');
        $user = UserModel::find($compteId);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Utilisateur non trouvé.');
        }

        $heureReservation = $this->request->getPost('heure_reservation');
        $heure = $this->request->getPost('heure');
        $typeId = $this->request->getPost('type_id');
        
        if (!$heureReservation || !$heure || !$typeId) {
            return redirect()->back()->withInput()->with('error', 'La date, l\'heure et le type de massage sont requis.');
        }

        try {
            $panierModel = new PanierModel();
            $panier = $panierModel->where('compte_id', $compteId)->first();

            $reservationData = [
                'compte_id' => $user->compte_id,
                'type_id' => $typeId,
                'heure_reservation' => $heureReservation . ' ' . $heure,
                'duree' => $this->request->getPost('duree'),
                'salle_id' => $this->request->getPost('salle_id'),
                'employe_id' => $this->request->getPost('employe_id'),
                'preference_praticien' => $this->request->getPost('preference_praticien'),
                'commentaires' => $this->request->getPost('commentaires'),
                'created_at' => date('Y-m-d H:i:s'),
                'panier_id' => $panier->panier_id
            ];

            $enAttente = new EnAttenteModel();
            $enAttente->createFromCart($reservationData);
            
            return redirect()->to(base_url('TypesMassages'))->with('success', 'Votre réservation a été enregistrée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement de votre réservation.');
        }
    }

    public function edit($id)
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion');
        }

        $enAttente = new EnAttenteModel();
        $reservation = $enAttente->find($id);
        
        if (!$reservation) {
            return redirect()->to('/TypesMassages')->with('error', 'Réservation non trouvée');
        }

        $compteId = $session->get('id');
        $panierModel = new PanierModel();
        $panier = $panierModel->where('compte_id', $compteId)->first();

        $data = [
            'employes' => EmployeModel::findAll(),
            'salles' => SalleModel::all(),
            'reservation' => $reservation,
            'type_id' => $reservation->type_id,
            'panier' => $panier
        ];

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/en_attente', $data);
        echo view('TypesMassages/Templates/footer');
    }

    public function delete($id)
    {
        try {
            $enAttente = new EnAttenteModel();
            $enAttente->delete($id);
            
            return redirect()->to(base_url('TypesMassages'))->with('success', 'Réservation supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}