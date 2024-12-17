<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'telephone',
        'compte_id'
    ];

    public function compte()
    {
        return $this->belongsTo(UserModel::class, 'compte_id', 'compte_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'client_id', 'client_id');
    }

    public function panier()
    {
        return $this->hasMany(Panier::class, 'client_id', 'client_id');
    }
}
