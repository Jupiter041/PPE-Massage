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
        $data = [
            'title' => 'Logs système',
            'table' => $this->request->getGet('table'),
            'action' => $this->request->getGet('action')
        ];
        
        $query = $this->logModel->orderBy('date_log', 'DESC');
        
        if (!empty($data['table'])) {
            $query->where('table_name', $data['table']);
        }
        if (!empty($data['action'])) {
            $query->where('action', $data['action']);
        }
        
        $data['logs'] = $query->get()->toArray();

        return view('TypesMassages/Templates/header')
            . view('TypesMassages/Templates/navbar')
            . view('TypesMassages/logs', $data)
            . view('TypesMassages/Templates/footer');
    }

    public function show($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') != 1) {
            return redirect()->to('/logs')->with('error', 'Accès réservé aux administrateurs');
        }

        $data = [
            'title' => 'Détail du log',
            'log' => $this->logModel->find($id)
        ];
        
        if (!$data['log']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Le log avec l'ID $id n'existe pas.");
        }

        return view('TypesMassages/Templates/header')
            . view('TypesMassages/Templates/navbar')
            . view('TypesMassages/show', $data)
            . view('TypesMassages/Templates/footer');
    }
}
