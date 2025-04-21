<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'comptes_utilisateurs';
    protected $primaryKey = 'compte_id';
    protected $fillable = ['nom_utilisateur', 'mot_de_passe', 'role', 'email'];
    public $timestamps = false;

    public function employe()
    {
        return $this->hasOne(EmployeModel::class, 'compte_id', 'compte_id');
    }

    public function reservations()
    {
        return $this->hasMany(ReservationsModel::class, 'compte_id', 'compte_id');
    }

    public function panier()
    {
        return $this->hasMany(PanierModel::class, 'compte_id', 'compte_id');
    }

    public function enAttente()
    {
        return $this->hasMany(EnAttenteModel::class, 'compte_id', 'compte_id');
    }
}
