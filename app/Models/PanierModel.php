<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanierModel extends Model
{
    protected $table = 'panier';
    protected $primaryKey = 'panier_id';
    public $timestamps = false;

    protected $fillable = [
        'compte_id',
        'type_massage_id', 
        'quantite',
        'date_ajout'
    ];

    public function compte()
    {
        return $this->belongsTo(UserModel::class, 'compte_id', 'compte_id');
    }

    public function typeMassage() 
    {
        return $this->belongsTo(TypeMassageModel::class, 'type_massage_id', 'type_id');
    }

    public function getTotal()
    {
        return $this->typeMassage->prix * $this->quantite;
    }

    public function en_attente()
    {
        return $this->hasOne(EnAttenteModel::class, 'panier_id');
    }
}
