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
        'preference_praticien',
        'compte_id'
    ];

    protected $dates = [
        'heure_reservation',
        'date_creation'
    ];

    protected $casts = [
        'duree' => 'integer',
        'salle_id' => 'integer',
        'type_id' => 'integer', 
        'employe_id' => 'integer',
        'compte_id' => 'integer'
    ];

    public function salle()
    {
        return $this->belongsTo(SalleModel::class, 'salle_id', 'salle_id');
    }

    public function typeMassage() 
    {
        return $this->belongsTo(TypeMassageModel::class, 'type_id', 'type_id');
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
