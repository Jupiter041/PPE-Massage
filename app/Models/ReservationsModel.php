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
        'client_id'
    ];

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id', 'salle_id');
    }

    public function typeMassage()
    {
        return $this->belongsTo(TypesMassages::class, 'type_id', 'type_id');
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id', 'employe_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }
}
