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
        'horaire_travail',
        'compte_id'
    ];

    protected $dates = [
        'horaire_travail'
    ];

    public function compte()
    {
        return $this->belongsTo(UserModel::class, 'compte_id', 'compte_id');
    }

    public function reservations()
    {
        return $this->hasMany(ReservationsModel::class, 'employe_id', 'employe_id');
    }

    public static function findAll()
    {
        return self::all();
    }

    public function getWorkingHours()
    {
        return $this->selectRaw('employe.employe_id, compte.nom_utilisateur as nom,
            SUM(CASE WHEN MONTH(reservations.heure_reservation) = MONTH(CURRENT_DATE())
                THEN reservations.duree ELSE 0 END) as heures_mois,
            SUM(reservations.duree) as heures_total')
        ->join('comptes_utilisateurs as compte', 'compte.compte_id', '=', 'employe.compte_id')
        ->join('reservations', 'reservations.employe_id', '=', 'employe.employe_id')
        ->groupBy('employe.employe_id')
        ->get();
    }

    public function getTimeSlots($employeId)
    {
        return ReservationsModel::select('heure_reservation as date', 'duree')
            ->where('employe_id', $employeId)
            ->orderBy('heure_reservation', 'DESC')
            ->get()
            ->toArray();
    }

    public function getLeastBusyEmployee($date) {
        return $this->select('employe.employe_id')
            ->selectSum('reservations.duree', 'total_duree')
            ->join('reservations', 'reservations.employe_id = employe.employe_id')
            ->where('DATE(reservations.heure_reservation)', $date)
            ->groupBy('employe.employe_id')
            ->orderBy('total_duree', 'ASC')
            ->findAll();
    }
}
