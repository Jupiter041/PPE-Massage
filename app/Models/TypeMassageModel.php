<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeMassageModel extends Model
{
    protected $table = 'types_massages';
    protected $primaryKey = 'type_id';
    protected $fillable = ['nom_type', 'description', 'prix'];

}
