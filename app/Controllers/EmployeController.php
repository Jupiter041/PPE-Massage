<?php
namespace App\Controllers;

use App\Models\EmployeModel;
use DateTime;

class EmployeController extends BaseController
{
    public function getTimeSlots($employeId)
    {
        $model = new EmployeModel();
        $creneaux = $model->getTimeSlots($employeId);
        
        // Formater les données
        $formatted = array_map(function($c) {
            $start = new DateTime($c['date']);
            $end = (clone $start)->modify("+{$c['duree']} minutes");
            
            return [
                'date' => $start->format('d/m/Y'),
                'debut' => $start->format('H:i'),
                'fin' => $end->format('H:i'),
                'duree' => $c['duree']
            ];
        }, $creneaux);
    
        return $this->response->setJSON($formatted);
    }
}