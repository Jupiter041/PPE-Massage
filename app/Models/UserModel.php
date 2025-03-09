<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'comptes_utilisateurs';
    protected $primaryKey = 'compte_id';
    protected $fillable = ['nom_utilisateur', 'mot_de_passe', 'role', 'email'];
    public $timestamps = false;


}
