<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rescue extends Model
{
    protected $table = 'rescues';
    protected $primaryKey = 'id';

    public function province(){
    	return $this->belongsTo('App\Province');
    }
    public function municipality(){
    	return $this->belongsTo('App\CityMunicipality');
    }
}
