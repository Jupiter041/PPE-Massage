<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnAttenteModel extends Model
{
    protected $table = 'en_attente';
    protected $primaryKey = 'en_attente_id';
    public $timestamps = false;

    protected $fillable = [
        'compte_id',
        'type_id',
        'duree',
        'heure_reservation',
        'salle_id',
        'employe_id',
        'preference_praticien',
        'commentaires',
        'created_at',
        'panier_id'
    ];

    public function compte()
    {
        return $this->belongsTo(UserModel::class, 'compte_id', 'compte_id');
    }

    public function typeMassage() 
    {
        return $this->belongsTo(TypeMassageModel::class, 'type_id', 'type_id')->select(['type_id', 'nom_type', 'description', 'prix']);
    }

    public function salle()
    {
        return $this->belongsTo(SalleModel::class, 'salle_id', 'salle_id');
    }

    public function employe()
    {
        return $this->belongsTo(EmployeModel::class, 'employe_id', 'employe_id');
    }

    public function panier()
    {
        return $this->belongsTo(PanierModel::class, 'panier_id');
    }

    public function reservation()
    {
        return $this->hasOne(ReservationsModel::class, 'en_attente_id', 'en_attente_id');
    }

    public function createFromCart($data) {
        return self::create($data);
    }
    
    public function getAllPendingReservations() {
        return self::orderBy('created_at', 'ASC')->get();
    }

    public function updatePendingReservation($panierId, $data) {
        // Vérifie si une entrée existe déjà pour ce panier
        $existing = self::where('panier_id', $panierId)->first();
        
        if ($existing) {
            // Met à jour l'entrée existante
            return $existing->update($data);
        } else {
            // Crée une nouvelle entrée si elle n'existe pas
            $data['panier_id'] = $panierId;
            return self::create($data);
        }
    }
}
