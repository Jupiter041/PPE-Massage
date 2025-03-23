<?php

namespace App\Controllers;

use App\Models\ReservationsModel;
use App\Models\ClientModel;
use CodeIgniter\Controller;

class ReservationsController extends Controller
{
    protected $reservationsModel;

    public function __construct()
    {
        $this->reservationsModel = new ReservationsModel();
    }

    public function index()
    {
        return view('massage_details');
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $session = session();
            if (!$session->get('isLoggedIn')) {
                return $this->response->setJSON(['error' => 'Vous devez être connecté'])->setStatusCode(401);
            }

            if (!$this->validate([
                'Nom' => 'required',
                'Email' => 'required|valid_email',
                'Telephone' => 'required|numeric|exact_length[10]',
                'TypeMassage' => 'required|numeric',
                'Duree' => 'required',
                'Date' => 'required|valid_date',
                'Heure' => 'required',
            ])) {
                return $this->response->setJSON(['error' => $this->validator->getErrors()])->setStatusCode(400);
            }

            $clientModel = new ClientModel();
            $client = $clientModel->where('compte_id', $session->get('id'))->first();

            if (!$client) {
                $clientData = [
                    'email' => $this->request->getPost('Email'),
                    'telephone' => $this->request->getPost('Telephone'),
                    'compte_id' => $session->get('id')
                ];
                $client_id = $clientModel->insert($clientData);
            } else {
                $client_id = $client['client_id'];
            }

            $data = [
                'heure_reservation' => $this->request->getPost('Date') . ' ' . $this->request->getPost('Heure'),
                'commentaires' => $this->request->getPost('Com'),
                'duree' => $this->request->getPost('Duree'),
                'type_id' => $this->request->getPost('TypeMassage'),
                'client_id' => $client_id,
                'employe_id' => null,
                'salle_id' => null
            ];

            // Insérer dans la table en_attente
            if ($this->reservationsModel->insertEnAttente($data)) {
                return $this->response->setJSON(['success' => true]);
            }

            return $this->response->setJSON(['error' => 'Erreur lors de la création de la réservation'])->setStatusCode(500);
        }
    }

    public function transfererReservation($id)
    {
        if ($this->reservationsModel->transfererReservation($id)) {
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['error' => 'Erreur lors du transfert de la réservation'])->setStatusCode(500);
    }
}
