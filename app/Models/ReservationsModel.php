<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationsModel extends Model
{
    protected $table = 'reservations';
    protected $primaryKey = 'reservation_id';
    public $timestamps = false;

    protected $fillable = [
        'heure_reservation',
        'commentaires',
        'duree',
        'salle_id',
        'type_id',
        'employe_id',
        'compte_id',
        'preference_praticien'
    ];

    protected $dates = [
        'heure_reservation',
        'date_creation'
    ];

    public function salle()
    {
        return $this->belongsTo(SalleModel::class, 'salle_id', 'salle_id');
    }

    public function typeMassage() 
    {
        return $this->belongsTo(TypeMassageModel::class, 'type_id', 'type_id')->select(['type_id', 'nom_type', 'description', 'prix']);
    }

    public function employe()
    {
        return $this->belongsTo(EmployeModel::class, 'employe_id', 'employe_id');
    }
    public function compte()
    {
        return $this->belongsTo(UserModel::class, 'compte_id', 'compte_id');
    }
}