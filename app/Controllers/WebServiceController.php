<?php

namespace App\Controllers;

use App\Models\ReservationsModel;
use App\Models\EmployeModel;
use App\Models\TypeMassageModel;
use App\Models\EmpechementModel;
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
        $model = new ReservationsModel();
        
        if ($id) {
            $reservation = $model->find($id);
            if (!$reservation) {
                return $this->fail('Réservation non trouvée', 404);
            }
            return $this->respond(['commentaires' => $reservation->commentaires]);
        }

        $reservations = $model->select('reservation_id, commentaires, heure_reservation')
            ->where('commentaires IS NOT NULL')
            ->orderBy('heure_reservation', 'DESC')
            ->all();

        if (empty($reservations)) {
            return $this->respondNoContent();
        }

        return $this->respond($reservations);
    }


    public function createEmpechement()
    {
        try {
            helper('jwt');
            $user = getConnectedUser();
            
            $json = $this->request->getJSON();
            
            if (empty($json)) {
                return $this->fail('Invalid JSON data received', 400);
            }

            if (!isset($json->employe_id) || !isset($json->motif)) {
                return $this->fail('Missing required fields', 400);
            }
            
            $empechement = new EmpechementModel();
            $data = [
                'employe_id' => $json->employe_id,
                'motif' => $json->motif,
                'reservation_id' => isset($json->reservation_id) ? $json->reservation_id : null
            ];
            
            $result = $empechement->insert($data);
            
            if (!$result) {
                return $this->fail('Failed to create empechement', 500);
            }
            
            return $this->respond(['success' => true]);
            
        } catch (\Exception $e) {
            log_message('error', '[createEmpechement] ' . $e->getMessage());
            return $this->fail('Une erreur interne est survenue', 500);
        }
    }
}