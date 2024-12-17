<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ReservationsModel;

class ReservationControlleur extends Controller
{
    protected $typeMassageModel;
    protected $reservationsModel;

    public function __construct()
    {
        $this->typeMassageModel = model('TypeMassageModel');
        $this->reservationsModel = new ReservationsModel();
    }

    public function reserver()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour réserver un massage');
        }

        $rules = [
            'Nom' => 'required|min_length[3]',
            'Email' => 'required|valid_email', 
            'Telephone' => 'required|numeric|exact_length[10]',
            'TypeMassage' => 'required|numeric',
            'Duree' => 'required',
            'Date' => 'required|valid_date',
            'Heure' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'client_id' => session()->get('id'),
            'type_id' => $this->request->getPost('TypeMassage'),
            'heure_reservation' => $this->request->getPost('Date') . ' ' . $this->request->getPost('Heure'),
            'duree' => $this->request->getPost('Duree'),
            'commentaires' => $this->request->getPost('Com')
        ];

        $this->reservationsModel->insert($data);

        return redirect()->to('/TypesMassages/success')->with('success', 'Votre réservation a été enregistrée');
    }

    public function select($id = null)
    {
        return redirect()->to('/TypesMassages/details/' . $id);
    }

    public function confirmSelection()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter pour réserver un massage');
        }

        $massageId = $this->request->getPost('massage_id');
        if (!$massageId) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un massage');
        }

        $selectedMassage = $this->typeMassageModel->find($massageId);
        if (!$selectedMassage) {
            return redirect()->back()->with('error', 'Massage non trouvé');
        }

        return redirect()->to('/TypesMassages/success')->with('success', 'Votre sélection a été confirmée');
    }
}
