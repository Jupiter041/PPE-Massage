<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalleModel extends Model
{
    protected $table = 'Salle';
    protected $primaryKey = 'salle_id';
    public $timestamps = false;

    protected $fillable = [
        'nom_salle',
        'disponibilite'
    ];

    public function reservations()
    {
        return $this->hasMany(ReservationsModel::class, 'salle_id', 'salle_id');
    }
}
