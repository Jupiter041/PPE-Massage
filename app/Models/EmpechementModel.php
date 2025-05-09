<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpechementModel extends Model
{
    protected $table = 'empechements';
    protected $primaryKey = 'empechement_id';
    
    protected $fillable = [
        'employe_id',
        'motif',
        'created_at',
        'reservation_id'
    ];

    protected $dates = [
        'created_at'
    ];

    public function employe()
    {
        return $this->belongsTo(EmployeModel::class, 'employe_id', 'employe_id');
    }

    public function reservation()
    {
        return $this->belongsTo(ReservationsModel::class, 'reservation_id', 'reservation_id');
    }
}
