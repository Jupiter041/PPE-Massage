<?php
/**
 *? Comment faire pour que les informations de chaques massage soient mise dans la bdd puis transférer vers la table reservations ?
 * TODO: Ajouter une fonction pour stocker les données du panier dans la base de données -> utilisation de la table en_attente + changer le formulaire de /TypesMassages/panier.php
*/
namespace App\Controllers;

use App\Models\PanierModel;
use App\Models\TypeMassageModel;
use App\Models\ReservationsModel;
use App\Models\UserModel;
use App\Models\EmployeModel;
use App\Models\EnAttenteModel;

class PanierController extends BaseController
{
    protected $panierModel;
    protected $typeMassageModel;
    protected $reservationsModel;
    protected $userModel;
    protected $employeModel;
    protected $enAttenteModel;

    public function __construct()
    {
        $this->panierModel = new PanierModel();
        $this->typeMassageModel = new TypeMassageModel();
        $this->reservationsModel = new ReservationsModel();
        $this->userModel = new UserModel();
        $this->employeModel = new EmployeModel();
        $this->enAttenteModel = new EnAttenteModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        if (empty($compteId)) {
            return redirect()->to('/connexion')->with('error', 'Session invalide');
        }

        $panier = $this->panierModel
            ->with('typeMassage')
            ->where('compte_id', $compteId)
            ->get();

        $employes = $this->employeModel->findAll();

        $data = [
            'title' => 'Mon Panier',
            'panier' => $panier,
            'employes' => $employes
        ];
        echo view('TypesMassages/Templates/header');
        echo view('TypesMassages/Templates/navbar');
        echo view('TypesMassages/panier', $data);
        echo view('TypesMassages/Templates/footer');
    }

    public function ajouter($typeId)
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        if (empty($compteId)) {
            return redirect()->to('/connexion')->with('error', 'Session invalide');
        }

        $data = [
            'compte_id' => $compteId,
            'type_massage_id' => $typeId,
            'quantite' => 1,
            'date_ajout' => date('Y-m-d H:i:s')
        ];

        $this->panierModel->insertData($data);
        return redirect()->to('/panier')->with('success', 'Article ajouté au panier');
    }

    public function supprimer($typeId)
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        if (empty($compteId)) {
            return redirect()->to('/connexion')->with('error', 'Session invalide');
        }

        $this->panierModel->where('compte_id', $compteId)
                          ->where('type_massage_id', $typeId)
                          ->delete();

        return redirect()->to('/panier')->with('success', 'Article retiré du panier');
    }

    public function vider()
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion');
        }

        $compteId = $session->get('id');
        if (empty($compteId)) {
            return redirect()->to('/connexion')->with('error', 'Session invalide');
        }

        $this->panierModel->where('compte_id', $compteId)->delete();

        return redirect()->to('/panier')->with('success', 'Panier vidé avec succès');
    }

    public function ajouterMultiple()
    {
        $session = session();
        if (!$session->has('id')) {
            return redirect()->to('/connexion')->with('error', 'Utilisateur non connecté');
        }

        $compteId = $session->get('id');
        if (empty($compteId)) {
            return redirect()->to('/connexion')->with('error', 'Session invalide');
        }

        $panier = $this->panierModel->where('compte_id', $compteId)->findAll();

        try {
            foreach ($panier as $item) {
                if (!isset($item->type_massage_id)) {
                    throw new \Exception('ID du type de massage manquant');
                }

                $date = $this->request->getPost('heure_reservation_' . $item->type_massage_id);
                $heure = $this->request->getPost('heure_' . $item->type_massage_id);

                if (empty($date) || empty($heure)) {
                    throw new \Exception('Date ou heure manquante');
                }

                // Validation du format de la date (YYYY-MM-DD)
                if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
                    throw new \Exception('Format de date invalide');
                }

                // Validation du format de l'heure (HH:MM)
                if (!preg_match("/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/", $heure)) {
                    throw new \Exception('Format d\'heure invalide');
                }

                $heureReservation = $date . ' ' . $heure;
                
                // Vérification que la date est dans le futur
                $dateTime = new \DateTime($heureReservation);
                $now = new \DateTime();
                
                if ($dateTime <= $now) {
                    throw new \Exception('La date de réservation doit être dans le futur');
                }
                
                $enAttenteData = [
                    'compte_id' => $compteId,
                    'type_id' => $item->type_massage_id,
                    'duree' => $this->request->getPost('duree_' . $item->type_massage_id),
                    'heure_reservation' => $heureReservation,
                    'preference_praticien' => $this->request->getPost('preference_praticien_' . $item->type_massage_id),
                    'commentaires' => $this->request->getPost('commentaires_' . $item->type_massage_id),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $this->enAttenteModel->insert($enAttenteData);
            }

            $this->panierModel->where('compte_id', $compteId)->delete();

            return redirect()->to('/panier')->with('success', 'Réservations en attente enregistrées avec succès');
        } catch (\Exception $e) {
            return redirect()->to('/panier')->with('error', 'Erreur lors de l\'enregistrement des réservations: ' . $e->getMessage());
        }
    }
}
