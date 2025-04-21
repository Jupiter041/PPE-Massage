<?php

namespace App\Controllers;

use App\Models\ReservationsModel;
use App\Models\EnAttenteModel;
use App\Models\PanierModel;
use App\Models\UserModel;
use App\Models\EmployeModel;
use App\Models\SalleModel;
use App\Models\TypeMassageModel;

class ReservationsController extends BaseController
{
    public function create()
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion');
        }

        $panierModel = new PanierModel();
        $enAttenteModel = new EnAttenteModel();
        $reservationsModel = new ReservationsModel();
        
        // Récupérer tous les articles du panier de l'utilisateur connecté
        $panierItems = PanierModel::where('compte_id', session()->get('id'))->get();
        
        // Vérifier si tous les articles ont des réservations en attente
        $incompletItems = [];
        foreach ($panierItems as $item) {
            $enAttente = EnAttenteModel::where('panier_id', $item->panier_id)->first();
            if (!$enAttente) {
                $incompletItems[] = $item->typeMassage->nom_type;
            }
        }
        
        if (!empty($incompletItems)) {
            return redirect()->back()->with('error', 'Veuillez spécifier les détails de réservation pour les massages suivants : ' . implode(', ', $incompletItems));
        }

        // Transférer les réservations en attente vers les réservations confirmées
        foreach ($panierItems as $item) {
            $enAttente = EnAttenteModel::where('panier_id', $item->panier_id)->first();
            
            if ($enAttente) {
                // Créer la réservation
                ReservationsModel::create([
                    'heure_reservation' => $enAttente->heure_reservation,
                    'commentaires' => $enAttente->commentaires,
                    'duree' => $enAttente->duree,
                    'salle_id' => $enAttente->salle_id,
                    'type_id' => $enAttente->type_id,
                    'employe_id' => $enAttente->employe_id,
                    'preference_praticien' => $enAttente->preference_praticien,
                    'compte_id' => $enAttente->compte_id
                ]);
                
                // Supprimer l'entrée en attente
                $enAttente->delete();
                
                // Supprimer l'article du panier
                $item->delete();
            }
        }
        
        return redirect()->to('/panier')->with('success', 'Vos réservations ont été confirmées avec succès.');
    }
}
