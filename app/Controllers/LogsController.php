<?php

namespace App\Controllers;

use App\Models\LogModel;

class LogsController extends BaseController
{
    protected $session;
    protected $logModel;

    public function __construct()
    {
        helper('form');
        $this->session = \Config\Services::session();
        $this->logModel = new LogModel();
    }

    public function index()
    {
        $table = $this->request->getGet('table');
        $action = $this->request->getGet('action');
        
        $query = $this->logModel->orderBy('date_log', 'DESC');
        
        if (!empty($table)) {
            $query->where('table_name', $table);
        }
        if (!empty($action)) {
            $query->where('action', $action);
        }
        
        $logs = $query->get()->toArray();

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/logs', ['logs' => $logs]);
        echo view('TypesMassages/Templates/footer');
    }

    public function show($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') != 1) {
            return redirect()->to('/logs')->with('error', 'Accès réservé aux administrateurs');
        }

        $log = $this->logModel->find($id);
        
        if (!$log) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Le log avec l'ID $id n'existe pas.");
        }

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('show', ['log' => $log]);
        echo view('TypesMassages/Templates/footer');
    }
}
