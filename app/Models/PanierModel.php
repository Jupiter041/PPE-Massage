<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanierModel extends Model
{
    protected $table = 'panier';
    protected $primaryKey = 'panier_id';
    protected $fillable = ['compte_id', 'type_massage_id', 'quantite', 'date_ajout'];
    public $timestamps = false;

    public function compte()
    {
        return $this->belongsTo(CompteUtilisateurModel::class, 'compte_id', 'compte_id');
    }

    public function typeMassage()
    {
        return $this->belongsTo(TypeMassageModel::class, 'type_massage_id', 'type_id');
    }

    public function insertData($data)
    {
        return $this->insert($data);
    }
}
