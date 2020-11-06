<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetOficinaE extends Model
{
    //
    protected $table = 'det_oficinae';
    protected $fillable = ['id','id_oficina','id_equipo'];
    public $timestamps = false;
}
