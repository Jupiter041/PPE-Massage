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

    public function getSalleDisponible($dateTimeDebut, $dateTimeFin)
    {
        return self::with('reservations')
            ->whereDoesntHave('reservations', function($query) use ($dateTimeDebut, $dateTimeFin) {
                $query->where('heure_reservation', '<=', $dateTimeFin->format('Y-m-d H:i:s'))
                      ->where('heure_reservation', '>', $dateTimeDebut->format('Y-m-d H:i:s'));
            })
            ->withCount(['reservations as charge' => function($query) use ($dateTimeDebut) {
                $query->whereRaw('DATE(heure_reservation) = ?', [$dateTimeDebut->format('Y-m-d')]);
            }])
            ->orderBy('charge')
            ->first();
    }
}