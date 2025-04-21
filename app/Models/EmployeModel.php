<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeModel extends Model
{
    protected $table = 'employe';
    protected $primaryKey = 'employe_id';
    public $timestamps = false;

    protected $fillable = [
        'type_employe',
        'compte_id'
    ];

    public function compte()
    {
        return $this->belongsTo(UserModel::class, 'compte_id', 'compte_id');
    }

    public function reservations()
    {
        return $this->hasMany(ReservationsModel::class, 'employe_id', 'employe_id');
    }

    public function enAttente()
    {
        return $this->hasMany(EnAttenteModel::class, 'employe_id', 'employe_id');
    }

    public static function findAll()
    {
        return self::all();
    }

    public static function getEmployeDisponible($dateDebut, $dateFin)
    {
        return self::whereDoesntHave('reservations', function($query) use ($dateDebut, $dateFin) {
            $query->where('heure_reservation', '<=', $dateFin->format('Y-m-d H:i:s'))
                  ->where('heure_reservation', '>', $dateDebut->format('Y-m-d H:i:s'));
        })
        ->withCount(['reservations' => function($query) use ($dateDebut) {
            $query->whereRaw('DATE(heure_reservation) = ?', [$dateDebut->format('Y-m-d')])
                  ->selectRaw('SUM(duree) as charge');
        }])
        ->orderBy('reservations_count')
        ->first();
    }
}