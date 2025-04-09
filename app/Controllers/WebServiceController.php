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
        $reservationModel = new ReservationsModel();
        
        $employe = (new EmployeModel())->find($employeId);
        if (!$employe) {
            return $this->fail('Employé non trouvé', 404);
        }

        $reservations = $reservationModel
            ->where('employe_id', $employeId)
            ->with(['typeMassage'])
            ->orderBy('heure_reservation', 'ASC')
            ->get();

        if (!$reservations) {
            return $this->respondNoContent();
        }

        $typeMassageModel = new TypeMassageModel();
        $data = array_map(function($reservation) use ($typeMassageModel) {
            $typeMassage = $typeMassageModel->find($reservation['type_id']);
            $dateTime = new \DateTime($reservation['heure_reservation']);
            return [
                // 'date_heure' => $dateTime->format('Y-m-d H:i:s'),
                'date' => $dateTime->format('Y-m-d'),
                'heure' => $dateTime->format('H:i'),
                'jour_semaine' => $dateTime->format('N'),
                'nom_massage' => $typeMassage ? $typeMassage->nom_type : null
            ];
        }, $reservations->toArray());

        return $this->respond($data);
    }
}