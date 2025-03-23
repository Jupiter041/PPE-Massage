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
        'commentaires'
    ];
}