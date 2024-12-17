<?php

namespace App\Controllers;

use App\Models\PanierModel;
use App\Models\TypeMassageModel;
use App\Models\UserModel;

class PanierController extends BaseController
{
    protected $panierModel;
    protected $typesMassagesModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->panierModel = new PanierModel();
        $this->typesMassagesModel = new TypeMassageModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('compte_id');
        $data['items'] = $this->panierModel->where('panier.compte_id', $userId)
            ->join('type_massage', 'panier.type_massage_id = type_massage.type_id')
            ->select('panier.*, type_massage.nom_type, type_massage.prix')
            ->findAll();
        
        return view('Panier/index', $data);
    }

    public function ajouter($typeId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('compte_id');
        $session = session();
        
        try {
            // Vérifier si le type de massage existe déjà dans le panier
            $existingItem = $this->panierModel
                ->where('compte_id', $userId)
                ->where('type_massage_id', $typeId)
                ->first();

            if ($existingItem) {
                // Si l'article existe, augmenter la quantité
                $this->panierModel->update($existingItem->panier_id, [
                    'quantite' => $existingItem->quantite + 1
                ]);
            } else {
                // Si l'article n'existe pas, créer un nouvel enregistrement
                $data = [
                    'compte_id' => $userId,
                    'type_massage_id' => $typeId,
                    'quantite' => 1,
                    'date_ajout' => date('Y-m-d H:i:s')
                ];
                $this->panierModel->insert($data);
            }
            $session->setFlashdata('success', 'Article ajouté au panier avec succès');
            return redirect()->to('/panier');
        } catch (\Exception $e) {
            $session->setFlashdata('msg', 'Une erreur est survenue lors de l\'ajout au panier.');
            return redirect()->back();
        }
    }

    public function supprimer($panierId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $session = session();
        try {
            $this->panierModel->where('panier_id', $panierId)->delete();
            $session->setFlashdata('success', 'Article supprimé du panier');
            return redirect()->to('/panier');
        } catch (\Exception $e) {
            $session->setFlashdata('msg', 'Une erreur est survenue lors de la suppression.');
            return redirect()->back();
        }
    }

    public function updateQuantite()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $session = session();
        try {
            $panierId = $this->request->getPost('panier_id');
            $quantite = $this->request->getPost('quantite');

            $this->panierModel->where('panier_id', $panierId)->update(['quantite' => $quantite]);
            $session->setFlashdata('success', 'Quantité mise à jour');
            return redirect()->to('/panier');
        } catch (\Exception $e) {
            $session->setFlashdata('msg', 'Une erreur est survenue lors de la mise à jour.');
            return redirect()->back();
        }
    }

    public function vider()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $session = session();
        try {
            $userId = session()->get('compte_id');
            $this->panierModel->where('compte_id', $userId)->delete();
            $session->setFlashdata('success', 'Panier vidé avec succès');
            return redirect()->to('/panier');
        } catch (\Exception $e) {
            $session->setFlashdata('msg', 'Une erreur est survenue lors du vidage du panier.');
            return redirect()->back();
        }
    }
}
