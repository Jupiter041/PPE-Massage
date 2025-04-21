<?php

namespace App\Controllers;

use App\Models\ReservationsModel;
use App\Models\EmployeModel;
use App\Models\TypeMassageModel;
use CodeIgniter\API\ResponseTrait;

class WebServiceController extends BaseController
{
    use ResponseTrait;

    public function getData($id = null)
    {
        $employeId = $id;
        
        $employe = EmployeModel::find($employeId);
        if (!$employe) {
            return $this->fail('Employé non trouvé', 404);
        }

        $reservations = ReservationsModel::where('employe_id', $employeId)
            ->with(['typeMassage', 'salle'])
            ->orderBy('heure_reservation', 'ASC')
            ->get();

        if ($reservations->isEmpty()) {
            return $this->respondNoContent();
        }

        $data = $reservations->map(function($reservation) {
            $dateTime = new \DateTime($reservation->heure_reservation);
            $heureFinDateTime = clone $dateTime;
            $heureFinDateTime->modify('+' . $reservation->duree . ' minutes');
            
            return [
                'reservation_id' => $reservation->reservation_id,
                'date' => $dateTime->format('Y-m-d'),
                'heure' => $dateTime->format('H:i'),
                'heure_fin' => $heureFinDateTime->format('H:i'),
                'jour_semaine' => $dateTime->format('N'),
                'nom_massage' => $reservation->typeMassage ? $reservation->typeMassage->nom_type : null,
                'salle_id' => $reservation->salle_id,
                'duree' => $reservation->duree
            ];
        });

        return $this->respond($data);
    }

    public function getComments($id = null) 
    {
        if ($id) {
            $reservation = ReservationsModel::find($id);
            if (!$reservation) {
                return $this->fail('Réservation non trouvée', 404);
            }
            return $this->respond(['commentaires' => $reservation->commentaires]);
        }

        $reservations = ReservationsModel::select('reservation_id', 'commentaires', 'heure_reservation')
            ->whereNotNull('commentaires')
            ->orderBy('heure_reservation', 'DESC')
            ->get();

        if ($reservations->isEmpty()) {
            return $this->respondNoContent();
        }

        return $this->respond($reservations);
    }
}