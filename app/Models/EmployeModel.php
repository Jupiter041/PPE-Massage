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
}
