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

    public function findAllAsObjects()
    {
        return $this->all();
    }

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
        return $this->create($data);
    }
    
    public function getAllPendingReservations() {
        return $this->orderBy('created_at', 'ASC')->findAll();
    }
}