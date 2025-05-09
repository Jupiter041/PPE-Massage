<?php

namespace App\Controllers;

use App\Models\EnAttenteModel;
use App\Models\UserModel;
use App\Models\EmployeModel;
use App\Models\SalleModel;
use App\Models\PanierModel;
use App\Models\TypeMassageModel;
use App\Models\ReservationsModel;

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
            'employes' => EmployeModel::all(),
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
        $typeId = $this->request->getPost('type_id');
        $heure = $this->request->getPost('heure');
        $date = $this->request->getPost('heure_reservation');
        $duree = $this->request->getPost('duree');
            
        if (!$date || !$heure || !$typeId || !$duree) {
            return redirect()->back()->withInput()->with('error', 'Tous les champs sont obligatoires.');
        }
            
        $heureReservation = $date . ' ' . $heure;
        $dateTimeDebut = new \DateTime($heureReservation);
        $dateTimeFin = clone $dateTimeDebut;
        $dateTimeFin->modify("+$duree minutes");
            
        $employeDispo = EmployeModel::getEmployeDisponible($dateTimeDebut, $dateTimeFin);
            
        if (!$employeDispo) {
            return redirect()->back()->withInput()->with('error', 'Aucun employé disponible pour ce créneau.');
        }
            
        $salle = (new SalleModel())->getSalleDisponible($dateTimeDebut, $dateTimeFin);
            
        if (!$salle) {
            return redirect()->back()->withInput()->with('error', 'Aucune salle disponible.');
        }

        $panierModel = new PanierModel();
        $panier = $panierModel->where('compte_id', $compteId)->first();

        if (!$panier) {
            return redirect()->back()->withInput()->with('error', 'Panier non trouvé');
        }

        $enAttente = new EnAttenteModel();
        $data = [
            'compte_id' => $compteId,
            'type_id' => $typeId,
            'duree' => $duree,
            'heure_reservation' => $heureReservation,
            'salle_id' => $salle->salle_id,
            'employe_id' => $employeDispo->employe_id,
            'preference_praticien' => $this->request->getPost('preference_praticien'),
            'commentaires' => $this->request->getPost('commentaires'),
            'panier_id' => $panier->panier_id,
            'created_at' => date('Y-m-d H:i:s')
        ];

        try {
            if($enAttente->createFromCart($data)) {
                return redirect()->to('/TypesMassages')->with('success', 'Réservation créée');
            }
        } catch (\Exception $e) {
            $reservationModel = new ReservationsModel();
            $creneauxDispos = $reservationModel->getCreneauxDisponibles(date('Y-m-d'));
            return redirect()->back()->withInput()
                ->with('error', 'Ce créneau n\'est plus disponible. Veuillez en choisir un autre.')
                ->with('creneaux_dispos', $creneauxDispos);
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
            'employes' => EmployeModel::all(),
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

    public function afficherCreneaux($type_massage_id)
{
    $date = date('Y-m-d');
    $reservationModel = new ReservationsModel();
    $creneauxDispos = $reservationModel->getCreneauxDisponibles($date);
    
    return view('TypesMassages/creneaux', [
        'creneaux' => $creneauxDispos,
        'type_massage_id' => $type_massage_id
    ]);
}

public function reserver($type_massage_id)
{
    $creneau = $this->request->getPost('creneau');
    if (empty($creneau)) {
        return redirect()->back()->with('error', 'Veuillez sélectionner un créneau');
    }

    $data = [
        'type_massage_id' => $type_massage_id,
        'heure_debut' => $creneau,
        'date' => date('Y-m-d')
    ];

    try {
        $enAttente = new EnAttenteModel();
        if ($enAttente->createFromCart($data)) {
            return redirect()->to('/TypesMassages')->with('success', 'Réservation créée avec succès');
        }
    } catch (\Exception $e) {
        $reservationModel = new ReservationsModel();
        $creneauxDispos = $reservationModel->getCreneauxDisponibles(date('Y-m-d'));
        return redirect()->back()
            ->with('error', 'Ce créneau n\'est plus disponible. Voici les créneaux disponibles aujourd\'hui: ' . json_encode($creneauxDispos));
    }
}

public function getAvailableSlots()
{
    $date = $this->request->getGet('date');
    $duration = $this->request->getGet('duration');
    $clientId = session()->get('id'); // Récupère l'ID du client connecté
    
    if (!$date) {
        return $this->response->setJSON(['error' => 'Date requise'])->setStatusCode(400);
    }

    $reservationModel = new ReservationsModel();
    $reservedSlots = $reservationModel->getReservedTimeSlots($date);

    // Générer tous les créneaux possibles (9h-20h)
    $allSlots = [];
    $startTime = strtotime($date . ' 09:00:00');
    $endTime = strtotime($date . ' 20:00:00');
    
    // Pas de 30 minutes, durée minimum
    for ($time = $startTime; $time <= $endTime - ($duration * 60); $time += 1800) {
        $allSlots[] = date('H:i', $time);
    }

    // Filtrer les créneaux disponibles
    $availableSlots = [];
    foreach ($allSlots as $slot) {
        $isAvailable = $reservationModel->isTimeSlotAvailable($date, $slot, $duration, $clientId);
        
        if ($isAvailable) {
            // Vérifier aussi la disponibilité des employés et salles
            $employeDispo = (new EmployeModel())->getEmployeDisponible(
                new \DateTime("$date $slot"),
                new \DateTime(date('Y-m-d H:i:s', strtotime("$date $slot") + ($duration * 60)))
            );
            
            $salleDispo = (new SalleModel())->getSalleDisponible(
                new \DateTime("$date $slot"),
                new \DateTime(date('Y-m-d H:i:s', strtotime("$date $slot") + ($duration * 60)))
            );
            
            if ($employeDispo && $salleDispo) {
                $availableSlots[] = $slot;
            }
        }
    }

    return $this->response->setJSON(['slots' => $availableSlots]);
}}