<?php

namespace App\Controllers;

use App\Models\SalleModel;

class GereSalleController extends BaseController
{
    public function index()
    {
        $salles = SalleModel::all();
        
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/adminnav');
        echo view('TypesMassages/Templates/navbar');
        echo view('gestion/Salle/gere_salle', ['salles' => $salles]);
        echo view('TypesMassages/Templates/footer');
    }

    public function showCreate()
    {
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/adminnav');
        echo view('TypesMassages/Templates/navbar');
        echo view('gestion/Salle/create_salle');
        echo view('TypesMassages/Templates/footer');
    }

    public function create()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nom_salle' => 'required|min_length[3]|max_length[50]',
            'disponibilite' => 'required|in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        SalleModel::create([
            'nom_salle' => $this->request->getPost('nom_salle'),
            'disponibilite' => $this->request->getPost('disponibilite')
        ]);

        return redirect()->to('/admin/gestion/salles')->with('success', 'Salle créée avec succès');
    }

    public function edit($id)
    {
        $salle = SalleModel::find($id);
        
        if (!$salle) {
            return redirect()->to('/admin/gestion/salles')->with('error', 'Salle non trouvée');
        }

        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/adminnav');
        echo view('TypesMassages/Templates/navbar');
        echo view('gestion/Salle/modif_salle', ['salle' => $salle]);
        echo view('TypesMassages/Templates/footer');
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nom_salle' => 'required|min_length[3]|max_length[50]',
            'disponibilite' => 'required|in_list[0,1]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $salle = SalleModel::find($id);
        $salle->update([
            'nom_salle' => $this->request->getPost('nom_salle'),
            'disponibilite' => $this->request->getPost('disponibilite')
        ]);

        return redirect()->to('/admin/gestion/salles')->with('success', 'Salle modifiée avec succès');
    }

    public function delete($id)
    {
        $salle = SalleModel::find($id);
        
        if (!$salle) {
            return redirect()->to('/admin/gestion/salles')->with('error', 'Salle non trouvée');
        }

        try {
            $salle->delete();
            return redirect()->to('/admin/gestion/salles')->with('success', 'Salle supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->to('/admin/gestion/salles')->with('error', 'Impossible de supprimer cette salle car elle est liée à des réservations');
        }
    }
}