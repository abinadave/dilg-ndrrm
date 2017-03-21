<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evacuation extends Model
{
    protected $table = 'evacuations';
    protected $primaryKey = 'id';

    public function province(){
    	return $this->belongsTo('App\Province');
    }
    public function municipality(){
    	return $this->belongsTo('App\CityMunicipality');
    }
}
